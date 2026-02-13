<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Fine;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Halaman Dashboard Admin
    public function dashboard()
    {
        // Total buku
        $totalBooks = Book::count();

        // Peminjaman hari ini
        $today = Carbon::today()->toDateString();
        $borrowToday = Loan::whereDate('borrowed_at', $today)->count();

        // Total denda belum dibayar
        $totalFines = Fine::where('status', 'belum_dibayar')->sum('amount');

        return view('admin', compact('totalBooks', 'borrowToday', 'totalFines')); // resources/views/admin.blade.php
    }

    // Data statistik peminjaman untuk grafik (JSON)
    public function loanStats()
    {
        // Ambil data jumlah peminjaman per hari (7 hari terakhir)
        $stats = Loan::select(
                DB::raw("DATE(borrowed_at) as date"),
                DB::raw("COUNT(*) as count")
            )
            ->where('borrowed_at', '>=', Carbon::today()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data agar lengkap 7 hari terakhir
        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $key = Carbon::today()->subDays($i)->format('Y-m-d');
            $days->put($key, 0);
        }

        foreach ($stats as $item) {
            $days[$item->date] = $item->count;
        }

        return response()->json(
            $days->map(function ($value, $key) {
                return ['date' => $key, 'count' => $value];
            })->values()
        );
    }
}
