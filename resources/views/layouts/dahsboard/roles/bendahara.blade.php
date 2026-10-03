{{-- ========================================================================= --}}
{{-- DASHBOARD KHUSUS ROLE: BENDAHARA / KEUANGAN                               --}}
{{-- ========================================================================= --}}

<!-- Welcome Banner -->
<div class="row mb-3">
  <div class="col-12">
    <div class="card bg-success bg-gradient text-white shadow-sm border-0" style="background: linear-gradient(135deg, #0f5132 0%, #198754 50%, #20c997 100%);">
      <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
          <div>
            <div class="d-flex align-items-center gap-2 mb-1">
              <span class="badge bg-warning text-dark fw-bold px-2 py-1">
                <i class="bi bi-wallet2 me-1"></i>BENDAHARA PPDB
              </span>
              <span class="badge bg-white bg-opacity-25 text-white">Manajemen Keuangan</span>
            </div>
            <h3 class="fw-bold mb-1 text-white">Selamat Datang, {{ $user->name }}!</h3>
            <p class="mb-0 text-white-50 small">
              Rekapitulasi Keuangan & Pembayaran Masuk PPDB {{ $sekolah->nama_sekolah ?? 'SD Islam Plus Al Wafa' }}.
              Tahun Ajaran: <strong class="text-white">{{ $tahunAktif->tahun_ajaran ?? 'Aktif' }}</strong>
            </p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('pembayaran.index') }}" class="btn btn-warning btn-sm fw-semibold px-3 shadow-sm text-dark">
              <i class="bi bi-cash-coin me-1"></i> Kelola Pembayaran
            </a>
            <a href="{{ route('biaya.index') }}" class="btn btn-outline-light btn-sm fw-semibold px-3 shadow-sm">
              <i class="bi bi-tag me-1"></i> Pengaturan Tarif Biaya
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 4 Metrik Keuangan Utama -->
<div class="row">
  <!-- 1. Total Pemasukan Lunas -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-success border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Total Pemasukan (Lunas)</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-subtle text-success" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-cash-stack"></i>
          </div>
          <div class="ps-3">
            <h4 class="mb-0 fw-bold text-success" style="font-size: 1.25rem;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
            <span class="text-muted small">{{ $bayarLunas }} Transaksi Terverifikasi</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. Menunggu Konfirmasi -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-warning border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Menunggu Konfirmasi</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning-subtle text-warning" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-hourglass-split"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $bayarMenunggu }}</h3>
            <span class="text-warning small fw-semibold">Perlu Konfirmasi Segera</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. Pembayaran Ditolak -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-danger border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Pembayaran Ditolak</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger-subtle text-danger" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-x-circle"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $bayarDitolak }}</h3>
            <span class="text-danger small fw-semibold">Tidak Sesuai / Invalid</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 4. Total Transaksi -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-primary border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Total Keseluruhan Transaksi</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-subtle text-primary" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-receipt"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $totalTransaksi }}</h3>
            <span class="text-muted small">Semua Riwayat Bayar</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Antrean Utama: Pembayaran Menunggu Konfirmasi -->
