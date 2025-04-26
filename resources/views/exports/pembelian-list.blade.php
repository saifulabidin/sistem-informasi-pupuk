<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Pembelian Pupuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .subtitle {
            text-align: center;
            font-size: 12px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th {
            background-color: #f2f2f2;
            padding: 5px;
            font-size: 11px;
            text-align: center;
            vertical-align: middle;
        }
        td {
            padding: 5px;
            font-size: 10px;
            vertical-align: middle;
        }
        .footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: right;
        }
        .page-number {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <h1>DAFTAR PEMBELIAN PUPUK</h1>
    <div class="subtitle">Tanggal: {{ date('d/m/Y') }}</div>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Petani</th>
                <th>Kelompok Tani</th>
                <th>Pupuk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchases as $index => $item)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td style="text-align: center">{{ $item['id'] }}</td>
                    <td>{{ $item['petani'] }}</td>
                    <td>{{ $item['kelompok_tani'] }}</td>
                    <td>{{ $item['pupuk'] }}</td>
                    <td style="text-align: right">{{ $item['jumlah'] }}</td>
                    <td style="text-align: right">{{ $item['harga_satuan'] }}</td>
                    <td style="text-align: right">{{ $item['total_harga'] }}</td>
                    <td style="text-align: center">{{ $item['tanggal_pembelian'] }}</td>
                    <td style="text-align: center">{{ ucfirst($item['metode_pembayaran']) }}</td>
                    <td style="text-align: center">{{ ucfirst($item['status_pembayaran']) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center">Tidak ada data pembelian</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="page-number">Halaman {{ '{PAGENO}' }}</div>
</body>
</html>