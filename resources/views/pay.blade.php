@extends('admin.index')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Pembayaran Denda</h2>

    <div class="card shadow">
        <div class="card-body">
            <p><strong>Nama Peminjam:</strong> {{ $fine->loan->user->name }}</p>
            <p><strong>Jumlah Denda:</strong> Rp{{ number_format($fine->amount, 0, ',', '.') }}</p>

            <form action="{{ route('admin.fines.processPayment', $fine->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label"><strong>Pilih Metode Pembayaran:</strong></label>

                    <div class="d-flex gap-3 flex-wrap">
                        @php
                            $methods = ['tunai' => 'Tunai 💵', 'transfer' => 'Transfer 💳', 'e-wallet' => 'E-Wallet 📱'];
                        @endphp

                        @foreach ($methods as $value => $label)
                        <label class="method-option form-check-label">
                            <input type="radio" name="payment_method" value="{{ $value }}" class="btn-check" required>
                            <div class="btn btn-outline-primary rounded-pill px-4 py-2">
                                {{ $label }}
                            </div>
                        </label>
                        @endforeach
                    </div>

                    @error('payment_method')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success mt-3">
                    <i class="bi bi-cash-coin"></i> Konfirmasi Pembayaran
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .method-option input[type="radio"]:checked + .btn {
        background-color: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
        box-shadow: 0 0 10px rgba(13, 110, 253, 0.6);
        transform: scale(1.05);
        transition: 0.3s ease-in-out;
    }

    .method-option .btn {
        transition: all 0.2s;
        cursor: pointer;
    }

    .method-option input[type="radio"] {
        display: none;
    }
</style>
@endsection
