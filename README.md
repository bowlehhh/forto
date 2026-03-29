# Forto

Forto sekarang disiapkan untuk berjalan penuh di MySQL, termasuk aplikasi utama, migration, seeder, session, cache, dan test suite.

## Kebutuhan

- PHP 8.3+
- Ekstensi `pdo_mysql`
- MySQL 8+ atau MariaDB yang kompatibel
- Composer

## Konfigurasi MySQL

Salin file env lalu isi kredensial MySQL server deploy:

```bash
cp .env.example .env
php artisan key:generate
```

Variabel database yang dipakai project ini:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forto
DB_USERNAME=forto_user
DB_PASSWORD=forto_pass_123
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
DB_ENGINE=InnoDB
```

## Deploy Dengan MySQL

Setelah database dan user MySQL dibuat di server, jalankan:

```bash
composer install --no-dev --optimize-autoloader
php artisan config:clear
php artisan migrate --seed --force
php artisan optimize
```

Project ini memang ditargetkan ke MySQL. `config/database.php` sudah dibuat MySQL-only supaya environment deploy tidak tercampur dengan driver lain.

## Local MySQL Helper

Kalau service MySQL sistem belum aktif, helper lokal ini bisa dipakai:

```bash
./scripts/mysql-local-start.sh
php artisan serve --host=127.0.0.1 --port=8000
```

Untuk mematikannya:

```bash
./scripts/mysql-local-stop.sh
```

Default helper lokal memakai port `3307` dan otomatis membuat database `forto` serta `forto_test`.

## Verifikasi

Untuk memastikan semua jalur MySQL sehat:

```bash
php artisan migrate:status
php artisan test
```
