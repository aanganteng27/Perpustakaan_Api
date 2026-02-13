<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PinjamanDisetujui extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;

    public function __construct($loan)
    {
        $this->loan = $loan;
    }

    public function build()
    {
        return $this->subject('PINJAMAN DISETUJUI: ' . $this->loan->book->title)
                    ->view('emails.pinjaman_disetujui');
    }
}