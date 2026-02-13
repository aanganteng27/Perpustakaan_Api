<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Menampilkan daftar semua buku.
     * * Note: Tidak perlu mapping URL manual di sini karena Model Book 
     * sudah memiliki Accessor 'getCoverUrlAttribute' yang otomatis 
     * mengubah path database menjadi full URL asset.
     */
    public function index()
    {
        // Mengambil semua data buku
        $books = Book::all();

        // Langsung return sebagai JSON
        return response()->json($books);
    }
}