@extends('layouts.admin')

@section('title', 'Tambah Buku Baru')

@section('content')
<style>
    /* Header Card Style - Glassmorphism */
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

    /* Luxury Card Form */
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
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    /* Upload & Preview Section */
    .preview-container {
        background: #f1f5f9;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        border: 2px dashed #cbd5e1;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: all 0.3s ease;
    }

    .img-preview {
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        max-width: 100%;
        max-height: 320px;
        object-fit: cover;
        display: none;
        margin-bottom: 15px;
    }

    .placeholder-icon {
        font-size: 5rem;
        color: #cbd5e1;
        margin-bottom: 10px;
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
                <h2 class="display-6">Tambah Buku Baru</h2>
                <p class="mb-0 small">Inputkan data buku secara lengkap untuk menambah koleksi perpustakaan.</p>
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
            <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Judul Buku</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                    placeholder="Masukkan judul lengkap buku..." value="{{ old('title') }}" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Penulis / Author</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-plus-fill"></i></span>
                                    <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" 
                                        placeholder="Nama penulis" value="{{ old('author') }}" required style="border-radius: 0 12px 12px 0 !important;">
                                </div>
                                @error('author')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Nomor ISBN</label>
                                <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" 
                                    placeholder="Contoh: 978-602-..." value="{{ old('isbn') }}" required>
                                @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Kategori</label>
                                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="Sains" {{ old('category') == 'Sains' ? 'selected' : '' }}>Sains</option>
                                    <option value="Bisnis" {{ old('category') == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
                                    <option value="Novel" {{ old('category') == 'Novel' ? 'selected' : '' }}>Novel</option>
                                    <option value="Teknologi" {{ old('category') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                    <option value="Fantasy" {{ old('category') == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                                </select>
                                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3 mb-4">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" 
                                    placeholder="2024" value="{{ old('year') }}">
                                @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3 mb-4">
                                <label class="form-label">Stok Awal</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                                    value="{{ old('stock', 0) }}" min="0" required>
                                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-12 mb-0">
                                <label class="form-label">Deskripsi Buku</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                    rows="5" placeholder="Tuliskan sinopsis singkat mengenai buku ini...">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="sticky-top" style="top: 20px; z-index: 1;">
                            <label class="form-label">Upload Cover</label>
                            <div class="preview-container" id="dropzone">
                                <i class="bi bi-cloud-arrow-up placeholder-icon" id="placeholderIcon"></i>
                                <img src="#" id="imgPreview" alt="Preview Cover" class="img-preview">
                                <p class="small text-muted mb-3" id="previewText">Tarik gambar ke sini atau klik pilih file</p>
                                
                                <div class="w-100">
                                    <input type="file" name="cover" id="coverInput" class="form-control form-control-sm @error('cover') is-invalid @enderror">
                                    <div class="mt-2 text-center">
                                        <span class="badge bg-white text-muted fw-normal border">JPG, PNG, WEBP (Max 2MB)</span>
                                    </div>
                                    @error('cover')<div class="invalid-feedback mt-2">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5" style="opacity: 0.05;">

                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i> Data yang Anda masukkan akan langsung tersimpan di sistem.</p>
                    <button type="submit" class="btn btn-success btn-save px-5 text-white">
                        <i class="bi bi-plus-lg me-2"></i> Daftarkan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Live Image Preview Logic
    document.getElementById('coverInput').onchange = evt => {
        const [file] = document.getElementById('coverInput').files
        if (file) {
            const preview = document.getElementById('imgPreview');
            const placeholder = document.getElementById('placeholderIcon');
            const text = document.getElementById('previewText');
            
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            preview.classList.add('page-fade-in'); // Trigger animation
            
            placeholder.style.display = 'none';
            text.innerText = 'File: ' + file.name;
        }
    }
</script>
@endsection