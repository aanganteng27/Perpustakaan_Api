<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('login'); 
    }

    /**
     * Proses masuk dan pengecekan status aktif.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            
            $user = Auth::user();

            // 🔥 LOGIC SKRIPSI: Cek apakah Admin sudah menyetujui akun ini
            if ($user->is_active == false) {
                Auth::logout();
                
                return back()->with('error', 'Akun Anda belum disetujui oleh Admin. Silakan hubungi petugas perpustakaan.');
            }

            $request->session()->regenerate();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard')->with('success', 'Selamat Datang Kembali, Admin!');
            }

            return redirect()->route('welcome')->with('success', 'Berhasil masuk ke sistem.');
        }

        throw ValidationException::withMessages([
            'email' => ['Maaf, email atau password salah.'],
        ]);
    }

    /**
     * Proses keluar.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar.');
    }
}