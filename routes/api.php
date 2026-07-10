<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\UserAuth\AuthController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/config', function () {
  return response()->json([
    'pusher_key' => config('broadcasting.connections.pusher.key'),
    'pusher_cluster' => config('broadcasting.connections.pusher.options.cluster'),
  ]);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
  Route::get('/users', [ChatController::class, 'getUsers']);
  Route::post('/send-message', [ChatController::class, 'sendMessage']);
  Route::get('/messages/{userId}', [ChatController::class, 'getMessages']);
  Route::post('/logout', [AuthController::class, 'logout']);
});
