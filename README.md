# 🎓 SIMPEL-5 (Sistem Monitoring PKL SMKN 5)

**SIMPEL-5** adalah aplikasi web berbasis Laravel untuk mempermudah pengelolaan proses **Praktik Kerja Lapangan (PKL)** di lingkungan **SMKN 5 Kabupaten Tangerang**. Sistem ini menyediakan fitur lengkap mulai dari pendaftaran PKL, pengajuan tempat PKL, manajemen dan monitoring siswa beserta instansi, upload laporan, penilaian akhir oleh guru pembimbing, hingga prediksi kesiapan kerja siswa.

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
