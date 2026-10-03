<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\CalonSiswa;
use App\Models\DokumenSiswa;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\JenisDokumen;
use App\Models\KomponenSeleksi;
use App\Models\NilaiSeleksi;
use App\Models\Pembayaran;
use App\Models\Pengumuman;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan Dashboard dinamis sesuai dengan role pengguna yang sedang login.
     * Admin & Super Admin mendapatkan dashboard lengkap (Full View dari semua peran).
     */
    public function index()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $role = $user->role;
        // Normalisasi alias role lama
        if ($role === 'admin') {
            $role = 'admin_ppdb';
        } elseif ($role === 'user') {
            $role = 'pendaftar';
        }

        $sekolah = Sekolah::first();
        $tahunAktif = TahunAjaran::where('is_active', true)->first() ?? TahunAjaran::latest()->first();
        $gelombangAktif = Gelombang::where('is_active', true)->first() ?? Gelombang::latest()->first();

        // Data tren pendaftaran 6 bulan terakhir untuk grafik
        $chartBulan = [];
        $chartPendaftar = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartBulan[] = $date->translatedFormat('M Y');
            $chartPendaftar[] = CalonSiswa::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Wadah data bersama
        $data = compact('user', 'role', 'sekolah', 'tahunAktif', 'gelombangAktif', 'chartBulan', 'chartPendaftar');

        if (in_array($role, ['super_admin', 'admin_ppdb'])) {
            // =====================================================================
            // 1. TAMPILAN FULL VIEW: ADMIN & SUPER ADMIN (MENGGABUNGKAN SEMUA ROLE)
            // =====================================================================

            // Calon Siswa (Metrik Keseluruhan)
            $data['totalPendaftar'] = CalonSiswa::count();
            $data['totalDraft'] = CalonSiswa::where('status', 'draft')->count();
            $data['totalMenungguVerifikasi'] = CalonSiswa::where('status', 'menunggu_verifikasi')->count();
            $data['totalDiverifikasi'] = CalonSiswa::where('status', 'diverifikasi')->count();
            $data['totalDiterima'] = CalonSiswa::where('status', 'diterima')->count();
            $data['totalDitolak'] = CalonSiswa::where('status', 'ditolak')->count();

            // Rasio Gender
            $data['genderL'] = CalonSiswa::where('jenis_kelamin', 'Laki-laki')->count();
            $data['genderP'] = CalonSiswa::where('jenis_kelamin', 'Perempuan')->count();

            // Modul Keuangan (Bendahara)
            $data['totalPemasukan'] = Pembayaran::where('status_pembayaran', 'lunas')->sum('nominal');
            $data['totalBayarMenunggu'] = Pembayaran::where('status_pembayaran', 'menunggu_konfirmasi')->count();
            $data['totalBayarLunas'] = Pembayaran::where('status_pembayaran', 'lunas')->count();
            $data['totalBayarDitolak'] = Pembayaran::where('status_pembayaran', 'ditolak')->count();
            $data['totalTransaksi'] = Pembayaran::count();
            $data['antreanBayar'] = Pembayaran::with(['calonSiswa', 'biaya'])
                ->where('status_pembayaran', 'menunggu_konfirmasi')
                ->latest()
                ->take(5)
                ->get();
            $data['transaksiTerbaru'] = Pembayaran::with(['calonSiswa', 'biaya'])
                ->latest()
                ->take(5)
                ->get();
            $data['biayaList'] = Biaya::withSum(['pembayaran as total_terkumpul' => function ($q) {
                $q->where('status_pembayaran', 'lunas');
            }], 'nominal')->where('is_active', true)->get();

            // Modul Verifikasi (Verifikator)
            $data['totalDokumen'] = DokumenSiswa::count();
            $data['dokumenMenunggu'] = DokumenSiswa::where('status_verifikasi', 'menunggu')->count();
            $data['dokumenValid'] = DokumenSiswa::where('status_verifikasi', 'valid')->count();
            $data['dokumenDitolak'] = DokumenSiswa::where('status_verifikasi', 'ditolak')->count();
            $data['antreanVerifikasiSiswa'] = CalonSiswa::with(['gelombang', 'jalur', 'dokumen'])
                ->where('status', 'menunggu_verifikasi')
                ->latest()
                ->take(5)
                ->get();
            $data['antreanDokumen'] = DokumenSiswa::with(['calonSiswa', 'jenisDokumen'])
                ->where('status_verifikasi', 'menunggu')
                ->latest()
                ->take(5)
                ->get();

            // Modul Penilaian Ujian Seleksi (Guru / Wali Kelas)
            $data['komponenList'] = KomponenSeleksi::where('is_active', true)->orderBy('urutan')->get();
            $data['siswaSiapSeleksi'] = CalonSiswa::whereIn('status', ['diverifikasi', 'diterima', 'ditolak'])->count();
            $data['siswaSudahDinilai'] = CalonSiswa::whereHas('nilaiSeleksi')->count();
            $data['siswaBelumDinilai'] = CalonSiswa::where('status', 'diverifikasi')->whereDoesntHave('nilaiSeleksi')->count();
            $data['antreanNilaiSiswa'] = CalonSiswa::with(['gelombang', 'jalur'])
                ->where('status', 'diverifikasi')
                ->whereDoesntHave('nilaiSeleksi')
                ->latest()
                ->take(5)
                ->get();
            $data['nilaiTerbaru'] = NilaiSeleksi::with(['calonSiswa', 'komponenSeleksi'])
                ->latest()
                ->take(5)
                ->get();

            // Modul Analitik & Kuota (Kepala Sekolah)
            $data['gelombangList'] = Gelombang::withCount('calonSiswa')->latest()->take(5)->get();
            $data['jalurList'] = Jalur::withCount('calonSiswa')->get();
            $data['pendaftarTerbaru'] = CalonSiswa::with(['gelombang', 'jalur'])->latest()->take(5)->get();

            // Khusus Super Admin: Statistik Pengguna & Akun
            if ($role === 'super_admin') {
                $data['totalUsers'] = User::count();
                $data['usersByRole'] = User::selectRaw('role, count(*) as count')
                    ->groupBy('role')
                    ->pluck('count', 'role')
                    ->toArray();
            }
        } elseif ($role === 'verifikator') {
            // =====================================================================
            // 2. TAMPILAN ROLE: VERIFIKATOR (FOKUS DOKUMEN & VERIFIKASI BIODATA)
            // =====================================================================
            $data['totalPendaftar'] = CalonSiswa::count();
            $data['menungguVerifikasi'] = CalonSiswa::where('status', 'menunggu_verifikasi')->count();
            $data['sudahDiverifikasi'] = CalonSiswa::where('status', 'diverifikasi')->count();
            $data['ditolak'] = CalonSiswa::where('status', 'ditolak')->count();

            $data['dokumenMenunggu'] = DokumenSiswa::where('status_verifikasi', 'menunggu')->count();
            $data['dokumenValid'] = DokumenSiswa::where('status_verifikasi', 'valid')->count();
            $data['dokumenDitolak'] = DokumenSiswa::where('status_verifikasi', 'ditolak')->count();

            $data['antreanVerifikasiSiswa'] = CalonSiswa::with(['gelombang', 'jalur', 'dokumen'])
                ->where('status', 'menunggu_verifikasi')
                ->latest()
                ->take(10)
                ->get();

            $data['antreanDokumen'] = DokumenSiswa::with(['calonSiswa', 'jenisDokumen'])
                ->where('status_verifikasi', 'menunggu')
                ->latest()
                ->take(10)
                ->get();

            $data['riwayatVerifikasi'] = CalonSiswa::with(['gelombang', 'jalur', 'verifiedByUser'])
                ->whereIn('status', ['diverifikasi', 'ditolak'])
                ->latest('verified_at')
                ->take(6)
                ->get();

            $data['jalurList'] = Jalur::withCount('calonSiswa')->get();
        } elseif ($role === 'bendahara') {
            // =====================================================================
            // 3. TAMPILAN ROLE: BENDAHARA (FOKUS TRANSAKSI, REKAP PEMASUKAN & BIAYA)
            // =====================================================================
            $data['totalPemasukan'] = Pembayaran::where('status_pembayaran', 'lunas')->sum('nominal');
            $data['bayarMenunggu'] = Pembayaran::where('status_pembayaran', 'menunggu_konfirmasi')->count();
            $data['bayarLunas'] = Pembayaran::where('status_pembayaran', 'lunas')->count();
            $data['bayarDitolak'] = Pembayaran::where('status_pembayaran', 'ditolak')->count();
            $data['totalTransaksi'] = Pembayaran::count();

            $data['antreanPembayaran'] = Pembayaran::with(['calonSiswa', 'biaya'])
                ->where('status_pembayaran', 'menunggu_konfirmasi')
                ->latest()
                ->take(10)
                ->get();

            $data['pembayaranTerbaru'] = Pembayaran::with(['calonSiswa', 'biaya', 'verifikator'])
                ->where('status_pembayaran', 'lunas')
                ->latest()
                ->take(10)
                ->get();

            $data['biayaList'] = Biaya::withSum(['pembayaran as total_terkumpul' => function ($q) {
                $q->where('status_pembayaran', 'lunas');
            }], 'nominal')->where('is_active', true)->get();
        } elseif ($role === 'kepala_sekolah') {
            // =====================================================================
            // 4. TAMPILAN ROLE: KEPALA SEKOLAH (MONITORING EKSEKUTIF, KUOTA & HASIL)
            // =====================================================================
            $data['totalPendaftar'] = CalonSiswa::count();
            $data['totalDiterima'] = CalonSiswa::where('status', 'diterima')->count();
            $data['totalDitolak'] = CalonSiswa::where('status', 'ditolak')->count();
            $data['totalProses'] = CalonSiswa::whereIn('status', ['menunggu_verifikasi', 'diverifikasi'])->count();

            $data['genderL'] = CalonSiswa::where('jenis_kelamin', 'Laki-laki')->count();
            $data['genderP'] = CalonSiswa::where('jenis_kelamin', 'Perempuan')->count();

            $data['gelombangList'] = Gelombang::withCount('calonSiswa')->get();
            $data['jalurList'] = Jalur::withCount('calonSiswa')->get();

            $data['komponenNilai'] = KomponenSeleksi::withAvg('nilaiSeleksi as rata_nilai', 'nilai')
                ->where('is_active', true)
                ->orderBy('urutan')
                ->get();

            $data['siswaDiterimaTerbaru'] = CalonSiswa::with(['gelombang', 'jalur'])
                ->where('status', 'diterima')
                ->latest()
                ->take(8)
                ->get();
        } elseif ($role === 'guru') {
            // =====================================================================
            // 5. TAMPILAN ROLE: GURU / PENGUJI (PENILAIAN & UJIAN SELEKSI)
            // =====================================================================
            $data['komponenList'] = KomponenSeleksi::where('is_active', true)->orderBy('urutan')->get();
            $data['siswaSiapSeleksi'] = CalonSiswa::whereIn('status', ['diverifikasi', 'diterima', 'ditolak'])->count();
            $data['siswaBelumDinilai'] = CalonSiswa::where('status', 'diverifikasi')->whereDoesntHave('nilaiSeleksi')->count();
            $data['siswaSudahDinilai'] = CalonSiswa::whereHas('nilaiSeleksi')->count();

            $data['antreanNilaiSiswa'] = CalonSiswa::with(['gelombang', 'jalur', 'nilaiSeleksi'])
                ->where('status', 'diverifikasi')
                ->latest()
                ->take(12)
                ->get();

            $data['nilaiTerbaru'] = NilaiSeleksi::with(['calonSiswa', 'komponenSeleksi', 'penguji'])
                ->latest()
                ->take(8)
                ->get();
        } elseif ($role === 'pendaftar') {
            // =====================================================================
            // 6. TAMPILAN ROLE: PENDAFTAR (CALON SISWA / ORANG TUA MURID)
            // =====================================================================
            $data['calonSiswa'] = CalonSiswa::where('user_id', $user->id)
                ->with(['gelombang', 'jalur', 'tahunAjaran', 'dokumen.jenisDokumen', 'pembayaran.biaya', 'nilaiSeleksi.komponenSeleksi'])
                ->first();

            $data['dokumenWajib'] = JenisDokumen::where('is_active', true)->where('is_wajib', true)->get();
            $data['biayaFormulir'] = Biaya::where('is_active', true)
                ->where(function ($q) {
                    $q->where('jenis_biaya', 'pendaftaran')
                        ->orWhere('nama_biaya', 'like', '%pendaftaran%')
                        ->orWhere('nama_biaya', 'like', '%formulir%');
                })->first() ?? Biaya::where('is_active', true)->first();

            $data['pengumuman'] = Pengumuman::where('is_published', true)->latest()->take(3)->get();
        }

        return view('layouts.dahsboard.index', $data);
    }
}
