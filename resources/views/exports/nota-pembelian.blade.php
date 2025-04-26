<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Pembelian Pupuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14px;
            margin-bottom: 0;
        }
        .info-container {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-container table {
            width: 100%;
        }
        .info-container td {
            vertical-align: top;
            padding: 3px 5px;
        }
        .info-container .label {
            font-weight: bold;
            width: 150px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid #000;
            padding: 8px;
        }
        .items-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .items-table .number-column {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-container {
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
        }
        .barcode {
            text-align: center;
            margin-top: 20px;
        }
        .notes {
            margin-top: 20px;
            font-size: 12px;
            border-top: 1px dotted #666;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">NOTA PEMBELIAN PUPUK</div>
        <div class="subtitle">Sistem Informasi Penjualan Pupuk</div>
    </div>
    
    <div class="info-container">
        <table>
            <tr>
                <td class="label">No. Transaksi</td>
                <td>: {{ $pembelian->id }}</td>
                <td class="label">Tanggal</td>
                <td>: {{ $pembelian->tanggal_pembelian->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Petani</td>
                <td>: {{ $petani->nama }}</td>
                <td class="label">NIK</td>
                <td>: {{ $petani->nik ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kelompok Tani</td>
                <td>: {{ $petani->kelompokTani->nama ?? '-' }}</td>
                <td class="label">No. Bukti</td>
                <td>: {{ $pembelian->no_bukti ?? '-' }}</td>
            </tr>
        </table>
    </div>
    
    <table class="items-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Item</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $pupuk->nama }} ({{ $pupuk->jenis }})</td>
                <td class="number-column">{{ $pembelian->jumlah }}</td>
                <td>{{ $pupuk->satuan }}</td>
                <td class="number-column">Rp {{ number_format($pembelian->harga_satuan, 0, ',', '.') }}</td>
                <td class="number-column">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="5" style="text-align: right; font-weight: bold;">Total:</td>
                <td class="number-column">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    
    <div>
        <div><strong>Metode Pembayaran:</strong> {{ ucfirst($pembelian->metode_pembayaran) }}</div>
        <div><strong>Status Pembayaran:</strong> {{ ucfirst($pembelian->status_pembayaran) }}</div>
        @if($pembelian->keterangan)
            <div><strong>Keterangan:</strong> {{ $pembelian->keterangan }}</div>
        @endif
        @if($pembelian->alokasi_pupuk_id)
            <div><strong>Bagian dari Alokasi No:</strong> {{ $pembelian->alokasi_pupuk_id }}</div>
        @endif
    </div>
    
    <div class="footer">
        <div class="signature-container">
            <div class="signature-box">
                <div>{{ now()->format('d M Y') }}</div>
                <div>Petugas,</div>
                <div class="signature-line"></div>
                <div>({{ auth()->user()->name ?? '.....................' }})</div>
            </div>
        </div>
    </div>
    
    <div style="clear: both;"></div>
    
    <div class="barcode">
        #{{ $pembelian->id }}-{{ $pembelian->tanggal_pembelian->format('Ymd') }}
    </div>
    
    <div class="notes">
        * Nota ini merupakan bukti pembelian yang sah<br>
        * Simpan nota ini dengan baik
    </div>
</body>
</html>