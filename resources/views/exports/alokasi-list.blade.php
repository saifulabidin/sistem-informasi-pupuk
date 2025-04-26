<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alokasi Pupuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }
        .title {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14pt;
            margin-bottom: 10px;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10pt;
        }
        .item-table th,
        .item-table td {
            border: 1px solid #000;
            padding: 5px 7px;
            text-align: left;
        }
        .item-table th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
            font-size: 10pt;
            text-align: center;
        }
        .page-number {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 9pt;
        }
        .status-label {
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9pt;
        }
        .status-belum_diambil {
            background-color: #ffc107;
            color: #000;
        }
        .status-sebagian {
            background-color: #2196f3;
            color: #fff;
        }
        .status-selesai {
            background-color: #4caf50;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">DAFTAR ALOKASI PUPUK</div>
        <div class="subtitle">SISTEM INFORMASI PENJUALAN PUPUK</div>
        <div>Jl. Pertanian No. 123, Kecamatan Subur, Kabupaten Makmur</div>
        <div>Tanggal Cetak: {{ now()->format('d/m/Y') }}</div>
    </div>
    
    <table class="item-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Kelompok Tani</th>
                <th>Pupuk</th>
                <th>Jumlah Alokasi</th>
                <th>Jumlah Diambil</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Periode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allocations as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['kelompok_tani'] }}</td>
                    <td>{{ $item['pupuk'] }}</td>
                    <td>{{ $item['jumlah_alokasi'] }}</td>
                    <td>{{ $item['jumlah_diambil'] }}</td>
                    <td>
                        @if($item['status'] == 'belum_diambil')
                            <span class="status-label status-belum_diambil">Belum Diambil</span>
                        @elseif($item['status'] == 'sebagian')
                            <span class="status-label status-sebagian">Sebagian Diambil</span>
                        @else
                            <span class="status-label status-selesai">Selesai</span>
                        @endif
                    </td>
                    <td>{{ $item['tanggal_alokasi'] }}</td>
                    <td>{{ $item['periode'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dokumen ini dicetak dari Sistem Informasi Penjualan Pupuk.</p>
        <p>&copy; {{ date('Y') }} - Sistem Informasi Penjualan Pupuk</p>
    </div>
    
    <div class="page-number">
        Halaman 1
    </div>
</body>
</html>