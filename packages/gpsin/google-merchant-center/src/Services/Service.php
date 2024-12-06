<?php

namespace Gpsin\GoogleMerchant\Services;

use Illuminate\Support\Facades\Http;

class Service{

    public function apiUrl($extension = null){

        $merchantId = env('GOOGLE_MERCHANT_ID');
        
        $url = ["https://shoppingcontent.googleapis.com/content/v2.1/$merchantId"];

        if($extension != null){
            array_push($url, ltrim($extension, '/'));
        }

        return implode('/', $url);
    }

    public function generateAccessToken()
    {
        $jsonKeyFilePath = storage_path('/json/opportune-baton-443711-e5-0b02c8d4c557.json'); // Path to your JSON key file
        $credentials = json_decode(file_get_contents($jsonKeyFilePath), true);
    
        $tokenUrl = 'https://oauth2.googleapis.com/token';
    
        // Create JWT
        $now = time();
        $jwtHeader = base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $jwtClaim = base64_encode(json_encode([
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/content',
            'aud' => $tokenUrl,
            'exp' => $now + 3600,
            'iat' => $now,
        ]));
    
        // Sign the JWT
        $privateKey = $credentials['private_key'];
        $signature = '';
        openssl_sign("$jwtHeader.$jwtClaim", $signature, $privateKey, 'SHA256');
        $signedJwt = "$jwtHeader.$jwtClaim." . base64_encode($signature);
    
        // Make the HTTP POST request
        $response = Http::asForm()->post($tokenUrl, [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $signedJwt,
        ]);
    
        if ($response->successful()) {
            return $response->json()['access_token'];
        } else {
            throw new \Exception('Failed to generate access token: ' . $response->body());
        }
    }

    public function successResponse($data, $message = null) {
		return [
			'status' => 'success',
			'message' => $message,
			'data' => $data,
		];
	}

	public function errorResponse($message, $data = null) {
		return [
			'status' => 'error',
			'message' => $message,
			'data' => $data,
		];
	}
}