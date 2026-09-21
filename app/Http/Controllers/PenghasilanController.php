<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenghasilanRequest;
use App\Http\Requests\UpdatePenghasilanRequest;
use App\Models\Penghasilan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenghasilanController extends Controller
{
    /**
     * Tampilkan data penghasilan (dengan Yajra DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Penghasilan::query()
                ->select(['id_penghasilan', 'label', 'batas_bawah', 'batas_atas', 'urutan', 'is_active', 'created_at'])
                ->orderBy('urutan', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('label', function ($row) {
                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-wallet2" style="font-size: 0.9rem;"></i>
                                </div>
                                <span class="fw-bold text-dark">' . e($row->label) . '</span>
                            </div>';
                })
                ->addColumn('rentang_nominal', function ($row) {
                    return '<span class="font-monospace fw-semibold text-secondary">' . e($row->rentang_format) . '</span>';
                })
                ->editColumn('urutan', function ($row) {
                    return '<span class="badge bg-light text-dark border px-2 py-1 font-monospace">' . $row->urutan . '</span>';
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
                    $editUrl = route('penghasilan.edit', $row->id_penghasilan);
                    $deleteUrl = route('penghasilan.destroy', $row->id_penghasilan);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit Penghasilan"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_penghasilan . '" data-name="' . e($row->label) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Penghasilan"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['label', 'rentang_nominal', 'urutan', 'is_active', 'action'])
                ->make(true);
        }

        return view('pages.penghasilan.index');
    }

    /**
     * Form tambah penghasilan baru
     */
    public function create()
    {
        // Hitung urutan default (tertinggi + 1)
        $nextUrutan = (Penghasilan::max('urutan') ?? 0) + 1;
        return view('pages.penghasilan.create', compact('nextUrutan'));
    }

    /**
     * Simpan data penghasilan baru ke database
     */
    public function store(StorePenghasilanRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        Penghasilan::create($data);

        return redirect()->route('penghasilan.index')->with('success', 'Data rentang penghasilan berhasil ditambahkan!');
    }

    /**
     * Form edit penghasilan
     */
    public function edit(Penghasilan $penghasilan)
    {
        return view('pages.penghasilan.edit', compact('penghasilan'));
    }

    /**
     * Perbarui data penghasilan
     */
    public function update(UpdatePenghasilanRequest $request, Penghasilan $penghasilan)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $penghasilan->update($data);

        return redirect()->route('penghasilan.index')->with('success', 'Data rentang penghasilan berhasil diperbarui!');
    }

    /**
     * Hapus data penghasilan
     */
    public function destroy(Request $request, Penghasilan $penghasilan)
    {
        $nama = $penghasilan->label;
        $penghasilan->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Rentang penghasilan "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('penghasilan.index')->with('success', 'Rentang penghasilan "' . $nama . '" berhasil dihapus!');
    }
}
