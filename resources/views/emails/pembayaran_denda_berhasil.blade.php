<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; padding: 20px; background-color: #f9f9f9;">
    <div style="max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; border: 1px solid #ddd;">
        <div style="text-align: center; border-bottom: 2px dashed #eee; padding-bottom: 20px;">
            <h2 style="color: #27ae60;">PEMBAYARAN DITERIMA ✅</h2>
            <p>Terima kasih telah melunasi denda perpustakaan kamu.</p>
        </div>

        <div style="padding: 20px 0;">
            <table style="width: 100%;">
                <tr>
                    <td style="color: #888;">ID Transaksi:</td>
                    <td style="text-align: right;">#FIN-{{ $fine->id }}</td>
                </tr>
                <tr>
                    <td style="color: #888;">Metode Bayar:</td>
                    <td style="text-align: right; text-transform: uppercase;">{{ $fine->payment_method }}</td>
                </tr>
                <tr>
                    <td style="color: #888;">Tanggal Bayar:</td>
                    <td style="text-align: right;">{{ \Carbon\Carbon::parse($fine->paid_at)->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <td colspan="2"><hr style="border: 0; border-top: 1px solid #eee;"></td>
                </tr>
                <tr style="font-size: 18px; font-weight: bold;">
                    <td>Total Bayar:</td>
                    <td style="text-align: right; color: #27ae60;">Rp {{ number_format($fine->amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div style="background: #fdfdfd; padding: 10px; border-radius: 5px; font-size: 12px; color: #7f8c8d; text-align: center;">
            Harap simpan email ini sebagai bukti pembayaran yang sah.
        </div>
        
        <p style="text-align: center; font-size: 12px; color: #aaa; margin-top: 20px;">
            Sistem AyoBaca Perpustakaan Digital
        </p>
    </div>
</body>
</html>