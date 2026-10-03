<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Portal Pendaftaran Siswa Baru &mdash; SD Islam Plus Al-Wafa Batam</title>
<meta name="description" content="Portal Resmi Penerimaan Peserta Didik Baru (PPDB) SD Islam Plus Al-Wafa Batam TP 2026/2027. Cari jalur pendaftaran, rincian biaya, program tahfidz, dan kelas tematik Sahabat Nabi.">
<meta name="keywords" content="PPDB SD Al-Wafa, SD Islam Plus Al-Wafa Batam, Pendaftaran Siswa Baru Batam, Yayasan Daarul Aitam">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito+Sans:wght@400;500;600;700&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

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

  .arabic-text {
    font-family: 'Amiri', serif;
    direction: rtl;
    font-size: 1.4rem;
    color: var(--uis-primary);
  }

  /* ---------- NAVBAR ---------- */
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
  .navbar-nav {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    gap: 20px;
  }
  .navbar-nav .nav-link {
    font-size: 0.92rem;
    font-weight: 500;
    color: #334155;
    padding: 6px 4px !important;
    white-space: nowrap !important;
    transition: color 0.2s ease;
  }
  .navbar-nav .nav-link:hover,
  .navbar-nav .nav-link.active {
    color: var(--uis-primary);
    font-weight: 600;
  }

  /* Button Masuk Navbar */
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
    justify-content: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
  }
  .btn-uis-outline:hover {
    background: var(--uis-primary);
    color: #ffffff !important;
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
    justify-content: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
  }
  .btn-uis-primary:hover {
    background: var(--uis-primary-dark);
    border-color: var(--uis-primary-dark);
    color: #ffffff !important;
  }

  /* ---------- HERO SECTION ---------- */
  .hero-uis {
    background: linear-gradient(135deg, #044d2e 0%, #035e38 60%, #05824e 100%);
    position: relative;
    padding: 60px 0 95px;
    color: #ffffff;
    overflow: hidden;
  }
  .hero-uis::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1.5px, transparent 1.5px);
    background-size: 24px 24px;
    opacity: 0.7;
    pointer-events: none;
  }
  .hero-headline {
    font-size: clamp(2rem, 3.5vw, 2.75rem);
    font-weight: 800;
    line-height: 1.25;
    margin-bottom: 12px;
  }
  .hero-subtitle {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.88);
    max-width: 620px;
    margin-bottom: 0;
    line-height: 1.6;
  }
  .hero-badge-tag {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #ffffff;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 16px;
  }

  /* ---------- FLOATING FILTER CARD ---------- */
  .floating-filter-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--uis-border);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
    padding: 26px 30px;
    margin-top: -55px;
    position: relative;
    z-index: 10;
  }
  .filter-card-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 3px;
  }
  .filter-card-subtitle {
    font-size: 0.84rem;
    color: #64748b;
    margin-bottom: 18px;
  }
  .form-select-uis {
    font-size: 0.88rem;
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    color: #334155;
    background-color: #f8fafc;
  }
  .form-select-uis:focus {
    border-color: var(--uis-primary);
    box-shadow: 0 0 0 3px rgba(5, 130, 78, 0.15);
  }
  .btn-search-uis {
    background: var(--uis-primary);
    color: #ffffff;
    font-weight: 600;
    font-size: 0.9rem;
    border-radius: 8px;
    padding: 10px 20px;
    border: none;
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: background 0.2s;
  }
  .btn-search-uis:hover {
    background: var(--uis-primary-dark);
    color: #ffffff;
  }

  /* ---------- SECTION CONTENT STYLING ---------- */
  .uis-card {
    background: #ffffff;
    border: 1px solid var(--uis-border);
    border-radius: 16px;
    padding: 26px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
  }
  .uis-card-header-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 16px;
  }

  /* Tab Pills Program Studi */
  .pill-filter-btn {
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 6px 16px;
    border-radius: 8px;
    margin-right: 8px;
    margin-bottom: 8px;
    transition: all 0.2s ease;
    cursor: pointer;
  }
  .pill-filter-btn:hover,
  .pill-filter-btn.active {
    border-color: var(--uis-primary);
    color: var(--uis-primary);
    background: var(--uis-primary-light);
  }

  /* List Item Program / Kelas */
  .program-item-card {
    border: 1px solid var(--uis-border);
    border-radius: 12px;
    padding: 16px 20px;
    margin-top: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #ffffff;
    transition: border-color 0.2s;
  }
  .program-item-card:hover {
    border-color: var(--uis-primary);
  }
  .program-item-title {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.95rem;
    margin-bottom: 2px;
  }
  .program-item-desc {
    font-size: 0.8rem;
    color: #64748b;
    margin-bottom: 0;
  }

  /* Steps List Tata Cara */
  .uis-step-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
  }
  .uis-step-item {
    position: relative;
    padding-left: 28px;
    margin-bottom: 16px;
  }
  .uis-step-item:last-child {
    margin-bottom: 0;
  }
  .uis-step-num {
    position: absolute;
    left: 0;
    top: 2px;
    font-weight: 700;
    color: var(--uis-primary);
    font-size: 0.9rem;
  }
  .uis-step-title {
    font-weight: 700;
    font-size: 0.88rem;
    color: #0f172a;
    margin-bottom: 2px;
  }
  .uis-step-desc {
    font-size: 0.8rem;
    color: #64748b;
    line-height: 1.5;
    margin-bottom: 0;
  }

  /* ---------- SECTION PENGUMUMAN ---------- */
  .announcement-card {
    background: #ffffff;
    border: 1px solid var(--uis-border);
    border-radius: 16px;
    padding: 22px;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    transition: all 0.25s ease;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
  }
  .announcement-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.07);
    border-color: #86efac;
    color: inherit;
  }
  .announcement-icon-wrap {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
    border: 1px solid #e2e8f0;
  }
  .announcement-icon-wrap img {
    height: 38px;
    width: auto;
    object-fit: contain;
  }
  .announcement-date {
    font-size: 0.78rem;
    color: #64748b;
    margin-bottom: 6px;
    font-weight: 500;
  }
  .announcement-title {
    font-weight: 700;
    font-size: 0.92rem;
    color: #0f172a;
    line-height: 1.4;
    margin-bottom: 14px;
    flex-grow: 1;
  }
  .announcement-badge-pengumuman {
    background: #fef3c7;
    color: #b45309;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 50px;
    display: inline-block;
    width: fit-content;
  }
  .announcement-badge-info {
    background: #e0f2fe;
    color: #0369a1;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 50px;
    display: inline-block;
    width: fit-content;
  }

  /* ---------- CALL TO ACTION (KAMI SIAP MEMBANTU ANDA) ---------- */
  .cta-uis-banner {
    background: linear-gradient(135deg, #eab308 0%, #d97706 100%);
    border-radius: 18px;
    padding: 38px 44px;
    color: #ffffff;
    box-shadow: 0 12px 30px rgba(217, 119, 6, 0.2);
    position: relative;
    overflow: hidden;
    margin: 50px 0;
  }
  .cta-uis-banner::before {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 45%;
    background-image: url('{{ asset('assets/img/school-banner.jpg') }}');
    background-size: cover;
    background-position: center;
    opacity: 0.22;
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
    color: #d97706 !important;
    border-color: #ffffff;
  }

  /* ---------- FOOTER ---------- */
  .footer-uis {
    background: #ffffff;
    border-top: 1px solid var(--uis-border);
    padding: 50px 0 25px;
    font-size: 0.85rem;
    color: #475569;
  }
  .footer-uis-heading {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 16px;
  }
  .footer-uis-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
  }
  .footer-uis-list li {
    margin-bottom: 8px;
  }
  .footer-uis-list a {
    color: #64748b;
    text-decoration: none;
    transition: color 0.2s;
  }
  .footer-uis-list a:hover {
    color: var(--uis-primary);
  }
  .footer-social-btn {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #475569;
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
  }

  /* Floating WhatsApp Button */
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
      <!-- 4 Menu Utama Sesuai Referensi -->
      <ul class="navbar-nav mx-auto mt-3 mt-lg-0">
        <li class="nav-item"><a class="nav-link active" href="#home">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#jalur">Jalur Pendaftaran</a></li>
        <li class="nav-item"><a class="nav-link" href="#program">Program Studi</a></li>
        <li class="nav-item"><a class="nav-link" href="#informasi">Informasi</a></li>
      </ul>

      <!-- Sisi Kanan: ID Language + Tombol Masuk -->
      <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0 flex-shrink-0">
        <span class="small text-muted fw-semibold d-none d-sm-inline">ID <i class="bi bi-globe2 ms-1"></i></span>
        @auth
          <a href="{{ route('dashboard') }}" class="btn-uis-outline">
            <i class="bi bi-grid-fill"></i> Dashboard
          </a>
        @else
          <a href="{{ route('login') }}" class="btn-uis-outline">
            Masuk
          </a>
        @endauth
      </div>
    </div>
  </div>
