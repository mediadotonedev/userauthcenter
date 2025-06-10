<?php

use Illuminate\Support\Facades\Route;
use Mohsen\UserAuthCenter\Http\Controllers\UserAuthController;

Route::prefix(config('userauthcenter.auth.route_prefix', 'auth'))->middleware('api')->group(function () {
    Route::post('/check', [UserAuthController::class, 'check']);
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/register/verify', [UserAuthController::class, 'registerVerify']);
    Route::post('/login/otp', [UserAuthController::class, 'logiByOtp']);
    Route::post('/login/otp/verify', [UserAuthController::class, 'logiByOtpVerify']);
    Route::post('/login/password', [UserAuthController::class, 'logiByPassword']);
    Route::post('/resend-otp', [UserAuthController::class, 'resendOtp']);
});