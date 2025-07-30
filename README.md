# PulseCare - Aplikasi Kesehatan Ibu dan Anak

**PulseCare** adalah aplikasi web berbasis Laravel yang dirancang untuk menjadi pendamping digital bagi para ibu dan calon ibu, mulai dari fase pranikah, kehamilan, hingga parenting. Aplikasi ini menyediakan alat untuk memantau kesehatan mental, melacak data penting, serta menjadi platform edukasi dan konsultasi dengan tenaga kesehatan profesional.

---

## Fitur Utama

Aplikasi ini memiliki tiga peran pengguna utama dengan fitur yang disesuaikan untuk masing-masing peran.

### 1. Untuk User Pasien

- **Asesmen Kesehatan Mental**: Mengisi kuesioner DASS-21 untuk mengetahui tingkat depresi, kecemasan, dan stres.
- **Riwayat & Tren**: Melihat riwayat hasil asesmen dalam bentuk tabel dan grafik tren untuk memantau perkembangan kondisi.
- **Rekomendasi Personal**: Mendapatkan rekomendasi tindakan berdasarkan level kondisi kesehatan mental terakhir.
- **Chat Dokter**: Sistem chat real-time untuk konsultasi langsung dengan tenaga kesehatan profesional.
- **Riwayat Chat**: Melihat riwayat percakapan dengan dokter untuk reference masa depan.
- **Pelacakan Kesehatan**: _(Fitur Mendatang)_ Mencatat siklus menstruasi, data kehamilan, dan tumbuh kembang anak.
- **Artikel Edukasi**: Mengakses konten edukasi seputar pranikah, kehamilan, parenting dan lain sebagainya.
- **Jurnal Pribadi**: _(Fitur Mendatang)_ Menulis jurnal harian untuk refleksi diri.
- **Reminder**: _(Fitur Mendatang)_ Dapatkan notifikasi untuk imunisasi dan siklus kesehatan.

### 2. Untuk Tenaga Kesehatan (Dokter)

- **Dashboard Chat**: Melihat dan mengelola percakapan dengan pasien melalui sistem chat real-time.
- **Chat Pasien**: Membalas pertanyaan dari pasien dan memberikan konsultasi melalui chat.
- **Riwayat Chat**: Melihat riwayat percakapan dengan pasien untuk follow-up yang lebih baik.
- **Manajemen Konsultasi**: Mengelola status chat (aktif/ditutup) dan melacak aktivitas konsultasi.
- **Data Anak**: _(Fitur Mendatang)_ Kelola data tumbuh kembang dan riwayat imunisasi.

### 3. Untuk Admin

### 3. Untuk Admin

- **Dashboard Analytics**: Dashboard lengkap dengan statistik sistem, grafik pertumbuhan user, dan analisis data.
- **Manajemen Pengguna**: CRUD lengkap untuk semua data pengguna dengan fitur filter dan pencarian.
- **Manajemen Konten**: Mengelola semua artikel dengan sistem kategori dan tracking views.
- **Sistem Laporan**:
    - **Laporan Users**: Filter dan export data pengguna berdasarkan role
    - **Laporan Asesmen**: Analisis hasil asesmen kesehatan mental dengan statistik
    - **Laporan Chat**: Monitoring aktivitas chat dan konsultasi dokter-pasien
    - **Export Data**: Download laporan dalam format CSV
- **Statistik Real-time**:
    - Grafik tren registrasi pengguna dan asesmen per bulan
    - Distribusi gender pengguna
    - Analisis level stress, anxiety, dan depression
    - Chat activity dan artikel populer
- **User Management**: Tambah, edit, hapus pengguna dengan role-based access control.

---

## Teknologi yang Digunakan

- **Backend**: PHP 8.3+, Laravel 12
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Real-time**: WebSocket untuk chat real-time
- **Charts**: Chart.js untuk visualisasi data dan laporan
- **Database**: MySQL / MariaDB dengan relationship yang optimized
- **Manajer Paket**: Composer, NPM
- **Security**: Role-based middleware, CSRF protection
- **Export**: CSV export functionality untuk laporan

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
    - **Dokter**: `jen@gmail.com` / `password`
    - **User Pasien**: `patient@gmail.com` / `password`

---

## Fitur Unggulan

### 🎯 Dashboard Analytics (Admin)

- **Real-time Statistics**: Monitoring jumlah user, asesmen, chat, dan artikel
- **Interactive Charts**: Grafik tren bulanan dengan Chart.js
- **Data Visualization**: Distribusi gender, level kesehatan mental, aktivitas chat
- **Export Reports**: Download data dalam format CSV

### 💬 Chat System (Real-time)

- **Doctor-Patient Chat**: Konsultasi langsung antara dokter dan pasien
- **Chat Management**: Status active/closed, tracking last message
- **Chat History**: Riwayat percakapan untuk referensi
- **WebSocket Integration**: Real-time messaging experience

### 📊 Mental Health Assessment

- **DASS-21 Questionnaire**: Standard assessment untuk depresi, anxiety, stress
- **Progress Tracking**: Grafik tren kondisi kesehatan mental
- **Personal Recommendations**: Saran berdasarkan hasil asesmen
- **Historical Data**: Riwayat lengkap hasil asesmen

### 🔐 Advanced User Management

- **Role-based Access**: Admin, Dokter, Pasien dengan permission berbeda
- **User CRUD**: Create, Read, Update, Delete dengan validasi
- **Search & Filter**: Pencarian berdasarkan nama, email, role
- **Bulk Operations**: Export dan manage multiple users

---

## Kontribusi

Kontribusi untuk pengembangan proyek ini sangat diterima. Silakan buat _pull request_ atau buka _issue_ untuk diskusi lebih lanjut. Pastikan untuk mengikuti standar coding yang ada.
