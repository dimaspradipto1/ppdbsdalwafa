<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tata Cara &amp; Alur Pendaftaran Siswa Baru &mdash; SD Islam Plus Al-Wafa Batam</title>
<meta name="description" content="Panduan lengkap tata cara dan alur pendaftaran peserta didik baru (PPDB) online di SD Islam Plus Al-Wafa Batam Tahun Pelajaran {{ $tahunAktif->tahun_ajaran ?? '2026/2027' }}.">
<meta name="keywords" content="Tata Cara PPDB Al-Wafa, Alur Pendaftaran SD Islam Batam, Petunjuk PPDB Online Al-Wafa">

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
    padding: 6px 14px !important;
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
    padding: 7px 22px;
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
    padding: 7px 22px;
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

  /* Hero Page Header */
  .page-hero {
    background: linear-gradient(135deg, #035e38 0%, #05824e 60%, #0a9d60 100%);
    color: #ffffff;
    padding: 55px 0 45px;
    position: relative;
    overflow: hidden;
  }
  .page-hero::after {
    content: '';
    position: absolute;
    right: -60px;
    bottom: -60px;
    width: 320px;
    height: 320px;
    background: radial-gradient(circle, rgba(234, 179, 8, 0.18) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
  }
  .page-hero-badge {
    background: rgba(255, 255, 255, 0.16);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #ffffff;
    font-size: 0.78rem;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 14px;
    backdrop-filter: blur(4px);
  }
  .page-hero-title {
    font-size: 2.2rem;
    font-weight: 800;
    line-height: 1.25;
    margin-bottom: 12px;
    letter-spacing: -0.5px;
  }
  .page-hero-desc {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.92);
    max-width: 680px;
    margin-bottom: 0;
  }

  /* Quick Summary Cards (Pill Steps) */
  .quick-flow-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--uis-border);
    margin-top: -30px;
    position: relative;
    z-index: 10;
    padding: 24px 20px;
  }

  .step-pill-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
    height: 100%;
  }
  .step-pill-item:hover {
    background: #ffffff;
    border-color: var(--uis-primary);
    box-shadow: 0 4px 12px rgba(5, 130, 78, 0.1);
    transform: translateY(-2px);
  }
  .step-pill-num {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: var(--uis-primary);
    color: #ffffff;
    font-weight: 700;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .step-pill-title {
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--uis-dark);
    line-height: 1.2;
    margin-bottom: 2px;
  }
  .step-pill-desc {
    font-size: 0.76rem;
    color: #64748b;
    margin-bottom: 0;
    line-height: 1.25;
  }

  /* Timeline & Process Cards */
  .timeline-uis {
    position: relative;
    padding-left: 20px;
  }
  .timeline-uis::before {
    content: '';
    position: absolute;
    left: 28px;
    top: 20px;
    bottom: 40px;
    width: 3px;
    background: linear-gradient(to bottom, var(--uis-primary), #cbd5e1);
  }
  .timeline-item {
    position: relative;
    padding-left: 60px;
    margin-bottom: 32px;
  }
  .timeline-badge {
    position: absolute;
    left: 8px;
    top: 0;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #ffffff;
    border: 3px solid var(--uis-primary);
    color: var(--uis-primary);
    font-weight: 800;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    z-index: 2;
  }
  .timeline-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--uis-border);
    padding: 24px;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.03);
    transition: all 0.25s ease;
  }
  .timeline-card:hover {
    box-shadow: 0 8px 24px rgba(5, 130, 78, 0.08);
    border-color: #a7f3d0;
  }
  .timeline-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
  }
  .timeline-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--uis-dark);
    margin-bottom: 0;
  }
  .timeline-tag {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 50px;
  }

  /* Section Styling */
  .section-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--uis-dark);
    margin-bottom: 6px;
    letter-spacing: -0.3px;
  }
  .section-subtitle {
    font-size: 0.95rem;
    color: #64748b;
    margin-bottom: 28px;
  }

  /* Persyaratan Table Card */
  .doc-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--uis-border);
    overflow: hidden;
    box-shadow: 0 3px 14px rgba(0, 0, 0, 0.03);
  }
  .doc-tab-btn {
    border: none;
    background: transparent;
    padding: 14px 22px;
    font-weight: 700;
    font-size: 0.92rem;
    color: #64748b;
    border-bottom: 3px solid transparent;
    transition: all 0.2s ease;
  }
  .doc-tab-btn.active {
    color: var(--uis-primary);
    border-bottom-color: var(--uis-primary);
    background: #f8fafc;
  }

  /* Age Requirement Box */
  .age-box {
    background: linear-gradient(135deg, #f0fdf4 0%, #e6f7ef 100%);
    border: 1.5px solid #86efac;
    border-radius: 16px;
    padding: 24px;
  }

  /* Accordion FAQ */
  .faq-accordion .accordion-item {
    border: 1px solid var(--uis-border);
    border-radius: 12px !important;
    margin-bottom: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
  }
  .faq-accordion .accordion-button {
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--uis-dark);
    background: #ffffff;
    padding: 16px 20px;
  }
  .faq-accordion .accordion-button:not(.collapsed) {
    color: var(--uis-primary);
    background: var(--uis-primary-light);
    box-shadow: none;
  }
  .faq-accordion .accordion-button::after {
    filter: invert(0.3);
  }
  .faq-accordion .accordion-body {
    padding: 18px 20px;
    font-size: 0.92rem;
    color: #475569;
    line-height: 1.65;
    background: #ffffff;
  }

  /* Helpdesk Card */
  .helpdesk-card {
    background: linear-gradient(135deg, #05824e 0%, #035e38 100%);
    border-radius: 18px;
    padding: 36px 32px;
    color: #ffffff;
    box-shadow: 0 10px 30px rgba(5, 130, 78, 0.2);
  }

  /* Footer */
  .footer-uis {
    background: #0b1329 !important;
    color: #cbd5e1 !important;
    padding: 55px 0 25px;
    font-size: 0.88rem;
  }
  .footer-uis-heading {
    font-size: 1rem;
    font-weight: 700;
    color: #ffffff !important;
    margin-bottom: 16px;
  }
  .footer-uis-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
  }
  .footer-uis-list li {
    margin-bottom: 9px;
  }
  .footer-uis-list a {
    color: #cbd5e1 !important;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-block;
  }
  .footer-uis-list a:hover {
    color: #38bdf8 !important;
    transform: translateX(4px);
  }
  .footer-social-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 6px;
    text-decoration: none;
    transition: all 0.2s;
  }
  .footer-social-btn:hover {
    background: var(--uis-primary);
    color: #ffffff;
    transform: translateY(-2px);
  }

  /* Floating WhatsApp */
  .floating-wa-btn {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #25d366;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 0.88rem;
    padding: 10px 20px;
    border-radius: 50px;
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    z-index: 1050;
    transition: all 0.25s ease;
  }
  .floating-wa-btn:hover {
    transform: translateY(-3px);
    background: #1eb857;
    box-shadow: 0 12px 28px rgba(37, 211, 102, 0.5);
  }
