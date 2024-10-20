<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Proyek Laravel 10 - Manajemen Pendappatan Daerah

## Deskripsi

Proyek ini adalah aplikasi manajemen rekening dan transaksi yang dibangun dengan menggunakan Laravel 10. Aplikasi ini memungkinkan pengguna untuk mengelola pendapatan daerah, transaksi, dan target, serta menyediakan fitur laporan yang dapat diunduh dalam format PDF.

## Tech Stack

-   **Laravel 10**: Framework PHP untuk membangun aplikasi web.
-   **Pgsql**: Basis data yang digunakan untuk menyimpan data aplikasi.
-   **Bootstrap**: Untuk styling antarmuka pengguna.
-   **DomPDF**: Untuk menghasilkan laporan dalam format PDF.
-   **PHP 8.2.12**: Versi PHP yang digunakan dalam proyek ini.

## Fitur Utama

1. **CRUD Rekening**

    - Menambah, mengedit, dan menghapus rekening.
    - Melihat daftar semua rekening yang ada.
    - Mencari data menggunakan search.

2. **CRUD Transaksi**

    - Menambah, mengedit, dan menghapus transaksi.
    - Melihat daftar semua transaksi yang terkait dengan rekening.
    - Mencari data menggunakan search.

3. **CRUD Target**

    - Menambah, mengedit, dan menghapus target.
    - Melihat daftar semua target yang telah ditetapkan.
    - Mencari data menggunakan search.

4. **Laporan**
    - Menghasilkan laporan transaksi yang dapat diunduh dalam format PDF.
    - Mencetak report data dengan melakukan filter sesuai range waktu yang ditentukan.

## Cara Menjalankan Proyek

1. **Kloning Repository**

    ```bash
    git clone https://github.com/amiqbal7/test-mdigi.git

    ```

2. **Masuk ke Direktori Proyek**

    ```bash
    cd test-mdigi

    ```

3. **Instalasi Dependensi**

    ```bash
    composer install

    ```

4. **Lakukan Konfigurasi .env**

5. **Migrasi database**

    ```bash
    php arisan migrate

    ```

6. **Jalankan Seeder**

    ```bash
    php artisan db:seed --class=RekeningSeeder

    ```

    ```bash
    php artisan db:seed --class=TransactionSeeder

    ```

    ```bash
    php artisan db:seed --class=TargetSeeder

    ````

7. **Instalasi Frontend Dependencies dan Build**

    ```bash
    npm install

    ```

    ```bash
    npm run dev

    ```

8. **jalankan server**

    ```bash
     php artisan serve

    ```
