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
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Judul Kartu Brosur</label>
                    <input type="text" name="brosur_judul" class="form-control" value="{{ $settings['brosur_judul'] ?? 'Brosur Dan Informasi Biaya' }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Upload File Brosur PDF</label>
                    @if(!empty($settings['brosur_file']))
                      <div class="mb-2">
                        <a href="{{ asset($settings['brosur_file']) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                          <i class="bi bi-file-pdf me-1"></i> Unduh File Brosur Saat Ini
                        </a>
                      </div>
                    @endif
                    <input type="file" name="brosur_file" class="form-control" accept=".pdf,.jpg,.png">
                    <div class="form-text">Format: PDF, JPG, PNG (Max 5MB).</div>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">Deskripsi Brosur</label>
                    <textarea name="brosur_deskripsi" rows="2" class="form-control">{{ $settings['brosur_deskripsi'] ?? 'Brosur dan rincian biaya selama bersekolah di SD Islam Plus Al-Wafa Batam' }}</textarea>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">Catatan Kebijakan Pembayaran / Angsuran</label>
                    <input type="text" name="biaya_catatan" class="form-control" value="{{ $settings['biaya_catatan'] ?? 'Pembayaran biaya masuk dapat diangsur secara fleksibel sesuai kesepakatan saat wawancara keuangan.' }}">
                  </div>
                </div>
              </div>

              <!-- TAB 3: Tata Cara Pendaftaran -->
              <div class="tab-pane fade" id="tab-tatacara" role="tabpanel">
                <div class="row g-3">
                  <div class="col-12">
                    <div class="alert alert-info small mb-3">
                      <i class="bi bi-info-circle me-1"></i> Bagian ini ditampilkan di kolom kanan pada kartu <strong>Tata Cara Pendaftaran Siswa Baru</strong> di halaman depan.
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

              <!-- TAB 5: Kontak & Bantuan -->
              <div class="tab-pane fade" id="tab-kontak" role="tabpanel">
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
                    <label class="form-label fw-semibold">Nomor WhatsApp Utama</label>
                    <input type="text" name="kontak_whatsapp" class="form-control" value="{{ $settings['kontak_whatsapp'] ?? '081266812015' }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Nomor Telepon Kantor</label>
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
@endsection