</style>
</head>
<body>

@php
  $waAdminRaw = $settings['kontak_whatsapp'] ?? '081266812015';
  $cleanWa = preg_replace('/[^0-9]/', '', $waAdminRaw);
  if (str_starts_with($cleanWa, '0')) {
      $cleanWa = '62' . substr($cleanWa, 1);
  }
  $waUrl = 'https://wa.me/' . $cleanWa;
@endphp

<!-- ============================================
     1. NAVBAR
============================================ -->
<nav class="navbar navbar-expand-lg navbar-uis sticky-top" id="mainNav">
  <div class="container">
    <a class="uis-logo" href="{{ url('/') }}">
      <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo SD Islam Plus Al-Wafa Batam" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
      <div>
        <div class="uis-logo-subtitle text-uppercase">Penerimaan Siswa Baru</div>
        <div class="uis-logo-title">SD ISLAM PLUS AL-WAFA</div>
      </div>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-label="Toggle navigation">
      <i class="bi bi-list fs-2" style="color: var(--uis-primary);"></i>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav mx-auto mt-3 mt-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ route('homepage') }}#home">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('homepage') }}#jalur">Jalur Pendaftaran</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('tatacara.publik') }}">Tata Cara</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('biaya.publik') }}">Brosur &amp; Biaya</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('informasi.index') }}">Informasi &amp; Pengumuman</a></li>
      </ul>

      <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0 flex-shrink-0">
        @auth
          <a href="{{ route('dashboard') }}" class="btn-uis-primary">
            <i class="bi bi-grid-fill me-1"></i> Dashboard
          </a>
        @else
          <a href="{{ route('login') }}" class="btn-uis-outline">
            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
          </a>
          <a href="{{ route('register') }}" class="btn-uis-primary">
            <i class="bi bi-person-plus me-1"></i> Daftar
          </a>
        @endauth
      </div>
    </div>
  </div>
</nav>

<!-- ============================================
     2. HERO HEADER
============================================ -->
<header class="page-hero">
  <div class="container position-relative">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <div class="page-hero-badge">
          <i class="bi bi-info-circle-fill text-warning"></i>
          <span>Panduan Lengkap PPDB Online &bull; T.A. {{ $tahunAktif->tahun_ajaran ?? '2026/2027' }}</span>
        </div>
        <h1 class="page-hero-title">Tata Cara &amp; Alur Pendaftaran Siswa Baru</h1>
        <p class="page-hero-desc">
          Pelajari tahapan langkah demi langkah pendaftaran calon siswa baru SD Islam Plus Al-Wafa Batam, mulai dari registrasi akun, pemilihan jalur, pengisian biodata, pembayaran formulir, hingga pengumuman kelulusan.
        </p>
        <div class="d-flex flex-wrap gap-2 mt-4">
          <a href="{{ route('register') }}" class="btn btn-warning fw-bold px-4 py-2 rounded-pill text-dark d-inline-flex align-items-center gap-2">
            <i class="bi bi-pencil-square"></i> Daftar Akun PPDB Sekarang
          </a>
          <a href="#langkah-alur" class="btn btn-outline-light px-4 py-2 rounded-pill fw-semibold d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-down-circle"></i> Lihat 7 Langkah Pendaftaran
          </a>
        </div>
      </div>
      <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
        <div class="p-3 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-25 d-inline-block text-center">
          <i class="bi bi-shield-check text-warning" style="font-size: 3.5rem;"></i>
          <div class="fw-bold mt-2 text-white">Sistem PPDB Resmi &amp; Terpadu</div>
          <small class="text-white-50">SD Islam Plus Al-Wafa Batam</small>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- ============================================
     3. QUICK STEP SUMMARY (Pill Cards)
