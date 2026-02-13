<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Pembayaran Denda #{{ $fine->id }}</title>
    <style>
        /* Style untuk tampilan di layar */
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }
        .receipt-card {
            background-color: #fff;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border: 1px solid #eee;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            position: relative;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #666;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }
        .item-label {
            color: #777;
        }
        .item-value {
            font-weight: bold;
            text-align: right;
        }
        .divider {
            border-top: 1px solid #eee;
            margin: 20px 0;
        }
        .total-box {
            background-color: #f9f9f9;
            padding: 15px;
            text-align: center;
            border: 1px solid #333;
            margin-top: 20px;
        }
        .total-label {
            font-size: 12px;
            margin-bottom: 5px;
        }
        .total-amount {
            font-size: 28px;
            font-weight: bold;
        }
        .status-paid {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 60px;
            font-weight: bold;
            color: rgba(76, 175, 80, 0.15); /* Warna hijau transparan seperti stempel */
            border: 5px solid rgba(76, 175, 80, 0.15);
            padding: 10px 20px;
            pointer-events: none;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #999;
        }
        
        /* Tombol print manual (hanya muncul di layar, tidak saat di-print) */
        .no-print-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        /* Rule khusus saat pencetakan */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .receipt-card {
                box-shadow: none;
                border: none;
                max-width: 100%;
            }
            .no-print-btn {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="receipt-card">
        <div class="status-paid">LUNAS</div>

        <div class="header">
            <h1>Kuitansi Denda</h1>
            <p>Sistem Perpustakaan Digital</p>
        </div>

        <div class="item-row">
            <span class="item-label">No. Transaksi</span>
            <span class="item-value">#FIN-{{ $fine->id }}</span>
        </div>
        <div class="item-row">
            <span class="item-label">Tanggal Bayar</span>
            <span class="item-value">{{ \Carbon\Carbon::parse($fine->paid_at)->format('d M Y H:i') }}</span>
        </div>
        <div class="item-row">
            <span class="item-label">Nama Peminjam</span>
            <span class="item-value">{{ $fine->user->name ?? $fine->loan->user->name }}</span>
        </div>

        <div class="divider"></div>

        <div class="item-row">
            <span class="item-label">Judul Buku</span>
            <span class="item-value">{{ $fine->loan->book->title }}</span>
        </div>
        <div class="item-row">
            <span class="item-label">Metode Bayar</span>
            <span class="item-value">{{ strtoupper($fine->payment_method ?? 'Tunai') }}</span>
        </div>

        <div class="total-box">
            <div class="total-label">TOTAL DENDA DIBAYAR</div>
            <div class="total-amount">Rp {{ number_format($fine->amount, 0, ',', '.') }}</div>
        </div>

        <div class="footer">
            <p>Terima kasih telah mematuhi peraturan perpustakaan.<br>Kuitansi ini adalah bukti pembayaran yang sah secara sistem.</p>
        </div>

        <button class="no-print-btn" onclick="window.print()">Cetak Ulang</button>
    </div>

</body>
</html>