</nav>

<!-- ============================================
     2. HERO BANNER
============================================ -->
<header id="home" class="hero-uis">
  <div class="container position-relative">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <div class="hero-badge-tag">
          <i class="bi bi-mortarboard-fill text-warning"></i>
          <span>{{ $settings['hero_badge'] ?? '#SDIPAlWafaUnggul' }} &bull; Akreditasi Resmi &bull; Yayasan Daarul Aitam</span>
        </div>
        <h1 class="hero-headline">
          {{ $settings['hero_judul'] ?? 'Portal Pendaftaran Siswa Baru' }}
        </h1>
        <p class="hero-subtitle">
          {{ $settings['hero_subjudul'] ?? 'Cari tahu informasi program kelas, rincian biaya sekolah, dan informasi pendaftaran di SD Islam Plus Al-Wafa Batam' }}
        </p>
      </div>
      <div class="col-lg-4 text-end d-none d-lg-block">
        <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="SD Islam Plus Al-Wafa Batam" style="max-height: 150px; opacity: 0.9;" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
      </div>
    </div>
  </div>
</header>

<!-- ============================================
     3. FLOATING FILTER CARD (CARI JALUR PENDAFTARAN)
============================================ -->
<div class="container">
  <div class="floating-filter-card">
    <div class="filter-card-title">Cari Jalur Pendaftaran</div>
    <div class="filter-card-subtitle">Temukan jalur pendaftaran sesuai dengan pilihan tingkat kelas yang diminati.</div>

    <form id="filterForm" onsubmit="handleCariJalur(event)">
      <div class="row g-3 align-items-center">
        <!-- 1. Pilih Jenjang / Tingkat -->
        <div class="col-md-3">
          <select class="form-select form-select-uis" id="selectTingkat">
            <option value="all">-- Pilih Jenjang / Tingkat --</option>
            <option value="Kelas I">Kelas I (Siswa Baru)</option>
            <option value="Kelas II">Kelas II</option>
            <option value="Kelas III">Kelas III</option>
            <option value="Kelas IV">Kelas IV</option>
            <option value="Kelas V">Kelas V</option>
            <option value="Kelas VI">Kelas VI</option>
          </select>
        </div>

        <!-- 2. Pilih Program / Kelas -->
        <div class="col-md-3">
          <select class="form-select form-select-uis" id="selectKelas">
            <option value="all">-- Pilih Program / Kelas --</option>
            @foreach($daftarKelas as $k)
              <option value="{{ $k['rombel'] }}">{{ $k['rombel'] }} - {{ $k['nama'] }}</option>
            @endforeach
          </select>
        </div>

        <!-- 3. Pilih Jalur Pendaftaran -->
        <div class="col-md-3">
          <select class="form-select form-select-uis" id="selectJalur">
            <option value="all">-- Pilih Jalur Pendaftaran --</option>
            @forelse($jalurList as $j)
              <option value="{{ $j->nama_jalur }}">{{ $j->nama_jalur }}</option>
            @empty
              <option value="Reguler">Jalur Reguler</option>
              <option value="Prestasi">Jalur Prestasi / Tahfidz</option>
              <option value="Afirmasi">Jalur Afirmasi / Beasiswa</option>
            @endforelse
          </select>
        </div>

        <!-- 4. Tombol Submit -->
        <div class="col-md-3">
          <button type="submit" class="btn-search-uis">
            <i class="bi bi-search"></i> Cari Jalur Pendaftaran
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- ============================================
     4. MIDDLE 2-COLUMN CONTENT GRID