<div class="row">
  <div class="col-lg-8 mb-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
        <div>
          <h6 class="m-0 fw-bold text-dark"><i class="bi bi-clock-history text-warning me-2"></i>Antrean Transaksi Menunggu Konfirmasi</h6>
          <span class="text-muted small">Periksa bukti transfer dan validasi pembayaran calon siswa</span>
        </div>
        <span class="badge bg-warning text-dark">{{ $antreanPembayaran->count() }} Pending</span>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
            <thead class="table-light">
              <tr>
                <th class="ps-3">Kode / Siswa</th>
                <th>Jenis Tagihan</th>
                <th>Metode & Pengirim</th>
                <th>Nominal</th>
                <th class="text-end pe-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($antreanPembayaran as $bayar)
                <tr>
                  <td class="ps-3">
                    <span class="badge bg-light text-dark font-monospace border mb-1">{{ $bayar->kode_transaksi }}</span>
                    <div class="fw-bold text-dark">{{ $bayar->calonSiswa->nama_lengkap ?? '-' }}</div>
                    <div class="text-muted small font-monospace">{{ $bayar->calonSiswa->no_pendaftaran ?? '-' }}</div>
                  </td>
                  <td>
                    <div class="fw-medium text-dark">{{ $bayar->biaya->nama_biaya ?? 'Biaya PPDB' }}</div>
                    <div class="text-muted small">{{ $bayar->tanggal_bayar ? $bayar->tanggal_bayar->format('d/m/Y H:i') : '-' }}</div>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark border">{{ $bayar->metode_pembayaran }}</span>
                    @if($bayar->nama_bank_pengirim)
                      <div class="text-muted small">{{ $bayar->nama_bank_pengirim }} &bull; {{ $bayar->atas_nama_pengirim }}</div>
                    @endif
                  </td>
                  <td>
                    <span class="fw-bold text-success fs-6">Rp {{ number_format($bayar->nominal, 0, ',', '.') }}</span>
                  </td>
                  <td class="text-end pe-3">
                    <a href="{{ route('pembayaran.show', $bayar->id_pembayaran) }}" class="btn btn-sm btn-success px-3 fw-semibold shadow-sm">
                      <i class="bi bi-check2-circle me-1"></i> Proses
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-5 text-muted">
                    <i class="bi bi-check-circle text-success fs-2 d-block mb-2"></i>
                    Alhamdulillah! Tidak ada transaksi pembayaran yang menunggu konfirmasi saat ini.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Kolom Kanan: Rincian Penerimaan per Kategori Tarif Biaya -->
  <div class="col-lg-4 mb-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-pie-chart text-success me-2"></i>Pemasukan per Tarif Biaya</h6>
        <a href="{{ route('biaya.index') }}" class="btn btn-sm btn-link p-0 text-decoration-none">Kelola</a>
      </div>
      <div class="card-body p-3">
        @forelse($biayaList as $b)
          <div class="mb-3">
            <div class="d-flex justify-content-between small mb-1">
              <span class="fw-semibold text-dark">{{ $b->nama_biaya }}</span>
              <span class="fw-bold text-success">Rp {{ number_format($b->total_terkumpul ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between text-muted" style="font-size: 0.75rem;">
              <span>Tarif: Rp {{ number_format($b->nominal, 0, ',', '.') }}</span>
              <span>{{ $b->is_wajib ? 'Wajib' : 'Opsional' }}</span>
            </div>
            <div class="progress mt-1" style="height: 5px;">
              <div class="progress-bar bg-success" style="width: {{ $totalPemasukan > 0 ? min(100, round((($b->total_terkumpul ?? 0) / $totalPemasukan) * 100)) : 0 }}%"></div>
            </div>
          </div>
        @empty
          <div class="text-muted small fst-italic text-center py-4">Belum ada pengaturan tarif biaya aktif.</div>
        @endforelse
      </div>
    </div>
  </div>
</div>

<!-- Riwayat Pembayaran Terkonfirmasi Terakhir -->
<div class="row">
  <div class="col-12 mb-4">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-shield-check text-success me-2"></i>Transaksi Pembayaran Lunas Terbaru</h6>
        <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-outline-success">Lihat Semua Riwayat</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
            <thead class="table-light">
              <tr>
                <th class="ps-3">Kode Transaksi</th>
                <th>Calon Siswa</th>
                <th>Jenis Biaya</th>
                <th>Nominal</th>
                <th>Waktu Konfirmasi</th>
                <th class="text-end pe-3">Kwitansi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pembayaranTerbaru as $pb)
                <tr>
                  <td class="ps-3 font-monospace fw-semibold text-primary">{{ $pb->kode_transaksi }}</td>
                  <td>
                    <div class="fw-bold text-dark">{{ $pb->calonSiswa->nama_lengkap ?? '-' }}</div>
                    <div class="text-muted small font-monospace">{{ $pb->calonSiswa->no_pendaftaran ?? '-' }}</div>
                  </td>
                  <td>{{ $pb->biaya->nama_biaya ?? '-' }}</td>
                  <td><span class="fw-bold text-success">Rp {{ number_format($pb->nominal, 0, ',', '.') }}</span></td>
                  <td>
                    <div class="small text-muted">{{ $pb->verified_at ? $pb->verified_at->format('d/m/Y H:i') : '-' }}</div>
                  </td>
                  <td class="text-end pe-3">
                    <a href="{{ route('pembayaran.kwitansi', $pb->id_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-primary px-2 py-1">
                      <i class="bi bi-printer me-1"></i> Cetak Kwitansi
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted small">Belum ada riwayat pembayaran yang lunas.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
