<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserAdminController extends Controller
{
    /**
     * Menampilkan daftar semua user kecuali admin.
     */
    public function index()
    {
        // Mengambil user dengan role 'user' (atau selain admin) 
        // Diurutkan dari yang terbaru daftar
        $users = User::where('role', '!=', 'admin')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menyetujui akun user agar bisa login.
     */
    public function approve($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Update status is_active menjadi true
            $user->update([
                'is_active' => true
            ]);

            return back()->with('success', 'Akses pengguna ' . $user->name . ' telah diaktifkan!');
        } catch (\Exception $e) {
            Log::error("Gagal approve user: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyetujui user.');
        }
    }

    /**
     * Menghapus user (jika pendaftar dianggap spam atau ditolak).
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $userName = $user->name;
            $user->delete();

            return back()->with('success', 'Akun ' . $userName . ' berhasil dihapus dari sistem.');
        } catch (\Exception $e) {
            Log::error("Gagal hapus user: " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus pengguna.');
        }
    }
}