<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTahunAjaranRequest;
use App\Http\Requests\UpdateTahunAjaranRequest;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TahunAjaranController extends Controller
{
    /**
     * Tampilkan data tahun ajaran (dengan Yajra DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = TahunAjaran::query()->select([
                'id_tahun_ajaran',
                'tahun_ajaran',
                'nama_tahun_ajaran',
                'tanggal_mulai',
                'tanggal_selesai',
                'is_active',
                'keterangan',
                'created_at',
            ]);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('tahun_ajaran', function ($row) {
                    $namaDetail = $row->nama_tahun_ajaran ? '<div class="text-muted small">' . e($row->nama_tahun_ajaran) . '</div>' : '';
                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                    <i class="bi bi-calendar-range" style="font-size: 0.95rem;"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark">' . e($row->tahun_ajaran) . '</span>
                                    ' . $namaDetail . '
                                </div>
                            </div>';
                })
                ->addColumn('periode', function ($row) {
                    if ($row->tanggal_mulai && $row->tanggal_selesai) {
                        return '<span class="text-nowrap"><i class="bi bi-calendar-event text-secondary me-1"></i>' . 
                               $row->tanggal_mulai->translatedFormat('d M Y') . ' - ' . 
                               $row->tanggal_selesai->translatedFormat('d M Y') . '</span>';
                    } elseif ($row->tanggal_mulai) {
                        return '<span class="text-nowrap">Mulai: ' . $row->tanggal_mulai->translatedFormat('d M Y') . '</span>';
                    }
                    return '<span class="text-muted fst-italic">-</span>';
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
                ->editColumn('keterangan', function ($row) {
                    return $row->keterangan ? e($row->keterangan) : '<span class="text-muted fst-italic">-</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('tahun-ajaran.edit', $row->id_tahun_ajaran);
                    $deleteUrl = route('tahun-ajaran.destroy', $row->id_tahun_ajaran);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit Tahun Ajaran"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_tahun_ajaran . '" data-name="' . e($row->tahun_ajaran) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Tahun Ajaran"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['tahun_ajaran', 'periode', 'is_active', 'keterangan', 'action'])
                ->make(true);
        }

        return view('pages.tahun_ajaran.index');
    }

    /**
     * Form tambah tahun ajaran baru
     */
    public function create()
    {
        return view('pages.tahun_ajaran.create');
    }

    /**
     * Simpan data tahun ajaran baru ke database
     */
    public function store(StoreTahunAjaranRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        // Jika tahun ajaran baru diaktifkan, nonaktifkan tahun ajaran lainnya
        if ($data['is_active']) {
            TahunAjaran::where('is_active', true)->update(['is_active' => false]);
        }

        TahunAjaran::create($data);

        return redirect()->route('tahun-ajaran.index')->with('success', 'Data tahun ajaran berhasil ditambahkan!');
    }

    /**
     * Form edit tahun ajaran
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('pages.tahun_ajaran.edit', compact('tahunAjaran'));
    }

    /**
     * Perbarui data tahun ajaran
     */
    public function update(UpdateTahunAjaranRequest $request, TahunAjaran $tahunAjaran)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        // Jika tahun ajaran ini diaktifkan, nonaktifkan tahun ajaran yang lain
        if ($data['is_active']) {
            TahunAjaran::where('id_tahun_ajaran', '!=', $tahunAjaran->id_tahun_ajaran)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $tahunAjaran->update($data);

        return redirect()->route('tahun-ajaran.index')->with('success', 'Data tahun ajaran berhasil diperbarui!');
    }

    /**
     * Hapus data tahun ajaran
     */
    public function destroy(Request $request, TahunAjaran $tahunAjaran)
    {
        $nama = $tahunAjaran->tahun_ajaran;
        $tahunAjaran->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tahun ajaran "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun ajaran "' . $nama . '" berhasil dihapus!');
    }
}
