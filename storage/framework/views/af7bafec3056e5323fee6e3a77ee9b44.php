<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; padding: 20px;">
    <div style="max-width: 500px; margin: auto; border: 1px solid #f39c12; border-radius: 10px; padding: 20px;">
        <h2 style="color: #e67e22;">Halo <?php echo e($loan->user->name); ?>! 👋</h2>
        <p>Cuma mau ingetin nih, buku yang kamu pinjam harus dikembalikan **besok**.</p>
        
        <div style="background: #f9f9f9; padding: 15px; border-radius: 5px;">
            <p style="margin: 0;">📖 <strong><?php echo e($loan->book->title); ?></strong></p>
            <p style="margin: 5px 0 0 0; color: #e74c3c;">📅 Jatuh Tempo: <?php echo e(\Carbon\Carbon::parse($loan->due_date)->format('d M Y')); ?></p>
        </div>

        <p>Jangan sampai telat ya, daripada kena denda kan lumayan uangnya buat jajan. Hehe.</p>
        <hr>
        <p style="font-size: 12px; color: #888;">Sistem AyoBaca - Perpustakaan Digital</p>
    </div>
</body>
</html><?php /**PATH C:\Users\AINANHAMMAL\perpustakaan-api\resources\views/emails/pengingat_kembali.blade.php ENDPATH**/ ?>