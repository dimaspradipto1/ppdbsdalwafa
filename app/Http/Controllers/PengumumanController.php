<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Gelombang;
use App\Models\Pengumuman;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PengumumanController extends Controller
{
    /**
     * Tampilkan daftar pengumuman hasil seleksi (DataTables AJAX & View)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Pengumuman::with(['tahunAjaran', 'gelombang', 'creator'])
                ->select('pengumuman_ppdb.*');

            $user = Auth::user();
            if ($user && $user->role === 'pendaftar') {
                $query->where('is_published', true);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('info_pengumuman', function ($row) {
                    $tgl = $row->tanggal_buka ? $row->tanggal_buka->translatedFormat('d M Y H:i') : '-';
                    $nomor = $row->nomor_surat ? '<span class="text-muted small font-monospace d-block">No: ' . e($row->nomor_surat) . '</span>' : '';
                    return '<div class="fw-bold text-dark fs-6">' . e($row->judul) . '</div>' . $nomor
                         . '<div class="text-muted small mt-1"><i class="bi bi-calendar3 me-1"></i>Dibuka: ' . $tgl . '</div>';
                })
                ->addColumn('target', function ($row) {
                    $gel = $row->gelombang ? e($row->gelombang->nama_gelombang) : 'Semua Gelombang';
                    $ta = $row->tahunAjaran ? e($row->tahunAjaran->tahun_ajaran) : 'Semua TA';
                    return '<span class="fw-medium text-dark">' . $gel . '</span><div class="text-muted small">' . $ta . '</div>';
                })
                ->editColumn('is_published', function ($row) {
                    if ($row->is_published) {
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Dipublikasikan</span>';
                    }
                    return '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1"><i class="bi bi-eye-slash me-1"></i>Draft / Ditutup</span>';
                })
                ->addColumn('action', function ($row) {
                    $showUrl = route('pengumuman.show', $row->id_pengumuman);
                    $editUrl = route('pengumuman.edit', $row->id_pengumuman);
                    $deleteUrl = route('pengumuman.destroy', $row->id_pengumuman);

                    $user = Auth::user();
                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $showUrl . '" class="btn btn-sm btn-info text-white d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem;" title="Lihat Hasil & Daftar Siswa"><i class="bi bi-eye"></i><span>Hasil</span></a>';

                    if ($user && in_array($user->role, ['super_admin', 'admin_ppdb', 'kepala_sekolah'])) {
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem;" title="Edit Pengumuman"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';
                        $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_pengumuman . '" data-name="' . e($row->judul) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem;" title="Hapus Pengumuman"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    }
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['info_pengumuman', 'target', 'is_published', 'action'])
                ->make(true);
        }

        // Summary status siswa
        $totalPendaftar = CalonSiswa::count();
        $totalDiterima = CalonSiswa::where('status', 'diterima')->count();
        $totalDiverifikasi = CalonSiswa::where('status', 'diverifikasi')->count();
        $totalDitolak = CalonSiswa::where('status', 'ditolak')->count();

        return view('pages.pengumuman.index', compact('totalPendaftar', 'totalDiterima', 'totalDiverifikasi', 'totalDitolak'));
    }

    /**
     * Form buat pengumuman baru
     */
    public function create()
    {
        $daftarTahunAjaran = TahunAjaran::orderByDesc('is_active')->orderByDesc('id_tahun_ajaran')->get();
        $daftarGelombang = Gelombang::orderBy('nama_gelombang')->get();

        return view('pages.pengumuman.create', compact('daftarTahunAjaran', 'daftarGelombang'));
    }

    /**
     * Simpan pengumuman baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_tahun_ajaran' => 'nullable|exists:tahun_ajaran,id_tahun_ajaran',
            'id_gelombang'    => 'nullable|exists:gelombang,id_gelombang',
            'judul'           => 'required|string|max:200',
            'nomor_surat'     => 'nullable|string|max:100',
            'tanggal_buka'    => 'required|date',
            'isi_pengumuman'  => 'nullable|string',
            'file_lampiran'   => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'is_published'    => 'nullable|boolean',
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $data['created_by'] = Auth::id();

        if ($request->hasFile('file_lampiran')) {
            $data['file_lampiran'] = $request->file('file_lampiran')->store('pengumuman', 'public');
        }

        Pengumuman::create($data);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman kelulusan berhasil dibuat!');
    }

    /**
     * Detail Pengumuman beserta Daftar Hasil Kelulusan Siswa
     */
    public function show(Pengumuman $pengumuman)
    {
        $user = Auth::user();
        if ($user && $user->role === 'pendaftar' && !$pengumuman->is_published) {
            abort(403, 'Pengumuman kelulusan belum dipublikasikan.');
        }

        $pengumuman->load(['tahunAjaran', 'gelombang', 'creator']);

        $query = CalonSiswa::query();
        if ($pengumuman->id_tahun_ajaran) {
            $query->where('id_tahun_ajaran', $pengumuman->id_tahun_ajaran);
        }
        if ($pengumuman->id_gelombang) {
            $query->where('id_gelombang', $pengumuman->id_gelombang);
        }

        if ($user && $user->role === 'pendaftar') {
            $query->where('user_id', $user->id);
        }

        $daftarSiswa = $query->with(['jalur', 'nilaiSeleksi'])->orderBy('status')->orderBy('nama_lengkap')->get();

        return view('pages.pengumuman.show', compact('pengumuman', 'daftarSiswa'));
    }

    /**
     * Form edit pengumuman
     */
    public function edit(Pengumuman $pengumuman)
    {
        $daftarTahunAjaran = TahunAjaran::orderByDesc('is_active')->orderByDesc('id_tahun_ajaran')->get();
        $daftarGelombang = Gelombang::orderBy('nama_gelombang')->get();

        return view('pages.pengumuman.edit', compact('pengumuman', 'daftarTahunAjaran', 'daftarGelombang'));
    }

    /**
     * Perbarui pengumuman
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $request->validate([
            'id_tahun_ajaran' => 'nullable|exists:tahun_ajaran,id_tahun_ajaran',
            'id_gelombang'    => 'nullable|exists:gelombang,id_gelombang',
            'judul'           => 'required|string|max:200',
            'nomor_surat'     => 'nullable|string|max:100',
            'tanggal_buka'    => 'required|date',
            'isi_pengumuman'  => 'nullable|string',
            'file_lampiran'   => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'is_published'    => 'nullable|boolean',
        ]);

        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('file_lampiran')) {
            if ($pengumuman->file_lampiran && Storage::disk('public')->exists($pengumuman->file_lampiran)) {
                Storage::disk('public')->delete($pengumuman->file_lampiran);
            }
            $data['file_lampiran'] = $request->file('file_lampiran')->store('pengumuman', 'public');
        }

        $pengumuman->update($data);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Cetak Surat Keterangan Penerimaan / Kelulusan (SKL) Resmi Siswa
     */
    public function suratKelulusan(CalonSiswa $calonSiswa)
    {
        $calonSiswa->load(['tahunAjaran', 'gelombang', 'jalur']);
        return view('pages.pengumuman.surat_kelulusan', compact('calonSiswa'));
    }

    /**
     * Hapus pengumuman
     */
    public function destroy(Request $request, Pengumuman $pengumuman)
    {
        $judul = $pengumuman->judul;

        if ($pengumuman->file_lampiran && Storage::disk('public')->exists($pengumuman->file_lampiran)) {
            Storage::disk('public')->delete($pengumuman->file_lampiran);
        }

        $pengumuman->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengumuman "' . $judul . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman "' . $judul . '" berhasil dihapus!');
    }
}
