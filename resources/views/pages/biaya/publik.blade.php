<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Brosur &amp; Rincian Biaya Pendidikan &mdash; SD Islam Plus Al-Wafa Batam</title>
<meta name="description" content="Informasi resmi rincian biaya pendaftaran, uang pangkal, seragam, SPP bulanan, dan berkas brosur PPDB SD Islam Plus Al-Wafa Batam Tahun Pelajaran 2026/2027.">
<meta name="keywords" content="Biaya PPDB Al-Wafa, Brosur SD Al-Wafa Batam, Rincian Uang Masuk SD Islam">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Bootstrap 5 -->
<link href="{{ asset('homepage/assets/bootstrap.min.css') }}" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" onerror="this.src='{{ asset('assets/img/logo.png') }}'">

<style>
  :root {
    --uis-primary: #05824e;
    --uis-primary-dark: #035e38;
    --uis-primary-light: #e8f7f0;
    --uis-gold: #eab308;
    --uis-gold-dark: #ca8a04;
    --uis-dark: #1e293b;
    --uis-muted: #64748b;
    --uis-bg: #f8fafc;
    --uis-border: #e2e8f0;
  }

  body {
    font-family: 'Nunito Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #334155;
    background-color: var(--uis-bg);
    line-height: 1.6;
    overflow-x: hidden;
  }

  h1, h2, h3, h4, h5, h6, .fw-bold, .nav-link, .btn {
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* Navbar */
  .navbar-uis {
    background: #ffffff;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    padding: 12px 0;
  }
  .uis-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
  }
  .uis-logo img {
    height: 48px;
    width: auto;
  }
  .uis-logo-subtitle {
    font-size: 0.7rem;
    color: #64748b;
    font-weight: 500;
    line-height: 1.1;
    margin-bottom: 2px;
  }
  .uis-logo-title {
    font-size: 1.08rem;
    font-weight: 800;
    color: #035e38;
    line-height: 1.2;
    letter-spacing: -0.2px;
  }
  .navbar-nav .nav-link {
    font-size: 0.92rem;
    font-weight: 500;
    color: #334155;
    padding: 6px 12px !important;
    transition: color 0.2s ease;
  }
  .navbar-nav .nav-link:hover,
  .navbar-nav .nav-link.active {
    color: var(--uis-primary);
    font-weight: 600;
  }
  .btn-uis-primary {
    background: var(--uis-primary);
    border: 1.5px solid var(--uis-primary);
    color: #ffffff !important;
    font-weight: 600;
    border-radius: 50px;
    padding: 6px 22px;
    font-size: 0.88rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .btn-uis-primary:hover {
    background: var(--uis-primary-dark);
    border-color: var(--uis-primary-dark);
  }
  .btn-uis-outline {
    border: 1.5px solid var(--uis-primary);
    color: var(--uis-primary) !important;
    background: transparent;
    font-weight: 600;
    border-radius: 50px;
    padding: 6px 22px;
    font-size: 0.88rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .btn-uis-outline:hover {
    background: var(--uis-primary);
    color: #ffffff !important;
  }

  /* Header Banner */
  .page-header-banner {
    background: linear-gradient(135deg, #044d2e 0%, #035e38 50%, #05824e 100%);
    padding: 55px 0 45px;
    color: #ffffff;
    position: relative;
    overflow: hidden;
  }
  .page-header-banner::before {
    content: '';
    position: absolute;
    top: 0; right: 0; bottom: 0; left: 0;
    background: radial-gradient(circle at top right, rgba(255,255,255,0.12), transparent 70%);
    pointer-events: none;
  }
  .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
  }
  .breadcrumb-item a:hover {
    color: #ffffff;
    text-decoration: underline;
  }
  .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.95);
  }
  .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.5);
  }

  /* Main Card */
  .content-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--uis-border);
    padding: 32px;
    margin-bottom: 24px;
  }

  .table-biaya th {
    background: #f8fafc;
    color: var(--uis-dark);
    font-weight: 700;
    font-size: 0.9rem;
    padding: 14px 16px;
  }
  .table-biaya td {
    padding: 14px 16px;
    vertical-align: middle;
  }

  /* Brosur Download Card */
  .brosur-card {
    background: linear-gradient(135deg, #044d2e 0%, #05824e 100%);
    color: #ffffff;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 8px 24px rgba(5, 130, 78, 0.2);
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
  }
  .brosur-card::before {
    content: '';
    position: absolute;
    right: -20px;
    bottom: -20px;
    width: 140px;
    height: 140px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
  }

  /* Banner Bantuan Hijau */
  .cta-uis-banner {
    background: linear-gradient(135deg, #05824e 0%, #035e38 100%);
    border-radius: 18px;
    padding: 38px 44px;
    color: #ffffff;
    box-shadow: 0 12px 30px rgba(5, 130, 78, 0.25);
    position: relative;
    overflow: hidden;
    margin: 50px 0;
  }
  .cta-uis-banner::before {
    content: '';
    position: absolute;
    right: 0; top: 0; bottom: 0;
    width: 45%;
    background-image: url('{{ asset('assets/img/school-banner.jpg') }}');
    background-size: cover;
    background-position: center;
    opacity: 0.20;
    mix-blend-mode: overlay;
    pointer-events: none;
  }
  .cta-uis-title {
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 6px;
  }
  .cta-uis-desc {
    font-size: 0.92rem;
    color: rgba(255, 255, 255, 0.92);
    max-width: 580px;
    margin-bottom: 0;
  }
  .btn-cta-white {
    background: rgba(255, 255, 255, 0.2);
    border: 1.5px solid rgba(255, 255, 255, 0.7);
    color: #ffffff !important;
    backdrop-filter: blur(4px);
    font-weight: 600;
    font-size: 0.88rem;
    border-radius: 50px;
    padding: 9px 24px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .btn-cta-white:hover {
    background: #ffffff;
    color: #035e38 !important;
    border-color: #ffffff;
  }

  /* Footer */
  .footer-uis {
    background: #0b1329 !important;
    color: #cbd5e1 !important;
    padding: 55px 0 25px;
    font-size: 0.88rem;
  }
  .footer-uis .footer-title {
    color: #ffffff !important;
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 16px;
    letter-spacing: -0.2px;
  }
  .footer-uis p,
  .footer-uis .text-muted,
  .footer-uis small,
  .footer-uis .small {
    color: #cbd5e1 !important;
  }
  .footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .footer-links li {
    margin-bottom: 9px;
  }
  .footer-links a {
    color: #cbd5e1 !important;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-block;
  }
  .footer-links a:hover {
    color: #38bdf8 !important;
    transform: translateX(4px);
  }
  .footer-uis .border-top {
    border-color: rgba(255, 255, 255, 0.15) !important;
    color: #94a3b8 !important;
  }

  /* Floating WhatsApp */
  .floating-wa-btn {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #25d366;
    color: #ffffff !important;
    border-radius: 50px;
    padding: 12px 22px;
    font-weight: 700;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
    z-index: 999;
    text-decoration: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .floating-wa-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(37, 211, 102, 0.5);
    color: #ffffff;
  }
</style>
</head>
<body>

@php
  $rawWa = $settings['kontak_whatsapp'] ?? '081266812015';
  $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);
  if (str_starts_with($cleanWa, '0')) {
      $cleanWa = '62' . substr($cleanWa, 1);
  }
  $waUrl = 'https://wa.me/' . $cleanWa;
@endphp

<!-- ============================================
     NAVBAR
============================================ -->
<nav class="navbar navbar-expand-lg navbar-uis sticky-top">
  <div class="container">
    <a class="uis-logo" href="{{ route('homepage') }}">
      <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo SD Al-Wafa" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
      <div>
        <div class="uis-logo-subtitle">PPDB ONLINE</div>
        <div class="uis-logo-title">SD ISLAM PLUS AL-WAFA</div>
      </div>
    </a>

    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navPublic">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navPublic">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('homepage') }}#home">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('homepage') }}#jalur">Jalur Pendaftaran</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('biaya.publik') }}">Brosur &amp; Biaya</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('informasi.index') }}">Informasi &amp; Pengumuman</a>
        </li>
        <li class="nav-item ms-lg-2">
          <a href="{{ route('login') }}" class="btn-uis-outline">
            <i class="bi bi-box-arrow-in-right"></i> Masuk
          </a>
        </li>
        <li class="nav-item ms-lg-2">
          <a href="{{ route('register') }}" class="btn-uis-primary">
            <i class="bi bi-person-plus"></i> Daftar
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- ============================================
     HEADER BANNER & BREADCRUMB
============================================ -->
<header class="page-header-banner">
  <div class="container position-relative">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2 small">
        <li class="breadcrumb-item"><a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page">Brosur &amp; Rincian Biaya</li>
      </ol>
    </nav>
    <div class="d-flex align-items-center gap-2 mb-2">
      <span class="badge bg-white text-success px-3 py-1 rounded-pill fw-bold small">
        <i class="bi bi-shield-check me-1"></i> Informasi Resmi PPDB
      </span>
      <span class="badge bg-white-50 text-white px-3 py-1 rounded-pill small">
        T.A. {{ $tahunAktif->tahun_ajaran ?? '2026/2027' }}
      </span>
    </div>
    <h1 class="h2 fw-bold text-white mb-2">Brosur &amp; Rincian Biaya Pendidikan</h1>
    <p class="mb-0 text-white-50" style="max-width: 650px;">
      Transparansi pembiayaan pendidikan peserta didik baru, rincian uang masuk, fasilitas, dan berkas brosur resmi SD Islam Plus Al-Wafa Batam.
    </p>
  </div>
</header>

<main class="py-5">
  <div class="container">
    <div class="row g-4">

      <!-- ================= KOLOM KIRI (TABEL BIAYA) ================= -->
      <div class="col-lg-7">
        <div class="content-card">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="fw-bold text-dark mb-1">
                <i class="bi bi-cash-stack text-success me-2"></i>Rincian Komponen Biaya Sekolah
              </h5>
              <small class="text-muted">Tahun Pelajaran {{ $tahunAktif->tahun_ajaran ?? '2026/2027' }}</small>
            </div>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
              Skema Fleksibel
            </span>
          </div>

          <div class="table-responsive mb-4">
            <table class="table table-bordered table-biaya align-middle">
              <thead>
                <tr>
                  <th style="width: 5%;" class="text-center">No</th>
                  <th>Komponen Biaya</th>
                  <th style="width: 22%;" class="text-center">Sifat</th>
                  <th style="width: 32%;" class="text-end">Nominal Tarif</th>
                </tr>
              </thead>
              <tbody>
                @forelse($biayaList as $idx => $b)
                  <tr>
                    <td class="text-center fw-semibold text-muted">{{ $idx + 1 }}</td>
                    <td>
                      <div class="fw-bold text-dark">{{ $b->nama_biaya }}</div>
                      @if($b->keterangan)
                        <small class="text-muted d-block">{{ $b->keterangan }}</small>
                      @endif
                    </td>
                    <td class="text-center">
                      <span class="badge {{ $b->is_wajib ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-secondary-subtle text-secondary border border-secondary-subtle' }} px-2 py-1 rounded-pill small">
                        {{ $b->is_wajib ? 'Wajib' : 'Pilihan / Opsional' }}
                      </span>
                    </td>
                    <td class="text-end fw-bold font-monospace text-dark fs-6">
                      Rp {{ number_format($b->nominal, 0, ',', '.') }}
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                      Belum ada rincian tarif biaya yang dipublikasikan.
                    </td>
                  </tr>
                @endforelse
              </tbody>
              @if(isset($totalBiayaWajib) && $totalBiayaWajib > 0)
                <tfoot class="table-light">
                  <tr>
                    <th colspan="3" class="text-end fw-bold text-dark">Estimasi Total Biaya Wajib Awal:</th>
                    <th class="text-end fw-bold font-monospace text-success fs-5">
                      Rp {{ number_format($totalBiayaWajib, 0, ',', '.') }}
                    </th>
                  </tr>
                </tfoot>
              @endif
            </table>
          </div>

          <!-- Alert Kebijakan Angsuran / Cicilan -->
          <div class="p-3 rounded-3" style="background: #fefce8; border: 1.5px solid #fef08a;">
            <div class="d-flex align-items-start gap-2">
              <i class="bi bi-info-circle-fill text-warning fs-5 flex-shrink-0 mt-1"></i>
              <div>
                <strong class="text-dark d-block mb-1">Kebijakan Pembayaran Bertahap (Angsuran):</strong>
                <p class="small text-muted mb-0">
                  {{ $settings['biaya_catatan'] ?? 'Sekolah memfasilitasi opsi pembayaran uang masuk secara fleksibel hingga 3 kali angsuran tanpa bunga untuk mempermudah bapak/ibu calon wali murid. Kesepakatan jadwal angsuran dapat dibahas saat sesi wawancara keuangan.' }}
                </p>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- ================= KOLOM KANAN (DOWNLOAD BROSUR & KONSULTASI) ================= -->
      <div class="col-lg-5">

        <!-- Card Brosur PDF -->
        <div class="brosur-card">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="bg-white text-success rounded-3 p-3 fs-2 d-inline-flex align-items-center justify-content-center" style="width: 58px; height: 58px;">
              <i class="bi bi-file-earmark-pdf"></i>
            </div>
            <div>
              <h5 class="fw-bold text-white mb-1">{{ $settings['brosur_judul'] ?? 'Brosur Resmi PPDB Al-Wafa' }}</h5>
              <small class="text-white-50">Tahun Pelajaran {{ $tahunAktif->tahun_ajaran ?? '2026/2027' }}</small>
            </div>
          </div>

          <p class="small text-white-50 mb-4" style="line-height: 1.7;">
            {{ $settings['brosur_deskripsi'] ?? 'Unduh dokumen brosur cetak berisi profil sekolah, keunggulan program tahfidz Qur’an, fasilitas belajar smart class, dan rincian lengkap biaya pendidikan.' }}
          </p>

          @php
            $defaultBrosur = 'assets/uploads/brosur/brosur-ppdb-alwafa.pdf';
            $fileUrl = !empty($settings['brosur_file']) ? asset($settings['brosur_file']) : (file_exists(public_path($defaultBrosur)) ? asset($defaultBrosur) : null);
            $driveUrl = !empty($settings['brosur_link']) ? $settings['brosur_link'] : null;
          @endphp

          <div class="d-grid gap-2">
            @if($fileUrl)
              <div class="d-flex gap-2">
                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-light fw-bold flex-grow-1 text-dark d-flex align-items-center justify-content-center gap-2 py-2" style="border-radius: 50px; font-size: 0.92rem;">
                  <i class="bi bi-eye"></i> View Brosur
                </a>
                <a href="{{ $fileUrl }}" download class="btn btn-warning fw-bold flex-grow-1 text-dark d-flex align-items-center justify-content-center gap-2 py-2" style="border-radius: 50px; font-size: 0.92rem;">
                  <i class="bi bi-download"></i> Download PDF
                </a>
              </div>
            @endif

            @if($driveUrl)
              <a href="{{ $driveUrl }}" target="_blank" class="btn btn-outline-light fw-semibold rounded-pill py-2 d-flex align-items-center justify-content-center gap-2" style="font-size: 0.88rem;">
                <i class="bi bi-google"></i> Buka via Google Drive
              </a>
            @endif
          </div>
        </div>

        <!-- Card Konsultasi Keuangan WhatsApp -->
        <div class="content-card">
          <h6 class="fw-bold text-dark mb-2">
            <i class="bi bi-whatsapp text-success me-2"></i>Konsultasi Biaya Langsung
          </h6>
          <p class="small text-muted mb-3">
            Butuh klarifikasi skema pembayaran atau subsidi keringanan biaya pendidikan? Hubungi panitia PPDB sekarang.
          </p>
          <div class="p-3 bg-light rounded-3 mb-3 border">
            <div class="small text-muted mb-1">WhatsApp Panitia / Bendahara:</div>
            <div class="fw-bold text-success fs-6">
              <i class="bi bi-telephone me-1"></i> {{ $settings['kontak_whatsapp'] ?? '081266812015' }}
            </div>
          </div>
          <a href="{{ $waUrl }}?text={{ urlencode('Assalamu’alaikum Bendahara PPDB SD Islam Plus Al-Wafa Batam, saya ingin bertanya seputar rincian biaya pendaftaran') }}" target="_blank" class="btn btn-success w-100 py-2 fw-semibold rounded-pill d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-whatsapp"></i> Chat WhatsApp Panitia
          </a>
        </div>

        <!-- Card Alur Pembayaran -->
        <div class="content-card">
          <h6 class="fw-bold text-dark mb-3">
            <i class="bi bi-shield-check text-primary me-2"></i>Alur Pembayaran Biaya
          </h6>
          <ol class="small text-muted ps-3 mb-0" style="line-height: 1.8;">
            <li>Lakukan registrasi akun online calon wali murid di website resmi ini.</li>
            <li>Biaya formulir awal dapat dibayarkan melalui transfer rekening resmi sekolah atau posko pendaftaran luring.</li>
            <li>Unggah bukti transfer pada menu <strong>Pembayaran</strong> di dashboard akun.</li>
            <li>Panitia/Bendahara akan memverifikasi dan menerbitkan kwitansi resmi tanda lunas.</li>
          </ol>
        </div>

      </div>

    </div>

    <!-- ============================================
         BANNER KAMI SIAP MEMBANTU ANDA (HIJAU)
    ============================================ -->
    <div class="cta-uis-banner mt-4">
      <div class="row align-items-center">
        <div class="col-lg-8 mb-3 mb-lg-0">
          <div class="cta-uis-title">{{ $settings['cta_judul'] ?? 'Kami Siap Membantu Anda' }}</div>
          <p class="cta-uis-desc">
            {{ $settings['cta_subjudul'] ?? 'Apabila kamu memiliki kendala atau pertanyaan, silakan hubungi kami atau dapat juga membaca petunjuk pendaftaran terlebih dahulu.' }}
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
            @if(($settings['cta_wa_active'] ?? '1') == '1')
              <a href="{{ $waUrl }}?text={{ urlencode($settings['cta_wa_text'] ?? 'Assalamu’alaikum Panitia PPDB SD Islam Plus Al-Wafa, saya ingin bertanya') }}" target="_blank" class="btn-cta-white">
                <i class="bi bi-whatsapp"></i> WhatsApp
              </a>
            @endif
            <a href="{{ route('homepage') }}#tatacara" class="btn-cta-white">
              <i class="bi bi-book"></i> Petunjuk Pendaftaran
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>

