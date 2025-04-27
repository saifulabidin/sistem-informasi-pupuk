<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIP-Pupuk</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Animate.css for smooth animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Google Fonts - Better Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #198754;
            --secondary-color: #6c757d;
            --accent-color: #ffc107;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            color: #333;
            position: relative;
            min-height: 100vh;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        
        .navbar {
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .navbar-nav .nav-link {
            position: relative;
            margin: 0 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            bottom: 0;
            left: 0;
            transition: width 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(25,135,84,0.8) 0%, rgba(25,135,84,0.6) 100%), url('https://images.unsplash.com/photo-1464226184884-fa280b87c399?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            margin-bottom: 60px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            animation: fadeInUp 1s ease;
        }
        
        .hero-section h1 {
            font-weight: 700;
            font-size: 2.8rem;
            margin-bottom: 1rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        
        .hero-section p.lead {
            font-size: 1.4rem;
            font-weight: 300;
            margin-bottom: 2rem;
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 60px;
            background-color: var(--primary-color);
        }
        
        .pupuk-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 25px;
            border: none;
            height: 100%;
        }
        
        .pupuk-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }
        
        .pupuk-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .pupuk-card .badge {
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        .kelompok-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 30px;
            border: none;
        }
        
        .kelompok-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.1);
        }
        
        .kelompok-card .card-header {
            border-bottom: none;
            padding: 1rem 1.5rem;
        }
        
        .kelompok-card .card-body {
            padding: 1.5rem;
        }
        
        .kelompok-card .card-title {
            margin-bottom: 0;
            font-size: 1.25rem;
        }
        
        .list-group-item {
            border-left: none;
            border-right: none;
            padding: 0.75rem 1.25rem;
            transition: background-color 0.3s ease;
        }
        
        .list-group-item:hover {
            background-color: rgba(25,135,84,0.05);
        }
        
        .list-group-item:first-child {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background-color: #157347;
            color: white;
            transform: translateY(-3px);
        }
        
        footer {
            margin-top: 80px;
            background-color: #212529;
            color: white;
            padding: 60px 0 30px;
        }
        
        footer h5 {
            color: white;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        footer h5::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 2px;
            background-color: var(--accent-color);
        }
        
        footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        footer a:hover {
            color: white;
        }
        
        .footer-social a {
            display: inline-block;
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.1);
            margin-right: 10px;
            border-radius: 50%;
            text-align: center;
            line-height: 36px;
            color: white;
            transition: all 0.3s;
        }
        
        .footer-social a:hover {
            background: var(--accent-color);
            transform: translateY(-3px);
        }
        
        /* Loading spinner */
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255,255,255,0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s, visibility 0.5s;
        }
        
        /* Responsive styles */
        @media (max-width: 767.98px) {
            .hero-section {
                padding: 80px 0;
            }
            
            .hero-section h1 {
                font-size: 2rem;
            }
            
            .hero-section p.lead {
                font-size: 1.1rem;
            }
            
            .section-title {
                text-align: center;
            }
            
            .section-title::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            footer {
                text-align: center;
            }
            
            footer h5::after {
                left: 50%;
                transform: translateX(-50%);
            }
        }
    </style>
