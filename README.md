# Aplikasi Pengelolaan Apotek Mufida Farma

Repository ini berisi source code Tugas Akhir berjudul:  
**"Rancang Bangun Sistem Informasi Pengelolaan Apotek Mufida Farma Berbasis Web Menggunakan Framework Laravel"**

## 👨‍💻 Teknologi yang Digunakan
- Laravel 11.x
- Inertia.js
- React
- Tailwind CSS
- MySQL

## 📦 Fitur Utama
- Manajemen data obat
- Transaksi penjualan (POS Kasir)
- Cetak struk
- Laporan Penjualan
- Manajemen stok dan resep

## ⚙️ Instalasi
```bash
git clone https://github.com/username/aplikasi-apotekmufidafarma.git
cd aplikasi-apotekmufidafarma
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate
