<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Menampilkan detail user berdasarkan ID
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }
        
        // Jangan timpa property asli agar tidak rusak saat save/delete nanti
        // Kita buat attribute virtual saja atau format langsung di response
        $userData = $user->toArray();
        if ($user->profile_photo) {
            $userData['profile_photo'] = asset('storage/' . $user->profile_photo);
        }
        
        return response()->json($userData);
    }

    /**
     * Update Foto Profil User
     */
    public function updatePhoto(Request $request)
    {
        // 1. Validasi file
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Ambil user yang sedang login
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // 3. Hapus foto lama jika ada
        if ($user->getRawOriginal('profile_photo')) {
            // Gunakan getRawOriginal agar yang diambil path aslinya, bukan URL asset
            Storage::disk('public')->delete($user->getRawOriginal('profile_photo'));
        }

        // 4. Simpan foto baru
        $path = $request->file('photo')->store('profiles', 'public');

        // 5. Update database
        $user->profile_photo = $path;
        $user->save();

        // 6. Response (Disesuaikan agar AuthProvider Flutter langsung baca URL-nya)
        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'profile_photo' => asset('storage/' . $path), // URL Lengkap untuk Flutter
            ]
        ]);
    }
}