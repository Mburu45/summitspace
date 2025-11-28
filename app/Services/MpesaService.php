<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected $consumerKey;
    protected $consumerSecret;
    protected $shortcode;
    protected $passkey;
    protected $callbackUrl;
    protected $stkPushUrl;
    protected $tokenUrl;
    protected $environment;

    public function __construct()
    {
        $this->consumerKey = config('services.mpesa.consumer_key');
        $this->consumerSecret = config('services.mpesa.consumer_secret');
        $this->shortcode = config('services.mpesa.shortcode');
        $this->passkey = config('services.mpesa.passkey');
        $this->callbackUrl = config('services.mpesa.callback_url');
        $this->stkPushUrl = config('services.mpesa.stk_push_url');
        $this->tokenUrl = config('services.mpesa.token_url');
        $this->environment = config('services.mpesa.environment', 'sandbox');
    }

    /**
     * Get M-Pesa access token
     */
    public function getAccessToken()
    {
        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->get($this->tokenUrl);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        Log::error('M-Pesa Token Error: ' . $response->body());
        return null;
    }

    /**
     * Initiate STK Push
     */
    public function stkPush($phone, $amount, $accountReference, $transactionDesc = 'Event Booking Payment')
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return ['success' => false, 'message' => 'Failed to get access token'];
        }

        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => $this->callbackUrl,
            'AccountReference' => $accountReference,
            'TransactionDesc' => $transactionDesc,
        ];

        $response = Http::withToken($accessToken)
            ->post($this->stkPushUrl, $payload);

        if ($response->successful()) {
            $data = $response->json();
            Log::info('M-Pesa STK Push Response: ', $data);

            return [
                'success' => true,
                'checkout_request_id' => $data['CheckoutRequestID'] ?? null,
                'response_code' => $data['ResponseCode'] ?? null,
                'response_description' => $data['ResponseDescription'] ?? null,
                'customer_message' => $data['CustomerMessage'] ?? null,
            ];
        }

        Log::error('M-Pesa STK Push Error: ' . $response->body());
        return [
            'success' => false,
            'message' => 'Failed to initiate payment',
            'error' => $response->body()
        ];
    }

    /**
     * Handle M-Pesa callback
     */
    public function handleCallback($callbackData)
    {
        Log::info('M-Pesa Callback Received: ', $callbackData);

        try {
            if (isset($callbackData['Body']['stkCallback'])) {
                $callback = $callbackData['Body']['stkCallback'];
                $checkoutRequestId = $callback['CheckoutRequestID'];
                $resultCode = $callback['ResultCode'];
                $resultDesc = $callback['ResultDesc'];

                // Find booking by checkout request ID
                $booking = \App\Models\Booking::where('mpesa_receipt_number', $checkoutRequestId)->first();

                if ($booking) {
                    if ($resultCode == 0) {
                        // Payment successful
                        $booking->update([
                            'payment_status' => 'paid',
                            'status' => 'approved',
                            'transaction_status' => 'completed',
                        ]);

                        // Store callback data
                        $booking->update([
                            'raw_callback' => json_encode($callbackData)
                        ]);

                        Log::info('Payment successful for booking: ' . $booking->id);
                    } else {
                        // Payment failed
                        $booking->update([
                            'payment_status' => 'failed',
                            'transaction_status' => 'failed',
                            'raw_callback' => json_encode($callbackData)
                        ]);

                        Log::warning('Payment failed for booking: ' . $booking->id . ' - ' . $resultDesc);
                    }
                } else {
                    Log::error('Booking not found for CheckoutRequestID: ' . $checkoutRequestId);
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('M-Pesa Callback Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}