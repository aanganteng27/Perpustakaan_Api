@extends('layouts.admin')

@section('title', 'Edit Denda')

@section('content')
<style>
    /* Hero Header Style */
    .edit-header {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 25px rgba(5, 150, 105, 0.2);
    }

    /* Card Styling */
    .fine-edit-card {
        background: #ffffff;
        border: none;
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .form-section-title {
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.05em;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .form-section-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #f1f5f9;
        margin-left: 1rem;
    }

    /* Modern Input Styling */
    .form-control-modern {
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        font-weight: 500;
        color: #334155;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        background-color: #ffffff;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .form-control-modern:disabled {
        background-color: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }

    /* Custom Select Arrow */
    .form-select-modern {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%2364748b'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 12px;
    }

    /* Button Styling */
    .btn-save-custom {
        background: #059669;
        color: white;
        border: none;
        border-radius: 14px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-save-custom:hover {
        background: #047857;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(5, 150, 105, 0.2);
        color: white;
    }

    .btn-cancel-custom {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        border-radius: 14px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-cancel-custom:hover {
        background: #e2e8f0;
        color: #475569;
    }

    .info-label {
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        display: block;
    }
</style>

<div class="container py-4">
    {{-- Header Section --}}
    <div class="edit-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">Edit Data Denda</h2>
            <p class="mb-0 opacity-75">Sesuaikan nominal atau status pembayaran denda buku.</p>
        </div>
        <div class="d-none d-md-block">
            <i class="bi bi-pencil-square" style="font-size: 3rem; opacity: 0.3;"></i>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card fine-edit-card">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('admin.fines.update', $fine->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Section 1: Informasi Peminjaman --}}
                        <div class="form-section-title">Informasi Peminjaman</div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="info-label">Nama Peminjam</label>
                                <input type="text" class="form-control form-control-modern shadow-sm"
                                    value="{{ $fine->loan->user->name }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="info-label">ID Transaksi</label>
                                <input type="text" class="form-control form-control-modern shadow-sm"
                                    value="#{{ $fine->loan_id }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="info-label">Tanggal Pinjam</label>
                                <input type="text" class="form-control form-control-modern shadow-sm"
                                    value="{{ $fine->loan->borrowed_at ? \Carbon\Carbon::parse($fine->loan->borrowed_at)->format('d F Y') : '-' }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="info-label">Tanggal Kembali</label>
                                <input type="text" class="form-control form-control-modern shadow-sm"
                                    value="{{ $fine->loan->returned_at ? \Carbon\Carbon::parse($fine->loan->returned_at)->format('d F Y') : 'Belum Dikembalikan' }}" disabled>
                            </div>
                        </div>

                        {{-- Section 2: Detail Denda --}}
                        <div class="form-section-title">Detail Pembayaran</div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="amount" class="info-label text-primary">Jumlah Denda (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #e2e8f0;">Rp</span>
                                    <input type="number" name="amount" id="amount"
                                        class="form-control form-control-modern border-start-0 ps-1"
                                        style="border-radius: 0 12px 12px 0;"
                                        value="{{ old('amount', $fine->amount) }}" required>
                                </div>
                                @error('amount')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="info-label">Status Pembayaran</label>
                                <select name="status" id="status" class="form-select form-control-modern form-select-modern shadow-sm" required>
                                    <option value="belum_dibayar" {{ $fine->status == 'belum_dibayar' ? 'selected' : '' }}>
                                        🔴 Belum Dibayar
                                    </option>
                                    <option value="sudah_dibayar" {{ $fine->status == 'sudah_dibayar' ? 'selected' : '' }}>
                                        🟢 Sudah Dibayar (Lunas)
                                    </option>
                                </select>
                            </div>

                            <div class="col-12 mb-4">
                                <label for="payment_method" class="info-label">Metode Pembayaran</label>
                                <input type="text" name="payment_method" id="payment_method" 
                                    class="form-control form-control-modern shadow-sm"
                                    value="{{ old('payment_method', $fine->payment_method) }}" 
                                    placeholder="Contoh: Tunai / Transfer Bank / QRIS">
                            </div>
                        </div>

                        {{-- Section 3: Actions --}}
                        <div class="d-flex flex-wrap gap-3 mt-4 justify-content-end">
                            <a href="{{ route('admin.fines.index') }}" class="btn btn-cancel-custom px-4">
                                <i class="bi bi-x-lg me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-save-custom px-4">
                                <i class="bi bi-check2-circle me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection