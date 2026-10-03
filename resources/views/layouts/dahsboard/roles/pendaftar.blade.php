{{-- ========================================================================= --}}
{{-- DASHBOARD KHUSUS ROLE: PENDAFTAR (CALON SISWA / ORANG TUA)                --}}
{{-- ========================================================================= --}}

@if(!$calonSiswa)
  <!-- KONDISI A: PENDAFTAR BELUM MENGISI BIODATA SISWA -->
  <div class="row">
    <div class="col-12 mb-4">
      <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
        <div class="card-body p-4 p-md-5 text-white text-center">
          <span class="badge bg-warning text-dark px-3 py-2 fw-bold text-uppercase mb-3">Portal Pendaftaran Baru</span>
          <h2 class="fw-bold mb-2">Selamat Datang di PPDB {{ $sekolah->nama_sekolah ?? 'SD Islam Plus Al Wafa' }}</h2>
          <p class="lead mb-4 text-white-50 mx-auto" style="max-width: 680px;">
            Terima kasih telah bergabung. Anda belum mendaftarkan calon siswa. Silakan lengkapi formulir pendaftaran untuk memulai proses penerimaan peserta didik baru tahun ajaran {{ $tahunAktif->tahun_ajaran ?? 'berjalan' }}.
          </p>
          <a href="{{ route('calon-siswa.create') }}" class="btn btn-warning btn-lg px-4 py-2 fw-bold shadow text-dark">
            <i class="bi bi-pencil-square me-2"></i> Isi Formulir Pendaftaran Siswa
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Petunjuk 4 Langkah Pendaftaran -->
  <div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
      <div class="card shadow-sm border-0 h-100 p-3 text-center">
        <div class="rounded-circle bg-primary-subtle text-primary mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; font-size: 1.3rem;">
          1
        </div>
        <h6 class="fw-bold text-dark">Isi Biodata</h6>
        <p class="text-muted small mb-0">Lengkapi data diri calon siswa, orang tua, serta asal sekolah secara akurat.</p>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="card shadow-sm border-0 h-100 p-3 text-center">
        <div class="rounded-circle bg-info-subtle text-info mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; font-size: 1.3rem;">
          2
        </div>
        <h6 class="fw-bold text-dark">Unggah Berkas</h6>
        <p class="text-muted small mb-0">Upload scan akta kelahiran, kartu keluarga, dan pas foto calon siswa.</p>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="card shadow-sm border-0 h-100 p-3 text-center">
        <div class="rounded-circle bg-warning-subtle text-warning mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; font-size: 1.3rem;">
          3
        </div>
        <h6 class="fw-bold text-dark">Pembayaran</h6>
        <p class="text-muted small mb-0">Lakukan pembayaran formulir pendaftaran dan unggah bukti transfer.</p>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="card shadow-sm border-0 h-100 p-3 text-center">
        <div class="rounded-circle bg-success-subtle text-success mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; font-size: 1.3rem;">
          4
        </div>
        <h6 class="fw-bold text-dark">Ujian & Pengumuman</h6>
        <p class="text-muted small mb-0">Ikuti jadwal observasi/wawancara dan pantau hasil kelulusan di sini.</p>
      </div>
    </div>
  </div>

