<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengingatKembali;
use Carbon\Carbon;

class SendReturnReminder extends Command
{
    // Nama perintah yang akan dijalankan
    protected $signature = 'reminder:return-book';
    protected $description = 'Kirim email pengingat pengembalian buku H-1';

    public function handle()
    {
        // Cari pinjaman yang statusnya 'dipinjam' dan due_date-nya adalah besok
        $tomorrow = Carbon::tomorrow()->toDateString();
        
        $loans = Loan::with(['user', 'book'])
            ->where('status', 'dipinjam')
            ->whereDate('due_date', $tomorrow)
            ->get();

        $count = 0;
        foreach ($loans as $loan) {
            try {
                Mail::to($loan->user->email)->send(new PengingatKembali($loan));
                $count++;
            } catch (\Exception $e) {
                $this->error("Gagal kirim ke: " . $loan->user->email);
            }
        }

        $this->info("Berhasil mengirim $count email pengingat.");
    }
}