============================================ -->
<div class="container">
  <div class="quick-flow-card">
    <div class="row g-3">
      <div class="col-md-3 col-sm-6">
        <div class="step-pill-item">
          <div class="step-pill-num">1</div>
          <div>
            <div class="step-pill-title">{{ $settings['tatacara_1_judul'] ?? 'Buat Akun Wali' }}</div>
            <p class="step-pill-desc">{{ $settings['tatacara_1_desc'] ?? 'Registrasi akun baru dengan nama, email & WhatsApp.' }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="step-pill-item">
          <div class="step-pill-num">2</div>
          <div>
            <div class="step-pill-title">{{ $settings['tatacara_2_judul'] ?? 'Pilih Jalur & Bayar' }}</div>
            <p class="step-pill-desc">{{ $settings['tatacara_2_desc'] ?? 'Tentukan jalur pendaftaran dan lunasi biaya formulir.' }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="step-pill-item">
          <div class="step-pill-num">3</div>
          <div>
            <div class="step-pill-title">{{ $settings['tatacara_3_judul'] ?? 'Biodata & Berkas' }}</div>
            <p class="step-pill-desc">{{ $settings['tatacara_3_desc'] ?? 'Lengkapi formulir online serta unggah dokumen persyaratan.' }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="step-pill-item">
          <div class="step-pill-num">4</div>
          <div>
            <div class="step-pill-title">{{ $settings['tatacara_4_judul'] ?? 'Observasi & Lulus' }}</div>
            <p class="step-pill-desc">{{ $settings['tatacara_4_desc'] ?? 'Observasi kematangan belajar & unduh surat kelulusan.' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ============================================
     4. ALUR LENGKAP 7 LANGKAH (TIMELINE SECTION)
============================================ -->
<section class="py-5" id="langkah-alur">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill mb-2">Panduan Tahapan</span>
      <h2 class="section-title">7 Langkah Alur Pendaftaran Online</h2>
      <p class="section-subtitle mx-auto" style="max-width: 620px;">
        Ikuti tahapan berikut secara runtut agar proses verifikasi dan pendaftaran putra/putri Anda berjalan lancar tanpa kendala.
      </p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="timeline-uis">

          <!-- Langkah 1 -->
          <div class="timeline-item">
            <div class="timeline-badge">1</div>
            <div class="timeline-card">
              <div class="timeline-card-header">
                <div>
                  <h3 class="timeline-title">
                    <i class="bi bi-person-plus text-success me-2"></i>Registrasi Akun Wali Murid
                  </h3>
                  <small class="text-muted">Tahap Pembuatan Akses Masuk Portal PPDB</small>
                </div>
                <span class="timeline-tag bg-primary-subtle text-primary border border-primary-subtle">
                  Langkah Awal
                </span>
              </div>
              <p class="text-secondary small mb-3">
                Wali murid mengakses menu <strong>Daftar Akun</strong> melalui tautan <a href="{{ route('register') }}" class="text-success fw-bold">Pendaftaran Akun Baru</a>.
                Masukkan <strong>Nama Lengkap Wali</strong>, <strong>Alamat Email Aktif</strong>, <strong>Nomor WhatsApp Aktif</strong> (untuk menerima notifikasi resmi &amp; instruksi), serta kata sandi pendaftaran.
              </p>
              <div class="p-3 bg-light rounded-3 small border">
                <i class="bi bi-lightbulb-fill text-warning me-1"></i>
                <strong>Tips Penting:</strong> Pastikan nomor WhatsApp yang Anda daftarkan aktif dan dapat menerima pesan dari sistem informasi sekolah.
              </div>
            </div>
          </div>

          <!-- Langkah 2 -->
          <div class="timeline-item">
            <div class="timeline-badge">2</div>
            <div class="timeline-card">
              <div class="timeline-card-header">
                <div>
                  <h3 class="timeline-title">
                    <i class="bi bi-ui-checks text-success me-2"></i>Pilih Jalur &amp; Gelombang Pendaftaran
                  </h3>
                  <small class="text-muted">Menentukan Jalur Masuk Sesuai Kategori Calon Siswa</small>
                </div>
                <span class="timeline-tag bg-success-subtle text-success border border-success-subtle">
                  Pilihan Program
                </span>
              </div>
              <p class="text-secondary small mb-3">
                Setelah masuk ke dashboard wali murid, pilih menu <strong>Daftar Calon Siswa</strong>. Tentukan jalur masuk yang tersedia:
              </p>
              <div class="row g-2 small">
                <div class="col-md-4">
                  <div class="p-2 border rounded bg-light">
                    <strong class="text-dark d-block mb-1"><i class="bi bi-check2-circle text-success me-1"></i>Jalur Reguler</strong>
                    <span class="text-muted" style="font-size: 0.78rem;">Penerimaan umum calon siswa baru kelas 1 dengan observasi kematangan.</span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="p-2 border rounded bg-light">
                    <strong class="text-dark d-block mb-1"><i class="bi bi-check2-circle text-success me-1"></i>Jalur Prestasi</strong>
                    <span class="text-muted" style="font-size: 0.78rem;">Bagi calon siswa berprestasi di bidang tahfidz Al-Qur'an atau perlombaan.</span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="p-2 border rounded bg-light">
                    <strong class="text-dark d-block mb-1"><i class="bi bi-check2-circle text-success me-1"></i>Siswa Pindahan</strong>
                    <span class="text-muted" style="font-size: 0.78rem;">Pindahan mutasi kelas II hingga V dari sekolah asal dengan surat pindah.</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Langkah 3 -->
          <div class="timeline-item">
            <div class="timeline-badge">3</div>
            <div class="timeline-card">
              <div class="timeline-card-header">
                <div>
                  <h3 class="timeline-title">
                    <i class="bi bi-credit-card-2-front text-success me-2"></i>Pembayaran Biaya Formulir Pendaftaran
                  </h3>
                  <small class="text-muted">Biaya Administrasi Pendaftaran: {{ $biayaDaftarNominal }}</small>
                </div>
                <span class="timeline-tag bg-warning-subtle text-warning-emphasis border border-warning-subtle">
                  Administrasi
                </span>
              </div>
              <p class="text-secondary small mb-3">
                Lakukan pelunasan biaya pembelian formulir pendaftaran sebesar <strong>{{ $biayaDaftarNominal }}</strong> melalui rekening resmi yayasan atau pembayaran langsung di kantor sekretariat PPDB SD Islam Plus Al-Wafa Batam.
              </p>
              <div class="p-3 bg-light rounded-3 small border mb-2">
                <div class="row align-items-center">
                  <div class="col-sm-8">
                    <div class="fw-bold text-dark mb-1">Upload Bukti Pembayaran di Portal</div>
                    <div class="text-muted" style="font-size: 0.8rem;">Setelah mentransfer, unggah foto/struk bukti bayar di menu <strong>Pembayaran</strong> agar divalidasi oleh panitia bendahara PPDB.</div>
                  </div>
                  <div class="col-sm-4 text-sm-end mt-2 mt-sm-0">
                    <span class="badge bg-success px-3 py-2">Verifikasi Cepat</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Langkah 4 -->
          <div class="timeline-item">
            <div class="timeline-badge">4</div>
            <div class="timeline-card">
              <div class="timeline-card-header">
                <div>
                  <h3 class="timeline-title">
                    <i class="bi bi-clipboard2-data text-success me-2"></i>Pengisian Biodata Lengkap Calon Siswa
                  </h3>
                  <small class="text-muted">Data Induk Kependudukan &amp; Profil Orang Tua / Wali</small>
                </div>
                <span class="timeline-tag bg-info-subtle text-info-emphasis border border-info-subtle">
                  Data Pokok
                </span>
              </div>
              <p class="text-secondary small mb-2">
                Setelah pembayaran terkonfirmasi, isi data calon siswa secara lengkap dan valid sesuai dengan data pada Kartu Keluarga (KK) dan Akta Kelahiran:
              </p>
              <ul class="text-secondary small mb-0 ps-3">
                <li><strong>Identitas Anak:</strong> NIK, Nama Lengkap, Nama Panggilan, Tempat &amp; Tanggal Lahir, Jenis Kelamin, Anak ke-berapa.</li>
                <li><strong>Data Orang Tua/Wali:</strong> NIK Ayah &amp; Ibu, Nama Lengkap, Pekerjaan, Pendidikan Terakhir, dan Nomor Telepon/WhatsApp.</li>
                <li><strong>Data Tempat Tinggal:</strong> Alamat lengkap domisili, RT/RW, Kelurahan, Kecamatan, dan Kode Pos.</li>
              </ul>
            </div>
          </div>

          <!-- Langkah 5 -->
          <div class="timeline-item">
            <div class="timeline-badge">5</div>
            <div class="timeline-card">
              <div class="timeline-card-header">
                <div>
                  <h3 class="timeline-title">
                    <i class="bi bi-cloud-arrow-up text-success me-2"></i>Unggah Dokumen &amp; Berkas Persyaratan
                  </h3>
                  <small class="text-muted">Penyelarasan Berkas Digital</small>
                </div>
                <span class="timeline-tag bg-secondary-subtle text-secondary border">
                  Dokumen
                </span>
              </div>
              <p class="text-secondary small mb-3">
                Unggah scan berkas asli atau fotokopi yang jelas (format PDF, JPG, atau PNG maksimal 2MB per file) pada menu <strong>Dokumen Berkas</strong>:
              </p>
              <div class="row g-2 small">
                <div class="col-sm-6">
                  <div class="p-2 border rounded bg-light d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-pdf text-danger fs-5"></i>
                    <div>
                      <div class="fw-bold text-dark">Akta Kelahiran &amp; Kartu Keluarga</div>
                      <span class="text-muted" style="font-size: 0.75rem;">Scan jelas terbaca nomor NIK &amp; No KK</span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="p-2 border rounded bg-light d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-image text-primary fs-5"></i>
                    <div>
                      <div class="fw-bold text-dark">Pas Foto 3x4 Calon Siswa</div>
                      <span class="text-muted" style="font-size: 0.75rem;">Seragam Putih / Bebas Rapi Latar Merah</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Langkah 6 -->
          <div class="timeline-item">
            <div class="timeline-badge">6</div>
            <div class="timeline-card">
              <div class="timeline-card-header">
                <div>
                  <h3 class="timeline-title">
                    <i class="bi bi-person-workspace text-success me-2"></i>Observasi &amp; Tes Kesiapan Belajar
                  </h3>
                  <small class="text-muted">Sesi Interaktif Bersama Tim Guru &amp; Psikolog Sekolah</small>
                </div>
                <span class="timeline-tag bg-danger-subtle text-danger border border-danger-subtle">
                  Tahap Observasi
                </span>
              </div>
              <p class="text-secondary small mb-2">
                Calon siswa hadir bersama orang tua ke kampus SD Islam Plus Al-Wafa Batam sesuai jadwal yang tertera pada kartu pendaftaran / undangan WhatsApp:
              </p>
              <ul class="text-secondary small mb-0 ps-3">
                <li><strong>Observasi Kematangan Belajar:</strong> Kesiapan motorik halus/kasar, kemandirian anak, dan interaksi sosial.</li>
                <li><strong>Tes Baca Al-Qur'an / Iqra:</strong> Penempatan kelompok bimbingan Tahsin dan program Tahfidz Al-Qur'an.</li>
                <li><strong>Wawancara Orang Tua:</strong> Penyelarasan visi pendidikan islami serta komitmen pendampingan belajar di rumah.</li>
              </ul>
            </div>
          </div>

          <!-- Langkah 7 -->
          <div class="timeline-item">
            <div class="timeline-badge">7</div>
            <div class="timeline-card">
              <div class="timeline-card-header">
                <div>
                  <h3 class="timeline-title">
                    <i class="bi bi-award text-success me-2"></i>Pengumuman Kelulusan &amp; Daftar Ulang
                  </h3>
                  <small class="text-muted">Hasil Keputusan Resmi &amp; Pengambilan Seragam</small>
                </div>
                <span class="timeline-tag bg-success-subtle text-success border border-success-subtle">
                  Tahap Akhir
                </span>
              </div>
              <p class="text-secondary small mb-3">
                Periksa hasil kelulusan melalui menu <strong>Pengumuman</strong> di portal PPDB online. Jika dinyatakan <strong>LULUS</strong>, Anda dapat:
              </p>
              <div class="p-3 bg-light rounded-3 small border">
                <ol class="mb-0 ps-3">
                  <li class="mb-1">Mengunduh <strong>Surat Keterangan Kelulusan Resmi</strong> ber-barcode.</li>
                  <li class="mb-1">Melakukan pelunasan atau konfirmasi cicilan <strong>Biaya Uang Pangkal / Daftar Ulang</strong>.</li>
                  <li>Pengukuran dan pengambilan paket seragam sekolah, buku tematik, dan jadwal masuk Matsama (Masa Ta'aruf Siswa Madrasah/Sekolah).</li>
                </ol>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================
     5. PERSYARATAN BERKAS DOKUMEN & KETENTUAN USIA
============================================ -->
<section class="py-5 bg-white" id="persyaratan-berkas">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill mb-2">Dokumen &amp; Syarat</span>
      <h2 class="section-title">Persyaratan Berkas Pendaftaran</h2>
      <p class="section-subtitle mx-auto" style="max-width: 650px;">
        Dokumen fisik diserahkan saat verifikasi berkas/observasi ke sekretariat panitia PPDB SD Islam Plus Al-Wafa Batam.
      </p>
    </div>

    <div class="row g-4 mb-5">
      <!-- Tabel Berkas Siswa Baru (Kelas 1) -->
      <div class="col-lg-6">
        <div class="doc-card h-100">
          <div class="p-3 bg-light border-bottom d-flex align-items-center justify-content-between">
            <div class="fw-bold text-dark d-flex align-items-center gap-2">
              <i class="bi bi-person-fill text-success fs-5"></i>
              <span>Calon Siswa Baru (Kelas I)</span>
            </div>
            <span class="badge bg-success">Wajib Lengkap</span>
          </div>
          <div class="p-3">
            <div class="table-responsive">
              <table class="table table-hover align-middle small mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Berkas Dokumen</th>
                    <th>Jumlah</th>
                    <th class="text-center">Sifat</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($dokumenWajibBaru as $doc)
                    <tr>
                      <td>
                        <strong class="text-dark d-block">{{ $doc->nama_dokumen }}</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">{{ $doc->keterangan }}</span>
                      </td>
                      <td class="text-nowrap">{{ $doc->jumlah_lembar ?: '1 Set' }}</td>
                      <td class="text-center">
                        <span class="badge {{ $doc->is_wajib ? 'bg-danger-subtle text-danger' : 'bg-secondary-subtle text-secondary' }}">
                          {{ $doc->is_wajib ? 'Wajib' : 'Opsional' }}
                        </span>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td>
                        <strong class="text-dark d-block">Fotocopy Akta Lahir &amp; KK</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">Masing-masing 3 lembar jelas terbaca</span>
                      </td>
                      <td>3 Lembar</td>
                      <td class="text-center"><span class="badge bg-danger-subtle text-danger">Wajib</span></td>
                    </tr>
                    <tr>
                      <td>
                        <strong class="text-dark d-block">Fotocopy KTP Orang Tua</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">e-KTP Ayah dan Ibu/Wali</span>
                      </td>
                      <td>1 Lembar</td>
                      <td class="text-center"><span class="badge bg-danger-subtle text-danger">Wajib</span></td>
                    </tr>
                    <tr>
                      <td>
                        <strong class="text-dark d-block">Pas Foto Berwarna 3x4</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">Latar belakang merah (baju seragam/bebas rapi)</span>
                      </td>
                      <td>3 Lembar</td>
                      <td class="text-center"><span class="badge bg-danger-subtle text-danger">Wajib</span></td>
                    </tr>
                    <tr>
                      <td>
                        <strong class="text-dark d-block">Membawa Calon Siswa</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">Saat verifikasi berkas dan observasi kematangan</span>
                      </td>
                      <td>1 Siswa</td>
                      <td class="text-center"><span class="badge bg-danger-subtle text-danger">Wajib</span></td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabel Berkas Siswa Pindahan / Mutasi -->
      <div class="col-lg-6">
        <div class="doc-card h-100">
          <div class="p-3 bg-light border-bottom d-flex align-items-center justify-content-between">
            <div class="fw-bold text-dark d-flex align-items-center gap-2">
              <i class="bi bi-arrow-left-right text-primary fs-5"></i>
              <span>Calon Siswa Pindahan (Mutasi)</span>
            </div>
            <span class="badge bg-primary">Kelas II - V</span>
          </div>
          <div class="p-3">
            <div class="table-responsive">
              <table class="table table-hover align-middle small mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Berkas Dokumen</th>
                    <th>Jumlah</th>
                    <th class="text-center">Sifat</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($dokumenPindahan as $doc)
                    <tr>
                      <td>
                        <strong class="text-dark d-block">{{ $doc->nama_dokumen }}</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">{{ $doc->keterangan }}</span>
                      </td>
                      <td class="text-nowrap">{{ $doc->jumlah_lembar ?: '1 Set' }}</td>
                      <td class="text-center">
                        <span class="badge {{ $doc->is_wajib ? 'bg-danger-subtle text-danger' : 'bg-secondary-subtle text-secondary' }}">
                          {{ $doc->is_wajib ? 'Wajib' : 'Opsional' }}
                        </span>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td>
                        <strong class="text-dark d-block">Surat Keterangan Pindah</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">Dari sekolah asal yang divalidasi Dinas Pendidikan</span>
                      </td>
                      <td>Asli &amp; 2 Copy</td>
                      <td class="text-center"><span class="badge bg-danger-subtle text-danger">Wajib</span></td>
                    </tr>
                    <tr>
                      <td>
                        <strong class="text-dark d-block">Buku Rapor Lengkap</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">Buku rapor asli &amp; 1 set fotocopy nilai semester akhir</span>
                      </td>
                      <td>1 Set</td>
                      <td class="text-center"><span class="badge bg-danger-subtle text-danger">Wajib</span></td>
                    </tr>
                    <tr>
                      <td>
                        <strong class="text-dark d-block">Dokumen Kependudukan</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">Akta Kelahiran, KK, KTP orang tua, dan NISN</span>
                      </td>
                      <td>3 Lembar</td>
                      <td class="text-center"><span class="badge bg-danger-subtle text-danger">Wajib</span></td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Ketentuan Usia Resmi Calon Siswa (Permendikbud) -->
    <div class="age-box">
      <div class="row align-items-center g-3">
        <div class="col-md-2 text-center">
          <i class="bi bi-calendar-heart text-success" style="font-size: 3.5rem;"></i>
        </div>
        <div class="col-md-10">
          <h5 class="fw-bold text-dark mb-1">Ketentuan Batas Usia Calon Siswa Baru (Kelas I SD)</h5>
          <p class="small text-muted mb-2">
            Mengacu pada Peraturan Menteri Pendidikan dan Kebudayaan (Permendikbud) mengenai Penerimaan Peserta Didik Baru:
          </p>
          <div class="row g-2 small">
            <div class="col-md-4">
              <div class="p-2 bg-white rounded border">
                <span class="badge bg-success me-1">Prioritas</span>
                <strong>7 Tahun Penuh</strong>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $settings['tatacara_usia_prioritas'] ?? 'Prioritas penerimaan tanpa tes kesiapan khusus.' }}</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="p-2 bg-white rounded border">
                <span class="badge bg-primary me-1">Standar</span>
                <strong>Minimal 6 Tahun</strong>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $settings['tatacara_usia_standar'] ?? 'Genap per 1 Juli tahun pelajaran berjalan.' }}</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="p-2 bg-white rounded border">
                <span class="badge bg-warning text-dark me-1">Khusus</span>
                <strong>5 Tahun 6 Bulan</strong>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $settings['tatacara_usia_khusus'] ?? 'Wajib rekomendasi tertulis dari psikolog/ahli.' }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ============================================
     6. FAQ (PERTANYAAN YANG SERING DIAJUKAN)
============================================ -->
<section class="py-5" id="faq">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1 rounded-pill mb-2">FAQ Bantuan</span>
      <h2 class="section-title">Pertanyaan yang Sering Diajukan (FAQ)</h2>
      <p class="section-subtitle mx-auto" style="max-width: 600px;">
        Temukan jawaban cepat atas pertanyaan seputar tata cara pendaftaran, berkas, dan observasi di SD Islam Plus Al-Wafa Batam.
      </p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="accordion faq-accordion" id="accordionFaq">

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
                <i class="bi bi-question-circle me-2 text-success"></i> Bagaimana cara membuat akun jika saya belum pernah mendaftar?
              </button>
            </h2>
            <div id="faqOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionFaq">
              <div class="accordion-body">
                Klik tombol <strong>Daftar</strong> di pojok kanan atas atau buka halaman <a href="{{ route('register') }}" class="text-success fw-bold">Pendaftaran Akun Baru</a>. Masukkan nama lengkap wali murid, email aktif, nomor WhatsApp yang dapat dihubungi, serta buat kata sandi. Setelah itu Anda bisa langsung masuk ke portal untuk mendaftarkan anak Anda.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                <i class="bi bi-question-circle me-2 text-success"></i> Apakah anak yang berusia kurang dari 6 tahun bisa mendaftar?
              </button>
            </h2>
            <div id="faqTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionFaq">
              <div class="accordion-body">
                Sesuai regulasi pemerintah, usia minimal adalah 6 tahun pada tanggal 1 Juli tahun pelajaran berjalan. Bagi calon siswa yang berusia antara 5 tahun 6 bulan hingga 6 tahun dapat dipertimbangkan jika memiliki kecerdasan/bakat istimewa dan kesiapan psikis yang dibuktikan dengan surat rekomendasi tertulis dari psikolog profesional.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                <i class="bi bi-question-circle me-2 text-success"></i> Apa saja materi observasi dan tes calon siswa baru?
              </button>
            </h2>
            <div id="faqThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionFaq">
              <div class="accordion-body">
                Observasi di SD Islam Plus Al-Wafa Batam dirancang ramah anak (tidak membuat anak tertekan). Materi observasi meliputi: kesiapan motorik (menulis sederhana, mewarnai, menggunting), kematangan emosional dan kemandirian, pengenalan huruf hijaiyah / baca Iqra, hafalan surat-surat pendek, serta doa harian.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqFour" aria-expanded="false" aria-controls="faqFour">
                <i class="bi bi-question-circle me-2 text-success"></i> Apakah biaya masuk (uang pangkal) dapat diangsur?
              </button>
            </h2>
            <div id="faqFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionFaq">
              <div class="accordion-body">
                Ya, Yayasan Daarul Aitam dan pihak sekolah menyediakan skema keringanan berupa pembayaran biaya masuk/daftar ulang secara berangsur sesuai kesepakatan saat sesi wawancara keuangan dengan pihak sekolah.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqFive" aria-expanded="false" aria-controls="faqFive">
                <i class="bi bi-question-circle me-2 text-success"></i> Bagaimana jika berkas Akta Kelahiran masih dalam proses pembuatan?
              </button>
            </h2>
            <div id="faqFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionFaq">
              <div class="accordion-body">
                Bapak/Ibu tetap dapat mendaftar dengan melampirkan <strong>Surat Keterangan Lahir dari Bidan/Rumah Sakit</strong> dan Kartu Keluarga sementara, dengan komitmen menyerahkan fotokopi Akta Kelahiran resmi begitu dokumen selesai diterbitkan oleh Dinas Kependudukan dan Catatan Sipil.
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================
     7. HELPDESK & CALL TO ACTION
============================================ -->
<div class="container my-5">
  <div class="helpdesk-card">
    <div class="row align-items-center">
      <div class="col-lg-8 mb-3 mb-lg-0">
        <h3 class="fw-bold mb-2">Mengalami Kesulitan Saat Mendaftar?</h3>
        <p class="text-white-50 mb-0" style="font-size: 0.95rem;">
          Panitia PPDB SD Islam Plus Al-Wafa Batam siap mendampingi Anda melalui panduan langsung via WhatsApp atau kunjungan ke sekretariat sekolah.
        </p>
      </div>
      <div class="col-lg-4 text-lg-end">
        <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
          <a href="{{ $waUrl }}?text={{ urlencode('Assalamu’alaikum Panitia PPDB SD Islam Plus Al-Wafa, saya ingin berkonsultasi mengenai alur pendaftaran siswa baru') }}" target="_blank" class="btn btn-light fw-bold px-4 py-2 rounded-pill text-success d-inline-flex align-items-center gap-2">
            <i class="bi bi-whatsapp"></i> Chat WhatsApp Panitia
          </a>
          <a href="{{ route('biaya.publik') }}" class="btn btn-outline-light px-4 py-2 rounded-pill d-inline-flex align-items-center gap-2">
            <i class="bi bi-file-earmark-pdf"></i> Brosur &amp; Biaya
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ============================================
     8. FOOTER
============================================ -->
<footer class="footer-uis">
  <div class="container">
    <div class="row g-4 pb-4">
      <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo" style="height: 44px;" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
          <div>
            <strong class="text-white d-block" style="font-size: 1rem; letter-spacing: -0.2px;">SD ISLAM PLUS AL-WAFA</strong>
            <div class="small" style="color: #94a3b8;">{{ $settings['yayasan'] ?? 'Yayasan Daarul Aitam Batam' }}</div>
          </div>
        </div>
        <p class="small mb-3" style="color: #cbd5e1; max-width: 320px; line-height: 1.6;">
          Membentuk generasi Qur'ani yang beriman, berakhlak mulia, cakap digital, dan berwawasan global.
        </p>
        <div class="d-flex">
          <a href="#" class="footer-social-btn" title="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="footer-social-btn" title="Twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="footer-social-btn" title="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="footer-social-btn" title="YouTube"><i class="bi bi-youtube"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="footer-uis-heading">Kontak Kami</div>
        <div class="small mb-2" style="color: #cbd5e1; line-height: 1.6;">
          <i class="bi bi-geo-alt me-1 text-success"></i>
          {{ $settings['kontak_alamat'] ?? 'Bida Asri II Blok G2 No. 11 - 15 Kel. Belian, Kec. Batam Kota, Kota Batam' }}
        </div>
        <div class="small mb-2" style="color: #cbd5e1;">
          <i class="bi bi-telephone me-1 text-success"></i>
          Telp: {{ $settings['kontak_telepon'] ?? '0778 7495940' }} / WA: {{ $settings['kontak_whatsapp'] ?? '081266812015' }}
        </div>
        <div class="small" style="color: #cbd5e1;">
          <i class="bi bi-envelope me-1 text-success"></i>
          {{ $settings['kontak_email'] ?? 'sdipalwafa@gmail.com' }}
        </div>
      </div>

      <div class="col-6 col-lg-2 col-md-6">
        <div class="footer-uis-heading">Menu</div>
        <ul class="footer-uis-list">
          <li><a href="{{ route('homepage') }}#home"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Beranda</a></li>
          <li><a href="{{ route('homepage') }}#jalur"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Jalur Pendaftaran</a></li>
          <li><a href="{{ route('tatacara.publik') }}"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Tata Cara</a></li>
          <li><a href="{{ route('biaya.publik') }}"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Brosur &amp; Biaya</a></li>
          <li><a href="{{ route('informasi.index') }}"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Informasi</a></li>
        </ul>
      </div>

      <div class="col-6 col-lg-3 col-md-6">
        <div class="footer-uis-heading">Tautan</div>
        <ul class="footer-uis-list">
          <li><a href="{{ route('register') }}"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Pendaftaran Akun</a></li>
          <li><a href="{{ route('login') }}"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Portal PPDB Online</a></li>
          <li><a href="{{ route('biaya.publik') }}"><i class="bi bi-chevron-right small me-1 opacity-50"></i> Rincian Tarif &amp; Brosur</a></li>
          <li><a href="#"><i class="bi bi-chevron-right small me-1 opacity-50"></i> NPSN: {{ $settings['npsn'] ?? '69888848' }}</a></li>
        </ul>
      </div>
    </div>

    <div class="pt-3 border-top text-center small" style="color: #94a3b8; border-color: rgba(255, 255, 255, 0.15) !important;">
      Copyright &copy; {{ date('Y') }} <strong>SD Islam Plus Al-Wafa Batam</strong> &bull; Yayasan Daarul Aitam
    </div>
  </div>
</footer>

<!-- Floating WhatsApp Button -->
<a href="{{ $waUrl }}?text={{ urlencode('Assalamu’alaikum Admin PPDB SD Islam Plus Al-Wafa, saya butuh bantuan pendaftaran') }}" target="_blank" class="floating-wa-btn" title="Hubungi Kami via WhatsApp">
  <i class="bi bi-whatsapp fs-5"></i>
  <span>Butuh Bantuan? Hubungi Kami!</span>
</a>

<!-- Bootstrap 5 JS Bundle -->
<script src="{{ asset('homepage/assets/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
