@extends('layouts.admin')

@section('title', 'Daftar Peminjaman')

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

    /* Avatar & Image */
    .avatar-circle {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #334155, #1e293b);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-weight: 700;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .book-cover-mini {
        width: 45px;
        height: 65px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* FIX SEARCH BAR CONTRAST */
    .search-container {
        max-width: 550px;
        margin: 0 auto;
    }

    .search-wrapper .input-group {
        border-radius: 50px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.4);
        /* Dibuat sedikit lebih gelap transparan agar teks putih terbaca */
        background: rgba(0, 0, 0, 0.15) !important; 
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 5px;
    }

    .search-wrapper input {
        color: #ffffff !important;
        font-weight: 500;
    }

    .search-wrapper input::placeholder {
        color: rgba(255, 255, 255, 0.75) !important;
    }

    .btn-search-custom {
        background: #ffffff;
        color: #059669; /* Emerald 600 */
        font-weight: 700;
        border: none;
        border-radius: 50px !important;
        padding: 10px 25px;
        transition: all 0.3s;
    }

    .btn-search-custom:hover {
        background: #f0f0f0;
        transform: scale(1.03);
        color: #047857;
    }

    /* Custom Badge Colors */
    .bg-info-subtle { background-color: #e0f2fe !important; color: #0369a1 !important; }
    .bg-warning-subtle { background-color: #fef3c7 !important; color: #a16207 !important; }
    .bg-success-subtle { background-color: #dcfce7 !important; color: #15803d !important; }
    .bg-danger-subtle { background-color: #fee2e2 !important; color: #b91c1c !important; }
    .bg-secondary-subtle { background-color: #f1f5f9 !important; color: #475569 !important; }
</style>

<div class="page-fade-in">

    {{-- Header Section --}}
    <div class="header-card">
        <h2 class="display-6">📚 Management Peminjaman</h2>
        <p>Otorisasi permintaan, pantau sirkulasi buku secara real-time, dan kelola denda anggota perpustakaan.</p>

        {{-- Search Bar Update --}}
        <div class="search-container">
            <form method="GET" action="{{ route('admin.loans.index') }}" class="search-wrapper">
                <div class="input-group shadow-lg">
                    <span class="bg-transparent border-0 ps-3 d-flex align-items-center">
                        <i class="bi bi-search text-white opacity-75"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 bg-transparent text-white" 
                           placeholder="Ketik nama peminjam di sini..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-search-custom shadow-sm">
                        Cari Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="card glossy-card overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 premium-table">
                    <thead>
                        <tr>
                            <th class="ps-4">Peminjam</th>
                            <th>Info Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Manajemen Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($loans as $loan)
                        <tr class="table-row-luxury">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $loan->user->name }}</div>
                                        <small class="text-muted d-block">{{ $loan->user->email }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $loan->book->cover_url }}" class="book-cover-mini me-3">
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $loan->book->title }}</div>
                                        <small class="text-muted">Tersedia: {{ $loan->book->stock }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="text-dark fw-medium">
                                    <i class="bi bi-calendar-check me-1 text-primary"></i>
                                    {{ $loan->borrowed_at ? date('d M Y', strtotime($loan->borrowed_at)) : '---' }}
                                </span>
                            </td>

                            <td>
                                <span class="text-dark fw-medium">
                                    <i class="bi bi-calendar-x me-1 text-danger"></i>
                                    {{ $loan->due_date ? date('d M Y', strtotime($loan->due_date)) : '---' }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if($loan->status === 'pending')
                                    <span class="badge badge-glossy bg-info-subtle">
                                        <span class="spinner-grow spinner-grow-sm me-1" role="status"></span> Pending
                                    </span>
                                @elseif($loan->status === 'dipinjam')
                                    <span class="badge badge-glossy bg-warning-subtle">
                                        <i class="bi bi-book me-1"></i> Dipinjam
                                    </span>
                                @elseif($loan->status === 'dikembalikan')
                                    <span class="badge badge-glossy bg-success-subtle">
                                        <i class="bi bi-check2-all me-1"></i> Kembali
                                    </span>
                                @elseif($loan->status === 'ditolak')
                                    <span class="badge badge-glossy bg-secondary-subtle">
                                        <i class="bi bi-slash-circle me-1"></i> Ditolak
                                    </span>
                                @elseif($loan->status === 'hilang')
                                    <span class="badge badge-glossy bg-danger-subtle">
                                        <i class="bi bi-exclamation-triangle me-1"></i> Hilang
                                    </span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm rounded-3">
                                    @if($loan->status === 'pending')
                                        <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button class="btn btn-success btn-sm px-3 border-0 rounded-start-3" title="Setujui">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.loans.reject', $loan->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button class="btn btn-outline-danger btn-sm px-3 border-0 rounded-end-3" title="Tolak">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>

                                    @elseif($loan->status === 'dipinjam')
                                        <button class="btn btn-warning btn-sm px-3 border-0 text-white rounded-start-3" 
                                                data-bs-toggle="modal" data-bs-target="#editDueDateModal"
                                                data-id="{{ $loan->id }}" data-date="{{ $loan->due_date }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('admin.loans.markReturned', $loan->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <button class="btn btn-success btn-sm px-3 border-0">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.loans.markLost', $loan->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <button class="btn btn-danger btn-sm px-3 border-0 rounded-end-3">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-light btn-sm px-4 disabled border-0 text-muted rounded-3">Selesai</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox text-muted opacity-25" style="font-size: 5rem;"></i>
                                    <p class="mt-3 text-muted fw-medium">Tidak ada aktivitas peminjaman yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Modern --}}
<div class="modal fade" id="editDueDateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="editDueDateForm" class="modal-content border-0 shadow-lg rounded-4">
            @csrf @method('PUT')
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-calendar-event me-2 text-success"></i>Perpanjang Pinjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <label class="form-label text-muted small fw-bold">TANGGAL JATUH TEMPO BARU</label>
                <input type="date" name="due_date" id="dueDateInput" class="form-control form-control-lg rounded-3 border-0 bg-light" required>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success rounded-pill px-4 shadow text-white">Update Tanggal</button>
            </div>
        </form>
    </div>
</div>

<script>
    const editModal = document.getElementById('editDueDateModal')
    if(editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget
            const id = button.getAttribute('data-id')
            const date = button.getAttribute('data-date')
            
            document.getElementById('dueDateInput').value = date.split(' ')[0]
            document.getElementById('editDueDateForm').action = `/admin/loans/${id}/update-due-date`
        })
    }
</script>
@endsection