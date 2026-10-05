<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\DokumenSiswa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Dapatkan daftar notifikasi dan jumlah data baru yang butuh tindakan
     */
    public static function getNotifikasiData()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            return [
                'count' => 0,
                'items' => [],
            ];
        }

        $items = collect();
        $unreadCount = 0;

        // Jika Staf / Admin / Panitia / Kepala Sekolah / Bendahara
        if ($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah', 'bendahara', 'guru')) {

            // 1. Data Pendaftaran Baru / Menunggu Verifikasi
            $pendingSiswaCount = CalonSiswa::whereIn('status', ['draft', 'menunggu_verifikasi'])->count();
            $unreadCount += $pendingSiswaCount;

            $recentSiswa = CalonSiswa::latest()
                ->take(5)
                ->get()
                ->map(function ($s) {
                    $statusLabel = $s->status === 'menunggu_verifikasi' ? 'Menunggu Verifikasi' : ($s->status === 'draft' ? 'Baru Terdaftar' : ucfirst($s->status));
                    return [
                        'type'       => 'pendaftar',
                        'icon'       => 'bi bi-person-plus-fill text-primary',
                        'bg'         => 'bg-primary-subtle',
                        'title'      => 'Pendaftar Baru: ' . $s->nama_lengkap,
                        'desc'       => 'No. Reg: ' . ($s->no_pendaftaran ?? '-') . ' (' . $statusLabel . ')',
                        'time'       => $s->created_at ? $s->created_at->diffForHumans() : 'Baru saja',
                        'timestamp'  => $s->created_at ? $s->created_at->timestamp : 0,
                        'url'        => route('calon-siswa.show', $s->id_calon_siswa),
                    ];
                });

            // 2. Data Pembayaran Masuk / Menunggu Konfirmasi
            $pendingBayarCount = Pembayaran::where('status_pembayaran', 'menunggu_konfirmasi')->count();
            $unreadCount += $pendingBayarCount;

            $recentBayar = Pembayaran::with('calonSiswa')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($p) {
                    $namaSiswa = $p->calonSiswa ? $p->calonSiswa->nama_lengkap : 'Calon Siswa';
                    $statusText = $p->status_pembayaran === 'menunggu_konfirmasi' ? 'Menunggu Konfirmasi' : ucfirst($p->status_pembayaran);
                    return [
                        'type'       => 'pembayaran',
                        'icon'       => 'bi bi-credit-card-fill text-success',
                        'bg'         => 'bg-success-subtle',
                        'title'      => 'Pembayaran: Rp ' . number_format($p->nominal, 0, ',', '.'),
                        'desc'       => $namaSiswa . ' (' . $statusText . ')',
                        'time'       => $p->created_at ? $p->created_at->diffForHumans() : 'Baru saja',
                        'timestamp'  => $p->created_at ? $p->created_at->timestamp : 0,
                        'url'        => route('pembayaran.index'),
                    ];
                });

            // 3. Dokumen Baru Diunggah / Belum Diverifikasi
            $pendingDokCount = DokumenSiswa::where('status_verifikasi', 'menunggu')->count();
            $unreadCount += $pendingDokCount;

            $recentDok = DokumenSiswa::with(['calonSiswa', 'jenisDokumen'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($d) {
                    $jenis = $d->jenisDokumen ? $d->jenisDokumen->nama_dokumen : 'Berkas Dokumen';
                    $namaSiswa = $d->calonSiswa ? $d->calonSiswa->nama_lengkap : 'Calon Siswa';
                    return [
                        'type'       => 'dokumen',
                        'icon'       => 'bi bi-file-earmark-check-fill text-warning',
                        'bg'         => 'bg-warning-subtle',
                        'title'      => 'Berkas: ' . $jenis,
                        'desc'       => 'Diunggah oleh ' . $namaSiswa,
                        'time'       => $d->created_at ? $d->created_at->diffForHumans() : 'Baru saja',
                        'timestamp'  => $d->created_at ? $d->created_at->timestamp : 0,
                        'url'        => route('dokumen.index'),
                    ];
                });

            $items = $items->concat($recentSiswa)
                ->concat($recentBayar)
                ->concat($recentDok)
                ->sortByDesc('timestamp')
                ->values()
                ->take(6);

        } else {
            // Role Pendaftar (Wali Murid)
            $calonSiswa = CalonSiswa::where('user_id', $user->id)->first();
            if ($calonSiswa) {
                // Notifikasi status siswa
                $items->push([
                    'type'      => 'status',
                    'icon'      => 'bi bi-info-circle-fill text-info',
                    'bg'        => 'bg-info-subtle',
                    'title'     => 'Status Pendaftaran',
                    'desc'      => 'Status pendaftaran ananda: ' . ucfirst($calonSiswa->status),
                    'time'      => $calonSiswa->updated_at ? $calonSiswa->updated_at->diffForHumans() : 'Terkini',
                    'timestamp' => $calonSiswa->updated_at ? $calonSiswa->updated_at->timestamp : 0,
                    'url'       => route('calon-siswa.show', $calonSiswa->id_calon_siswa),
                ]);

                // Notifikasi pembayaran siswa
                $pembayarans = Pembayaran::where('id_calon_siswa', $calonSiswa->id_calon_siswa)->latest()->take(3)->get();
                foreach ($pembayarans as $p) {
                    $items->push([
                        'type'      => 'pembayaran',
                        'icon'      => 'bi bi-credit-card text-success',
                        'bg'        => 'bg-success-subtle',
                        'title'     => 'Transaksi: Rp ' . number_format($p->nominal, 0, ',', '.'),
                        'desc'      => 'Status: ' . ucfirst($p->status_pembayaran),
                        'time'      => $p->created_at ? $p->created_at->diffForHumans() : 'Terkini',
                        'timestamp' => $p->created_at ? $p->created_at->timestamp : 0,
                        'url'       => route('pembayaran.index'),
                    ]);
                }
            }
            $unreadCount = $items->count();
        }

        return [
            'count' => $unreadCount,
            'items' => $items->all(),
        ];
    }

    /**
     * Endpoint API JSON untuk realtime polling notifikasi
     */
    public function index()
    {
        return response()->json(static::getNotifikasiData());
    }
}
