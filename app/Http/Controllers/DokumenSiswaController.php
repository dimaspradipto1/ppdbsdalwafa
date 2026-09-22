<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDokumenSiswaRequest;
use App\Http\Requests\UpdateDokumenSiswaRequest;
use App\Models\CalonSiswa;
use App\Models\DokumenSiswa;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DokumenSiswaController extends Controller
{
    /**
     * Tampilkan data dokumen (dengan DataTables AJAX & Filter)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DokumenSiswa::with(['calonSiswa', 'jenisDokumen', 'verifikator'])
                ->select('dokumen_siswa.*');

            // Batasi pendaftar hanya dapat melihat dokumen milik calon siswanya sendiri
            $user = Auth::user();
            if ($user && $user->role === 'pendaftar') {
                $query->whereHas('calonSiswa', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }

            // Filter berdasarkan kategori dokumen jika ada
            if ($request->filled('kategori')) {
                $query->whereHas('jenisDokumen', function ($q) use ($request) {
                    $q->where('kategori', $request->kategori);
                });
            }

            // Filter status verifikasi
            if ($request->filled('status_verifikasi')) {
                $query->where('status_verifikasi', $request->status_verifikasi);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('calon_siswa', function ($row) {
                    if (!$row->calonSiswa) {
                        return '<span class="text-muted fst-italic">Siswa tidak ditemukan</span>';
                    }
                    $genderIcon = $row->calonSiswa->jenis_kelamin === 'Laki-laki' 
                        ? '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-1 ms-1" style="font-size: 0.7rem;"><i class="bi bi-gender-male"></i> L</span>' 
                        : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-1 ms-1" style="font-size: 0.7rem;"><i class="bi bi-gender-female"></i> P</span>';

                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 34px; height: 34px; font-weight: 600; font-size: 0.85rem;">
                                    ' . strtoupper(substr($row->calonSiswa->nama_lengkap, 0, 1)) . '
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">' . e($row->calonSiswa->nama_lengkap) . ' ' . $genderIcon . '</div>
                                    <div class="text-muted small font-monospace">NIK: ' . e($row->calonSiswa->nik ?? '-') . '</div>
                                </div>
                            </div>';
                })
                ->editColumn('jenis_dokumen', function ($row) {
                    if (!$row->jenisDokumen) {
                        return '<span class="text-muted fst-italic">-</span>';
                    }
                    $kategoriBadge = match($row->jenisDokumen->kategori) {
                        'siswa_baru'     => '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0" style="font-size: 0.72rem;"><i class="bi bi-person-plus me-1"></i>Siswa Baru</span>',
                        'siswa_pindahan' => '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-0" style="font-size: 0.72rem;"><i class="bi bi-arrow-left-right me-1"></i>Siswa Pindahan</span>',
                        default          => '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-0" style="font-size: 0.72rem;">Semua Siswa</span>',
                    };

                    $lembarBadge = $row->jenisDokumen->jumlah_lembar 
                        ? '<span class="badge bg-light text-dark border ms-1" style="font-size: 0.72rem;"><i class="bi bi-files me-1"></i>' . e($row->jenisDokumen->jumlah_lembar) . '</span>' 
                        : '';

                    $keterangan = $row->jenisDokumen->keterangan 
                        ? '<div class="text-muted small fst-italic mt-1" style="font-size: 0.78rem;"><i class="bi bi-info-circle me-1"></i>' . e($row->jenisDokumen->keterangan) . '</div>' 
                        : '';

                    return '<div>
                                <div class="mb-1">' . $kategoriBadge . ' ' . $lembarBadge . '</div>
                                <span class="fw-semibold text-dark">' . e($row->jenisDokumen->nama_dokumen) . '</span>
                                ' . $keterangan . '
                            </div>';
                })
                ->editColumn('berkas', function ($row) {
                    $fileUrl = Storage::url($row->file_path);
                    $isImage = in_array(strtolower($row->tipe_file), ['jpg', 'jpeg', 'png', 'webp']);
                    $isPdf   = strtolower($row->tipe_file) === 'pdf';

                    $icon = $isPdf 
                        ? '<i class="bi bi-file-earmark-pdf text-danger fs-5 me-2"></i>' 
                        : ($isImage ? '<i class="bi bi-file-earmark-image text-primary fs-5 me-2"></i>' : '<i class="bi bi-file-earmark text-secondary fs-5 me-2"></i>');

                    $size = $row->ukuran_file ? ' (' . round($row->ukuran_file, 0) . ' KB)' : '';

                    return '<div class="d-flex align-items-center">
                                ' . $icon . '
                                <div>
                                    <button type="button" class="btn btn-link p-0 text-decoration-none fw-semibold btn-preview text-start" data-url="' . $fileUrl . '" data-type="' . e($row->tipe_file) . '" data-name="' . e($row->nama_file) . '" style="font-size: 0.83rem;">
                                        ' . e(str($row->nama_file)->limit(22)) . '
                                    </button>
                                    <div class="text-muted small">' . strtoupper($row->tipe_file ?? 'FILE') . $size . '</div>
                                </div>
                            </div>';
                })
                ->editColumn('status_verifikasi', function ($row) {
                    return match($row->status_verifikasi) {
                        'valid'   => '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Valid / Diterima</span>',
                        'ditolak' => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="bi bi-x-circle me-1"></i>Ditolak</span>',
                        default   => '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1"><i class="bi bi-clock-history me-1"></i>Menunggu</span>',
                    };
                })
                ->addColumn('action', function ($row) {
                    $fileUrl = Storage::url($row->file_path);
                    $editUrl = route('dokumen.edit', $row->id_dokumen);
                    $deleteUrl = route('dokumen.destroy', $row->id_dokumen);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<button type="button" class="btn btn-sm btn-info text-white d-inline-flex align-items-center gap-1 px-2 py-1 btn-preview" data-url="' . $fileUrl . '" data-type="' . e($row->tipe_file) . '" data-name="' . e($row->nama_file) . '" style="font-size: 0.78rem; border-radius: 6px;" title="Lihat Berkas"><i class="bi bi-eye"></i><span>Lihat</span></button>';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit / Verifikasi"><i class="bi bi-pencil-square"></i><span>Verifikasi</span></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_dokumen . '" data-name="' . e($row->nama_file) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Berkas"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['calon_siswa', 'jenis_dokumen', 'berkas', 'status_verifikasi', 'action'])
                ->make(true);
        }

        return view('pages.dokumen.index');
    }

    /**
     * Form unggah dokumen baru
     */
    public function create()
    {
        $calonSiswa = CalonSiswa::orderBy('nama_lengkap')->get();
        $jenisDokumen = JenisDokumen::where('is_active', true)->orderBy('kategori')->orderBy('id_jenis_dokumen')->get();

        return view('pages.dokumen.create', compact('calonSiswa', 'jenisDokumen'));
    }

    /**
     * Simpan unggahan dokumen baru
     */
    public function store(StoreDokumenSiswaRequest $request)
    {
        $file = $request->file('berkas');
        $namaFileAsli = $file->getClientOriginalName();
        $tipeFile = $file->getClientOriginalExtension();
        $ukuranKb = round($file->getSize() / 1024);

        $path = $file->store('dokumen', 'public');

        DokumenSiswa::create([
            'id_calon_siswa'     => $request->id_calon_siswa,
            'id_jenis_dokumen'   => $request->id_jenis_dokumen,
            'nama_file'          => $namaFileAsli,
            'file_path'          => $path,
            'tipe_file'          => $tipeFile,
            'ukuran_file'        => $ukuranKb,
            'status_verifikasi'  => $request->status_verifikasi ?? 'menunggu',
            'catatan_verifikasi' => $request->catatan_verifikasi,
            'verified_by'        => $request->status_verifikasi && $request->status_verifikasi !== 'menunggu' ? Auth::id() : null,
            'verified_at'        => $request->status_verifikasi && $request->status_verifikasi !== 'menunggu' ? now() : null,
        ]);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diunggah!');
    }

    /**
     * Form edit & verifikasi dokumen
     */
    public function edit(DokumenSiswa $dokumen)
    {
        $dokumen->load(['calonSiswa', 'jenisDokumen']);
        $calonSiswa = CalonSiswa::orderBy('nama_lengkap')->get();
        $jenisDokumen = JenisDokumen::where('is_active', true)->orderBy('kategori')->orderBy('id_jenis_dokumen')->get();

        return view('pages.dokumen.edit', compact('dokumen', 'calonSiswa', 'jenisDokumen'));
    }

    /**
     * Perbarui berkas atau status verifikasi dokumen
     */
    public function update(UpdateDokumenSiswaRequest $request, DokumenSiswa $dokumen)
    {
        $data = [
            'id_calon_siswa'     => $request->id_calon_siswa,
            'id_jenis_dokumen'   => $request->id_jenis_dokumen,
            'status_verifikasi'  => $request->status_verifikasi,
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ];

        // Jika mengubah status dari menunggu ke valid/ditolak
        if ($request->status_verifikasi !== 'menunggu') {
            $data['verified_by'] = Auth::id();
            $data['verified_at'] = now();
        } else {
            $data['verified_by'] = null;
            $data['verified_at'] = null;
        }

        // Jika mengunggah berkas pengganti
        if ($request->hasFile('berkas')) {
            // Hapus file lama dari storage
            if (Storage::disk('public')->exists($dokumen->file_path)) {
                Storage::disk('public')->delete($dokumen->file_path);
            }

            $file = $request->file('berkas');
            $data['nama_file']   = $file->getClientOriginalName();
            $data['file_path']   = $file->store('dokumen', 'public');
            $data['tipe_file']   = $file->getClientOriginalExtension();
            $data['ukuran_file'] = round($file->getSize() / 1024);
        }

        $dokumen->update($data);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    /**
     * Hapus dokumen
     */
    public function destroy(Request $request, DokumenSiswa $dokumen)
    {
        $nama = $dokumen->nama_file;

        if (Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Dokumen "' . $nama . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('dokumen.index')->with('success', 'Dokumen "' . $nama . '" berhasil dihapus!');
    }
}
