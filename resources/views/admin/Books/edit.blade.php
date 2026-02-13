@extends('layouts.admin')

@section('title', 'Edit Buku - ' . $book->title)

@section('content')
<style>
    /* Welcome/Header Card Style */
    .header-card {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 30px;
        padding: 2rem 2.5rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .header-card h2 {
        font-weight: 800;
        color: #ffffff;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .header-card p {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
    }

    /* Form Card Luxury */
    .card-luxury {
        border: none;
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .form-label {
        font-weight: 700;
        color: #475569;
        margin-bottom: 0.6rem;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        transition: all 0.3s;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    /* Preview Section */
    .preview-container {
        background: #f1f5f9;
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        border: 2px dashed #cbd5e1;
        transition: all 0.3s;
    }

    .img-preview {
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        max-width: 100%;
        height: 280px;
        object-fit: cover;
        margin-bottom: 15px;
    }

    .btn-save {
        background: #10b981;
        border: none;
        border-radius: 15px;
        padding: 12px 35px;
        font-weight: 700;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-save:hover {
        background: #059669;
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(16, 185, 129, 0.3);
    }

    .input-group-text {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #64748b;
        border-radius: 12px 0 0 12px !important;
    }
</style>

<div class="page-fade-in">
    <div class="header-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="display-6">Edit Informasi Buku</h2>
                <p class="mb-0 small">Perbarui detail koleksi "{{ $book->title }}" agar data tetap akurat.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.books.index') }}" class="btn btn-white bg-white text-dark px-4 py-2 shadow-sm fw-bold border-0 rounded-pill">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card card-luxury overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('admin.books.update', $book->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Judul Lengkap Buku</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                    placeholder="Contoh: Harry Potter and the Sorcerer's Stone" value="{{ old('title', $book->title) }}" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Penulis / Author</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" 
                                        value="{{ old('author', $book->author) }}" required style="border-radius: 0 12px 12px 0 !important;">
                                </div>
                                @error('author')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Nomor ISBN</label>
                                <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" 
                                    value="{{ old('isbn', $book->isbn) }}" required>
                                @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Kategori</label>
                                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                    <option value="Sains" {{ old('category', $book->category) == 'Sains' ? 'selected' : '' }}>Sains</option>
                                    <option value="Bisnis" {{ old('category', $book->category) == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
                                    <option value="Novel" {{ old('category', $book->category) == 'Novel' ? 'selected' : '' }}>Novel</option>
                                    <option value="Teknologi" {{ old('category', $book->category) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                    <option value="Fantasy" {{ old('category', $book->category) == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                                </select>
                                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3 mb-4">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" 
                                    value="{{ old('year', $book->year) }}">
                                @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3 mb-4">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                                    value="{{ old('stock', $book->stock) }}" min="0" required>
                                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-12 mb-0">
                                <label class="form-label">Deskripsi / Sinopsis</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                    rows="5" placeholder="Tuliskan deskripsi buku secara mendetail...">{{ old('description', $book->description) }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="sticky-top" style="top: 20px; z-index: 1;">
                            <label class="form-label">Visual Cover</label>
                            <div class="preview-container">
                                @php
                                    $coverSrc = $book->cover_url 
                                        ? (Str::startsWith($book->cover_url, 'http') ? $book->cover_url : asset('storage/' . $book->cover_url))
                                        : asset('images/placeholder.png');
                                @endphp
                                
                                <img src="{{ $coverSrc }}" id="imgPreview" alt="Cover Preview" class="img-preview">
                                
                                <div class="text-start mt-2">
                                    <label for="coverInput" class="small fw-bold text-muted mb-2 d-block">Ganti Cover (Opsional)</label>
                                    <input type="file" name="cover" id="coverInput" class="form-control form-control-sm">
                                    <div class="mt-2 text-center">
                                        <span class="badge bg-light text-dark fw-normal border">JPG, PNG, WEBP (Max: 2MB)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5" style="opacity: 0.05;">

                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i> Periksa kembali data sebelum menekan tombol simpan.</p>
                    <button type="submit" class="btn btn-primary btn-save px-5 text-white">
                        <i class="bi bi-cloud-arrow-up-fill me-2"></i> Update Data Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Live Preview Cover Script
    document.getElementById('coverInput').onchange = evt => {
        const [file] = document.getElementById('coverInput').files
        if (file) {
            const preview = document.getElementById('imgPreview');
            preview.src = URL.createObjectURL(file);
            preview.classList.add('fade-in');
        }
    }
</script>
@endsection