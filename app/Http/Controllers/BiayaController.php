<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBiayaRequest;
use App\Http\Requests\UpdateBiayaRequest;
use App\Models\Biaya;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BiayaController extends Controller
{
    /**
     * Tampilkan data biaya & tarif PPDB (DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Biaya::with(['tahunAjaran', 'gelombang', 'jalur'])->select('biaya_ppdb.*');

            if ($request->filled('id_tahun_ajaran')) {
                $query->where('id_tahun_ajaran', $request->id_tahun_ajaran);
            }
            if ($request->filled('jenis_biaya')) {
                $query->where('jenis_biaya', $request->jenis_biaya);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_biaya', function ($row) {
                    $ket = $row->keterangan ? '<div class="text-muted small">' . e($row->keterangan) . '</div>' : '';
                    return '<div class="d-flex align-items-center">
                                <div class="bg-success-subtle text-success rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                    <i class="bi bi-cash-coin" style="font-size: 0.95rem;"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark">' . e($row->nama_biaya) . '</span>
                                    ' . $ket . '
                                </div>
                            </div>';
                })
                ->editColumn('jenis_biaya', function ($row) {
                    $label = Biaya::KATEGORI_BIAYA[$row->jenis_biaya] ?? ucfirst($row->jenis_biaya);
                    return '<span class="badge bg-light text-dark border px-2 py-1">' . e($label) . '</span>';
                })
                ->editColumn('nominal', function ($row) {
                    return '<span class="fw-bold text-success font-monospace">Rp ' . number_format($row->nominal, 0, ',', '.') . '</span>';
                })
                ->addColumn('penerapan', function ($row) {
                    $items = [];
                    if ($row->tahunAjaran) {
                        $items[] = '<span class="badge bg-light text-dark border"><i class="bi bi-calendar-range me-1 text-primary"></i>' . e($row->tahunAjaran->tahun_ajaran) . '</span>';
                    }
                    if ($row->gelombang) {
                        $items[] = '<span class="badge bg-info-subtle text-info border border-info-subtle"><i class="bi bi-layers me-1"></i>' . e($row->gelombang->nama_gelombang) . '</span>';
                    }
                    if ($row->jalur) {
                        $items[] = '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle"><i class="bi bi-signpost-split me-1"></i>' . e($row->jalur->nama_jalur) . '</span>';
                    }
                    return !empty($items) ? implode(' ', $items) : '<span class="text-muted small fst-italic">Semua Siswa</span>';
                })
                ->editColumn('tipe_pembayaran', function ($row) {
                    if ($row->tipe_pembayaran === 'bulanan') {
                        return '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">Bulanan</span>';
                    } elseif ($row->tipe_pembayaran === 'sukarela') {
                        return '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">Sukarela</span>';
                    }
                    return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">Sekali Bayar</span>';
                })
                ->editColumn('is_active', function ($row) {
                    if ($row->is_active) {
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Aktif</span>';
                    }
                    return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1"><i class="bi bi-x-circle me-1"></i>Non-Aktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('biaya.edit', $row->id_biaya);
                    $deleteUrl = route('biaya.destroy', $row->id_biaya);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_biaya . '" data-name="' . e($row->nama_biaya) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['nama_biaya', 'jenis_biaya', 'nominal', 'penerapan', 'tipe_pembayaran', 'is_active', 'action'])
                ->make(true);
        }

        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();
        $kategoriBiaya = Biaya::KATEGORI_BIAYA;

        return view('pages.biaya.index', compact('tahunAjaranList', 'kategoriBiaya'));
    }

    public function create()
    {
        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();
        $gelombangList = Gelombang::orderBy('id_gelombang', 'asc')->get();
        $jalurList = Jalur::orderBy('id_jalur', 'asc')->get();
        $kategoriBiaya = Biaya::KATEGORI_BIAYA;
        $tipePembayaran = Biaya::TIPE_PEMBAYARAN;
        $activeTahunAjaran = TahunAjaran::active()->first();

        return view('pages.biaya.create', compact('tahunAjaranList', 'gelombangList', 'jalurList', 'kategoriBiaya', 'tipePembayaran', 'activeTahunAjaran'));
    }

    public function store(StoreBiayaRequest $request)
    {
        $data = $request->validated();
        $data['is_wajib'] = $request->boolean('is_wajib');
        $data['is_active'] = $request->boolean('is_active');

        Biaya::create($data);

        return redirect()->route('biaya.index')->with('success', 'Biaya & tarif PPDB berhasil ditambahkan!');
    }

    public function edit(Biaya $biaya)
    {
        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();
        $gelombangList = Gelombang::orderBy('id_gelombang', 'asc')->get();
        $jalurList = Jalur::orderBy('id_jalur', 'asc')->get();
        $kategoriBiaya = Biaya::KATEGORI_BIAYA;
        $tipePembayaran = Biaya::TIPE_PEMBAYARAN;

        return view('pages.biaya.edit', compact('biaya', 'tahunAjaranList', 'gelombangList', 'jalurList', 'kategoriBiaya', 'tipePembayaran'));
    }

    public function update(UpdateBiayaRequest $request, Biaya $biaya)
    {
        $data = $request->validated();
        $data['is_wajib'] = $request->boolean('is_wajib');
        $data['is_active'] = $request->boolean('is_active');

        $biaya->update($data);

        return redirect()->route('biaya.index')->with('success', 'Biaya & tarif PPDB berhasil diperbarui!');
    }

    public function destroy(Request $request, Biaya $biaya)
    {
        $nama = $biaya->nama_biaya;
        $biaya->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Biaya "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('biaya.index')->with('success', 'Biaya "' . $nama . '" berhasil dihapus!');
    }
}
