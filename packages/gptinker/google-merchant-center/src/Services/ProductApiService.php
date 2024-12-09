<?php

namespace Gptinker\GoogleMerchant\Services;

use Illuminate\Support\Facades\Http;

class ProductApiService extends Service{

    public function fetch()
    {
        try {
            $accessToken = $this->generateAccessToken();
    
            $response = Http::withToken($accessToken)
                ->get($this->apiUrl('products'));
    
            if ($response->successful()) {
                return $this->successResponse($response->json(), 'Product fetched!');
            } else {
                return $this->errorResponse($response->json()['error']['message']);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function insert($product_data)
    {
        $other_product_data = [
            'channel' => env("GOOGLE_MERCHANT_CHANNEL", "online"),
            'contentLanguage' => env("GOOGLE_MERCHANT_CONTENT_LANGUAGE", "en"),
            'targetCountry' => env("GOOGLE_MERCHANT_TARGET_COUNTRY", "AE"),
        ];

        $product_data = array_merge($product_data, $other_product_data);

        try {
            $accessToken = $this->generateAccessToken();
    
            $response = Http::withToken($accessToken)
                ->post($this->apiUrl('products'), $product_data);
    
            if ($response->successful()) {
                return $this->successResponse($response->json(), 'Product created!');
            } else {
                return $this->errorResponse($response->json()['error']['message']);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update($product_data, $product_id)
    {
        $other_product_data = [
            'channel' => env("GOOGLE_MERCHANT_CHANNEL", "online"),
            'contentLanguage' => env("GOOGLE_MERCHANT_CONTENT_LANGUAGE", "en"),
            'targetCountry' => env("GOOGLE_MERCHANT_TARGET_COUNTRY", "AE"),
            'product_id' => $product_id
        ];

        $product_id = implode(':', $other_product_data);

        try {
            $accessToken = $this->generateAccessToken();
    
            $response = Http::withToken($accessToken)
                ->patch($this->apiUrl("products/$product_id"), $product_data);
    
            if ($response->successful()) {
                return $this->successResponse($response->json(), 'Product updated!');
            } else {
                return $this->errorResponse($response->json()['error']['message']);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete($product_id)
    {
        $other_product_data = [
            'channel' => env("GOOGLE_MERCHANT_CHANNEL", "online"),
            'contentLanguage' => env("GOOGLE_MERCHANT_CONTENT_LANGUAGE", "en"),
            'targetCountry' => env("GOOGLE_MERCHANT_TARGET_COUNTRY", "AE"),
            'product_id' => $product_id
        ];

        $product_id = implode(':', $other_product_data);

        try {
            $accessToken = $this->generateAccessToken();
    
            $response = Http::withToken($accessToken)
                ->delete($this->apiUrl("products/$product_id"));
    
            if ($response->successful()) {
                return $this->successResponse($response->json(), 'Product deleted!');
            } else {
                return $this->errorResponse($response->json()['error']['message']);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}