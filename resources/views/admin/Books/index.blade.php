@extends('layouts.admin')

@section('title', 'Daftar Buku')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<style>
    /* Welcome Card Style - Biar matching sama Dashboard */
    .welcome-card {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 30px;
        padding: 2rem 2.5rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .welcome-card h2 {
        font-weight: 800;
        color: #ffffff;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        margin-bottom: 0.2rem;
    }

    .welcome-card p {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Table Styling */
    .table-container {
        background: #ffffff;
        border-radius: 24px;
        padding: 25px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0,0,0,0.02);
    }

    .custom-table thead {
        background: #f8fafc;
        border-bottom: 2px solid #edf2f7;
    }

    .custom-table th {
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 18px 15px !important;
        border: none;
    }

    .book-cover {
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .book-cover:hover {
        transform: scale(1.1) rotate(2deg);
    }

    .badge-category {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #dcfce7;
        padding: 6px 14px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.7rem;
    }

    .btn-action {
        border-radius: 12px;
        transition: all 0.3s;
        padding: 8px 15px;
        font-size: 0.85rem;
    }

    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }

    /* Override Link Pagination */
    .pagination {
        gap: 5px;
    }
    .page-item .page-link {
        border-radius: 10px !important;
        border: none;
        color: #64748b;
        font-weight: 600;
    }
    .page-item.active .page-link {
        background-color: #10b981;
    }
</style>

<div class="page-fade-in">
    <div class="welcome-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="display-6">Daftar Koleksi Buku</h2>
                <p class="mb-0 small">Kelola dan pantau seluruh ketersediaan buku perpustakaan Anda.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.books.create') }}" class="btn btn-white bg-white text-success px-4 py-2 shadow-sm fw-800 border-0 rounded-pill">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Buku Baru
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 15px; border-left: 6px solid #10b981 !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div>
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-container">
        @if($books->count())
        <div class="table-responsive">
            <table class="table custom-table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="text-center" width="60">NO.</th>
                        <th class="text-center">COVER</th>
                        <th>INFORMASI BUKU</th>
                        <th class="text-center">ISBN</th>
                        <th>DESKRIPSI</th>
                        <th class="text-center">KATEGORI</th>
                        <th class="text-center">STOK</th>
                        <th class="text-center" width="120">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $index => $book)
                    <tr>
                        <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                        <td class="text-center">
                            @php
                                $cover = $book->cover_url;
                                if ($cover) {
                                    $coverSrc = Str::startsWith($cover, 'http') 
                                        ? $cover 
                                        : asset('storage/' . $cover);
                                } else {
                                    $coverSrc = asset('images/placeholder.png');
                                }
                            @endphp
                            <img 
                                src="{{ $coverSrc }}" 
                                alt="Cover {{ $book->title }}" 
                                width="50" height="70" 
                                class="book-cover"
                                style="object-fit: cover;"
                            >
                        </td>
                        <td>
                            <div class="fw-800 text-dark mb-0">{{ $book->title }}</div>
                            <div class="text-muted small"><i class="bi bi-person-fill me-1"></i>{{ $book->author }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border fw-normal">{{ $book->isbn ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="small text-muted" title="{{ $book->description }}">
                                {{ Str::limit($book->description, 45, '...') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge-category">
                                {{ $book->category ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($book->stock <= 5)
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 rounded-pill fw-bold">{{ $book->stock }}</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill fw-bold">{{ $book->stock }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-warning btn-action text-white shadow-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger btn-action shadow-sm" type="submit" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 px-2">
            <div class="text-muted small fw-600">
                Menampilkan {{ $books->firstItem() }} sampai {{ $books->lastItem() }} dari {{ $books->total() }} buku
            </div>
            <div>
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        </div>

        @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bi bi-book-half text-muted opacity-25" style="font-size: 4rem;"></i>
            </div>
            <h5 class="text-muted fw-bold">Belum Ada Koleksi</h5>
            <p class="text-muted small">Silakan tambahkan buku baru untuk mulai mengelola perpustakaan.</p>
        </div>
        @endif
    </div>
</div>
@endsection