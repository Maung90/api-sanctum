<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfileController;


Route::prefix('auth')->as('auth.')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login'); 
        Route::post('/verify-otp', 'verifyOtp'); 
        Route::post('/register', 'register');
        Route::post('/forgot-password', 'forgotPassword')->name('forgotPassword');
    });
});

Route::middleware('auth:sanctum')->group(function () { 

    Route::middleware('can:role-master')->group(function () {
        Route::controller(UserController::class)->group(function () { 
            Route::get('/users','index');
            Route::delete('/users/{user}','destroy'); 
            Route::post('/users/{user}/update-role','update_role');
        });
    });

    Route::prefix('profile')->as('profile.')->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('me', 'index')->name('index');
            // Route::put('/', 'update')->name('update');
        });
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});