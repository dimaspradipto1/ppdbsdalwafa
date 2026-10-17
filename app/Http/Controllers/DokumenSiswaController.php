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
     * Tampilkan data dokumen dikelompokkan per Calon Siswa (dengan DataTables AJAX & Filter)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isPendaftar = $user && in_array($user->role, ['pendaftar', 'user']);

        if ($request->ajax()) {
            $query = CalonSiswa::with(['dokumen.jenisDokumen', 'jalur', 'gelombang', 'tahunAjaran'])
                ->select('calon_siswa.*');

            if ($isPendaftar) {
                $query->where('user_id', $user->id);
            }

            // Filter Kategori (Siswa Baru vs Siswa Pindahan)
            if ($request->filled('kategori')) {
                if ($request->kategori === 'siswa_pindahan') {
                    $query->whereHas('jalur', function ($q) {
                        $q->where('kode_jalur', 'PINDAHAN');
                    });
                } elseif ($request->kategori === 'siswa_baru') {
                    $query->where(function ($q) {
                        $q->whereDoesntHave('jalur')
                          ->orWhereHas('jalur', function ($q2) {
                              $q2->where('kode_jalur', '!=', 'PINDAHAN');
                          });
                    });
                }
            }

            // Filter Status Verifikasi Dokumen
            if ($request->filled('status_verifikasi')) {
                if ($request->status_verifikasi === 'valid') {
                    $query->whereHas('dokumen')
                          ->whereDoesntHave('dokumen', function ($q) {
                              $q->where('status_verifikasi', '!=', 'valid');
                          });
                } elseif ($request->status_verifikasi === 'menunggu') {
                    $query->whereHas('dokumen', function ($q) {
                        $q->where('status_verifikasi', 'menunggu');
                    });
                } elseif ($request->status_verifikasi === 'ditolak') {
                    $query->whereHas('dokumen', function ($q) {
                        $q->where('status_verifikasi', 'ditolak');
                    });
                } elseif ($request->status_verifikasi === 'belum_unggah') {
                    $query->doesntHave('dokumen');
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('calon_siswa', function ($row) {
                    $genderIcon = $row->jenis_kelamin === 'Laki-laki' 
                        ? '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-1 ms-1" style="font-size: 0.7rem;"><i class="bi bi-gender-male"></i> L</span>' 
                        : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-1 ms-1" style="font-size: 0.7rem;"><i class="bi bi-gender-female"></i> P</span>';

                    $noReg = $row->no_pendaftaran ?: str_pad($row->id_calon_siswa, 8, '0', STR_PAD_LEFT);

                    return '<div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px; font-weight: 700; font-size: 0.9rem;">
                                    ' . strtoupper(substr($row->nama_lengkap, 0, 1)) . '
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-6">' . e($row->nama_lengkap) . ' ' . $genderIcon . '</div>
                                    <div class="text-muted small mt-1">
                                        <span class="badge bg-light text-dark border font-monospace me-1"><i class="bi bi-card-text me-1"></i>' . e($noReg) . '</span>
                                        <span class="text-secondary">' . e(optional($row->jalur)->nama_jalur ?? 'Jalur Reguler') . '</span>
                                    </div>
                                </div>
                            </div>';
                })
                ->editColumn('kategori', function ($row) {
                    $isPindahan = optional($row->jalur)->kode_jalur === 'PINDAHAN';
                    $badgeKategori = $isPindahan 
                        ? '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1"><i class="bi bi-arrow-left-right me-1"></i>Siswa Pindahan</span>' 
                        : '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-person-plus me-1"></i>Siswa Baru</span>';

                    $gelombang = optional($row->gelombang)->nama_gelombang ?? 'Gelombang 1';

                    return '<div>
                                <div>' . $badgeKategori . '</div>
                                <div class="text-muted small mt-1"><i class="bi bi-calendar3 me-1"></i>' . e($gelombang) . '</div>
                            </div>';
                })
                ->editColumn('kelengkapan', function ($row) {
                    $total = $row->dokumen->count();
                    $valid = $row->dokumen->where('status_verifikasi', 'valid')->count();
                    $menunggu = $row->dokumen->where('status_verifikasi', 'menunggu')->count();
                    $ditolak = $row->dokumen->where('status_verifikasi', 'ditolak')->count();

                    if ($total === 0) {
                        return '<span class="badge bg-light text-muted border px-2 py-1"><i class="bi bi-dash-circle me-1"></i>0 Berkas Terunggah</span>';
                    }

                    $pills = '<div class="d-flex flex-wrap gap-1 mt-1">';
                    if ($valid > 0) {
                        $pills .= '<span class="badge bg-success text-white" style="font-size: 0.72rem;"><i class="bi bi-check me-1"></i>' . $valid . ' Valid</span>';
                    }
                    if ($menunggu > 0) {
                        $pills .= '<span class="badge bg-warning text-dark border border-warning fw-semibold" style="font-size: 0.72rem;"><i class="bi bi-clock me-1"></i>' . $menunggu . ' Menunggu</span>';
                    }
                    if ($ditolak > 0) {
                        $pills .= '<span class="badge bg-danger text-white" style="font-size: 0.72rem;"><i class="bi bi-x me-1"></i>' . $ditolak . ' Ditolak</span>';
                    }
                    $pills .= '</div>';

                    return '<div>
                                <span class="fw-bold text-dark"><i class="bi bi-files text-primary me-1"></i>' . $total . ' Berkas Diunggah</span>
                                ' . $pills . '
                            </div>';
                })
                ->editColumn('status_verifikasi', function ($row) {
                    $total = $row->dokumen->count();
                    $valid = $row->dokumen->where('status_verifikasi', 'valid')->count();
                    $menunggu = $row->dokumen->where('status_verifikasi', 'menunggu')->count();
                    $ditolak = $row->dokumen->where('status_verifikasi', 'ditolak')->count();

                    if ($total === 0) {
                        return '<span class="badge bg-secondary-subtle text-secondary border px-2 py-1"><i class="bi bi-cloud-slash me-1"></i>Belum Ada Berkas</span>';
                    }
                    if ($ditolak > 0) {
                        return '<span class="badge bg-danger text-white px-2 py-1"><i class="bi bi-exclamation-triangle-fill me-1"></i>Perlu Perbaikan</span>';
                    }
                    if ($menunggu > 0) {
                        return '<span class="badge bg-warning text-dark border border-warning px-2 py-1 fw-bold shadow-sm"><i class="bi bi-hourglass-split me-1 text-dark"></i>Menunggu Verifikasi</span>';
                    }
                    return '<span class="badge bg-success text-white px-2 py-1 fw-semibold"><i class="bi bi-check2-all me-1"></i>Semua Berkas Valid</span>';
                })
                ->addColumn('action', function ($row) use ($isPendaftar) {
                    $total = $row->dokumen->count();
                    $btnClass = $isPendaftar ? 'btn-info text-white' : 'btn-primary';
                    $btnIcon = $isPendaftar ? 'bi-eye' : 'bi-folder-check';
                    $btnText = $isPendaftar ? 'Lihat Berkas' : 'Detail & Verifikasi';

                    return '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">
                                <button type="button" class="btn btn-sm ' . $btnClass . ' d-inline-flex align-items-center gap-1 px-3 py-1 btn-detail-dokumen shadow-sm" 
                                    data-id="' . $row->id_calon_siswa . '" 
                                    data-nama="' . e($row->nama_lengkap) . '">
                                    <i class="bi ' . $btnIcon . '"></i><span>' . $btnText . '</span>
                                    <span class="badge bg-white text-dark ms-1">' . $total . '</span>
                                </button>
                            </div>';
                })
                ->rawColumns(['calon_siswa', 'kategori', 'kelengkapan', 'status_verifikasi', 'action'])
                ->make(true);
        }

        // Statistik summary data
        $baseQuery = CalonSiswa::query();
        if ($isPendaftar) {
            $baseQuery->where('user_id', $user->id);
        }
        $totalSiswa = (clone $baseQuery)->count();
        $siswaMenunggu = (clone $baseQuery)->whereHas('dokumen', function ($q) {
            $q->where('status_verifikasi', 'menunggu');
        })->count();
        $siswaValid = (clone $baseQuery)->whereHas('dokumen')->whereDoesntHave('dokumen', function ($q) {
            $q->where('status_verifikasi', '!=', 'valid');
        })->count();
        $siswaDitolak = (clone $baseQuery)->whereHas('dokumen', function ($q) {
            $q->where('status_verifikasi', 'ditolak');
        })->count();
        $siswaBelumUnggah = (clone $baseQuery)->doesntHave('dokumen')->count();

        $stats = compact('totalSiswa', 'siswaMenunggu', 'siswaValid', 'siswaDitolak', 'siswaBelumUnggah');

        return view('pages.dokumen.index', compact('stats', 'isPendaftar'));
    }

    /**
     * Ambil data berkas dokumen milik 1 calon siswa untuk ditampilkan di modal detail
     */
    public function getDokumenBySiswa(CalonSiswa $calonSiswa)
    {
        $user = Auth::user();
        $isPendaftar = $user && in_array($user->role, ['pendaftar', 'user']);

        if ($isPendaftar && $calonSiswa->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki hak akses untuk siswa ini.'], 403);
        }

        $calonSiswa->load(['dokumen.jenisDokumen', 'dokumen.verifikator', 'jalur', 'gelombang', 'tahunAjaran']);

        $isPindahan = optional($calonSiswa->jalur)->kode_jalur === 'PINDAHAN';
        $targetKategori = $isPindahan ? 'siswa_pindahan' : 'siswa_baru';

        // Persyaratan dokumen wajib
        $syaratDocs = JenisDokumen::where('is_active', true)
            ->where(function ($q) use ($targetKategori) {
                $q->where('kategori', $targetKategori)
                  ->orWhere('kategori', 'semua')
                  ->orWhereNull('kategori');
            })
            ->get();

        $uploadedDocs = $calonSiswa->dokumen->map(function ($d) {
            return [
                'id_dokumen'         => $d->id_dokumen,
                'id_jenis_dokumen'   => $d->id_jenis_dokumen,
                'nama_dokumen'       => optional($d->jenisDokumen)->nama_dokumen ?? 'Dokumen Tambahan',
                'kode_dokumen'       => optional($d->jenisDokumen)->kode ?? '-',
                'keterangan_syarat'  => optional($d->jenisDokumen)->keterangan ?? '',
                'nama_file'          => $d->nama_file,
                'file_url'           => Storage::url($d->file_path),
                'tipe_file'          => strtolower($d->tipe_file ?? 'file'),
                'ukuran_file'        => $d->ukuran_file ?? 0,
                'status_verifikasi'  => $d->status_verifikasi ?? 'menunggu',
                'catatan_verifikasi' => $d->catatan_verifikasi ?? '',
                'verified_by_name'   => optional($d->verifikator)->name ?? '-',
                'verified_at'        => $d->verified_at ? $d->verified_at->translatedFormat('d M Y H:i') : null,
                'created_at'         => $d->created_at ? $d->created_at->translatedFormat('d M Y H:i') : null,
                'edit_url'           => route('dokumen.edit', $d->id_dokumen),
                'delete_url'         => route('dokumen.destroy', $d->id_dokumen),
            ];
        });

        $uploadedJenisIds = $calonSiswa->dokumen->pluck('id_jenis_dokumen')->filter()->all();
        $missingDocs = $syaratDocs->filter(function ($doc) use ($uploadedJenisIds) {
            return !in_array($doc->id_jenis_dokumen, $uploadedJenisIds);
        })->values();

        $canVerify = $user && in_array($user->role, ['super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah']);

        return response()->json([
            'success'      => true,
            'siswa'        => [
                'id_calon_siswa' => $calonSiswa->id_calon_siswa,
                'nama_lengkap'   => $calonSiswa->nama_lengkap,
                'no_pendaftaran' => $calonSiswa->no_pendaftaran ?: str_pad($calonSiswa->id_calon_siswa, 8, '0', STR_PAD_LEFT),
                'jenis_kelamin'  => $calonSiswa->jenis_kelamin,
                'jalur'          => optional($calonSiswa->jalur)->nama_jalur ?? 'Jalur Reguler',
                'gelombang'      => optional($calonSiswa->gelombang)->nama_gelombang ?? '-',
                'tahun_ajaran'   => optional($calonSiswa->tahunAjaran)->tahun_ajaran ?? '-',
                'kategori_label' => $isPindahan ? 'Siswa Pindahan' : 'Siswa Baru',
                'status_siswa'   => $calonSiswa->status,
            ],
            'dokumen'      => $uploadedDocs,
            'missing_docs' => $missingDocs,
            'can_verify'   => $canVerify,
        ]);
    }

    /**
     * Ubah status verifikasi dokumen secara cepat via modal AJAX
     */
    public function quickVerifikasi(Request $request, DokumenSiswa $dokumen)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah'])) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki hak akses verifikasi.'], 403);
        }

        $request->validate([
            'status_verifikasi'  => 'required|in:valid,menunggu,ditolak',
            'catatan_verifikasi' => 'nullable|string|max:500',
        ]);

        $dokumen->status_verifikasi  = $request->status_verifikasi;
        $dokumen->catatan_verifikasi = $request->catatan_verifikasi;
        $dokumen->verified_by        = $request->status_verifikasi !== 'menunggu' ? $user->id : null;
        $dokumen->verified_at        = $request->status_verifikasi !== 'menunggu' ? now() : null;
        $dokumen->save();

        return response()->json([
            'success' => true,
            'message' => 'Status verifikasi berkas "' . ($dokumen->nama_file) . '" berhasil diubah menjadi ' . strtoupper($dokumen->status_verifikasi) . '!',
            'dokumen' => [
                'id_dokumen'         => $dokumen->id_dokumen,
                'status_verifikasi'  => $dokumen->status_verifikasi,
                'catatan_verifikasi' => $dokumen->catatan_verifikasi,
                'verified_by_name'   => $user->name,
                'verified_at'        => $dokumen->verified_at ? $dokumen->verified_at->translatedFormat('d M Y H:i') : null,
            ]
        ]);
    }

    /**
     * Verifikasi semua dokumen calon siswa sekaligus
     */
    public function verifikasiSemua(Request $request, CalonSiswa $calonSiswa)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah'])) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki hak akses verifikasi.'], 403);
        }

        $status = $request->input('status', 'valid');
        if (!in_array($status, ['valid', 'menunggu'])) {
            $status = 'valid';
        }

        $updated = DokumenSiswa::where('id_calon_siswa', $calonSiswa->id_calon_siswa)
            ->update([
                'status_verifikasi'  => $status,
                'catatan_verifikasi' => $status === 'valid' ? 'Berkas lengkap dan sesuai persyaratan.' : null,
                'verified_by'        => $status === 'valid' ? $user->id : null,
                'verified_at'        => $status === 'valid' ? now() : null,
            ]);

        return response()->json([
            'success' => true,
            'message' => "Berhasil memverifikasi {$updated} berkas dokumen milik {$calonSiswa->nama_lengkap} sebagai " . strtoupper($status) . "!",
        ]);
    }

    /**
     * Form unggah dokumen baru
     */
    /**
     * Form unggah dokumen baru
     */
    public function create()
    {
        $user = Auth::user();
        $isPendaftar = $user && ($user->role === 'pendaftar' || $user->role === 'user');

        if ($isPendaftar) {
            $calonSiswa = CalonSiswa::where('user_id', $user->id)->orderBy('nama_lengkap')->get();
        } else {
            $calonSiswa = CalonSiswa::orderBy('nama_lengkap')->get();
        }

        $jenisDokumen = JenisDokumen::where('is_active', true)->orderBy('kategori')->orderBy('id_jenis_dokumen')->get();

        return view('pages.dokumen.create', compact('calonSiswa', 'jenisDokumen', 'isPendaftar'));
    }

    /**
     * Simpan unggahan dokumen baru
     */
    public function store(StoreDokumenSiswaRequest $request)
    {
        $user = Auth::user();
        $isPendaftar = $user && ($user->role === 'pendaftar' || $user->role === 'user');

        if ($isPendaftar) {
            // Otomatis tentukan calon siswa milik akun pendaftar
            $idCalonSiswa = $request->id_calon_siswa;
            $siswaValid = CalonSiswa::where('user_id', $user->id)
                ->where('id_calon_siswa', $idCalonSiswa)
                ->exists();

            if (!$siswaValid) {
                $siswaPertama = CalonSiswa::where('user_id', $user->id)->first();
                if ($siswaPertama) {
                    $idCalonSiswa = $siswaPertama->id_calon_siswa;
                } else {
                    return back()->withErrors(['id_calon_siswa' => 'Akun Anda belum memiliki data calon siswa yang terdaftar.'])->withInput();
                }
            }

            // Calon siswa tidak bisa menentukan status & catatan verifikasi
            $statusVerifikasi  = 'menunggu';
            $catatanVerifikasi = null;
            $verifiedBy        = null;
            $verifiedAt        = null;
        } else {
            $idCalonSiswa      = $request->id_calon_siswa;
            $statusVerifikasi  = $request->status_verifikasi ?? 'menunggu';
            $catatanVerifikasi = $request->catatan_verifikasi;
            $verifiedBy        = $statusVerifikasi !== 'menunggu' ? Auth::id() : null;
            $verifiedAt        = $statusVerifikasi !== 'menunggu' ? now() : null;
        }

        $file = $request->file('berkas');
        $namaFileAsli = $file->getClientOriginalName();
        $tipeFile = $file->getClientOriginalExtension();
        $ukuranKb = round($file->getSize() / 1024);

        $path = $file->store('dokumen', 'public');

        DokumenSiswa::create([
            'id_calon_siswa'     => $idCalonSiswa,
            'id_jenis_dokumen'   => $request->id_jenis_dokumen,
            'nama_file'          => $namaFileAsli,
            'file_path'          => $path,
            'tipe_file'          => $tipeFile,
            'ukuran_file'        => $ukuranKb,
            'status_verifikasi'  => $statusVerifikasi,
            'catatan_verifikasi' => $catatanVerifikasi,
            'verified_by'        => $verifiedBy,
            'verified_at'        => $verifiedAt,
        ]);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diunggah!');
    }

    /**
     * Form edit & verifikasi dokumen
     */
    public function edit(DokumenSiswa $dokumen)
    {
        $user = Auth::user();
        $isPendaftar = $user && ($user->role === 'pendaftar' || $user->role === 'user');

        if ($isPendaftar && $dokumen->calonSiswa && $dokumen->calonSiswa->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah dokumen ini.');
        }

        $dokumen->load(['calonSiswa', 'jenisDokumen']);

        if ($isPendaftar) {
            $calonSiswa = CalonSiswa::where('user_id', $user->id)->orderBy('nama_lengkap')->get();
        } else {
            $calonSiswa = CalonSiswa::orderBy('nama_lengkap')->get();
        }

        $jenisDokumen = JenisDokumen::where('is_active', true)->orderBy('kategori')->orderBy('id_jenis_dokumen')->get();

        return view('pages.dokumen.edit', compact('dokumen', 'calonSiswa', 'jenisDokumen', 'isPendaftar'));
    }

    /**
     * Perbarui berkas atau status verifikasi dokumen
     */
    public function update(UpdateDokumenSiswaRequest $request, DokumenSiswa $dokumen)
    {
        $user = Auth::user();
        $isPendaftar = $user && ($user->role === 'pendaftar' || $user->role === 'user');

        if ($isPendaftar && $dokumen->calonSiswa && $dokumen->calonSiswa->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah dokumen ini.');
        }

        $data = [
            'id_jenis_dokumen' => $request->id_jenis_dokumen,
        ];

        // Jika bukan pendaftar (admin/petugas verifikator)
        if (!$isPendaftar) {
            $data['id_calon_siswa']     = $request->id_calon_siswa;
            $data['status_verifikasi']  = $request->status_verifikasi;
            $data['catatan_verifikasi'] = $request->catatan_verifikasi;

            if ($request->status_verifikasi !== 'menunggu') {
                $data['verified_by'] = Auth::id();
                $data['verified_at'] = now();
            } else {
                $data['verified_by'] = null;
                $data['verified_at'] = null;
            }
        } else {
            // Pendaftar mengunggah berkas perbaikan: reset status ke menunggu
            if ($request->hasFile('berkas')) {
                $data['status_verifikasi']  = 'menunggu';
                $data['catatan_verifikasi'] = null;
                $data['verified_by']        = null;
                $data['verified_at']        = null;
            }
        }

        // Jika mengunggah berkas pengganti
        if ($request->hasFile('berkas')) {
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
