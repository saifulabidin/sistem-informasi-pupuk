<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
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
            font-size: 12px;
            text-align: center;
            vertical-align: middle;
        }
        td {
            padding: 5px;
            font-size: 11px;
            vertical-align: middle;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
        }
        .filters {
            margin-bottom: 15px;
        }
        .filters table {
            width: 60%;
            margin-bottom: 10px;
            border: none;
        }
        .filters table, .filters td {
            border: none;
            padding: 2px;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="subtitle">Tanggal: {{ $date }}</div>
    
    <div class="filters">
        <table>
            <tr>
                <td style="width: 25%">Kelompok Tani</td>
                <td>: {{ $filters['kelompok_tani'] }}</td>
            </tr>
            <tr>
                <td>Jenis Pupuk</td>
                <td>: {{ $filters['pupuk'] }}</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>: {{ $filters['periode'] }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: {{ $filters['status'] }}</td>
            </tr>
        </table>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Kelompok Tani</th>
                <th>Pupuk</th>
                <th>Jumlah Alokasi</th>
                <th>Jumlah Diambil</th>
                <th>Sisa</th>
                <th>Tanggal Alokasi</th>
                <th>Periode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alokasi as $index => $item)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td>{{ $item->kelompokTani->nama }}</td>
                    <td>{{ $item->pupuk->nama }}</td>
                    <td style="text-align: right">{{ $item->jumlah_alokasi }} {{ $item->pupuk->satuan }}</td>
                    <td style="text-align: right">{{ $item->jumlah_diambil }} {{ $item->pupuk->satuan }}</td>
                    <td style="text-align: right">{{ $item->jumlah_alokasi - $item->jumlah_diambil }} {{ $item->pupuk->satuan }}</td>
                    <td style="text-align: center">{{ $item->tanggal_alokasi->format('d/m/Y') }}</td>
                    <td style="text-align: center">{{ $item->periode }}</td>
                    <td style="text-align: center">{{ ucfirst($item->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center">Tidak ada data alokasi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>