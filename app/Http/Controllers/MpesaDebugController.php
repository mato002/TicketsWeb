<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\MpesaService;

class MpesaDebugController extends Controller
{
    public function index()
    {
        return view('debug.mpesa');
    }
    
    public function test(Request $request)
    {
        try {
            $mpesaService = app(MpesaService::class);
            
            // Test data
            $phoneNumber = $request->phone ?? '254712345678';
            $amount = $request->amount ?? 1;
            
            Log::info('M-Pesa Debug Test Started', [
                'phone' => $phoneNumber,
                'amount' => $amount,
                'timestamp' => now()
            ]);
            
            // Test 1: Check configuration
            $config = [
                'consumer_key' => config('services.mpesa.consumer_key') ? 'set' : 'missing',
                'consumer_secret' => config('services.mpesa.consumer_secret') ? 'set' : 'missing',
                'passkey' => config('services.mpesa.passkey') ? 'set' : 'missing',
                'shortcode' => config('services.mpesa.shortcode') ? config('services.mpesa.shortcode') : 'missing',
                'till_number' => config('services.mpesa.till_number') ? config('services.mpesa.till_number') : 'missing',
                'environment' => config('services.mpesa.environment') ? config('services.mpesa.environment') : 'missing',
                'base_url' => config('services.mpesa.environment') === 'production' 
                    ? 'https://api.safaricom.co.ke' 
                    : 'https://sandbox.safaricom.co.ke'
            ];
            
            // Test 2: Generate access token
            try {
                $token = $mpesaService->generateAccessToken();
                $config['access_token'] = $token ? 'generated' : 'failed';
            } catch (\Exception $e) {
                $config['access_token'] = 'failed: ' . $e->getMessage();
            }
            
            // Test 3: Validate phone number
            $formattedPhone = $mpesaService->validateMpesaPhone($phoneNumber);
            $config['phone_validation'] = [
                'original' => $phoneNumber,
                'formatted' => $formattedPhone,
                'valid' => $formattedPhone ? true : false
            ];
            
            // Test 4: STK Push
            try {
                $stkResult = $mpesaService->initiateStkPush($formattedPhone, $amount, 'TEST-REF');
                $config['stk_push'] = [
                    'success' => $stkResult['success'] ?? false,
                    'message' => $stkResult['message'] ?? 'No message',
                    'data' => $stkResult['data'] ?? []
                ];
            } catch (\Exception $e) {
                $config['stk_push'] = [
                    'success' => false,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ];
            }
            
            Log::info('M-Pesa Debug Test Results', [
                'config' => $config,
                'timestamp' => now()
            ]);
            
            return response()->json([
                'success' => true,
                'data' => $config,
                'timestamp' => now()->toISOString()
            ]);
            
        } catch (\Exception $e) {
            Log::error('M-Pesa Debug Controller Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 500);
        }
    }
}
