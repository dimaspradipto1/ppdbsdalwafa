<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJenisDokumenRequest;
use App\Http\Requests\UpdateJenisDokumenRequest;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JenisDokumenController extends Controller
{
    /**
     * Tampilkan persyaratan dokumen (DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = JenisDokumen::query()->select([
                'id_jenis_dokumen',
                'kode',
                'nama_dokumen',
                'kategori',
                'jumlah_lembar',
                'keterangan',
                'is_wajib',
                'is_active',
            ]);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_dokumen', function ($row) {
                    $ket = $row->keterangan ? '<div class="text-muted small">' . e($row->keterangan) . '</div>' : '';
                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                    <i class="bi bi-file-earmark-check" style="font-size: 0.95rem;"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark">' . e($row->nama_dokumen) . '</span>
                                    <div class="text-secondary small">Kode: <code>' . e($row->kode) . '</code></div>
                                    ' . $ket . '
                                </div>
                            </div>';
                })
                ->editColumn('kategori', function ($row) {
                    if ($row->kategori === 'siswa_baru') {
                        return '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1"><i class="bi bi-person-plus me-1"></i>Siswa Baru</span>';
                    } elseif ($row->kategori === 'siswa_pindahan') {
                        return '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1"><i class="bi bi-arrow-left-right me-1"></i>Siswa Pindahan</span>';
                    }
                    return '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1"><i class="bi bi-people me-1"></i>Semua Siswa</span>';
                })
                ->editColumn('jumlah_lembar', function ($row) {
                    return $row->jumlah_lembar ? '<span class="badge bg-light text-dark border px-2 py-1">' . e($row->jumlah_lembar) . '</span>' : '<span class="text-muted">-</span>';
                })
                ->editColumn('is_wajib', function ($row) {
                    if ($row->is_wajib) {
                        return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Wajib</span>';
                    }
                    return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">Opsional</span>';
                })
                ->editColumn('is_active', function ($row) {
                    if ($row->is_active) {
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Aktif</span>';
                    }
                    return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1"><i class="bi bi-x-circle me-1"></i>Non-Aktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('persyaratan-dokumen.edit', $row->id_jenis_dokumen);
                    $deleteUrl = route('persyaratan-dokumen.destroy', $row->id_jenis_dokumen);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_jenis_dokumen . '" data-name="' . e($row->nama_dokumen) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['nama_dokumen', 'kategori', 'jumlah_lembar', 'is_wajib', 'is_active', 'action'])
                ->make(true);
        }

        return view('pages.persyaratan_dokumen.index');
    }

    public function create()
    {
        $kategoriList = JenisDokumen::KATEGORI;
        return view('pages.persyaratan_dokumen.create', compact('kategoriList'));
    }

    public function store(StoreJenisDokumenRequest $request)
    {
        $data = $request->validated();
        $data['is_wajib'] = $request->boolean('is_wajib');
        $data['is_active'] = $request->boolean('is_active');

        JenisDokumen::create($data);

        return redirect()->route('persyaratan-dokumen.index')->with('success', 'Persyaratan dokumen berhasil ditambahkan!');
    }

    public function edit(JenisDokumen $jenisDokumen)
    {
        $kategoriList = JenisDokumen::KATEGORI;
        return view('pages.persyaratan_dokumen.edit', compact('jenisDokumen', 'kategoriList'));
    }

    public function update(UpdateJenisDokumenRequest $request, JenisDokumen $jenisDokumen)
    {
        $data = $request->validated();
        $data['is_wajib'] = $request->boolean('is_wajib');
        $data['is_active'] = $request->boolean('is_active');

        $jenisDokumen->update($data);

        return redirect()->route('persyaratan-dokumen.index')->with('success', 'Persyaratan dokumen berhasil diperbarui!');
    }

    public function destroy(Request $request, JenisDokumen $jenisDokumen)
    {
        $nama = $jenisDokumen->nama_dokumen;
        $jenisDokumen->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Persyaratan dokumen "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('persyaratan-dokumen.index')->with('success', 'Persyaratan dokumen "' . $nama . '" berhasil dihapus!');
    }
}
