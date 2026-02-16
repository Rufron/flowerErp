<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected $consumerKey;
    protected $consumerSecret;
    protected $shortCode;
    protected $passkey;
    protected $environment;
    protected $callbackUrl;

    public function __construct()
    {
        $this->consumerKey = config('mpesa.consumer_key');
        $this->consumerSecret = config('mpesa.consumer_secret');
        $this->shortCode = config('mpesa.shortcode');
        $this->passkey = config('mpesa.passkey');
        $this->environment = config('mpesa.environment');
        $this->callbackUrl = config('mpesa.callback_url');
    }

    /**
     * Get OAuth Token
     */
    protected function getToken()
    {
        $url = $this->environment === 'sandbox' 
            ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->get($url);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        Log::error('Failed to get M-PESA token', ['response' => $response->body()]);
        return null;
    }

    /**
     * Initiate STK Push
     */
    public function stkPush($phone, $amount, $reference, $description)
    {
        $token = $this->getToken();
        
        if (!$token) {
            return [
                'success' => false,
                'message' => 'Failed to get access token'
            ];
        }

        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortCode . $this->passkey . $timestamp);

        $url = $this->environment === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
            : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        // Format phone number (remove 0 or +254, ensure 254 format)
        $phone = $this->formatPhoneNumber($phone);

        $response = Http::withToken($token)
            ->post($url, [
                'BusinessShortCode' => $this->shortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => (int) $amount,
                'PartyA' => $phone,
                'PartyB' => $this->shortCode,
                'PhoneNumber' => $phone,
                'CallBackURL' => $this->callbackUrl,
                'AccountReference' => $reference,
                'TransactionDesc' => $description
            ]);

        if ($response->successful()) {
            $result = $response->json();
            
            if (isset($result['ResponseCode']) && $result['ResponseCode'] == '0') {
                return [
                    'success' => true,
                    'message' => 'STK Push sent successfully',
                    'data' => $result
                ];
            }
        }

        Log::error('STK Push failed', ['response' => $response->body()]);
        
        return [
            'success' => false,
            'message' => 'Failed to initiate STK Push',
            'data' => $response->json()
        ];
    }

    /**
     * Format phone number to 254XXXXXXXXX
     */
    protected function formatPhoneNumber($phone)
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If starts with 0, replace with 254
        if (substr($phone, 0, 1) == '0') {
            $phone = '254' . substr($phone, 1);
        }
        
        // If starts with 7, add 254
        if (substr($phone, 0, 1) == '7') {
            $phone = '254' . $phone;
        }
        
        // If starts with 254 and length is 12, return
        if (substr($phone, 0, 3) == '254' && strlen($phone) == 12) {
            return $phone;
        }
        
        return $phone;
    }
}