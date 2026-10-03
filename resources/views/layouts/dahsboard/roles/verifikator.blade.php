{{-- ========================================================================= --}}
{{-- DASHBOARD KHUSUS ROLE: PANITIA VERIFIKASI (VERIFIKATOR)                   --}}
{{-- ========================================================================= --}}

<!-- Welcome Banner -->
<div class="row mb-3">
  <div class="col-12">
    <div class="card bg-warning bg-gradient text-dark shadow-sm border-0" style="background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 50%, #ffda6a 100%); border-left: 6px solid #ffc107 !important;">
      <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
          <div>
            <div class="d-flex align-items-center gap-2 mb-1">
              <span class="badge bg-dark text-warning fw-bold px-2 py-1">
                <i class="bi bi-patch-check-fill me-1"></i>PANITIA VERIFIKASI
              </span>
              <span class="badge bg-secondary text-white">Verifikasi Data & Dokumen</span>
            </div>
            <h3 class="fw-bold mb-1 text-dark">Selamat Bertugas, {{ $user->name }}!</h3>
            <p class="mb-0 text-muted small">
              Fokus Verifikasi Berkas Persyaratan & Validasi Biodata Calon Siswa {{ $sekolah->nama_sekolah ?? 'SD Al Wafa' }}.
              Tahun Ajaran: <strong>{{ $tahunAktif->tahun_ajaran ?? 'Aktif' }}</strong>
            </p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('calon-siswa.index') }}" class="btn btn-dark btn-sm fw-semibold px-3 shadow-sm text-warning">
              <i class="bi bi-person-lines-fill me-1"></i> Data Calon Siswa
            </a>
            <a href="{{ route('dokumen.index') }}" class="btn btn-outline-dark btn-sm fw-semibold px-3 shadow-sm">
              <i class="bi bi-folder-check me-1"></i> Semua Dokumen
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 4 Metrik Fokus Verifikasi -->
<div class="row">
  <!-- 1. Calon Siswa Menunggu Verifikasi -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-warning border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Siswa Menunggu Verifikasi</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning-subtle text-warning" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-person-exclamation"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $menungguVerifikasi }}</h3>
            <span class="text-warning small fw-semibold">Prioritas Tindakan</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. Dokumen Menunggu Validasi -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-info border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Dokumen Belum Diperiksa</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info-subtle text-info" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-file-earmark-text"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $dokumenMenunggu }}</h3>
            <span class="text-info small fw-semibold">Berkas Masuk</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. Calon Siswa Telah Diverifikasi -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-success border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Siswa Telah Diverifikasi</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-subtle text-success" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-check2-circle"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $sudahDiverifikasi }}</h3>
            <span class="text-success small fw-semibold">{{ $dokumenValid }} Dokumen Valid</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 4. Berkas / Calon Siswa Ditolak -->
  <div class="col-xxl-3 col-md-6 mb-3">
    <div class="card info-card shadow-sm h-100 border-start border-danger border-4">
      <div class="card-body p-3">
        <h5 class="card-title text-muted p-0 mb-1" style="font-size: 0.85rem;">Berkas / Siswa Ditolak</h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger-subtle text-danger" style="width: 50px; height: 50px; font-size: 1.5rem;">
            <i class="bi bi-x-circle"></i>
          </div>
          <div class="ps-3">
            <h3 class="mb-0 fw-bold text-dark">{{ $ditolak }}</h3>
            <span class="text-danger small fw-semibold">{{ $dokumenDitolak }} Dokumen Ditolak</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Antrean Utama: Calon Siswa Menunggu Verifikasi -->
