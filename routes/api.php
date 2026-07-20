<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\ServiceApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ApiAuthController::class, 'user']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    Route::get('/services', [ServiceApiController::class, 'index']);
    Route::get('/customers', [CustomerApiController::class, 'index']);
});
