<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Kolom-kolom yang bisa diisi massal (mass assignment)
    protected $fillable = [
        'title',        // Judul buku
        'author',       // Penulis buku
        'isbn',         // Nomor ISBN buku
        'year',         // Tahun terbit
        'category',     // Kategori buku
        'stock',        // Stok buku tersedia
        'cover_url',    // URL atau path gambar cover buku
        'description',  // Deskripsi buku
    ];

    // Relasi: satu buku bisa dipinjam banyak kali (loan)
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // Getter otomatis untuk cover URL
    public function getCoverUrlAttribute($value)
    {
        if (!$value) {
            return url('/images/default-book.png'); // fallback jika tidak ada gambar
        }

        // Ambil nama file saja agar tidak double URL
        $filename = basename($value);

        // Buat URL lengkap menuju folder storage/covers
        return asset('storage/covers/' . $filename);
    }
}
