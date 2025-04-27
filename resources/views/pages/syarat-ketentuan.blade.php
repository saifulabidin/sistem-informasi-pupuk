<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat dan Ketentuan - SIP-Pupuk</title>
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
            <h1>Syarat dan Ketentuan</h1>
            <p class="lead">Ketentuan penggunaan Sistem Informasi Penjualan Pupuk</p>
        </div>
    </section>

    <!-- Content Section -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <section class="mb-5">
                    <h2 class="section-title">Pendahuluan</h2>
                    <p class="mb-4">
                        Selamat datang di Sistem Informasi Penjualan Pupuk ("SIP-Pupuk"). Syarat dan Ketentuan ini 
                        mengatur penggunaan dan akses ke layanan yang disediakan melalui situs web dan aplikasi kami, 
                        termasuk semua konten, fitur, dan fungsionalitas yang terkait.
                    </p>
                    <p class="mb-4">
                        Dengan mengakses atau menggunakan layanan kami, Anda menyetujui bahwa Anda telah membaca, 
                        memahami, dan menyetujui untuk terikat oleh Syarat dan Ketentuan ini. Jika Anda tidak menyetujui 
                        Syarat dan Ketentuan ini, maka Anda tidak berhak untuk mengakses atau menggunakan layanan kami.
                    </p>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Definisi</h2>
                    <ul class="mb-4">
                        <li>
                            <strong>"Layanan"</strong> mengacu pada situs web Sistem Informasi Penjualan Pupuk, termasuk 
                            semua konten, fitur, dan fungsionalitas yang disediakan.
                        </li>
                        <li>
                            <strong>"Pengguna"</strong> mengacu pada individu atau entitas yang mengakses atau 
                            menggunakan Layanan, baik terdaftar maupun tidak.
                        </li>
                        <li>
                            <strong>"Konten Pengguna"</strong> mengacu pada semua data, informasi, atau materi lain 
                            yang diunggah, diposting, atau disediakan oleh Pengguna melalui Layanan.
                        </li>
                        <li>
                            <strong>"SIP-Pupuk"</strong> mengacu pada Sistem Informasi Penjualan Pupuk, 
                            platform yang menyediakan layanan ini.
                        </li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Penggunaan Layanan</h2>
                    <h5 class="mb-3">1. Persyaratan Umum</h5>
                    <p class="mb-4">
                        Anda setuju untuk menggunakan Layanan kami hanya untuk tujuan yang sah dan sesuai dengan Syarat 
                        dan Ketentuan ini. Anda tidak boleh menggunakan Layanan untuk aktivitas ilegal atau untuk 
                        menyebarkan konten yang melanggar hukum, berbahaya, mengancam, kasar, melanggar, memfitnah, vulgar, 
                        cabul, menyinggung, atau tidak pantas lainnya.
                    </p>

                    <h5 class="mb-3">2. Akun dan Keamanan</h5>
                    <p class="mb-4">
                        Beberapa bagian dari Layanan kami mungkin memerlukan pendaftaran akun. Anda bertanggung jawab untuk 
                        menjaga kerahasiaan kredensial akun Anda dan untuk semua aktivitas yang terjadi di bawah akun Anda. 
                        Anda setuju untuk memberi tahu kami segera tentang penggunaan yang tidak sah dari akun Anda atau 
                        pelanggaran keamanan lainnya.
                    </p>

                    <h5 class="mb-3">3. Konten Pengguna</h5>
                    <p class="mb-4">
                        Anda bertanggung jawab atas semua Konten Pengguna yang Anda berikan. Dengan menyediakan Konten 
                        Pengguna, Anda memberi kami lisensi non-eksklusif, bebas royalti, dapat ditransfer, dan dapat 
                        disublisensikan untuk menggunakan, mereproduksi, memodifikasi, mengadaptasi, mempublikasikan, 
                        menerjemahkan, mendistribusikan, dan menampilkan Konten Pengguna tersebut untuk tujuan menyediakan 
                        dan mempromosikan Layanan.
                    </p>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Pembatasan Penggunaan</h2>
                    <p class="mb-3">Anda setuju untuk tidak:</p>
                    <ul class="mb-4">
                        <li>Menggunakan Layanan dengan cara yang dapat merusak, menonaktifkan, membebani berlebihan, atau 
                            mengganggu infrastruktur kami</li>
                        <li>Mencoba untuk mengakses area yang tidak diizinkan dari Layanan</li>
                        <li>Mengunggah, memposting, atau mentransmisikan virus, worm, atau kode berbahaya lainnya</li>
                        <li>Melakukan scraping atau pengumpulan data otomatis tanpa izin tertulis dari kami</li>
                        <li>Menyamar sebagai orang atau entitas lain, atau menyalahartikan afiliasi Anda dengan orang atau entitas</li>
                        <li>Melanggar hak kekayaan intelektual atau hak-hak lain dari pihak ketiga</li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Kekayaan Intelektual</h2>
                    <p class="mb-4">
                        Semua konten, fitur, dan fungsionalitas di Layanan kami, termasuk tetapi tidak terbatas pada teks, 
                        grafik, logo, ikon, gambar, file audio, video, dan perangkat lunak, adalah milik dari SIP-Pupuk 
                        atau pemilik lisensinya dan dilindungi oleh undang-undang hak cipta, merek dagang, paten, rahasia 
                        dagang, dan hukum kekayaan intelektual lainnya.
                    </p>
                    <p class="mb-4">
                        Anda tidak diperbolehkan untuk mereproduksi, mendistribusikan, memodifikasi, membuat karya turunan, 
                        menampilkan, menerbitkan, atau menjual bagian apa pun dari Layanan atau konten yang disediakan tanpa 
                        izin tertulis dari kami.
                    </p>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Penafian dan Batasan Tanggung Jawab</h2>
                    <p class="mb-4">
                        LAYANAN DISEDIAKAN "SEBAGAIMANA ADANYA" DAN "SEBAGAIMANA TERSEDIA" TANPA JAMINAN APA PUN, BAIK TERSURAT 
                        MAUPUN TERSIRAT. KAMI SECARA KHUSUS MENYANGKAL JAMINAN TERSIRAT TENTANG KELAYAKAN UNTUK DIPERJUALBELIKAN, 
                        KESESUAIAN UNTUK TUJUAN TERTENTU, DAN TIDAK PELANGGARAN.
                    </p>
                    <p class="mb-4">
                        DALAM KEADAAN APA PUN KAMI TIDAK AKAN BERTANGGUNG JAWAB ATAS KERUSAKAN LANGSUNG, TIDAK LANGSUNG, INSIDENTAL, 
                        KHUSUS, ATAU KONSEKUENSIAL YANG TIMBUL DARI PENGGUNAAN ATAU KETIDAKMAMPUAN MENGGUNAKAN LAYANAN, BAHKAN 
                        JIKA KAMI TELAH DIBERITAHU TENTANG KEMUNGKINAN KERUSAKAN TERSEBUT.
                    </p>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Perubahan pada Syarat dan Ketentuan</h2>
                    <p class="mb-4">
                        Kami berhak, atas kebijakan kami sendiri, untuk mengubah atau mengganti Syarat dan Ketentuan ini kapan 
                        saja. Jika perubahan bersifat material, kami akan berusaha memberi tahu Pengguna setidaknya 15 hari 
                        sebelum syarat baru berlaku. Penggunaan berkelanjutan atas Layanan kami setelah perubahan tersebut 
                        menunjukkan persetujuan Anda terhadap syarat-syarat baru.
                    </p>
                </section>

                <section>
                    <h2 class="section-title">Kontak</h2>
                    <p class="mb-4">
                        Jika Anda memiliki pertanyaan tentang Syarat dan Ketentuan ini, silakan hubungi kami di:
                    </p>
                    <div class="card bg-light p-4 mb-4">
                        <p><i class="bi bi-envelope-fill me-2 text-success"></i> <strong>Email:</strong> <a href="mailto:contact@sabidzpro.is-a.dev">contact@sabidzpro.is-a.dev</a></p>
                        <p><i class="bi bi-telephone-fill me-2 text-success"></i> <strong>Telepon:</strong> <a href="tel:+6282242034791">(62) 82242034791</a></p>
                        <p class="mb-0"><i class="bi bi-geo-alt-fill me-2 text-success"></i> <strong>Alamat:</strong> Jatisari Genukharjo, Wuryantoro, Wonogiri</p>
                    </div>
                    <p class="mb-4">
                        <small><em>Terakhir diperbarui: April 2025</em></small>
                    </p>
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