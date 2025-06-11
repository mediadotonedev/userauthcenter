<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserAuthService
{
    protected $baseUrl;
    protected $apiKey;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
        $this->baseUrl = env('AUTH_CENTER_API_URL');
        $this->apiKey = env('AUTH_CENTER_API_KEY');
    }

    public function userCheck(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->baseUrl . 'check';

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Accept' => 'application/json',
        ])->post($apiUrl, [
            'username' => $data['username'],
        ]);

        return response()->json($response->json(), $response->status());
    }


    public function userRegister(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->baseUrl . 'register';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
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
        return response()->json($response->json(), $response->status());
    }

    public function userRegisterVerify(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->baseUrl . 'register/verify';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Accept' => 'application/json',
            ])->post($apiUrl,[
                'username'=> $data['username'],
                'code' => $data['code'],
            ]);
        return response()->json($response->json(), $response->status());
    }

    public function userLoginOtp(Request $request): JsonResponse
    {
        $data = $request->validated();

        $apiUrl = $this->baseUrl . 'login/otp';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Accept' => 'application/json',
            ])->post($apiUrl,[
                'username'=> $data['username']
            ]);
        return response()->json($response->json(), $response->status());
    }

    public function userLoginOtpVerify(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->baseUrl . 'login/otp/verify';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Accept' => 'application/json',
            ])->post($apiUrl,[
                'username'=> $data['username'],
                'code' => $data['code'],
            ]);
        return response()->json($response->json(), $response->status());
    }

    public function userLogiByPassword($request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->baseUrl . 'login/password';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Accept' => 'application/json',
            ])->post($apiUrl,[
                'username'=> $data['username'],
                'password' => $data['password'],
            ]);
        return response()->json($response->json(), $response->status());
    }

}
