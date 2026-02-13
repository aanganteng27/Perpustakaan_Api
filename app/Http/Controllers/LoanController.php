<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// --- UPDATE: IMPORT UNTUK EMAIL & LOG ---
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\NotifikasiPinjam;

class LoanController extends Controller
{
    /**
     * Tampilkan halaman peminjaman di admin (Blade)
     */
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        $query = Loan::with(['user', 'book']);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $loans = $query->orderBy('created_at', 'desc')->get();

        return view('admin.loans.index', compact('loans'));
    }

    /**
     * API untuk Flutter: ambil daftar peminjaman user
     */
    public function apiIndex(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json(['message' => 'User ID diperlukan'], 400);
        }

        $loans = Loan::with(['book'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $loans,
        ], 200);
    }

    /**
     * Proses pengajuan pinjam buku (API Flutter)
     * Logika baru: Masuk sebagai PENDING
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $book = Book::find($request->book_id);

        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        // 1. Cek stok (Hanya cek, jangan dikurangi dulu)
        if ($book->stock <= 0) {
            return response()->json(['message' => 'Stok buku sedang kosong'], 400);
        }

        // 2. Cek apakah user sudah punya pinjaman pending atau aktif untuk buku ini
        $existingLoan = Loan::where('user_id', $request->user_id)
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['pending', 'dipinjam'])
            ->first();

        if ($existingLoan) {
            $statusMsg = $existingLoan->status == 'pending' 
                ? 'Kamu sudah mengajukan pinjaman buku ini, tunggu persetujuan admin.' 
                : 'Buku ini sedang kamu pinjam.';
            return response()->json(['message' => $statusMsg], 400);
        }

        // 3. Create Loan dengan status PENDING
        // Stok TIDAK dikurangi di sini (dikurangi di AdminController saat Approve)
        $loan = Loan::create([
            'user_id'     => $request->user_id,
            'book_id'     => $request->book_id,
            'borrowed_at' => null, // Belum mulai pinjam
            'due_date'    => null, // Belum ada tenggat
            'returned_at' => null,
            'status'      => 'pending',
        ]);

        // --- UPDATE: LOGIC KIRIM EMAIL ---
        $loan->load(['user', 'book']); // Pastikan data user & buku ikut terbawa ke email

        try {
            Mail::to($loan->user->email)->send(new NotifikasiPinjam($loan));
        } catch (\Exception $e) {
            // Jika mail gagal (misal koneksi mati), log tetap dicatat tapi proses tidak berhenti
            Log::error('Gagal mengirim email peminjaman: ' . $e->getMessage());
        }
        // ---------------------------------

        return response()->json([
            'message' => 'Permintaan pinjam berhasil dikirim, silahkan cek email Anda untuk verifikasi dan tunggu konfirmasi admin.',
            'loan'    => $loan,
        ], 201);
    }

    /**
     * Tandai buku hilang (API untuk Flutter)
     */
    public function markLost($id)
    {
        $loan = Loan::with('book')->find($id);

        if (!$loan) {
            return response()->json(['message' => 'Pinjaman tidak ditemukan'], 404);
        }

        if ($loan->status === 'hilang') {
            return response()->json(['message' => 'Buku sudah ditandai hilang'], 400);
        }

        // Update status loan
        $loan->status = 'hilang';
        $loan->save();

        // Buat denda otomatis
        $amount = $loan->book->price ?? 50000;

        Fine::create([
            'loan_id' => $loan->id,
            'user_id' => $loan->user_id,
            'amount'  => $amount,
            'reason'  => 'Buku hilang (dilaporkan oleh user)',
            'status'  => 'belum_dibayar',
        ]);

        return response()->json([
            'message' => 'Laporan buku hilang diterima, denda telah ditambahkan.',
            'loan'    => $loan
        ], 200);
    }
}