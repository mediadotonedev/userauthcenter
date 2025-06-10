<?php

use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/
Route::prefix('users')->group(function () {
    //user sanctum
    Route::middleware(['auth:sanctum'])->group(function () {

    });
    /***auth user chdeck/register/registerVerify/loginOtp/loginOtpVerify/login password */
    Route::post('/check',[UserAuthController::class,'check']);
    Route::post('/register',[UserAuthController::class,'register']);
    Route::post('/register/verify',[UserAuthController::class,'registerVerify']);
    Route::post('/login/otp',[UserAuthController::class,'logiByOtp']);
    Route::post('/login/otp/verify',[UserAuthController::class,'logiByOtpVerify']);
    Route::post('/login/password',[UserAuthController::class,'logiByPassword']);

    /***update user profile(name/gender/avatar) and password */
    /*
    Route::post('update/{user_id}',[UserController::class],'userUpdate');

    Route::resources([UserController::class]);
    */

});
