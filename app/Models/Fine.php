<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Loan;
use App\Models\User;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'user_id',
        'amount',
        'status',
        'reason',
    ];

    // Relasi ke Loan
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    // 🔥 RELASI KE USER (WAJIB)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
