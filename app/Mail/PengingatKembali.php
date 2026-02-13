<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengingatKembali extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;

    public function __construct($loan)
    {
        $this->loan = $loan;
    }

    public function build()
    {
        return $this->subject('PENGINGAT: Besok Waktunya Kembalikan Buku!')
                    ->view('emails.pengingat_kembali');
    }
}