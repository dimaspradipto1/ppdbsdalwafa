<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalonSiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KebutuhanKhususController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PenghasilanController;
use App\Http\Controllers\SekolahController;
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

    // Pengaturan & Master: Sekolah (Super Admin, Admin PPDB, Kepala Sekolah)
    Route::middleware(['checkrole:super_admin,admin_ppdb,kepala_sekolah'])->group(function () {
        Route::resource('sekolah', SekolahController::class);
    });

    // Pengaturan & Master: Agama, Pendidikan, Pekerjaan, Penghasilan & Kebutuhan Khusus (Super Admin, Admin PPDB)
    Route::middleware(['checkrole:super_admin,admin_ppdb'])->group(function () {
        Route::resource('agama', AgamaController::class);
        Route::resource('pendidikan', PendidikanController::class);
        Route::resource('pekerjaan', PekerjaanController::class);
        Route::resource('penghasilan', PenghasilanController::class);
        Route::resource('kebutuhan-khusus', KebutuhanKhususController::class)->parameters(['kebutuhan-khusus' => 'kebutuhanKhusus']);
    });

    // Data Pendaftaran: Calon Siswa (Super Admin, Admin PPDB, Verifikator, Kepala Sekolah, Bendahara, Guru, Pendaftar)
    Route::middleware(['checkrole:super_admin,admin_ppdb,verifikator,kepala_sekolah,bendahara,guru,pendaftar'])->group(function () {
        Route::resource('calon-siswa', CalonSiswaController::class)->parameters(['calon-siswa' => 'calonSiswa']);
    });
});