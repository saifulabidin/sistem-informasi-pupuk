<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Penjualan Pupuk</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background-color: #f8f9fa;
            padding: 80px 0;
            margin-bottom: 40px;
        }
        .pupuk-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .pupuk-card:hover {
            transform: translateY(-5px);
        }
        footer {
            margin-top: 60px;
            background-color: #212529;
            color: white;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">Sistem Informasi Pupuk</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#daftar-pupuk">Daftar Pupuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kelompok-tani">Kelompok Tani</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Login Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1>Sistem Informasi Penjualan Pupuk</h1>
            <p class="lead mt-3">Distribusi pupuk yang efisien untuk petani</p>
        </div>
    </section>

    <!-- Pupuk Section -->
    <section class="container mb-5" id="daftar-pupuk">
        <h2 class="mb-4">Daftar Pupuk</h2>
        <div class="row">
            @forelse($pupuk as $item)
                <div class="col-md-4">
                    <div class="card pupuk-card h-100">
                        @if($item->hasMedia())
                            <img src="{{ $item->getFirstMediaUrl() }}" class="card-img-top" alt="{{ $item->nama }}">
                        @else
                            <div class="card-img-top bg-light text-center py-5">
                                <i class="bi bi-image" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama }}</h5>
                            <p class="card-text">
                                <span class="badge bg-primary">{{ $item->jenis }}</span>
                            </p>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($item->deskripsi, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                <span class="badge bg-secondary">Stok: {{ $item->stok }} {{ $item->satuan }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Belum ada data pupuk tersedia</div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Kelompok Tani Section -->
    <section class="container" id="kelompok-tani">
        <h2 class="mb-4">Kelompok Tani</h2>
        <div class="row">
            @forelse($kelompokTani as $kelompok)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">{{ $kelompok->nama }}</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Ketua:</strong> {{ $kelompok->ketua }}</p>
                            <p><strong>Lokasi:</strong> {{ $kelompok->desa }}, {{ $kelompok->kecamatan }}</p>
                            <p><strong>Jumlah Anggota:</strong> {{ $kelompok->petani->count() }} petani</p>
                            <hr>
                            <h6>Daftar Anggota:</h6>
                            <ul class="list-group">
                                @foreach($kelompok->petani->take(5) as $petani)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $petani->nama }}
                                        <span class="badge bg-primary rounded-pill">{{ $petani->luas_lahan ?? 0 }} ha</span>
                                    </li>
                                @endforeach
                                @if($kelompok->petani->count() > 5)
                                    <li class="list-group-item text-center text-muted">dan {{ $kelompok->petani->count() - 5 }} anggota lainnya</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Belum ada data kelompok tani tersedia</div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Sistem Informasi Penjualan Pupuk</h5>
                    <p>Sistem untuk membantu pengecer dalam mengelola distribusi pupuk kepada petani.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Kontak</h5>
                    <p>Email: info@pupuk-app.com</p>
                    <p>Telp: (021) 1234-5678</p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Sistem Informasi Penjualan Pupuk. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>