============================================ -->
<main class="py-5" id="program">
  <div class="container">
    <div class="row g-4">

      <!-- ================= KOLOM KIRI (PROGRAM STUDI & KELAS) ================= -->
      <div class="col-lg-7">
        <div class="uis-card">
          <div class="uis-card-header-title">Informasi Program Studi &amp; Kelas</div>

          <!-- Filter Pill Tabs -->
          <div class="d-flex flex-wrap mb-3">
            <button type="button" class="pill-filter-btn active" onclick="filterProgramTab('Kelas I', this)">Kelas I</button>
            <button type="button" class="pill-filter-btn" onclick="filterProgramTab('Kelas II-III', this)">Kelas II - III</button>
            <button type="button" class="pill-filter-btn" onclick="filterProgramTab('Kelas IV-VI', this)">Kelas IV - VI</button>
            <button type="button" class="pill-filter-btn" onclick="filterProgramTab('tahfidz', this)">Program Tahfidz</button>
            <button type="button" class="pill-filter-btn" onclick="filterProgramTab('all', this)">Semua Rombel</button>
          </div>

          <!-- Daftar Rombel / Program Cards -->
          <div id="programListContainer">
            @foreach($daftarKelas as $k)
              @php
                $tabGroup = 'Kelas IV-VI';
                if ($k['tingkat'] === 'Kelas I') {
                  $tabGroup = 'Kelas I';
                } elseif (in_array($k['tingkat'], ['Kelas II', 'Kelas III'])) {
                  $tabGroup = 'Kelas II-III';
                }
              @endphp
              <div class="program-item-card" data-tingkat="{{ $k['tingkat'] }}" data-group="{{ $tabGroup }}" data-rombel="{{ $k['rombel'] }}">
                <div>
                  <div class="program-item-title">
                    <span class="badge bg-success-subtle text-success me-1 border border-success-subtle">{{ $k['rombel'] }}</span>
                    {{ $k['nama'] }}
                    <span class="arabic-text ms-2 small d-none d-sm-inline">{{ $k['arab'] }}</span>
                  </div>
                  <p class="program-item-desc">
                    Wali Kelas: <strong>{{ $k['wali'] }}</strong> &bull; Pendamping: {{ $k['pendamping'] }}
                  </p>
                </div>
                <div>
                  <button type="button" class="btn-uis-outline" onclick="showModalDetailKelas('{{ $k['rombel'] }}', '{{ addslashes($k['nama']) }}', '{{ $k['arab'] }}', '{{ addslashes($k['wali']) }}', '{{ addslashes($k['pendamping']) }}', '{{ $k['tingkat'] }}')">
                    Lihat Detail
                  </button>
                </div>
              </div>
            @endforeach

            <!-- Card Khusus Program Tahfidz -->
            <div class="program-item-card" data-tingkat="Tahfidz" data-group="tahfidz" data-rombel="Tahfidz">
              <div>
                <div class="program-item-title">
                  <span class="badge bg-warning-subtle text-warning-emphasis me-1 border border-warning-subtle">Tahfidz</span>
                  Program Tahfidz &amp; Tartil Al-Qur'an Bersanad
                </div>
                <p class="program-item-desc">
                  Metode Tartil Mutqin, Target Juz 'Amma &amp; 30 Juz, dibimbing guru tahfidz tersertifikasi.
                </p>
              </div>
              <div>
                <button type="button" class="btn-uis-outline" onclick="showModalTahfidz()">
                  Lihat Detail
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- ================= KOLOM KANAN (BROSUR & TATA CARA) ================= -->
      <div class="col-lg-5" id="jalur">
        <!-- Card 1: Brosur Dan Informasi Biaya -->
        <div class="uis-card">
          <div class="uis-card-header-title">{{ $settings['brosur_judul'] ?? 'Brosur Dan Informasi Biaya' }}</div>
          <p class="text-muted small mb-3">
            {{ $settings['brosur_deskripsi'] ?? 'Brosur dan rincian biaya selama bersekolah di SD Islam Plus Al-Wafa Batam' }}
          </p>
          <div class="d-flex gap-2">
            <button type="button" class="btn-uis-outline" data-bs-toggle="modal" data-bs-target="#modalBiaya">
              <i class="bi bi-cash-coin me-1"></i> Lihat Detail Biaya
            </button>
            @if(!empty($settings['brosur_file']))
              <a href="{{ asset($settings['brosur_file']) }}" target="_blank" class="btn-uis-primary">
                <i class="bi bi-file-earmark-pdf me-1"></i> Unduh Brosur
              </a>
            @else
              <a href="#modalBiaya" data-bs-toggle="modal" class="btn-uis-primary">
                <i class="bi bi-file-earmark-text me-1"></i> Rincian Tarif
              </a>
            @endif
          </div>
        </div>

        <!-- Card 2: Tata Cara Pendaftaran Calon Siswa Baru -->
        <div class="uis-card">
          <div class="uis-card-header-title">Tata Cara Pendaftaran Siswa Baru</div>

          <ul class="uis-step-list">
            <li class="uis-step-item">
              <span class="uis-step-num">1.</span>
              <div class="uis-step-title">{{ $settings['tatacara_1_judul'] ?? 'Pilih Jalur Pendaftaran' }}</div>
              <p class="uis-step-desc">{{ $settings['tatacara_1_desc'] ?? 'Tentukan jalur masuk sesuai pilihan dan ketentuan sekolah.' }}</p>
            </li>
            <li class="uis-step-item">
              <span class="uis-step-num">2.</span>
              <div class="uis-step-title">{{ $settings['tatacara_2_judul'] ?? 'Isi Formulir Pendaftaran' }}</div>
              <p class="uis-step-desc">{{ $settings['tatacara_2_desc'] ?? 'Lengkapi data diri calon siswa dan orang tua pada formulir online secara benar.' }}</p>
            </li>
            <li class="uis-step-item">
              <span class="uis-step-num">3.</span>
              <div class="uis-step-title">{{ $settings['tatacara_3_judul'] ?? 'Bayar Biaya Pendaftaran' }}</div>
              <p class="uis-step-desc">{{ $settings['tatacara_3_desc'] ?? 'Lakukan pembayaran biaya formulir sesuai petunjuk yang tersedia.' }}</p>
            </li>
            <li class="uis-step-item">
              <span class="uis-step-num">4.</span>
              <div class="uis-step-title">{{ $settings['tatacara_4_judul'] ?? 'Unggah Berkas &amp; Ikuti Seleksi' }}</div>
              <p class="uis-step-desc">{{ $settings['tatacara_4_desc'] ?? 'Kirim dokumen dan ikuti tahapan observasi kematangan sesuai jadwal.' }}</p>
            </li>
          </ul>

          <div class="mt-4 pt-3 border-top text-center">
            <a href="{{ route('register') }}" class="btn-uis-primary w-100 py-2">
              <i class="bi bi-pencil-square me-1"></i> Daftar Akun PPDB Sekarang
            </a>
          </div>
        </div>

      </div>

    </div>
  </div>
