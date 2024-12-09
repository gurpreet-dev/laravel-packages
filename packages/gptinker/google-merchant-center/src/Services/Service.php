<?php

namespace Gptinker\GoogleMerchant\Services;

use Illuminate\Support\Facades\Http;

class Service{

    public $merchant_id;
    public $credential_file_path;
    public $api_base_url;

    public function __construct()
    {
        $this->merchant_id = env('GOOGLE_MERCHANT_ID');
        $this->credential_file_path = storage_path('/json/opportune-baton-443711-e5-0b02c8d4c557.json');
        $this->api_base_url = "https://shoppingcontent.googleapis.com/content/v2.1";
    }

    public function init()
    {
        if(!$this->merchant_id){
            return throw new \Exception('Merchant ID is required!');
        }

        if(!file_exists($this->credential_file_path)){
            return throw new \Exception('Credential file required!');
        }

        $credentials = json_decode(file_get_contents($this->credential_file_path), true);

        if(empty($credentials)){
            return throw new \Exception('Invalid credentials!');
        }
    }

    public function apiUrl($extension = null){

        $merchantId = env('GOOGLE_MERCHANT_ID');
        
        $url = ["$this->api_base_url/$merchantId"];

        if($extension != null){
            array_push($url, ltrim($extension, '/'));
        }

        return implode('/', $url);
    }

    public function generateAccessToken()
    {

        try{

            $this->init();

            $jsonKeyFilePath = $this->credential_file_path;
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
                throw new \Exception('Failed to generate access token');
            }
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
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