<?php

namespace App\Services;

use Shaz3e\PeachPayment\Helpers\PeachPayment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PeachPaymentService extends PeachPayment
{
    public static function createCheckout($amount, $return_url = null, $order_number = null)
    {
        $checkout_url = config('peach-payment.' . config('peach-payment.environment') . '.checkout_url').'/v2/checkout';

        $domain = config('peach-payment.domain');
        
        if (!preg_match('/^https?:\/\//', $domain)) {
            throw new \Exception('Invalid domain format');
        }

        $token = self::getToken();
        $headers = [
            'Accept: application/json',
            'Referer: '. $domain,
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
        ];

        $nonce = 'UNQ-' . time();

        $entity_id = config('peach-payment.entity_id');
        $currency = config('peach-payment.currency');
        $order_number = $order_number ?: 'OrderNo' . time(); // Use provided order_number or generate a new one
        
        // Construct valid URL
        $shopperResultUrl = $domain.$return_url.'/?peachpaymentOrder='.$order_number.'&amount='.$amount;

        if (!filter_var($shopperResultUrl, FILTER_VALIDATE_URL)) {
            throw new \Exception('Invalid shopperResultUrl: ' . $shopperResultUrl);
        }

        $data = [
            'currency' => $currency,
            'forceDefaultMethod' => false,
            'authentication.entityId' => $entity_id,
            'merchantTransactionId' => $order_number,
            'amount' => $amount, // Ensure amount is a valid number
            'nonce' => $nonce,
            'shopperResultUrl' => $shopperResultUrl, // Valid shopper result URL
            'defaultPaymentMethod' => 'CARD',
            'paymentType' => 'DB',
        ];

        // Execute the request using cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $checkout_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Remove in production
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Remove in production
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        
        curl_close($ch);
        
        $responseData = json_decode($result, true);
        if (isset($responseData['checkoutId'])) {
            $checkoutId = $responseData['checkoutId'];
        } else {
            Log::error('Peach Payment Response Error: checkoutId not found', ['response' => $responseData]);
            throw new \Exception('checkoutId not found in the response');
        }

        return [
            'checkoutId' => $checkoutId, 
            'order_number' => $order_number
        ];
    }

    /**
     * Get token
     */
    private static function getToken()
    {
        $api_url = config('peach-payment.' . config('peach-payment.environment') . '.authentication_url');
        $tokenEndpoint = $api_url.'/api/oauth/token';

        $client_id = config('peach-payment.client_id');
        $client_secret = config('peach-payment.client_secret');
        $merchant_id = config('peach-payment.merchant_id');
        
        // $response = Http::post($tokenEndpoint, [ // Production
        try {
        $response = Http::withoutVerifying()->post($tokenEndpoint, [ // Development
            'clientId' => $client_id,
            'clientSecret' => $client_secret,
            'merchantId' => $merchant_id,
        
        ]);

        Log::info('Peach Payment Token Response: ' . $response->body());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new \Exception('Error getting access token');
            return null;
        }

        // Check for request success
        if ($response->successful()) {
            $accessToken = $response->json('access_token');

            // Use the access token as needed
            return $accessToken;
        } else {
            // Handle request failure
            throw new \Exception('Error getting access token');
        }
    }
}