</main>

<!-- ============================================
     5. SECTION INFORMASI & PENGUMUMAN
============================================ -->
<section class="py-5 bg-white" id="informasi">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold text-dark mb-0">Informasi &amp; Pengumuman</h3>
      <a href="{{ route('login') }}" class="text-decoration-none fw-semibold small" style="color: var(--uis-primary);">
        Lihat Semua Informasi <i class="bi bi-chevron-right"></i>
      </a>
    </div>

    <div class="row g-4">
      @if(isset($pengumumanList) && $pengumumanList->count() > 0)
        @foreach($pengumumanList as $idx => $p)
          <div class="col-lg-3 col-md-6">
            <div class="announcement-card" onclick="showModalPengumuman('{{ addslashes($p->judul) }}', '{{ $p->tanggal_buka ? $p->tanggal_buka->translatedFormat('d F Y') : date('d F Y') }}', '{{ addslashes($p->isi_pengumuman) }}')">
              <div class="announcement-icon-wrap">
                <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
              </div>
              <div class="announcement-date">
                {{ $p->tanggal_buka ? $p->tanggal_buka->translatedFormat('d F Y') : date('d F Y') }}
              </div>
              <div class="announcement-title">
                {{ Str::limit($p->judul, 70) }}
              </div>
              <span class="{{ $idx === 3 ? 'announcement-badge-info' : 'announcement-badge-pengumuman' }}">
                {{ $idx === 3 ? 'Informasi' : 'Pengumuman' }}
              </span>
            </div>
          </div>
        @endforeach
      @else
        <!-- Fallback 4 Kartu Pengumuman Realistis Sesuai Referensi -->
        <div class="col-lg-3 col-md-6">
          <div class="announcement-card" onclick="showModalPengumuman('PENGUMUMAN PELAKSANAAN OBSERVASI KEMATANGAN & TES BACA TAHFIDZ AL-QUR\'AN TP 2026/2027', '30 Juli 2026', 'Diberitahukan kepada seluruh calon wali murid bahwa observasi kematangan anak dan tes kemampuan membaca Al-Qur\'an akan dilaksanakan bertahap di kampus SD Islam Plus Al-Wafa Batam.')">
            <div class="announcement-icon-wrap">
              <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
            </div>
            <div class="announcement-date">30 Juli 2026</div>
            <div class="announcement-title">PENGUMUMAN PELAKSANAAN OBSERVASI KEMATANGAN &amp; TAHFIDZ...</div>
            <span class="announcement-badge-pengumuman">Pengumuman</span>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="announcement-card" onclick="showModalPengumuman('JADWAL PENDAFTARAN GELOMBANG 1 PPDB SD ISLAM PLUS AL-WAFA BATAM', '21 Juli 2026', 'Pendaftaran PPDB Gelombang 1 telah resmi dibuka. Dapatkan potongan biaya pendaftaran serta jaminan alokasi rombel kelas tematik Sahabat Nabi.')">
            <div class="announcement-icon-wrap">
              <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
            </div>
            <div class="announcement-date">21 Juli 2026</div>
            <div class="announcement-title">PENGUMUMAN JADWAL GELOMBANG 1 PPDB SD ISLAM PLUS AL-WAFA...</div>
            <span class="announcement-badge-pengumuman">Pengumuman</span>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="announcement-card" onclick="showModalPengumuman('PENGUMUMAN HASIL KELULUSAN OBSERVASI & WAWANCARA ORANG TUA', '25 April 2026', 'Hasil verifikasi administrasi dan keputusan kelulusan calon siswa baru dapat dicek langsung melalui akun dashboard orang tua masing-masing.')">
            <div class="announcement-icon-wrap">
              <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
            </div>
            <div class="announcement-date">25 April 2026</div>
            <div class="announcement-title">PENGUMUMAN HASIL OBSERVASI UNTUK CALON SISWA BARU...</div>
            <span class="announcement-badge-pengumuman">Pengumuman</span>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="announcement-card" onclick="showModalPengumuman('RINCIAN BIAYA PENDIDIKAN DAN UANG MASUK TP 2026/2027', '4 Februari 2026', 'Informasi resmi terkait rincian tarif SPP, biaya formulir, seragam, dan buku paket TP 2026/2027 telah dirilis dan dapat diangsur secara fleksibel.')">
            <div class="announcement-icon-wrap">
              <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
            </div>
            <div class="announcement-date">4 Februari 2026</div>
            <div class="announcement-title">RINCIAN BIAYA PENDIDIKAN &amp; PERLENGKAPAN TAHUN 2026/2027...</div>
            <span class="announcement-badge-info">Informasi</span>
          </div>
        </div>
      @endif
    </div>

    <!-- ============================================
         6. CALL TO ACTION BANNER (KAMI SIAP MEMBANTU ANDA)
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
            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $settings['kontak_whatsapp'] ?? '081266812015')) }}?text=Assalamu’alaikum%20Panitia%20PPDB%20SD%20Islam%20Plus%20Al-Wafa,%20saya%20ingin%20bertanya" target="_blank" class="btn-cta-white">
              <i class="bi bi-whatsapp"></i> WhatsApp
            </a>
            <button type="button" class="btn-cta-white" data-bs-toggle="modal" data-bs-target="#modalPetunjuk">
              <i class="bi bi-book"></i> Petunjuk Pendaftaran
            </button>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ============================================
     7. FOOTER 4 KOLOM
