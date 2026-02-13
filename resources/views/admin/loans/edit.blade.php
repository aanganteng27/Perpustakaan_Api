@extends('admin.index')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-semibold">Edit Data Peminjaman</h2>

    <form method="POST" action="{{ route('admin.loans.update', $loan->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Peminjam</label>
            <input type="text" class="form-control" value="{{ $loan->user->name }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Buku</label>
            <input type="text" class="form-control" value="{{ $loan->book->title }}" disabled>
        </div>

        <div class="mb-3">
            <label for="loan_date" class="form-label fw-semibold">Tanggal Peminjaman</label>
            <input type="date" name="loan_date" id="loan_date" class="form-control"
                value="{{ old('loan_date', optional($loan->loan_date)->format('Y-m-d')) }}" required>
            @error('loan_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="return_date" class="form-label fw-semibold">Tanggal Pengembalian</label>
            <input type="date" name="return_date" id="return_date" class="form-control"
                value="{{ old('return_date', optional($loan->return_date)->format('Y-m-d')) }}">
            @error('return_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label fw-semibold">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="borrowed" {{ $loan->status == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                <option value="returned" {{ $loan->status == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
            </select>
            @error('status')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan Perubahan
        </button>
        <a href="{{ route('admin.loans.index') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
@endsection
