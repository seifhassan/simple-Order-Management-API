<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;


Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::get('/orders/stats', [OrderController::class, 'stats']);
