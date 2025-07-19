# Patani

**Patani** adalah sebuah platform yang memudahkan pelanggan untuk membeli sayur dan buah-buahan langsung dari petani, memastikan produk yang lebih segar dan harga yang lebih kompetitif.

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan proyek ini secara lokal:

### 1. Clone Repository

```bash
git clone https://github.com/mvirgiawancr/patani.git
cd patani
```

### 2. Instal Dependensi

```bash
composer install
```

### 3. Konfigurasi Environment

Duplikasi file `.env.example` dan ubah namanya menjadi `.env`:

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan konfigurasi database Anda:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nama_database
DB_USERNAME=username
DB_PASSWORD=password
```

### 6. Migrasi Database

```bash
php artisan migrate
```

### 7. Hubungkan Storage dengan Public

```bash
php artisan storage:link
```

### 8. Jalankan Server

```bash
php artisan serve
```

Aplikasi sekarang dapat diakses di `http://127.0.0.1:8000`.

## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan lakukan fork repository ini dan buat pull request dengan perubahan yang Anda usulkan.
