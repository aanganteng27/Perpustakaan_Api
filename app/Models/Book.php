<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * Kolom-kolom yang bisa diisi massal (mass assignment)
     * Pastikan semua kolom ini sudah ada di database Railway lu.
     */
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

    /**
     * Relasi: satu buku bisa dipinjam banyak kali (loan)
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * CATATAN PERBAIKAN:
     * Getter getCoverUrlAttribute dihapus karena konflik dengan logika di Blade index.
     * Sekarang sistem akan mengambil path asli dari database, 
     * dan file Blade lu yang akan menentukan format URL-nya.
     */
}