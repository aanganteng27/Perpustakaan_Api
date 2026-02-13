<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    /**
     * Menampilkan semua denda milik user (API)
     */
    public function index(Request $request)
    {
        // 🔥 FIX BUG AUTH NULL (AMAN UNTUK FLUTTER TANPA TOKEN)
        $userId = optional($request->user())->id ?? $request->get('user_id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID tidak ditemukan'
            ], 400);
        }

        $fines = Fine::with(['loan.book'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $fines
        ], 200);
    }

    /**
     * Detail satu denda
     */
    public function show($id)
    {
        $fine = Fine::with(['loan.book'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $fine
        ], 200);
    }

    /**
     * Proses pembayaran denda (USER)
     */
    public function pay(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|string|max:50'
        ]);

        $fine = Fine::with('loan')->findOrFail($id);

        // ⛔ Cegah bayar ulang
        if ($fine->status === 'sudah_dibayar') {
            return response()->json([
                'success' => false,
                'message' => 'Denda sudah dibayar.'
            ], 400);
        }

        // ✅ Update denda
        $fine->status = 'sudah_dibayar';
        $fine->paid_at = now();
        $fine->payment_method = $request->payment_method;
        $fine->save();

        // 🔥 Sinkron ke loan (jika buku hilang)
        if ($fine->loan && $fine->loan->status === 'hilang') {
            $fine->loan->status = 'lunas';
            $fine->loan->returned_at = now();
            $fine->loan->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran denda berhasil.',
            'data' => $fine
        ], 200);
    }
}
