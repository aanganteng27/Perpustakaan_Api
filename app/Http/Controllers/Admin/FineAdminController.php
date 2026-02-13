<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use Illuminate\Http\Request;
// --- UPDATE: IMPORT UNTUK EMAIL ---
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PembayaranDendaBerhasil;

class FineAdminController extends Controller
{
    /**
     * Menampilkan data denda
     */
    public function index(Request $request)
    {
        $query = Fine::with(['loan.user', 'loan.book']);

        // 🔍 Search nama peminjam
        if ($request->filled('search')) {
            $query->whereHas('loan.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // 🔎 Filter status (SESUI ENUM DB)
        if ($request->filled('status') && in_array($request->status, [
            'belum_dibayar',
            'sudah_dibayar'
        ])) {
            $query->where('status', $request->status);
        }

        // API
        if ($request->wantsJson()) {
            return response()->json($query->get());
        }

        // WEB
        $fines = $query->latest()->paginate(10);
        return view('admin.fines.index', compact('fines'));
    }

    /**
     * Form bayar denda
     */
    public function showPayForm($id)
    {
        $fine = Fine::with(['loan.user', 'loan.book'])->findOrFail($id);
        return view('admin.fines.pay', compact('fine'));
    }

    /**
     * Proses pembayaran denda (ADMIN)
     */
    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|string|max:50',
        ]);

        $fine = Fine::with(['loan.user', 'user'])->findOrFail($id);

        // ✅ UPDATE DENDA
        $fine->status = 'sudah_dibayar';
        $fine->paid_at = now();
        $fine->payment_method = $request->payment_method;
        $fine->save();

        // 🔥 SINKRON KE LOAN
        if ($fine->loan) {
            $fine->loan->status = 'dikembalikan'; 
            $fine->loan->returned_at = now();
            $fine->loan->save();
        }

        // --- KIRIM EMAIL KUITANSI ---
        $this->sendReceiptEmail($fine);

        return redirect()
            ->route('admin.fines.index')
            ->with('success', 'Denda berhasil dibayar & kuitansi telah dikirim ke email user.');
    }

    /**
     * API: tandai lunas
     */
    public function markAsPaid($id)
    {
        $fine = Fine::with(['loan.user', 'user'])->findOrFail($id);

        $fine->status = 'sudah_dibayar';
        $fine->paid_at = now();
        $fine->payment_method = 'tunai'; // Default jika klik tombol cepat
        $fine->save();

        if ($fine->loan) {
            $fine->loan->status = 'dikembalikan';
            $fine->loan->returned_at = now();
            $fine->loan->save();
        }

        // --- KIRIM EMAIL KUITANSI ---
        $this->sendReceiptEmail($fine);

        return request()->wantsJson()
            ? response()->json(['message' => 'Denda berhasil diselesaikan dan email terkirim'])
            : redirect()->route('admin.fines.index')->with('success', 'Denda berhasil ditandai lunas & kuitansi terkirim.');
    }

    /**
     * Edit denda
     */
    public function edit($id)
    {
        $fine = Fine::with(['loan.user', 'loan.book'])->findOrFail($id);
        return view('admin.fines.edit', compact('fine'));
    }

    /**
     * Update denda (EDIT MANUAL ADMIN)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:belum_dibayar,sudah_dibayar',
            'payment_method' => 'nullable|string|max:50',
        ]);

        $fine = Fine::with(['loan.user', 'user'])->findOrFail($id);
        
        $oldStatus = $fine->status; // Simpan status lama buat pengecekan email

        $fine->amount = $request->amount;
        $fine->status = $request->status;
        $fine->payment_method = $request->payment_method;
        
        if ($request->status === 'sudah_dibayar' && !$fine->paid_at) {
            $fine->paid_at = now();
        }
        
        $fine->save();

        // 🔥 JIKA STATUS BERUBAH JADI SUDAH_DIBAYAR
        if ($request->status === 'sudah_dibayar') {
            if ($fine->loan) {
                $fine->loan->status = 'dikembalikan';
                $fine->loan->returned_at = now();
                $fine->loan->save();
            }

            // Kirim email hanya jika sebelumnya statusnya belum lunas
            if ($oldStatus !== 'sudah_dibayar') {
                $this->sendReceiptEmail($fine);
            }
        }

        return redirect()
            ->route('admin.fines.index')
            ->with('success', 'Data denda berhasil diperbarui.');
    }

    /**
     * Menampilkan kuitansi PDF/Web untuk dicetak
     * Ditambahkan untuk sinkronisasi dengan Flutter Web
     */
    public function receipt($id)
    {
        // Mengambil data denda beserta relasi yang diperlukan
        $fine = Fine::with(['loan.user', 'loan.book', 'user'])->findOrFail($id);

        // Hanya izinkan cetak jika sudah dibayar
        if ($fine->status !== 'sudah_dibayar') {
            return redirect()->route('admin.fines.index')
                ->with('error', 'Kuitansi belum tersedia karena denda belum dibayar.');
        }

        return view('admin.fines.receipt', compact('fine'));
    }

    /**
     * Private function untuk kirim email agar kode tidak duplikat
     */
    private function sendReceiptEmail($fine)
    {
        try {
            // Cek email lewat relasi fine->user atau fine->loan->user
            $email = $fine->user->email ?? ($fine->loan->user->email ?? null);

            if ($email) {
                Mail::to($email)->send(new PembayaranDendaBerhasil($fine));
            } else {
                Log::warning('Email tidak ditemukan untuk denda ID: ' . $fine->id);
            }
        } catch (\Exception $e) {
            Log::error('Gagal kirim email kuitansi: ' . $e->getMessage());
        }
    }
}