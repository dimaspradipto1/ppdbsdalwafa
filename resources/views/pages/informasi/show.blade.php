<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $pengumuman->judul }} &mdash; SD Islam Plus Al-Wafa Batam</title>
<meta name="description" content="{{ Str::limit(strip_tags($pengumuman->isi_pengumuman), 160) }}">
<meta name="keywords" content="Pengumuman PPDB, SD Islam Plus Al-Wafa, PPDB Batam, Informasi Sekolah">

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
    line-height: 1.7;
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

  /* Breadcrumb Header Banner */
  .page-header-banner {
    background: linear-gradient(135deg, #044d2e 0%, #035e38 50%, #05824e 100%);
    padding: 45px 0 40px;
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

  /* Breadcrumbs */
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

  /* Detail Card */
  .article-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--uis-border);
    padding: 36px 40px;
    margin-top: -24px;
    position: relative;
    z-index: 10;
  }
  @media (max-width: 768px) {
    .article-card {
      padding: 24px 20px;
      margin-top: -15px;
    }
  }

  .badge-category {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 5px 14px;
    border-radius: 50px;
    display: inline-block;
  }
  .badge-category.info {
    background: #e0f2fe;
    color: #0369a1;
    border-color: #bae6fd;
  }

  .article-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 18px;
    padding: 14px 0;
    margin: 16px 0 24px;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
    color: var(--uis-muted);
  }
  .article-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .article-meta-item i {
    color: var(--uis-primary);
  }

  .article-body {
    font-size: 1.05rem;
    line-height: 1.85;
    color: #334155;
  }
  .article-body p {
    margin-bottom: 1.25rem;
  }

  /* Attachment Box */
  .attachment-box {
    background: #f8fafc;
    border: 1.5px dashed #cbd5e1;
    border-radius: 14px;
    padding: 20px 24px;
    margin: 30px 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }
  @media (max-width: 576px) {
    .attachment-box {
      flex-direction: column;
      align-items: flex-start;
    }
  }

  /* Sidebar widgets */
  .sidebar-widget {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--uis-border);
    padding: 24px;
    margin-bottom: 24px;
  }
  .widget-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--uis-dark);
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--uis-primary-light);
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .widget-title i {
    color: var(--uis-primary);
  }

  .mini-news-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .mini-news-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }
  .mini-news-item:hover .mini-news-title {
    color: var(--uis-primary);
  }
  .mini-news-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: var(--uis-primary-light);
    color: var(--uis-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.1rem;
  }
  .mini-news-title {
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--uis-dark);
    line-height: 1.35;
    margin-bottom: 3px;
    transition: color 0.2s ease;
  }
  .mini-news-date {
    font-size: 0.76rem;
    color: var(--uis-muted);
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
  // Format nomor WhatsApp untuk wa.me
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
          <a class="nav-link" href="{{ route('homepage') }}#hero">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('homepage') }}#jalur">Jalur &amp; Gelombang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('homepage') }}#biaya">Biaya &amp; Brosur</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('homepage') }}#tatacara">Tata Cara</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('informasi.index') }}">Informasi &amp; Pengumuman</a>
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
     PAGE HEADER BANNER & BREADCRUMB
============================================ -->
<header class="page-header-banner">
  <div class="container position-relative">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2 small">
        <li class="breadcrumb-item"><a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('informasi.index') }}">Informasi &amp; Pengumuman</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Pengumuman</li>
      </ol>
    </nav>
    <div class="d-flex align-items-center gap-2 mt-3">
      <span class="badge {{ str_contains(strtolower($pengumuman->judul), 'rincian') || str_contains(strtolower($pengumuman->judul), 'biaya') ? 'badge-category info' : 'badge-category' }}">
        <i class="bi bi-megaphone-fill me-1"></i>
        {{ str_contains(strtolower($pengumuman->judul), 'rincian') || str_contains(strtolower($pengumuman->judul), 'biaya') ? 'Informasi' : 'Pengumuman Resmi' }}
      </span>
      @if($pengumuman->tahunAjaran)
        <span class="badge bg-white text-dark border py-1 px-3 rounded-pill fw-semibold small">
          <i class="bi bi-calendar-check me-1 text-success"></i> TA {{ $pengumuman->tahunAjaran->tahun_ajaran }}
        </span>
      @endif
      @if($pengumuman->gelombang)
        <span class="badge bg-white text-dark border py-1 px-3 rounded-pill fw-semibold small">
          <i class="bi bi-flag-fill me-1 text-warning"></i> {{ $pengumuman->gelombang->nama_gelombang }}
        </span>
      @endif
    </div>
  </div>
</header>

<!-- ============================================
     MAIN DETAIL CONTENT