============================================ -->
<footer class="footer-uis">
  <div class="container">
    <div class="row g-4 pb-4">
      <!-- Kolom 1: Logo & Media Sosial -->
      <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo" style="height: 44px;" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
          <div>
            <div class="small text-muted fw-semibold">Seleksi Penerimaan Siswa Baru</div>
            <strong class="text-dark">SD Islam Plus Al-Wafa Batam</strong>
          </div>
        </div>
        <p class="small text-muted mb-3" style="max-width: 320px;">
          Membentuk generasi Qur'ani yang beriman, berakhlak mulia, cakap digital, dan berwawasan global.
        </p>
        <div class="d-flex">
          <a href="#" class="footer-social-btn" title="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="footer-social-btn" title="Twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="footer-social-btn" title="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="footer-social-btn" title="YouTube"><i class="bi bi-youtube"></i></a>
        </div>
      </div>

      <!-- Kolom 2: Kontak Kami -->
      <div class="col-lg-3 col-md-6">
        <div class="footer-uis-heading">Kontak Kami</div>
        <div class="small text-muted mb-2">
          <i class="bi bi-geo-alt me-1 text-success"></i>
          {{ $settings['kontak_alamat'] ?? 'Bida Asri II Blok G2 No. 11 - 15 Kel. Belian, Kec. Batam Kota, Kota Batam' }}
        </div>
        <div class="small text-muted mb-2">
          <i class="bi bi-telephone me-1 text-success"></i>
          Telp: {{ $settings['kontak_telepon'] ?? '0778 7495940' }} / WA: {{ $settings['kontak_whatsapp'] ?? '081266812015' }}
        </div>
        <div class="small text-muted">
          <i class="bi bi-envelope me-1 text-success"></i>
          {{ $settings['kontak_email'] ?? 'sdipalwafa@gmail.com' }}
        </div>
      </div>

      <!-- Kolom 3: Menu -->
      <div class="col-6 col-lg-2 col-md-6">
        <div class="footer-uis-heading">Menu</div>
        <ul class="footer-uis-list">
          <li><a href="#home">Beranda</a></li>
          <li><a href="#program">Program Studi</a></li>
          <li><a href="#informasi">Informasi dan Pengumuman</a></li>
          <li><a href="#jalur">Jalur Pendaftaran</a></li>
        </ul>
      </div>

      <!-- Kolom 4: Tautan -->
      <div class="col-6 col-lg-3 col-md-6">
        <div class="footer-uis-heading">Tautan</div>
        <ul class="footer-uis-list">
          <li><a href="#">Yayasan Daarul Aitam Batam</a></li>
          <li><a href="{{ route('login') }}">Portal PPDB Online</a></li>
          <li><a href="#modalBiaya" data-bs-toggle="modal">Rincian Tarif Biaya</a></li>
          <li><a href="#">NPSN: {{ $settings['npsn'] ?? '69888848' }} (Akreditasi B)</a></li>
          <li><a href="#modalPetunjuk" data-bs-toggle="modal">Petunjuk Pendaftaran</a></li>
        </ul>
      </div>
    </div>

    <!-- Copyright -->
    <div class="pt-3 border-top text-center text-muted small">
      Copyright &copy; {{ date('Y') }} <strong>SD Islam Plus Al-Wafa Batam</strong> &bull; Yayasan Daarul Aitam
    </div>
  </div>
