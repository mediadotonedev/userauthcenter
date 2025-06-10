<?php

namespace Mediadotonedev\UserAuthCenter\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mediadotonedev\UserAuthCenter\Models\User;

class UserAuthService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('userauthcenter.api.key');
        $this->apiUrl = config('userauthcenter.api.url');
    }

    public function userCheck(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->apiUrl . 'check';
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
            ])->post($apiUrl, [
                'username' => $data['username'],
            ]);

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to connect to authentication service'], 503);
        }
    }

    public function userRegister(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->apiUrl . 'register';
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
            ])->post($apiUrl, [
                'username' => $data['username'],
                'name' => $data['name'],
                'nickname' => $data['nickname'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'gender' => $data['gender'],
                'show_name' => $data['show_name'],
            ]);

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to connect to authentication service'], 503);
        }
    }

    public function userRegisterVerify(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->apiUrl . 'register/verify';
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
            ])->post($apiUrl, [
                'username' => $data['username'],
                'code' => $data['code'],
            ]);

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to connect to authentication service'], 503);
        }
    }

    public function userLoginOtp(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->apiUrl . 'login/otp';
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
            ])->post($apiUrl, [
                'username' => $data['username'],
            ]);

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to connect to authentication service'], 503);
        }
    }

    public function userLoginOtpVerify(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->apiUrl . 'login/otp/verify';
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
            ])->post($apiUrl, [
                'username' => $data['username'],
                'code' => $data['code'],
            ]);

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to connect to authentication service'], 503);
        }
    }

    public function userLogiByPassword(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->apiUrl . 'login/password';
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
            ])->post($apiUrl, [
                'username' => $data['username'],
                'password' => $data['password'],
            ]);

            if ($response->successful()) {
                $user = User::where('email', $data['username'])->orWhere('phone', $data['username'])->first();
                if ($user) {
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()->json([
                        'message' => 'Login successful',
                        'token' => "Bearer {$token}",
                    ]);
                }
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to connect to authentication service'], 503);
        }
    }

    public function resendOtpCode(Request $request): JsonResponse
    {
        $data = $request->validated();
        $apiUrl = $this->apiUrl . 'resend-otp';
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
            ])->post($apiUrl, [
                'username' => $data['username'],
            ]);

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to connect to authentication service'], 503);
        }
    }
}