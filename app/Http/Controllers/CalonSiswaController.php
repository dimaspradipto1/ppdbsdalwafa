<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalonSiswaRequest;
use App\Http\Requests\UpdateCalonSiswaRequest;
use App\Models\Agama;
use App\Models\Beasiswa;
use App\Models\CalonSiswa;
use App\Models\KebutuhanKhusus;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penghasilan;
use App\Models\Prestasi;
use Illuminate\Http\Request;
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
            $query = CalonSiswa::with(['prestasi', 'beasiswa', 'kebutuhanKhusus'])
                ->withCount(['prestasi', 'beasiswa'])
                ->select('calon_siswa.*');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_lengkap', function ($row) {
                    $genderIcon = $row->jenis_kelamin === 'Laki-laki' 
                        ? '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-0 ms-1" style="font-size: 0.72rem;"><i class="bi bi-gender-male"></i> L</span>' 
                        : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-0 ms-1" style="font-size: 0.72rem;"><i class="bi bi-gender-female"></i> P</span>';

                    $kebutuhanBadge = '';
                    if ($row->kebutuhanKhusus && $row->kebutuhanKhusus->kode !== '01') {
                        $kebutuhanBadge = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle ms-1" style="font-size: 0.7rem;"><i class="bi bi-heart-pulse me-1"></i>' . e($row->kebutuhanKhusus->nama) . '</span>';
                    }

                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px; font-weight: 600;">
                                    ' . strtoupper(substr($row->nama_lengkap, 0, 1)) . '
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">' . e($row->nama_lengkap) . ' ' . $genderIcon . '</div>
                                    <div class="text-muted small">' . ($row->asal_sekolah ? '<i class="bi bi-bank me-1"></i>' . e($row->asal_sekolah) : '-') . ' ' . $kebutuhanBadge . '</div>
                                </div>
                            </div>';
                })
                ->addColumn('nik_nisn', function ($row) {
                    $nik = $row->nik ? '<span class="font-monospace text-dark d-block">NIK: ' . e($row->nik) . '</span>' : '<span class="text-muted fst-italic">NIK: -</span>';
                    $nisn = $row->nisn ? '<span class="font-monospace text-secondary small d-block">NISN: ' . e($row->nisn) . '</span>' : '<span class="text-muted small fst-italic">NISN: -</span>';
                    return $nik . $nisn;
                })
                ->addColumn('ttl', function ($row) {
                    $tgl = $row->tanggal_lahir ? $row->tanggal_lahir->translatedFormat('d M Y') : '-';
                    return '<span class="text-dark fw-medium">' . e($row->tempat_lahir) . '</span><br><span class="text-muted small">' . $tgl . '</span>';
                })
                ->addColumn('prestasi_beasiswa', function ($row) {
                    $output = '<div class="d-flex flex-column gap-1">';
                    if ($row->prestasi_count > 0) {
                        $output .= '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-trophy me-1"></i>' . $row->prestasi_count . ' Prestasi</span>';
                    } else {
                        $output .= '<span class="text-muted small">-</span>';
                    }

                    if ($row->beasiswa_count > 0) {
                        $output .= '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1"><i class="bi bi-award me-1"></i>' . $row->beasiswa_count . ' Beasiswa</span>';
                    }
                    $output .= '</div>';
                    return $output;
                })
                ->editColumn('status', function ($row) {
                    $badges = [
                        'draft' => 'bg-secondary-subtle text-secondary border-secondary-subtle',
                        'menunggu_verifikasi' => 'bg-warning-subtle text-warning border-warning-subtle',
                        'diverifikasi' => 'bg-info-subtle text-info border-info-subtle',
                        'diterima' => 'bg-success-subtle text-success border-success-subtle',
                        'ditolak' => 'bg-danger-subtle text-danger border-danger-subtle',
                    ];
                    $labels = [
                        'draft' => 'Draft',
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'diverifikasi' => 'Diverifikasi',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ];
                    $cls = $badges[$row->status] ?? 'bg-light text-dark';
                    $lbl = $labels[$row->status] ?? ucfirst($row->status);

                    return '<span class="badge ' . $cls . ' border px-2 py-1">' . $lbl . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $showUrl = route('calon-siswa.show', $row->id_calon_siswa);
                    $editUrl = route('calon-siswa.edit', $row->id_calon_siswa);
                    $deleteUrl = route('calon-siswa.destroy', $row->id_calon_siswa);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $showUrl . '" class="btn btn-sm btn-info text-white d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Detail Biodata"><i class="bi bi-eye"></i><span>Detail</span></a>';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit Biodata"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_calon_siswa . '" data-name="' . e($row->nama_lengkap) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Data"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['nama_lengkap', 'nik_nisn', 'ttl', 'prestasi_beasiswa', 'status', 'action'])
                ->make(true);
        }

        return view('pages.calon_siswa.index');
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
            
            // Simpan Calon Siswa
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

        return redirect()->route('calon-siswa.index')->with('success', 'Data calon siswa berhasil didaftarkan!');
    }

    /**
     * Tampilkan detail biodata calon siswa
     */
    public function show(CalonSiswa $calonSiswa)
    {
        $calonSiswa->load([
            'prestasi',
            'beasiswa',
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

        return view('pages.calon_siswa.edit', array_merge($dataMaster, compact('calonSiswa')));
    }

    /**
     * Perbarui data calon siswa
     */
    public function update(UpdateCalonSiswaRequest $request, CalonSiswa $calonSiswa)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request, $calonSiswa) {
            $siswaData = collect($validated)->except(['prestasi', 'beasiswa'])->toArray();
            $calonSiswa->update($siswaData);

            // Sinkronisasi Prestasi (Hapus lama & simpan yang baru terisi)
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

            // Sinkronisasi Beasiswa (Hapus lama & simpan yang baru terisi)
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
