<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalonSiswaRequest;
use App\Http\Requests\UpdateCalonSiswaRequest;
use App\Models\Agama;
use App\Models\Beasiswa;
use App\Models\CalonSiswa;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KebutuhanKhusus;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penghasilan;
use App\Models\Prestasi;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CalonSiswaController extends Controller
{
    /**
     * Tampilkan data calon siswa (DataTables AJAX & View)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CalonSiswa::with([
                'tahunAjaran',
                'gelombang',
                'jalur',
                'kebutuhanKhusus',
                'dokumen',
            ])
            ->withCount([
                'prestasi',
                'beasiswa',
                'dokumen',
                'dokumen as dokumen_valid_count' => function ($q) {
                    $q->where('status_verifikasi', 'valid');
                }
            ])
            ->select('calon_siswa.*');

            // Filter Tahun Ajaran
            if ($request->filled('id_tahun_ajaran')) {
                $query->where('id_tahun_ajaran', $request->id_tahun_ajaran);
            }

            // Filter Gelombang
            if ($request->filled('id_gelombang')) {
                $query->where('id_gelombang', $request->id_gelombang);
            }

            // Filter Jalur
            if ($request->filled('id_jalur')) {
                $query->where('id_jalur', $request->id_jalur);
            }

            // Filter Status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('no_pendaftaran', function ($row) {
                    $no = e($row->no_pendaftaran ?? 'REG-' . $row->id_calon_siswa);
                    $tgl = $row->tanggal_daftar 
                        ? $row->tanggal_daftar->translatedFormat('d M Y H:i') 
                        : ($row->created_at ? $row->created_at->translatedFormat('d M Y') : '-');

                    return '<span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace px-2 py-1 mb-1">' . $no . '</span>
                            <div class="text-muted small" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i>' . $tgl . '</div>';
                })
                ->editColumn('nama_lengkap', function ($row) {
                    $genderIcon = $row->jenis_kelamin === 'Laki-laki' 
                        ? '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-1 py-0 ms-1" style="font-size: 0.7rem;"><i class="bi bi-gender-male"></i> L</span>' 
                        : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-1 py-0 ms-1" style="font-size: 0.7rem;"><i class="bi bi-gender-female"></i> P</span>';

                    $kebutuhanBadge = '';
                    if ($row->kebutuhanKhusus && $row->kebutuhanKhusus->kode !== '01') {
                        $kebutuhanBadge = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle ms-1" style="font-size: 0.68rem;"><i class="bi bi-heart-pulse me-1"></i>' . e($row->kebutuhanKhusus->nama) . '</span>';
                    }

                    $asal = $row->asal_sekolah ? '<i class="bi bi-buildings me-1"></i>' . e($row->asal_sekolah) : '<span class="fst-italic text-muted">Asal TK -</span>';
                    $nik = $row->nik ? '<span class="font-monospace text-secondary small me-2"><i class="bi bi-card-text me-1"></i>' . e($row->nik) . '</span>' : '';

                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px; font-weight: 600; font-size: 0.95rem;">
                                    ' . strtoupper(substr($row->nama_lengkap, 0, 1)) . '
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">' . e($row->nama_lengkap) . ' ' . $genderIcon . ' ' . $kebutuhanBadge . '</div>
                                    <div class="text-muted small">' . $asal . '</div>
                                    <div class="mt-1">' . $nik . '</div>
                                </div>
                            </div>';
                })
                ->addColumn('jalur_gelombang', function ($row) {
                    $jalur = $row->jalur ? '<span class="fw-medium text-dark">' . e($row->jalur->nama_jalur) . '</span>' : '<span class="text-muted">-</span>';
                    $gelombang = $row->gelombang ? e($row->gelombang->nama_gelombang) : '-';
                    $ta = $row->tahunAjaran ? e($row->tahunAjaran->tahun_ajaran) : '-';

                    return $jalur . '<br><small class="text-muted">' . $gelombang . ' &bull; ' . $ta . '</small>';
                })
                ->addColumn('berkas', function ($row) {
                    $total = $row->dokumen_count;
                    $valid = $row->dokumen_valid_count;

                    if ($total === 0) {
                        return '<span class="badge bg-light text-secondary border">0 Berkas</span>';
                    }

                    if ($valid === $total) {
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check2-all me-1"></i>' . $valid . '/' . $total . ' Valid</span>';
                    }

                    return '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1"><i class="bi bi-hourglass-split me-1"></i>' . $valid . '/' . $total . ' Valid</span>';
                })
                ->editColumn('status', function ($row) {
                    $badges = [
                        'draft'               => 'bg-secondary-subtle text-secondary border-secondary-subtle',
                        'menunggu_verifikasi' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                        'diverifikasi'        => 'bg-info-subtle text-info-emphasis border-info-subtle',
                        'diterima'            => 'bg-success-subtle text-success border-success-subtle',
                        'ditolak'             => 'bg-danger-subtle text-danger border-danger-subtle',
                    ];
                    $labels = [
                        'draft'               => 'Draft',
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'diverifikasi'        => 'Diverifikasi',
                        'diterima'            => 'Diterima',
                        'ditolak'             => 'Ditolak',
                    ];
                    $cls = $badges[$row->status] ?? 'bg-light text-dark';
                    $lbl = $labels[$row->status] ?? ucfirst($row->status);

                    $btn = '<button type="button" class="btn btn-sm ' . $cls . ' border px-2 py-1 btn-quick-status" '
                        . 'data-id="' . $row->id_calon_siswa . '" '
                        . 'data-name="' . e($row->nama_lengkap) . '" '
                        . 'data-status="' . $row->status . '" '
                        . 'data-catatan="' . e($row->catatan_verifikasi ?? '') . '" '
                        . 'title="Klik untuk ubah status pendaftaran">'
                        . '<i class="bi bi-patch-check me-1"></i>' . $lbl . '</button>';

                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $showUrl = route('calon-siswa.show', $row->id_calon_siswa);
                    $editUrl = route('calon-siswa.edit', $row->id_calon_siswa);
                    $deleteUrl = route('calon-siswa.destroy', $row->id_calon_siswa);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $showUrl . '" class="btn btn-sm btn-info text-white d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Detail Pendaftar"><i class="bi bi-eye"></i><span>Detail</span></a>';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit Biodata"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_calon_siswa . '" data-name="' . e($row->nama_lengkap) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Data"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['no_pendaftaran', 'nama_lengkap', 'jalur_gelombang', 'berkas', 'status', 'action'])
                ->make(true);
        }

        $tahunAjaranList = TahunAjaran::orderByDesc('is_active')->orderByDesc('id_tahun_ajaran')->get();
        $gelombangList = Gelombang::orderBy('nama_gelombang')->get();
        $jalurList = Jalur::orderBy('nama_jalur')->get();

        return view('pages.calon_siswa.index', compact('tahunAjaranList', 'gelombangList', 'jalurList'));
    }

    /**
     * Form tambah calon siswa baru
     */
    public function create()
    {
        $dataMaster = $this->getMasterData();

        return view('pages.calon_siswa.create', $dataMaster);
    }

    /**
     * Simpan data calon siswa baru ke database
     */
    public function store(StoreCalonSiswaRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request) {
            $siswaData = collect($validated)->except(['prestasi', 'beasiswa'])->toArray();

            // Set user_id jika login sebagai pendaftar
            if (Auth::check() && Auth::user()->role === 'pendaftar' && empty($siswaData['user_id'])) {
                $siswaData['user_id'] = Auth::id();
            }

            // Simpan Calon Siswa (no_pendaftaran auto-generated in Model booted)
            $calonSiswa = CalonSiswa::create($siswaData);

            // Simpan Catatan Prestasi
            if ($request->has('prestasi') && is_array($request->prestasi)) {
                foreach ($request->prestasi as $item) {
                    if (!empty($item['nama_prestasi'])) {
                        $calonSiswa->prestasi()->create([
                            'jenis_prestasi' => $item['jenis_prestasi'] ?? '04. Lain-lain',
                            'tingkat'        => $item['tingkat'] ?? 'Sekolah',
                            'nama_prestasi'  => $item['nama_prestasi'],
                            'tahun'          => $item['tahun'] ?? date('Y'),
                            'penyelenggara'  => $item['penyelenggara'] ?? '-',
                        ]);
                    }
                }
            }

            // Simpan Beasiswa
            if ($request->has('beasiswa') && is_array($request->beasiswa)) {
                foreach ($request->beasiswa as $item) {
                    if (!empty($item['jenis_beasiswa'])) {
                        $calonSiswa->beasiswa()->create([
                            'jenis_beasiswa' => $item['jenis_beasiswa'],
                            'penyelenggara'  => $item['penyelenggara'] ?? '-',
                            'tahun_mulai'    => $item['tahun_mulai'] ?? date('Y'),
                            'tahun_selesai'  => $item['tahun_selesai'] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('calon-siswa.index')->with('success', 'Data pendaftaran calon siswa berhasil disimpan!');
    }

    /**
     * Tampilkan detail biodata calon siswa (Tabbed View)
     */
    public function show(CalonSiswa $calonSiswa)
    {
        $calonSiswa->load([
            'tahunAjaran',
            'gelombang',
            'jalur',
            'verifiedByUser',
            'prestasi',
            'beasiswa',
            'dokumen.jenisDokumen',
            'dokumen.verifikator',
            'agama',
            'kebutuhanKhusus',
            'pekerjaanAyah',
            'pendidikanAyah',
            'agamaAyah',
            'penghasilanAyah',
            'pekerjaanIbu',
            'pendidikanIbu',
            'agamaIbu',
            'penghasilanIbu',
            'pekerjaanWali',
            'pendidikanWali',
            'agamaWali',
            'penghasilanWali',
        ]);

        return view('pages.calon_siswa.show', compact('calonSiswa'));
    }

    /**
     * Form edit calon siswa
     */
    public function edit(CalonSiswa $calonSiswa)
    {
        $calonSiswa->load(['prestasi', 'beasiswa']);
        $dataMaster = $this->getMasterData();

        return view('pages.calon_siswa.edit', array_merge(compact('calonSiswa'), $dataMaster));
    }

    /**
     * Perbarui data calon siswa di database
     */
    public function update(UpdateCalonSiswaRequest $request, CalonSiswa $calonSiswa)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request, $calonSiswa) {
            $siswaData = collect($validated)->except(['prestasi', 'beasiswa'])->toArray();

            $calonSiswa->update($siswaData);

            // Perbarui Prestasi
            $calonSiswa->prestasi()->delete();
            if ($request->has('prestasi') && is_array($request->prestasi)) {
                foreach ($request->prestasi as $item) {
                    if (!empty($item['nama_prestasi'])) {
                        $calonSiswa->prestasi()->create([
                            'jenis_prestasi' => $item['jenis_prestasi'] ?? '04. Lain-lain',
                            'tingkat'        => $item['tingkat'] ?? 'Sekolah',
                            'nama_prestasi'  => $item['nama_prestasi'],
                            'tahun'          => $item['tahun'] ?? date('Y'),
                            'penyelenggara'  => $item['penyelenggara'] ?? '-',
                        ]);
                    }
                }
            }

            // Perbarui Beasiswa
            $calonSiswa->beasiswa()->delete();
            if ($request->has('beasiswa') && is_array($request->beasiswa)) {
                foreach ($request->beasiswa as $item) {
                    if (!empty($item['jenis_beasiswa'])) {
                        $calonSiswa->beasiswa()->create([
                            'jenis_beasiswa' => $item['jenis_beasiswa'],
                            'penyelenggara'  => $item['penyelenggara'] ?? '-',
                            'tahun_mulai'    => $item['tahun_mulai'] ?? date('Y'),
                            'tahun_selesai'  => $item['tahun_selesai'] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('calon-siswa.index')->with('success', 'Data calon siswa berhasil diperbarui!');
    }

    /**
     * Update Status Verifikasi Calon Siswa (AJAX or Form Post)
     */
    public function updateStatus(Request $request, CalonSiswa $calonSiswa)
    {
        $request->validate([
            'status'             => 'required|in:draft,menunggu_verifikasi,diverifikasi,diterima,ditolak',
            'catatan_verifikasi' => 'nullable|string|max:500',
        ]);

        $calonSiswa->update([
            'status'             => $request->status,
            'catatan_verifikasi' => $request->catatan_verifikasi,
            'verified_by'        => Auth::id(),
            'verified_at'        => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pendaftaran "' . $calonSiswa->nama_lengkap . '" berhasil diperbarui!',
                'status'  => $calonSiswa->status,
            ]);
        }

        return back()->with('success', 'Status pendaftaran berhasil diperbarui!');
    }

    /**
     * Hapus data calon siswa
     */
    public function destroy(Request $request, CalonSiswa $calonSiswa)
    {
        $nama = $calonSiswa->nama_lengkap;
        $calonSiswa->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data calon siswa "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('calon-siswa.index')->with('success', 'Data calon siswa "' . $nama . '" berhasil dihapus!');
    }

    /**
     * Helper load data master
     */
    private function getMasterData(): array
    {
        return [
            'daftarTahunAjaran'    => TahunAjaran::orderByDesc('is_active')->orderByDesc('id_tahun_ajaran')->get(),
            'daftarGelombang'      => Gelombang::orderBy('nama_gelombang')->get(),
            'daftarJalur'          => Jalur::orderBy('nama_jalur')->get(),
            'daftarAgama'          => Agama::where('is_active', true)->orderBy('nama_agama')->get(),
            'daftarPekerjaan'      => Pekerjaan::where('is_active', true)->orderBy('nama_pekerjaan')->get(),
            'daftarPendidikan'     => Pendidikan::where('is_active', true)->orderBy('id_pendidikan')->get(),
            'daftarPenghasilan'    => Penghasilan::where('is_active', true)->orderBy('urutan')->get(),
            'daftarKebutuhanKhusus'=> KebutuhanKhusus::where('is_active', true)->orderBy('kode')->get(),
            'pilihanJenisPrestasi' => Prestasi::JENIS_PRESTASI,
            'pilihanTingkat'       => Prestasi::TINGKAT,
        ];
    }
}
