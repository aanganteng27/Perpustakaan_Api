<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\BookAdminController;
use App\Http\Controllers\Admin\LoanAdminController;
use App\Http\Controllers\Admin\FineAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===================
// Halaman Umum
// ===================
Route::view('/', 'welcome')->name('welcome');

// --- AUTH SYSTEM ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Logout via GET (Opsional, untuk mempermudah link logout)
Route::get('/logout-get', function () {
    Session::flush();
    return redirect()->route('login')->with('success', 'Anda telah logout.');
})->name('logout.get');


// ===================
// ADMIN AREA
// ===================
Route::prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    // Statistik peminjaman
    Route::get('/loan-stats', [AdminController::class, 'loanStats'])
        ->name('loanStats');

    // ===================
    // Kelola Users (Fungsi Aktivasi Akun)
    // ===================
    Route::prefix('users')->name('admin.users.')->group(function () {
        Route::get('/', [UserAdminController::class, 'index'])->name('index');
        Route::put('/{id}/approve', [UserAdminController::class, 'approve'])->name('approve');
        Route::delete('/{id}', [UserAdminController::class, 'destroy'])->name('destroy');
    });

    // ===================
    // Buku
    // ===================
    Route::prefix('books')->name('admin.books.')->group(function () {
        Route::get('/', [BookAdminController::class, 'index'])->name('index');
        Route::get('/create', [BookAdminController::class, 'create'])->name('create');
        Route::post('/', [BookAdminController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BookAdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BookAdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [BookAdminController::class, 'destroy'])->name('destroy');
    });

    // ===================
    // Peminjaman
    // ===================
    Route::prefix('loans')->name('admin.loans.')->group(function () {

        Route::get('/', [LoanAdminController::class, 'index'])->name('index');
        Route::get('/{id}', [LoanAdminController::class, 'show'])->name('show');
        Route::put('/{id}', [LoanAdminController::class, 'update'])->name('update');

        // 🔥 Aksi Approve & Reject
        Route::put('/{id}/approve', [LoanAdminController::class, 'approve'])->name('approve');
        Route::put('/{id}/reject', [LoanAdminController::class, 'reject'])->name('reject');

        // 🔥 Edit jatuh tempo
        Route::put('/{id}/update-due-date', [LoanAdminController::class, 'updateDueDate'])->name('updateDueDate');

        // 🔥 Aksi status kembali / hilang
        Route::put('/{id}/return', [LoanAdminController::class, 'markReturned'])->name('markReturned');
        Route::put('/{id}/lost', [LoanAdminController::class, 'markLost'])->name('markLost');
    });

    // ===================
    // Denda
    // ===================
    Route::prefix('fines')->name('admin.fines.')->group(function () {

        Route::get('/', [FineAdminController::class, 'index'])->name('index');

        // 🔥 EDIT HARGA DENDA
        Route::put('/{fine}/update-amount', [FineAdminController::class, 'updateAmount'])->name('updateAmount');

        // Edit & update manual
        Route::get('/{id}/edit', [FineAdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [FineAdminController::class, 'update'])->name('update');

        // 🔥 Pembayaran denda
        Route::put('/{id}/pay', [FineAdminController::class, 'markAsPaid'])->name('markAsPaid');
        Route::get('/pay/{id}', [FineAdminController::class, 'showPayForm'])->name('pay');
        Route::post('/pay/{id}', [FineAdminController::class, 'processPayment'])->name('processPayment');

        // 🔥 Tambahan Route Kuitansi (Receipt) untuk diakses Flutter Web
        Route::get('/receipt/{id}', [FineAdminController::class, 'receipt'])->name('receipt');
    });
});

// ============================================================
// EMERGENCY ROUTE (HAPUS SETELAH BERHASIL LOGIN)
// ============================================================
Route::get('/force-admin', function () {
    try {
        $user = \App\Models\User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('admin123'),
                'role' => 'admin', // Pastikan kolom di DB lu beneran 'role'
                'is_active' => true, // Biar langsung aktif
            ]
        );
        return "Admin Berhasil Dibuat/Update! <br> Email: admin@gmail.com <br> Pass: admin123 <br><br> <a href='/login'>Ke Halaman Login</a>";
    } catch (\Exception $e) {
        return "Gagal: " . $e->getMessage();
    }
});