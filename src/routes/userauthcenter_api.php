<?php

use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('api')->middleware('api')->group(function () {

	Route::prefix('users')->group(function () {
	    	Route::middleware(['auth:sanctum'])->group(function () {
			//routes by sanctum

	    	});

		Route::post('check', [UserAuthController::class, 'check'])->name('user.check');
		Route::post('register', [UserAuthController::class, 'register'])->name('user.register');
		Route::post('register/verify', [UserAuthController::class, 'registerVerify'])->name('user.register.verify');
		Route::post('login/password', [UserAuthController::class, 'logiByPassword'])->name('user.login.password');
		Route::post('login/otp', [UserAuthController::class, 'logiByOtp'])->name('user.login.otp');
		Route::post('login/otp/verify', [UserAuthController::class, 'logiByOtpVerify'])->name('user.login.otp.verify');
		
	});

});