@else
  <!-- KONDISI B: PENDAFTAR SUDAH MENGISI BIODATA SISWA -->

  <!-- Hero Siswa -->
  <div class="row mb-3">
    <div class="col-12">
      <div class="card shadow-sm border-0 text-white" style="background: linear-gradient(135deg, #1b3a6b 0%, #2e59a8 100%);">
        <div class="card-body p-4">
          <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
              <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-warning text-dark fw-bold px-2 py-1 font-monospace">
                  <i class="bi bi-upc-scan me-1"></i>{{ $calonSiswa->no_pendaftaran }}
                </span>
                <span class="badge bg-white bg-opacity-25 text-white">
                  {{ $calonSiswa->gelombang->nama_gelombang ?? 'Gelombang Aktif' }} &bull; {{ $calonSiswa->jalur->nama_jalur ?? 'Jalur Reguler' }}
                </span>
              </div>
              <h3 class="fw-bold mb-1 text-white">{{ $calonSiswa->nama_lengkap }}</h3>
              <p class="mb-0 text-white-50 small">
                Terdaftar pada: {{ $calonSiswa->tanggal_daftar ? $calonSiswa->tanggal_daftar->translatedFormat('d F Y H:i') : '-' }} &bull;
                Asal Sekolah: <strong>{{ $calonSiswa->asal_sekolah ?: '-' }}</strong>
              </p>
            </div>
            <div class="d-flex flex-wrap gap-2">
              <a href="{{ route('calon-siswa.show', $calonSiswa->id_calon_siswa) }}" class="btn btn-warning btn-sm fw-semibold px-3 shadow-sm text-dark">
                <i class="bi bi-person-bounding-box me-1"></i> Detail Formulir
              </a>
              <a href="{{ route('dokumen.index') }}" class="btn btn-light btn-sm fw-semibold px-3 shadow-sm text-primary">
                <i class="bi bi-folder me-1"></i> Upload Berkas
              </a>
              <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-light btn-sm fw-semibold px-3 shadow-sm">
                <i class="bi bi-credit-card me-1"></i> Cek Pembayaran
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stepper / Alur Proses PPDB (6 Tahapan) -->
  @php
    $dokumenSiswaList = $calonSiswa->dokumen;
    $pembayaranList = $calonSiswa->pembayaran;
    $pembayaranLunas = $pembayaranList->where('status_pembayaran', 'lunas')->first();
    $pembayaranPending = $pembayaranList->where('status_pembayaran', 'menunggu_konfirmasi')->first();
    $isDokumenLengkap = $dokumenSiswaList->count() > 0;
    $isVerifikasiLolos = in_array($calonSiswa->status, ['diverifikasi', 'diterima']);
    $isLulus = $calonSiswa->status === 'diterima';
    $isDitolak = $calonSiswa->status === 'ditolak';
  @endphp

  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
          <h6 class="m-0 fw-bold text-dark"><i class="bi bi-arrow-right-circle text-primary me-2"></i>Status Tahapan Pendaftaran Anda</h6>
        </div>
        <div class="card-body p-4">
          <div class="row text-center g-3">
            <!-- Step 1: Formulir Biodata -->
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded bg-success-subtle border-success">
                <i class="bi bi-check-circle-fill text-success fs-3 d-block mb-1"></i>
                <span class="fw-bold small d-block text-dark">1. Biodata</span>
                <span class="badge bg-success" style="font-size: 0.7rem;">Selesai</span>
              </div>
            </div>

            <!-- Step 2: Upload Dokumen -->
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded {{ $isDokumenLengkap ? 'bg-success-subtle border-success' : 'bg-warning-subtle border-warning' }}">
                <i class="bi {{ $isDokumenLengkap ? 'bi-check-circle-fill text-success' : 'bi-clock-fill text-warning' }} fs-3 d-block mb-1"></i>
                <span class="fw-bold small d-block text-dark">2. Berkas</span>
                <span class="badge {{ $isDokumenLengkap ? 'bg-success' : 'bg-warning text-dark' }}" style="font-size: 0.7rem;">
                  {{ $isDokumenLengkap ? 'Diunggah' : 'Perlu Upload' }}
                </span>
              </div>
            </div>

            <!-- Step 3: Pembayaran -->
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded {{ $pembayaranLunas ? 'bg-success-subtle border-success' : ($pembayaranPending ? 'bg-info-subtle border-info' : 'bg-light border') }}">
                <i class="bi {{ $pembayaranLunas ? 'bi-check-circle-fill text-success' : ($pembayaranPending ? 'bi-hourglass-split text-info' : 'bi-credit-card text-muted') }} fs-3 d-block mb-1"></i>
                <span class="fw-bold small d-block text-dark">3. Pembayaran</span>
                <span class="badge {{ $pembayaranLunas ? 'bg-success' : ($pembayaranPending ? 'bg-info' : 'bg-secondary') }}" style="font-size: 0.7rem;">
                  {{ $pembayaranLunas ? 'Lunas' : ($pembayaranPending ? 'Konfirmasi' : 'Belum Bayar') }}
                </span>
              </div>
            </div>

            <!-- Step 4: Verifikasi Panitia -->
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded {{ $isVerifikasiLolos ? 'bg-success-subtle border-success' : ($isDitolak ? 'bg-danger-subtle border-danger' : 'bg-light border') }}">
                <i class="bi {{ $isVerifikasiLolos ? 'bi-patch-check-fill text-success' : ($isDitolak ? 'bi-x-circle-fill text-danger' : 'bi-shield-check text-muted') }} fs-3 d-block mb-1"></i>
                <span class="fw-bold small d-block text-dark">4. Verifikasi</span>
                <span class="badge {{ $isVerifikasiLolos ? 'bg-success' : ($isDitolak ? 'bg-danger' : 'bg-secondary') }}" style="font-size: 0.7rem;">
                  {{ $isVerifikasiLolos ? 'Diverifikasi' : ($isDitolak ? 'Ditolak' : 'Menunggu') }}
                </span>
              </div>
            </div>

            <!-- Step 5: Ujian Observasi -->
            @php
              $sudahDinilai = $calonSiswa->nilaiSeleksi->count() > 0;
            @endphp
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded {{ $sudahDinilai ? 'bg-success-subtle border-success' : 'bg-light border' }}">
                <i class="bi {{ $sudahDinilai ? 'bi-award-fill text-success' : 'bi-pencil-square text-muted' }} fs-3 d-block mb-1"></i>
                <span class="fw-bold small d-block text-dark">5. Tes Masuk</span>
                <span class="badge {{ $sudahDinilai ? 'bg-success' : 'bg-secondary' }}" style="font-size: 0.7rem;">
                  {{ $sudahDinilai ? 'Selesai Tes' : 'Jadwal Tes' }}
                </span>
              </div>
            </div>

            <!-- Step 6: Kelulusan -->
            <div class="col-md-2 col-4">
              <div class="p-2 border rounded {{ $isLulus ? 'bg-success-subtle border-success' : ($isDitolak ? 'bg-danger-subtle border-danger' : 'bg-light border') }}">
                <i class="bi {{ $isLulus ? 'bi-mortarboard-fill text-success' : ($isDitolak ? 'bi-x-circle text-danger' : 'bi-megaphone text-muted') }} fs-3 d-block mb-1"></i>
                <span class="fw-bold small d-block text-dark">6. Kelulusan</span>
                <span class="badge {{ $isLulus ? 'bg-success' : ($isDitolak ? 'bg-danger' : 'bg-secondary') }}" style="font-size: 0.7rem;">
                  {{ $isLulus ? 'DITERIMA' : ($isDitolak ? 'TIDAK LOLOS' : 'Menunggu') }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Status Detail Cards -->
  <div class="row">
    <!-- Status Kelulusan / Pengumuman Terkini -->
    <div class="col-lg-6 mb-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
          <h6 class="m-0 fw-bold text-dark"><i class="bi bi-info-circle text-primary me-2"></i>Status Pendaftaran Calon Siswa</h6>
          <span class="badge {{ $calonSiswa->status === 'diterima' ? 'bg-success' : ($calonSiswa->status === 'menunggu_verifikasi' ? 'bg-warning text-dark' : ($calonSiswa->status === 'diverifikasi' ? 'bg-info' : 'bg-secondary')) }}">
            {{ ucfirst(str_replace('_', ' ', $calonSiswa->status)) }}
          </span>
        </div>
        <div class="card-body p-4">
          @if($calonSiswa->status === 'diterima')
            <div class="alert alert-success d-flex align-items-center mb-3">
              <i class="bi bi-patch-check-fill fs-2 me-3"></i>
              <div>
                <h5 class="alert-heading fw-bold mb-1">Selamat! Calon Siswa Diterima!</h5>
                <p class="mb-0 small">Ananda dinyatakan <strong>LULUS / DITERIMA</strong> di {{ $sekolah->nama_sekolah ?? 'SD Islam Plus Al Wafa' }}. Silakan segera lakukan proses daftar ulang sesuai petunjuk sekolah.</p>
              </div>
            </div>
          @elseif($calonSiswa->status === 'ditolak')
            <div class="alert alert-danger d-flex align-items-center mb-3">
              <i class="bi bi-x-circle-fill fs-2 me-3"></i>
              <div>
                <h5 class="alert-heading fw-bold mb-1">Mohon Maaf</h5>
                <p class="mb-0 small">Pendaftaran ananda belum dapat diterima pada periode ini. Hubungi pihak sekolah untuk informasi lebih lanjut.</p>
              </div>
            </div>
          @elseif($calonSiswa->status === 'diverifikasi')
            <div class="alert alert-info d-flex align-items-center mb-3">
              <i class="bi bi-check2-circle fs-2 me-3"></i>
              <div>
                <h5 class="alert-heading fw-bold mb-1">Berkas Terverifikasi</h5>
                <p class="mb-0 small">Berkas persyaratan dan biodata telah diverifikasi panitia. Silakan persiapkan ananda untuk jadwal observasi/wawancara seleksi.</p>
              </div>
            </div>
          @else
            <div class="alert alert-warning d-flex align-items-center mb-3">
              <i class="bi bi-hourglass-split fs-2 me-3"></i>
              <div>
                <h5 class="alert-heading fw-bold mb-1">Menunggu Verifikasi Berkas</h5>
                <p class="mb-0 small">Data pendaftaran ananda sedang dalam antrean pemeriksaan oleh Panitia PPDB Al Wafa. Pastikan seluruh berkas wajib telah Anda unggah.</p>
              </div>
            </div>
          @endif

          @if($calonSiswa->catatan_verifikasi)
            <div class="p-3 bg-light border rounded mb-3">
              <span class="fw-bold small text-muted d-block mb-1"><i class="bi bi-chat-left-quote me-1"></i>Catatan dari Panitia Verifikasi:</span>
              <p class="mb-0 text-dark small fst-italic">"{{ $calonSiswa->catatan_verifikasi }}"</p>
            </div>
          @endif

          <div class="d-flex gap-2">
            <a href="{{ route('calon-siswa.edit', $calonSiswa->id_calon_siswa) }}" class="btn btn-outline-primary btn-sm">
              <i class="bi bi-pencil me-1"></i> Edit Biodata
            </a>
            <a href="{{ route('calon-siswa.show', $calonSiswa->id_calon_siswa) }}" class="btn btn-primary btn-sm">
              <i class="bi bi-eye me-1"></i> Lihat Data Lengkap
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Status Pembayaran & Rekening Bank -->
    <div class="col-lg-6 mb-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
          <h6 class="m-0 fw-bold text-dark"><i class="bi bi-wallet2 text-success me-2"></i>Status Pembayaran PPDB</h6>
          <span class="badge {{ $pembayaranLunas ? 'bg-success' : ($pembayaranPending ? 'bg-info' : 'bg-warning text-dark') }}">
            {{ $pembayaranLunas ? 'Lunas' : ($pembayaranPending ? 'Menunggu Konfirmasi' : 'Belum Lunas') }}
          </span>
        </div>
        <div class="card-body p-4">
          @if($pembayaranLunas)
            <div class="text-center py-3">
              <i class="bi bi-check-circle-fill text-success fs-1 mb-2 d-block"></i>
              <h5 class="fw-bold text-dark">Pembayaran Terkonfirmasi Lunas</h5>
              <p class="text-muted small mb-3">Kode Transaksi: <strong>{{ $pembayaranLunas->kode_transaksi }}</strong> &bull; Sebesar: <strong class="text-success">Rp {{ number_format($pembayaranLunas->nominal, 0, ',', '.') }}</strong></p>
              <a href="{{ route('pembayaran.kwitansi', $pembayaranLunas->id_pembayaran) }}" target="_blank" class="btn btn-outline-success btn-sm px-3">
                <i class="bi bi-printer me-1"></i> Cetak Kwitansi Resmi
              </a>
            </div>
          @else
            <div class="p-3 bg-light border rounded mb-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold text-dark">{{ $biayaFormulir->nama_biaya ?? 'Biaya Formulir Pendaftaran' }}</span>
                <span class="fw-bold text-success fs-6">Rp {{ number_format($biayaFormulir->nominal ?? 250000, 0, ',', '.') }}</span>
              </div>
              <p class="text-muted small mb-0">Silakan lakukan transfer biaya pendaftaran ke rekening resmi sekolah di bawah ini:</p>
              <div class="mt-2 p-2 bg-white border rounded">
                <div class="small fw-bold text-primary"><i class="bi bi-bank me-1"></i>Bank Syariah Indonesia (BSI)</div>
                <div class="fw-bold font-monospace fs-6">714-888-9990</div>
                <div class="small text-muted">a.n. {{ $sekolah->nama_yayasan ?? 'Yayasan Daarul Aitam Batam' }}</div>
              </div>
            </div>

            <div class="d-flex gap-2">
              <a href="{{ route('pembayaran.index') }}" class="btn btn-success btn-sm w-100 py-2 fw-semibold">
                <i class="bi bi-upload me-1"></i> Konfirmasi & Unggah Bukti Bayar
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Kelengkapan Dokumen Berkas -->
  <div class="row">
    <div class="col-12 mb-4">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
          <div>
            <h6 class="m-0 fw-bold text-dark"><i class="bi bi-files text-primary me-2"></i>Kelengkapan Dokumen Persyaratan</h6>
            <span class="text-muted small">Pastikan scan dokumen terlihat jelas dan terbaca oleh verifikator</span>
          </div>
          <a href="{{ route('dokumen.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-cloud-arrow-up me-1"></i> Kelola Dokumen
          </a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
              <thead class="table-light">
                <tr>
                  <th class="ps-3">Nama Dokumen Persyaratan</th>
                  <th>Kewajiban</th>
                  <th>Status Upload</th>
                  <th>Status Verifikasi</th>
                  <th class="text-end pe-3">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($dokumenWajib as $dokWajib)
                  @php
                    $uploaded = $calonSiswa->dokumen->where('id_jenis_dokumen', $dokWajib->id_jenis_dokumen)->first();
                  @endphp
                  <tr>
                    <td class="ps-3 fw-semibold text-dark">{{ $dokWajib->nama_dokumen }}</td>
                    <td>
                      <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Wajib</span>
                    </td>
                    <td>
                      @if($uploaded)
                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                          <i class="bi bi-check-lg me-1"></i>Sudah Diunggah
                        </span>
                      @else
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                          <i class="bi bi-exclamation-triangle me-1"></i>Belum Diunggah
                        </span>
                      @endif
                    </td>
                    <td>
                      @if($uploaded)
                        <span class="badge {{ $uploaded->status_verifikasi === 'valid' ? 'bg-success' : ($uploaded->status_verifikasi === 'ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}">
                          {{ ucfirst($uploaded->status_verifikasi) }}
                        </span>
                      @else
                        <span class="text-muted small">-</span>
                      @endif
                    </td>
                    <td class="text-end pe-3">
                      <a href="{{ route('dokumen.index') }}" class="btn btn-sm btn-outline-primary px-2 py-1">
                        <i class="bi bi-upload me-1"></i> {{ $uploaded ? 'Ubah' : 'Upload' }}
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-4 text-muted small">Belum ada daftar dokumen wajib.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif
