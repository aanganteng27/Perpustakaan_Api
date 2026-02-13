<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; padding: 20px;">
    <div style="max-width: 500px; margin: auto; border: 1px solid #ddd; border-radius: 10px; padding: 20px;">
        <h2 style="color: #28a745;">Pinjaman Disetujui! ✅</h2>
        <p>Halo <strong><?php echo e($loan->user->name); ?></strong>,</p>
        <p>Permintaan pinjaman buku kamu telah disetujui oleh admin.</p>
        
        <table style="width: 100%; margin-bottom: 20px;">
            <tr><td>Buku</td><td>: <strong><?php echo e($loan->book->title); ?></strong></td></tr>
            <tr><td>Tgl Pinjam</td><td>: <?php echo e($loan->borrowed_at); ?></td></tr>
            <tr><td>Tgl Kembali</td><td>: <strong style="color: red;"><?php echo e($loan->due_date); ?></strong></td></tr>
        </table>

        <p>Silakan ambil buku di rak yang tersedia. Jangan sampai telat mengembalikan ya!</p>
        <hr>
        <p style="font-size: 12px; color: #888;">Sistem Perpustakaan AyoBaca</p>
    </div>
</body>
</html><?php /**PATH C:\Users\AINANHAMMAL\perpustakaan-api\resources\views/emails/pinjaman_disetujui.blade.php ENDPATH**/ ?>