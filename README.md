# 🎓 SIMPEL-5 (Sistem Monitoring PKL SMKN 5)

**SIMPEL-5** adalah aplikasi web berbasis Laravel untuk mempermudah pengelolaan proses **Praktik Kerja Lapangan (PKL)** di lingkungan **SMKN 5 Kabupaten Tangerang**. Sistem ini menyediakan fitur lengkap mulai dari pendaftaran PKL, pengajuan tempat PKL, manajemen dan monitoring siswa beserta instansi, upload laporan, penilaian akhir oleh guru pembimbing, hingga prediksi kesiapan kerja siswa.

Catatan:

- Untuk seeder admin, guru, siswa, password default nya adalah "password"
- Untuk import data guru dan siswa password default nya adalah NISN/NIP sesuai data pada file import
- Untuk menjalankan project

## 🚀 Cara Menjalankan Proyek

### 1. Jalankan Laragon

1. Buka aplikasi **Laragon**.
2. Klik tombol **Start All** untuk mengaktifkan service **Apache/Nginx** dan **MySQL**.

---

### 2. Jalankan Aplikasi (Pilih Salah Satu Cara)

#### Opsi A: Cara Cepat (Rekomendasi - Laravel 11)

Cukup jalankan satu perintah di bawah ini untuk mengaktifkan _Server_, _Vite (Frontend)_, dan _Queue Worker_ sekaligus secara paralel dalam satu terminal:

```bash
composer dev
```

> Dibuat sebagai proyek untuk skripsi.

## 📌 Fitur Utama

Untuk semua roles:

- Login dengan NISN/NIP/Email
- Nama lengkap
- Email
- No Telepon
- Alamat
- Perbarui kata sandi

### 🔐 Otentikasi Role

- Admin
- Guru Pembimbing
- Siswa

### 🎛️ Admin

- Dashboard statistik
- Kelola data siswa dan guru (manual & import Excel)
- Kelola dan tambah perusahaan mitra
- Verifikasi pendaftaran dan terima laporan PKL
- Upload format laporan resmi

### 🧑‍🏫 Guru

- Lihat dan pantau daftar siswa pkl
- Lihat daftar instansi
- Input nilai PKL
- Analisis kesiapan kerja dengan KNN
- Training dataset dengan K-NN (manual & import Excel)
- Cek akurasi K-NN dengan Confusion Matrix

### 🎓 Siswa

- Pendaftaran PKL dan pantau status pendaftaran dengan guru pembimbing
- Lihat list perusahaan
- Tambah rekomendasi perusahaan
- Upload laporan PKL
- Unduh format laporan PKL

## 🧩 Teknologi

- **Laravel Framework:** `11.45.0`
- **PHP:** `8.2.12`
- **Database:** MySQL
- **Laravel Breeze (Auth):** Terpasang (_scaffolding_ berbasis Tailwind CSS & Alpine.js)
- **Spatie Laravel-Permission:** `6.25.0`
- **Vite:** `6.0.11` (`laravel-vite-plugin: ^1.2.0`)
- **Tailwind CSS:** `3.1.0` (`@tailwindcss/forms: ^0.5.2`)
- **Bootstrap:** `5.3.6` (`@popperjs/core: ^2.11.8`, `sass: ^1.89.0`)
- **Alpine.js:** `3.4.2`
- **Axios:** `1.7.4`
- **Autoprefixer:** `10.4.2`
- **PostCSS:** `8.4.31`
- **Concurrently:** `9.0.1`

## Tampilan User Interface

### 🔑 Login

<table>
  <tr>
    <td><img src="public/screenshots/login-1.png" alt="Login" width="220" /></td>
  </tr>
</table>

### 🎛️ Admin

<table>
  <tr>
    <td><img src="public/screenshots/admin-1.png" alt="Admin 1" width="220" /></td>
    <td><img src="public/screenshots/admin-2.png" alt="Admin 2" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/admin-3.png" alt="Admin 3" width="220" /></td>
    <td><img src="public/screenshots/admin-4.png" alt="Admin 4" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/admin-5.png" alt="Admin 5" width="220" /></td>
    <td><img src="public/screenshots/admin-6.png" alt="Admin 6" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/admin-7.png" alt="Admin 7" width="220" /></td>
    <td><img src="public/screenshots/admin-8.png" alt="Admin 8" width="220" /></td>
  </tr>
</table>

### 🎓 Siswa

<table>
  <tr>
    <td><img src="public/screenshots/siswa-1.png" alt="Siswa 1" width="220" /></td>
    <td><img src="public/screenshots/siswa-2.png" alt="Siswa 2" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/siswa-3.png" alt="Siswa 3" width="220" /></td>
    <td><img src="public/screenshots/siswa-4.png" alt="Siswa 4" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/siswa-5.png" alt="Siswa 5" width="220" /></td>
  </tr>
</table>

### 🧑‍🏫 Guru

<table>
  <tr>
    <td><img src="public/screenshots/guru-1.png" alt="Guru 1" width="220" /></td>
    <td><img src="public/screenshots/guru-2.png" alt="Guru 2" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/guru-3.png" alt="Guru 3" width="220" /></td>
    <td><img src="public/screenshots/guru-4.png" alt="Guru 4" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/guru-5.png" alt="Guru 5" width="220" /></td>
    <td><img src="public/screenshots/guru-5.png" alt="Guru 5" width="220" /></td>
  </tr>
</table>
