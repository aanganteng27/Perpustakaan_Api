<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookAdminController extends Controller
{
    public function index()
    {
        $books = Book::paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|unique:books',
            'year' => 'nullable|integer',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $coverUrl = null;
        if ($request->hasFile('cover')) {
            // Menyimpan file dan mengambil path aslinya saja
            $coverUrl = $request->file('cover')->store('covers', 'public');
        }

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'year' => $request->year,
            'category' => $request->category,
            'stock' => $request->stock,
            'description' => $request->description,
            'cover_url' => $coverUrl
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|unique:books,isbn,' . $id,
            'year' => 'nullable|integer',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Mengambil nilai asli dari database (bukan dari Getter) untuk pengecekan
        $coverUrl = $book->getRawOriginal('cover_url');
        
        if ($request->hasFile('cover')) {
            $coverUrl = $request->file('cover')->store('covers', 'public');
        }

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'year' => $request->year,
            'category' => $request->category,
            'stock' => $request->stock,
            'description' => $request->description,
            'cover_url' => $coverUrl
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }
}