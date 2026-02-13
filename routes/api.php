<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;      // 📌 Controller user books
use App\Http\Controllers\API\UserController;      // 📌 Controller user detail
use App\Http\Controllers\API\DashboardController; // 📌 Controller dashboard stats
use App\Http\Controllers\LoanController;           // 📌 User loan controller
use App\Http\Controllers\FineController;

use App\Http\Controllers\Admin\BookAdminController;
use App\Http\Controllers\Admin\LoanAdminController;
use App\Http\Controllers\Admin\FineAdminController;

// ==========================
// API Routes
// ==========================

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔥 ROUTE UPDATE PHOTO (Hanya ini yang pakai Middleware Auth)
Route::middleware('auth:sanctum')->post('/user/update-photo', [UserController::class, 'updatePhoto']);

// ==========================
// User Routes (Public/Sesuai Struktur Awal Kamu)
// ==========================

// Buku (user bisa lihat daftar buku)
Route::get('/books', [BookController::class, 'index']); // GET /api/books

// Peminjaman user (Flutter pakai API JSON)
Route::get('/loans', [LoanController::class, 'apiIndex']); // ✅ ganti dari 'index' ke 'apiIndex'
Route::post('/loans', [LoanController::class, 'store']);    // POST /api/loans (otomatis borrowed_at & due_date)

// Lapor kehilangan (user)
Route::put('/loans/{id}/lost', [LoanController::class, 'markLost']); // ✅ route user untuk Flutter Web

// Denda user
Route::get('/fines', [FineController::class, 'index']);           // GET /api/fines
Route::post('/fines/pay/{id}', [FineController::class, 'pay']);   // POST /api/fines/pay/{id}

// User detail (Balik ke posisi awal agar tidak kena CORS/Redirect)
Route::get('/users/{id}', [UserController::class, 'show']); // GET /api/users/{id}

// Dashboard statistics
Route::get('/dashboard/statistics', [DashboardController::class, 'statistics']);

// ==========================
// Cover Buku dengan CORS
// ==========================
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

Route::get('/cover/{filename}', function ($filename) {
    $path = storage_path('app/public/covers/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return Response::file($path, [
        'Access-Control-Allow-Origin' => '*', // ❗ CORS header
    ]);
});

// ==========================
// 🔥 UPDATE FINAL: Foto Profil dengan CORS (Sama seperti Cover)
// ==========================
Route::get('/profile-photo/{filename}', function ($filename) {
    // Sesuaikan folder penyimpanan di Laravel kamu (biasanya public/profiles)
    $path = storage_path('app/public/profiles/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return Response::file($path, [
        'Access-Control-Allow-Origin' => '*', // ❗ Mengatasi ERR_FAILED di Flutter Web
        'Access-Control-Allow-Methods' => 'GET',
    ]);
});

// ==========================
// Admin Routes (prefix: admin)
// ==========================
Route::prefix('admin')->group(function () {
    // Buku (CRUD)
    Route::get('/books', [BookAdminController::class, 'index']);
    Route::post('/books', [BookAdminController::class, 'store']);
    Route::put('/books/{id}', [BookAdminController::class, 'update']);
    Route::delete('/books/{id}', [BookAdminController::class, 'destroy']);

    // Peminjaman (lihat dan update status)
    Route::get('/loans', [LoanAdminController::class, 'index']);
    Route::put('/loans/{id}/return', [LoanAdminController::class, 'markReturned']);
    Route::put('/loans/{id}/lost', [LoanAdminController::class, 'markLost']); // ✅ tetap untuk admin

    // Denda (lihat dan bayar)
    Route::get('/fines', [FineAdminController::class, 'index']);
    Route::put('/fines/{id}/pay', [FineAdminController::class, 'markAsPaid']);
});