# Sistem Informasi Penjualan Pupuk

[![Build Status](https://github.com/saifulabidin/sistem-informasi-pupuk/actions/workflows/laravel-ci.yml/badge.svg)](https://github.com/saifulabidin/sistem-informasi-pupuk/actions/workflows/laravel-ci.yml)

Aplikasi sistem informasi untuk membantu pengecer dalam mengelola distribusi pupuk kepada petani. Dibangun menggunakan Laravel dan Filament Admin Panel untuk pengembangan yang cepat, mudah dipelajari, namun tetap fleksibel dan maintainable.

## Fitur Utama

1. **Autentikasi Admin**: login, register, dan forgot/reset password via email
2. **CRUD Otomatis**:
   - Data Petani
   - Data Pupuk (stok, jenis, harga)
   - Kelompok Tani (bisa menambahkan banyak petani sekaligus)
3. **Upload File Logbook**: mendukung format PDF, Word, Excel
4. **Tabel Alokasi Pupuk**:
   - Menampilkan alokasi pupuk per petani
   - Dapat diekspor ke PDF
5. **Pengurangan Stok Otomatis** saat petani membeli pupuk
6. **Landing Page Publik**:
   - Menampilkan daftar pupuk dan kelompok tani dari database

## Teknologi yang Digunakan

- **Laravel** v10+
- **Filament** v3 (Admin Panel UI & CRUD otomatis)
- **Bootstrap 5** (Frontend landing page)
- **Spatie Media Library** (Upload file logbook)
- **Laravel Excel** (Import/export Excel)
- **DomPDF** (Cetak tabel alokasi ke PDF)

## Prasyarat Sistem

- PHP 8.1 atau lebih tinggi
- Composer
- MySQL / MariaDB / SQLite
- Node.js & NPM (jika menggunakan frontend build)
- Web server (Apache/Nginx)

## Instalasi

1. **Clone repositori ini**

   ```bash
   git clone https://github.com/saifulabidin/sistem-informasi-pupuk.git
   cd sistem-informasi-pupuk
   ```

2. **Instal dependensi PHP**

   ```bash
   composer install
   ```

3. **Salin file .env**

   ```bash
   cp .env.example .env
   ```

4. **Generate kunci aplikasi**

   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi database di file .env**

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pupuk_app
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   > Alternatif: Untuk pengembangan, Anda dapat menggunakan SQLite
   > ```
   > DB_CONNECTION=sqlite
   > DB_DATABASE=/absolute/path/to/database.sqlite
   > ```
   > Kemudian buat file database.sqlite di folder database:
   > ```bash
   > touch database/database.sqlite
   > ```

6. **Jalankan migrasi dan seeder**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Buat link simbolik untuk storage**

   ```bash
   php artisan storage:link
   ```

8. **Jalankan aplikasi**

   ```bash
   php artisan serve
   ```

9. **Akses aplikasi**

   - Web: [http://localhost:8000](http://localhost:8000)
   - Admin Panel: [http://localhost:8000/admin](http://localhost:8000/admin)

## Petunjuk Penggunaan

### Admin Panel

1. Akses [http://localhost:8000/admin](http://localhost:8000/admin)
2. Login dengan kredensial default:
   - Email: admin@example.com
   - Password: password
3. Dari dashboard admin, Anda dapat mengakses semua fitur manajemen:
   - Data Petani
   - Data Pupuk
   - Kelompok Tani
   - Alokasi Pupuk
   - Pembelian Pupuk
   - Upload Logbook

### Landing Page Publik

Akses [http://localhost:8000](http://localhost:8000) untuk melihat landing page yang menampilkan informasi pupuk dan kelompok tani yang tersedia.

## Struktur Proyek

```
app/
├── Filament/Resources/
│   └── PupukResource.php, PetaniResource.php, KelompokTaniResource.php
├── Models/
│   └── Petani.php, Pupuk.php, KelompokTani.php, AlokasiPupuk.php, PembelianPupuk.php
├── Services/
│   └── PembelianService.php
├── Http/
│   ├── Controllers/LandingPageController.php
│   └── Requests/...
routes/
├── web.php (landing page)
resources/views/
├── landing.blade.php
```

## Deployment

### Persiapan Hosting

1. **Kebutuhan Server**:
   - PHP 8.1+
   - Database MySQL/MariaDB
   - Composer
   - Web Server (Apache/Nginx)
   - SSL Certificate (disarankan)

2. **Langkah-langkah Deployment**:

   a. Clone repositori ke server:
   ```bash
   git clone https://github.com/username/sistem-informasi-pupuk.git
   cd sistem-informasi-pupuk
   ```

   b. Instal dependensi PHP:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

   c. Konfigurasi environment:
   ```bash
   cp .env.example .env
   # Edit file .env untuk production
   ```

   d. Generate kunci aplikasi:
   ```bash
   php artisan key:generate
   ```

   e. Konfigurasi database dan jalankan migrasi:
   ```bash
   php artisan migrate --force
   ```

   f. Optimasi untuk production:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

   g. Buat link simbolik storage:
   ```bash
   php artisan storage:link
   ```

### Konfigurasi Web Server

#### Contoh Konfigurasi Nginx

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl;
    server_name your-domain.com www.your-domain.com;
    
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    
    root /path/to/sistem-informasi-pupuk/public;
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    }
    
    location ~ /\.ht {
        deny all;
    }
    
    location /storage {
        try_files $uri $uri/ =404;
    }
}
```

#### Contoh Konfigurasi Apache (.htaccess sudah disediakan oleh Laravel)

Pastikan mod_rewrite diaktifkan:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Pemeliharaan Aplikasi

1. **Update aplikasi**:
   ```bash
   git pull
   composer install --optimize-autoloader --no-dev
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Backup database secara reguler**:
   ```bash
   # Contoh menggunakan mysqldump
   mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
   ```

## Kontribusi

Kontribusi sangat dipersilakan! Untuk berkontribusi pada proyek ini:

1. Fork repositori
2. Buat branch fitur (`git checkout -b feature/amazing-feature`)
3. Commit perubahan Anda (`git commit -m 'Add some amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buka Pull Request

## Lisensi

Aplikasi ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

## Kontak

Jika Anda memiliki pertanyaan atau masukan, silakan buka issue di repositori ini.

---

Dikembangkan dengan ❤️ untuk mempermudah distribusi pupuk kepada petani Indonesia.
