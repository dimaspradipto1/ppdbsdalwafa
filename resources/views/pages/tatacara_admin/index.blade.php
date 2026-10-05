@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Kelola Tata Cara &amp; Alur Pendaftaran PPDB</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Homepage</li>
      <li class="breadcrumb-item active">Kelola Tata Cara</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">

    @if(session('success'))
      <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
          <i class="bi bi-check-circle-fill fs-5 me-2"></i>
          <div>{{ session('success') }}</div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    @if(isset($errors) && $errors->any())
      <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul class="mb-0 small">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    <!-- Kolom Kiri: Form Pengaturan Tata Cara -->
    <div class="col-lg-7">
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <div class="bg-primary text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="bi bi-journal-text"></i>
            </div>
            <div>
              <h6 class="card-title p-0 m-0 fw-bold text-dark">Formulir Konten Tata Cara Pendaftaran</h6>
              <small class="text-muted">Kustomisasi tahapan alur pendaftaran yang tampil di homepage dan halaman tata cara</small>
            </div>
          </div>
          <a href="{{ route('tatacara.publik') }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Publik
          </a>
        </div>

        <div class="card-body p-4">
          <form action="{{ route('tatacara-setting.update') }}" method="POST" id="formTataCara">
            @csrf

            <!-- Section 1: Ringkasan 4 Langkah di Homepage -->
            <div class="mb-4">
              <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                <h6 class="fw-bold text-dark mb-0">
                  <i class="bi bi-card-checklist text-success me-2"></i>1. Ringkasan 4 Langkah Pendaftaran (Tampil di Homepage)
                </h6>
                <span class="badge bg-success-subtle text-success border border-success-subtle">Homepage Utama</span>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark">Judul Kartu di Homepage</label>
                  <input type="text" name="tatacara_judul" id="input_tatacara_judul" class="form-control" value="{{ $settings['tatacara_judul'] ?? 'Tata Cara Pendaftaran Siswa Baru' }}" placeholder="Tata Cara Pendaftaran Siswa Baru" oninput="updateLivePreview()">
                  <div class="form-text">Judul kartu tata cara di kolom samping kanan homepage.</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark">Judul Accordion di Atas Jalur</label>
                  <input type="text" name="tatacara_accordion_judul" id="input_accordion_judul" class="form-control" value="{{ $settings['tatacara_accordion_judul'] ?? 'Tata Cara Pendaftaran Calon Siswa Baru' }}" placeholder="Tata Cara Pendaftaran Calon Siswa Baru" oninput="updateLivePreview()">
                  <div class="form-text">Judul bilah accordion di atas daftar kartu jalur pendaftaran.</div>
                </div>
              </div>

              <!-- Langkah 1 & 2 -->
              <div class="card bg-light border-0 p-3 mb-3 rounded-3">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-success"><i class="bi bi-1-circle me-1"></i> Langkah 1: Judul</label>
                    <input type="text" name="tatacara_1_judul" id="input_step1_title" class="form-control mb-2" value="{{ $settings['tatacara_1_judul'] ?? 'Pilih Jalur Pendaftaran' }}" placeholder="Judul Langkah 1" required oninput="updateLivePreview()">
                    <label class="form-label fw-semibold text-muted small">Deskripsi Ringkas</label>
                    <textarea name="tatacara_1_desc" id="input_step1_desc" rows="2" class="form-control" placeholder="Deskripsi ringkas..." required oninput="updateLivePreview()">{{ $settings['tatacara_1_desc'] ?? 'Tentukan jalur masuk sesuai pilihan dan ketentuan sekolah.' }}</textarea>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-success"><i class="bi bi-2-circle me-1"></i> Langkah 2: Judul</label>
                    <input type="text" name="tatacara_2_judul" id="input_step2_title" class="form-control mb-2" value="{{ $settings['tatacara_2_judul'] ?? 'Isi Formulir Pendaftaran' }}" placeholder="Judul Langkah 2" required oninput="updateLivePreview()">
                    <label class="form-label fw-semibold text-muted small">Deskripsi Ringkas</label>
                    <textarea name="tatacara_2_desc" id="input_step2_desc" rows="2" class="form-control" placeholder="Deskripsi ringkas..." required oninput="updateLivePreview()">{{ $settings['tatacara_2_desc'] ?? 'Lengkapi data diri calon siswa dan orang tua pada formulir online secara benar.' }}</textarea>
                  </div>
                </div>
              </div>

              <!-- Langkah 3 & 4 -->
              <div class="card bg-light border-0 p-3 rounded-3">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-success"><i class="bi bi-3-circle me-1"></i> Langkah 3: Judul</label>
                    <input type="text" name="tatacara_3_judul" id="input_step3_title" class="form-control mb-2" value="{{ $settings['tatacara_3_judul'] ?? 'Bayar Biaya Pendaftaran' }}" placeholder="Judul Langkah 3" required oninput="updateLivePreview()">
                    <label class="form-label fw-semibold text-muted small">Deskripsi Ringkas</label>
                    <textarea name="tatacara_3_desc" id="input_step3_desc" rows="2" class="form-control" placeholder="Deskripsi ringkas..." required oninput="updateLivePreview()">{{ $settings['tatacara_3_desc'] ?? 'Lakukan pembayaran biaya formulir sesuai petunjuk yang tersedia.' }}</textarea>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-success"><i class="bi bi-4-circle me-1"></i> Langkah 4: Judul</label>
                    <input type="text" name="tatacara_4_judul" id="input_step4_title" class="form-control mb-2" value="{{ $settings['tatacara_4_judul'] ?? 'Unggah Berkas & Ikuti Seleksi' }}" placeholder="Judul Langkah 4" required oninput="updateLivePreview()">
                    <label class="form-label fw-semibold text-muted small">Deskripsi Ringkas</label>
                    <textarea name="tatacara_4_desc" id="input_step4_desc" rows="2" class="form-control" placeholder="Deskripsi ringkas..." required oninput="updateLivePreview()">{{ $settings['tatacara_4_desc'] ?? 'Kirim dokumen dan ikuti tahapan observasi kematangan sesuai jadwal.' }}</textarea>
                  </div>
                </div>
              </div>
            </div>

            <!-- Section 2: 7 Tahapan Lengkap di Halaman Tata Cara -->
            <div class="mb-4">
              <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                <h6 class="fw-bold text-dark mb-0">
                  <i class="bi bi-diagram-3 text-primary me-2"></i>2. Deskripsi 7 Langkah Alur Lengkap (Halaman /tata-cara)
                </h6>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Halaman Tata Cara</span>
              </div>

              <!-- Accordion Edit 7 Tahapan -->
              <div class="accordion" id="accordionStepsEdit">
                
                <!-- Tahap 1 -->
                <div class="accordion-item mb-2 border rounded-3 overflow-hidden">
                  <h2 class="accordion-header" id="headingStep1">
                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStep1" aria-expanded="false">
                      <span class="badge bg-primary rounded-pill me-2">1</span> Registrasi Akun Wali Murid
                    </button>
                  </h2>
                  <div id="collapseStep1" class="accordion-collapse collapse" data-bs-parent="#accordionStepsEdit">
                    <div class="accordion-body bg-light p-3">
                      <div class="mb-2">
                        <label class="form-label small fw-semibold">Judul Tahap 1</label>
                        <input type="text" name="tatacara_step1_judul" class="form-control form-control-sm" value="{{ $settings['tatacara_step1_judul'] ?? 'Registrasi Akun Wali Murid' }}">
                      </div>
                      <div>
                        <label class="form-label small fw-semibold">Deskripsi Penjelasan Tahap 1</label>
                        <textarea name="tatacara_step1_desc" rows="2" class="form-control form-control-sm">{{ $settings['tatacara_step1_desc'] ?? 'Wali murid mengakses menu pendaftaran akun baru dengan nama, email, nomor WhatsApp aktif, dan kata sandi pendaftaran.' }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Tahap 2 -->
                <div class="accordion-item mb-2 border rounded-3 overflow-hidden">
                  <h2 class="accordion-header" id="headingStep2">
                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStep2" aria-expanded="false">
                      <span class="badge bg-primary rounded-pill me-2">2</span> Pilih Jalur &amp; Gelombang Pendaftaran
                    </button>
                  </h2>
                  <div id="collapseStep2" class="accordion-collapse collapse" data-bs-parent="#accordionStepsEdit">
                    <div class="accordion-body bg-light p-3">
                      <div class="mb-2">
                        <label class="form-label small fw-semibold">Judul Tahap 2</label>
                        <input type="text" name="tatacara_step2_judul" class="form-control form-control-sm" value="{{ $settings['tatacara_step2_judul'] ?? 'Pilih Jalur & Gelombang Pendaftaran' }}">
                      </div>
                      <div>
                        <label class="form-label small fw-semibold">Deskripsi Penjelasan Tahap 2</label>
                        <textarea name="tatacara_step2_desc" rows="2" class="form-control form-control-sm">{{ $settings['tatacara_step2_desc'] ?? 'Tentukan jalur masuk yang tersedia: Jalur Reguler (calon siswa kelas 1), Jalur Prestasi (tahfidz/lomba), atau Siswa Pindahan (mutasi kelas II - V).' }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Tahap 3 -->
                <div class="accordion-item mb-2 border rounded-3 overflow-hidden">
                  <h2 class="accordion-header" id="headingStep3">
                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStep3" aria-expanded="false">
                      <span class="badge bg-primary rounded-pill me-2">3</span> Pembayaran Biaya Formulir Pendaftaran
                    </button>
                  </h2>
                  <div id="collapseStep3" class="accordion-collapse collapse" data-bs-parent="#accordionStepsEdit">
                    <div class="accordion-body bg-light p-3">
                      <div class="mb-2">
                        <label class="form-label small fw-semibold">Judul Tahap 3</label>
                        <input type="text" name="tatacara_step3_judul" class="form-control form-control-sm" value="{{ $settings['tatacara_step3_judul'] ?? 'Pembayaran Biaya Formulir Pendaftaran' }}">
                      </div>
                      <div>
                        <label class="form-label small fw-semibold">Deskripsi Penjelasan Tahap 3</label>
                        <textarea name="tatacara_step3_desc" rows="2" class="form-control form-control-sm">{{ $settings['tatacara_step3_desc'] ?? 'Membayar biaya formulir pendaftaran melalui transfer bank atau loket sekolah, lalu mengunggah bukti bayar di portal untuk divalidasi panitia.' }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Tahap 4 -->
                <div class="accordion-item mb-2 border rounded-3 overflow-hidden">
                  <h2 class="accordion-header" id="headingStep4">
                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStep4" aria-expanded="false">
                      <span class="badge bg-primary rounded-pill me-2">4</span> Pengisian Biodata Lengkap Calon Siswa
                    </button>
                  </h2>
                  <div id="collapseStep4" class="accordion-collapse collapse" data-bs-parent="#accordionStepsEdit">
                    <div class="accordion-body bg-light p-3">
                      <div class="mb-2">
                        <label class="form-label small fw-semibold">Judul Tahap 4</label>
                        <input type="text" name="tatacara_step4_judul" class="form-control form-control-sm" value="{{ $settings['tatacara_step4_judul'] ?? 'Pengisian Biodata Lengkap Calon Siswa' }}">
                      </div>
                      <div>
                        <label class="form-label small fw-semibold">Deskripsi Penjelasan Tahap 4</label>
                        <textarea name="tatacara_step4_desc" rows="2" class="form-control form-control-sm">{{ $settings['tatacara_step4_desc'] ?? 'Mengisi data diri calon siswa, identitas orang tua/wali, data tempat tinggal, dan kontak darurat secara akurat sesuai Kartu Keluarga (KK).' }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Tahap 5 -->
                <div class="accordion-item mb-2 border rounded-3 overflow-hidden">
                  <h2 class="accordion-header" id="headingStep5">
                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStep5" aria-expanded="false">
                      <span class="badge bg-primary rounded-pill me-2">5</span> Unggah Dokumen &amp; Berkas Persyaratan
                    </button>
                  </h2>
                  <div id="collapseStep5" class="accordion-collapse collapse" data-bs-parent="#accordionStepsEdit">
                    <div class="accordion-body bg-light p-3">
                      <div class="mb-2">
                        <label class="form-label small fw-semibold">Judul Tahap 5</label>
                        <input type="text" name="tatacara_step5_judul" class="form-control form-control-sm" value="{{ $settings['tatacara_step5_judul'] ?? 'Unggah Dokumen & Berkas Persyaratan' }}">
                      </div>
                      <div>
                        <label class="form-label small fw-semibold">Deskripsi Penjelasan Tahap 5</label>
                        <textarea name="tatacara_step5_desc" rows="2" class="form-control form-control-sm">{{ $settings['tatacara_step5_desc'] ?? 'Unggah berkas digital scan Akta Kelahiran, Kartu Keluarga, KTP Orang Tua, dan Pas Foto Berwarna latar belakang merah (maksimal 2MB per file).' }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Tahap 6 -->
                <div class="accordion-item mb-2 border rounded-3 overflow-hidden">
                  <h2 class="accordion-header" id="headingStep6">
                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStep6" aria-expanded="false">
                      <span class="badge bg-primary rounded-pill me-2">6</span> Observasi &amp; Tes Kesiapan Belajar
                    </button>
                  </h2>
                  <div id="collapseStep6" class="accordion-collapse collapse" data-bs-parent="#accordionStepsEdit">
                    <div class="accordion-body bg-light p-3">
                      <div class="mb-2">
                        <label class="form-label small fw-semibold">Judul Tahap 6</label>
                        <input type="text" name="tatacara_step6_judul" class="form-control form-control-sm" value="{{ $settings['tatacara_step6_judul'] ?? 'Observasi & Tes Kesiapan Belajar' }}">
                      </div>
                      <div>
                        <label class="form-label small fw-semibold">Deskripsi Penjelasan Tahap 6</label>
                        <textarea name="tatacara_step6_desc" rows="2" class="form-control form-control-sm">{{ $settings['tatacara_step6_desc'] ?? 'Calon siswa hadir bersama orang tua mengikuti observasi kematangan belajar, kesiapan motorik, dan tes baca Al-Qur\'an / Iqra sesuai jadwal.' }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Tahap 7 -->
                <div class="accordion-item border rounded-3 overflow-hidden">
                  <h2 class="accordion-header" id="headingStep7">
                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStep7" aria-expanded="false">
                      <span class="badge bg-primary rounded-pill me-2">7</span> Pengumuman Kelulusan &amp; Daftar Ulang
                    </button>
                  </h2>
                  <div id="collapseStep7" class="accordion-collapse collapse" data-bs-parent="#accordionStepsEdit">
                    <div class="accordion-body bg-light p-3">
                      <div class="mb-2">
                        <label class="form-label small fw-semibold">Judul Tahap 7</label>
                        <input type="text" name="tatacara_step7_judul" class="form-control form-control-sm" value="{{ $settings['tatacara_step7_judul'] ?? 'Pengumuman Kelulusan & Daftar Ulang' }}">
                      </div>
                      <div>
                        <label class="form-label small fw-semibold">Deskripsi Penjelasan Tahap 7</label>
                        <textarea name="tatacara_step7_desc" rows="2" class="form-control form-control-sm">{{ $settings['tatacara_step7_desc'] ?? 'Cek hasil kelulusan di portal, unduh Surat Keterangan Kelulusan resmi, penyelesaian uang pangkal, dan pengukuran seragam sekolah.' }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <!-- Section 3: Ketentuan Batas Usia -->
            <div class="mb-4">
              <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                <i class="bi bi-calendar-event text-warning me-2"></i>3. Ketentuan Batas Usia Calon Siswa (Permendikbud)
              </h6>
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label small fw-semibold">Usia Prioritas (7 Tahun)</label>
                  <input type="text" name="tatacara_usia_prioritas" class="form-control form-control-sm" value="{{ $settings['tatacara_usia_prioritas'] ?? '7 Tahun Penuh: Prioritas utama penerimaan tanpa tes kesiapan khusus.' }}">
                </div>
                <div class="col-md-4">
                  <label class="form-label small fw-semibold">Usia Standar (6 Tahun)</label>
                  <input type="text" name="tatacara_usia_standar" class="form-control form-control-sm" value="{{ $settings['tatacara_usia_standar'] ?? 'Minimal 6 Tahun: Genap per 1 Juli tahun pelajaran berjalan.' }}">
                </div>
                <div class="col-md-4">
                  <label class="form-label small fw-semibold">Usia Khusus (5.5 Tahun)</label>
                  <input type="text" name="tatacara_usia_khusus" class="form-control form-control-sm" value="{{ $settings['tatacara_usia_khusus'] ?? '5 Tahun 6 Bulan: Wajib rekomendasi tertulis dari psikolog/ahli.' }}">
                </div>
              </div>
            </div>

            <div class="pt-3 border-top d-flex align-items-center justify-content-between">
              <span class="text-muted small">
                <i class="bi bi-info-circle me-1"></i> Perubahan akan langsung tampil pada Homepage &amp; Halaman Tata Cara.
              </span>
              <button type="submit" class="btn btn-success fw-bold px-4 py-2 rounded-pill">
                <i class="bi bi-save me-1"></i> Simpan Pembaruan Tata Cara
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan: Live Interactive Visual Simulation Preview -->
    <div class="col-lg-5">
      <div class="sticky-top" style="top: 85px; z-index: 10;">

        <!-- Card Pratinjau Tampilan Homepage -->
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="card-title p-0 m-0 fw-bold text-dark">
              <i class="bi bi-eye text-primary me-2"></i>Simulasi Kartu di Homepage
            </h6>
            <span class="badge bg-light text-dark border">Live Preview</span>
          </div>

          <div class="card-body p-4 bg-light">

            <!-- Simulasi Kartu Tata Cara (Persis seperti yang ada di Homepage) -->
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white" style="border: 1px solid #e2e8f0 !important;">
              <h6 class="fw-bold mb-3 text-dark border-bottom pb-2" id="preview_tatacara_title" style="color: #035e38; font-size: 1.05rem;">
                {{ $settings['tatacara_judul'] ?? 'Tata Cara Pendaftaran Siswa Baru' }}
              </h6>

              <!-- Step Items -->
              <div class="d-flex flex-column gap-3 mb-3">
                <div class="d-flex align-items-start gap-2">
                  <span class="badge rounded-circle p-2 text-white bg-success d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.75rem;">1</span>
                  <div>
                    <strong class="d-block text-dark small" id="preview_step1_title">{{ $settings['tatacara_1_judul'] ?? 'Pilih Jalur Pendaftaran' }}</strong>
                    <span class="text-muted" style="font-size: 0.78rem;" id="preview_step1_desc">{{ $settings['tatacara_1_desc'] ?? 'Tentukan jalur masuk sesuai pilihan dan ketentuan sekolah.' }}</span>
                  </div>
                </div>

                <div class="d-flex align-items-start gap-2">
                  <span class="badge rounded-circle p-2 text-white bg-success d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.75rem;">2</span>
                  <div>
                    <strong class="d-block text-dark small" id="preview_step2_title">{{ $settings['tatacara_2_judul'] ?? 'Isi Formulir Pendaftaran' }}</strong>
                    <span class="text-muted" style="font-size: 0.78rem;" id="preview_step2_desc">{{ $settings['tatacara_2_desc'] ?? 'Lengkapi data diri calon siswa dan orang tua pada formulir online secara benar.' }}</span>
                  </div>
                </div>

                <div class="d-flex align-items-start gap-2">
                  <span class="badge rounded-circle p-2 text-white bg-success d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.75rem;">3</span>
                  <div>
                    <strong class="d-block text-dark small" id="preview_step3_title">{{ $settings['tatacara_3_judul'] ?? 'Bayar Biaya Pendaftaran' }}</strong>
                    <span class="text-muted" style="font-size: 0.78rem;" id="preview_step3_desc">{{ $settings['tatacara_3_desc'] ?? 'Lakukan pembayaran biaya formulir sesuai petunjuk yang tersedia.' }}</span>
                  </div>
                </div>

                <div class="d-flex align-items-start gap-2">
                  <span class="badge rounded-circle p-2 text-white bg-success d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.75rem;">4</span>
                  <div>
                    <strong class="d-block text-dark small" id="preview_step4_title">{{ $settings['tatacara_4_judul'] ?? 'Unggah Berkas & Ikuti Seleksi' }}</strong>
                    <span class="text-muted" style="font-size: 0.78rem;" id="preview_step4_desc">{{ $settings['tatacara_4_desc'] ?? 'Kirim dokumen dan ikuti tahapan observasi kematangan sesuai jadwal.' }}</span>
                  </div>
                </div>
              </div>

              <!-- Button CTA -->
              <div class="pt-3 border-top d-flex flex-column gap-2">
                <button type="button" class="btn btn-success btn-sm w-100 py-2 rounded-pill fw-bold" style="background-color: #05824e; border-color: #05824e;" disabled>
                  <i class="bi bi-pencil-square me-1"></i> Daftar Akun PPDB Sekarang
                </button>
                <button type="button" class="btn btn-outline-success btn-sm w-100 py-2 rounded-pill fw-semibold" disabled>
                  <i class="bi bi-journal-text me-1"></i> Lihat Alur &amp; Syarat Lengkap
                </button>
              </div>

            </div>

            <!-- Catatan Integrasi -->
            <div class="alert alert-info border-0 rounded-3 mt-3 mb-0 small">
              <i class="bi bi-info-circle-fill me-1 text-info"></i>
              <strong>Sinkronisasi Otomatis:</strong> Ketika Anda menekan tombol simpan, data di atas langsung memperbarui kartu ringkas di homepage serta halaman lengkap tata cara pendaftaran.
            </div>

          </div>
        </div>

        <!-- Info Hubungan dengan Master Persyaratan Dokumen -->
        <div class="card shadow-sm border-0">
          <div class="card-body p-4">
            <h6 class="fw-bold text-dark mb-2">
              <i class="bi bi-file-earmark-check text-success me-2"></i>Kelola Persyaratan Dokumen?
            </h6>
            <p class="small text-muted mb-3">
              Daftar fotokopi dokumen (Akta, KK, KTP, Foto, Surat Pindah, Rapor) yang ditampilkan pada tabel persyaratan di halaman tata cara dapat dikelola melalui menu master:
            </p>
            <a href="{{ route('persyaratan-dokumen.index') }}" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-semibold">
              <i class="bi bi-sliders me-1"></i> Buka Master Persyaratan Dokumen
            </a>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>

<script>
function updateLivePreview() {
  const judul = document.getElementById('input_tatacara_judul').value;
  if (judul) document.getElementById('preview_tatacara_title').innerText = judul;

  const s1Title = document.getElementById('input_step1_title').value;
  const s1Desc = document.getElementById('input_step1_desc').value;
  if (s1Title) document.getElementById('preview_step1_title').innerText = s1Title;
  if (s1Desc) document.getElementById('preview_step1_desc').innerText = s1Desc;

  const s2Title = document.getElementById('input_step2_title').value;
  const s2Desc = document.getElementById('input_step2_desc').value;
  if (s2Title) document.getElementById('preview_step2_title').innerText = s2Title;
  if (s2Desc) document.getElementById('preview_step2_desc').innerText = s2Desc;

  const s3Title = document.getElementById('input_step3_title').value;
  const s3Desc = document.getElementById('input_step3_desc').value;
  if (s3Title) document.getElementById('preview_step3_title').innerText = s3Title;
  if (s3Desc) document.getElementById('preview_step3_desc').innerText = s3Desc;

  const s4Title = document.getElementById('input_step4_title').value;
  const s4Desc = document.getElementById('input_step4_desc').value;
  if (s4Title) document.getElementById('preview_step4_title').innerText = s4Title;
  if (s4Desc) document.getElementById('preview_step4_desc').innerText = s4Desc;
}
</script>
@endsection
