<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\PaymentService;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paymentService;
    
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    
    /**
     * Show payment form
     */
    public function show(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return redirect()->route('public.home')
                ->with('error', 'This booking cannot be paid for.');
        }
        
        $booking->load(['user', 'items.bookable']);
        $paymentMethods = $this->paymentService->getAvailablePaymentMethods();
        
        return view('public.payment.show', compact('booking', 'paymentMethods'));
    }
    
    /**
     * Process payment
     */
    public function process(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer,wallet_topup,mpesa',
            'card_number' => 'required_if:payment_method,credit_card|string',
            'card_expiry' => 'required_if:payment_method,credit_card|string',
            'card_cvv' => 'required_if:payment_method,credit_card|string',
            'cardholder_name' => 'required_if:payment_method,credit_card|string',
            'topup_amount' => 'required_if:payment_method,wallet_topup|string',
            'custom_amount' => 'required_if:topup_amount,custom|numeric|min:10|max:1000',
            'mpesa_phone' => 'required_if:payment_method,mpesa|string|min:10|max:15',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string',
            'billing_state' => 'required|string',
            'billing_zip' => 'required|string',
            'billing_country' => 'required|string',
            'terms_accepted' => 'required|accepted',
        ]);
        
        if ($booking->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This booking cannot be paid for.'
            ], 400);
        }
        
        // Prepare payment data
        $paymentData = [
            'payment_method' => $request->payment_method,
            'amount' => $booking->total_amount,
            'card_number' => $request->card_number ?? null,
            'card_expiry' => $request->card_expiry ?? null,
            'card_cvv' => $request->card_cvv ?? null,
            'cardholder_name' => $request->cardholder_name ?? null,
            'billing_address' => $request->billing_address,
            'billing_city' => $request->billing_city,
            'billing_state' => $request->billing_state,
            'billing_zip' => $request->billing_zip,
            'billing_country' => $request->billing_country,
        ];
        
        DB::beginTransaction();
        
        try {
            // Process payment
            $result = $this->paymentService->processPayment($booking, $paymentData);
            
            if ($result['success']) {
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'redirect_url' => route('public.booking.confirmation', $booking)
                ]);
            } else {
                DB::rollback();
                
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 400);
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed. Please try again.'
            ], 500);
        }
    }
    
    /**
     * Handle M-Pesa callback
     */
    public function mpesaCallback(Request $request)
    {
        try {
            $callbackData = $request->all();
            
            Log::info('M-Pesa callback received', [
                'data' => $callbackData
            ]);
            
            // Extract transaction details
            $resultCode = $callbackData['Body']['stkCallback']['ResultCode'] ?? null;
            $transactionId = $callbackData['Body']['stkCallback']['MerchantRequestID'] ?? null;
            $mpesaReceipt = $callbackData['Body']['stkCallback']['CallbackMetadata']['MpesaReceiptNumber'] ?? null;
            
            if ($resultCode == '0') {
                // Payment successful - find and update booking
                $booking = Booking::where('transaction_id', $transactionId)->first();
                
                if ($booking) {
                    $booking->update([
                        'status' => 'confirmed',
                        'confirmed_at' => now(),
                        'mpesa_receipt' => $mpesaReceipt,
                        'payment_details' => json_encode($callbackData)
                    ]);
                    
                    Log::info('M-Pesa payment confirmed', [
                        'booking_id' => $booking->id,
                        'transaction_id' => $transactionId,
                        'mpesa_receipt' => $mpesaReceipt
                    ]);
                }
            } else {
                // Payment failed
                $booking = Booking::where('transaction_id', $transactionId)->first();
                
                if ($booking) {
                    $booking->update([
                        'status' => 'failed',
                        'failed_reason' => $this->getMpesaErrorMessage($resultCode),
                        'payment_details' => json_encode($callbackData)
                    ]);
                }
                
                Log::error('M-Pesa payment failed', [
                    'transaction_id' => $transactionId,
                    'result_code' => $resultCode,
                    'error_message' => $this->getMpesaErrorMessage($resultCode)
                ]);
            }
            
            return response()->json(['ResultCode' => 0]);
            
        } catch (\Exception $e) {
            Log::error('M-Pesa callback error', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            return response()->json(['ResultCode' => 1]);
        }
    }
    
    /**
     * Get M-Pesa error message
     */
    private function getMpesaErrorMessage($resultCode)
    {
        $errors = [
            '1' => 'Insufficient funds',
            '2' => 'Less than minimum transaction value',
            '3' => 'More than maximum transaction value',
            '4' => 'Could not find subscriber',
            '5' => 'Could not find transaction',
            '6' => 'Transaction was not successful',
            '1032' => 'Request cancelled by user',
            '1037' => 'Timeout in processing transaction',
            '2001' => 'Invalid initialization request',
            '2002' => 'Invalid initialization request'
        ];
        
        return $errors[$resultCode] ?? 'Unknown error occurred';
    }
    
    /**
     * Calculate processing fees
     */
    public function calculateFees(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer'
        ]);
        
        $amount = $request->amount;
        $paymentMethod = $request->payment_method;
        
        $processingFee = $this->paymentService->calculateProcessingFee($amount, $paymentMethod);
        $totalAmount = $this->paymentService->calculateTotalWithFees($amount, $paymentMethod);
        
        return response()->json([
            'amount' => $amount,
            'processing_fee' => $processingFee,
            'total_amount' => $totalAmount,
            'payment_method' => $paymentMethod
        ]);
    }
    
    /**
     * Process refund (Admin only)
     */
    public function refund(Request $request, Booking $booking)
    {
        $request->validate([
            'amount' => 'nullable|numeric|min:0.01|max:' . $booking->total_amount,
            'reason' => 'required|string|max:500'
        ]);
        
        if (!in_array($booking->status, ['confirmed', 'completed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only confirmed or completed bookings can be refunded.'
            ], 400);
        }
        
        $refundAmount = $request->amount ?? $booking->total_amount;
        
        DB::beginTransaction();
        
        try {
            // Process refund
            $result = $this->paymentService->processRefund($booking, $refundAmount);
            
            if ($result['success']) {
                // Update booking status
                $booking->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now()
                ]);
                
                // Return tickets to available pool
                foreach ($booking->items as $item) {
                    if ($item->bookable_type === \App\Models\Concert::class) {
                        $concert = $item->bookable;
                        $concert->increment('available_tickets', $item->quantity);
                    }
                }
                
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'refund_id' => $result['refund_id']
                ]);
            } else {
                DB::rollback();
                
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 400);
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Refund processing failed. Please try again.'
            ], 500);
        }
    }
}
