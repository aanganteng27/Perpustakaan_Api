<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PembayaranDendaBerhasil extends Mailable
{
    use Queueable, SerializesModels;

    public $fine;

    public function __construct($fine)
    {
        $this->fine = $fine;
    }

    public function build()
    {
        return $this->subject('KUITANSI DIGITAL: Pembayaran Denda AyoBaca Berhasil')
                    ->view('emails.pembayaran_denda_berhasil');
    }
}