<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi - SIP-Pupuk</title>
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
            <h1>Kebijakan Privasi</h1>
            <p class="lead">Informasi mengenai pengumpulan dan penggunaan data</p>
        </div>
    </section>

    <!-- Content Section -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <section class="mb-5">
                    <h2 class="section-title">Pengantar</h2>
                    <p class="mb-4">
                        Sistem Informasi Penjualan Pupuk kami berkomitmen untuk melindungi privasi Anda. 
                        Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, 
                        mengungkapkan, dan melindungi informasi pribadi Anda saat Anda menggunakan 
                        layanan kami.
                    </p>
                    <p class="mb-4">
                        Dengan menggunakan layanan kami, Anda menyetujui praktik yang dijelaskan dalam Kebijakan 
                        Privasi ini. Kami dapat mengubah Kebijakan Privasi ini dari waktu ke waktu. Perubahan tersebut 
                        akan berlaku segera setelah dipublikasikan di situs web.
                    </p>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Informasi yang Kami Kumpulkan</h2>
                    <p class="mb-3">Kami mengumpulkan informasi berikut dari pengguna kami:</p>
                    <ul class="mb-4">
                        <li>
                            <strong>Informasi Akun:</strong> Saat Anda mendaftar atau menggunakan layanan kami, kami 
                            mengumpulkan informasi seperti nama, alamat email, nomor telepon, dan kredensial login.
                        </li>
                        <li>
                            <strong>Informasi Petani dan Kelompok Tani:</strong> Data mengenai petani dan kelompok 
                            tani, termasuk nama, alamat, luas lahan, dan informasi kontak.
                        </li>
                        <li>
                            <strong>Data Transaksi:</strong> Informasi tentang pembelian pupuk, termasuk jenis pupuk, 
                            jumlah, harga, tanggal pembelian, dan metode pembayaran.
                        </li>
                        <li>
                            <strong>Informasi Penggunaan:</strong> Data tentang bagaimana Anda berinteraksi dengan 
                            layanan kami, fitur yang Anda gunakan, dan tindakan yang Anda lakukan.
                        </li>
                        <li>
                            <strong>Informasi Teknis:</strong> Data seperti alamat IP, jenis perangkat, jenis dan versi 
                            browser, sistem operasi, dan informasi log lainnya.
                        </li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Bagaimana Kami Menggunakan Informasi</h2>
                    <p class="mb-3">Kami menggunakan informasi yang dikumpulkan untuk:</p>
                    <ul class="mb-4">
                        <li>Menyediakan, memelihara, dan meningkatkan layanan kami</li>
                        <li>Memproses transaksi dan mengirimkan pemberitahuan terkait transaksi</li>
                        <li>Mengelola akun pengguna dan menyediakan dukungan pelanggan</li>
                        <li>Mengirimkan pembaruan, peringatan keamanan, dan pesan administratif</li>
                        <li>Menganalisis pola penggunaan dan tren untuk meningkatkan pengalaman pengguna</li>
                        <li>Mendeteksi, menyelidiki, dan mencegah aktivitas penipuan atau tidak sah</li>
                        <li>Memenuhi kewajiban hukum dan peraturan yang berlaku</li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Pembagian dan Pengungkapan Informasi</h2>
                    <p class="mb-4">
                        Kami tidak menjual, memperdagangkan, atau menyewakan informasi pribadi pengguna kepada pihak ketiga. 
                        Namun, kami dapat membagikan informasi dalam situasi berikut:
                    </p>
                    <ul class="mb-4">
                        <li>
                            <strong>Dengan Persetujuan Anda:</strong> Kami dapat membagikan informasi dengan pihak ketiga ketika 
                            Anda memberikan persetujuan untuk melakukannya.
                        </li>
                        <li>
                            <strong>Penyedia Layanan:</strong> Kami bekerja sama dengan penyedia layanan pihak ketiga 
                            untuk membantu kami menjalankan dan meningkatkan layanan kami.
                        </li>
                        <li>
                            <strong>Kepatuhan Hukum:</strong> Kami dapat mengungkapkan informasi jika diperlukan oleh hukum 
                            atau dalam menanggapi proses hukum yang sah.
                        </li>
                        <li>
                            <strong>Perlindungan Hak dan Keamanan:</strong> Kami dapat mengungkapkan informasi untuk melindungi 
                            hak, properti, atau keselamatan kami, pengguna kami, atau orang lain.
                        </li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Keamanan Data</h2>
                    <p class="mb-4">
                        Kami menerapkan langkah-langkah keamanan yang dirancang untuk melindungi informasi pribadi Anda 
                        dari akses yang tidak sah atau pengungkapan, termasuk:
                    </p>
                    <ul class="mb-4">
                        <li>Enkripsi data sensitif dan kredensial pengguna</li>
                        <li>Kontrol akses administratif dan teknik untuk membatasi akses ke sistem dan data</li>
                        <li>Pemantauan keamanan sistem secara teratur</li>
                        <li>Pembaruan keamanan dan penambalan rutin</li>
                    </ul>
                    <p>
                        Meskipun kami melakukan upaya terbaik untuk melindungi informasi pribadi Anda, tidak ada 
                        metode transmisi melalui Internet, atau metode penyimpanan elektronik yang 100% aman. Oleh 
                        karena itu, kami tidak dapat menjamin keamanan absolutnya.
                    </p>
                </section>

                <section class="mb-5">
                    <h2 class="section-title">Retensi Data</h2>
                    <p class="mb-4">
                        Kami menyimpan informasi pribadi Anda selama diperlukan untuk memenuhi tujuan yang diuraikan 
                        dalam Kebijakan Privasi ini, kecuali jangka waktu retensi yang lebih lama diperlukan atau 
                        diizinkan oleh hukum.
                    </p>
                </section>

                <section>
                    <h2 class="section-title">Kontak</h2>
                    <p class="mb-4">
                        Jika Anda memiliki pertanyaan atau kekhawatiran tentang Kebijakan Privasi ini atau praktik 
                        data kami, silakan hubungi kami di:
                    </p>
                    <div class="card bg-light p-4 mb-4">
                        <p><i class="bi bi-envelope-fill me-2 text-success"></i> <strong>Email:</strong> <a href="mailto:contact@sabidzpro.is-a.dev">contact@sabidzpro.is-a.dev</a></p>
                        <p><i class="bi bi-telephone-fill me-2 text-success"></i> <strong>Telepon:</strong> <a href="tel:+6282242034791">(62) 82242034791</a></p>
                        <p class="mb-0"><i class="bi bi-geo-alt-fill me-2 text-success"></i> <strong>Alamat:</strong> Jatisari Genukharjo, Wuryantoro, Wonogiri</p>
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