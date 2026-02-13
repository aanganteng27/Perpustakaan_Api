<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use App\Models\Fine;
use App\Mail\NotifikasiDenda;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AutoFineCalculation extends Command
{
    protected $signature = 'fine:calculate';
    protected $description = 'Cek keterlambatan dan kirim email denda';

    public function handle()
    {
        // Cari pinjaman yang sudah lewat jatuh tempo dan belum dikembalikan
        $overdueLoans = Loan::with(['user', 'book'])
            ->where('status', 'dipinjam')
            ->where('due_date', '<', Carbon::today())
            ->get();

        foreach ($overdueLoans as $loan) {
            $dueDate = Carbon::parse($loan->due_date);
            $today = Carbon::today();
            $daysLate = $today->diffInDays($dueDate);
            
            // Misal denda 2000 per hari
            $fineAmount = $daysLate * 2000;

            // Update atau Create data denda di tabel fines
            Fine::updateOrCreate(
                ['loan_id' => $loan->id],
                [
                    'user_id' => $loan->user_id,
                    'amount' => $fineAmount,
                    'reason' => "Terlambat $daysLate hari",
                    'status' => 'belum_dibayar'
                ]
            );

            // Kirim email notifikasi
            try {
                Mail::to($loan->user->email)->send(new NotifikasiDenda($loan, $fineAmount));
            } catch (\Exception $e) {
                $this->error("Gagal kirim denda ke: " . $loan->user->email);
            }
        }

        $this->info("Proses denda selesai.");
    }
}