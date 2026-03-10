<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\{
    ImportSiswaController, ImportGuruController, AdminSiswaController, 
    AdminGuruController, PerusahaanController, FormatLaporanController, 
    PendaftaranPklController, LaporanController as AdminLaporanController
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
| 1. Public & Redirect Logic
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check() ? redirect('/redirect') : redirect('/login');
});

Route::get('/dashboard', function () {
    return redirect('/redirect');
})->middleware(['auth'])->name('dashboard');

Route::get('/redirect', function () {
    if (!Auth::check()) return redirect('/login');
    
    $role = strtolower(trim(Auth::user()->role));
    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'guru'  => redirect()->route('guru.dashboard'),
        'siswa' => redirect()->route('siswa.dashboard'),
        default => abort(403, 'Role tidak dikenali'),
    };
})->middleware('auth');

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| 2. Shared Routes (Profile) - FIXED NAME
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // FIXED: dari profile.edit ke profile.destroy
});

/*
|--------------------------------------------------------------------------
| 3. Role: Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('siswa', AdminSiswaController::class);
    Route::get('/siswa-import', [ImportSiswaController::class, 'create'])->name('siswa.import.form');
    Route::post('/siswa-import', [ImportSiswaController::class, 'store'])->name('siswa.import');
    
    Route::resource('guru', AdminGuruController::class);
    Route::get('/guru-import', [ImportGuruController::class, 'create'])->name('guru.import.form');
    Route::post('/guru-import', [ImportGuruController::class, 'store'])->name('guru.import');

    Route::resource('perusahaan', PerusahaanController::class);
    Route::post('/perusahaan/{id}/approve', [PerusahaanController::class, 'approve'])->name('perusahaan.approve');
    Route::post('/perusahaan/{id}/reject', [PerusahaanController::class, 'reject'])->name('perusahaan.reject');
    
    Route::get('/pendaftaran', [PendaftaranPklController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran/{id}/verifikasi', [PendaftaranPklController::class, 'verifikasi'])->name('pendaftaran.verifikasi');
    Route::delete('/pendaftaran/{id}', [PendaftaranPklController::class, 'destroy'])->name('pendaftaran.destroy'); 

    Route::get('/laporan/verifikasi', [AdminLaporanController::class, 'index'])->name('laporan.verifikasi');
    Route::post('/laporan/verifikasi/{id}', [AdminLaporanController::class, 'verifikasi'])->name('laporan.verifikasi.process');

    Route::resource('format-laporan', FormatLaporanController::class)->names('format')->only(['index', 'destroy']);
    Route::post('/format-laporan/upload', [FormatLaporanController::class, 'upload'])->name('format.upload');
});

/*
|--------------------------------------------------------------------------
| 4. Role: Guru - FIXED NILAI ROUTE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.siswa');
    Route::get('/instansi', [InstansiController::class, 'index'])->name('instansi.index');
    Route::get('/siswa-bimbingan', [SiswaBimbinganController::class, 'index'])->name('siswa.bimbingan');
    
    Route::get('/bimbingan', [BimbinganPKLController::class, 'index'])->name('bimbingan');
    Route::post('/bimbingan/{id}/verifikasi', [BimbinganPKLController::class, 'verifikasi'])->name('bimbingan.verifikasi');
    
    // Pakai resource tapi pastikan .index nya terdaftar jelas
    Route::resource('nilai', NilaiController::class)->names([
        'index' => 'nilai' // Menyamakan dengan pemanggilan x-sidebar-link route="guru.nilai"
    ])->except(['show', 'create', 'edit']);

    Route::prefix('spk')->name('spk.')->group(function() {
        Route::get('/', [SPKController::class, 'index'])->name('index'); 
        Route::get('/training', [SPKController::class, 'training'])->name('training');
        Route::post('/training', [SPKController::class, 'storeTraining'])->name('training.store');
        Route::delete('/training/{id}', [SPKController::class, 'destroyTraining'])->name('training.destroy');
        Route::post('/import-alumni', [SPKController::class, 'importAlumni'])->name('import'); 
        Route::get('/input/{id}', [SPKController::class, 'input'])->name('input'); 
        Route::post('/input/{id}', [SPKController::class, 'storeInput'])->name('store');
        Route::post('/predict/{id}', [SPKController::class, 'predict'])->name('predict'); 
    });
});

/*
|--------------------------------------------------------------------------
| 5. Role: Siswa
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::resource('pendaftaran', PendaftaranController::class)->names('pendaftaran');
    
    Route::get('/perusahaan', [SiswaDashboardController::class, 'perusahaan'])->name('perusahaan');
    Route::get('/perusahaan/create', [SiswaDashboardController::class, 'createPerusahaan'])->name('perusahaan.create');
    Route::post('/perusahaan/store', [SiswaDashboardController::class, 'storePerusahaan'])->name('perusahaan.store');
    Route::get('/perusahaan/{id}', [SiswaDashboardController::class, 'showPerusahaan'])->name('perusahaan.show');

    Route::get('/laporan', [SiswaLaporanController::class, 'index'])->name('laporan');
    Route::post('/laporan/upload', [SiswaLaporanController::class, 'upload'])->name('laporan.upload');
    
    Route::get('/bimbingan', [BimbinganController::class, 'index'])->name('bimbingan');
    Route::post('/bimbingan', [BimbinganController::class, 'store'])->name('bimbingan.store');

    Route::get('/format-laporan', function () {
        $format = \App\Models\FormatLaporan::latest()->get();
        return view('siswa.format.index', compact('format'));
    })->name('format');
});