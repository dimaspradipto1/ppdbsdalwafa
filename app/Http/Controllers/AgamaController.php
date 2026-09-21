<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAgamaRequest;
use App\Http\Requests\UpdateAgamaRequest;
use App\Models\Agama;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AgamaController extends Controller
{
    /**
     * Tampilkan data agama (dengan Yajra DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Agama::query()->select(['id_agama', 'nama_agama', 'keterangan', 'is_active', 'created_at']);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_agama', function ($row) {
                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-moon-stars" style="font-size: 0.9rem;"></i>
                                </div>
                                <span class="fw-bold text-dark">' . e($row->nama_agama) . '</span>
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
                    $editUrl = route('agama.edit', $row->id_agama);
                    $deleteUrl = route('agama.destroy', $row->id_agama);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit Agama"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_agama . '" data-name="' . e($row->nama_agama) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Agama"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['nama_agama', 'keterangan', 'is_active', 'action'])
                ->make(true);
        }

        return view('pages.agama.index');
    }

    /**
     * Form tambah agama baru
     */
    public function create()
    {
        return view('pages.agama.create');
    }

    /**
     * Simpan agama baru ke database
     */
    public function store(StoreAgamaRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        Agama::create($data);

        return redirect()->route('agama.index')->with('success', 'Data agama berhasil ditambahkan!');
    }

    /**
     * Form edit agama
     */
    public function edit(Agama $agama)
    {
        return view('pages.agama.edit', compact('agama'));
    }

    /**
     * Perbarui data agama
     */
    public function update(UpdateAgamaRequest $request, Agama $agama)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $agama->update($data);

        return redirect()->route('agama.index')->with('success', 'Data agama berhasil diperbarui!');
    }

    /**
     * Hapus data agama
     */
    public function destroy(Request $request, Agama $agama)
    {
        $nama = $agama->nama_agama;
        $agama->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Agama "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('agama.index')->with('success', 'Agama "' . $nama . '" berhasil dihapus!');
    }
}
