# PulseCare - Aplikasi Kesehatan Ibu dan Anak

**PulseCare** adalah aplikasi web berbasis Laravel yang dirancang untuk menjadi pendamping digital bagi para ibu dan calon ibu, mulai dari fase pranikah, kehamilan, hingga parenting. Aplikasi ini menyediakan alat untuk memantau kesehatan mental, melacak data penting, serta menjadi platform edukasi dan konsultasi dengan tenaga kesehatan profesional.

---

## Fitur Utama

Aplikasi ini memiliki tiga peran pengguna utama dengan fitur yang disesuaikan untuk masing-masing peran.

### 1. Untuk User

* **Asesmen Kesehatan Mental**: Mengisi kuesioner DASS-21 untuk mengetahui tingkat depresi, kecemasan, dan stres.
* **Riwayat & Tren**: Melihat riwayat hasil asesmen dalam bentuk tabel dan grafik tren untuk memantau perkembangan kondisi.
* **Rekomendasi Personal**: Mendapatkan rekomendasi tindakan berdasarkan level kondisi kesehatan mental terakhir.
* **Forum Publik**: *(Fitur Mendatang)* Ajukan pertanyaan dan lihat jawaban dari perawat.
* **Pelacakan Kesehatan**: *(Fitur Mendatang)* Mencatat siklus menstruasi, data kehamilan, dan tumbuh kembang anak.
* **Artikel Edukasi**: *(Fitur Mendatang)* Mengakses konten edukasi seputar pranikah, kehamilan, dan parenting.
* **Jurnal Pribadi**: *(Fitur Mendatang)* Menulis jurnal harian untuk refleksi diri.
* **Reminder**: *(Fitur Mendatang)* Dapatkan notifikasi untuk imunisasi dan siklus kesehatan.

### 2. Untuk Tenaga Kesehatan (Perawat)

* **Dasbor Pertanyaan**: *(Fitur Mendatang)* Melihat daftar semua pertanyaan yang masuk dari pasien di forum.
* **Sistem Ambil & Jawab**: *(Fitur Mendatang)* Mengambil (assign) pertanyaan untuk dijawab, mencegah jawaban ganda dari perawat lain.
* **Data Anak**: *(Fitur Mendatang)* Kelola data tumbuh kembang dan riwayat imunisasi.


### 3. Untuk Admin

* **Manajemen Pengguna**: *(Fitur Mendatang)* CRUD untuk semua data pengguna.
* **Manajemen Konten**: *(Fitur Mendatang)* Mengelola semua artikel.
* **Moderasi Forum**: *(Fitur Mendatang)* Manajemen data forum dan laporan aplikasi.

---

## Teknologi yang Digunakan

* **Backend**: PHP 8.2+, Laravel 12
* **Frontend**: Blade, Tailwind CSS, Alpine.js
* **Database**: MySQL / MariaDB
* **Manajer Paket**: Composer, NPM

---

## Instalasi Proyek

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal.

1.  **Clone Repository**
    ```bash
    git clone https://github.com/mizzcode/pulsecare.git
    cd pulsecare
    ```

2.  **Install Dependensi**
    Pastikan Anda memiliki Composer dan NPM terinstal.
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan**
    Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
    ```bash
    cp .env.example .env
    ```
    Setelah itu, buka file `.env` dan atur `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`.

4.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```
5.  **Create Symbolic Link**
    ```bash
    php artisan storage:link
    ```

6.  **Jalankan Migrasi dan Seeder**
    Perintah ini akan membuat semua tabel database dan mengisinya dengan data awal (role, user, pertanyaan, dll).
    ```bash
    php artisan migrate --seed
    ```

7.  **Jalankan Server**
    Kompilasi aset frontend dan jalankan server pengembangan.
    ```bash
    composer run dev
    ```
8.  **Akses Aplikasi**
    Buka browser Anda dan kunjungi `http://127.0.0.1:8000`. Anda bisa login dengan akun default yang dibuat oleh seeder:
    - **Admin**: `mizz@gmail.com` / `password`
    - **Perawat**: `jani@gmail.com` / `password`
    - **User**: `zul@gmail.com` / `password`

---

## Kontribusi

Kontribusi untuk pengembangan proyek ini sangat diterima. Silakan buat *pull request* atau buka *issue* untuk diskusi lebih lanjut. Pastikan untuk mengikuti standar coding yang ada.
