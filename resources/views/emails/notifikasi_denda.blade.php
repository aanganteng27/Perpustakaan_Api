<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; padding: 20px;">
    <div style="max-width: 500px; margin: auto; border: 2px solid #e74c3c; border-radius: 10px; padding: 20px;">
        <h2 style="color: #e74c3c;">Buku Kamu Terlambat! ⚠️</h2>
        <p>Halo <strong>{{ $loan->user->name }}</strong>,</p>
        <p>Buku <strong>{{ $loan->book->title }}</strong> seharusnya dikembalikan pada {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}.</p>
        
        <div style="background: #fdeaea; padding: 15px; border-radius: 5px; text-align: center;">
            <p style="margin: 0; font-size: 18px;">Total Denda Saat Ini:</p>
            <h1 style="margin: 10px 0; color: #e74c3c;">Rp {{ number_format($fineAmount, 0, ',', '.') }}</h1>
        </div>

        <p>Segera kembalikan buku ke perpustakaan untuk menghentikan akumulasi denda harian.</p>
        <hr>
        <p style="font-size: 12px; color: #888;">Sistem AyoBaca - Perpustakaan Digital</p>
    </div>
</body>
</html>