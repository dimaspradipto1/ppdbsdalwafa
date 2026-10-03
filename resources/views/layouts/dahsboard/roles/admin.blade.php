{{-- ========================================================================= --}}
{{-- DASHBOARD FULL VIEW: SUPER ADMIN & ADMIN PPDB                             --}}
{{-- ========================================================================= --}}

<!-- Welcome Banner -->
<div class="row mb-3">
  <div class="col-12">
    <div class="card bg-primary text-white shadow-sm border-0" style="background: linear-gradient(135deg, #1b3a6b 0%, #29559b 50%, #4154f1 100%);">
      <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
          <div>
            <div class="d-flex align-items-center gap-2 mb-1">
              <span class="badge bg-warning text-dark fw-bold px-2 py-1">
                <i class="bi bi-shield-check me-1"></i>{{ $role === 'super_admin' ? 'SUPER ADMIN' : 'ADMIN PPDB' }}
              </span>
              <span class="badge bg-white bg-opacity-25 text-white">Full Control View</span>
            </div>
            <h3 class="fw-bold mb-1 text-white">Selamat Datang, {{ $user->name }}!</h3>
            <p class="mb-0 text-white-50 small">
              Sistem Penerimaan Peserta Didik Baru (PPDB) {{ $sekolah->nama_sekolah ?? 'SD Islam Plus Al Wafa' }} &bull;
              Tahun Ajaran: <strong class="text-white">{{ $tahunAktif->tahun_ajaran ?? 'Aktif' }}</strong>
              @if($gelombangAktif)
                &bull; Gelombang Aktif: <strong class="text-warning">{{ $gelombangAktif->nama_gelombang }}</strong>
              @endif
            </p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('calon-siswa.create') }}" class="btn btn-warning fw-semibold btn-sm px-3 shadow-sm text-dark">
              <i class="bi bi-person-plus-fill me-1"></i> Tambah Siswa
            </a>
            <a href="{{ route('pembayaran.index') }}" class="btn btn-light btn-sm fw-semibold px-3 shadow-sm text-primary">
              <i class="bi bi-credit-card me-1"></i> Cek Pembayaran
            </a>
            <a href="{{ route('nilai-seleksi.index') }}" class="btn btn-outline-light btn-sm fw-semibold px-3 shadow-sm">
              <i class="bi bi-clipboard-check me-1"></i> Nilai Seleksi
            </a>
            @if($role === 'super_admin')
              <a href="{{ route('users.index') }}" class="btn btn-outline-warning btn-sm fw-semibold px-3 shadow-sm">
                <i class="bi bi-people me-1"></i> Kelola User
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 6 Metrik Utama (Semua Peran) -->
<div class="row">
  <!-- 1. Total Pendaftar -->
  <div class="col-xxl-2 col-md-4 col-sm-6 mb-3">
    <div class="card info-card sales-card shadow-sm h-100 border-start border-primary border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Total Pendaftar</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-subtle text-primary" style="width: 48px; height: 48px; font-size: 1.4rem;">
            <i class="bi bi-people-fill"></i>
          </div>
          <div class="ps-3">
            <h4 class="mb-0 fw-bold text-dark">{{ $totalPendaftar }}</h4>
            <a href="{{ route('calon-siswa.index') }}" class="text-primary small fw-semibold text-decoration-none" style="font-size: 0.75rem;">
              Lihat Siswa <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. Pemasukan Lunas -->
  <div class="col-xxl-2 col-md-4 col-sm-6 mb-3">
    <div class="card info-card revenue-card shadow-sm h-100 border-start border-success border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Total Pemasukan</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-subtle text-success" style="width: 48px; height: 48px; font-size: 1.4rem;">
            <i class="bi bi-cash-stack"></i>
          </div>
          <div class="ps-3">
            <h5 class="mb-0 fw-bold text-success" style="font-size: 1.05rem;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h5>
            <span class="text-muted small" style="font-size: 0.72rem;">{{ $totalBayarLunas }} Trx Lunas</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. Menunggu Verifikasi Berkas -->
  <div class="col-xxl-2 col-md-4 col-sm-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-warning border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Perlu Verifikasi</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning-subtle text-warning" style="width: 48px; height: 48px; font-size: 1.4rem;">
            <i class="bi bi-file-earmark-check"></i>
          </div>
          <div class="ps-3">
            <h4 class="mb-0 fw-bold text-dark">{{ $totalMenungguVerifikasi }}</h4>
            <span class="text-warning small fw-semibold" style="font-size: 0.72rem;">{{ $dokumenMenunggu }} Berkas Baru</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 4. Menunggu Konfirmasi Bayar -->
  <div class="col-xxl-2 col-md-4 col-sm-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-info border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Pending Bayar</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info-subtle text-info" style="width: 48px; height: 48px; font-size: 1.4rem;">
            <i class="bi bi-hourglass-split"></i>
          </div>
          <div class="ps-3">
            <h4 class="mb-0 fw-bold text-dark">{{ $totalBayarMenunggu }}</h4>
            <a href="{{ route('pembayaran.index') }}" class="text-info small fw-semibold text-decoration-none" style="font-size: 0.75rem;">
              Konfirmasi <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 5. Siswa Belum Dinilai -->
  <div class="col-xxl-2 col-md-4 col-sm-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-danger border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Belum Dinilai</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger-subtle text-danger" style="width: 48px; height: 48px; font-size: 1.4rem;">
            <i class="bi bi-pencil-square"></i>
          </div>
          <div class="ps-3">
            <h4 class="mb-0 fw-bold text-dark">{{ $siswaBelumDinilai }}</h4>
            <a href="{{ route('nilai-seleksi.index') }}" class="text-danger small fw-semibold text-decoration-none" style="font-size: 0.75rem;">
              Input Nilai <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 6. Siswa Diterima (Lulus) -->
  <div class="col-xxl-2 col-md-4 col-sm-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-primary border-4" style="border-color: #6f42c1 !important;">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Siswa Diterima</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; font-size: 1.4rem; background-color: #6f42c1;">
            <i class="bi bi-mortarboard-fill"></i>
          </div>
          <div class="ps-3">
            <h4 class="mb-0 fw-bold text-dark">{{ $totalDiterima }}</h4>
            <span class="text-muted small" style="font-size: 0.72rem;">{{ $totalDitolak }} Ditolak</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@if($role === 'super_admin' && isset($usersByRole))
  <!-- Khusus Super Admin: Widget Ringkasan Akun Pengguna -->
  <div class="row mb-3">
    <div class="col-12">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
          <h6 class="m-0 fw-bold text-dark"><i class="bi bi-people me-2 text-primary"></i>Statistik Pengguna Sistem (Khusus Super Admin)</h6>
          <a href="{{ route('users.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
            <i class="bi bi-gear me-1"></i> Manajemen User
          </a>
        </div>
        <div class="card-body py-3">
          <div class="row text-center g-2">
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded bg-light">
                <span class="text-muted small d-block">Super Admin</span>
                <span class="fw-bold fs-5 text-danger">{{ $usersByRole['super_admin'] ?? 0 }}</span>
              </div>
            </div>
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded bg-light">
                <span class="text-muted small d-block">Admin PPDB</span>
                <span class="fw-bold fs-5 text-primary">{{ ($usersByRole['admin_ppdb'] ?? 0) + ($usersByRole['admin'] ?? 0) }}</span>
              </div>
            </div>
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded bg-light">
                <span class="text-muted small d-block">Verifikator</span>
                <span class="fw-bold fs-5 text-warning">{{ $usersByRole['verifikator'] ?? 0 }}</span>
              </div>
            </div>
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded bg-light">
                <span class="text-muted small d-block">Bendahara</span>
                <span class="fw-bold fs-5 text-success">{{ $usersByRole['bendahara'] ?? 0 }}</span>
              </div>
            </div>
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded bg-light">
                <span class="text-muted small d-block">Guru / Penguji</span>
                <span class="fw-bold fs-5 text-info">{{ $usersByRole['guru'] ?? 0 }}</span>
              </div>
            </div>
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded bg-light">
                <span class="text-muted small d-block">Pendaftar</span>
                <span class="fw-bold fs-5 text-secondary">{{ ($usersByRole['pendaftar'] ?? 0) + ($usersByRole['user'] ?? 0) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

<!-- Row Modul 1: Verifikator & Bendahara Antrean -->
<div class="row">
  <!-- Kolom Verifikator: Antrean Calon Siswa Perlu Verifikasi -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm h-100 border-0">
      <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
        <div>
          <span class="badge bg-warning-subtle text-warning border border-warning-subtle me-1">Role Verifikator</span>
          <h6 class="m-0 fw-bold text-dark d-inline">Antrean Verifikasi Calon Siswa</h6>
        </div>
        <a href="{{ route('calon-siswa.index') }}" class="btn btn-sm btn-outline-warning">
          Lihat Semua ({{ $totalMenungguVerifikasi }})
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
            <thead class="table-light">
              <tr>
                <th class="ps-3">Calon Siswa</th>
                <th>Jalur / Gelombang</th>
                <th>Dokumen</th>
                <th class="text-end pe-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($antreanVerifikasiSiswa as $siswa)
                <tr>
                  <td class="ps-3">
                    <div class="fw-bold text-dark">{{ $siswa->nama_lengkap }}</div>
                    <div class="text-muted small font-monospace">{{ $siswa->no_pendaftaran }}</div>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark border">{{ $siswa->jalur->nama_jalur ?? '-' }}</span>
                    <div class="text-muted small">{{ $siswa->gelombang->nama_gelombang ?? '-' }}</div>
                  </td>
                  <td>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                      {{ $siswa->dokumen->count() }} Berkas
                    </span>
                  </td>
                  <td class="text-end pe-3">
                    <a href="{{ route('calon-siswa.show', $siswa->id_calon_siswa) }}" class="btn btn-sm btn-warning text-dark px-2 py-1" title="Verifikasi">
                      <i class="bi bi-search me-1"></i> Periksa
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center py-4 text-muted">
                    <i class="bi bi-check-circle text-success fs-3 d-block mb-1"></i>
                    Semua calon siswa telah selesai diverifikasi!
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Kolom Bendahara: Antrean Pembayaran Menunggu Konfirmasi -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm h-100 border-0">
      <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
        <div>
          <span class="badge bg-success-subtle text-success border border-success-subtle me-1">Role Bendahara</span>
          <h6 class="m-0 fw-bold text-dark d-inline">Antrean Konfirmasi Pembayaran</h6>
        </div>
        <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-outline-success">
          Lihat Semua ({{ $totalBayarMenunggu }})
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
            <thead class="table-light">
              <tr>
                <th class="ps-3">Transaksi / Siswa</th>
                <th>Jenis Biaya</th>
                <th>Nominal</th>
                <th class="text-end pe-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($antreanBayar as $bayar)
                <tr>
                  <td class="ps-3">
                    <span class="badge bg-light text-dark font-monospace border mb-1">{{ $bayar->kode_transaksi }}</span>
                    <div class="fw-semibold text-dark">{{ $bayar->calonSiswa->nama_lengkap ?? '-' }}</div>
                  </td>
                  <td>
                    <div class="small fw-medium">{{ $bayar->biaya->nama_biaya ?? 'Pembayaran PPDB' }}</div>
                    <div class="text-muted small">{{ $bayar->metode_pembayaran }}</div>
                  </td>
                  <td>
                    <span class="fw-bold text-success">Rp {{ number_format($bayar->nominal, 0, ',', '.') }}</span>
                  </td>
                  <td class="text-end pe-3">
                    <a href="{{ route('pembayaran.show', $bayar->id_pembayaran) }}" class="btn btn-sm btn-success px-2 py-1" title="Konfirmasi">
                      <i class="bi bi-check2-circle me-1"></i> Proses
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center py-4 text-muted">
                    <i class="bi bi-check-circle text-success fs-3 d-block mb-1"></i>
                    Tidak ada pembayaran tertunda yang butuh konfirmasi.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Row Modul 2: Guru (Penilaian Ujian) & Analitik Kepala Sekolah -->
<div class="row">
  <!-- Kolom Guru: Calon Siswa Perlu Diuji / Dinilai -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm h-100 border-0">
      <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
        <div>
          <span class="badge bg-primary-subtle text-primary border border-primary-subtle me-1">Role Guru / Penguji</span>
          <h6 class="m-0 fw-bold text-dark d-inline">Siswa Siap Ujian & Penilaian</h6>
        </div>
        <a href="{{ route('nilai-seleksi.index') }}" class="btn btn-sm btn-outline-primary">
          Buka Penilaian ({{ $siswaBelumDinilai }})
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
            <thead class="table-light">
              <tr>
                <th class="ps-3">Calon Siswa</th>
                <th>Gelombang / Jalur</th>
                <th>Status Nilai</th>
                <th class="text-end pe-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($antreanNilaiSiswa as $siswa)
                <tr>
                  <td class="ps-3">
                    <div class="fw-bold text-dark">{{ $siswa->nama_lengkap }}</div>
                    <div class="text-muted small font-monospace">{{ $siswa->no_pendaftaran }}</div>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark border">{{ $siswa->gelombang->nama_gelombang ?? '-' }}</span>
                    <div class="text-muted small">{{ $siswa->jalur->nama_jalur ?? '-' }}</div>
                  </td>
                  <td>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                      <i class="bi bi-exclamation-circle me-1"></i>Belum Dinilai
                    </span>
                  </td>
                  <td class="text-end pe-3">
                    <a href="{{ route('nilai-seleksi.edit', $siswa->id_calon_siswa) }}" class="btn btn-sm btn-primary px-2 py-1">
                      <i class="bi bi-pencil me-1"></i> Input Nilai
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center py-4 text-muted">
                    <i class="bi bi-check2-all text-primary fs-3 d-block mb-1"></i>
                    Semua siswa terverifikasi telah memiliki nilai seleksi!
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Kolom Kepala Sekolah: Komposisi Gender & Kuota Keterisian -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm h-100 border-0">
      <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
        <div>
          <span class="badge bg-dark-subtle text-dark border me-1">Role Kepala Sekolah</span>
          <h6 class="m-0 fw-bold text-dark d-inline">Daya Tampung & Komposisi Pendaftar</h6>
        </div>
        <span class="badge bg-info-subtle text-info border border-info-subtle">Ringkasan Kuota</span>
      </div>
      <div class="card-body p-3">
        <!-- Keterisian Kuota Jalur -->
        <h6 class="fw-bold small text-muted text-uppercase mb-2">Keterisian Kuota per Jalur</h6>
        @forelse($jalurList as $j)
          @php
            $kuotaJalur = $j->kuota > 0 ? $j->kuota : 1;
            $persenJalur = min(100, round(($j->calon_siswa_count / $kuotaJalur) * 100));
          @endphp
          <div class="mb-3">
            <div class="d-flex justify-content-between small mb-1">
              <span class="fw-semibold text-dark">{{ $j->nama_jalur }}</span>
              <span class="text-muted">{{ $j->calon_siswa_count }} / {{ $j->kuota }} Siswa ({{ $persenJalur }}%)</span>
            </div>
            <div class="progress" style="height: 7px;">
              <div class="progress-bar {{ $persenJalur >= 90 ? 'bg-danger' : ($persenJalur >= 60 ? 'bg-warning' : 'bg-primary') }}" role="progressbar" style="width: {{ $persenJalur }}%"></div>
            </div>
          </div>
        @empty
          <div class="text-muted small fst-italic mb-3">Belum ada data jalur pendaftaran aktif.</div>
        @endforelse

        <hr class="my-3">

        <!-- Komposisi Gender -->
        <h6 class="fw-bold small text-muted text-uppercase mb-2">Komposisi Jenis Kelamin</h6>
        <div class="row g-2 text-center">
          <div class="col-6">
            <div class="p-2 border rounded bg-primary-subtle border-primary-subtle">
              <i class="bi bi-gender-male text-primary fs-4"></i>
              <div class="fw-bold fs-5 text-primary">{{ $genderL }}</div>
              <div class="small text-muted">Laki-laki</div>
            </div>
          </div>
          <div class="col-6">
            <div class="p-2 border rounded bg-danger-subtle border-danger-subtle">
              <i class="bi bi-gender-female text-danger fs-4"></i>
              <div class="fw-bold fs-5 text-danger">{{ $genderP }}</div>
              <div class="small text-muted">Perempuan</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Row Modul 3: Grafik Tren Pendaftaran & Rekap Terkini -->
<div class="row">
  <!-- Grafik Tren Pendaftaran -->
  <div class="col-lg-8 mb-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-graph-up text-primary me-2"></i>Tren Pendaftaran Siswa (6 Bulan Terakhir)</h6>
        <span class="badge bg-light text-muted border">Real-time DB</span>
      </div>
      <div class="card-body">
        <div id="chartTrenPendaftar" style="min-height: 280px;"></div>
      </div>
    </div>
  </div>

  <!-- Pendaftar Siswa Terbaru -->
  <div class="col-lg-4 mb-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-clock-history text-primary me-2"></i>Pendaftar Terbaru</h6>
        <a href="{{ route('calon-siswa.index') }}" class="btn btn-sm btn-link p-0 text-decoration-none">Semua</a>
      </div>
      <div class="card-body p-0">
        <ul class="list-group list-group-flush">
          @forelse($pendaftarTerbaru as $siswa)
            <li class="list-group-item px-3 py-2 d-flex align-items-center justify-content-between">
              <div>
                <a href="{{ route('calon-siswa.show', $siswa->id_calon_siswa) }}" class="fw-bold text-dark text-decoration-none d-block">
                  {{ $siswa->nama_lengkap }}
                </a>
                <span class="text-muted small font-monospace">{{ $siswa->no_pendaftaran }} &bull; {{ $siswa->gelombang->nama_gelombang ?? '-' }}</span>
              </div>
              <span class="badge {{ $siswa->status === 'diterima' ? 'bg-success' : ($siswa->status === 'menunggu_verifikasi' ? 'bg-warning text-dark' : ($siswa->status === 'diverifikasi' ? 'bg-info' : 'bg-secondary')) }}">
                {{ ucfirst(str_replace('_', ' ', $siswa->status)) }}
              </span>
            </li>
          @empty
            <li class="list-group-item text-center py-4 text-muted">Belum ada data pendaftar.</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const bulan = @json($chartBulan ?? []);
    const pendaftar = @json($chartPendaftar ?? []);

    new ApexCharts(document.querySelector("#chartTrenPendaftar"), {
      series: [{
        name: 'Pendaftar Baru',
        data: pendaftar
      }],
      chart: {
        height: 280,
        type: 'area',
        toolbar: { show: false }
      },
      markers: { size: 4 },
      colors: ['#4154f1'],
      fill: {
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.4,
          opacityTo: 0.05,
          stops: [0, 90, 100]
        }
      },
      dataLabels: { enabled: false },
      stroke: { curve: 'smooth', width: 2 },
      xaxis: {
        categories: bulan
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " Siswa";
          }
        }
      }
    }).render();
  });
</script>
@endpush
