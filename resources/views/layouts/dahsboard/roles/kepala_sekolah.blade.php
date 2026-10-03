{{-- ========================================================================= --}}
{{-- DASHBOARD KHUSUS ROLE: KEPALA SEKOLAH (EXECUTIVE MONITORING)              --}}
{{-- ========================================================================= --}}

<!-- Welcome Banner -->
<div class="row mb-3">
  <div class="col-12">
    <div class="card text-white shadow-sm border-0" style="background: linear-gradient(135deg, #2b1055 0%, #4b1f85 50%, #7597de 100%);">
      <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
          <div>
            <div class="d-flex align-items-center gap-2 mb-1">
              <span class="badge bg-warning text-dark fw-bold px-2 py-1">
                <i class="bi bi-person-workspace me-1"></i>KEPALA SEKOLAH
              </span>
              <span class="badge bg-white bg-opacity-25 text-white">Monitoring Eksekutif & Kelulusan</span>
            </div>
            <h3 class="fw-bold mb-1 text-white">Selamat Datang, Bapak/Ibu {{ $user->name }}!</h3>
            <p class="mb-0 text-white-50 small">
              Laporan Eksekutif Perkembangan Penerimaan Peserta Didik Baru {{ $sekolah->nama_sekolah ?? 'SD Islam Plus Al Wafa' }} &bull;
              Tahun Ajaran: <strong class="text-white">{{ $tahunAktif->tahun_ajaran ?? 'Aktif' }}</strong>
            </p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('calon-siswa.index') }}" class="btn btn-warning btn-sm fw-semibold px-3 shadow-sm text-dark">
              <i class="bi bi-people-fill me-1"></i> Data Calon Siswa
            </a>
            <a href="{{ route('nilai-seleksi.index') }}" class="btn btn-outline-light btn-sm fw-semibold px-3 shadow-sm">
              <i class="bi bi-award-fill me-1"></i> Hasil Penilaian Seleksi
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 4 Metrik Eksekutif Utama -->
<div class="row">
  <!-- 1. Total Pendaftar -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-primary border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Total Calon Siswa Terdaftar</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-subtle text-primary" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-people"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $totalPendaftar }}</h3>
            <span class="text-primary small fw-semibold">Pendaftar Masuk</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. Siswa Diterima -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-success border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Siswa Diterima (Lolos)</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-subtle text-success" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-mortarboard-fill"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-success">{{ $totalDiterima }}</h3>
            <span class="text-success small fw-semibold">Memenuhi Kriteria</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. Dalam Proses Seleksi -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-warning border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Sedang Proses Seleksi</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning-subtle text-warning" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-clock-history"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $totalProses }}</h3>
            <span class="text-warning small fw-semibold">Verifikasi / Penilaian</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 4. Tidak Lolos / Ditolak -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-danger border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Siswa Belum Diterima</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger-subtle text-danger" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-person-x"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $totalDitolak }}</h3>
            <span class="text-danger small fw-semibold">Tidak Memenuhi Syarat</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Baris Visualisasi Grafik & Analytics -->
<div class="row">
  <!-- Grafik Tren Pendaftaran -->
  <div class="col-lg-8 mb-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-graph-up-arrow text-primary me-2"></i>Tren Pendaftaran Siswa 6 Bulan Terakhir</h6>
        <span class="badge bg-light text-muted border">Laporan Bulanan</span>
      </div>
      <div class="card-body">
        <div id="chartTrenKepsek" style="min-height: 280px;"></div>
      </div>
    </div>
  </div>

  <!-- Donut Chart Gender & Daya Tampung Jalur -->
  <div class="col-lg-4 mb-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header bg-white py-3 border-bottom">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-pie-chart text-primary me-2"></i>Komposisi Gender Siswa</h6>
      </div>
      <div class="card-body d-flex flex-column align-items-center justify-content-center">
        <div id="chartGenderKepsek" style="width: 100%; min-height: 230px;"></div>
        <div class="d-flex justify-content-around w-100 mt-2 text-center">
          <div>
            <span class="text-muted small d-block">Laki-laki</span>
            <span class="fw-bold fs-6 text-primary">{{ $genderL }} Siswa</span>
          </div>
          <div>
            <span class="text-muted small d-block">Perempuan</span>
            <span class="fw-bold fs-6 text-danger">{{ $genderP }} Siswa</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Keterisian Kuota Gelombang & Nilai Komponen Seleksi -->
