<?php

use Illuminate\Http\Request;
use App\Http\Controllers\MidtransController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/midtrans/callback', [MidtransController::class, 'handleCallback']);
