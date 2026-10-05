<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\CalonSiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenSiswaController;
use App\Http\Controllers\GelombangController;
use App\Http\Controllers\HomepageBannerController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\HomepageSettingController;
use App\Http\Controllers\JalurController;
use App\Http\Controllers\JenisDokumenController;
use App\Http\Controllers\KebutuhanKhususController;
use App\Http\Controllers\KomponenSeleksiController;
use App\Http\Controllers\NilaiSeleksiController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PenghasilanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaAdminController;
use App\Http\Controllers\BrosurAdminController;
use App\Http\Controllers\TatacaraAdminController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/tata-cara', [HomepageController::class, 'tatacaraIndex'])->name('tatacara.publik');
Route::get('/alur-pendaftaran', [HomepageController::class, 'tatacaraIndex']);
Route::get('/panduan', [HomepageController::class, 'tatacaraIndex']);
Route::get('/informasi', [HomepageController::class, 'informasiIndex'])->name('informasi.index');
Route::get('/informasi/{id}', [HomepageController::class, 'informasiDetail'])->name('informasi.detail');
Route::get('/biaya-dan-brosur', [HomepageController::class, 'biayaIndex'])->name('biaya.publik');
Route::get('/biaya', [HomepageController::class, 'biayaIndex']);
Route::get('/brosur', [HomepageController::class, 'biayaIndex']);

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginproses')->name('login.proses');
    Route::get('/loginproses', 'loginproses');
    Route::post('/loginproses', 'loginproses')->name('loginproses');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerproses')->name('register.proses');
    Route::get('/registerproses', 'registerproses');
    Route::post('/registerproses', 'registerproses')->name('registerproses');

    Route::match(['get', 'post'], '/logout', 'logout')->name('logout');
});

Route::middleware(['checkrole:*'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifikasi-realtime', [\App\Http\Controllers\NotifikasiController::class, 'index'])->name('notifikasi.realtime');

    // Kelola Homepage & Layanan WA (Super Admin & Admin PPDB)
    Route::middleware(['checkrole:super_admin,admin_ppdb'])->group(function () {
        Route::resource('homepage-banner', HomepageBannerController::class)->parameters(['homepage-banner' => 'homepageBanner']);
        Route::get('homepage-setting', [HomepageSettingController::class, 'index'])->name('homepage-setting.index');
        Route::post('homepage-setting', [HomepageSettingController::class, 'update'])->name('homepage-setting.update');

        // Pengaturan Khusus WhatsApp Admin
        Route::get('wa-admin', [WaAdminController::class, 'index'])->name('wa-admin.index');
        Route::post('wa-admin', [WaAdminController::class, 'update'])->name('wa-admin.update');

        // Pengaturan Khusus Brosur PPDB (Upload & Link Drive)
        Route::get('brosur-setting', [BrosurAdminController::class, 'index'])->name('brosur-setting.index');
        Route::post('brosur-setting', [BrosurAdminController::class, 'update'])->name('brosur-setting.update');

        // Pengaturan Khusus Tata Cara PPDB
        Route::get('tatacara-setting', [TatacaraAdminController::class, 'index'])->name('tatacara-setting.index');
        Route::post('tatacara-setting', [TatacaraAdminController::class, 'update'])->name('tatacara-setting.update');
    });

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

    // Data Pendaftaran: Calon Siswa & Dokumen (Semua role terkait pendaftaran)
    Route::middleware(['checkrole:super_admin,admin_ppdb,verifikator,kepala_sekolah,bendahara,guru,pendaftar'])->group(function () {
        Route::patch('calon-siswa/{calonSiswa}/status', [CalonSiswaController::class, 'updateStatus'])
            ->middleware('checkrole:super_admin,admin_ppdb,verifikator,kepala_sekolah')
            ->name('calon-siswa.update-status');
        Route::resource('calon-siswa', CalonSiswaController::class)->parameters(['calon-siswa' => 'calonSiswa']);
        Route::resource('dokumen', DokumenSiswaController::class)->parameters(['dokumen' => 'dokumen']);
    });

    // Proses PPDB: Pembayaran (Super Admin, Admin PPDB, Bendahara, Pendaftar)
    Route::middleware(['checkrole:super_admin,admin_ppdb,bendahara,pendaftar'])->group(function () {
        Route::patch('pembayaran/{pembayaran}/status', [PembayaranController::class, 'updateStatus'])
            ->middleware('checkrole:super_admin,admin_ppdb,bendahara')
            ->name('pembayaran.update-status');
        Route::get('pembayaran/{pembayaran}/kwitansi', [PembayaranController::class, 'kwitansi'])->name('pembayaran.kwitansi');
        Route::resource('pembayaran', PembayaranController::class);
    });

    // Proses PPDB: Penilaian & Ujian Seleksi (Super Admin, Admin PPDB, Kepala Sekolah, Guru)
    Route::middleware(['checkrole:super_admin,admin_ppdb,kepala_sekolah,guru'])->group(function () {
        Route::resource('nilai-seleksi', NilaiSeleksiController::class)->only(['index', 'edit', 'update'])->parameters(['nilai-seleksi' => 'calonSiswa']);
    });

    // Proses PPDB: Pengumuman Kelulusan
    Route::middleware(['checkrole:super_admin,admin_ppdb,kepala_sekolah'])->group(function () {
        Route::resource('pengumuman', PengumumanController::class)->except(['index', 'show']);
    });
    Route::middleware(['checkrole:super_admin,admin_ppdb,kepala_sekolah,pendaftar'])->group(function () {
        Route::get('pengumuman/surat-kelulusan/{calonSiswa}', [PengumumanController::class, 'suratKelulusan'])->name('pengumuman.surat-kelulusan');
        Route::resource('pengumuman', PengumumanController::class)->only(['index', 'show']);
    });
});