<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\AuthController;
use App\Models\Penyakit;
use App\Http\Controllers\FeedScheduleController;

/*
|--------------------------------------------------------------------------|
| API Routes                                                               |
|--------------------------------------------------------------------------|
| Here is where you can register API routes for your application. These    |
| routes are loaded by the RouteServiceProvider and all of them will       |
| be assigned to the "api" middleware group. Make something great!         |
|--------------------------------------------------------------------------|
*/

// Rute yang membutuhkan autentikasi menggunakan Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/feed-schedules', [FeedScheduleController::class, 'index']);
    Route::post('/feed-schedules', [FeedScheduleController::class, 'store']);
    Route::put('/feed-schedules/{id}', [FeedScheduleController::class, 'update']);
    Route::delete('/feed-schedules/{id}', [FeedScheduleController::class, 'destroy']);
});

// Endpoint untuk mendapatkan data user yang sedang login
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rute login menggunakan controller AuthController
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::get('/penyakit', function () {
    return response()->json(Penyakit::all());
});