<div class="row">
  <!-- Daya Tampung & Keterisian Kuota -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header bg-white py-3 border-bottom">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-bar-chart-steps text-info me-2"></i>Keterisian Daya Tampung per Gelombang</h6>
      </div>
      <div class="card-body p-3">
        @forelse($gelombangList as $g)
          @php
            $kuotaG = $g->kuota > 0 ? $g->kuota : 1;
            $persenG = min(100, round(($g->calon_siswa_count / $kuotaG) * 100));
          @endphp
          <div class="mb-3">
            <div class="d-flex justify-content-between small mb-1">
              <span class="fw-semibold text-dark">{{ $g->nama_gelombang }}</span>
              <span class="text-muted">{{ $g->calon_siswa_count }} / {{ $g->kuota }} Siswa ({{ $persenG }}%)</span>
            </div>
            <div class="progress" style="height: 8px;">
              <div class="progress-bar {{ $persenG >= 90 ? 'bg-danger' : ($persenG >= 60 ? 'bg-warning' : 'bg-primary') }}" role="progressbar" style="width: {{ $persenG }}%"></div>
            </div>
          </div>
        @empty
          <div class="text-muted small text-center py-4">Belum ada data gelombang pendaftaran.</div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Rata-rata Nilai Komponen Seleksi -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header bg-white py-3 border-bottom">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-card-checklist text-success me-2"></i>Rata-rata Nilai Ujian Seleksi Masuk</h6>
      </div>
      <div class="card-body p-3">
        @forelse($komponenNilai as $kn)
          <div class="mb-3">
            <div class="d-flex justify-content-between small mb-1">
              <span class="fw-semibold text-dark">{{ $kn->nama_komponen }}</span>
              <span class="fw-bold text-dark">Rata-rata: {{ number_format($kn->rata_nilai ?? 0, 1) }} / Min: {{ $kn->nilai_minimal }}</span>
            </div>
            <div class="progress" style="height: 8px;">
              @php
                $pct = min(100, ($kn->rata_nilai ?? 0));
              @endphp
              <div class="progress-bar {{ ($kn->rata_nilai ?? 0) >= $kn->nilai_minimal ? 'bg-success' : 'bg-danger' }}" role="progressbar" style="width: {{ $pct }}%"></div>
            </div>
          </div>
        @empty
          <div class="text-muted small text-center py-4">Belum ada data nilai komponen seleksi.</div>
        @endforelse
      </div>
    </div>
  </div>
</div>

<!-- Daftar Calon Siswa Diterima Terbaru -->
<div class="row">
  <div class="col-12 mb-4">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-mortarboard text-success me-2"></i>Calon Siswa yang Telah Diterima (Lulus Seleksi)</h6>
        <a href="{{ route('calon-siswa.index') }}" class="btn btn-sm btn-outline-primary">Lihat Seluruh Siswa</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
            <thead class="table-light">
              <tr>
                <th class="ps-3">No. Pendaftaran</th>
                <th>Nama Lengkap</th>
                <th>Gelombang</th>
                <th>Jalur Masuk</th>
                <th class="text-end pe-3">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($siswaDiterimaTerbaru as $siswa)
                <tr>
                  <td class="ps-3 font-monospace fw-bold text-primary">{{ $siswa->no_pendaftaran }}</td>
                  <td class="fw-semibold text-dark">{{ $siswa->nama_lengkap }}</td>
                  <td>{{ $siswa->gelombang->nama_gelombang ?? '-' }}</td>
                  <td><span class="badge bg-light text-dark border">{{ $siswa->jalur->nama_jalur ?? '-' }}</span></td>
                  <td class="text-end pe-3">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                      <i class="bi bi-check-circle me-1"></i>Diterima
                    </span>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted small">Belum ada calon siswa dengan status diterima.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", () => {
    // 1. Chart Tren Bulanan
    const bulan = @json($chartBulan ?? []);
    const pendaftar = @json($chartPendaftar ?? []);

    new ApexCharts(document.querySelector("#chartTrenKepsek"), {
      series: [{
        name: 'Pendaftar',
        data: pendaftar
      }],
      chart: {
        height: 280,
        type: 'area',
        toolbar: { show: false }
      },
      markers: { size: 4 },
      colors: ['#4b1f85'],
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
      xaxis: { categories: bulan }
    }).render();

    // 2. Chart Gender Donut
    const gL = {{ $genderL ?? 0 }};
    const gP = {{ $genderP ?? 0 }};

    new ApexCharts(document.querySelector("#chartGenderKepsek"), {
      series: [gL, gP],
      chart: {
        type: 'donut',
        height: 230
      },
      labels: ['Laki-laki', 'Perempuan'],
      colors: ['#4154f1', '#e83e8c'],
      legend: { position: 'bottom' },
      dataLabels: { enabled: true }
    }).render();
  });
</script>
@endpush
