<?php

namespace App\Services;

use App\Models\Booking;
use App\Services\MpesaService;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $mpesaService;
    
    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }
    /**
     * Process payment for a booking
     */
    public function processPayment(Booking $booking, array $paymentData)
    {
        try {
            // Validate payment data
            $this->validatePaymentData($paymentData);
            
            // Process payment based on method
            $paymentResult = $this->processRealPayment($booking, $paymentData);
            
            if ($paymentResult['success']) {
                // Update booking with payment information
                $booking->update([
                    'payment_method' => $paymentData['payment_method'],
                    'status' => 'confirmed',
                    'confirmed_at' => now(),
                    'transaction_id' => $paymentResult['transaction_id'] ?? null,
                ]);
                
                Log::info('Payment processed successfully', [
                    'booking_id' => $booking->id,
                    'amount' => $booking->total_amount,
                    'payment_method' => $paymentData['payment_method'],
                    'transaction_id' => $paymentResult['transaction_id'] ?? null
                ]);
                
                return [
                    'success' => true,
                    'message' => 'Payment processed successfully',
                    'transaction_id' => $paymentResult['transaction_id'] ?? null
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $paymentResult['message']
                ];
            }
            
        } catch (\Exception $e) {
            Log::error('Payment processing failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Payment processing failed. Please try again.'
            ];
        }
    }
    
    /**
     * Process real payment based on method
     */
    private function processRealPayment(Booking $booking, array $paymentData)
    {
        switch ($paymentData['payment_method']) {
            case 'mpesa':
                return $this->processMpesaPayment($booking, $paymentData);
            case 'credit_card':
                return $this->processStripePayment($booking, $paymentData);
            case 'paypal':
                return $this->processPaypalPayment($booking, $paymentData);
            case 'bank_transfer':
                return $this->processBankTransfer($booking, $paymentData);
            case 'wallet_topup':
                return $this->processWalletTopup($booking, $paymentData);
            default:
                return [
                    'success' => false,
                    'message' => 'Payment method not supported'
                ];
        }
    }
    
    /**
     * Process M-Pesa payment
     */
    private function processMpesaPayment(Booking $booking, array $paymentData)
    {
        $phoneNumber = $paymentData['mpesa_phone'];
        $amount = $booking->total_amount;
        $accountReference = 'TWENDEE-' . $booking->booking_reference;
        
        // Validate phone number
        $validPhone = $this->mpesaService->validateMpesaPhone($phoneNumber);
        if (!$validPhone) {
            return [
                'success' => false,
                'message' => 'Invalid M-Pesa phone number. Please use a valid Kenyan number.'
            ];
        }
        
        // Use till number if available, otherwise use STK push
        if (env('MPESA_TILL_NUMBER')) {
            return $this->mpesaService->processTillPayment($validPhone, $amount, $accountReference);
        } else {
            return $this->mpesaService->initiateStkPush($validPhone, $amount, $accountReference);
        }
    }
    
    /**
     * Process Stripe payment (placeholder for future implementation)
     */
    private function processStripePayment(Booking $booking, array $paymentData)
    {
        // TODO: Implement real Stripe integration
        return $this->simulatePayment($booking, $paymentData);
    }
    
    /**
     * Process PayPal payment (placeholder for future implementation)
     */
    private function processPaypalPayment(Booking $booking, array $paymentData)
    {
        // TODO: Implement real PayPal integration
        return $this->simulatePayment($booking, $paymentData);
    }
    
    /**
     * Process bank transfer (placeholder)
     */
    private function processBankTransfer(Booking $booking, array $paymentData)
    {
        // TODO: Implement bank transfer processing
        return $this->simulatePayment($booking, $paymentData);
    }
    
    /**
     * Process wallet topup (placeholder)
     */
    private function processWalletTopup(Booking $booking, array $paymentData)
    {
        // TODO: Implement wallet system
        return $this->simulatePayment($booking, $paymentData);
    }
    
    /**
     * Validate payment data
     */
    private function validatePaymentData(array $paymentData)
    {
        $required = ['payment_method', 'amount'];
        
        foreach ($required as $field) {
            if (!isset($paymentData[$field])) {
                throw new \InvalidArgumentException("Missing required field: {$field}");
            }
        }
        
        if (!in_array($paymentData['payment_method'], ['credit_card', 'paypal', 'bank_transfer', 'wallet_topup', 'mpesa'])) {
            throw new \InvalidArgumentException('Invalid payment method');
        }
    }
    
    /**
     * Simulate payment processing
     * In a real implementation, this would call the actual payment gateway
     */
    private function simulatePayment(Booking $booking, array $paymentData)
    {
        // Simulate payment processing delay
        usleep(500000); // 0.5 seconds
        
        // Simulate different scenarios
        $scenarios = [
            'success' => 0.9, // 90% success rate
            'insufficient_funds' => 0.05, // 5% insufficient funds
            'card_declined' => 0.03, // 3% card declined
            'network_error' => 0.02, // 2% network error
        ];
        
        $random = mt_rand() / mt_getrandmax();
        $cumulative = 0;
        
        foreach ($scenarios as $scenario => $probability) {
            $cumulative += $probability;
            if ($random <= $cumulative) {
                return $this->handlePaymentScenario($scenario, $booking, $paymentData);
            }
        }
        
        // Default to success
        return $this->handlePaymentScenario('success', $booking, $paymentData);
    }
    
    /**
     * Handle different payment scenarios
     */
    private function handlePaymentScenario(string $scenario, Booking $booking, array $paymentData)
    {
        switch ($scenario) {
            case 'success':
                return [
                    'success' => true,
                    'transaction_id' => 'TXN_' . strtoupper(uniqid()),
                    'message' => 'Payment successful'
                ];
                
            case 'insufficient_funds':
                return [
                    'success' => false,
                    'message' => 'Insufficient funds. Please try a different payment method.'
                ];
                
            case 'card_declined':
                return [
                    'success' => false,
                    'message' => 'Card declined. Please contact your bank or try a different card.'
                ];
                
            case 'network_error':
                return [
                    'success' => false,
                    'message' => 'Network error. Please try again.'
                ];
                
            default:
                return [
                    'success' => false,
                    'message' => 'Payment failed. Please try again.'
                ];
        }
    }
    
    /**
     * Refund a payment
     */
    public function processRefund(Booking $booking, float $amount = null)
    {
        try {
            $refundAmount = $amount ?? $booking->total_amount;
            
            // Simulate refund processing
            $refundResult = $this->simulateRefund($booking, $refundAmount);
            
            if ($refundResult['success']) {
                Log::info('Refund processed successfully', [
                    'booking_id' => $booking->id,
                    'amount' => $refundAmount,
                    'refund_id' => $refundResult['refund_id']
                ]);
                
                return [
                    'success' => true,
                    'message' => 'Refund processed successfully',
                    'refund_id' => $refundResult['refund_id']
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $refundResult['message']
                ];
            }
            
        } catch (\Exception $e) {
            Log::error('Refund processing failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Refund processing failed. Please contact support.'
            ];
        }
    }
    
    /**
     * Simulate refund processing
     */
    private function simulateRefund(Booking $booking, float $amount)
    {
        // Simulate refund processing delay
        usleep(300000); // 0.3 seconds
        
        // Simulate 95% success rate for refunds
        if (mt_rand() / mt_getrandmax() < 0.95) {
            return [
                'success' => true,
                'refund_id' => 'REF_' . strtoupper(uniqid()),
                'message' => 'Refund successful'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Refund failed. Please contact support.'
            ];
        }
    }
    
    /**
     * Get payment methods available
     */
    public function getAvailablePaymentMethods()
    {
        return [
            'credit_card' => [
                'name' => 'Credit Card',
                'description' => 'Visa, MasterCard, American Express',
                'icon' => 'fas fa-credit-card',
                'enabled' => true
            ],
            'paypal' => [
                'name' => 'PayPal',
                'description' => 'Pay with your PayPal account',
                'icon' => 'fab fa-paypal',
                'enabled' => true
            ],
            'bank_transfer' => [
                'name' => 'Bank Transfer',
                'description' => 'Direct bank transfer',
                'icon' => 'fas fa-university',
                'enabled' => true
            ],
            'wallet_topup' => [
                'name' => 'Wallet Top-up',
                'description' => 'Add funds to your wallet',
                'icon' => 'fas fa-wallet',
                'enabled' => true
            ],
            'mpesa' => [
                'name' => 'M-Pesa',
                'description' => 'Pay with M-Pesa mobile money',
                'icon' => 'fas fa-mobile-alt',
                'enabled' => true
            ]
        ];
    }
    
    /**
     * Calculate processing fees
     */
    public function calculateProcessingFee(float $amount, string $paymentMethod)
    {
        $fees = [
            'credit_card' => 0.029, // 2.9%
            'paypal' => 0.034, // 3.4%
            'bank_transfer' => 0.0, // No fee
            'wallet_topup' => 0.0, // No fee for wallet top-up
            'mpesa' => 0.015, // 1.5% for M-Pesa
        ];
        
        $feeRate = $fees[$paymentMethod] ?? 0.029;
        $fee = $amount * $feeRate;
        
        // Minimum fee of $0.30
        return max($fee, 0.30);
    }
    
    /**
     * Calculate total amount including fees
     */
    public function calculateTotalWithFees(float $amount, string $paymentMethod)
    {
        $processingFee = $this->calculateProcessingFee($amount, $paymentMethod);
        return $amount + $processingFee;
    }
}
