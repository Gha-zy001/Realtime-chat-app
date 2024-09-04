<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\UserAuth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->group(function () {
  Route::get('/users', [ChatController::class, 'getUsers']);
  Route::post('/send-message', [ChatController::class, 'sendMessage']);
  Route::get('/messages/{userId}', [ChatController::class, 'getMessages']);
  Route::post('/logout', [AuthController::class, 'logout']);
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