<div class="row">
  <div class="col-lg-8 mb-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
        <div>
          <h6 class="m-0 fw-bold text-dark"><i class="bi bi-list-task text-warning me-2"></i>Daftar Calon Siswa Menunggu Verifikasi</h6>
          <span class="text-muted small">Segera periksa kelengkapan data biodata dan dokumen calon siswa</span>
        </div>
        <span class="badge bg-warning text-dark">{{ $antreanVerifikasiSiswa->count() }} Menunggu</span>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
            <thead class="table-light">
              <tr>
                <th class="ps-3">No. Reg / Siswa</th>
                <th>Gelombang / Jalur</th>
                <th>Kelengkapan Dokumen</th>
                <th>Tgl Daftar</th>
                <th class="text-end pe-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($antreanVerifikasiSiswa as $siswa)
                <tr>
                  <td class="ps-3">
                    <span class="badge bg-light text-dark font-monospace border mb-1">{{ $siswa->no_pendaftaran }}</span>
                    <div class="fw-bold text-dark">{{ $siswa->nama_lengkap }}</div>
                    <div class="text-muted small"><i class="bi bi-telephone me-1"></i>{{ $siswa->no_hp ?? '-' }}</div>
                  </td>
                  <td>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle mb-1">
                      {{ $siswa->jalur->nama_jalur ?? '-' }}
                    </span>
                    <div class="text-muted small">{{ $siswa->gelombang->nama_gelombang ?? '-' }}</div>
                  </td>
                  <td>
                    @php
                      $countDokumen = $siswa->dokumen->count();
                    @endphp
                    <span class="badge {{ $countDokumen > 0 ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">
                      <i class="bi bi-file-earmark-check me-1"></i>{{ $countDokumen }} Dokumen Diunggah
                    </span>
                  </td>
                  <td>
                    <div class="small text-muted">{{ $siswa->tanggal_daftar ? $siswa->tanggal_daftar->format('d/m/Y H:i') : '-' }}</div>
                  </td>
                  <td class="text-end pe-3">
                    <a href="{{ route('calon-siswa.show', $siswa->id_calon_siswa) }}" class="btn btn-warning btn-sm text-dark px-3 fw-semibold shadow-sm">
                      <i class="bi bi-check2-square me-1"></i> Verifikasi
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-5 text-muted">
                    <i class="bi bi-emoji-smile text-success fs-2 d-block mb-2"></i>
                    Bagus sekali! Semua calon siswa pada antrean telah selesai diverifikasi.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Kolom Kanan: Dokumen Baru Masuk & Riwayat Verifikasi -->
  <div class="col-lg-4 mb-4">
    <!-- Dokumen Menunggu Review -->
    <div class="card shadow-sm border-0 mb-4">
      <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-files text-info me-2"></i>Dokumen Baru Masuk</h6>
        <a href="{{ route('dokumen.index') }}" class="btn btn-sm btn-link p-0 text-decoration-none">Semua</a>
      </div>
      <div class="card-body p-0">
        <ul class="list-group list-group-flush">
          @forelse($antreanDokumen as $dok)
            <li class="list-group-item px-3 py-2 d-flex align-items-center justify-content-between">
              <div>
                <div class="fw-semibold text-dark small">{{ $dok->jenisDokumen->nama_dokumen ?? 'Dokumen' }}</div>
                <div class="text-muted small">{{ $dok->calonSiswa->nama_lengkap ?? '-' }}</div>
              </div>
              <a href="{{ route('dokumen.show', $dok->id_dokumen) }}" class="btn btn-sm btn-outline-info px-2 py-1" title="Lihat Berkas">
                <i class="bi bi-eye"></i>
              </a>
            </li>
          @empty
            <li class="list-group-item text-center py-3 text-muted small">Tidak ada berkas dokumen yang menunggu.</li>
          @endforelse
        </ul>
      </div>
    </div>

    <!-- Riwayat Verifikasi Terakhir -->
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white py-3 border-bottom">
        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-clock-history text-secondary me-2"></i>Riwayat Verifikasi Terbaru</h6>
      </div>
      <div class="card-body p-0">
        <ul class="list-group list-group-flush">
          @forelse($riwayatVerifikasi as $rw)
            <li class="list-group-item px-3 py-2">
              <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="fw-bold text-dark small">{{ $rw->nama_lengkap }}</span>
                <span class="badge {{ $rw->status === 'diverifikasi' ? 'bg-success' : 'bg-danger' }}">
                  {{ $rw->status === 'diverifikasi' ? 'Disetujui' : 'Ditolak' }}
                </span>
              </div>
              <div class="text-muted small" style="font-size: 0.75rem;">
                Diverifikasi: {{ $rw->verified_at ? $rw->verified_at->format('d M H:i') : '-' }}
                @if($rw->catatan_verifikasi)
                  &bull; <em>"{{ Str::limit($rw->catatan_verifikasi, 30) }}"</em>
                @endif
              </div>
            </li>
          @empty
            <li class="list-group-item text-center py-3 text-muted small">Belum ada riwayat verifikasi.</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>
