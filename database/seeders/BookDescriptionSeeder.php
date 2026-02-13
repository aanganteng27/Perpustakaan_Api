<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookDescriptionSeeder extends Seeder
{
    public function run()
    {
        Book::where('id', 1)->update([
            'description' => 'Buku fantasi klasik karya J.K. Rowling tentang Harry Potter.'
        ]);
        Book::where('id', 2)->update([
            'description' => 'Buku fantasi karya J.R.R. Tolkien tentang perjalanan Bilbo Baggins.'
        ]);
        Book::where('id', 3)->update([
            'description' => 'Novel distopia karya George Orwell yang menceritakan pengawasan totaliter.'
        ]);
        Book::where('id', 4)->update([
            'description' => 'Klasik Amerika karya Harper Lee tentang keadilan dan rasisme.'
        ]);
        Book::where('id', 5)->update([
            'description' => 'Romansa klasik karya Jane Austen tentang cinta dan keluarga.'
        ]);
        Book::where('id', 6)->update([
            'description' => 'Novel klasik karya F. Scott Fitzgerald tentang mimpi Amerika.'
        ]);
    }
}
