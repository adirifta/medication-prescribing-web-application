## Medication Prescribing Web Application
Aplikasi web peresepan obat berbasis Laravel dengan antarmuka terpisah untuk dokter, apoteker, dan administrator.

### Fitur Utama
#### Dokter
- Membuat dan mengelola pemeriksaan pasien
- Menginput tanda vital (tinggi badan, berat badan, tekanan darah, dll.)
- Menulis catatan pemeriksaan dan mengupload file
- Memberikan resep obat dengan harga dinamis
- Mengedit resep sebelum diproses apoteker

#### Apoteker
- Melihat resep yang menunggu diproses
- Memproses resep dan pembayaran
- Mencetak receipt dalam format PDF
- Melihat riwayat resep

#### Administrator
- Manajemen pengguna (dokter, apoteker, admin)
- Melihat semua data pasien dan pemeriksaan
- Audit logs untuk melacak semua perubahan data
- Konfigurasi sistem dan pengaturan
- Laporan dan analitik sistem

#### Teknologi yang Digunakan
- Backend: PHP 8.1+, Laravel 12
- Frontend: Tailwind CSS, Alpine.js
- Database: MySQL 5.7+
- PDF Generation: DomPDF
- API Integration: External Medicine API
- Coding Style: PSR-12 dengan Laravel Pint

### Persyaratan Sistem
- PHP 8.1 atau lebih tinggi
- Composer
- Node.js & NPM
- MySQL 5.7 atau lebih tinggi
- Web server (Apache/Nginx)
- Extensions PHP: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

### Instalasi dan Konfigurasi
1. Clone Repository
```bash
git clone [repository-url]
cd medication-prescribing
```

2. Install Dependencies PHP
```bash
composer install
```

3. Install Dependencies JavaScript
```bash
npm install
npm run build
```

4. Konfigurasi Environment
```bash
cp .env.example .env
```

5. Generate Application Key
```bash
php artisan key:generate
```

6. Jalankan Migrasi Database
```bash
php artisan migrate --seed
```

7. Buat Storage Link
```bash
php artisan storage:link
```

### Menjalankan Aplikasi
```bash
# Jalankan server Laravel
php artisan serve

npm run dev
```

### Akun Default
Setelah menjalankan seeder, akun berikut akan tersedia:
#### Administrator
- Email: admin@gmail.com
- Password: password
- Fitur: Manajemen sistem lengkap

#### Dokter
- Email: doctor@gmail.com
- Password: password
- Fitur: Pemeriksaan pasien dan resep

#### Apoteker
- Email: pharmacist@gmail.com
- Password: password
- Fitur: Proses resep dan cetak receipt