============================================ -->
<main class="py-4">
  <div class="container">
    <div class="row g-4">

      <!-- Kolom Konten Artikel Pengumuman -->
      <div class="col-lg-8">
        <article class="article-card">
          <h1 class="h3 fw-bold text-dark mb-3 lh-base">
            {{ $pengumuman->judul }}
          </h1>

          <div class="article-meta">
            <div class="article-meta-item">
              <i class="bi bi-calendar3"></i>
              <span>{{ $pengumuman->tanggal_buka ? $pengumuman->tanggal_buka->translatedFormat('l, d F Y') : '-' }}</span>
            </div>
            @if($pengumuman->nomor_surat)
              <div class="article-meta-item">
                <i class="bi bi-file-earmark-text"></i>
                <span>No: {{ $pengumuman->nomor_surat }}</span>
              </div>
            @endif
            <div class="article-meta-item">
              <i class="bi bi-person-circle"></i>
              <span>Panitia PPDB SD Islam Plus Al-Wafa</span>
            </div>
          </div>

          <!-- Isi Pengumuman -->
          <div class="article-body">
            {!! nl2br(e($pengumuman->isi_pengumuman)) !!}
          </div>

          <!-- File Lampiran Jika Ada -->
          @if($pengumuman->file_lampiran)
            <div class="attachment-box">
              <div class="d-flex align-items-center gap-3">
                <div class="bg-danger-subtle text-danger p-3 rounded-3 fs-3">
                  <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <div>
                  <h6 class="fw-bold mb-1 text-dark">Lampiran Dokumen Resmi</h6>
                  <p class="text-muted small mb-0">Silakan unduh dokumen surat keputusan / edaran resmi.</p>
                </div>
              </div>
              <a href="{{ asset('storage/' . $pengumuman->file_lampiran) }}" target="_blank" class="btn btn-danger btn-sm px-3 py-2 fw-semibold">
                <i class="bi bi-download me-1"></i> Unduh Lampiran
              </a>
            </div>
          @endif

          <!-- Tombol Aksi / Bagikan -->
          <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 pt-4 mt-4 border-top">
            <a href="{{ route('informasi.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
              <i class="bi bi-arrow-left me-1"></i> Semua Pengumuman
            </a>

            <div class="d-flex align-items-center gap-2">
              <span class="small text-muted fw-semibold me-1">Bagikan:</span>
              <a href="https://wa.me/?text={{ urlencode($pengumuman->judul . ' - Selengkapnya di: ' . url()->current()) }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3" title="Bagikan ke WhatsApp">
                <i class="bi bi-whatsapp me-1"></i> WhatsApp
              </a>
              <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan pengumuman berhasil disalin!');">
                <i class="bi bi-link-45deg me-1"></i> Salin Tautan
              </button>
            </div>
          </div>

        </article>
      </div>

      <!-- Kolom Sidebar -->
      <div class="col-lg-4">

        <!-- Widget: Kontak WhatsApp Admin & Panitia -->
        <div class="sidebar-widget">
          <div class="widget-title">
            <i class="bi bi-whatsapp text-success"></i> Layanan Bantuan PPDB
          </div>
          <p class="text-muted small mb-3">
            Ada pertanyaan terkait informasi pengumuman atau proses pendaftaran? Hubungi panitia via WhatsApp resmi.
          </p>
          <div class="p-3 bg-light rounded-3 mb-3 border">
            <div class="small text-muted mb-1">WhatsApp Admin PPDB:</div>
            <div class="fw-bold text-success fs-6">
              <i class="bi bi-telephone-forward me-1"></i> {{ $settings['kontak_whatsapp'] ?? '081266812015' }}
            </div>
            @if(!empty($settings['kontak_whatsapp_2']))
              <div class="fw-bold text-success fs-6 mt-1">
                <i class="bi bi-telephone-forward me-1"></i> {{ $settings['kontak_whatsapp_2'] }} (Admin 2)
              </div>
            @endif
          </div>
          <a href="{{ $waUrl }}?text={{ urlencode('Assalamu’alaikum Panitia PPDB SD Al-Wafa, saya ingin bertanya tentang: ' . $pengumuman->judul) }}" target="_blank" class="btn btn-success w-100 fw-semibold rounded-pill py-2">
            <i class="bi bi-whatsapp me-1"></i> Chat WhatsApp Sekarang
          </a>
        </div>

        <!-- Widget: Pengumuman Terbaru Lainnya -->
        <div class="sidebar-widget">
          <div class="widget-title">
            <i class="bi bi-newspaper"></i> Pengumuman Lainnya
          </div>
          <div>
            @forelse($pengumumanLainnya as $pl)
              <a href="{{ route('informasi.detail', $pl->id_pengumuman) }}" class="mini-news-item">
                <div class="mini-news-icon">
                  <i class="bi bi-megaphone"></i>
                </div>
                <div class="flex-grow-1">
                  <div class="mini-news-title">{{ Str::limit($pl->judul, 65) }}</div>
                  <div class="mini-news-date">
                    <i class="bi bi-calendar3 me-1"></i> {{ $pl->tanggal_buka ? $pl->tanggal_buka->translatedFormat('d M Y') : '-' }}
                  </div>
                </div>
              </a>
            @empty
              <p class="text-muted small mb-0">Belum ada pengumuman lainnya.</p>
            @endforelse
          </div>
        </div>

        <!-- Widget: Banner Ajakan Daftar -->
        <div class="sidebar-widget text-center bg-success text-white" style="background: linear-gradient(135deg, #05824e 0%, #035e38 100%) !important;">
          <i class="bi bi-mortarboard fs-1 text-warning mb-2 d-block"></i>
          <h5 class="fw-bold mb-2">Daftar Siswa Baru Sekarang</h5>
          <p class="small text-white-50 mb-3">
            Dapatkan pendidikan karakter islami, tahfidz Al-Qur'an, dan bimbingan tematik terbaik bagi putra/putri Anda.
          </p>
          <a href="{{ route('register') }}" class="btn btn-warning fw-bold rounded-pill w-100 py-2">
            <i class="bi bi-pencil-square me-1"></i> Registrasi Online
          </a>
        </div>

      </div>

    </div>

    <!-- ============================================
         BANNER KAMI SIAP MEMBANTU ANDA (HIJAU)
    ============================================ -->
    <div class="cta-uis-banner mt-5">
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
