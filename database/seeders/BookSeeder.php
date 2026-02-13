<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        $books = [
            [
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'author' => 'J.K. Rowling',
                'year' => 1997,
                'stock' => 10,
                'isbn' => '9780747532699',
                'category' => 'Fantasy',
                'cover_url' => 'covers/harry_potter.jpg',
            ],
            [
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'year' => 1937,
                'stock' => 5,
                'isbn' => '9780618968633',
                'category' => 'Fantasy',
                'cover_url' => 'covers/the_hobbit.jpg',
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'year' => 1949,
                'stock' => 7,
                'isbn' => '9780451524935',
                'category' => 'Dystopian',
                'cover_url' => 'covers/1984.jpg',
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'year' => 1960,
                'stock' => 8,
                'isbn' => '9780060935467',
                'category' => 'Classic',
                'cover_url' => 'covers/mockingbird.jpg',
            ],
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'year' => 1813,
                'stock' => 4,
                'isbn' => '9780141439518',
                'category' => 'Romance',
                'cover_url' => 'covers/pride_prejudice.jpg',
            ],
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'year' => 1925,
                'stock' => 6,
                'isbn' => '9780743273565',
                'category' => 'Classic',
                'cover_url' => 'covers/gatsby.jpg',
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(
                ['isbn' => $book['isbn']],  // Cek berdasarkan ISBN
                $book                       // Update jika ada, buat baru jika tidak ada
            );
        }
    }
}
