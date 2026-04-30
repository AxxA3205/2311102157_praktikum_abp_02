# 🏪 Inventori Toko Pak Cokomi & Mas Wowo

Sistem manajemen inventori toko sederhana berbasis Laravel.

## Fitur
- 🔐 Autentikasi (login/register) menggunakan Laravel Breeze
- 📦 CRUD produk lengkap
- 🔍 Filter & pencarian produk
- 📊 Dashboard statistik stok
- ⚠️ Indikator stok menipis
- 💾 Database seeder dengan data dummy

## Akun Demo
| Nama | Email | Password |
|------|-------|----------|
| Pak Cokomi | cokomi@toko.com | password123 |
| Mas Wowo | wowo@toko.com | password123 |

## Instalasi
```bash
git clone <repo-url>
cd inventori-toko
composer install
cp .env.example .env
php artisan key:generate
# Edit .env sesuaikan DB
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

## Teknologi
- Laravel 11
- Laravel Breeze (auth)
- MySQL
- Blade Templates
- Tailwind CSS (via Vite)