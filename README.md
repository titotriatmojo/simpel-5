# 🎓 SIMPEL-5 (Sistem Informasi Praktik Kerja Lapangan)

**SIMPEL-5** adalah aplikasi web berbasis Laravel untuk mempermudah pengelolaan proses **Praktik Kerja Lapangan (PKL)** di lingkungan **Jurusan Kampus**. Sistem ini menyediakan fitur lengkap mulai dari pendaftaran PKL, pengajuan bimbingan, unggah laporan, hingga penilaian akhir oleh guru pembimbing.

> Dibuat sebagai proyek pribadi.

## 📌 Fitur Utama

Untuk semua roles:

- Login dengan NIM/NIP/Email
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
- Training dataset dengan KNN (manual & import Excel (soon))

### 🎓 Siswa

- Pendaftaran PKL dan pantau status pendaftaran dengan guru pembimbing
- Lihat list perusahaan
- Tambah rekomendasi perusahaan
- Ajukan bimbingan PKL
- Upload laporan PKL
- Unduh format laporan PKL

## 🧩 Teknologi

- Laravel 11
- Laravel Breeze (auth)
- Tailwind CSS
- Vite
- MySQL

## Tampilan User Interface

### 🔑 Login

<table>
  <tr>
    <td><img src="public/screenshots/Login-page.png" alt="Login" width="220" /></td>
  </tr>
</table>

### 🎛️ Admin

<table>
  <tr>
    <td><img src="public/screenshots/Admin-1.png" alt="Admin 1" width="220" /></td>
    <td><img src="public/screenshots/Admin-2.png" alt="Admin 2" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/Admin-3.png" alt="Admin 3" width="220" /></td>
    <td><img src="public/screenshots/Admin-4.png" alt="Admin 4" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/Admin-5.png" alt="Admin 5" width="220" /></td>
    <td><img src="public/screenshots/Admin-6.png" alt="Admin 6" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/Admin-7.png" alt="Admin 7" width="220" /></td>
    <td><img src="public/screenshots/Admin-8.png" alt="Admin 8" width="220" /></td>
  </tr>
</table>

### 🎓 Siswa

<table>
  <tr>
    <td><img src="public/screenshots/Siswa-1.png" alt="Siswa 1" width="220" /></td>
    <td><img src="public/screenshots/Siswa-2.png" alt="Siswa 2" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/Siswa-3.png" alt="Siswa 3" width="220" /></td>
    <td><img src="public/screenshots/Siswa-4.png" alt="Siswa 4" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/Siswa-5.png" alt="Siswa 5" width="220" /></td>
    <td><img src="public/screenshots/Siswa-6.png" alt="Siswa 6" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/Siswa-7.png" alt="Siswa 7" width="220" /></td>
    <td></td>
  </tr>
</table>

### 🧑‍🏫 Guru

<table>
  <tr>
    <td><img src="public/screenshots/Guru-1.png" alt="Guru 1" width="220" /></td>
    <td><img src="public/screenshots/Guru-2.png" alt="Guru 2" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/Guru-3.png" alt="Guru 3" width="220" /></td>
    <td><img src="public/screenshots/Guru-4.png" alt="Guru 4" width="220" /></td>
  </tr>
  <tr>
    <td><img src="public/screenshots/Guru-5.png" alt="Guru 5" width="220" /></td>
    <td></td>
  </tr>
</table>
