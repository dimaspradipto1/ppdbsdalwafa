<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Gelombang;
use App\Models\KomponenSeleksi;
use App\Models\NilaiSeleksi;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class NilaiSeleksiController extends Controller
{
    /**
     * Tampilkan rekapitulasi penilaian seleksi masuk (DataTables AJAX & View)
     */
    public function index(Request $request)
    {
        $komponenList = KomponenSeleksi::where('is_active', true)->orderBy('urutan')->get();

        if ($request->ajax()) {
            $query = CalonSiswa::with(['tahunAjaran', 'gelombang', 'jalur', 'nilaiSeleksi'])
                ->select('calon_siswa.*');

            if ($request->filled('id_tahun_ajaran')) {
                $query->where('id_tahun_ajaran', $request->id_tahun_ajaran);
            }

            if ($request->filled('id_gelombang')) {
                $query->where('id_gelombang', $request->id_gelombang);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('siswa', function ($row) {
                    $no = e($row->no_pendaftaran ?? 'REG-' . $row->id_calon_siswa);
                    return '<div class="fw-bold text-dark">' . e($row->nama_lengkap) . '</div>'
                         . '<div class="text-muted small font-monospace">' . $no . ' &bull; ' . e($row->asal_sekolah ?: '-') . '</div>';
                })
                ->addColumn('program', function ($row) {
                    $gel = $row->gelombang ? e($row->gelombang->nama_gelombang) : '-';
                    $ta = $row->tahunAjaran ? e($row->tahunAjaran->tahun_ajaran) : '-';
                    return '<span class="fw-medium text-dark">' . $gel . '</span><div class="text-muted small">' . $ta . '</div>';
                })
                ->addColumn('rincian_nilai', function ($row) use ($komponenList) {
                    $html = '<div class="d-flex flex-wrap gap-1">';
                    $nilaiMap = $row->nilaiSeleksi->keyBy('id_komponen_seleksi');

                    foreach ($komponenList as $k) {
                        $item = $nilaiMap->get($k->id_komponen_seleksi);
                        $val = $item ? number_format($item->nilai, 0) : '-';
                        $badgeClass = ($item && $item->nilai >= $k->nilai_minimal) ? 'bg-success-subtle text-success border-success-subtle' : ($item ? 'bg-danger-subtle text-danger border-danger-subtle' : 'bg-light text-muted border');
                        
                        $html .= '<span class="badge ' . $badgeClass . ' border" title="' . e($k->nama_komponen) . ' (Min: ' . $k->nilai_minimal . ')">'
                              . e($k->kode ?: substr($k->nama_komponen, 0, 4)) . ': <strong>' . $val . '</strong></span>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->addColumn('total_skor', function ($row) use ($komponenList) {
                    $totalBobot = 0;
                    $skorAkhir = 0;
                    $terisi = 0;
                    $nilaiMap = $row->nilaiSeleksi->keyBy('id_komponen_seleksi');

                    foreach ($komponenList as $k) {
                        $bobot = $k->bobot_persen ?: (100 / max(1, count($komponenList)));
                        $totalBobot += $bobot;

                        if ($item = $nilaiMap->get($k->id_komponen_seleksi)) {
                            $skorAkhir += ($item->nilai * ($bobot / 100));
                            $terisi++;
                        }
                    }

                    if ($terisi === 0) {
                        return '<span class="badge bg-light text-muted border">Belum Ada Nilai</span>';
                    }

                    return '<span class="fs-6 fw-bold text-primary font-monospace">' . number_format($skorAkhir, 1) . '</span>'
                         . '<div class="small text-muted" style="font-size: 0.72rem;">(' . $terisi . '/' . count($komponenList) . ' diuji)</div>';
                })
                ->addColumn('action', function ($row) {
                    $inputUrl = route('nilai-seleksi.edit', $row->id_calon_siswa);
                    return '<div class="text-center">'
                         . '<a href="' . $inputUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem;" title="Input / Edit Nilai Seleksi">'
                         . '<i class="bi bi-pencil-square"></i><span>Input Nilai</span></a>'
                         . '</div>';
                })
                ->rawColumns(['siswa', 'program', 'rincian_nilai', 'total_skor', 'action'])
                ->make(true);
        }

        $tahunAjaranList = TahunAjaran::orderByDesc('is_active')->orderByDesc('id_tahun_ajaran')->get();
        $gelombangList = Gelombang::orderBy('nama_gelombang')->get();

        return view('pages.nilai_seleksi.index', compact('komponenList', 'tahunAjaranList', 'gelombangList'));
    }

    /**
     * Form penginputan nilai seleksi per calon siswa
     */
    public function edit(CalonSiswa $calonSiswa)
    {
        $calonSiswa->load(['tahunAjaran', 'gelombang', 'jalur', 'nilaiSeleksi']);
        $komponenList = KomponenSeleksi::where('is_active', true)->orderBy('urutan')->get();
        $nilaiMap = $calonSiswa->nilaiSeleksi->keyBy('id_komponen_seleksi');

        return view('pages.nilai_seleksi.edit', compact('calonSiswa', 'komponenList', 'nilaiMap'));
    }

    /**
     * Simpan / Perbarui nilai seleksi siswa
     */
    public function update(Request $request, CalonSiswa $calonSiswa)
    {
        $request->validate([
            'nilai'                  => 'required|array',
            'nilai.*'                => 'nullable|numeric|between:0,100',
            'catatan'                => 'nullable|array',
            'catatan.*'              => 'nullable|string|max:255',
            'status_rekomendasi'     => 'nullable|in:menunggu_verifikasi,diverifikasi,diterima,ditolak',
        ]);

        foreach ($request->nilai as $idKomponen => $val) {
            if ($val !== null && $val !== '') {
                NilaiSeleksi::updateOrCreate(
                    [
                        'id_calon_siswa'        => $calonSiswa->id_calon_siswa,
                        'id_komponen_seleksi'   => $idKomponen,
                    ],
                    [
                        'nilai'      => $val,
                        'catatan'    => $request->catatan[$idKomponen] ?? null,
                        'penguji_id' => Auth::id(),
                    ]
                );
            }
        }

        // Jika penguji langsung memberikan rekomendasi status
        if ($request->filled('status_rekomendasi')) {
            $calonSiswa->update([
                'status'             => $request->status_rekomendasi,
                'verified_by'        => Auth::id(),
                'verified_at'        => now(),
            ]);
        }

        return redirect()->route('nilai-seleksi.index')->with('success', 'Nilai seleksi "' . $calonSiswa->nama_lengkap . '" berhasil disimpan!');
    }
}
