<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Alokasi Pupuk #{{ $alokasi->id }}</title>
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
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px 10px;
        }
        .info-table td:first-child {
            width: 150px;
            font-weight: bold;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .item-table th,
        .item-table td {
            border: 1px solid #000;
            padding: 5px 10px;
            text-align: left;
        }
        .item-table th {
            background-color: #f2f2f2;
        }
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            margin: 20px 0 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .progress-bar {
            width: 100%;
            height: 20px;
            background-color: #f2f2f2;
            border: 1px solid #000;
        }
        .progress {
            height: 100%;
            background-color: #4caf50;
        }
        .status {
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
        }
        .status-belum {
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
        .footer {
            margin-top: 30px;
            font-size: 10pt;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">DETAIL ALOKASI PUPUK</div>
        <div class="subtitle">SISTEM INFORMASI PENJUALAN PUPUK</div>
        <div>Jl. Pertanian No. 123, Kecamatan Subur, Kabupaten Makmur</div>
        <div>Tanggal Cetak: {{ now()->format('d/m/Y') }}</div>
    </div>
    
    <table class="info-table">
        <tr>
            <td>ID Alokasi</td>
            <td>: {{ $alokasi->id }}</td>
        </tr>
        <tr>
            <td>Kelompok Tani</td>
            <td>: {{ $kelompokTani->nama }}</td>
        </tr>
        <tr>
            <td>Pupuk</td>
            <td>: {{ $pupuk->nama }} ({{ ucfirst($pupuk->jenis) }})</td>
        </tr>
        <tr>
            <td>Jumlah Alokasi</td>
            <td>: {{ $alokasi->jumlah_alokasi }} {{ $pupuk->satuan }}</td>
        </tr>
        <tr>
            <td>Jumlah Diambil</td>
            <td>: {{ $alokasi->jumlah_diambil }} {{ $pupuk->satuan }}</td>
        </tr>
        <tr>
            <td>Sisa</td>
            <td>: {{ $alokasi->jumlah_alokasi - $alokasi->jumlah_diambil }} {{ $pupuk->satuan }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>: 
                @if($alokasi->status == 'belum_diambil')
                    <span class="status status-belum">Belum Diambil</span>
                @elseif($alokasi->status == 'sebagian')
                    <span class="status status-sebagian">Sebagian Diambil</span>
                @else
                    <span class="status status-selesai">Selesai</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>Tanggal Alokasi</td>
            <td>: {{ $alokasi->tanggal_alokasi->format('d/m/Y') }}</td>
        </tr>
        @if($alokasi->periode)
        <tr>
            <td>Periode</td>
            <td>: {{ $alokasi->periode }}</td>
        </tr>
        @endif
    </table>
    
    <div>
        <div style="margin-bottom: 5px;">Progress Pengambilan:</div>
        <div class="progress-bar">
            <div class="progress" style="width: <?php echo ($alokasi->jumlah_diambil / $alokasi->jumlah_alokasi) * 100; ?>%;"></div>
        </div>
        <div style="text-align: right; font-size: 10pt; margin-top: 5px;">
            {{ number_format(($alokasi->jumlah_diambil / $alokasi->jumlah_alokasi) * 100, 1) }}% Selesai
        </div>
    </div>
    
    @if($alokasi->keterangan)
    <div style="margin: 20px 0;">
        <strong>Keterangan:</strong>
        <p>{{ $alokasi->keterangan }}</p>
    </div>
    @endif
    
    <div class="section-title">Riwayat Pengambilan</div>
    
    @if(count($pembelian) > 0)
    <table class="item-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Petani</th>
                <th>Jumlah</th>
                <th>Tanggal Pengambilan</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelian as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->petani->nama }}</td>
                    <td>{{ $item->jumlah }} {{ $pupuk->satuan }}</td>
                    <td>{{ $item->tanggal_pembelian->format('d/m/Y') }}</td>
                    <td>
                        @if($item->status_pembayaran == 'lunas')
                            <span style="color: #4caf50; font-weight: bold;">Lunas</span>
                        @else
                            <span style="color: #f44336; font-weight: bold;">Hutang</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p><em>Belum ada pengambilan pupuk untuk alokasi ini.</em></p>
    @endif
    
    <div class="footer">
        <p>Dokumen ini dicetak dari Sistem Informasi Penjualan Pupuk.</p>
        <p>&copy; {{ date('Y') }} - Sistem Informasi Penjualan Pupuk</p>
    </div>
</body>
</html>