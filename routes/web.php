<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboardController,
    ImportSiswaController, ImportGuruController, AdminSiswaController, 
    AdminGuruController, PerusahaanController, FormatLaporanController, 
    PendaftaranPklController as AdminPendaftaranController, 
    LaporanController as AdminLaporanController
};

// Guru Controllers
use App\Http\Controllers\Guru\{
    DashboardController as GuruDashboardController, BimbinganPKLController, 
    SiswaBimbinganController, NilaiController, MonitoringController, InstansiController,
    SPKController
};

// Siswa Controllers
use App\Http\Controllers\Siswa\{
    DashboardController as SiswaDashboardController, LaporanController as SiswaLaporanController, 
    PendaftaranController, BimbinganController
};


/*
|--------------------------------------------------------------------------
| 1. Public & Auth Redirect Logic
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Auth::check() ? redirect('/redirect') : redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => redirect('/redirect'))->name('dashboard');

    Route::get('/redirect', function () {
        $role = strtolower(trim(Auth::user()->role));
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru'  => redirect()->route('guru.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => abort(403, 'Role tidak dikenali'),
        };
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| 2. Role: Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

 // --- BAGIAN SISWA ---
    Route::resource('siswa', AdminSiswaController::class);
    // Route nampilin form import siswa
    Route::get('/siswa-import', [ImportSiswaController::class, 'index'])->name('siswa.import.form'); 
    // Route proses upload siswa
    Route::post('/siswa-import', [ImportSiswaController::class, 'store'])->name('siswa.import');
    
    // --- BAGIAN GURU ---
    // 1. Taruh Import DULUAN (Custom Route)
    Route::get('/guru-import', [ImportGuruController::class, 'index'])->name('guru.import.form'); 
    Route::post('/guru-import', [ImportGuruController::class, 'store'])->name('guru.import');

    // 2. Baru Resource (Standard CRUD)
    Route::resource('guru', AdminGuruController::class);

    // Perusahaan
    Route::resource('perusahaan', PerusahaanController::class);
    Route::post('/perusahaan/{id}/approve', [PerusahaanController::class, 'approve'])->name('perusahaan.approve');
    Route::post('/perusahaan/{id}/reject', [PerusahaanController::class, 'reject'])->name('perusahaan.reject');
    
    // Pendaftaran (Full Control)
    Route::get('/pendaftaran', [AdminPendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran/{id}/verifikasi', [AdminPendaftaranController::class, 'verifikasi'])->name('pendaftaran.verifikasi');
    Route::delete('/pendaftaran/{id}', [AdminPendaftaranController::class, 'destroy'])->name('pendaftaran.destroy'); 
    
    // Laporan & Format
    Route::get('/laporan/verifikasi', [AdminLaporanController::class, 'index'])->name('laporan.verifikasi');
    Route::post('/laporan/verifikasi/{id}', [AdminLaporanController::class, 'verifikasi'])->name('laporan.verifikasi.process');
    Route::resource('format-laporan', FormatLaporanController::class)->names('format')->only(['index', 'destroy']);
    Route::post('/format-laporan/upload', [FormatLaporanController::class, 'upload'])->name('format.upload');
    Route::get('/laporan/download/{id}', [FormatLaporanController::class, 'downloadLaporan'])->name('laporan.download');});
    Route::delete('/admin/laporan/{id}', [AdminLaporanController::class, 'destroy'])->name('admin.laporan.destroy');
/*
|--------------------------------------------------------------------------
| 3. Role: Guru
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.siswa');
    Route::get('/instansi', [InstansiController::class, 'index'])->name('instansi.index');
    
    // Bimbingan PKL (Verifikasi & Destroy)
    Route::get('/bimbingan', [BimbinganPKLController::class, 'index'])->name('bimbingan.index');
    Route::post('/bimbingan/{id}/verifikasi', [BimbinganPKLController::class, 'verifikasi'])->name('bimbingan.verifikasi');
    Route::delete('/bimbingan/{id}', [BimbinganPKLController::class, 'destroy'])->name('bimbingan.destroy'); // FITUR DESTROY BUAT GURU
    
    // Nilai (Pastiin .index sinkron sama Sidebar)
    Route::resource('nilai', NilaiController::class)->names(['index' => 'nilai.index'])->except(['show', 'create', 'edit']);

    // SPK Module (KNN)
    Route::prefix('spk')->name('spk.')->group(function() {
        Route::get('/', [SPKController::class, 'index'])->name('index'); 
        Route::get('/training', [SPKController::class, 'training'])->name('training');
        Route::post('/training', [SPKController::class, 'storeTraining'])->name('training.store');
        Route::delete('/training/{id}', [SPKController::class, 'destroyTraining'])->name('training.destroy');
        // Di web.php lo tertulis:
        Route::get('/input/{id}', [SPKController::class, 'input'])->name('input'); 
        Route::post('/input/{id}', [SPKController::class, 'storeInput'])->name('store');
        Route::post('/predict/{id}', [SPKController::class, 'predict'])->name('predict'); 
    });
    
});

/*
|--------------------------------------------------------------------------
| 4. Role: Siswa
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::resource('pendaftaran', PendaftaranController::class)->names(['index' => 'pendaftaran.index']);
    
    // Perusahaan Management (Custom Controller)
    Route::controller(SiswaDashboardController::class)->group(function () {
        Route::get('/perusahaan', 'perusahaan')->name('perusahaan');
        Route::get('/perusahaan/create', 'createPerusahaan')->name('perusahaan.create');
        Route::post('/perusahaan/store', 'storePerusahaan')->name('perusahaan.store');
        Route::get('/perusahaan/{id}', 'showPerusahaan')->name('perusahaan.show');
    });

    // Laporan (FIXED NAME)
    Route::get('/laporan', [SiswaLaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/upload', [SiswaLaporanController::class, 'upload'])->name('laporan.upload');
    Route::get('/laporan/download', [SiswaLaporanController::class, 'download'])->name('laporan.download');
    
    // Bimbingan
    Route::get('/bimbingan', [BimbinganController::class, 'index'])->name('bimbingan');
    Route::post('/bimbingan', [BimbinganController::class, 'store'])->name('bimbingan.store');

    // Format Laporan (External Controller)
    Route::get('/format-laporan', [SiswaLaporanController::class, 'format'])->name('format');
});