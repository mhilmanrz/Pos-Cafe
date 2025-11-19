# 🍽️ POS Café — Point of Sale Web App

Aplikasi **Point of Sale (POS)** khusus kafe untuk mengelola pemesanan menu, transaksi, pembayaran, hingga laporan penjualan secara efisien. Dibangun menggunakan **Laravel**, aplikasi ini membantu admin dan kasir dalam mempercepat proses pelayanan dan mempermudah pencatatan transaksi harian.

---

## ✨ Fitur Utama

### 🔐 Autentikasi & Role User
- Login dengan role **Admin** dan **Kasir**
- Akses halaman dibatasi berdasarkan role

### 📋 Manajemen Menu
- Tambah, edit, hapus menu
- Atur harga, kategori, dan status menu
- Upload gambar menu (jika diperlukan)

### 🧾 Transaksi & Pemesanan
- Kasir dapat membuat order baru
- Hitung total harga otomatis
- Cetak struk pembayaran
- Pantau status pembayaran

### 📊 Laporan Penjualan
- Rekap penjualan harian dan bulanan
- Daftar transaksi berdasarkan periode
- Ringkasan pendapatan

### 📱 QR Order 
- Customer scan QR meja
- Customer melihat menu secara online
- Pesanan masuk ke sistem kasir dan kitchen

---

## 🏗️ Arsitektur Project

- **Backend**: Laravel
- **Frontend**: Blade Template + Bootstrap / CSS
- **Database**: MySQL
- **Authentication**: Laravel Auth



---

## 📦 Instalasi & Setup

### 1️⃣ Clone Repository
```bash
git clone https://github.com/mhilmanrz/Pos-Cafe.git
cd Pos-Cafe
```

### 2️⃣ Install Dependencies
```bash
composer install
npm install
```

3️⃣ Copy File Environment
```bash
cp .env.example .env
```

4️⃣ Generate App Key
```bash
php artisan key:generate
```

5️⃣ Konfigurasi Database
```bash
Buat database baru di MySQL, lalu sesuaikan konfigurasinya di file .env:

DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

6️⃣ Import Database
```bash
Import file SQL berikut:

db_cafe.sql
```

7️⃣ Migrasi & Seed (opsional)

Jika ingin menggunakan migration:
```bash
php artisan migrate --seed
```

8️⃣ Jalankan Server Laravel
```bash
php artisan serve
```

Aplikasi dapat diakses melalui:
```bash
http://127.0.0.1:8000
```
