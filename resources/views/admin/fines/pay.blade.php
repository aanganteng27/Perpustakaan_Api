@extends('layouts.admin')

@section('title', 'Proses Pembayaran Denda')

@section('content')
<style>
    /* Hero Header Style */
    .pay-header {
        background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
        text-align: center;
    }

    /* Card Styling */
    .payment-card {
        background: #ffffff;
        border: none;
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .summary-box {
        background: #f8fafc;
        border-radius: 20px;
        padding: 20px;
        border: 1px dashed #cbd5e1;
    }

    /* Method Option Styling */
    .method-option {
        flex: 1;
        min-width: 140px;
    }

    .method-option input[type="radio"] {
        display: none;
    }

    .method-card {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: block;
        height: 100%;
    }

    .method-card:hover {
        border-color: #3b82f6;
        background: #f0f7ff;
        transform: translateY(-3px);
    }

    .method-option input[type="radio"]:checked + .method-card {
        border-color: #3b82f6;
        background: #eff6ff;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.1);
    }

    .method-icon {
        font-size: 1.5rem;
        margin-bottom: 8px;
        display: block;
    }

    .method-label {
        font-weight: 700;
        color: #334155;
        font-size: 0.9rem;
    }

    /* Confirm Button */
    .btn-confirm-pay {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 15px 40px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-confirm-pay:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 25px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .total-amount {
        font-size: 2rem;
        font-weight: 800;
        color: #ef4444;
        letter-spacing: -1px;
    }
</style>

<div class="container py-4">
    {{-- Header --}}
    <div class="pay-header">
        <h2 class="fw-bold mb-2">Konfirmasi Pembayaran</h2>
        <p class="mb-0 opacity-90">Selesaikan transaksi denda untuk mengaktifkan kembali akses peminjaman anggota.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card payment-card">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Summary Section --}}
                    <div class="summary-box mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fw-medium">Nama Peminjam</span>
                            <span class="fw-bold text-dark">{{ $fine->loan->user->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted fw-medium">Total Tagihan Denda</span>
                        </div>
                        <div class="total-amount mt-1">
                            Rp{{ number_format($fine->amount, 0, ',', '.') }}
                        </div>
                    </div>

                    <hr class="my-4 opacity-50">

                    {{-- Form Section --}}
                    <form action="{{ route('admin.fines.processPayment', $fine->id) }}" method="POST">
                        @csrf

                        <div class="mb-5">
                            <label class="form-label d-block text-center fw-bold text-dark mb-4">
                                <i class="bi bi-wallet2 me-2 text-primary"></i> Pilih Metode Pembayaran
                            </label>
                            
                            <div class="d-flex gap-3 flex-wrap justify-content-center">
                                @php
                                    $methods = [
                                        'tunai' => ['label' => 'Tunai', 'icon' => '💵'],
                                        'transfer' => ['label' => 'Transfer', 'icon' => '💳'],
                                        'e-wallet' => ['label' => 'E-Wallet', 'icon' => '📱']
                                    ];
                                @endphp

                                @foreach ($methods as $value => $data)
                                    <label class="method-option">
                                        <input type="radio" name="payment_method" value="{{ $value }}" required>
                                        <div class="method-card">
                                            <span class="method-icon">{{ $data['icon'] }}</span>
                                            <span class="method-label">{{ $data['label'] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            @error('payment_method')
                                <div class="text-danger text-center mt-3 small fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-confirm-pay w-100 mb-3">
                                <i class="bi bi-shield-check me-2"></i> Konfirmasi & Bayar Lunas
                            </button>
                            
                            <a href="{{ route('admin.fines.index') }}" class="btn btn-link text-muted text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Denda
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Keamanan Info --}}
            <div class="mt-4 text-center">
                <p class="text-muted small">
                    <i class="bi bi-lock-fill me-1"></i> Pembayaran akan diverifikasi otomatis oleh sistem.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection