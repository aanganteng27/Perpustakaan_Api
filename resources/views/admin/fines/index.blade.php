@extends('layouts.admin')

@section('title', 'Manajemen Denda')

@section('content')
<style>
    /* Header Card Style - Glassmorphism Hijau */
    .header-card {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 30px;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .header-card h2 {
        font-weight: 800;
        color: #ffffff;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        margin-bottom: 0.5rem;
        letter-spacing: -1px;
    }

    .header-card p {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
        max-width: 600px;
        margin: 0 auto 1.5rem auto;
    }

    /* Search & Filter Container */
    .filter-container {
        max-width: 750px;
        margin: 0 auto;
    }

    .filter-wrapper {
        background: rgba(0, 0, 0, 0.15) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 50px;
        padding: 6px;
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .filter-wrapper input, .filter-wrapper select {
        color: #ffffff !important;
        background: transparent !important;
        border: none !important;
        font-weight: 500;
        box-shadow: none !important;
    }

    /* CUSTOM SELECT ARROW - Membuat tanda panah putih */
    .filter-wrapper select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 1rem center !important;
        background-size: 12px !important;
        padding-right: 2.5rem !important;
        cursor: pointer;
    }

    .filter-wrapper input::placeholder {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    .filter-wrapper select option {
        color: #333;
        background: #fff;
    }

    .btn-filter-custom {
        background: #ffffff;
        color: #059669;
        font-weight: 700;
        border-radius: 50px !important;
        padding: 10px 25px;
        transition: all 0.3s;
        border: none;
    }

    .btn-filter-custom:hover {
        background: #f0f0f0;
        transform: scale(1.03);
        color: #047857;
    }

    /* Premium Table Styling */
    .premium-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 20px 15px;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-row-luxury {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 1px solid #f1f5f9;
    }

    .table-row-luxury:hover {
        background: #fdfdfd;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.03);
        z-index: 2;
        position: relative;
    }

    /* Glossy Components */
    .glossy-card {
        background: #ffffff;
        border: none;
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
    }

    .badge-glossy {
        font-weight: 700;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.75rem;
    }

    /* Avatar & Icons */
    .avatar-circle {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #64748b, #334155);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-weight: 700;
    }

    /* Custom Badge Colors */
    .bg-success-subtle { background-color: #dcfce7 !important; color: #15803d !important; }
    .bg-warning-subtle { background-color: #fef3c7 !important; color: #a16207 !important; }
</style>

<div class="page-fade-in">

    {{-- Header Section --}}
    <div class="header-card">
        <h2 class="display-6">💸 Manajemen Denda</h2>
        <p>Pantau status tunggakan, verifikasi pembayaran denda, dan kelola histori transaksi anggota secara efisien.</p>

        {{-- Search & Filter Update --}}
        <div class="filter-container">
            <form method="GET" action="" class="filter-wrapper shadow-lg">
                <div class="input-group">
                    <span class="bg-transparent border-0 ps-3 d-flex align-items-center">
                        <i class="bi bi-search text-white opacity-75"></i>
                    </span>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nama peminjam..." value="{{ request('search') }}">
                    
                    <div class="vr mx-2 bg-white opacity-25"></div>

                    {{-- Select dengan tanda panah kustom --}}
                    <select name="status" class="form-select" style="max-width: 180px;">
                        <option value="">Semua Status</option>
                        <option value="belum_dibayar" {{ request('status') === 'belum_dibayar' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="sudah_dibayar" {{ request('status') === 'sudah_dibayar' ? 'selected' : '' }}>Lunas</option>
                    </select>

                    <button type="submit" class="btn btn-filter-custom shadow-sm ms-2">
                        Filter Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Main Content Section --}}
    <div class="card glossy-card overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 premium-table">
                    <thead>
                        <tr>
                            <th class="ps-4">Peminjam</th>
                            <th>Info Buku</th>
                            <th class="text-center">Jumlah Denda</th>
                            <th class="text-center">Status Pembayaran</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($fines as $fine)
                        <tr class="table-row-luxury">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        {{ strtoupper(substr($fine->loan->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $fine->loan->user->name ?? '-' }}</div>
                                        <small class="text-muted">ID Pinjam: #{{ $fine->loan_id }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="fw-semibold text-dark">{{ $fine->loan->book->title ?? '-' }}</div>
                                <small class="text-muted">{{ $fine->loan->book->author ?? '-' }}</small>
                            </td>

                            <td class="text-center">
                                <span class="fw-bold text-dark">
                                    Rp{{ number_format($fine->amount, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if ($fine->status === 'sudah_dibayar')
                                    <span class="badge badge-glossy bg-success-subtle">
                                        <i class="bi bi-check-circle-fill me-1"></i> Lunas
                                    </span>
                                @else
                                    <span class="badge badge-glossy bg-warning-subtle">
                                        <i class="bi bi-clock-history me-1"></i> Belum Lunas
                                    </span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm rounded-3">
                                    @if ($fine->status === 'belum_dibayar')
                                        <a href="{{ route('admin.fines.pay', $fine->id) }}"
                                           class="btn btn-success btn-sm px-3 border-0 rounded-start-3" title="Bayar Sekarang">
                                            <i class="bi bi-credit-card"></i>
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('admin.fines.edit', $fine->id) }}"
                                       class="btn btn-outline-warning btn-sm px-3 border-0 {{ $fine->status === 'sudah_dibayar' ? 'rounded-3' : 'rounded-end-3' }}" 
                                       title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-cash-stack text-muted opacity-25" style="font-size: 5rem;"></i>
                                    <p class="mt-3 text-muted fw-medium">Tidak ada data denda ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $fines->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection