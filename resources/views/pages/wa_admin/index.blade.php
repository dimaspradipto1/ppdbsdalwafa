@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Pengaturan WhatsApp Admin</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Homepage</li>
      <li class="breadcrumb-item active">Pengaturan WA Admin</li>
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

    <!-- Kolom Kiri: Form Konfigurasi WA Admin -->
    <div class="col-lg-7">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <div class="bg-success text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="bi bi-whatsapp"></i>
            </div>
            <div>
              <h6 class="card-title p-0 m-0 fw-bold text-dark">Formulir Kontak WhatsApp Admin & Panitia PPDB</h6>
              <small class="text-muted">Kelola nomor layanan, pesan pembuka, dan integrasi tombol chat di website</small>
            </div>
          </div>
        </div>

        <div class="card-body p-4">
          <form action="{{ route('wa-admin.update') }}" method="POST">
            @csrf

            <!-- Section 1: Nomor Kontak WhatsApp -->
            <div class="mb-4">
              <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                <i class="bi bi-telephone-forward text-success me-1"></i> Nomor Kontak WhatsApp
              </h6>

              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark">
                    Nomor WhatsApp Utama <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-light text-success fw-bold"><i class="bi bi-whatsapp"></i></span>
                    <input type="text" name="kontak_whatsapp" id="input_wa_utama" class="form-control" value="{{ old('kontak_whatsapp', $settings['kontak_whatsapp'] ?? '081266812015') }}" placeholder="Contoh: 081266812015 atau 6281266812015" required>
                  </div>
                  <div class="form-text">Bisa diawali 08... atau 628... (sistem otomatis menstandarkan untuk link wa.me).</div>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark">Nomor WhatsApp Cadangan</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-telephone-plus"></i></span>
                    <input type="text" name="kontak_whatsapp_2" class="form-control" value="{{ old('kontak_whatsapp_2', $settings['kontak_whatsapp_2'] ?? '082323222606') }}" placeholder="Contoh: 082323222606">
                  </div>
                  <div class="form-text">Nomor alternatif panitia untuk konsultasi pendaftaran.</div>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark">Nama Admin / CS WhatsApp</label>
                  <input type="text" name="wa_admin_nama" id="input_wa_nama" class="form-control" value="{{ old('wa_admin_nama', $settings['wa_admin_nama'] ?? 'Panitia PPDB SD Al-Wafa') }}" placeholder="Contoh: Panitia PPDB SD Al-Wafa">
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark">Jam Operasional Layanan Chat</label>
                  <input type="text" name="kontak_jam" class="form-control" value="{{ old('kontak_jam', $settings['kontak_jam'] ?? 'Senin – Sabtu : 07.30 – 15.00 WIB') }}" placeholder="Contoh: Senin – Sabtu : 07.30 – 15.00 WIB">
                </div>
              </div>
            </div>

            <!-- Section 2: Pesan Sambutan Otomatis -->
            <div class="mb-4">
              <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                <i class="bi bi-chat-dots text-success me-1"></i> Teks Pesan Otomatis (Greeting Message)
              </h6>

              <div class="mb-2">
                <label class="form-label fw-semibold text-dark">
                  Template Teks Chat Pertama Calon Wali Murid <span class="text-danger">*</span>
                </label>
                <textarea name="cta_wa_text" id="input_wa_text" class="form-control" rows="3" required placeholder="Tuliskan pesan salam pembuka yang otomatis muncul saat wali murid klik tombol WhatsApp">{{ old('cta_wa_text', $settings['cta_wa_text'] ?? 'Assalamu’alaikum Panitia PPDB SD Islam Plus Al-Wafa Batam, saya ingin bertanya seputar pendaftaran siswa baru') }}</textarea>
                <div class="form-text">Pesan ini akan otomatis terketik di kolom chat calon wali murid ketika membuka link WhatsApp.</div>
              </div>
            </div>

            <!-- Section 3: Banner Bantuan Hijau di Homepage -->
            <div class="mb-4">
              <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                <i class="bi bi-megaphone text-success me-1"></i> Teks Banner Bantuan Hijau ("Kami Siap Membantu Anda")
              </h6>

              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label fw-semibold text-dark">Judul Banner Bantuan <span class="text-danger">*</span></label>
                  <input type="text" name="cta_judul" class="form-control" value="{{ old('cta_judul', $settings['cta_judul'] ?? 'Kami Siap Membantu Anda') }}" required>
                </div>
                <div class="col-12">
                  <label class="form-label fw-semibold text-dark">Subjudul / Deskripsi Banner</label>
                  <textarea name="cta_subjudul" class="form-control" rows="2">{{ old('cta_subjudul', $settings['cta_subjudul'] ?? 'Apabila kamu memiliki kendala atau pertanyaan, silakan hubungi kami atau dapat juga membaca petunjuk pendaftaran terlebih dahulu.') }}</textarea>
                </div>
              </div>
            </div>

            <!-- Section 4: Pengaturan Tampilan Tombol -->
            <div class="mb-4">
              <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                <i class="bi bi-toggles text-success me-1"></i> Saklar Tampilan Tombol di Website
              </h6>

              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="floating_wa_active" id="floating_wa_active" value="1" {{ ($settings['floating_wa_active'] ?? '1') == '1' ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold text-dark" for="floating_wa_active">
                  Aktifkan Tombol Floating WhatsApp (Pojok Kanan Bawah Website)
                </label>
                <div class="text-muted small">Tombol melayang warna hijau di pojok kanan bawah yang selalu tampil saat pengunjung menggulir halaman.</div>
              </div>

              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="cta_wa_active" id="cta_wa_active" value="1" {{ ($settings['cta_wa_active'] ?? '1') == '1' ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold text-dark" for="cta_wa_active">
                  Aktifkan Tombol WhatsApp di Banner Bantuan Hijau Homepage
                </label>
                <div class="text-muted small">Menampilkan tombol "WhatsApp" berdampingan dengan "Petunjuk Pendaftaran" di banner bantuan hijau.</div>
              </div>
            </div>

            <div class="pt-3 border-top d-flex align-items-center justify-content-between">
              <a href="{{ route('homepage') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Homepage
              </a>
              <button type="submit" class="btn btn-success px-4 py-2 fw-semibold">
                <i class="bi bi-check2-circle me-1"></i> Simpan &amp; Sinkronkan Perubahan
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan: Live Mockup Chat WhatsApp & Status Integrasi -->
    <div class="col-lg-5">

      <!-- Live Mockup WhatsApp Card -->
      <div class="card shadow-sm border-0 mb-4 overflow-hidden" style="border-radius: 18px;">
        <div class="card-header text-white py-3 px-3 d-flex align-items-center justify-content-between" style="background: #075e54;">
          <div class="d-flex align-items-center gap-2">
            <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo" class="rounded-circle bg-white p-1" style="width: 40px; height: 40px; object-fit: contain;" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
            <div>
              <div class="fw-bold lh-1 text-white" id="preview_admin_nama" style="font-size: 0.95rem;">
                {{ $settings['wa_admin_nama'] ?? 'Panitia PPDB SD Al-Wafa' }}
              </div>
              <small class="text-white-50" style="font-size: 0.72rem;">
                <span class="badge bg-success p-1 rounded-circle d-inline-block me-1" style="width: 7px; height: 7px;"></span>
                Online &bull; <span id="preview_admin_nomor">{{ $settings['kontak_whatsapp'] ?? '081266812015' }}</span>
              </small>
            </div>
          </div>
          <span class="badge bg-white text-dark rounded-pill px-2 py-1" style="font-size: 0.7rem;">Live Mockup</span>
        </div>

        <div class="card-body p-3" style="background: #efeae2; min-height: 250px; background-image: radial-gradient(#d1d7db 1px, transparent 1px); background-size: 16px 16px;">
          <div class="text-center my-2">
            <span class="badge bg-white text-muted shadow-sm px-2 py-1 small fw-normal" style="font-size: 0.7rem; border-radius: 8px;">
              HARI INI
            </span>
          </div>

          <!-- Bubble Pesan Calon Wali Murid (Pesan Otomatis dari Web) -->
          <div class="d-flex justify-content-end mb-3">
            <div class="p-3 shadow-sm text-dark position-relative" style="background: #dcf8c6; border-radius: 12px 0 12px 12px; max-width: 85%; font-size: 0.88rem; line-height: 1.45;">
              <span id="preview_pesan_text">
                {{ $settings['cta_wa_text'] ?? 'Assalamu’alaikum Panitia PPDB SD Islam Plus Al-Wafa Batam, saya ingin bertanya seputar pendaftaran siswa baru' }}
              </span>
              <div class="text-end text-muted mt-1" style="font-size: 0.68rem;">
                {{ date('H:i') }} <i class="bi bi-check2-all text-primary"></i>
              </div>
            </div>
          </div>

          <!-- Bubble Balasan Otomatis Simulasi -->
          <div class="d-flex justify-content-start mb-2">
            <div class="p-3 shadow-sm text-dark position-relative bg-white" style="border-radius: 0 12px 12px 12px; max-width: 85%; font-size: 0.88rem; line-height: 1.45;">
              Wa’alaikumussalam Warahmatullahi Wabarakatuh. Selamat datang di Layanan Informasi PPDB SD Islam Plus Al-Wafa Batam. Ada yang dapat kami bantu?
              <div class="text-end text-muted mt-1" style="font-size: 0.68rem;">
                {{ date('H:i') }}
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer bg-white p-3 border-top">
          @php
            $rawWa = $settings['kontak_whatsapp'] ?? '081266812015';
            $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);
            if (str_starts_with($cleanWa, '0')) {
                $cleanWa = '62' . substr($cleanWa, 1);
            }
          @endphp
          <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode($settings['cta_wa_text'] ?? 'Assalamu’alaikum Panitia PPDB SD Islam Plus Al-Wafa Batam, saya ingin bertanya') }}" target="_blank" class="btn btn-success w-100 py-2 fw-semibold rounded-pill d-flex align-items-center justify-content-center gap-2" id="btn_test_wa">
            <i class="bi bi-whatsapp fs-5"></i>
            <span>Uji Coba Chat Langsung via WhatsApp</span>
          </a>
        </div>
      </div>

      <!-- Card Status Sinkronisasi Real-Time -->
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
          <h6 class="card-title p-0 m-0 fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-arrow-repeat text-success"></i> Status Integrasi di Website
          </h6>
        </div>
        <div class="card-body p-3">
          <ul class="list-group list-group-flush small">
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
              <div>
                <strong>Banner Bantuan Hijau ("Kami Siap Membantu Anda")</strong>
                <div class="text-muted" style="font-size: 0.78rem;">Tombol WhatsApp pada banner hijau di homepage</div>
              </div>
              <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                <i class="bi bi-check-lg me-1"></i> Aktif &amp; Terhubung
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
              <div>
                <strong>Floating Button WhatsApp</strong>
                <div class="text-muted" style="font-size: 0.78rem;">Tombol melayang di sudut kanan bawah semua halaman publik</div>
              </div>
              <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                <i class="bi bi-check-lg me-1"></i> Aktif &amp; Terhubung
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
              <div>
                <strong>Halaman Informasi &amp; Detail Pengumuman</strong>
                <div class="text-muted" style="font-size: 0.78rem;">Sidebar bantuan &amp; banner bantuan pada artikel pengumuman</div>
              </div>
              <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                <i class="bi bi-check-lg me-1"></i> Aktif &amp; Terhubung
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
              <div>
                <strong>Footer Kontak Website</strong>
                <div class="text-muted" style="font-size: 0.78rem;">Informasi kontak telepon &amp; WhatsApp resmi Al-Wafa</div>
              </div>
              <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                <i class="bi bi-check-lg me-1"></i> Aktif &amp; Terhubung
              </span>
            </li>
          </ul>
        </div>
      </div>

    </div>

  </div>
</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var inputNomor = document.getElementById('input_wa_utama');
    var inputNama = document.getElementById('input_wa_nama');
    var inputText = document.getElementById('input_wa_text');

    var prevNomor = document.getElementById('preview_admin_nomor');
    var prevNama = document.getElementById('preview_admin_nama');
    var prevText = document.getElementById('preview_pesan_text');
    var btnTest = document.getElementById('btn_test_wa');

    function updateLivePreview() {
      var nomorVal = inputNomor.value.trim();
      var namaVal = inputNama.value.trim();
      var textVal = inputText.value.trim();

      if (prevNomor) prevNomor.textContent = nomorVal || '081266812015';
      if (prevNama) prevNama.textContent = namaVal || 'Panitia PPDB SD Al-Wafa';
      if (prevText) prevText.textContent = textVal || 'Assalamu’alaikum Panitia PPDB SD Islam Plus Al-Wafa Batam...';

      // Update link WhatsApp
      var clean = nomorVal.replace(/[^0-9]/g, '');
      if (clean.startsWith('0')) {
        clean = '62' + clean.substring(1);
      }
      if (btnTest) {
        btnTest.href = 'https://wa.me/' + clean + '?text=' + encodeURIComponent(textVal);
      }
    }

    if (inputNomor) inputNomor.addEventListener('input', updateLivePreview);
    if (inputNama) inputNama.addEventListener('input', updateLivePreview);
    if (inputText) inputText.addEventListener('input', updateLivePreview);
  });
</script>
@endpush
@endsection
