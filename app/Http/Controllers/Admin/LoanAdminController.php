<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Fine;
use Illuminate\Http\Request;
use Carbon\Carbon;
// --- UPDATE: IMPORT UNTUK EMAIL & LOG ---
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PinjamanDisetujui;

class LoanAdminController extends Controller
{
    /**
     * Tampilkan semua daftar peminjaman (Admin Dashboard)
     */
    public function index(Request $request)
    {
        $query = Loan::with(['book', 'user', 'fine'])->orderBy('created_at', 'desc');

        // Fitur Search nama user
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $loans = $query->get();
        return view('admin.loans.index', compact('loans'));
    }

    /**
     * =====================
     * ✅ SETUJUI PEMINJAMAN
     * =====================
     */
    public function approve($id)
    {
        // Update: Load user juga biar bisa kirim email
        $loan = Loan::with(['book', 'user'])->findOrFail($id);

        if ($loan->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya permintaan pending yang bisa disetujui.');
        }

        // Cek stok buku fisik sebelum menyetujui
        if ($loan->book->stock <= 0) {
            return redirect()->back()->with('error', 'Gagal! Stok buku habis.');
        }

        // Update status & set masa pinjam (7 hari)
        $loan->update([
            'status' => 'dipinjam',
            'borrowed_at' => now(),
            'due_date' => now()->addDays(7),
        ]);

        // Kunci: Stok baru berkurang saat disetujui admin
        $loan->book->decrement('stock');

        // --- UPDATE: KIRIM EMAIL NOTIFIKASI APPROVE ---
        try {
            Mail::to($loan->user->email)->send(new PinjamanDisetujui($loan));
        } catch (\Exception $e) {
            // Log error jika email gagal tapi proses tetap jalan
            Log::error('Gagal mengirim email approve peminjaman: ' . $e->getMessage());
        }
        // ----------------------------------------------

        return redirect()->back()->with('success', 'Peminjaman disetujui. Stok buku telah dikurangi dan notifikasi email terkirim.');
    }

    /**
     * =====================
     * ❌ TOLAK PEMINJAMAN
     * =====================
     */
    public function reject($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya permintaan pending yang bisa ditolak.');
        }

        $loan->update(['status' => 'ditolak']);

        return redirect()->back()->with('info', 'Peminjaman telah ditolak.');
    }

    /**
     * =====================
     * 🔄 TANDAI DIKEMBALIKAN
     * =====================
     */
    public function markReturned($id)
    {
        $loan = Loan::with('book')->findOrFail($id);

        if ($loan->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Buku tidak sedang dalam status dipinjam.');
        }

        $loan->update([
            'status' => 'dikembalikan',
            'returned_at' => now(),
        ]);

        // Tambahkan kembali stok buku karena sudah dikembalikan
        $loan->book->increment('stock');

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan & stok bertambah.');
    }

    /**
     * =====================
     * 🔥 TANDAI HILANG + DENDA
     * =====================
     */
    public function markLost($id)
    {
        $loan = Loan::with(['book', 'fine'])->findOrFail($id);

        if ($loan->status === 'hilang') {
            return redirect()->back()->with('info', 'Buku sudah ditandai hilang sebelumnya.');
        }

        // Update status peminjaman
        $loan->status = 'hilang';
        $loan->save();

        // Buat denda otomatis seharga buku
        Fine::create([
            'loan_id' => $loan->id,
            'user_id' => $loan->user_id,
            'amount'  => $loan->book->price ?? 50000, // Default 50rb jika harga buku kosong
            'reason'  => 'Buku hilang saat masa peminjaman',
            'status'  => 'belum_dibayar', 
        ]);

        return redirect()->route('admin.loans.index')
            ->with('success', 'Buku ditandai hilang & denda otomatis telah dibuat.');
    }

    /**
     * UPDATE JATUH TEMPO (Jika ada perpanjangan manual oleh admin)
     */
    public function updateDueDate(Request $request, $id)
    {
        $request->validate(['due_date' => 'required|date']);
        
        $loan = Loan::findOrFail($id);
        $loan->update(['due_date' => $request->due_date]);

        return redirect()->back()->with('success', 'Tanggal jatuh tempo berhasil diperbarui.');
    }
}