<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJalurRequest;
use App\Http\Requests\UpdateJalurRequest;
use App\Models\Jalur;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JalurController extends Controller
{
    /**
     * Tampilkan data jalur pendaftaran (Yajra DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Jalur::with('tahunAjaran')->select('jalur.*');

            if ($request->filled('id_tahun_ajaran')) {
                $query->where('id_tahun_ajaran', $request->id_tahun_ajaran);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_jalur', function ($row) {
                    $kode = $row->kode_jalur ? ' <code>[' . e($row->kode_jalur) . ']</code>' : '';
                    $desc = $row->deskripsi ? '<div class="text-muted small">' . e($row->deskripsi) . '</div>' : '';
                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                    <i class="bi bi-signpost-split" style="font-size: 0.95rem;"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark">' . e($row->nama_jalur) . '</span>' . $kode . '
                                    ' . $desc . '
                                </div>
                            </div>';
                })
                ->addColumn('tahun_ajaran', function ($row) {
                    if ($row->tahunAjaran) {
                        return '<span class="badge bg-light text-dark border px-2 py-1"><i class="bi bi-calendar-range me-1 text-primary"></i>' . e($row->tahunAjaran->tahun_ajaran) . '</span>';
                    }
                    return '<span class="text-muted fst-italic">Semua Tahun</span>';
                })
                ->editColumn('kuota', function ($row) {
                    if ($row->kuota !== null && $row->kuota > 0) {
                        return '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1"><i class="bi bi-people me-1"></i>' . number_format($row->kuota, 0, ',', '.') . ' Siswa</span>';
                    }
                    return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">Tidak Dibatasi</span>';
                })
                ->editColumn('is_active', function ($row) {
                    if ($row->is_active) {
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Aktif</span>';
                    }
                    return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1"><i class="bi bi-x-circle me-1"></i>Non-Aktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('jalur.edit', $row->id_jalur);
                    $deleteUrl = route('jalur.destroy', $row->id_jalur);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_jalur . '" data-name="' . e($row->nama_jalur) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['nama_jalur', 'tahun_ajaran', 'kuota', 'is_active', 'action'])
                ->make(true);
        }

        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();

        return view('pages.jalur.index', compact('tahunAjaranList'));
    }

    public function create()
    {
        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();
        $activeTahunAjaran = TahunAjaran::active()->first();

        return view('pages.jalur.create', compact('tahunAjaranList', 'activeTahunAjaran'));
    }

    public function store(StoreJalurRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        Jalur::create($data);

        return redirect()->route('jalur.index')->with('success', 'Jalur pendaftaran berhasil ditambahkan!');
    }

    public function edit(Jalur $jalur)
    {
        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();

        return view('pages.jalur.edit', compact('jalur', 'tahunAjaranList'));
    }

    public function update(UpdateJalurRequest $request, Jalur $jalur)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $jalur->update($data);

        return redirect()->route('jalur.index')->with('success', 'Jalur pendaftaran berhasil diperbarui!');
    }

    public function destroy(Request $request, Jalur $jalur)
    {
        $nama = $jalur->nama_jalur;
        $jalur->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Jalur "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('jalur.index')->with('success', 'Jalur "' . $nama . '" berhasil dihapus!');
    }
}
