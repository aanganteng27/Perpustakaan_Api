<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifikasiDenda extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;
    public $fineAmount;

    public function __construct($loan, $fineAmount)
    {
        $this->loan = $loan;
        $this->fineAmount = $fineAmount;
    }

    public function build()
    {
        return $this->subject('PERINGATAN: Denda Keterlambatan Pengembalian Buku')
                    ->view('emails.notifikasi_denda');
    }
}