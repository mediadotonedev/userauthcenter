<?php

namespace Mediadotonedev\UserAuthCenter\Http\Controllers;

use Mediadotonedev\UserAuthCenter\Http\Requests\UserCheckRequest;
use Mediadotonedev\UserAuthCenter\Http\Requests\UserRegisterRequest;
use Mediadotonedev\UserAuthCenter\Http\Requests\UserRegisterVerifyRequest;
use Mediadotonedev\UserAuthCenter\Http\Requests\UserLoginOtpRequest;
use Mediadotonedev\UserAuthCenter\Http\Requests\UserLoginOtpVerifyRequest;
use Mediadotonedev\UserAuthCenter\Http\Requests\UserLoginPasswordRequest;
use Mediadotonedev\UserAuthCenter\Http\Requests\UserResendRequest;
use Mediadotonedev\UserAuthCenter\Services\UserAuthService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Post(
 *     path="/api/auth/check",
 *     tags={"Authentication"},
 *     summary="Check if a username exists",
 *     description="Checks if a username (email or phone) exists in the system.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username"},
 *             @OA\Property(property="username", type="string", example="user@example.com", description="User's email or phone number")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="exists", type="boolean", example=true, description="Whether the username exists")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid username")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid API key")
 *         )
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/auth/register",
 *     tags={"Authentication"},
 *     summary="Register a new user",
 *     description="Registers a new user with the provided details.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "name", "nickname", "password", "password_confirmation", "gender", "show_name"},
 *             @OA\Property(property="username", type="string", example="user@example.com", description="User's email or phone number"),
 *             @OA\Property(property="name", type="string", example="John Doe", description="Full name of the user"),
 *             @OA\Property(property="nickname", type="string", example="johndoe", description="User's nickname"),
 *             @OA\Property(property="password", type="string", format="password", example="Password123!", description="User's password"),
 *             @OA\Property(property="password_confirmation", type="string", format="password", example="Password123!", description="Password confirmation"),
 *             @OA\Property(property="gender", type="string", enum={"male", "female", "other"}, example="male", description="User's gender"),
 *             @OA\Property(property="show_name", type="boolean", example=true, description="Whether to show the user's name publicly")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful registration",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="User registered successfully"),
 *             @OA\Property(property="user_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Validation failed")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid API key")
 *         )
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/auth/register/verify",
 *     tags={"Authentication"},
 *     summary="Verify user registration",
 *     description="Verifies the user's registration using a verification code.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "code"},
 *             @OA\Property(property="username", type="string", example="user@example.com", description="User's email or phone number"),
 *             @OA\Property(property="code", type="string", example="123456", description="Verification code")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful verification",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="User verified successfully"),
 *             @OA\Property(property="token", type="string", example="Bearer xyz", description="Authentication token")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid verification code")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid API key")
 *         )
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/auth/login/otp",
 *     tags={"Authentication"},
 *     summary="Request OTP for login",
 *     description="Requests a one-time password (OTP) for user login.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username"},
 *             @OA\Property(property="username", type="string", example="user@example.com", description="User's email or phone number")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OTP sent successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="OTP sent to your email/phone")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid username")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid API key")
 *         )
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/auth/login/otp/verify",
 *     tags={"Authentication"},
 *     summary="Verify OTP for login",
 *     description="Verifies the OTP for user login.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "code"},
 *             @OA\Property(property="username", type="string", example="user@example.com", description="User's email or phone number"),
 *             @OA\Property(property="code", type="string", example="123456", description="OTP code")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful login",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Login successful"),
 *             @OA\Property(property="token", type="string", example="Bearer xyz", description="Authentication token")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid OTP code")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid API key")
 *         )
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/auth/login/password",
 *     tags={"Authentication"},
 *     summary="Login with password",
 *     description="Logs in a user using their username and password.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "password"},
 *             @OA\Property(property="username", type="string", example="user@example.com", description="User's email or phone number"),
 *             @OA\Property(property="password", type="string", format="password", example="Password123!", description="User's password")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful login",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Login successful"),
 *             @OA\Property(property="token", type="string", example="Bearer xyz", description="Authentication token")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid credentials")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid API key")
 *         )
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/auth/resend-otp",
 *     tags={"Authentication"},
 *     summary="Resend OTP for registration or login",
 *     description="Resends a one-time password (OTP) to the user's email or phone.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username"},
 *             @OA\Property(property="username", type="string", example="user@example.com", description="User's email or phone number")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OTP resent successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="OTP resent to your email/phone")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid username")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Invalid API key")
 *         )
 *     )
 * )
 */

class UserAuthController extends Controller
{
    protected $userAuthService;

    public function __construct()
    {
        $this->userAuthService = new UserAuthService();
    }

    public function check(UserCheckRequest $request): JsonResponse
    {
        return $this->userAuthService->userCheck($request);
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        return $this->userAuthService->userRegister($request);
    }

    public function registerVerify(UserRegisterVerifyRequest $request): JsonResponse
    {
        return $this->userAuthService->userRegisterVerify($request);
    }

    public function logiByOtp(UserLoginOtpRequest $request): JsonResponse
    {
        return $this->userAuthService->userLoginOtp($request);
    }

    public function logiByOtpVerify(UserLoginOtpVerifyRequest $request): JsonResponse
    {
        return $this->userAuthService->userLoginOtpVerify($request);
    }

    public function logiByPassword(UserLoginPasswordRequest $request): JsonResponse
    {
        return $this->userAuthService->userLogiByPassword($request);
    }

    public function resendOtp(UserResendRequest $request): JsonResponse
    {
        return $this->userAuthService->resendOtpCode($request);
    }
}