<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class MpesaService
{
    private $consumerKey;
    private $consumerSecret;
    private $passkey;
    private $shortcode;
    private $tillNumber;
    private $baseUrl;
    private $callbackUrl;

    public function __construct()
    {
        $this->consumerKey = env('MPESA_CONSUMER_KEY');
        $this->consumerSecret = env('MPESA_CONSUMER_SECRET');
        $this->passkey = env('MPESA_PASSKEY');
        $this->shortcode = env('MPESA_SHORTCODE');
        $this->tillNumber = env('MPESA_TILL_NUMBER');
        $this->baseUrl = env('MPESA_ENVIRONMENT') === 'production' 
            ? 'https://api.safaricom.co.ke' 
            : 'https://sandbox.safaricom.co.ke';
        $this->callbackUrl = env('MPESA_CALLBACK_URL', route('payment.mpesa.callback'));
    }

    /**
     * Initiate STK Push payment
     */
    public function initiateStkPush($phoneNumber, $amount, $accountReference = null)
    {
        try {
            $timestamp = date('YmdHis');
            $password = base64_encode($this->consumerKey . $this->consumerSecret . $timestamp);
            
            $requestBody = [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $this->shortcode,
                'PartyB' => $phoneNumber,
                'PhoneNumber' => $phoneNumber,
                'CallBackURL' => $this->callbackUrl,
                'AccountReference' => $accountReference ?? 'TWENDEETICKETS',
                'TransactionDesc' => 'Payment for TwendeeTickets booking',
                'TransactionType' => 'CustomerPayBillOnline'
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->generateAccessToken()
            ])->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', $requestBody);

            $responseData = $response->json();

            Log::info('M-Pesa STK Push initiated', [
                'phone' => $phoneNumber,
                'amount' => $amount,
                'response' => $responseData
            ]);

            return [
                'success' => isset($responseData['ResponseCode']) && $responseData['ResponseCode'] == '0',
                'data' => $responseData,
                'message' => $this->getMpesaResponseMessage($responseData['ResponseCode'] ?? 'UNKNOWN')
            ];

        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push failed', [
                'error' => $e->getMessage(),
                'phone' => $phoneNumber,
                'amount' => $amount
            ]);

            return [
                'success' => false,
                'message' => 'M-Pesa payment initiation failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process payment to till number
     */
    public function processTillPayment($phoneNumber, $amount, $accountReference = null)
    {
        try {
            $timestamp = date('YmdHis');
            $password = base64_encode($this->consumerKey . $this->consumerSecret . $timestamp);
            
            $requestBody = [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerBuyGoodsOnline',
                'Amount' => $amount,
                'PartyA' => $phoneNumber,
                'PartyB' => $this->tillNumber,
                'PhoneNumber' => $phoneNumber,
                'CallBackURL' => $this->callbackUrl,
                'AccountReference' => $accountReference ?? 'TWENDEETICKETS',
                'TransactionDesc' => 'Payment for TwendeeTickets booking',
                'TransactionType' => 'CustomerBuyGoodsOnline'
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->generateAccessToken()
            ])->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', $requestBody);

            $responseData = $response->json();

            Log::info('M-Pesa Till payment initiated', [
                'phone' => $phoneNumber,
                'amount' => $amount,
                'till' => $this->tillNumber,
                'response' => $responseData
            ]);

            return [
                'success' => isset($responseData['ResponseCode']) && $responseData['ResponseCode'] == '0',
                'data' => $responseData,
                'message' => $this->getMpesaResponseMessage($responseData['ResponseCode'] ?? 'UNKNOWN')
            ];

        } catch (\Exception $e) {
            Log::error('M-Pesa Till payment failed', [
                'error' => $e->getMessage(),
                'phone' => $phoneNumber,
                'amount' => $amount,
                'till' => $this->tillNumber
            ]);

            return [
                'success' => false,
                'message' => 'M-Pesa payment initiation failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Generate OAuth access token
     */
    private function generateAccessToken()
    {
        $cacheKey = 'mpesa_access_token';
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $credentials
            ])->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');

            $data = $response->json();
            
            if (isset($data['access_token'])) {
                Cache::put($cacheKey, $data['access_token'], now()->addMinutes(55));
                return $data['access_token'];
            }

            throw new \Exception('Failed to generate M-Pesa access token');

        } catch (\Exception $e) {
            Log::error('M-Pesa token generation failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get M-Pesa response message
     */
    private function getMpesaResponseMessage($responseCode)
    {
        $messages = [
            '0' => 'Success - Request accepted for processing',
            '1' => 'Insufficient funds',
            '2' => 'Less than minimum transaction value',
            '3' => 'More than maximum transaction value',
            '4' => 'Could not find subscriber',
            '5' => 'Could not find transaction',
            '6' => 'Transaction was not successful',
            '7' => 'DNS resolution failed',
            '8' => 'Service not available',
            '9' => 'Service timeout',
            '10' => 'Duplicate transaction',
            '11' => 'Transaction not found',
            '12' => 'Transaction was not successful',
            '13' => 'Transaction was reversed',
            '14' => 'Failed transaction',
            '15' => 'Transaction timed out',
            '17' => 'Invalid security credential',
            '18' => 'Account not found',
            '19' => 'Account not active',
            '20' => 'Account not validated for transaction',
            '25' => 'Quota exceeded',
            '26' => 'Transaction is from untrusted source',
            '27' => 'Transaction not permitted',
            '28' => 'Transaction is not permitted',
            '29' => 'Transaction is not permitted',
            '30' => 'Transaction is not permitted',
            '31' => 'Transaction is not permitted',
            '32' => 'Transaction is not permitted',
            '33' => 'Transaction is not permitted',
            '34' => 'Transaction is not permitted',
            '35' => 'Transaction is not permitted',
            '36' => 'Transaction is not permitted',
            '37' => 'Transaction is not permitted',
            '38' => 'Transaction is not permitted',
            '39' => 'Transaction is not permitted',
            '40' => 'Transaction is not permitted',
            '41' => 'Transaction is not permitted',
            '42' => 'Transaction is not permitted',
            '43' => 'Transaction is not permitted',
            '44' => 'Transaction is not permitted',
            '45' => 'Transaction is not permitted',
            '46' => 'Transaction is not permitted',
            '47' => 'Transaction is not permitted',
            '48' => 'Transaction is not permitted',
            '49' => 'Transaction is not permitted',
            '50' => 'Transaction is not permitted',
            '51' => 'Transaction is not permitted',
            '52' => 'Transaction is not permitted',
            '53' => 'Transaction is not permitted',
            '54' => 'Transaction is not permitted',
            '55' => 'Transaction is not permitted',
            '56' => 'Transaction is not permitted',
            '57' => 'Transaction is not permitted',
            '58' => 'Transaction is not permitted',
            '59' => 'Transaction is not permitted',
            '60' => 'Transaction is not permitted',
            '61' => 'Transaction is not permitted',
            '62' => 'Transaction is not permitted',
            '63' => 'Transaction is not permitted',
            '64' => 'Transaction is not permitted',
            '65' => 'Transaction is not permitted',
            '66' => 'Transaction is not permitted',
            '67' => 'Transaction is not permitted',
            '68' => 'Transaction is not permitted',
            '69' => 'Transaction is not permitted',
            '70' => 'Transaction is not permitted',
            '71' => 'Transaction is not permitted',
            '72' => 'Transaction is not permitted',
            '73' => 'Transaction is not permitted',
            '74' => 'Transaction is not permitted',
            '75' => 'Transaction is not permitted',
            '76' => 'Transaction is not permitted',
            '77' => 'Transaction is not permitted',
            '78' => 'Transaction is not permitted',
            '79' => 'Transaction is not permitted',
            '80' => 'Transaction is not permitted',
            '81' => 'Transaction is not permitted',
            '82' => 'Transaction is not permitted',
            '83' => 'Transaction is not permitted',
            '84' => 'Transaction is not permitted',
            '85' => 'Transaction is not permitted',
            '86' => 'Transaction is not permitted',
            '87' => 'Transaction is not permitted',
            '88' => 'Transaction is not permitted',
            '89' => 'Transaction is not permitted',
            '90' => 'Transaction is not permitted',
            '91' => 'Transaction is not permitted',
            '92' => 'Payment method not supported',
            '93' => 'Payment method not supported',
            '94' => 'Payment method not supported',
            '95' => 'Payment method not supported',
            '96' => 'Payment method not supported',
            '97' => 'Payment method not supported',
            '98' => 'Payment method not supported',
            '99' => 'Payment method not supported',
            '100' => 'Payment method not supported',
            '101' => 'Request rejected',
            '102' => 'Request cancelled by user',
            '103' => 'Entry invalid or duplicate',
            '185' => 'Security credential not valid',
            '200' => 'Success',
            '201' => 'Invalid Access Token',
            '202' => 'Invalid Access Token',
            '203' => 'Invalid Access Token',
            '204' => 'Invalid security credential',
            '400' => 'Bad Request - Invalid parameters',
            '401' => 'Unauthorized - Invalid credentials',
            '403' => 'Forbidden',
            '404' => 'Not Found',
            '405' => 'Method Not Allowed',
            '406' => 'Proxy Authentication Required',
            '408' => 'Request Timeout',
            '409' => 'Conflict',
            '500' => 'Internal Server Error',
            '502' => 'Bad Gateway',
            '503' => 'Service Unavailable',
            '504' => 'Gateway Timeout'
        ];

        return $messages[$responseCode] ?? 'Unknown error occurred';
    }

    /**
     * Validate M-Pesa phone number
     */
    public function validateMpesaPhone($phoneNumber)
    {
        // Remove any non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Validate Kenyan phone number format
        if (strlen($phone) === 9 && substr($phone, 0, 1) === '7') {
            return '254' . $phone; // Add country code
        }
        
        if (strlen($phone) === 12 && substr($phone, 0, 3) === '254') {
            return $phone; // Already has country code
        }
        
        if (strlen($phone) === 10 && substr($phone, 0, 3) === '254') {
            return $phone; // Full format
        }
        
        return false;
    }

    /**
     * Format phone number for display
     */
    public function formatPhoneNumber($phoneNumber)
    {
        $phone = $this->validateMpesaPhone($phoneNumber);
        if (!$phone) {
            return $phoneNumber;
        }
        
        if (strlen($phone) === 12) {
            return '+' . substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . ' ' . substr($phone, 6);
        }
        
        return $phone;
    }
}
