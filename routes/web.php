<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('role')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index');  
});

Route::get('/hello', function () {
    return response()->json(['message' => 'API jalan!']);
});