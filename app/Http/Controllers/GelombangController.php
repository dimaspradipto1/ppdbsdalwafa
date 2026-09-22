<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGelombangRequest;
use App\Http\Requests\UpdateGelombangRequest;
use App\Models\Gelombang;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GelombangController extends Controller
{
    /**
     * Tampilkan data gelombang pendaftaran (dengan Yajra DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Gelombang::with('tahunAjaran')->select('gelombang.*');

            if ($request->filled('id_tahun_ajaran')) {
                $query->where('id_tahun_ajaran', $request->id_tahun_ajaran);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_gelombang', function ($row) {
                    $ket = $row->keterangan ? '<div class="text-muted small">' . e($row->keterangan) . '</div>' : '';
                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                    <i class="bi bi-layers" style="font-size: 0.95rem;"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark">' . e($row->nama_gelombang) . '</span>
                                    ' . $ket . '
                                </div>
                            </div>';
                })
                ->addColumn('tahun_ajaran', function ($row) {
                    if ($row->tahunAjaran) {
                        return '<span class="badge bg-light text-dark border px-2 py-1"><i class="bi bi-calendar-range me-1 text-primary"></i>' . e($row->tahunAjaran->tahun_ajaran) . '</span>';
                    }
                    return '<span class="text-muted fst-italic">Semua Tahun</span>';
                })
                ->addColumn('periode', function ($row) {
                    return '<span class="text-nowrap"><i class="bi bi-clock me-1 text-secondary"></i>' . 
                           $row->tanggal_mulai->translatedFormat('d M Y') . ' - ' . 
                           $row->tanggal_selesai->translatedFormat('d M Y') . '</span>';
                })
                ->editColumn('kuota', function ($row) {
                    if ($row->kuota !== null && $row->kuota > 0) {
                        return '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1"><i class="bi bi-people me-1"></i>' . number_format($row->kuota, 0, ',', '.') . ' Siswa</span>';
                    }
                    return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">Tidak Dibatasi</span>';
                })
                ->editColumn('is_active', function ($row) {
                    if ($row->is_active) {
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                    <i class="bi bi-check-circle me-1"></i>Aktif
                                </span>';
                    }
                    return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                <i class="bi bi-x-circle me-1"></i>Non-Aktif
                            </span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('gelombang.edit', $row->id_gelombang);
                    $deleteUrl = route('gelombang.destroy', $row->id_gelombang);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit Gelombang"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_gelombang . '" data-name="' . e($row->nama_gelombang) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Gelombang"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['nama_gelombang', 'tahun_ajaran', 'periode', 'kuota', 'is_active', 'action'])
                ->make(true);
        }

        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();

        return view('pages.gelombang.index', compact('tahunAjaranList'));
    }

    /**
     * Form tambah gelombang baru
     */
    public function create()
    {
        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();
        $activeTahunAjaran = TahunAjaran::active()->first();

        return view('pages.gelombang.create', compact('tahunAjaranList', 'activeTahunAjaran'));
    }

    /**
     * Simpan data gelombang baru ke database
     */
    public function store(StoreGelombangRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        Gelombang::create($data);

        return redirect()->route('gelombang.index')->with('success', 'Data gelombang pendaftaran berhasil ditambahkan!');
    }

    /**
     * Form edit gelombang
     */
    public function edit(Gelombang $gelombang)
    {
        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();

        return view('pages.gelombang.edit', compact('gelombang', 'tahunAjaranList'));
    }

    /**
     * Perbarui data gelombang
     */
    public function update(UpdateGelombangRequest $request, Gelombang $gelombang)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $gelombang->update($data);

        return redirect()->route('gelombang.index')->with('success', 'Data gelombang pendaftaran berhasil diperbarui!');
    }

    /**
     * Hapus data gelombang
     */
    public function destroy(Request $request, Gelombang $gelombang)
    {
        $nama = $gelombang->nama_gelombang;
        $gelombang->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Gelombang "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('gelombang.index')->with('success', 'Gelombang "' . $nama . '" berhasil dihapus!');
    }
}
