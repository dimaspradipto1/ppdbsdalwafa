<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKomponenSeleksiRequest;
use App\Http\Requests\UpdateKomponenSeleksiRequest;
use App\Models\KomponenSeleksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KomponenSeleksiController extends Controller
{
    /**
     * Tampilkan data komponen seleksi (DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = KomponenSeleksi::query()->orderBy('urutan', 'asc')->select('komponen_seleksi.*');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_komponen', function ($row) {
                    $kode = $row->kode ? ' <code>[' . e($row->kode) . ']</code>' : '';
                    $ket = $row->keterangan ? '<div class="text-muted small">' . e($row->keterangan) . '</div>' : '';
                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                    <i class="bi bi-clipboard-check" style="font-size: 0.95rem;"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark">' . e($row->nama_komponen) . '</span>' . $kode . '
                                    ' . $ket . '
                                </div>
                            </div>';
                })
                ->editColumn('nilai_minimal', function ($row) {
                    if ($row->nilai_minimal !== null) {
                        return '<span class="badge bg-light text-dark border px-2 py-1 font-monospace">' . number_format($row->nilai_minimal, 1) . '</span>';
                    }
                    return '<span class="text-muted">-</span>';
                })
                ->editColumn('bobot_persen', function ($row) {
                    if ($row->bobot_persen !== null && $row->bobot_persen > 0) {
                        return '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">' . $row->bobot_persen . '%</span>';
                    }
                    return '<span class="text-muted">-</span>';
                })
                ->editColumn('urutan', function ($row) {
                    return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">#' . $row->urutan . '</span>';
                })
                ->editColumn('is_active', function ($row) {
                    if ($row->is_active) {
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Aktif</span>';
                    }
                    return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1"><i class="bi bi-x-circle me-1"></i>Non-Aktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('komponen-seleksi.edit', $row->id_komponen_seleksi);
                    $deleteUrl = route('komponen-seleksi.destroy', $row->id_komponen_seleksi);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_komponen_seleksi . '" data-name="' . e($row->nama_komponen) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['nama_komponen', 'nilai_minimal', 'bobot_persen', 'urutan', 'is_active', 'action'])
                ->make(true);
        }

        return view('pages.komponen_seleksi.index');
    }

    public function create()
    {
        return view('pages.komponen_seleksi.create');
    }

    public function store(StoreKomponenSeleksiRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        KomponenSeleksi::create($data);

        return redirect()->route('komponen-seleksi.index')->with('success', 'Komponen seleksi berhasil ditambahkan!');
    }

    public function edit(KomponenSeleksi $komponenSeleksi)
    {
        return view('pages.komponen_seleksi.edit', compact('komponenSeleksi'));
    }

    public function update(UpdateKomponenSeleksiRequest $request, KomponenSeleksi $komponenSeleksi)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $komponenSeleksi->update($data);

        return redirect()->route('komponen-seleksi.index')->with('success', 'Komponen seleksi berhasil diperbarui!');
    }

    public function destroy(Request $request, KomponenSeleksi $komponenSeleksi)
    {
        $nama = $komponenSeleksi->nama_komponen;
        $komponenSeleksi->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Komponen seleksi "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('komponen-seleksi.index')->with('success', 'Komponen seleksi "' . $nama . '" berhasil dihapus!');
    }
}
