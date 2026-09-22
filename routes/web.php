<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\CalonSiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenSiswaController;
use App\Http\Controllers\GelombangController;
use App\Http\Controllers\JalurController;
use App\Http\Controllers\JenisDokumenController;
use App\Http\Controllers\KebutuhanKhususController;
use App\Http\Controllers\KomponenSeleksiController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PenghasilanController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/login', 'login');
    Route::post('/login', 'loginproses')->name('login.proses');
    Route::get('/loginproses', 'loginproses');
    Route::post('/loginproses', 'loginproses')->name('loginproses');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerproses')->name('register.proses');
    Route::get('/registerproses', 'registerproses');
    Route::post('/registerproses', 'registerproses')->name('registerproses');

    Route::post('/logout', 'logout')->name('logout');
    Route::get('/logout', 'logout');
});

Route::middleware(['checkrole:*'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pengaturan & Master: Users (Super Admin)
    Route::middleware(['checkrole:super_admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Pengaturan & Master: Sekolah, Tahun Ajaran, Gelombang, Jalur, & Komponen Seleksi (Super Admin, Admin PPDB, Kepala Sekolah)
    Route::middleware(['checkrole:super_admin,admin_ppdb,kepala_sekolah'])->group(function () {
        Route::post('sekolah/update-logo', [SekolahController::class, 'updateLogo'])->name('sekolah.update-logo');
        Route::resource('sekolah', SekolahController::class);
        Route::resource('tahun-ajaran', TahunAjaranController::class)->parameters(['tahun-ajaran' => 'tahunAjaran']);
        Route::resource('gelombang', GelombangController::class);
        Route::resource('jalur', JalurController::class);
        Route::resource('komponen-seleksi', KomponenSeleksiController::class)->parameters(['komponen-seleksi' => 'komponenSeleksi']);
    });

    // Pengaturan & Master: Tarif & Biaya PPDB (Super Admin, Admin PPDB, Bendahara)
    Route::middleware(['checkrole:super_admin,admin_ppdb,bendahara'])->group(function () {
        Route::resource('biaya', BiayaController::class);
    });

    // Pengaturan & Master: Persyaratan Dokumen & Biodata (Super Admin, Admin PPDB)
    Route::middleware(['checkrole:super_admin,admin_ppdb'])->group(function () {
        Route::resource('persyaratan-dokumen', JenisDokumenController::class)->parameters(['persyaratan-dokumen' => 'jenisDokumen']);
        Route::resource('agama', AgamaController::class);
        Route::resource('pendidikan', PendidikanController::class);
        Route::resource('pekerjaan', PekerjaanController::class);
        Route::resource('penghasilan', PenghasilanController::class);
        Route::resource('kebutuhan-khusus', KebutuhanKhususController::class)->parameters(['kebutuhan-khusus' => 'kebutuhanKhusus']);
    });

    // Data Pendaftaran: Calon Siswa & Dokumen (Super Admin, Admin PPDB, Verifikator, Kepala Sekolah, Bendahara, Guru, Pendaftar)
    Route::middleware(['checkrole:super_admin,admin_ppdb,verifikator,kepala_sekolah,bendahara,guru,pendaftar'])->group(function () {
        Route::resource('calon-siswa', CalonSiswaController::class)->parameters(['calon-siswa' => 'calonSiswa']);
        Route::resource('dokumen', DokumenSiswaController::class)->parameters(['dokumen' => 'dokumen']);
    });
});