<!-- ============================================
     FOOTER
============================================ -->
<footer class="footer-uis">
  <div class="container">
    <div class="row g-4 pb-4">
      <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo" style="height: 42px;" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
          <div>
            <div class="text-white fw-bold" style="font-size: 1rem; letter-spacing: -0.2px;">SD ISLAM PLUS AL-WAFA</div>
            <div class="small" style="color: #94a3b8;">{{ $settings['yayasan'] ?? 'Yayasan Daarul Aitam Batam' }}</div>
          </div>
        </div>
        <p class="small" style="color: #cbd5e1; line-height: 1.6;">
          {{ $settings['kontak_alamat'] ?? 'Bida Asri II Blok G2 No. 11 - 15 Kel. Belian, Kec. Batam Kota, Kota Batam - Indonesia' }}
        </p>
        <p class="small mb-0" style="color: #cbd5e1;">
          <i class="bi bi-telephone text-success me-1"></i> Telp: {{ $settings['kontak_telepon'] ?? '0778 7495940' }} &bull; <i class="bi bi-whatsapp text-success me-1"></i> WA: {{ $settings['kontak_whatsapp'] ?? '081266812015' }}
        </p>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="footer-title">Tautan Cepat</div>
        <ul class="footer-links">
          <li><a href="{{ route('homepage') }}#home"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Beranda</a></li>
          <li><a href="{{ route('homepage') }}#jalur"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Jalur &amp; Gelombang</a></li>
          <li><a href="{{ route('biaya.publik') }}"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Rincian Biaya &amp; Brosur</a></li>
          <li><a href="{{ route('informasi.index') }}"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Informasi &amp; Pengumuman</a></li>
          <li><a href="{{ route('login') }}"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Masuk Portal PPDB</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-6">
        <div class="footer-title">Jam Pelayanan</div>
        <p class="small mb-3" style="color: #cbd5e1; line-height: 1.6;">
          <i class="bi bi-clock-history text-warning me-1"></i> {{ $settings['kontak_jam'] ?? 'Senin – Sabtu : 07.30 – 15.00 WIB' }}
        </p>
        <div class="footer-title mt-3">Legalitas</div>
        <p class="small mb-0" style="color: #cbd5e1; line-height: 1.6;">
          <i class="bi bi-patch-check-fill text-success me-1"></i> NPSN: {{ $settings['npsn'] ?? '69888848' }}<br>
          <i class="bi bi-file-earmark-text text-info me-1"></i> Izin: {{ $settings['izin_diknas'] ?? 'No. 21/421.3/DIKDAS/I/2015' }}
        </p>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="footer-title">Bantuan &amp; Konsultasi</div>
        <p class="small mb-3" style="color: #cbd5e1; line-height: 1.6;">
          Panitia PPDB siap melayani pertanyaan seputar pendaftaran, formulir, dan observasi siswa baru.
        </p>
        <a href="{{ $waUrl }}?text={{ urlencode('Assalamu’alaikum Admin PPDB SD Islam Plus Al-Wafa, saya butuh bantuan') }}" target="_blank" class="btn btn-success btn-sm rounded-pill w-100 py-2 fw-semibold">
          <i class="bi bi-whatsapp me-1"></i> WhatsApp Panitia PPDB
        </a>
      </div>
    </div>

    <div class="border-top pt-3 mt-2 text-center small" style="color: #94a3b8; border-color: rgba(255, 255, 255, 0.15) !important;">
      &copy; {{ date('Y') }} <strong>SD Islam Plus Al-Wafa Batam</strong> &bull; Seluruh Hak Cipta Dilindungi.
    </div>
  </div>
</footer>

<!-- Floating WhatsApp Button -->
@if(($settings['floating_wa_active'] ?? '1') == '1')
<a href="{{ $waUrl }}?text={{ urlencode($settings['cta_wa_text'] ?? 'Assalamu’alaikum Admin PPDB SD Islam Plus Al-Wafa, saya butuh bantuan') }}" target="_blank" class="floating-wa-btn" title="Hubungi Kami via WhatsApp">
  <i class="bi bi-whatsapp fs-5"></i>
  <span>Chat WhatsApp</span>
</a>
@endif

<script src="{{ asset('homepage/assets/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
