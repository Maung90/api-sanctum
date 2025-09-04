<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RapatController;
use App\Http\Controllers\Api\BidangController;


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

        Route::prefix('bidang')->as('bidang.')->group(function () {
            Route::controller(BidangController::class)->group(function () { 
                Route::get('/','index');
                Route::get('/{id}','show');
                Route::post('/', 'store');
                Route::put('/{id}', 'update');
                Route::delete('/{id}','destroy'); 
            });
        });
    });

    Route::prefix('profile')->as('profile.')->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('me', 'index')->name('index');
            Route::put('/', 'update')->name('update');
        });
    });

    Route::middleware('can:manage-meeting')->group(function () {
        Route::prefix('meet')->as('meet.')->group(function () {
            Route::controller(RapatController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
                Route::post('/', 'store');
                Route::put('/{id}', 'update');
                Route::delete('/{id}','destroy'); 
            });
        });
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});