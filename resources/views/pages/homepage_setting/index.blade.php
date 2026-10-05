@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Pengaturan Konten Homepage</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Homepage</li>
      <li class="breadcrumb-item active">Konten & Pengaturan</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle me-1"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title p-0 m-0 fw-bold text-dark">Kustomisasi Konten & Informasi Halaman Depan</h5>
            <small class="text-muted">Kelola hero banner, pencarian jalur, brosur, tata cara, dan kontak layanan PPDB</small>
          </div>
          <a href="{{ route('homepage') }}" target="_blank" class="btn btn-outline-success btn-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau Homepage
          </a>
        </div>
        <div class="card-body p-4">

          <form action="{{ route('homepage-setting.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nav Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered mb-4" id="settingTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-hero-btn" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button" role="tab">
                  <i class="bi bi-card-heading me-1"></i> Hero & Pencarian
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-brosur-btn" data-bs-toggle="tab" data-bs-target="#tab-brosur" type="button" role="tab">
                  <i class="bi bi-file-earmark-pdf me-1"></i> Brosur & Biaya
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-tatacara-btn" data-bs-toggle="tab" data-bs-target="#tab-tatacara" type="button" role="tab">
                  <i class="bi bi-list-ol me-1"></i> Tata Cara Pendaftaran
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-sambutan-btn" data-bs-toggle="tab" data-bs-target="#tab-sambutan" type="button" role="tab">
                  <i class="bi bi-person-workspace me-1"></i> Sambutan Kepala Sekolah
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-kontak-btn" data-bs-toggle="tab" data-bs-target="#tab-kontak" type="button" role="tab">
                  <i class="bi bi-geo-alt me-1"></i> Kontak & Bantuan
                </button>
              </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="settingTabContent">

              <!-- TAB 1: Hero & Pencarian -->
              <div class="tab-pane fade show active" id="tab-hero" role="tabpanel">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Judul Banner Utama (Hero Title)</label>
                    <input type="text" name="hero_judul" class="form-control" value="{{ $settings['hero_judul'] ?? 'Portal Pendaftaran Siswa Baru' }}" placeholder="Contoh: Portal Pendaftaran Siswa Baru">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Tag Slogan / Badge</label>
                    <input type="text" name="hero_badge" class="form-control" value="{{ $settings['hero_badge'] ?? '#SDIPAlWafaUnggul' }}" placeholder="#SDIPAlWafaUnggul">
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">Subjudul Banner (Hero Subtitle)</label>
                    <textarea name="hero_subjudul" rows="2" class="form-control">{{ $settings['hero_subjudul'] ?? 'Cari tahu informasi program kelas, rincian biaya sekolah, dan informasi pendaftaran di SD Islam Plus Al-Wafa Batam' }}</textarea>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">Teks Pengumuman Berjalan (Ticker Bar)</label>
                    <input type="text" name="pengumuman_headline" class="form-control" value="{{ $settings['pengumuman_headline'] ?? 'Penerimaan Peserta Didik Baru (PPDB) TP 2026/2027 SD Islam Plus Al-Wafa Resmi Dibuka!' }}">
                  </div>
                </div>
              </div>

              <!-- TAB 2: Brosur & Biaya -->
              <div class="tab-pane fade" id="tab-brosur" role="tabpanel">
                <div class="row g-4">

                  <!-- Alert Panduan Pengaturan Brosur -->
                  <div class="col-12">
                    <div class="card border-0" style="background: #f0fdf4; border: 1.5px solid #86efac !important; border-radius: 12px;">
                      <div class="card-body p-3">
                        <div class="d-flex align-items-center gap-3">
                          <div class="bg-success text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px; flex-shrink: 0;">
                            <i class="bi bi-file-earmark-pdf fs-4"></i>
                          </div>
                          <div>
                            <h6 class="fw-bold text-success mb-1">Pengaturan Brosur Resmi PPDB Al-Wafa</h6>
                            <p class="small text-muted mb-0">
                              Anda dapat menyediakan brosur sekolah melalui <strong>Upload Berkas Langsung (PDF/Gambar)</strong> ke server, ATAU mencantumkan <strong>Tautan / Link Online (Google Drive / Canva)</strong>. Tombol "Unduh Brosur" di website akan otomatis disinkronkan.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Judul & Deskripsi Brosur -->
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-dark">Judul Brosur</label>
                    <input type="text" name="brosur_judul" id="input_brosur_judul" class="form-control" value="{{ $settings['brosur_judul'] ?? 'Brosur Resmi PPDB Al-Wafa' }}" placeholder="Contoh: Brosur Resmi PPDB Al-Wafa">
                    <div class="form-text">Judul yang tertera pada kartu brosur di halaman website.</div>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label fw-bold text-dark">Catatan Kebijakan Pembayaran / Angsuran</label>
                    <input type="text" name="biaya_catatan" class="form-control" value="{{ $settings['biaya_catatan'] ?? 'Pembayaran biaya masuk dapat diangsur secara fleksibel sesuai kesepakatan saat wawancara keuangan.' }}" placeholder="Kebijakan cicilan / angsuran uang masuk">
                    <div class="form-text">Ditampilkan pada kotak informasi kebijakan di bawah tabel rincian biaya.</div>
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-bold text-dark">Deskripsi Ringkas Brosur</label>
                    <textarea name="brosur_deskripsi" id="input_brosur_desc" rows="2" class="form-control" placeholder="Tuliskan gambaran ringkas isi brosur...">{{ $settings['brosur_deskripsi'] ?? 'Unduh dokumen brosur cetak berisi profil sekolah, keunggulan program tahfidz Qur’an, fasilitas belajar smart class, dan rincian lengkap biaya pendidikan.' }}</textarea>
                  </div>

                  <!-- Kolom Kiri: OPSI 1 (Upload File) -->
                  <div class="col-md-6">
                    <div class="card h-100 border" style="border-radius: 12px;">
                      <div class="card-header bg-white py-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge bg-primary rounded-pill px-2 py-1">Opsi 1</span>
                          <strong class="text-dark">Upload Berkas Brosur (PDF / Gambar)</strong>
                        </div>
                      </div>
                      <div class="card-body">
                        @if(!empty($settings['brosur_file']))
                          <div class="p-3 mb-3 bg-light rounded border">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                              <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-3"></i>
                                <div>
                                  <div class="small fw-bold text-dark">Berkas Brosur Aktif Saat Ini:</div>
                                  <div class="small text-muted text-break" style="font-size: 0.8rem;">{{ basename($settings['brosur_file']) }}</div>
                                </div>
                              </div>
                              <a href="{{ asset($settings['brosur_file']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Buka File
                              </a>
                            </div>
                            <div class="form-check mt-3 pt-2 border-top">
                              <input class="form-check-input" type="checkbox" name="hapus_brosur_file" value="1" id="hapus_brosur">
                              <label class="form-check-label small text-danger fw-semibold" for="hapus_brosur">
                                <i class="bi bi-trash me-1"></i> Hapus berkas brosur ini (jika hanya ingin menggunakan link online)
                              </label>
                            </div>
                          </div>
                        @else
                          <div class="p-3 mb-3 bg-light rounded border text-muted small text-center">
                            <i class="bi bi-cloud-slash fs-4 d-block mb-1 text-secondary"></i>
                            Belum ada berkas brosur yang diunggah ke server.
                          </div>
                        @endif

                        <label class="form-label fw-semibold text-dark">Unggah / Ganti Berkas Brosur</label>
                        <input type="file" name="brosur_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text">Format yang didukung: <strong>PDF, JPG, PNG</strong> (Ukuran maksimal: 10 MB).</div>
                      </div>
                    </div>
                  </div>

                  <!-- Kolom Kanan: OPSI 2 (Link / URL Online) -->
                  <div class="col-md-6">
                    <div class="card h-100 border" style="border-radius: 12px;">
                      <div class="card-header bg-white py-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge bg-success rounded-pill px-2 py-1">Opsi 2</span>
                          <strong class="text-dark">Tautan / Link Brosur Online (Google Drive, Canva, dll)</strong>
                        </div>
                      </div>
                      <div class="card-body">
                        <p class="small text-muted mb-3">
                          Sangat berguna jika berkas brosur disimpan di <strong>Google Drive</strong>, Canva, Dropbox, atau Cloud Storage sekolah agar calon wali murid bisa langsung membaca atau mengunduh dari tautan tersebut.
                        </p>

                        <label class="form-label fw-semibold text-dark">Link / URL Brosur Online</label>
                        <div class="input-group mb-2">
                          <span class="input-group-text bg-white"><i class="bi bi-link-45deg text-success"></i></span>
                          <input type="url" name="brosur_link" id="input_brosur_link" class="form-control" value="{{ $settings['brosur_link'] ?? '' }}" placeholder="https://drive.google.com/file/d/.../view?usp=sharing">
                        </div>
                        <div class="form-text mb-3">
                          Pastikan hak akses tautan Google Drive disetel ke <strong>"Siapa saja yang memiliki link dapat melihat"</strong>.
                        </div>

                        @if(!empty($settings['brosur_link']))
                          <a href="{{ $settings['brosur_link'] }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Uji Buka Tautan Brosur Saat Ini
                          </a>
                        @endif
                      </div>
                    </div>
                  </div>

                  <!-- Preview Visual Kartu Brosur -->
                  <div class="col-12 mt-3">
                    <label class="form-label fw-bold text-dark d-block">
                      <i class="bi bi-eye me-1"></i> Simulasi Tampilan Kartu Brosur di Halaman Depan &amp; Biaya
                    </label>
                    <div class="p-4 rounded-4" style="background: linear-gradient(145deg, #05824e 0%, #035e38 100%); color: #fff; max-width: 550px;">
                      <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-white text-success rounded-3 p-3 fs-3 d-inline-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                          <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <div>
                          <h6 class="fw-bold text-white mb-0">{{ $settings['brosur_judul'] ?? 'Brosur Resmi PPDB Al-Wafa' }}</h6>
                          <small class="text-white-50">Tahun Pelajaran Aktif</small>
                        </div>
                      </div>
                      <p class="small text-white-50 mb-3" style="font-size: 0.85rem; line-height: 1.5;">
                        {{ $settings['brosur_deskripsi'] ?? 'Unduh dokumen brosur cetak berisi profil sekolah, keunggulan program tahfidz Qur’an, fasilitas belajar smart class, dan rincian lengkap biaya pendidikan.' }}
                      </p>
                      <button type="button" class="btn btn-warning w-100 py-2 fw-bold rounded-pill text-dark d-flex align-items-center justify-content-center gap-2" style="font-size: 0.9rem;" disabled>
                        <i class="bi bi-download"></i> Unduh Brosur Sekolah
                      </button>
                    </div>
                  </div>

                </div>
              </div>

              <!-- TAB 3: Tata Cara Pendaftaran -->
              <div class="tab-pane fade" id="tab-tatacara" role="tabpanel">
                <div class="row g-3">
                  <div class="col-12">
                    <div class="alert alert-info small mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                      <div>
                        <i class="bi bi-info-circle me-1"></i> Bagian ini ditampilkan di kolom kanan pada kartu <strong>Tata Cara Pendaftaran Siswa Baru</strong> di halaman depan.
                      </div>
                      <a href="{{ route('tatacara-setting.index') }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold">
                        <i class="bi bi-journal-text me-1"></i> Buka Menu Khusus Kelola Tata Cara PPDB &rarr;
                      </a>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Langkah 1: Judul & Deskripsi</label>
                    <input type="text" name="tatacara_1_judul" class="form-control mb-1" value="{{ $settings['tatacara_1_judul'] ?? 'Pilih Jalur Pendaftaran' }}" placeholder="Judul Langkah 1">
                    <textarea name="tatacara_1_desc" rows="2" class="form-control" placeholder="Deskripsi ringkas">{{ $settings['tatacara_1_desc'] ?? 'Tentukan jalur masuk sesuai pilihan dan ketentuan sekolah.' }}</textarea>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Langkah 2: Judul & Deskripsi</label>
                    <input type="text" name="tatacara_2_judul" class="form-control mb-1" value="{{ $settings['tatacara_2_judul'] ?? 'Isi Formulir Pendaftaran' }}" placeholder="Judul Langkah 2">
                    <textarea name="tatacara_2_desc" rows="2" class="form-control" placeholder="Deskripsi ringkas">{{ $settings['tatacara_2_desc'] ?? 'Lengkapi data diri calon siswa dan orang tua pada formulir online secara benar.' }}</textarea>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Langkah 3: Judul & Deskripsi</label>
                    <input type="text" name="tatacara_3_judul" class="form-control mb-1" value="{{ $settings['tatacara_3_judul'] ?? 'Bayar Biaya Pendaftaran' }}" placeholder="Judul Langkah 3">
                    <textarea name="tatacara_3_desc" rows="2" class="form-control" placeholder="Deskripsi ringkas">{{ $settings['tatacara_3_desc'] ?? 'Lakukan pembayaran biaya formulir sesuai petunjuk yang tersedia.' }}</textarea>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Langkah 4: Judul & Deskripsi</label>
                    <input type="text" name="tatacara_4_judul" class="form-control mb-1" value="{{ $settings['tatacara_4_judul'] ?? 'Unggah Berkas & Ikuti Seleksi' }}" placeholder="Judul Langkah 4">
                    <textarea name="tatacara_4_desc" rows="2" class="form-control" placeholder="Deskripsi ringkas">{{ $settings['tatacara_4_desc'] ?? 'Kirim dokumen dan ikuti tahapan observasi kematangan sesuai jadwal.' }}</textarea>
                  </div>
                </div>
              </div>

              <!-- TAB 4: Sambutan Kepala Sekolah -->
              <div class="tab-pane fade" id="tab-sambutan" role="tabpanel">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Kepala Sekolah</label>
                    <input type="text" name="sambutan_nama" class="form-control" value="{{ $settings['sambutan_nama'] ?? 'Ririn Kartika Sari Dalimunthe, S.Pd.I' }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">NUPTK Kepala Sekolah</label>
                    <input type="text" name="sambutan_nuptk" class="form-control" value="{{ $settings['sambutan_nuptk'] ?? '3552767669130143' }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Jabatan / Gelar</label>
                    <input type="text" name="sambutan_jabatan" class="form-control" value="{{ $settings['sambutan_jabatan'] ?? 'Kepala Sekolah SD Islam Plus Al-Wafa Batam' }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Foto Kepala Sekolah (Opsional)</label>
                    @if(!empty($settings['sambutan_foto']))
                      <div class="mb-2">
                        <img src="{{ asset($settings['sambutan_foto']) }}" alt="Foto Kepala Sekolah" class="rounded border" style="max-height: 80px;">
                      </div>
                    @endif
                    <input type="file" name="sambutan_foto" class="form-control" accept="image/*">
                    <div class="form-text">Format: JPG, PNG, WEBP (Max 2MB).</div>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">Teks Sambutan</label>
                    <textarea name="sambutan_teks" rows="5" class="form-control">{{ $settings['sambutan_teks'] ?? "Assalamu’alaikum Warahmatullahi Wabarakatuh.\n\nSelamat datang di portal resmi PPDB SD Islam Plus Al-Wafa Batam. Kami mendedikasikan diri untuk membina ananda menjadi generasi penerus yang teguh memegang Al-Qur'an dan As-Sunnah, berakhlakul karimah, berkarakter mulia, serta siap menghadapi tantangan masa depan dengan kecakapan digital dan wawasan global." }}</textarea>
                  </div>
                </div>
              </div>

              <!-- TAB 5: Kontak & Bantuan / Pengaturan WA Admin -->
              <div class="tab-pane fade" id="tab-kontak" role="tabpanel">
                
                <!-- Highlight Box Pengaturan WhatsApp Admin -->
                <div class="card border-0 mb-4" style="background: #f0fdf4; border: 1.5px solid #bbf7d0 !important; border-radius: 14px;">
                  <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                      <div class="d-flex align-items-center gap-2">
                        <div class="bg-success text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                          <i class="bi bi-whatsapp fs-5"></i>
                        </div>
                        <div>
                          <h6 class="fw-bold text-success mb-0">Integrasi WhatsApp Layanan PPDB & Bantuan</h6>
                          <small class="text-muted">Nomor ini langsung disinkronkan ke Floating Button, Tombol Bantuan Banner Hijau, dan Footer Website</small>
                        </div>
                      </div>
                      <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">
                        <i class="bi bi-arrow-repeat me-1"></i> Sync Aktif ke Homepage
                      </span>
                    </div>

                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label fw-bold text-dark">
                          Nomor WhatsApp Admin Utama <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                          <span class="input-group-text bg-white"><i class="bi bi-whatsapp text-success"></i></span>
                          <input type="text" name="kontak_whatsapp" id="input_wa_utama" class="form-control" value="{{ $settings['kontak_whatsapp'] ?? '081266812015' }}" placeholder="Contoh: 081266812015 atau 6281266812015" required>
                        </div>
                        <div class="form-text">Bisa menggunakan awalan 08... atau 628... (sistem otomatis menstandarkan ke tautan internasional 62...).</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label fw-bold text-dark">Nomor WhatsApp Cadangan (Opsional)</label>
                        <div class="input-group">
                          <span class="input-group-text bg-white"><i class="bi bi-telephone-plus text-success"></i></span>
                          <input type="text" name="kontak_whatsapp_2" class="form-control" value="{{ $settings['kontak_whatsapp_2'] ?? '082323222606' }}" placeholder="Contoh: 082323222606">
                        </div>
                        <div class="form-text">Nomor kontak alternatif panitia untuk konsultasi pendaftaran.</div>
                      </div>

                      <div class="col-12">
                        <label class="form-label fw-bold text-dark">Teks Pesan Awal Chat WhatsApp (Default Greetings)</label>
                        <textarea name="cta_wa_text" class="form-control" rows="2" placeholder="Teks template salam awal ketika calon wali murid mengklik tombol WhatsApp di website">{{ $settings['cta_wa_text'] ?? 'Assalamu’alaikum Panitia PPDB SD Islam Plus Al-Wafa Batam, saya ingin bertanya seputar pendaftaran siswa baru' }}</textarea>
                        <div class="form-text">Pesan otomatis yang akan langsung terisi di ruang chat WhatsApp saat orang tua mengklik tombol.</div>
                      </div>

                      @php
                        $rawTestWa = $settings['kontak_whatsapp'] ?? '081266812015';
                        $cleanTestWa = preg_replace('/[^0-9]/', '', $rawTestWa);
                        if (str_starts_with($cleanTestWa, '0')) {
                            $cleanTestWa = '62' . substr($cleanTestWa, 1);
                        }
                      @endphp
                      <div class="col-12 mt-2">
                        <div class="d-flex align-items-center gap-2">
                          <span class="small text-muted fw-semibold">Uji Coba Tautan:</span>
                          <a href="https://wa.me/{{ $cleanTestWa }}?text={{ urlencode($settings['cta_wa_text'] ?? 'Assalamu’alaikum Panitia PPDB SD Islam Plus Al-Wafa Batam, saya ingin bertanya') }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Buka Chat WA Sekarang ({{ $settings['kontak_whatsapp'] ?? '081266812015' }})
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Judul Banner Bantuan (CTA)</label>
                    <input type="text" name="cta_judul" class="form-control" value="{{ $settings['cta_judul'] ?? 'Kami Siap Membantu Anda' }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Subjudul Banner Bantuan</label>
                    <input type="text" name="cta_subjudul" class="form-control" value="{{ $settings['cta_subjudul'] ?? 'Apabila kamu memiliki kendala atau pertanyaan, silakan hubungi kami atau dapat juga membaca petunjuk pendaftaran terlebih dahulu.' }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Nomor Telepon Kantor (Fix Line)</label>
                    <input type="text" name="kontak_telepon" class="form-control" value="{{ $settings['kontak_telepon'] ?? '0778 7495940' }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Email Resmi Sekolah</label>
                    <input type="email" name="kontak_email" class="form-control" value="{{ $settings['kontak_email'] ?? 'sdipalwafa@gmail.com' }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Jam Layanan PPDB</label>
                    <input type="text" name="kontak_jam" class="form-control" value="{{ $settings['kontak_jam'] ?? 'Senin – Sabtu : 07.30 – 15.00 WIB' }}">
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">Alamat Lengkap</label>
                    <textarea name="kontak_alamat" rows="2" class="form-control">{{ $settings['kontak_alamat'] ?? 'Bida Asri II Blok G2 No. 11 - 15 Kel. Belian, Kec. Batam Kota, Kota Batam - Indonesia' }}</textarea>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">NPSN</label>
                    <input type="text" name="npsn" class="form-control" value="{{ $settings['npsn'] ?? '69888848' }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Izin Diknas</label>
                    <input type="text" name="izin_diknas" class="form-control" value="{{ $settings['izin_diknas'] ?? 'No. 21/421.3/DIKDAS/I/2015' }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Nama Yayasan</label>
                    <input type="text" name="yayasan" class="form-control" value="{{ $settings['yayasan'] ?? 'Yayasan Daarul Aitam Batam' }}">
                  </div>
                </div>
              </div>

            </div><!-- End Tab Content -->

            <div class="mt-4 pt-3 border-top text-end">
              <button type="submit" class="btn btn-success px-4 py-2 fw-semibold">
                <i class="bi bi-save me-1"></i> Simpan Semua Perubahan
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Otomatis aktifkan tab berdasarkan hash URL (misal #tab-brosur, #tab-kontak, dll)
    var hash = window.location.hash;
    if (hash) {
      if (!hash.startsWith('#tab-')) {
        hash = '#tab-' + hash.replace('#', '');
      }
      var targetBtn = document.querySelector('button[data-bs-target="' + hash + '"]');
      if (targetBtn) {
        var tab = new bootstrap.Tab(targetBtn);
        tab.show();
      }
    }
  });
</script>
@endpush
@endsection
