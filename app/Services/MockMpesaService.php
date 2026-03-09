<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class MockMpesaService extends MpesaService
{
    /**
     * Override the STK Push method to simulate success
     */
    public function initiateStkPush($phoneNumber, $amount, $accountReference = null)
    {
        try {
            // Simulate processing time
            usleep(500000); // 0.5 second delay to simulate API call
            
            // Generate mock response
            $transactionId = 'MOCK' . date('YmdHis') . rand(1000, 9999);
            
            $mockResponse = [
                'ResponseCode' => '0',
                'ResponseDescription' => 'Success. Request accepted for processing',
                'MerchantRequestID' => 'MOCK-' . uniqid(),
                'CheckoutRequestID' => $transactionId,
                'ResultCode' => '0',
                'ResultDesc' => 'The service request is processed successfully.'
            ];

            Log::info('Mock M-Pesa STK Push initiated', [
                'phone' => $phoneNumber,
                'amount' => $amount,
                'transaction_id' => $transactionId,
                'mock_mode' => true
            ]);

            return [
                'success' => true,
                'data' => $mockResponse,
                'message' => 'M-Pesa payment initiated successfully (Mock Mode)',
                'transaction_id' => $transactionId
            ];

        } catch (\Exception $e) {
            Log::error('Mock M-Pesa STK Push failed', [
                'error' => $e->getMessage(),
                'phone' => $phoneNumber,
                'amount' => $amount
            ]);

            return [
                'success' => false,
                'message' => 'Mock M-Pesa payment failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Simulate payment callback (normally called by M-Pesa)
     */
    public function simulatePaymentCallback($transactionId, $phoneNumber, $amount)
    {
        Log::info('Simulating M-Pesa payment callback', [
            'transaction_id' => $transactionId,
            'phone' => $phoneNumber,
            'amount' => $amount,
            'status' => 'completed'
        ]);

        return [
            'ResultCode' => '0',
            'ResultDesc' => 'Payment completed successfully',
            'TransactionID' => $transactionId,
            'PhoneNumber' => $phoneNumber,
            'Amount' => $amount
        ];
    }
}
