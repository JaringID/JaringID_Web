<?php

use App\Models\Farm;
use App\Models\Kolam;
use App\Models\User;
use App\Models\Penyakit;
use Illuminate\Http\Request;
use App\Models\MonthlyReport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KolamController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TambakController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\FeedScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KeuanganController;

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
    return response()->json($request->user()); // Mengembalikan data user
});


// Rute login menggunakan controller AuthController
Route::post('/login', [AuthController::class, 'login']);

Route::post('/api-register', [AuthController::class, 'register']);

Route::get('/penyakit', function () {
    return response()->json(Penyakit::all());
});

Route::post('/tambak', [TambakController::class, 'store'])->middleware('auth:sanctum');


Route::get('/tambak', [TambakController::class, 'index'])->middleware('auth:sanctum');


Route::get('/reports', function () {
    return response()->json(MonthlyReport::all());
});

Route::get('/kolam', function () {
    return response()->json(Kolam::all());
})->middleware('auth:sanctum');
Route::post('/kolam', [KolamController::class, 'store'])->middleware('auth:sanctum');
// Rute untuk mengedit kolam (menggunakan metode PUT)
Route::put('/kolam/{id}', [KolamController::class, 'update']);

// Rute untuk menghapus kolam (menggunakan metode DELETE)
Route::delete('/kolam/{id}', [KolamController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/getuser', [UserController::class, 'getUser']);

Route::middleware('auth:sanctum')->group(function () {
    // Endpoint untuk user yang sedang login
    Route::get('/user/profile', [UserController::class, 'showProfile']);

    // Endpoint untuk melihat profil user berdasarkan ID (opsional)
    Route::get('/user/profile/{id}', [UserController::class, 'showProfile']);
});

Route::post('/keuangan/saldo', [KeuanganController::class, 'catatSaldo']);
Route::post('/keuangan/pendapatan', [KeuanganController::class, 'catatPendapatan']);
Route::post('/keuangan/pengeluaran', [KeuanganController::class, 'storePengeluaran']);
Route::post('/keuangan/laporan', [KeuanganController::class, 'generateLaporanKeuangan']);

Route::middleware('auth:sanctum')->get('/farms', [TambakController::class, 'getUserTambaks']);
