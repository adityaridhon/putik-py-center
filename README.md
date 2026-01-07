# Putik Psychology Center

Website company profile dan sistem manajemen booking layanan psikologi untuk memudahkan klien dalam menemukan dan memesan layanan psikologi di bidang industri, klinis, dan pendidikan.

## Deskripsi

Putik Psychology Center adalah aplikasi web yang menyediakan platform untuk manajemen layanan psikologi profesional. Sistem ini memfasilitasi proses booking online, manajemen konten company profile, serta administrasi layanan psikologi.

## Fitur Utama

- Company profile dinamis dengan manajemen konten
- Sistem booking layanan psikologi online
- Autentikasi pengguna dengan Two-Factor Authentication
- Dashboard admin untuk manajemen konten dan booking
- Responsive design untuk desktop dan mobile

## Tech Stack

### Backend

- Laravel 12.0
- Laravel Fortify (autentikasi)
- Laravel Inertia (server-side rendering)

### Frontend

- Vue.js
- Tailwind CSS 4.1
- Inertia.js
- Vite
- Shadcn Vue

### Database

- MySQL/PostgreSQL (sesuai konfigurasi)

## Prerequisites

Pastikan sistem anda memiliki:

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- NPM atau Yarn
- MySQL/PostgreSQL

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/putik-py-center.git
cd putik-py-center
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Konfigurasi Environment

```bash
# Copy file .env.example
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Setup Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=putik_py_center
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Jalankan migrasi database:

```bash
php artisan migrate
```

## Menjalankan Aplikasi

```bash
composer run dev
```

Aplikasi akan berjalan di `http://localhost:8000`

## Lisensi

MIT License