</footer>

<!-- ============================================
     8. FLOATING WHATSAPP BUTTON (POJOK KANAN BAWAH)
============================================ -->
<a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $settings['kontak_whatsapp'] ?? '081266812015')) }}?text=Assalamu’alaikum%20Admin%20PPDB%20SD%20Islam%20Plus%20Al-Wafa,%20saya%20butuh%20bantuan" target="_blank" class="floating-wa-btn">
  <i class="bi bi-whatsapp fs-5"></i>
  <span>Butuh Bantuan? Hubungi Kami!</span>
</a>

<!-- ============================================
     9. MODALS DETAIL
============================================ -->

<!-- Modal Detail Kelas -->
<div class="modal fade" id="modalDetailKelas" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold text-dark" id="modalKelasTitle">Detail Rombel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="text-center p-3 mb-3 bg-light rounded-3">
          <div class="arabic-text fs-2 mb-1" id="modalKelasArab"></div>
          <div class="fw-bold text-success fs-5" id="modalKelasNama"></div>
          <span class="badge bg-success" id="modalKelasTingkat"></span>
        </div>
        <table class="table table-borderless small mb-0">
          <tr>
            <td class="text-muted fw-semibold" style="width: 140px;">Wali Kelas</td>
            <td>: <strong id="modalKelasWali" class="text-dark"></strong></td>
          </tr>
          <tr>
            <td class="text-muted fw-semibold">Guru Pendamping</td>
            <td>: <span id="modalKelasPendamping" class="text-dark"></span></td>
          </tr>
          <tr>
            <td class="text-muted fw-semibold">Kurikulum</td>
            <td>: Kurikulum Nasional Terpadu &bull; Tahfidz Al-Qur'an</td>
          </tr>
          <tr>
            <td class="text-muted fw-semibold">Fasilitas</td>
            <td>: Ruang Kelas Ber-AC, Multimedia, Loker Siswa, Perpustakaan</td>
          </tr>
        </table>
      </div>
      <div class="modal-footer border-0 pt-0">
        <a href="{{ route('register') }}" class="btn-uis-primary w-100 py-2">
          Daftar di Kelas Ini Sekarang
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Modal Rincian Biaya -->
<div class="modal fade" id="modalBiaya" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title fw-bold"><i class="bi bi-cash-coin me-2"></i>Rincian Tarif &amp; Biaya Pendidikan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <p class="text-muted small mb-3">
          Berikut adalah rincian komponen biaya pendaftaran dan pendidikan di SD Islam Plus Al-Wafa Batam Tahun Pelajaran 2026/2027:
        </p>
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Komponen Biaya</th>
                <th>Sifat</th>
                <th class="text-end">Nominal</th>
              </tr>
            </thead>
            <tbody>
              @forelse($biayaList as $idx => $b)
                <tr>
                  <td class="text-center">{{ $idx + 1 }}</td>
                  <td class="fw-semibold text-dark">{{ $b->nama_biaya }}</td>
                  <td>
                    <span class="badge {{ $b->is_wajib ? 'bg-danger-subtle text-danger' : 'bg-secondary-subtle text-secondary' }}">
                      {{ $b->is_wajib ? 'Wajib' : 'Opsional' }}
                    </span>
                  </td>
                  <td class="text-end fw-bold text-success font-monospace">
                    Rp {{ number_format($b->nominal, 0, ',', '.') }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted py-3">Rincian biaya dapat dikonfirmasi langsung dengan panitia PPDB.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="alert alert-warning small mb-0">
          <i class="bi bi-info-circle me-1"></i>
          {{ $settings['biaya_catatan'] ?? 'Pembayaran biaya masuk dapat diangsur secara fleksibel sesuai kesepakatan saat wawancara keuangan.' }}
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $settings['kontak_whatsapp'] ?? '081266812015')) }}?text=Halo%20Panitia,%20saya%20ingin%20tanya%20rincian%20biaya%20PPDB" target="_blank" class="btn btn-success btn-sm">
          <i class="bi bi-whatsapp me-1"></i> Konsultasi Biaya via WhatsApp
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Modal Petunjuk Pendaftaran -->
<div class="modal fade" id="modalPetunjuk" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold text-dark"><i class="bi bi-book-half text-success me-2"></i>Petunjuk Pendaftaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <ol class="small text-muted ps-3 mb-0" style="line-height: 1.8;">
          <li>Klik menu <strong>Masuk</strong> atau tombol <strong>Daftar Akun PPDB</strong> untuk membuat akun orang tua baru.</li>
          <li>Gunakan email dan nomor WhatsApp aktif saat mendaftar.</li>
          <li>Login ke dashboard orang tua untuk mengisi formulir biodata anak dan data wali.</li>
          <li>Upload scan dokumen wajib (Akta Kelahiran, KK, KTP Orang Tua, Pas Foto).</li>
          <li>Lakukan pembayaran formulir dan konfirmasi melalui dashboard.</li>
          <li>Ikuti jadwal observasi kematangan anak dan pengumuman hasil seleksi online.</li>
        </ol>
      </div>
      <div class="modal-footer border-0 pt-0">
        <a href="{{ route('register') }}" class="btn-uis-primary w-100 py-2">
          Mulai Pendaftaran Sekarang
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Modal Detail Pengumuman -->
<div class="modal fade" id="modalPengumuman" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold text-dark" id="modalPengumumanTitle">Pengumuman PPDB</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="badge bg-light text-muted border mb-2" id="modalPengumumanDate"></div>
        <p class="text-muted small mb-0" id="modalPengumumanContent" style="white-space: pre-line; line-height: 1.7;"></p>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="{{ asset('homepage/assets/bootstrap.bundle.min.js') }}"></script>

