<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserAuthService
{
    protected $apiKey;
    protected $apiUrl;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
        $this->apiKey = env('AUTH_CENTER_API_KEY');
        $this->apiUrl = env('AUTH_CENTER_API_URL');
    }

    public function userCheck(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->apiUrl . 'check';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Accept' => 'application/json',
        ])->post($apiUrl, [
            'username' => $data['username'],
        ]);

        if ($response->successful()) {
            return $response->json();
        }
        return $response->json();
    }


    public function userRegister(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->apiUrl . 'register';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$$this->apiKey}",
            'Accept' => 'application/json',
            ])->post($apiUrl,[
                'username' => $data['username'],
                'name' => $data['name'],
                'nickname' => $data['nickname'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'gender' => $data['gender'],
                'show_name' => $data['show_name']
            ]);
        if ($response->successful())
        {
            return $response->json();

        }
            return $response->json();
    }

    public function userRegisterVerify(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->apiUrl . 'register/verify';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Accept' => 'application/json',
            ])->post($apiUrl,[
                'username'=> $data['username'],
                'code' => $data['code'],
            ]);
        if ($response->successful())
        {
            return $response->json();
        }
            return $response->json();
    }

    public function userLoginOtp(Request $request): JsonResponse
    {
        $data = $request->validated();

        $apiUrl = $this->apiUrl . 'login/otp';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Accept' => 'application/json',
            ])->post($apiUrl,[
                'username'=> $data['username']
            ]);
        if ($response->successful())
        {
            return $response->json();
        }
            return $response->json();
    }

    public function userLoginOtpVerify(Request $request): JsonResponse
    {
        $data = $request->validated();

        $apiUrl = $this->apiUrl . 'login/otp/verify';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Accept' => 'application/json',
            ])->post($apiUrl,[
                'username'=> $data['username'],
                'code' => $data['code'],
            ]);
        if ($response->successful())
        {
            return $response->json();
        }
            return $response->json();
    }

    public function userLogiByPassword($request): JsonResponse
    {
        $data = $request->validated();

        $apiUrl = $this->apiUrl . 'login/password';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Accept' => 'application/json',
            ])->post($apiUrl,[
                'username'=> $data['username'],
                'password' => $data['password'],
            ]);
        if ($response->successful())
        {
                    // Generate token
            //$token = $adminUser->createToken('auth_token')->plainTextToken;
            return $response->json();
        }
            return $response->json();
    }

}
