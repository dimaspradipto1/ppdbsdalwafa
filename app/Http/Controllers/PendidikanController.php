<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePendidikanRequest;
use App\Http\Requests\UpdatePendidikanRequest;
use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PendidikanController extends Controller
{
    /**
     * Tampilkan data pendidikan (dengan Yajra DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Pendidikan::query()->select(['id_pendidikan', 'nama_pendidikan', 'keterangan', 'is_active', 'created_at']);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_pendidikan', function ($row) {
                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-mortarboard" style="font-size: 0.9rem;"></i>
                                </div>
                                <span class="fw-bold text-dark">' . e($row->nama_pendidikan) . '</span>
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
                    $editUrl = route('pendidikan.edit', $row->id_pendidikan);
                    $deleteUrl = route('pendidikan.destroy', $row->id_pendidikan);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit Pendidikan"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_pendidikan . '" data-name="' . e($row->nama_pendidikan) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Pendidikan"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['nama_pendidikan', 'keterangan', 'is_active', 'action'])
                ->make(true);
        }

        return view('pages.pendidikan.index');
    }

    /**
     * Form tambah pendidikan baru
     */
    public function create()
    {
        return view('pages.pendidikan.create');
    }

    /**
     * Simpan data pendidikan baru ke database
     */
    public function store(StorePendidikanRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        Pendidikan::create($data);

        return redirect()->route('pendidikan.index')->with('success', 'Data jenjang pendidikan berhasil ditambahkan!');
    }

    /**
     * Form edit pendidikan
     */
    public function edit(Pendidikan $pendidikan)
    {
        return view('pages.pendidikan.edit', compact('pendidikan'));
    }

    /**
     * Perbarui data pendidikan
     */
    public function update(UpdatePendidikanRequest $request, Pendidikan $pendidikan)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $pendidikan->update($data);

        return redirect()->route('pendidikan.index')->with('success', 'Data jenjang pendidikan berhasil diperbarui!');
    }

    /**
     * Hapus data pendidikan
     */
    public function destroy(Request $request, Pendidikan $pendidikan)
    {
        $nama = $pendidikan->nama_pendidikan;
        $pendidikan->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Jenjang pendidikan "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('pendidikan.index')->with('success', 'Jenjang pendidikan "' . $nama . '" berhasil dihapus!');
    }
}
