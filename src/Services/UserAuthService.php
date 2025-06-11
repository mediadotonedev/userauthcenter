<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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
            if($response->successful())
            {
                $responseData = $response->json();

                // بررسی وجود کلیدهای مورد انتظار در پاسخ
                if (!isset($responseData['data']['client'])) {
                    return response()->json([
                        'message' => 'Invalid API response format',
                        'response' => $responseData,
                    ], 400);
                }

                $clientData = $responseData['data']['client'];

                $clientValidator = Validator::make($clientData, [
                    'client_id' => 'required|integer',
                    'name' => 'required|string|max:255',
                    'phone' => 'nullable|string|unique:users,phone',
                    'email' => 'nullable|string|unique:users,email',
                    'gender' => 'nullable|in:male,female',
                ]);

                if ($clientValidator->fails()) {
                    return response()->json([
                        'message' => 'Invalid client data',
                        'errors' => $clientValidator->errors(),
                    ], 422);
                }
                try
                {
                    $user = User::updateOrCreate(
                    ['id' => $clientData['client_id']],
                    [
                        'fk_client_id' => $clientData['client_id'],
                        'name' => $clientData['name'],
                        'avatar' => $clientData['avatar'],
                        'nickname' => $clientData['nickname'],
                        'phone' => $clientData['phone'],
                        'phone_verified_at' => $clientData['phone_verified_at'],
                        'email' => $clientData['email'],
                        'email_verified_at' => $clientData['email_verified_at'],
                        'birth_date' => $clientData['birth_date'],
                        'gender' => $clientData['gender'],
                    ]);
                        return response()->json([
                            'message' => 'User registered successfully',
                            'user' => $user,
                        ], 200);
                    }
                catch (\Exception $e)
                {
                    return response()->json([
                        'message' => 'Failed to save user',
                        'error' => $e->getMessage(),
                    ], 500);
                }

            }
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
