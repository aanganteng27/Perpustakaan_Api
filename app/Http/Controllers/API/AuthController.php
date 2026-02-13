<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Fungsi Register User
    public function register(Request $request)
    {
        // Validasi data inputan
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Kalau validasi gagal, kembalikan error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Buat user baru, password di-hash supaya aman
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Buat token autentikasi (untuk API token)
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kirim response sukses beserta token dan data user
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user
        ], 201);
    }

    // Fungsi Login User
    public function login(Request $request)
    {
        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Kalau user tidak ditemukan atau password salah
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // Buat token autentikasi baru
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kirim response sukses beserta token dan data user
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user
        ]);
    }
}
