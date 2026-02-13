@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0" style="background: #f8fafc; min-height: 100vh; font-family: 'Inter', sans-serif;">
    
    {{-- HEADER SECTION: Green Gradient consistent with Loans Page --}}
    <div style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); padding: 3rem 2.5rem 6rem 2.5rem; position: relative;">
        <div class="d-flex justify-content-between align-items-center position-relative">
            <div>
                <h2 style="font-weight: 800; color: #ffffff; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 0.5rem;">
                    <i class="fas fa-users-cog me-2"></i> Arsitektur Pengguna
                </h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 1.1rem;">Matriks otorisasi personil dalam ekosistem perpustakaan digital.</p>
            </div>
            <div class="stats-badge-modern">
                <span style="font-size: 0.7rem; display: block; color: rgba(255,255,255,0.7); font-weight: 700; text-transform: uppercase;">Total Entitas</span>
                <span style="font-size: 2.2rem; font-weight: 800; color: #ffffff; line-height: 1;">{{ $users->count() }}</span>
            </div>
        </div>
    </div>

    {{-- CONTENT SECTION: White Card Table --}}
    <div class="container-fluid" style="margin-top: -4rem; padding: 0 2.5rem 3rem 2.5rem;">
        
        @if(session('success'))
            <div class="alert alert-custom-success animate__animated animate__fadeInDown alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-3 fa-lg"></i>
                    <div>
                        <strong>Sistem Terupdate</strong>
                        <div class="small">{{ session('success') }}</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- SEARCH BAR: Matching Loans Page Style --}}
        <div class="search-wrapper mb-4 animate__animated animate__fadeInUp">
            <div class="input-group-modern">
                <input type="text" id="userSearch" class="form-control" placeholder="Cari nama peminjam atau email...">
                <button class="btn-search-modern">
                    <i class="fas fa-search me-2"></i> Cari Data
                </button>
            </div>
        </div>

        {{-- TABLE CARD: White Style --}}
        <div class="table-card-white animate__animated animate__fadeIn">
            <div class="table-responsive">
                <table class="table custom-light-table" id="userTable">
                    <thead>
                        <tr>
                            <th class="text-center">Profil</th>
                            <th>Identitas Personil</th>
                            <th>Kontak Otorisasi</th>
                            <th class="text-center">Status Akses</th>
                            <th class="text-center">Tanggal Gabung</th>
                            <th class="text-center">Manajemen Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="text-center align-middle">
                                @if($user->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" class="user-avatar" alt="User">
                                @else
                                    <div class="user-avatar-placeholder">
                                        <span class="fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <span class="badge {{ (isset($user->role) && $user->role == 'ADMIN') ? 'bg-warning' : 'bg-light text-dark' }} border" style="font-size: 0.7rem;">
                                    {{ $user->role ?? 'USER' }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <div class="text-muted small">
                                    <i class="far fa-envelope me-1 text-primary"></i> {{ $user->email }}
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                @if($user->is_active)
                                    <span class="badge-status verified">
                                        <i class="fas fa-check-circle me-1"></i> Terverifikasi
                                    </span>
                                @else
                                    <span class="badge-status pending">
                                        <i class="fas fa-clock me-1"></i> Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="text-center align-middle text-muted small">
                                <i class="far fa-calendar-alt me-1"></i> {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center gap-2">
                                    @if(!$user->is_active)
                                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success btn-action" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus personil ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-action" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                <p>Tidak ada data personil ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium White Theme Styles */
    .stats-badge-modern {
        background: rgba(255, 255, 255, 0.2);
        padding: 1rem 2rem;
        border-radius: 15px;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        text-align: right;
    }

    .input-group-modern {
        background: #ffffff;
        padding: 0.5rem;
        border-radius: 12px;
        display: flex;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
    }

    .input-group-modern input {
        border: none;
        padding-left: 1.5rem;
        font-size: 0.95rem;
    }

    .input-group-modern input:focus { box-shadow: none; }

    .btn-search-modern {
        background: #11998e;
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.3s;
    }

    .table-card-white {
        background: #ffffff;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
    }

    .custom-light-table thead th {
        color: #64748b;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        border-bottom: 2px solid #f1f5f9;
        padding: 1.2rem;
    }

    .custom-light-table tbody tr {
        transition: 0.2s;
        border-bottom: 1px solid #f8fafc;
    }

    .custom-light-table tbody tr:hover { background: #f8fafc; }

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }

    .user-avatar-placeholder {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        background: #11998e;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .badge-status {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-status.verified { background: #ecfdf5; color: #10b981; }
    .badge-status.pending { background: #fff7ed; color: #f59e0b; }

    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    .alert-custom-success {
        background: #ffffff;
        border-left: 5px solid #10b981;
        color: #334155;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
</style>

<script>
document.getElementById('userSearch').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#userTable tbody tr');
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection