<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSekolahRequest;
use App\Http\Requests\UpdateSekolahRequest;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SekolahController extends Controller
{
    /**
     * Tampilkan data sekolah (dengan Yajra DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sekolah = Sekolah::query()->latest('id_sekolah');

            return DataTables::of($sekolah)
                ->addIndexColumn()
                ->addColumn('logo', function ($row) {
                    $url = $row->logo_url;
                    return '<div class="d-flex align-items-center justify-content-center">
                                <img src="' . $url . '" alt="Logo" class="rounded border p-1 bg-white shadow-xs" style="width: 44px; height: 44px; object-fit: contain;">
                            </div>';
                })
                ->editColumn('nama_sekolah', function ($row) {
                    $yayasan = $row->nama_yayasan ? '<div class="text-muted small">' . e($row->nama_yayasan) . '</div>' : '';
                    return '<div>
                                <span class="fw-bold text-dark">' . e($row->nama_sekolah) . '</span>' . $yayasan . '
                            </div>';
                })
                ->editColumn('npsn', function ($row) {
                    return $row->npsn 
                        ? '<span class="badge bg-light text-dark border font-monospace px-2 py-1">' . e($row->npsn) . '</span>' 
                        : '<span class="text-muted small">-</span>';
                })
                ->addColumn('jenjang_status', function ($row) {
                    return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 me-1">' . e($row->jenjang) . '</span>' .
                           '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">' . e($row->status_sekolah) . '</span>';
                })
                ->addColumn('kontak', function ($row) {
                    $html = '';
                    if ($row->telepon) {
                        $html .= '<div class="small text-nowrap"><i class="bi bi-telephone me-1 text-primary"></i>' . e($row->telepon) . '</div>';
                    }
                    if ($row->email) {
                        $html .= '<div class="small text-muted text-nowrap"><i class="bi bi-envelope me-1 text-danger"></i>' . e($row->email) . '</div>';
                    }
                    return $html ?: '<span class="text-muted small">-</span>';
                })
                ->addColumn('lokasi', function ($row) {
                    $kecKota = array_filter([$row->kecamatan, $row->kabupaten_kota]);
                    return '<div class="small text-muted">' . (implode(', ', $kecKota) ?: e($row->alamat ?? '-')) . '</div>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('sekolah.edit', $row->id_sekolah);
                    $deleteUrl = route('sekolah.destroy', $row->id_sekolah);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<button type="button" class="btn btn-sm btn-info text-white btn-detail" data-sekolah=\'' . json_encode($row) . '\' style="font-size: 0.78rem; border-radius: 6px;" title="Lihat Detail"><i class="bi bi-eye"></i></button>';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit Sekolah"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_sekolah . '" data-name="' . e($row->nama_sekolah) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Sekolah"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['logo', 'nama_sekolah', 'npsn', 'jenjang_status', 'kontak', 'lokasi', 'action'])
                ->make(true);
        }

        return view('pages.sekolah.index');
    }

    /**
     * Form tambah sekolah baru
     */
    public function create()
    {
        $jenjangList = Sekolah::JENJANG;
        $statusList = Sekolah::STATUS;

        return view('pages.sekolah.create', compact('jenjangList', 'statusList'));
    }

    /**
     * Simpan sekolah baru ke database
     */
    public function store(StoreSekolahRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_sekolah_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/uploads/sekolah');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $data['logo_path'] = 'assets/uploads/sekolah/' . $filename;
        }

        unset($data['logo']);

        Sekolah::create($data);

        return redirect()->route('sekolah.index')->with('success', 'Data sekolah berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail sekolah
     */
    public function show(Sekolah $sekolah)
    {
        return response()->json($sekolah);
    }

    /**
     * Form edit sekolah
     */
    public function edit(Sekolah $sekolah)
    {
        $jenjangList = Sekolah::JENJANG;
        $statusList = Sekolah::STATUS;

        return view('pages.sekolah.edit', compact('sekolah', 'jenjangList', 'statusList'));
    }

    /**
     * Perbarui data sekolah
     */
    public function update(UpdateSekolahRequest $request, Sekolah $sekolah)
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika berada di direktori upload custom
            if ($sekolah->logo_path && str_starts_with($sekolah->logo_path, 'assets/uploads/')) {
                $oldFile = public_path($sekolah->logo_path);
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }

            $file = $request->file('logo');
            $filename = 'logo_sekolah_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/uploads/sekolah');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $data['logo_path'] = 'assets/uploads/sekolah/' . $filename;
        }

        unset($data['logo']);

        $sekolah->update($data);

        return redirect()->route('sekolah.index')->with('success', 'Data sekolah berhasil diperbarui!');
    }

    /**
     * Hapus data sekolah
     */
    public function destroy(Request $request, Sekolah $sekolah)
    {
        $nama = $sekolah->nama_sekolah;

        if ($sekolah->logo_path && str_starts_with($sekolah->logo_path, 'assets/uploads/')) {
            $oldFile = public_path($sekolah->logo_path);
            if (file_exists($oldFile)) {
                @unlink($oldFile);
            }
        }

        $sekolah->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Sekolah ' . $nama . ' berhasil dihapus!',
            ]);
        }

        return redirect()->route('sekolah.index')->with('success', 'Sekolah ' . $nama . ' berhasil dihapus!');
    }
}
