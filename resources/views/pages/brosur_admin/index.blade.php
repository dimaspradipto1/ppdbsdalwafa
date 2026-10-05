@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Kelola Brosur PPDB &amp; Link Drive</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Homepage</li>
      <li class="breadcrumb-item active">Kelola Brosur</li>
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

    @php
      $fileBrosur = !empty($settings['brosur_file']) ? asset($settings['brosur_file']) : ($activeBrosurFile ? asset($activeBrosurFile) : null);
      $linkDrive = $settings['brosur_link'] ?? null;
      $hasFile = !empty($settings['brosur_file']) || !empty($activeBrosurFile);
      $hasDrive = !empty($linkDrive);
    @endphp

    <!-- Kolom Kiri: Form Upload & Link Drive -->
    <div class="col-lg-7">
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <div class="bg-danger text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="bi bi-file-earmark-pdf"></i>
            </div>
            <div>
              <h6 class="card-title p-0 m-0 fw-bold text-dark">Formulir Upload Brosur &amp; Tautan Drive</h6>
              <small class="text-muted">Kelola dokumen brosur agar calon wali murid bisa langsung unduh atau melihatnya</small>
            </div>
          </div>
        </div>

        <div class="card-body p-4">
          <form action="{{ route('brosur-setting.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Section 1: Informasi Judul & Deskripsi -->
            <div class="mb-4">
              <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                <i class="bi bi-card-text text-primary me-2"></i>1. Informasi Brosur di Website
              </h6>

              <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Judul Brosur</label>
                <input type="text" name="brosur_judul" class="form-control" value="{{ $settings['brosur_judul'] ?? 'Brosur Resmi PPDB Al-Wafa' }}" placeholder="Contoh: Brosur Resmi PPDB Al-Wafa" required>
                <div class="form-text">Judul yang muncul di kartu brosur halaman depan dan halaman rincian biaya.</div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Deskripsi Ringkas Brosur</label>
                <textarea name="brosur_deskripsi" rows="2" class="form-control" placeholder="Tuliskan keterangan brosur...">{{ $settings['brosur_deskripsi'] ?? 'Unduh dokumen brosur cetak berisi profil sekolah, keunggulan program tahfidz Qur’an, fasilitas belajar smart class, dan rincian lengkap biaya pendidikan.' }}</textarea>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Catatan Kebijakan Pembayaran / Angsuran</label>
                <input type="text" name="biaya_catatan" class="form-control" value="{{ $settings['biaya_catatan'] ?? 'Pembayaran biaya masuk dapat diangsur secara fleksibel sesuai kesepakatan saat wawancara keuangan.' }}" placeholder="Catatan opsi cicilan / keringanan biaya">
              </div>
            </div>

            <!-- Section 2: Upload File Dokumen Brosur -->
            <div class="mb-4">
              <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                <i class="bi bi-cloud-arrow-up text-danger me-2"></i>2. Upload Berkas Brosur (PDF / Gambar)
              </h6>

              @if(!empty($settings['brosur_file']))
                <div class="p-3 mb-3 bg-light rounded border">
                  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-file-earmark-pdf-fill text-danger fs-3"></i>
                      <div>
                        <div class="small fw-bold text-dark">Berkas Brosur Khusus yang Aktif:</div>
                        <div class="small text-muted text-break" style="font-size: 0.8rem;">{{ basename($settings['brosur_file']) }}</div>
                      </div>
                    </div>
                    <div class="d-flex gap-2">
                      <a href="{{ asset($settings['brosur_file']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye me-1"></i> Lihat Berkas
                      </a>
                      <a href="{{ asset($settings['brosur_file']) }}" download class="btn btn-sm btn-primary">
                        <i class="bi bi-download me-1"></i> Unduh
                      </a>
                    </div>
                  </div>
                  <div class="form-check mt-3 pt-2 border-top">
                    <input class="form-check-input" type="checkbox" name="hapus_brosur_file" value="1" id="hapus_file">
                    <label class="form-check-label small text-danger fw-semibold" for="hapus_file">
                      <i class="bi bi-trash me-1"></i> Hapus berkas ini (kembali ke brosur default atau gunakan Link Drive saja)
                    </label>
                  </div>
                </div>
              @elseif(!empty($activeBrosurFile))
                <div class="p-3 mb-3 bg-light rounded border">
                  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-file-earmark-pdf-fill text-success fs-3"></i>
                      <div>
                        <div class="small fw-bold text-dark">Berkas Brosur Standar Sekolah:</div>
                        <div class="small text-muted" style="font-size: 0.8rem;">brosur-ppdb-alwafa.pdf (Tersedia untuk diunduh / dilihat)</div>
                      </div>
                    </div>
                    <div class="d-flex gap-2">
                      <a href="{{ asset($activeBrosurFile) }}" target="_blank" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-eye me-1"></i> Lihat Berkas
                      </a>
                      <a href="{{ asset($activeBrosurFile) }}" download class="btn btn-sm btn-success">
                        <i class="bi bi-download me-1"></i> Unduh
                      </a>
                    </div>
                  </div>
                </div>
              @endif

              <label class="form-label fw-semibold text-dark">Pilih File Brosur Baru</label>
              <input type="file" name="brosur_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
              <div class="form-text">Mendukung format: <strong>PDF, JPG, PNG</strong> (Ukuran maksimal: 15 MB).</div>
            </div>

            <!-- Section 3: Link Google Drive (Opsional) -->
            <div class="mb-4">
              <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                <i class="bi bi-google text-success me-2"></i>3. Tautan / Link Google Drive (Opsional)
              </h6>

              <p class="small text-muted mb-2">
                Jika berkas brosur Anda berukuran besar atau disimpan di <strong>Google Drive</strong>, Anda cukup menempelkan tautan share link di bawah ini. Calon pendaftar bisa langsung membuka atau mengunduhnya dari Google Drive.
              </p>

              <label class="form-label fw-semibold text-dark">Link URL Google Drive</label>
              <div class="input-group mb-2">
                <span class="input-group-text bg-white"><i class="bi bi-link-45deg text-success fs-5"></i></span>
                <input type="url" name="brosur_link" class="form-control" value="{{ $linkDrive }}" placeholder="https://drive.google.com/file/d/xxxx/view?usp=sharing">
              </div>
              <div class="form-text mb-3">
                Tips: Pastikan setelan berbagi di Google Drive diatur ke: <strong>"Siapa saja yang memiliki link ini dapat melihat (Viewer)"</strong>.
              </div>

              @if($hasDrive)
                <div class="d-flex align-items-center gap-2">
                  <a href="{{ $linkDrive }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Uji Buka Link Google Drive
                  </a>
                </div>
              @endif
            </div>

            <div class="pt-3 border-top text-end">
              <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                <i class="bi bi-save me-1"></i> Simpan Pembaruan Brosur
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan: Status & Live Preview -->
    <div class="col-lg-5">

      <!-- Card Status Ketersediaan Brosur -->
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
          <h6 class="card-title p-0 m-0 fw-bold text-dark">
            <i class="bi bi-check2-circle text-success me-1"></i> Status Ketersediaan Brosur
          </h6>
        </div>
        <div class="card-body p-4">
          <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
              <span><i class="bi bi-file-earmark-pdf text-danger me-2"></i>Berkas Brosur File (PDF)</span>
              @if($hasFile)
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                  <i class="bi bi-check-lg me-1"></i> Aktif Siap Unduh
                </span>
              @else
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1">
                  Belum Diunggah
                </span>
              @endif
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
              <span><i class="bi bi-google text-success me-2"></i>Link Google Drive</span>
              @if($hasDrive)
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                  <i class="bi bi-check-lg me-1"></i> Tersedia
                </span>
              @else
                <span class="badge bg-light text-muted border rounded-pill px-3 py-1">
                  Tidak Diisi (Opsional)
                </span>
              @endif
            </li>
          </ul>

          <div class="d-grid gap-2">
            @if($fileBrosur)
              <a href="{{ $fileBrosur }}" target="_blank" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-eye me-1"></i> View / Tampilkan Brosur Sekarang
              </a>
              <a href="{{ $fileBrosur }}" download class="btn btn-outline-success btn-sm">
                <i class="bi bi-download me-1"></i> Download Berkas Brosur
              </a>
            @endif
            @if($hasDrive)
              <a href="{{ $linkDrive }}" target="_blank" class="btn btn-outline-dark btn-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Buka di Google Drive
              </a>
            @endif
          </div>
        </div>
      </div>

      <!-- Live Preview Kartu di Halaman Publik -->
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
          <h6 class="card-title p-0 m-0 fw-bold text-dark">
            <i class="bi bi-eye text-primary me-1"></i> Tampilan di Halaman Depan &amp; Biaya
          </h6>
        </div>
        <div class="card-body p-4">
          <div class="p-4 rounded-4" style="background: linear-gradient(145deg, #05824e 0%, #035e38 100%); color: #ffffff;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="bg-white text-success rounded-3 p-3 fs-3 d-inline-flex align-items-center justify-content-center" style="width: 52px; height: 52px; flex-shrink: 0;">
                <i class="bi bi-file-earmark-pdf"></i>
              </div>
              <div>
                <h6 class="fw-bold text-white mb-0">{{ $settings['brosur_judul'] ?? 'Brosur Resmi PPDB Al-Wafa' }}</h6>
                <small class="text-white-50">Tahun Pelajaran 2026/2027</small>
              </div>
            </div>

            <p class="small text-white-50 mb-3" style="font-size: 0.84rem; line-height: 1.5;">
              {{ $settings['brosur_deskripsi'] ?? 'Unduh dokumen brosur cetak berisi profil sekolah, keunggulan program tahfidz Qur’an, fasilitas belajar smart class, dan rincian lengkap biaya pendidikan.' }}
            </p>

            <div class="d-grid gap-2">
              @if($fileBrosur)
                <div class="d-flex gap-2">
                  <a href="{{ $fileBrosur }}" target="_blank" class="btn btn-light fw-bold flex-grow-1 text-dark d-flex align-items-center justify-content-center gap-1" style="font-size: 0.88rem; border-radius: 50px;">
                    <i class="bi bi-eye"></i> Lihat Brosur
                  </a>
                  <a href="{{ $fileBrosur }}" download class="btn btn-warning fw-bold flex-grow-1 text-dark d-flex align-items-center justify-content-center gap-1" style="font-size: 0.88rem; border-radius: 50px;">
                    <i class="bi bi-download"></i> Download PDF
                  </a>
                </div>
              @endif

              @if($hasDrive)
                <a href="{{ $linkDrive }}" target="_blank" class="btn btn-outline-light btn-sm fw-semibold rounded-pill d-flex align-items-center justify-content-center gap-2">
                  <i class="bi bi-google"></i> Buka di Google Drive
                </a>
              @endif
            </div>

          </div>
          <div class="form-text text-center mt-2 small text-muted">
            Calon wali murid langsung bisa men-download atau melihat berkas tanpa diarahkan ke WhatsApp.
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
@endsection
