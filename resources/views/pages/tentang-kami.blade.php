<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - SIP-Pupuk</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
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

        .page-header {
            background: linear-gradient(135deg, rgba(25,135,84,0.8) 0%, rgba(25,135,84,0.6) 100%), url('https://images.unsplash.com/photo-1464226184884-fa280b87c399?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
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
        
        .team-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 25px;
            border: none;
        }
        
        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }
        
        /* Responsive styles */
        @media (max-width: 767.98px) {
            .page-header {
                padding: 60px 0;
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
                        <a class="nav-link" href="/">
                            <i class="bi bi-house-door-fill me-1"></i>Beranda
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container text-center">
            <h1>Tentang Kami</h1>
            <p class="lead">Mengenal lebih dekat Sistem Informasi Penjualan Pupuk</p>
        </div>
    </section>

    <!-- Content Section -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <section class="mb-5">
                    <h2 class="section-title">Visi & Misi</h2>
                    <p class="mb-4">
                        <strong>Visi:</strong> Menjadi platform terdepan dalam mendukung efisiensi dan transparansi distribusi pupuk di Indonesia 
                        untuk mencapai ketahanan pangan nasional.
                    </p>
                    <p>
                        <strong>Misi:</strong>
                    </p>
                    <ul class="mb-4">
                        <li>Menyediakan sistem informasi yang mudah digunakan untuk pengelolaan distribusi pupuk</li>
                        <li>Membantu pengecer dalam pelacakan stok, alokasi, dan penjualan pupuk</li>
                        <li>Mendukung kelompok tani dalam memenuhi kebutuhan pupuk tepat waktu dan tepat sasaran</li>
                        <li>Membantu pemerintah dalam memantau alur distribusi pupuk bersubsidi</li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Sejarah Singkat</h2>
                    <p class="mb-4">
                        Sistem Informasi Penjualan Pupuk mulai dikembangkan pada tahun 2024 sebagai solusi untuk mengatasi 
                        permasalahan distribusi pupuk yang sering terjadi di daerah pertanian. Berawal dari 
                        ketidakefisienan pendataan manual dan sulitnya pelacakan stok pupuk yang kerap menimbulkan 
                        masalah distribusi.
                    </p>
                    <p class="mb-4">
                        Dengan dukungan dari berbagai pihak termasuk kelompok tani dan distributor pupuk lokal, sistem 
                        informasi ini terus berkembang dan menjadi alat bantu utama dalam memastikan distribusi pupuk 
                        yang tepat sasaran dan efisien.
                    </p>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Fitur Utama</h2>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-database-fill text-success me-3" style="font-size: 2rem;"></i>
                                        <h5 class="card-title mb-0">Pengelolaan Data</h5>
                                    </div>
                                    <p class="card-text">Manajemen data petani, kelompok tani, dan stok pupuk yang komprehensif dan terorganisir.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-graph-up-arrow text-success me-3" style="font-size: 2rem;"></i>
                                        <h5 class="card-title mb-0">Pelaporan</h5>
                                    </div>
                                    <p class="card-text">Laporan stok, alokasi, dan penjualan pupuk dengan format yang dapat diekspor ke PDF dan Excel.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-people text-success me-3" style="font-size: 2rem;"></i>
                                        <h5 class="card-title mb-0">Kelompok Tani</h5>
                                    </div>
                                    <p class="card-text">Manajemen kelompok tani dan alokasi pupuk per kelompok untuk distribusi yang tepat sasaran.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-box-seam text-success me-3" style="font-size: 2rem;"></i>
                                        <h5 class="card-title mb-0">Stok Otomatis</h5>
                                    </div>
                                    <p class="card-text">Pengurangan stok otomatis saat terjadi penjualan dan notifikasi saat stok hampir habis.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="section-title">Tim Pengembang</h2>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card team-card">
                                <div class="card-body text-center p-4">
                                    <div class="rounded-circle overflow-hidden mx-auto mb-3" style="width: 120px; height: 120px;">
                                        <img src="https://avatars.githubusercontent.com/u/55196633?s=400&u=e506e3ce7606bddb3801de5f1befe7d7a5cb96c4&v=4" class="img-fluid" alt="Developer">
                                    </div>
                                    <h5 class="card-title">Saiful Abidin</h5>
                                    <p class="text-muted">Lead Developer</p>
                                    <div class="d-flex justify-content-center mt-3">
                                        <a href="https://github.com/saifulabidin" class="btn btn-sm btn-outline-dark rounded-circle mx-1">
                                            <i class="bi bi-github"></i>
                                        </a>
                                        <a href="https://instagram.com/itssabidz" class="btn btn-sm btn-outline-dark rounded-circle mx-1">
                                            <i class="bi bi-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card team-card">
                                <div class="card-body text-center p-4">
                                    <div class="rounded-circle overflow-hidden mx-auto mb-3" style="width: 120px; height: 120px;">
                                        <img src="https://avatars.githubusercontent.com/u/55196633?s=400&u=e506e3ce7606bddb3801de5f1befe7d7a5cb96c4&v=4" class="img-fluid" alt="Team Member">
                                    </div>
                                    <h5 class="card-title">Tim Pendukung</h5>
                                    <p class="text-muted">Support & Testing</p>
                                    <div class="d-flex justify-content-center mt-3">
                                        <a href="mailto:contact@sabidzpro.is-a.dev" class="btn btn-sm btn-outline-dark rounded-circle mx-1">
                                            <i class="bi bi-envelope"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

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
        });
    </script>
</body>
</html>