<script>
  // Filter Tab di Kolom Program Studi
  function filterProgramTab(group, btnElement) {
    document.querySelectorAll('.pill-filter-btn').forEach(function(b) {
      b.classList.remove('active');
    });
    btnElement.classList.add('active');

    var items = document.querySelectorAll('#programListContainer .program-item-card');
    items.forEach(function(item) {
      var itemGroup = item.getAttribute('data-group');
      if (group === 'all' || itemGroup === group) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });
  }

  // Handle Form Pencarian Jalur Pendaftaran
  function handleCariJalur(event) {
    event.preventDefault();
    var tingkat = document.getElementById('selectTingkat').value;
    var kelas = document.getElementById('selectKelas').value;

    // Reset pills
    document.querySelectorAll('.pill-filter-btn').forEach(function(b) {
      b.classList.remove('active');
    });

    var items = document.querySelectorAll('#programListContainer .program-item-card');
    items.forEach(function(item) {
      var itemTingkat = item.getAttribute('data-tingkat');
      var itemRombel = item.getAttribute('data-rombel');

      var match = true;
      if (tingkat !== 'all' && itemTingkat !== tingkat) {
        match = false;
      }
      if (kelas !== 'all' && itemRombel !== kelas) {
        match = false;
      }

      if (match) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });

    // Scroll mulus ke bagian program studi
    var programSection = document.getElementById('program');
    if (programSection) {
      programSection.scrollIntoView({ behavior: 'smooth' });
    }
  }

  // Modal Detail Kelas
  function showModalDetailKelas(rombel, nama, arab, wali, pendamping, tingkat) {
    document.getElementById('modalKelasTitle').innerText = 'Kelas ' + rombel + ' - ' + nama;
    document.getElementById('modalKelasNama').innerText = nama;
    document.getElementById('modalKelasArab').innerText = arab;
    document.getElementById('modalKelasTingkat').innerText = tingkat;
    document.getElementById('modalKelasWali').innerText = wali;
    document.getElementById('modalKelasPendamping').innerText = pendamping;

    var modal = new bootstrap.Modal(document.getElementById('modalDetailKelas'));
    modal.show();
  }

  // Modal Program Tahfidz
  function showModalTahfidz() {
    document.getElementById('modalKelasTitle').innerText = 'Program Tahfidz Al-Qur\'an Bersanad';
    document.getElementById('modalKelasNama').innerText = 'Tahfidz & Tartil Mutqin';
    document.getElementById('modalKelasArab').innerText = 'برنامج تحفيظ القرآن الكريم';
    document.getElementById('modalKelasTingkat').innerText = 'Program Unggulan';
    document.getElementById('modalKelasWali').innerText = 'Ustadz / Ustadzah Koordinator Tahfidz';
    document.getElementById('modalKelasPendamping').innerText = 'Muhaffizh & Muhaffizhah Bersanad';

    var modal = new bootstrap.Modal(document.getElementById('modalDetailKelas'));
    modal.show();
  }

  // Modal Pengumuman
  function showModalPengumuman(judul, tanggal, isi) {
    document.getElementById('modalPengumumanTitle').innerText = judul;
    document.getElementById('modalPengumumanDate').innerText = tanggal;
    document.getElementById('modalPengumumanContent').innerText = isi;

    var modal = new bootstrap.Modal(document.getElementById('modalPengumuman'));
    modal.show();
  }

  // Initial tab filter ke Kelas I saat pertama buka
  document.addEventListener('DOMContentLoaded', function () {
    var firstTab = document.querySelector('.pill-filter-btn.active');
    if (firstTab) {
      filterProgramTab('Kelas I', firstTab);
    }
  });
</script>

</body>
</html>
