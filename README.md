# Aplikasi Pendaftaran Magang Kejaksaan Negeri Kabupaten Tegal

Sistem pendaftaran magang online untuk jalur Mandiri dan Institusi, dilengkapi dengan dashboard admin untuk pengelolaan data.

## Persyaratan Sistem

- **Pendaftaran Online**: Mendukung jalur Mandiri dan Institusi.
- **Cek Status**: Peserta dapat memantau status seleksi menggunakan NIK/NIM dan Tanggal Lahir.
- **Upload Laporan**: Fitur bagi peserta diterima untuk mengunggah Laporan Akhir Magang.
- **Dashboard Admin**: Manajemen data peserta, verifikasi berkas, dan update status penerimaan.

## Persyaratan Sistem

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL / MariaDB

## Cara Instalasi dan Menjalankan

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal:

### 1. Install Dependencies
Jalankan perintah berikut di terminal project:
```bash
composer install
npm install
```

### 2. Konfigurasi Environment
Salin file `.env.example` menjadi `.env` dan generate key aplikasi:
```bash
cp .env.example .env
php artisan key:generate
```
Buka file `.env` dan sesuaikan konfigurasi database Anda:
```ini
DB_DATABASE=register_magang
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Migrasi Database & Seeder
Jalankan perintah berikut untuk membuat tabel database dan akun Admin default:
```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
```
#### Opsi Alternatif: 
Import Database (SQL) 
    - Jika Anda ingin menggunakan database yang sudah disiapkan (termasuk data dummy), Anda dapat mengimpor file SQL yang tersedia di folder sql/:
        1. Pastikan database register_magang sudah dibuat di MySQL/MariaDB. 
        2. Import file sql/register_magang.sql menggunakan tool database favorit Anda atau via terminal: ```bash
        mysql -u root -p register_magang < sql/register_magang.sql
        ```
        Catatan: Jika menggunakan cara ini, Anda tidak perlu menjalankan perintah migrate dan db:seed.


### 4. Setup Storage
Agar file upload (PDF/Foto) dapat diakses publik, buat symbolic link:
```bash
php artisan storage:link
```

### 5. Menjalankan Aplikasi
Anda perlu menjalankan dua terminal:

**Terminal 1 (Vite - Frontend):**
```bash
npm run dev
```

**Terminal 2 (Laravel - Backend):**
```bash
php artisan serve
```

**Terminal 3 (Laravel - Frontend & Backend):**
```bash
composer run dev
```

Akses aplikasi melalui browser:
- **Halaman Pendaftaran:** http://127.0.0.1:8000
- **Cek Status & Upload Laporan:** http://127.0.0.1:8000/cek-status
- **Halaman Login Admin:** http://127.0.0.1:8000/login

---

## Pengujian (Testing)

Aplikasi ini dilengkapi dengan Unit Test & Feature Test menggunakan **Pest**. Jalankan perintah berikut untuk memulai pengujian:

```bash
php artisan test
```

## Akun Admin Default
Gunakan kredensial berikut untuk masuk ke dashboard admin:
- **Email:** `admin@kejari.go.id`
- **Password:** `password123`
