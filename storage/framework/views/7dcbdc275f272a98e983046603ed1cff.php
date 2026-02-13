<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="background-color: #f4f4f4; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div style="max-width: 500px; margin: auto; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        
        
        <div style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); padding: 20px; text-align: center; color: white;">
            <h2 style="margin: 0;">TIKET PEMINJAMAN</h2>
            <p style="font-size: 12px; opacity: 0.8;">Tunjukkan email ini ke petugas perpustakaan</p>
        </div>

        
        <div style="padding: 30px;">
            <div style="text-align: center; margin-bottom: 20px;">
                <small style="color: #888; text-transform: uppercase;">Kode Verifikasi</small>
                <h1 style="margin: 5px 0; color: #11998e; letter-spacing: 5px;">#<?php echo e($loan->id); ?><?php echo e(date('Hi')); ?></h1>
            </div>

            <table style="width: 100%; font-size: 14px; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px 0; color: #888;">Peminjam:</td>
                    <td style="padding: 10px 0; text-align: right; font-weight: bold;"><?php echo e($loan->user->name); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #888;">Judul Buku:</td>
                    <td style="padding: 10px 0; text-align: right; font-weight: bold;"><?php echo e($loan->book->title); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #888;">Tanggal Request:</td>
                    <td style="padding: 10px 0; text-align: right;"><?php echo e(date('d M Y')); ?></td>
                </tr>
            </table>

            
            <div style="margin-top: 30px; padding: 15px; background: #fff9db; border-left: 4px solid #fab005; font-size: 12px; color: #666;">
                <strong>Penting:</strong> Buku hanya akan diberikan jika Admin telah menyetujui (Approve) permintaan Anda di sistem.
            </div>
        </div>

        
        <div style="background: #f9fafb; padding: 15px; text-align: center; font-size: 10px; color: #aaa;">
            Email ini dikirim otomatis oleh sistem <?php echo e(config('app.name')); ?>.
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\AINANHAMMAL\perpustakaan-api\resources\views/emails/notifikasi_pinjam.blade.php ENDPATH**/ ?>