<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;
use App\Models\Biaya;
use App\Models\CalonSiswa;
use App\Models\Pembayaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PembayaranController extends Controller
{
    /**
     * Tampilkan data pembayaran (DataTables AJAX & View)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Pembayaran::with(['calonSiswa.tahunAjaran', 'biaya', 'verifikator'])
                ->select('pembayaran_ppdb.*');

            if ($request->filled('status_pembayaran')) {
                $query->where('status_pembayaran', $request->status_pembayaran);
            }

            if ($request->filled('id_tahun_ajaran')) {
                $query->whereHas('calonSiswa', function ($q) use ($request) {
                    $q->where('id_tahun_ajaran', $request->id_tahun_ajaran);
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('transaksi', function ($row) {
                    $tgl = $row->tanggal_bayar ? $row->tanggal_bayar->translatedFormat('d M Y H:i') : '-';
                    return '<span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace px-2 py-1 mb-1">' . e($row->kode_transaksi) . '</span>'
                         . '<div class="text-muted small" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i>' . $tgl . '</div>';
                })
                ->addColumn('siswa', function ($row) {
                    if (!$row->calonSiswa) {
                        return '<span class="text-muted fst-italic">Siswa tidak ditemukan</span>';
                    }
                    $no = e($row->calonSiswa->no_pendaftaran ?? '-');
                    return '<div class="fw-bold text-dark">' . e($row->calonSiswa->nama_lengkap) . '</div>'
                         . '<div class="text-muted small font-monospace"><i class="bi bi-person-badge me-1"></i>' . $no . '</div>';
                })
                ->addColumn('tagihan', function ($row) {
                    return $row->biaya ? '<span class="fw-medium text-dark">' . e($row->biaya->nama_biaya) . '</span>' : '<span class="text-muted">Biaya Umum</span>';
                })
                ->editColumn('nominal', function ($row) {
                    return '<span class="fw-bold text-success font-monospace">Rp ' . number_format($row->nominal, 0, ',', '.') . '</span>';
                })
                ->addColumn('metode_info', function ($row) {
                    $metode = '<span class="badge bg-light text-dark border">' . e($row->metode_pembayaran) . '</span>';
                    $info = '';
                    if ($row->nama_bank_pengirim) {
                        $info = '<div class="text-muted small mt-1">' . e($row->nama_bank_pengirim) . ' a.n ' . e($row->atas_nama_pengirim ?: '-') . '</div>';
                    }
                    return $metode . $info;
                })
                ->addColumn('bukti', function ($row) {
                    if ($row->bukti_transfer) {
                        $url = asset('storage/' . $row->bukti_transfer);
                        return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-outline-info px-2 py-1" style="font-size: 0.75rem;"><i class="bi bi-image me-1"></i>Bukti</a>';
                    }
                    return '<span class="badge bg-light text-muted border">Tanpa Berkas</span>';
                })
                ->editColumn('status_pembayaran', function ($row) {
                    $badges = [
                        'menunggu_konfirmasi' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                        'lunas'               => 'bg-success-subtle text-success border-success-subtle',
                        'ditolak'             => 'bg-danger-subtle text-danger border-danger-subtle',
                    ];
                    $labels = [
                        'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                        'lunas'               => 'Lunas',
                        'ditolak'             => 'Ditolak',
                    ];
                    $cls = $badges[$row->status_pembayaran] ?? 'bg-light text-dark';
                    $lbl = $labels[$row->status_pembayaran] ?? ucfirst($row->status_pembayaran);

                    return '<button type="button" class="btn btn-sm ' . $cls . ' border px-2 py-1 btn-quick-status-bayar" '
                        . 'data-id="' . $row->id_pembayaran . '" '
                        . 'data-kode="' . e($row->kode_transaksi) . '" '
                        . 'data-status="' . $row->status_pembayaran . '" '
                        . 'data-catatan="' . e($row->catatan ?? '') . '" '
                        . 'title="Ubah Status Pembayaran">'
                        . '<i class="bi bi-patch-check me-1"></i>' . $lbl . '</button>';
                })
                ->addColumn('action', function ($row) {
                    $kwitansiUrl = route('pembayaran.kwitansi', $row->id_pembayaran);
                    $editUrl = route('pembayaran.edit', $row->id_pembayaran);
                    $deleteUrl = route('pembayaran.destroy', $row->id_pembayaran);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    if ($row->status_pembayaran === 'lunas') {
                        $buttons .= '<a href="' . $kwitansiUrl . '" target="_blank" class="btn btn-sm btn-outline-dark d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem;" title="Cetak Kwitansi"><i class="bi bi-printer"></i><span>Kwitansi</span></a>';
                    }
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem;" title="Edit Transaksi"><i class="bi bi-pencil-square"></i></a>';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $row->id_pembayaran . '" data-name="' . e($row->kode_transaksi) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem;" title="Hapus"><i class="bi bi-trash3"></i></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['transaksi', 'siswa', 'tagihan', 'nominal', 'metode_info', 'bukti', 'status_pembayaran', 'action'])
                ->make(true);
        }

        $tahunAjaranList = TahunAjaran::orderByDesc('is_active')->orderByDesc('id_tahun_ajaran')->get();

        return view('pages.pembayaran.index', compact('tahunAjaranList'));
    }

    /**
     * Form entri pembayaran baru
     */
    public function create(Request $request)
    {
        $daftarSiswa = CalonSiswa::orderBy('nama_lengkap')->get(['id_calon_siswa', 'nama_lengkap', 'no_pendaftaran']);
        $daftarBiaya = Biaya::where('is_active', true)->orderBy('nama_biaya')->get();
        $selectedSiswaId = $request->query('id_calon_siswa');

        return view('pages.pembayaran.create', compact('daftarSiswa', 'daftarBiaya', 'selectedSiswaId'));
    }

    /**
     * Simpan transaksi pembayaran
     */
    public function store(StorePembayaranRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('bukti_transfer')) {
            $data['bukti_transfer'] = $request->file('bukti_transfer')->store('pembayaran', 'public');
        }

        if (($data['status_pembayaran'] ?? '') === 'lunas') {
            $data['verified_by'] = Auth::id();
            $data['verified_at'] = now();
        }

        Pembayaran::create($data);

        return redirect()->route('pembayaran.index')->with('success', 'Transaksi pembayaran berhasil dicatat!');
    }

    /**
     * Form edit pembayaran
     */
    public function edit(Pembayaran $pembayaran)
    {
        $daftarSiswa = CalonSiswa::orderBy('nama_lengkap')->get(['id_calon_siswa', 'nama_lengkap', 'no_pendaftaran']);
        $daftarBiaya = Biaya::where('is_active', true)->orderBy('nama_biaya')->get();

        return view('pages.pembayaran.edit', compact('pembayaran', 'daftarSiswa', 'daftarBiaya'));
    }

    /**
     * Perbarui data pembayaran
     */
    public function update(UpdatePembayaranRequest $request, Pembayaran $pembayaran)
    {
        $data = $request->validated();

        if ($request->hasFile('bukti_transfer')) {
            if ($pembayaran->bukti_transfer && Storage::disk('public')->exists($pembayaran->bukti_transfer)) {
                Storage::disk('public')->delete($pembayaran->bukti_transfer);
            }
            $data['bukti_transfer'] = $request->file('bukti_transfer')->store('pembayaran', 'public');
        }

        if ($data['status_pembayaran'] === 'lunas') {
            $data['verified_by'] = Auth::id();
            $data['verified_at'] = now();
        } else {
            $data['verified_by'] = null;
            $data['verified_at'] = null;
        }

        $pembayaran->update($data);

        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    /**
     * Ubah status pembayaran via AJAX modal
     */
    public function updateStatus(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:menunggu_konfirmasi,lunas,ditolak',
            'catatan'           => 'nullable|string|max:500',
        ]);

        $data = [
            'status_pembayaran' => $request->status_pembayaran,
            'catatan'           => $request->catatan,
        ];

        if ($request->status_pembayaran === 'lunas') {
            $data['verified_by'] = Auth::id();
            $data['verified_at'] = now();
        }

        $pembayaran->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pembayaran "' . $pembayaran->kode_transaksi . '" berhasil diperbarui!',
            ]);
        }

        return back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    /**
     * Cetak Kwitansi Pembayaran Resmi
     */
    public function kwitansi(Pembayaran $pembayaran)
    {
        $pembayaran->load(['calonSiswa.tahunAjaran', 'biaya', 'verifikator']);
        return view('pages.pembayaran.kwitansi', compact('pembayaran'));
    }

    /**
     * Hapus data pembayaran
     */
    public function destroy(Request $request, Pembayaran $pembayaran)
    {
        $kode = $pembayaran->kode_transaksi;

        if ($pembayaran->bukti_transfer && Storage::disk('public')->exists($pembayaran->bukti_transfer)) {
            Storage::disk('public')->delete($pembayaran->bukti_transfer);
        }

        $pembayaran->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data pembayaran "' . $kode . '" berhasil dihapus!',
            ]);
        }

        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran "' . $kode . '" berhasil dihapus!');
    }
}