</head>
<body>
    <!-- Loading spinner -->
    <div class="spinner-overlay" id="loading-spinner">
        <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-flower1 me-2"></i>SIP-Pupuk
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" aria-current="page">
                            <i class="bi bi-house-door-fill me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#daftar-pupuk">
                            <i class="bi bi-box-seam me-1"></i>Daftar Pupuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kelompok-tani">
                            <i class="bi bi-people-fill me-1"></i>Kelompok Tani
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <div class="hero-content">
                <h1 class="animate__animated animate__fadeInDown">Sistem Informasi Penjualan Pupuk</h1>
                <p class="lead mt-3 animate__animated animate__fadeInUp animate__delay-1s">Distribusi pupuk yang efisien untuk petani</p>
                <div class="mt-4 animate__animated animate__fadeInUp animate__delay-2s">
                    <a href="#daftar-pupuk" class="btn btn-light btn-lg shadow-sm me-2">
                        <i class="bi bi-box-seam me-2"></i>Lihat Produk
                    </a>
                    <a href="#kelompok-tani" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-people me-2"></i>Kelompok Tani
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Highlight -->
    <div class="container mb-5">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-3 shadow-sm h-100">
                    <i class="bi bi-box-seam text-success mb-3" style="font-size: 2rem;"></i>
                    <h3 class="fs-4">{{ $pupuk->count() }}</h3>
                    <p class="text-muted mb-0">Jenis Pupuk Tersedia</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-3 shadow-sm h-100">
                    <i class="bi bi-people text-success mb-3" style="font-size: 2rem;"></i>
                    <h3 class="fs-4">{{ $kelompokTani->count() }}</h3>
                    <p class="text-muted mb-0">Kelompok Tani</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-3 shadow-sm h-100">
                    <i class="bi bi-person-fill text-success mb-3" style="font-size: 2rem;"></i>
                    <h3 class="fs-4">{{ $kelompokTani->sum(function($item) { return $item->petani->count(); }) }}</h3>
                    <p class="text-muted mb-0">Total Petani</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pupuk Section -->
    <section class="container mb-5" id="daftar-pupuk">
        <h2 class="section-title">Daftar Pupuk</h2>
        <div class="row">
            @forelse($pupuk as $item)
                <div class="col-md-4 col-sm-6">
                    <div class="card pupuk-card h-100">
                        @if($item->hasMedia())
                            <img src="{{ $item->getFirstMediaUrl() }}" class="card-img-top" alt="{{ $item->nama }}" loading="lazy">
                        @else
                            <div class="card-img-top bg-light text-center py-5">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama }}</h5>
                            <p class="card-text mb-3">
                                <span class="badge bg-success">{{ $item->jenis }}</span>
                            </p>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($item->deskripsi, 100) }}</p>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-box me-1"></i>Stok: {{ $item->stok }} {{ $item->satuan }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>Belum ada data pupuk tersedia
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Kelompok Tani Section -->
    <section class="container" id="kelompok-tani">
        <h2 class="section-title">Kelompok Tani</h2>
        <div class="row">
            @forelse($kelompokTani as $kelompok)
                <div class="col-lg-6 mb-4">
                    <div class="card kelompok-card">
                        <div class="card-header bg-success text-white">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-people-fill me-2 fs-4"></i>
                                <h5 class="card-title m-0">{{ $kelompok->nama }}</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <i class="bi bi-person-fill me-2 text-success"></i>
                                        <strong>Ketua:</strong> {{ $kelompok->ketua }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <i class="bi bi-geo-alt-fill me-2 text-success"></i>
                                        <strong>Lokasi:</strong> {{ $kelompok->desa }}, {{ $kelompok->kecamatan }}
                                    </p>
                                </div>
                            </div>
                            <p class="mb-3">
                                <i class="bi bi-people me-2 text-success"></i>
                                <strong>Jumlah Anggota:</strong> 
                                <span class="badge bg-success rounded-pill ms-1">{{ $kelompok->petani->count() }} petani</span>
                            </p>
                            <hr>
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-list-check me-2"></i>Daftar Anggota:
                            </h6>
                            <ul class="list-group list-group-flush">
                                @foreach($kelompok->petani->take(5) as $petani)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="bi bi-person me-2 text-success"></i>
                                            {{ $petani->nama }}
                                        </span>
                                        <span class="badge bg-success rounded-pill">{{ $petani->luas_lahan ?? 0 }} ha</span>
                                    </li>
                                @endforeach
                                @if($kelompok->petani->count() > 5)
                                    <li class="list-group-item text-center text-muted">
                                        <i class="bi bi-three-dots me-2"></i>
                                        dan {{ $kelompok->petani->count() - 5 }} anggota lainnya
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>Belum ada data kelompok tani tersedia
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Back to top button -->
    <a href="#" class="back-to-top" id="back-to-top" aria-label="Back to top">
        <i class="bi bi-arrow-up"></i>
    </a>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5>Sistem Informasi Penjualan Pupuk</h5>
                    <p class="text-muted">Sistem untuk membantu pengecer dalam mengelola distribusi pupuk kepada petani.</p>
                    <div class="footer-social mt-4">
                        <a href="https://facebook.com/syaiful.osd1" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://x.com/syaifulosd" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://instagram.com/itssabidz" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5>Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('tentang-kami') }}"><i class="bi bi-chevron-right me-2"></i>Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('panduan-penggunaan') }}"><i class="bi bi-chevron-right me-2"></i>Panduan Penggunaan</a></li>
                        <li class="mb-2"><a href="{{ route('kebijakan-privasi') }}"><i class="bi bi-chevron-right me-2"></i>Kebijakan Privasi</a></li>
                        <li class="mb-2"><a href="{{ route('syarat-ketentuan') }}"><i class="bi bi-chevron-right me-2"></i>Syarat dan Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            Jatisari Genukharjo Wuryantoro Wonogiri
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope-fill me-2"></i>
                            <a href="mailto:contact@sabidzpro.is-a.dev">contact@sabidzpro.is-a.dev</a>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone-fill me-2"></i>
                            <a href="https://wa.me/+6282242034791">(62) 82242034791</a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Sistem Informasi Penjualan Pupuk. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Loading spinner
        window.addEventListener('load', function() {
            const spinner = document.getElementById('loading-spinner');
            spinner.style.opacity = '0';
            setTimeout(function() {
                spinner.style.visibility = 'hidden';
            }, 500);
        });
        
        // Back to top button
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopButton = document.getElementById('back-to-top');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.add('show');
                } else {
                    backToTopButton.classList.remove('show');
                }
            });
            
            backToTopButton.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        });
    </script>
</body>
</html>