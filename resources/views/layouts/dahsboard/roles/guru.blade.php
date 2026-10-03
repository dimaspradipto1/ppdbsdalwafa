{{-- ========================================================================= --}}
{{-- DASHBOARD KHUSUS ROLE: GURU / PENGUJI UJIAN SELEKSI                       --}}
{{-- ========================================================================= --}}

<!-- Welcome Banner -->
<div class="row mb-3">
  <div class="col-12">
    <div class="card text-white shadow-sm border-0" style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);">
      <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
          <div>
            <div class="d-flex align-items-center gap-2 mb-1">
              <span class="badge bg-warning text-dark fw-bold px-2 py-1">
                <i class="bi bi-pencil-fill me-1"></i>GURU / PENGUJI SELEKSI
              </span>
              <span class="badge bg-white bg-opacity-25 text-white">Penilaian Ujian PPDB</span>
            </div>
            <h3 class="fw-bold mb-1 text-white">Selamat Bertugas, Bapak/Ibu {{ $user->name }}!</h3>
            <p class="mb-0 text-white-50 small">
              Input dan kelola hasil ujian observasi & seleksi calon siswa {{ $sekolah->nama_sekolah ?? 'SD Islam Plus Al Wafa' }}.
              Tahun Ajaran: <strong class="text-white">{{ $tahunAktif->tahun_ajaran ?? 'Aktif' }}</strong>
            </p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('nilai-seleksi.index') }}" class="btn btn-warning btn-sm fw-semibold px-3 shadow-sm text-dark">
              <i class="bi bi-journal-check me-1"></i> Rekapitulasi Nilai Seleksi
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 4 Metrik Penilaian Guru -->
<div class="row">
  <!-- 1. Calon Siswa Siap Ujian -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-primary border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Siswa Terdaftar Ujian</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-subtle text-primary" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-people"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $siswaSiapSeleksi }}</h3>
            <span class="text-primary small fw-semibold">Telah Terverifikasi</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. Belum Dinilai -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-danger border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Belum Dinilai (Menunggu)</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger-subtle text-danger" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-exclamation-triangle"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $siswaBelumDinilai }}</h3>
            <span class="text-danger small fw-semibold">Prioritas Ujian</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. Sudah Selesai Dinilai -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-success border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Selesai Dinilai</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-subtle text-success" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-check2-all"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $siswaSudahDinilai }}</h3>
            <span class="text-success small fw-semibold">Nilai Terinput</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 4. Komponen Seleksi Aktif -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-info border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Komponen Tes Seleksi</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info-subtle text-info" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-card-checklist"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $komponenList->count() }}</h3>
            <span class="text-info small fw-semibold">Materi Uji Aktif</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Antrean Utama: Calon Siswa Siap Ujian & Penilaian -->
<div class="row">
  <div class="col-lg-8 mb-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
        <div>
          <h6 class="m-0 fw-bold text-dark"><i class="bi bi-clipboard-pulse text-primary me-2"></i>Daftar Siswa Siap Dinilai</h6>
          <span class="text-muted small">Pilih calon siswa untuk melakukan penilaian ujian observasi/masuk</span>
        </div>
        <a href="{{ route('nilai-seleksi.index') }}" class="btn btn-sm btn-outline-primary">Buka Halaman Penilaian</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
            <thead class="table-light">
              <tr>
                <th class="ps-3">No. Reg / Siswa</th>
                <th>Gelombang / Asal Sekolah</th>
                <th>Status Nilai</th>
                <th class="text-end pe-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($antreanNilaiSiswa as $siswa)
                @php
                  $sudahPunyaNilai = $siswa->nilaiSeleksi->count() > 0;
                @endphp
                <tr>
                  <td class="ps-3">
                    <span class="badge bg-light text-dark font-monospace border mb-1">{{ $siswa->no_pendaftaran }}</span>
                    <div class="fw-bold text-dark">{{ $siswa->nama_lengkap }}</div>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark border">{{ $siswa->gelombang->nama_gelombang ?? '-' }}</span>
                    <div class="text-muted small">{{ $siswa->asal_sekolah ?: 'Tidak disebutkan' }}</div>
                  </td>
                  <td>
                    @if($sudahPunyaNilai)
                      <span class="badge bg-success-subtle text-success border border-success-subtle">
                        <i class="bi bi-check-circle me-1"></i>Sudah Dinilai ({{ $siswa->nilaiSeleksi->count() }} Komponen)
                      </span>
                    @else
                      <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                        <i class="bi bi-clock me-1"></i>Belum Dinilai
                      </span>
                    @endif
                  </td>
                  <td class="text-end pe-3">
                    <a href="{{ route('nilai-seleksi.edit', $siswa->id_calon_siswa) }}" class="btn btn-sm {{ $sudahPunyaNilai ? 'btn-outline-primary' : 'btn-primary' }} px-3 fw-semibold shadow-sm">
                      <i class="bi bi-pencil-square me-1"></i> {{ $sudahPunyaNilai ? 'Edit Nilai' : 'Input Nilai' }}
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center py-5 text-muted">
                    <i class="bi bi-check-circle text-success fs-2 d-block mb-2"></i>
                    Belum ada calon siswa yang diverifikasi dan siap dinilai.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Kolom Kanan: Rincian Komponen Ujian & Riwayat Input Terakhir -->
  <div class="col-lg-4 mb-4">
    <!-- Komponen Ujian Seleksi -->
    <div class="card shadow-sm border-0 mb-4">
      <div class="card-header bg-white py-3 border-bottom">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-bookmark-check text-info me-2"></i>Komponen Ujian Aktif</h6>
      </div>
      <div class="card-body p-3">
        @forelse($komponenList as $k)
          <div class="p-2 border rounded bg-light mb-2">
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-bold text-dark small">{{ $k->nama_komponen }}</span>
              <span class="badge bg-primary">{{ $k->bobot_persen }}%</span>
            </div>
            <div class="text-muted small mt-1" style="font-size: 0.75rem;">
              KKM / Nilai Min: <strong>{{ $k->nilai_minimal }}</strong> &bull; Kode: <code>{{ $k->kode }}</code>
            </div>
          </div>
        @empty
          <div class="text-muted small text-center py-3">Belum ada komponen seleksi aktif.</div>
        @endforelse
      </div>
    </div>

    <!-- Riwayat Input Nilai Terbaru -->
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white py-3 border-bottom">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-clock-history text-secondary me-2"></i>Nilai Baru Saja Diinput</h6>
      </div>
      <div class="card-body p-0">
        <ul class="list-group list-group-flush">
          @forelse($nilaiTerbaru as $nl)
            <li class="list-group-item px-3 py-2 d-flex align-items-center justify-content-between">
              <div>
                <div class="fw-semibold text-dark small">{{ $nl->calonSiswa->nama_lengkap ?? '-' }}</div>
                <div class="text-muted small" style="font-size: 0.72rem;">{{ $nl->komponenSeleksi->nama_komponen ?? '-' }}</div>
              </div>
              <span class="badge bg-primary fs-6">{{ number_format($nl->nilai, 0) }}</span>
            </li>
          @empty
            <li class="list-group-item text-center py-3 text-muted small">Belum ada nilai yang diinput.</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>
