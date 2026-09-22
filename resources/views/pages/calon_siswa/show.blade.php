@extends('layouts.dahsboard.template')

@push('styles')
<style>
  @media print {
    body * {
      visibility: hidden;
    }
    #print-area, #print-area * {
      visibility: visible;
    }
    #print-area {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
    }
    .no-print {
      display: none !important;
    }
  }
  .table-biodata th {
    background-color: #f8f9fa;
    font-weight: 600;
    width: 25%;
  }
  .section-header {
    background-color: #0d6efd;
    color: white;
    padding: 0.55rem 1rem;
    font-weight: 700;
    border-radius: 8px;
    margin-top: 1.75rem;
    margin-bottom: 0.9rem;
    font-size: 0.95rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }
  .ortu-card {
    border-radius: 10px;
    background: #fff;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }
  .table-ortu th {
    font-size: 0.83rem;
    font-weight: 600;
    color: #6c757d;
    width: 100px;
    padding: 0.45rem 0.25rem;
    border-bottom: 1px dashed #e9ecef;
    white-space: nowrap;
  }
  .table-ortu td {
    font-size: 0.85rem;
    padding: 0.45rem 0.25rem;
    border-bottom: 1px dashed #e9ecef;
    color: #212529;
  }
  .table-ortu tr:last-child th,
  .table-ortu tr:last-child td {
    border-bottom: none;
  }
  .nav-tabs-bordered .nav-link.active {
    background-color: #fff;
    color: #0d6efd;
    border-bottom: 2.5px solid #0d6efd;
    font-weight: 600;
  }
</style>
@endpush

@section('content')
<div class="pagetitle no-print">
  <h1>Detail Pendaftaran Calon Siswa</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pendaftaran</li>
      <li class="breadcrumb-item"><a href="{{ route('calon-siswa.index') }}">Data Pendaftaran</a></li>
      <li class="breadcrumb-item active">{{ $calonSiswa->nama_lengkap }}</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
          <i class="bi bi-check-circle me-1"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <!-- Action toolbar (no print) -->
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 no-print">
        <a href="{{ route('calon-siswa.index') }}" class="btn btn-secondary btn-sm">
          <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-warning btn-sm text-dark fw-medium" data-bs-toggle="modal" data-bs-target="#modalStatusShow">
            <i class="bi bi-patch-check me-1"></i> Verifikasi Status
          </button>
          <a href="{{ route('dokumen.create', ['id_calon_siswa' => $calonSiswa->id_calon_siswa]) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-upload me-1"></i> Unggah Berkas
          </a>
          <button type="button" class="btn btn-outline-dark btn-sm" onclick="window.print()">
            <i class="bi bi-printer me-1"></i> Cetak Formulir
          </button>
          <a href="{{ route('calon-siswa.edit', $calonSiswa->id_calon_siswa) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil-square me-1"></i> Edit Biodata
          </a>
        </div>
      </div>

      <!-- Student PPDB Header Profile Card (no print) -->
      <div class="card shadow-sm border-0 mb-4 no-print">
        <div class="card-body p-4">
          <div class="row align-items-center">
            <div class="col-auto">
              <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 72px; height: 72px; font-size: 2rem; font-weight: 700;">
                {{ strtoupper(substr($calonSiswa->nama_lengkap, 0, 1)) }}
              </div>
            </div>
            <div class="col">
              <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                <h4 class="fw-bold mb-0 text-dark">{{ $calonSiswa->nama_lengkap }}</h4>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace px-2 py-1 fs-6">
                  {{ $calonSiswa->no_pendaftaran ?? 'REG-' . str_pad($calonSiswa->id_calon_siswa, 5, '0', STR_PAD_LEFT) }}
                </span>
                @php
                  $badges = [
                    'draft'               => 'bg-secondary-subtle text-secondary border-secondary-subtle',
                    'menunggu_verifikasi' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                    'diverifikasi'        => 'bg-info-subtle text-info-emphasis border-info-subtle',
                    'diterima'            => 'bg-success-subtle text-success border-success-subtle',
                    'ditolak'             => 'bg-danger-subtle text-danger border-danger-subtle',
                  ];
                  $labels = [
                    'draft'               => 'Draft',
                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                    'diverifikasi'        => 'Diverifikasi',
                    'diterima'            => 'Diterima',
                    'ditolak'             => 'Ditolak',
                  ];
                  $cls = $badges[$calonSiswa->status] ?? 'bg-light text-dark';
                  $lbl = $labels[$calonSiswa->status] ?? ucfirst($calonSiswa->status);
                @endphp
                <span class="badge {{ $cls }} border px-3 py-1 fs-6">
                  <i class="bi bi-patch-check me-1"></i>{{ $lbl }}
                </span>
              </div>

              <div class="text-muted small d-flex flex-wrap gap-3 mt-2">
                <span><i class="bi bi-signpost-2 me-1 text-primary"></i>Jalur: <strong>{{ $calonSiswa->jalur->nama_jalur ?? 'Reguler' }}</strong></span>
                <span><i class="bi bi-layers me-1 text-primary"></i>Gelombang: <strong>{{ $calonSiswa->gelombang->nama_gelombang ?? '-' }}</strong></span>
                <span><i class="bi bi-calendar-event me-1 text-primary"></i>Tahun: <strong>{{ $calonSiswa->tahunAjaran->tahun_ajaran ?? '-' }}</strong></span>
                <span><i class="bi bi-clock-history me-1 text-primary"></i>Daftar: <strong>{{ $calonSiswa->tanggal_daftar ? $calonSiswa->tanggal_daftar->translatedFormat('d M Y H:i') : $calonSiswa->created_at->translatedFormat('d M Y') }}</strong></span>
              </div>

              @if($calonSiswa->catatan_verifikasi)
                <div class="alert alert-warning py-2 px-3 mt-3 mb-0 small">
                  <i class="bi bi-info-circle me-1"></i><strong>Catatan Verifikator:</strong> {{ $calonSiswa->catatan_verifikasi }}
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Interactive Tabbed Card for Screen Reading (no print) -->
      <div class="card shadow-sm border-0 mb-4 no-print">
        <div class="card-body pt-3">
          <ul class="nav nav-tabs nav-tabs-bordered mb-3" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="identitas-tab" data-bs-toggle="tab" data-bs-target="#tab-identitas" type="button" role="tab"><i class="bi bi-person me-1"></i> 1. Identitas</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="alamat-tab" data-bs-toggle="tab" data-bs-target="#tab-alamat" type="button" role="tab"><i class="bi bi-geo-alt me-1"></i> 2. Alamat & Kontak</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="ortu-tab" data-bs-toggle="tab" data-bs-target="#tab-ortu" type="button" role="tab"><i class="bi bi-people me-1"></i> 3. Orang Tua & Wali</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="prestasi-tab" data-bs-toggle="tab" data-bs-target="#tab-prestasi" type="button" role="tab"><i class="bi bi-trophy me-1"></i> 4. Prestasi & Beasiswa</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="berkas-tab" data-bs-toggle="tab" data-bs-target="#tab-berkas" type="button" role="tab"><i class="bi bi-file-earmark-check me-1"></i> 5. Dokumen Persyaratan ({{ $calonSiswa->dokumen->count() }})</button>
            </li>
          </ul>

          <div class="tab-content" id="profileTabsContent">
            <!-- TAB 1: IDENTITAS -->
            <div class="tab-pane fade show active" id="tab-identitas" role="tabpanel">
              <table class="table table-bordered table-biodata align-middle mb-0">
                <tbody>
                  <tr>
                    <th>Nama Lengkap</th>
                    <td class="fw-bold text-dark fs-6">{{ $calonSiswa->nama_lengkap }}</td>
                    <th>Jenis Kelamin</th>
                    <td>{{ $calonSiswa->jenis_kelamin }}</td>
                  </tr>
                  <tr>
                    <th>NIK</th>
                    <td class="font-monospace">{{ $calonSiswa->nik ?? '-' }}</td>
                    <th>NISN</th>
                    <td class="font-monospace">{{ $calonSiswa->nisn ?? '-' }}</td>
                  </tr>
                  <tr>
                    <th>Tempat, Tanggal Lahir</th>
                    <td>{{ $calonSiswa->tempat_lahir }}, {{ optional($calonSiswa->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                    <th>Agama</th>
                    <td>{{ optional($calonSiswa->agama)->nama_agama ?? '-' }}</td>
                  </tr>
                  <tr>
                    <th>Jumlah Saudara Kandung</th>
                    <td>{{ $calonSiswa->jumlah_saudara_kandung }} orang</td>
                    <th>Anak Urutan Ke</th>
                    <td>Ke-{{ $calonSiswa->anak_ke }}</td>
                  </tr>
                  <tr>
                    <th>Asal Sekolah (TK / RA)</th>
                    <td>{{ $calonSiswa->asal_sekolah ?? '-' }}</td>
                    <th>Berkebutuhan Khusus</th>
                    <td>
                      @if($calonSiswa->kebutuhanKhusus && $calonSiswa->kebutuhanKhusus->kode !== '01')
                        <span class="badge bg-warning text-dark">{{ $calonSiswa->kebutuhanKhusus->nama }}</span>
                      @else
                        <span class="badge bg-success-subtle text-success">Tidak Ada (Normal)</span>
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- TAB 2: ALAMAT & KONTAK -->
            <div class="tab-pane fade" id="tab-alamat" role="tabpanel">
              <table class="table table-bordered table-biodata align-middle mb-0">
                <tbody>
                  <tr>
                    <th>Alamat (Dusun/Jalan)</th>
                    <td colspan="3">{{ $calonSiswa->alamat_jalan ?? '-' }} (RT {{ $calonSiswa->rt ?? '-' }} / RW {{ $calonSiswa->rw ?? '-' }})</td>
                  </tr>
                  <tr>
                    <th>Kelurahan / Desa</th>
                    <td>{{ $calonSiswa->kelurahan ?? '-' }}</td>
                    <th>Kode Pos</th>
                    <td class="font-monospace">{{ $calonSiswa->kode_pos ?? '-' }}</td>
                  </tr>
                  <tr>
                    <th>Kecamatan</th>
                    <td>{{ $calonSiswa->kecamatan ?? '-' }}</td>
                    <th>Kabupaten / Kota</th>
                    <td>{{ $calonSiswa->kabupaten_kota ?? '-' }}</td>
                  </tr>
                  <tr>
                    <th>Provinsi</th>
                    <td>{{ $calonSiswa->provinsi ?? '-' }}</td>
                    <th>Jenis Tinggal</th>
                    <td>{{ $calonSiswa->jenis_tinggal ?? '-' }}</td>
                  </tr>
                  <tr>
                    <th>No. HP / WhatsApp</th>
                    <td class="fw-bold text-primary">{{ $calonSiswa->no_hp ?? '-' }}</td>
                    <th>Email Pribadi</th>
                    <td>{{ $calonSiswa->email ?? '-' }}</td>
                  </tr>
                  <tr>
                    <th>Jarak ke Sekolah</th>
                    <td>{{ $calonSiswa->jarak_ke_sekolah ?? '-' }} {{ $calonSiswa->jarak_ke_sekolah_detail ? '(' . $calonSiswa->jarak_ke_sekolah_detail . ')' : '' }}</td>
                    <th>Waktu Tempuh</th>
                    <td>{{ $calonSiswa->waktu_tempuh ?? '-' }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- TAB 3: ORANG TUA & WALI -->
            <div class="tab-pane fade" id="tab-ortu" role="tabpanel">
              <div class="row g-3">
                <!-- Ayah -->
                <div class="col-md-4">
                  <div class="card h-100 border border-primary-subtle shadow-sm ortu-card">
                    <div class="card-header bg-primary text-white fw-bold py-2 px-3 d-flex justify-content-between">
                      <span><i class="bi bi-gender-male me-1"></i> Data Ayah Kandung</span>
                    </div>
                    <div class="card-body p-3">
                      <table class="table table-sm table-borderless table-ortu align-middle mb-0">
                        <tbody>
                          <tr><th>Nama</th><td>: <strong>{{ $calonSiswa->nama_ayah ?: '-' }}</strong></td></tr>
                          <tr><th>TTL</th><td>: {{ $calonSiswa->tempat_lahir_ayah ?: '-' }}, {{ optional($calonSiswa->tanggal_lahir_ayah)->translatedFormat('d M Y') ?: '-' }}</td></tr>
                          <tr><th>Pekerjaan</th><td>: {{ optional($calonSiswa->pekerjaanAyah)->nama_pekerjaan ?: '-' }}</td></tr>
                          <tr><th>Pendidikan</th><td>: {{ optional($calonSiswa->pendidikanAyah)->nama_pendidikan ?: '-' }}</td></tr>
                          <tr><th>Agama</th><td>: {{ optional($calonSiswa->agamaAyah)->nama_agama ?: '-' }}</td></tr>
                          <tr><th>Penghasilan</th><td>: {{ optional($calonSiswa->penghasilanAyah)->label ?: '-' }}</td></tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <!-- Ibu -->
                <div class="col-md-4">
                  <div class="card h-100 border border-danger-subtle shadow-sm ortu-card">
                    <div class="card-header bg-danger text-white fw-bold py-2 px-3 d-flex justify-content-between">
                      <span><i class="bi bi-gender-female me-1"></i> Data Ibu Kandung</span>
                    </div>
                    <div class="card-body p-3">
                      <table class="table table-sm table-borderless table-ortu align-middle mb-0">
                        <tbody>
                          <tr><th>Nama</th><td>: <strong>{{ $calonSiswa->nama_ibu ?: '-' }}</strong></td></tr>
                          <tr><th>TTL</th><td>: {{ $calonSiswa->tempat_lahir_ibu ?: '-' }}, {{ optional($calonSiswa->tanggal_lahir_ibu)->translatedFormat('d M Y') ?: '-' }}</td></tr>
                          <tr><th>Pekerjaan</th><td>: {{ optional($calonSiswa->pekerjaanIbu)->nama_pekerjaan ?: '-' }}</td></tr>
                          <tr><th>Pendidikan</th><td>: {{ optional($calonSiswa->pendidikanIbu)->nama_pendidikan ?: '-' }}</td></tr>
                          <tr><th>Agama</th><td>: {{ optional($calonSiswa->agamaIbu)->nama_agama ?: '-' }}</td></tr>
                          <tr><th>Penghasilan</th><td>: {{ optional($calonSiswa->penghasilanIbu)->label ?: '-' }}</td></tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <!-- Wali -->
                <div class="col-md-4">
                  <div class="card h-100 border border-secondary-subtle shadow-sm ortu-card">
                    <div class="card-header bg-secondary text-white fw-bold py-2 px-3 d-flex justify-content-between">
                      <span><i class="bi bi-shield-shaded me-1"></i> Data Wali</span>
                    </div>
                    <div class="card-body p-3">
                      @if($calonSiswa->nama_wali)
                        <table class="table table-sm table-borderless table-ortu align-middle mb-0">
                          <tbody>
                            <tr><th>Nama</th><td>: <strong>{{ $calonSiswa->nama_wali }}</strong></td></tr>
                            <tr><th>TTL</th><td>: {{ $calonSiswa->tempat_lahir_wali ?: '-' }}, {{ optional($calonSiswa->tanggal_lahir_wali)->translatedFormat('d M Y') ?: '-' }}</td></tr>
                            <tr><th>Pekerjaan</th><td>: {{ optional($calonSiswa->pekerjaanWali)->nama_pekerjaan ?: '-' }}</td></tr>
                            <tr><th>Pendidikan</th><td>: {{ optional($calonSiswa->pendidikanWali)->nama_pendidikan ?: '-' }}</td></tr>
                            <tr><th>Agama</th><td>: {{ optional($calonSiswa->agamaWali)->nama_agama ?: '-' }}</td></tr>
                            <tr><th>Penghasilan</th><td>: {{ optional($calonSiswa->penghasilanWali)->label ?: '-' }}</td></tr>
                          </tbody>
                        </table>
                      @else
                        <div class="text-center py-4 text-muted small fst-italic">
                          Calon siswa diasuh langsung oleh orang tua kandung.
                        </div>
                      @endif
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <!-- TAB 4: PRESTASI & BEASISWA -->
            <div class="tab-pane fade" id="tab-prestasi" role="tabpanel">
              <h6 class="fw-bold mb-2"><i class="bi bi-trophy text-warning me-1"></i> Catatan Prestasi</h6>
              @if($calonSiswa->prestasi->count() > 0)
                <div class="table-responsive mb-4">
                  <table class="table table-sm table-bordered align-middle">
                    <thead class="table-light">
                      <tr>
                        <th>No</th><th>Jenis Prestasi</th><th>Tingkat</th><th>Nama Prestasi</th><th>Tahun</th><th>Penyelenggara</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($calonSiswa->prestasi as $idx => $pres)
                        <tr>
                          <td>{{ $idx + 1 }}</td>
                          <td>{{ $pres->jenis_prestasi }}</td>
                          <td>{{ $pres->tingkat }}</td>
                          <td class="fw-bold">{{ $pres->nama_prestasi }}</td>
                          <td>{{ $pres->tahun }}</td>
                          <td>{{ $pres->penyelenggara }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="alert alert-light border small text-muted mb-4">Belum ada catatan prestasi.</div>
              @endif

              <h6 class="fw-bold mb-2"><i class="bi bi-award text-primary me-1"></i> Riwayat Beasiswa</h6>
              @if($calonSiswa->beasiswa->count() > 0)
                <div class="table-responsive mb-0">
                  <table class="table table-sm table-bordered align-middle">
                    <thead class="table-light">
                      <tr>
                        <th>No</th><th>Jenis Beasiswa</th><th>Penyelenggara</th><th>Tahun Mulai</th><th>Tahun Selesai</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($calonSiswa->beasiswa as $idx => $bea)
                        <tr>
                          <td>{{ $idx + 1 }}</td>
                          <td class="fw-bold">{{ $bea->jenis_beasiswa }}</td>
                          <td>{{ $bea->penyelenggara }}</td>
                          <td>{{ $bea->tahun_mulai }}</td>
                          <td>{{ $bea->tahun_selesai ?? 'Aktif' }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="alert alert-light border small text-muted">Belum ada riwayat beasiswa.</div>
              @endif
            </div>

            <!-- TAB 5: DOKUMEN PERSYARATAN -->
            <div class="tab-pane fade" id="tab-berkas" role="tabpanel">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-folder-check text-primary me-1"></i> Dokumen Berkas Persyaratan Terunggah</h6>
                <a href="{{ route('dokumen.create', ['id_calon_siswa' => $calonSiswa->id_calon_siswa]) }}" class="btn btn-sm btn-primary">
                  <i class="bi bi-plus-lg me-1"></i> Tambah Dokumen
                </a>
              </div>

              @if($calonSiswa->dokumen->count() > 0)
                <div class="table-responsive">
                  <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                      <tr>
                        <th style="width: 5%">No</th>
                        <th>Jenis Dokumen</th>
                        <th>Nama Berkas</th>
                        <th class="text-center">Ukuran / Format</th>
                        <th class="text-center">Status Verifikasi</th>
                        <th class="text-center" style="width: 15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($calonSiswa->dokumen as $idx => $dok)
                        <tr>
                          <td class="text-center">{{ $idx + 1 }}</td>
                          <td class="fw-bold">{{ $dok->jenisDokumen->nama_dokumen ?? '-' }}</td>
                          <td>
                            <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank" class="text-primary text-decoration-none">
                              <i class="bi bi-file-earmark-text me-1"></i>{{ $dok->nama_file }}
                            </a>
                            @if($dok->catatan_verifikasi)
                              <div class="small text-danger mt-1"><i class="bi bi-exclamation-triangle me-1"></i>{{ $dok->catatan_verifikasi }}</div>
                            @endif
                          </td>
                          <td class="text-center">
                            <span class="badge bg-light text-dark border text-uppercase">{{ $dok->tipe_file }}</span>
                            <small class="text-muted d-block">{{ $dok->ukuran_file }} KB</small>
                          </td>
                          <td class="text-center">
                            @if($dok->status_verifikasi === 'valid')
                              <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Valid</span>
                            @elseif($dok->status_verifikasi === 'ditolak')
                              <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                            @else
                              <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1"><i class="bi bi-hourglass-split me-1"></i>Menunggu</span>
                            @endif
                          </td>
                          <td class="text-center text-nowrap">
                            <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank" class="btn btn-sm btn-info text-white" title="Lihat Berkas"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('dokumen.edit', $dok->id_dokumen) }}" class="btn btn-sm btn-primary" title="Perbarui / Verifikasi"><i class="bi bi-pencil-square"></i></a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="alert alert-warning small mb-0">
                  <i class="bi bi-exclamation-circle me-1"></i> Calon siswa belum mengunggah dokumen persyaratan.
                </div>
              @endif
            </div>

          </div>
        </div>
      </div>

      <!-- Printable Area (Always complete for physical printout) -->
      <div class="card shadow-sm border-0" id="print-area">
        <div class="card-body p-4 p-md-5">

          <!-- Header Formulir -->
          <div class="text-center border-bottom pb-4 mb-4">
            <h4 class="fw-bold text-uppercase mb-1">Formulir Pendaftaran Peserta Didik Baru</h4>
            <h5 class="fw-bold text-primary mb-1">SD ISLAM DAARUL AITAM BATAM (AL-WAFA)</h5>
            <p class="text-muted small mb-0">
              No. Registrasi: <strong>{{ $calonSiswa->no_pendaftaran ?? 'REG-' . str_pad($calonSiswa->id_calon_siswa, 5, '0', STR_PAD_LEFT) }}</strong> | 
              Jalur: <strong>{{ $calonSiswa->jalur->nama_jalur ?? 'Reguler' }}</strong> | 
              Gelombang: <strong>{{ $calonSiswa->gelombang->nama_gelombang ?? '-' }}</strong> | 
              Tahun Ajaran: <strong>{{ $calonSiswa->tahunAjaran->tahun_ajaran ?? '-' }}</strong>
            </p>
          </div>

          <!-- 1. IDENTITAS PESERTA DIDIK -->
          <div class="section-header">1. IDENTITAS PESERTA DIDIK</div>
          <table class="table table-bordered table-biodata align-middle mb-4">
            <tbody>
              <tr>
                <th>Nama Lengkap</th>
                <td class="fw-bold text-dark fs-6">{{ $calonSiswa->nama_lengkap }}</td>
                <th>Jenis Kelamin</th>
                <td>{{ $calonSiswa->jenis_kelamin }}</td>
              </tr>
              <tr>
                <th>NIK</th>
                <td class="font-monospace">{{ $calonSiswa->nik ?? '-' }}</td>
                <th>NISN</th>
                <td class="font-monospace">{{ $calonSiswa->nisn ?? '-' }}</td>
              </tr>
              <tr>
                <th>Tempat, Tanggal Lahir</th>
                <td>{{ $calonSiswa->tempat_lahir }}, {{ optional($calonSiswa->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                <th>Agama</th>
                <td>{{ optional($calonSiswa->agama)->nama_agama ?? '-' }}</td>
              </tr>
              <tr>
                <th>Jumlah Saudara Kandung</th>
                <td>{{ $calonSiswa->jumlah_saudara_kandung }} orang</td>
                <th>Anak Urutan Ke</th>
                <td>Ke-{{ $calonSiswa->anak_ke }}</td>
              </tr>
              <tr>
                <th>Berkebutuhan Khusus</th>
                <td colspan="3">
                  @if($calonSiswa->kebutuhanKhusus && $calonSiswa->kebutuhanKhusus->kode !== '01')
                    {{ $calonSiswa->kebutuhanKhusus->kode }} - {{ $calonSiswa->kebutuhanKhusus->nama }}
                  @else
                    Tidak Ada (Normal)
                  @endif
                </td>
              </tr>
              <tr>
                <th>Asal Sekolah (TK / RA)</th>
                <td>{{ $calonSiswa->asal_sekolah ?? '-' }}</td>
                <th>Status Pendaftaran</th>
                <td><span class="badge bg-primary px-2 py-1 text-uppercase">{{ str_replace('_', ' ', $calonSiswa->status) }}</span></td>
              </tr>
            </tbody>
          </table>

          <!-- 2. ALAMAT TEMPAT TINGGAL & KONTAK -->
          <div class="section-header" style="background-color: #0dcaf0; color: #000;">2. ALAMAT TEMPAT TINGGAL & KONTAK</div>
          <table class="table table-bordered table-biodata align-middle mb-4">
            <tbody>
              <tr>
                <th>Alamat (Dusun/Jalan)</th>
                <td colspan="3">{{ $calonSiswa->alamat_jalan ?? '-' }} (RT {{ $calonSiswa->rt ?? '-' }} / RW {{ $calonSiswa->rw ?? '-' }})</td>
              </tr>
              <tr>
                <th>Kelurahan / Desa</th>
                <td>{{ $calonSiswa->kelurahan ?? '-' }}</td>
                <th>Kode Pos</th>
                <td class="font-monospace">{{ $calonSiswa->kode_pos ?? '-' }}</td>
              </tr>
              <tr>
                <th>Kecamatan</th>
                <td>{{ $calonSiswa->kecamatan ?? '-' }}</td>
                <th>Kabupaten / Kota</th>
                <td>{{ $calonSiswa->kabupaten_kota ?? '-' }}</td>
              </tr>
              <tr>
                <th>Provinsi</th>
                <td>{{ $calonSiswa->provinsi ?? '-' }}</td>
                <th>Jenis Tinggal</th>
                <td>{{ $calonSiswa->jenis_tinggal ?? '-' }}</td>
              </tr>
              <tr>
                <th>Alat Transportasi</th>
                <td>{{ $calonSiswa->alat_transportasi ?? '-' }}</td>
                <th>No. HP / WhatsApp</th>
                <td>{{ $calonSiswa->no_hp ?? '-' }}</td>
              </tr>
              <tr>
                <th>Telepon Rumah</th>
                <td>{{ $calonSiswa->telepon_rumah ?? '-' }}</td>
                <th>Email Pribadi</th>
                <td>{{ $calonSiswa->email ?? '-' }}</td>
              </tr>
              <tr>
                <th>Jarak ke Sekolah</th>
                <td>{{ $calonSiswa->jarak_ke_sekolah ?? '-' }} {{ $calonSiswa->jarak_ke_sekolah_detail ? '(' . $calonSiswa->jarak_ke_sekolah_detail . ')' : '' }}</td>
                <th>Waktu Tempuh</th>
                <td>{{ $calonSiswa->waktu_tempuh ?? '-' }}</td>
              </tr>
            </tbody>
          </table>

          <!-- 3. DATA ORANG TUA KANDUNG & WALI -->
          <div class="section-header" style="background-color: #198754;">3. DATA ORANG TUA KANDUNG & WALI</div>
          <div class="row g-3 mb-4">
            <div class="col-4">
              <div class="p-2 border rounded">
                <strong class="d-block text-primary border-bottom pb-1 mb-2">Ayah Kandung</strong>
                <div class="small"><strong>Nama:</strong> {{ $calonSiswa->nama_ayah ?: '-' }}</div>
                <div class="small"><strong>Pekerjaan:</strong> {{ optional($calonSiswa->pekerjaanAyah)->nama_pekerjaan ?: '-' }}</div>
                <div class="small"><strong>Pendidikan:</strong> {{ optional($calonSiswa->pendidikanAyah)->nama_pendidikan ?: '-' }}</div>
                <div class="small"><strong>Penghasilan:</strong> {{ optional($calonSiswa->penghasilanAyah)->label ?: '-' }}</div>
              </div>
            </div>
            <div class="col-4">
              <div class="p-2 border rounded">
                <strong class="d-block text-danger border-bottom pb-1 mb-2">Ibu Kandung</strong>
                <div class="small"><strong>Nama:</strong> {{ $calonSiswa->nama_ibu ?: '-' }}</div>
                <div class="small"><strong>Pekerjaan:</strong> {{ optional($calonSiswa->pekerjaanIbu)->nama_pekerjaan ?: '-' }}</div>
                <div class="small"><strong>Pendidikan:</strong> {{ optional($calonSiswa->pendidikanIbu)->nama_pendidikan ?: '-' }}</div>
                <div class="small"><strong>Penghasilan:</strong> {{ optional($calonSiswa->penghasilanIbu)->label ?: '-' }}</div>
              </div>
            </div>
            <div class="col-4">
              <div class="p-2 border rounded">
                <strong class="d-block text-secondary border-bottom pb-1 mb-2">Wali</strong>
                <div class="small"><strong>Nama:</strong> {{ $calonSiswa->nama_wali ?: '-' }}</div>
                <div class="small"><strong>Pekerjaan:</strong> {{ optional($calonSiswa->pekerjaanWali)->nama_pekerjaan ?: '-' }}</div>
                <div class="small"><strong>Pendidikan:</strong> {{ optional($calonSiswa->pendidikanWali)->nama_pendidikan ?: '-' }}</div>
                <div class="small"><strong>Penghasilan:</strong> {{ optional($calonSiswa->penghasilanWali)->label ?: '-' }}</div>
              </div>
            </div>
          </div>

          <!-- Lembar Tanda Tangan Cetak -->
          <div class="row mt-5 pt-3 border-top d-none d-print-flex">
            <div class="col-6 text-center">
              <p class="mb-5">Mengetahui,<br>Orang Tua / Wali Calon Siswa</p>
              <p class="fw-bold mt-5">( .................................................... )</p>
            </div>
            <div class="col-6 text-center">
              <p class="mb-5">Batam, {{ date('d F Y') }}<br>Panitia PPDB SD Islam Al-Wafa</p>
              <p class="fw-bold mt-5">( .................................................... )</p>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<!-- Modal Quick Status on Show Page -->
<div class="modal fade no-print" id="modalStatusShow" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fs-6"><i class="bi bi-patch-check me-2"></i>Verifikasi Status Calon Siswa</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('calon-siswa.update-status', $calonSiswa->id_calon_siswa) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Status Pendaftaran <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
              <option value="draft" {{ $calonSiswa->status === 'draft' ? 'selected' : '' }}>Draft</option>
              <option value="menunggu_verifikasi" {{ $calonSiswa->status === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
              <option value="diverifikasi" {{ $calonSiswa->status === 'diverifikasi' ? 'selected' : '' }}>Diverifikasi (Berkas Sah & Lengkap)</option>
              <option value="diterima" {{ $calonSiswa->status === 'diterima' ? 'selected' : '' }}>Diterima (Lulus Seleksi)</option>
              <option value="ditolak" {{ $calonSiswa->status === 'ditolak' ? 'selected' : '' }}>Ditolak (Tidak Memenuhi Syarat)</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Catatan Verifikasi / Alasan <small class="text-muted fw-normal">(Opsional)</small></label>
            <textarea name="catatan_verifikasi" class="form-control" rows="3" placeholder="Tuliskan catatan verifikator...">{{ $calonSiswa->catatan_verifikasi }}</textarea>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="bi bi-check-lg me-1"></i> Simpan Status
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
