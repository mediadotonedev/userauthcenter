<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserAuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function userCheck(Request $request): JsonResponse
    {
        $apiKey = env('AUTH_CENTER_API_KEY');
        $apiUrl = env('AUTH_CENTER_API_URL');
        $apiUrl .= 'check';

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Accept' => 'application/json',
        ])->post($apiUrl, [
            'username' => $request->username,
        ]);

        if ($response->successful()) {
            return $response->json();
        }
        return $response->json();
    }


    public function userRegister(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiKey = env('AUTH_CENTER_API_KEY');
        $apiUrl = env('AUTH_CENTER_API_URL');
        $apiUrl .= 'register';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
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
        $apiKey = env('AUTH_CENTER_API_KEY');
        $apiUrl = env('AUTH_CENTER_API_URL');
        $apiUrl .= 'register/verify';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
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
        $apiKey = env('AUTH_CENTER_API_KEY');
        $apiUrl = env('AUTH_CENTER_API_URL');
        $apiUrl .= 'login/otp';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
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
        $apiKey = env('AUTH_CENTER_API_KEY');
        $apiUrl = env('AUTH_CENTER_API_URL');
        $apiUrl .= 'login/otp/verify';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
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
        $apiKey = env('AUTH_CENTER_API_KEY');
        $apiUrl = env('AUTH_CENTER_API_URL');
        $apiUrl .= 'login/password';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Accept' => 'application/json',
            ])->post($apiUrl,[
                'username'=> $data['username'],
                'password' => $data['password'],
            ]);
        if ($response->successful())
        {
                    // Generate token
            $token = $adminUser->createToken('auth_token')->plainTextToken;
            return $response->json();
        }
            return $response->json();
    }

}
