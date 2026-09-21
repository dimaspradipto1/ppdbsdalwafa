<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKebutuhanKhususRequest;
use App\Http\Requests\UpdateKebutuhanKhususRequest;
use App\Models\KebutuhanKhusus;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KebutuhanKhususController extends Controller
{
    /**
     * Tampilkan data kebutuhan khusus (dengan Yajra DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = KebutuhanKhusus::query()->select([
                'id_kebutuhan',
                'kode',
                'nama',
                'keterangan',
                'is_active',
                'created_at',
            ]);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('kode', function ($row) {
                    return '<span class="badge bg-light text-primary border border-primary-subtle font-monospace px-2 py-1" style="font-size: 0.85rem;">' . e($row->kode) . '</span>';
                })
                ->editColumn('nama', function ($row) {
                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-heart-pulse" style="font-size: 0.9rem;"></i>
                                </div>
                                <span class="fw-bold text-dark">' . e($row->nama) . '</span>
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
                    $editUrl = route('kebutuhan-khusus.edit', $row->id_kebutuhan);
                    $deleteUrl = route('kebutuhan-khusus.destroy', $row->id_kebutuhan);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit Data"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_kebutuhan . '" data-name="' . e($row->nama) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Data"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['kode', 'nama', 'keterangan', 'is_active', 'action'])
                ->make(true);
        }

        return view('pages.kebutuhan_khusus.index');
    }

    /**
     * Form tambah kebutuhan khusus baru
     */
    public function create()
    {
        return view('pages.kebutuhan_khusus.create');
    }

    /**
     * Simpan data kebutuhan khusus baru ke database
     */
    public function store(StoreKebutuhanKhususRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        KebutuhanKhusus::create($data);

        return redirect()->route('kebutuhan-khusus.index')->with('success', 'Data kebutuhan khusus berhasil ditambahkan!');
    }

    /**
     * Form edit kebutuhan khusus
     */
    public function edit(KebutuhanKhusus $kebutuhanKhusus)
    {
        return view('pages.kebutuhan_khusus.edit', compact('kebutuhanKhusus'));
    }

    /**
     * Perbarui data kebutuhan khusus
     */
    public function update(UpdateKebutuhanKhususRequest $request, KebutuhanKhusus $kebutuhanKhusus)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $kebutuhanKhusus->update($data);

        return redirect()->route('kebutuhan-khusus.index')->with('success', 'Data kebutuhan khusus berhasil diperbarui!');
    }

    /**
     * Hapus data kebutuhan khusus
     */
    public function destroy(Request $request, KebutuhanKhusus $kebutuhanKhusus)
    {
        $nama = $kebutuhanKhusus->nama;
        $kebutuhanKhusus->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data kebutuhan khusus "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('kebutuhan-khusus.index')->with('success', 'Data kebutuhan khusus "' . $nama . '" berhasil dihapus!');
    }
}
