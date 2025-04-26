# Panduan Deployment Sistem Informasi Penjualan Pupuk

Dokumen ini berisi panduan lengkap untuk melakukan deployment aplikasi Sistem Informasi Penjualan Pupuk ke berbagai lingkungan, baik untuk keperluan pengembangan, staging, maupun production.

## Daftar Isi
1. [Kebutuhan Server](#kebutuhan-server)
2. [Deployment ke Shared Hosting](#deployment-ke-shared-hosting)
3. [Deployment ke VPS/Dedicated Server](#deployment-ke-vpsdedicated-server)
4. [Deployment dengan Docker](#deployment-dengan-docker)
5. [Konfigurasi Web Server](#konfigurasi-web-server)
6. [Pemeliharaan Aplikasi](#pemeliharaan-aplikasi)
7. [Troubleshooting](#troubleshooting)

## Kebutuhan Server

### Minimum Requirements
- PHP 8.1+
- MySQL 5.7+ atau MariaDB 10.3+
- Composer 2.0+
- Minimal 1GB RAM (disarankan 2GB untuk production)
- 10GB disk space

### PHP Extensions
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD
- Zip

### Software Tambahan
- Web Server: Apache atau Nginx
- Redis (opsional, untuk caching dan queue)
- Node.js & NPM (jika ingin menggunakan Vite untuk frontend)

## Deployment ke Shared Hosting

Shared hosting merupakan pilihan yang ekonomis dan mudah untuk deployment aplikasi Laravel.

### Langkah-langkah Deployment

1. **Download kode aplikasi**
   - Download kode dari repositori Git sebagai ZIP
   - Upload ke hosting melalui FTP/SFTP

2. **Struktur folder**
   - Upload semua file ke folder `public_html` atau folder root hosting Anda
   - Opsi yang lebih aman: Upload file di luar `public_html` kecuali folder `public`
   
   Contoh struktur aman:
   ```
   /home/username/
   ├── aplikasi_pupuk/         # Folder utama aplikasi
   │   ├── app/
   │   ├── bootstrap/
   │   ├── config/
   │   ├── ...semua file/folder Laravel lainnya
   │
   ├── public_html/            # Document root web server
       └── index.php           # Modified to point to ../aplikasi_pupuk/public/index.php
   ```

3. **Modifikasi index.php**
   Jika menggunakan struktur folder aman, edit file `public_html/index.php`:
   
   ```php
   // Original paths
   // require __DIR__.'/../vendor/autoload.php';
   // $app = require_once __DIR__.'/../bootstrap/app.php';

   // New paths
   require __DIR__.'/../aplikasi_pupuk/vendor/autoload.php';
   $app = require_once __DIR__.'/../aplikasi_pupuk/bootstrap/app.php';
   ```

4. **Konfigurasi Database**
   - Buat database melalui control panel hosting (cPanel, Plesk, dll)
   - Salin `.env.example` menjadi `.env` dan sesuaikan koneksi database

5. **Instalasi Dependensi**
   - Jika hosting mendukung SSH:
     ```bash
     composer install --optimize-autoloader --no-dev
     php artisan key:generate
     ```
   - Jika tidak ada SSH:
     - Instal composer dan dependensi di lokal
     - Upload folder vendor ke hosting

6. **Migrasi Database**
   ```bash
   php artisan migrate --force
   php artisan db:seed
   ```

7. **Symbolic Link Storage**
   - Jika hosting mendukung symbolic link:
     ```bash
     php artisan storage:link
     ```
   - Jika tidak, salin folder `storage/app/public` ke `public/storage`

8. **Konfigurasi File Permissions**
   ```bash
   chmod -R 755 /path/to/application
   chmod -R 777 /path/to/application/storage
   chmod -R 777 /path/to/application/bootstrap/cache
   ```

## Deployment ke VPS/Dedicated Server

VPS atau dedicated server memberikan kontrol penuh terhadap lingkungan server.

### Langkah-langkah Deployment

1. **Persiapkan Server**
   ```bash
   # Update package list
   sudo apt update && sudo apt upgrade -y
   
   # Install software yang diperlukan
   sudo apt install -y nginx mysql-server php8.1-fpm php8.1-cli php8.1-common php8.1-curl php8.1-mbstring php8.1-mysql php8.1-xml php8.1-zip php8.1-gd php8.1-bcmath git unzip
   ```

2. **Setup MySQL**
   ```bash
   sudo mysql_secure_installation
   
   # Buat database dan user
   sudo mysql -u root -p
   ```
   
   ```sql
   CREATE DATABASE pupuk_app;
   CREATE USER 'pupukuser'@'localhost' IDENTIFIED BY 'password';
   GRANT ALL PRIVILEGES ON pupuk_app.* TO 'pupukuser'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

3. **Install Composer**
   ```bash
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   ```

4. **Clone Repositori**
   ```bash
   cd /var/www
   git clone https://github.com/username/sistem-informasi-pupuk.git
   cd sistem-informasi-pupuk
   ```

5. **Setup Laravel**
   ```bash
   cp .env.example .env
   composer install --optimize-autoloader --no-dev
   
   # Edit .env file dengan konfigurasi yang tepat
   nano .env
   
   # Generate key aplikasi
   php artisan key:generate
   ```

6. **Migrasi Database**
   ```bash
   php artisan migrate --force
   php artisan db:seed
   ```

7. **Konfigurasi File Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/sistem-informasi-pupuk
   sudo chmod -R 755 /var/www/sistem-informasi-pupuk
   sudo chmod -R 777 /var/www/sistem-informasi-pupuk/storage
   sudo chmod -R 777 /var/www/sistem-informasi-pupuk/bootstrap/cache
   ```

8. **Konfigurasi Nginx**
   ```bash
   sudo nano /etc/nginx/sites-available/pupuk-app
   ```
   
   Isi dengan konfigurasi seperti di bagian [Konfigurasi Web Server - Nginx](#konfigurasi-web-server)
   
   ```bash
   sudo ln -s /etc/nginx/sites-available/pupuk-app /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl restart nginx
   ```

9. **Setup SSL dengan Let's Encrypt**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
   ```

10. **Optimize Laravel untuk Production**
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan storage:link
    ```

## Deployment dengan Docker

Docker memungkinkan deployment aplikasi dengan environment yang konsisten.

1. **Buat Dockerfile**

   Buat file `Dockerfile` di root proyek:
   ```dockerfile
   FROM php:8.1-fpm

   # Install dependencies
   RUN apt-get update && apt-get install -y \
       build-essential \
       libpng-dev \
       libjpeg62-turbo-dev \
       libfreetype6-dev \
       locales \
       zip \
       jpegoptim optipng pngquant gifsicle \
       vim \
       unzip \
       git \
       curl \
       libzip-dev

   # Clear cache
   RUN apt-get clean && rm -rf /var/lib/apt/lists/*

   # Install extensions
   RUN docker-php-ext-install pdo_mysql zip exif pcntl
   RUN docker-php-ext-configure gd --with-freetype --with-jpeg
   RUN docker-php-ext-install gd

   # Install composer
   COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

   # Set working directory
   WORKDIR /var/www

   COPY . /var/www

   # Change ownership of our applications
   RUN chown -R www-data:www-data /var/www

   CMD ["php-fpm"]

   EXPOSE 9000
   ```

2. **Buat docker-compose.yml**

   ```yaml
   version: '3'
   services:
     app:
       build:
         context: .
         dockerfile: Dockerfile
       image: pupuk-app
       container_name: pupuk-app
       restart: unless-stopped
       volumes:
         - ./:/var/www
         - ./php/local.ini:/usr/local/etc/php/conf.d/local.ini
       networks:
         - app-network

     db:
       image: mysql:5.7
       container_name: pupuk-db
       restart: unless-stopped
       environment:
         MYSQL_DATABASE: ${DB_DATABASE}
         MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
         MYSQL_PASSWORD: ${DB_PASSWORD}
         MYSQL_USER: ${DB_USERNAME}
       volumes:
         - dbdata:/var/lib/mysql
       networks:
         - app-network

     nginx:
       image: nginx:alpine
       container_name: pupuk-nginx
       restart: unless-stopped
       ports:
         - 8000:80
       volumes:
         - ./:/var/www
         - ./nginx/conf.d/:/etc/nginx/conf.d/
       networks:
         - app-network

   networks:
     app-network:
       driver: bridge

   volumes:
     dbdata:
       driver: local
   ```

3. **Konfigurasi Nginx untuk Docker**
   
   Buat folder `nginx/conf.d` dan file `app.conf`:
   ```
   server {
       listen 80;
       index index.php index.html;
       error_log  /var/log/nginx/error.log;
       access_log /var/log/nginx/access.log;
       root /var/www/public;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           try_files $uri =404;
           fastcgi_pass app:9000;
           fastcgi_index index.php;
           include fastcgi_params;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
       }
   }
   ```

4. **Build dan Jalankan Docker**
   ```bash
   docker-compose build
   docker-compose up -d
   ```

5. **Setup Laravel di dalam Container**
   ```bash
   docker-compose exec app composer install
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --force
   docker-compose exec app php artisan storage:link
   ```

## Konfigurasi Web Server

### Nginx

Contoh konfigurasi Nginx untuk production:

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com www.your-domain.com;
    
    ssl_certificate /etc/letsencrypt/live/your-domain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/your-domain.com/privkey.pem;
    
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_prefer_server_ciphers on;
    ssl_ciphers ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES256-GCM-SHA384;
    ssl_session_timeout 1d;
    ssl_session_cache shared:SSL:10m;
    ssl_session_tickets off;
    
    # HSTS
    add_header Strict-Transport-Security "max-age=63072000" always;
    
    # OCSP stapling
    ssl_stapling on;
    ssl_stapling_verify on;
    
    root /var/www/sistem-informasi-pupuk/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
        expires 365d;
        add_header Cache-Control "public, no-transform";
    }
    
    # Gzip compression
    gzip on;
    gzip_comp_level 5;
    gzip_min_length 256;
    gzip_proxied any;
    gzip_vary on;
    gzip_types
        application/atom+xml
        application/javascript
        application/json
        application/ld+json
        application/manifest+json
        application/rss+xml
        application/vnd.geo+json
        application/vnd.ms-fontobject
        application/x-font-ttf
        application/x-web-app-manifest+json
        application/xhtml+xml
        application/xml
        font/opentype
        image/bmp
        image/svg+xml
        image/x-icon
        text/cache-manifest
        text/css
        text/plain
        text/vcard
        text/vnd.rim.location.xloc
        text/vtt
        text/x-component
        text/x-cross-domain-policy;
}
```

### Apache

Contoh konfigurasi Apache Virtual Host:

```apache
<VirtualHost *:80>
    ServerName your-domain.com
    ServerAlias www.your-domain.com
    
    Redirect permanent / https://your-domain.com/
</VirtualHost>

<VirtualHost *:443>
    ServerName your-domain.com
    ServerAlias www.your-domain.com
    
    DocumentRoot /var/www/sistem-informasi-pupuk/public
    
    <Directory /var/www/sistem-informasi-pupuk/public>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>
    
    # SSL Configuration
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/your-domain.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/your-domain.com/privkey.pem
    
    <FilesMatch "\.(cgi|shtml|phtml|php)$">
        SSLOptions +StdEnvVars
    </FilesMatch>
    
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
    
    # Enable HTTP/2
    Protocols h2 http/1.1
    
    # HSTS
    Header always set Strict-Transport-Security "max-age=63072000"
</VirtualHost>
```

## Pemeliharaan Aplikasi

### Backup

Lakukan backup secara rutin:

1. **Database**
   ```bash
   # Backup MySQL
   mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
   
   # Compress backup
   gzip backup_$(date +%Y%m%d).sql
   
   # Optional: Upload to cloud storage
   aws s3 cp backup_$(date +%Y%m%d).sql.gz s3://your-backup-bucket/
   ```

2. **File Aplikasi**
   ```bash
   # Backup files
   tar -czf app_backup_$(date +%Y%m%d).tar.gz /var/www/sistem-informasi-pupuk
   ```

3. **Automasi dengan Cron**
   ```
   # Daily database backup at 2:00 AM
   0 2 * * * /path/to/backup_script.sh
   ```

### Update Aplikasi

1. **Backup terlebih dahulu**
   ```bash
   # Backup database dan files
   ```

2. **Pull kode terbaru**
   ```bash
   cd /var/www/sistem-informasi-pupuk
   git pull origin main
   ```

3. **Update dependensi**
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

4. **Migrasi database**
   ```bash
   php artisan migrate --force
   ```

5. **Clear dan cache konfigurasi**
   ```bash
   php artisan optimize
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. **Restart services jika perlu**
   ```bash
   # Contoh untuk Laravel Queue Worker
   sudo supervisorctl restart all
   ```

### Monitoring

1. **Setup Laravel Logs**
   ```
   LOG_CHANNEL=stack
   LOG_STACK=daily
   LOG_LEVEL=error
   ```

2. **Integrasikan dengan layanan monitoring**
   - New Relic
   - Datadog
   - Laravel Telescope untuk pengembangan

## Troubleshooting

### Masalah Umum dan Solusi

1. **Error 500**
   - Periksa file log Laravel di `storage/logs/laravel.log`
   - Periksa log web server (Nginx/Apache)
   - Pastikan permission folder `storage` dan `bootstrap/cache` benar

2. **Error Permission Denied**
   ```bash
   chmod -R 755 /var/www/sistem-informasi-pupuk
   chown -R www-data:www-data /var/www/sistem-informasi-pupuk
   chmod -R 777 /var/www/sistem-informasi-pupuk/storage
   chmod -R 777 /var/www/sistem-informasi-pupuk/bootstrap/cache
   ```

3. **Masalah Database Connection**
   - Pastikan kredensial di `.env` benar
   - Pastikan host database dapat diakses
   - Periksa firewall tidak memblokir koneksi

4. **White Screen of Death**
   - Aktifkan debugging di `.env` dengan `APP_DEBUG=true` (hanya untuk troubleshooting, jangan di production)
   - Periksa log PHP dan Laravel

5. **Error pada Login Admin Panel**
   - Pastikan `APP_URL` dikonfigurasi dengan benar di `.env`
   - Pastikan session driver dikonfigurasi dengan benar
   - Coba clear cache: `php artisan config:clear`

---

## Referensi

- [Dokumentasi Laravel - Deployment](https://laravel.com/docs/10.x/deployment)
- [Filament Documentation](https://filamentphp.com/docs)
- [Nginx Documentation](https://nginx.org/en/docs/)
- [Docker Documentation](https://docs.docker.com/)