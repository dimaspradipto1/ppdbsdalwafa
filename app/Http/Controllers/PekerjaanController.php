<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePekerjaanRequest;
use App\Http\Requests\UpdatePekerjaanRequest;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PekerjaanController extends Controller
{
    /**
     * Tampilkan data pekerjaan (dengan Yajra DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Pekerjaan::query()->select(['id_pekerjaan', 'nama_pekerjaan', 'keterangan', 'is_active', 'created_at']);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_pekerjaan', function ($row) {
                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-briefcase" style="font-size: 0.9rem;"></i>
                                </div>
                                <span class="fw-bold text-dark">' . e($row->nama_pekerjaan) . '</span>
                            </div>';
                })
                ->editColumn('keterangan', function ($row) {
                    return $row->keterangan ? e($row->keterangan) : '<span class="text-muted fst-italic">-</span>';
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
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->translatedFormat('d M Y H:i') : '-';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('pekerjaan.edit', $row->id_pekerjaan);
                    $deleteUrl = route('pekerjaan.destroy', $row->id_pekerjaan);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit Pekerjaan"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_pekerjaan . '" data-name="' . e($row->nama_pekerjaan) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Pekerjaan"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['nama_pekerjaan', 'keterangan', 'is_active', 'action'])
                ->make(true);
        }

        return view('pages.pekerjaan.index');
    }

    /**
     * Form tambah pekerjaan baru
     */
    public function create()
    {
        return view('pages.pekerjaan.create');
    }

    /**
     * Simpan data pekerjaan baru ke database
     */
    public function store(StorePekerjaanRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        Pekerjaan::create($data);

        return redirect()->route('pekerjaan.index')->with('success', 'Data pekerjaan berhasil ditambahkan!');
    }

    /**
     * Form edit pekerjaan
     */
    public function edit(Pekerjaan $pekerjaan)
    {
        return view('pages.pekerjaan.edit', compact('pekerjaan'));
    }

    /**
     * Perbarui data pekerjaan
     */
    public function update(UpdatePekerjaanRequest $request, Pekerjaan $pekerjaan)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $pekerjaan->update($data);

        return redirect()->route('pekerjaan.index')->with('success', 'Data pekerjaan berhasil diperbarui!');
    }

    /**
     * Hapus data pekerjaan
     */
    public function destroy(Request $request, Pekerjaan $pekerjaan)
    {
        $nama = $pekerjaan->nama_pekerjaan;
        $pekerjaan->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pekerjaan "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan "' . $nama . '" berhasil dihapus!');
    }
}
