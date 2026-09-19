<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">

  <title>Login PPDB - SD Islam Plus Al-Wafa Batam</title>
  <meta content="Portal Penerimaan Peserta Didik Baru (PPDB) SD Islam Plus Al-Wafa Batam - Yayasan Daarul Aitam Batam" name="description">
  <meta content="PPDB, SD Islam Plus Al-Wafa, Batam, Sekolah Islam, Tahfidz" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" rel="icon">
  <link href="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <style>
    :root {
      --primary-emerald: #065f46;
      --primary-green: #047857;
      --accent-gold: #d97706;
      --accent-gold-light: #fbbf24;
      --light-bg: #f0fdf4;
      --surface-card: #ffffff;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
      --focus-ring: rgba(4, 120, 87, 0.2);
    }

    * {
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #0f766e 100%);
      color: var(--text-dark);
      overflow-x: hidden;
    }

    .auth-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem 1rem;
      position: relative;
    }

    /* Decorative Islamic Geometric subtle background elements */
    .bg-pattern {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
      background-size: 24px 24px;
      pointer-events: none;
      z-index: 0;
    }

    .bg-glow-1 {
      position: absolute;
      width: 450px;
      height: 450px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(16, 185, 129, 0.25) 0%, transparent 70%);
      top: -100px;
      left: -100px;
      pointer-events: none;
      filter: blur(40px);
    }

    .bg-glow-2 {
      position: absolute;
      width: 400px;
      height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(245, 158, 11, 0.2) 0%, transparent 70%);
      bottom: -80px;
      right: -80px;
      pointer-events: none;
      filter: blur(40px);
    }

    /* Main Auth Container Card */
    .auth-card {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 1080px;
      background: var(--surface-card);
      border-radius: 24px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);
      overflow: hidden;
      margin: auto;
    }

    /* Left Side: School Branding Hero */
    .brand-side {
      background: linear-gradient(160deg, #064e3b 0%, #065f46 50%, #047857 100%);
      color: #ffffff;
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }

    .brand-side::before {
      content: "";
      position: absolute;
      inset: 0;
      background: url("{{ asset('assets/img/school-banner.jpg') }}") center center / cover no-repeat;
      opacity: 0.12;
      mix-blend-mode: luminosity;
      pointer-events: none;
    }

    .brand-side::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom, rgba(6, 78, 59, 0.88), rgba(4, 120, 87, 0.95));
      pointer-events: none;
    }

    .brand-content {
      position: relative;
      z-index: 2;
    }

    .logo-container {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 84px;
      height: 84px;
      background: #ffffff;
      border-radius: 20px;
      padding: 8px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2), 0 0 0 3px rgba(251, 191, 36, 0.4);
      margin-bottom: 1.5rem;
      transition: transform 0.3s ease;
    }

    .logo-container:hover {
      transform: scale(1.05);
    }

    .logo-container img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
    }

    .badge-school {
      display: inline-block;
      background: rgba(251, 191, 36, 0.18);
      color: #fef08a;
      border: 1px solid rgba(251, 191, 36, 0.4);
      padding: 0.35rem 0.85rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-bottom: 0.75rem;
    }

    .brand-title {
      font-size: 1.75rem;
      font-weight: 800;
      line-height: 1.25;
      color: #ffffff;
      margin-bottom: 0.5rem;
    }

    .brand-subtitle {
      font-size: 0.95rem;
      color: #a7f3d0;
      font-weight: 500;
      margin-bottom: 1.75rem;
      line-height: 1.5;
    }

    .feature-list {
      list-style: none;
      padding: 0;
      margin: 0 0 2rem 0;
    }

    .feature-item {
      display: flex;
      align-items: flex-start;
      gap: 0.85rem;
      margin-bottom: 1rem;
      font-size: 0.875rem;
      color: #ecfdf5;
    }

    .feature-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 28px;
      height: 28px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.15);
      color: var(--accent-gold-light);
      flex-shrink: 0;
      font-size: 0.9rem;
    }

    .brand-footer {
      position: relative;
      z-index: 2;
      border-top: 1px solid rgba(255, 255, 255, 0.15);
      padding-top: 1.25rem;
      font-size: 0.78rem;
      color: #a7f3d0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    /* Right Side: Login Form */
    .form-side {
      padding: 3rem 2.75rem;
      background: #ffffff;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-header {
      margin-bottom: 2rem;
    }

    .form-header h2 {
      font-size: 1.65rem;
      font-weight: 800;
      color: var(--text-dark);
      margin-bottom: 0.35rem;
      letter-spacing: -0.5px;
    }

    .form-header p {
      color: var(--text-muted);
      font-size: 0.9rem;
      margin-bottom: 0;
    }

    .form-label {
      font-size: 0.825rem;
      font-weight: 600;
      color: #334155;
      margin-bottom: 0.4rem;
    }

    .input-group-modern {
      position: relative;
      display: flex;
      align-items: center;
      background: #f8fafc;
      border: 1.5px solid var(--border-color);
      border-radius: 12px;
      transition: all 0.25s ease;
      overflow: hidden;
    }

    .input-group-modern:focus-within {
      border-color: var(--primary-green);
      background: #ffffff;
      box-shadow: 0 0 0 4px var(--focus-ring);
    }

    .input-group-modern.is-invalid {
      border-color: #ef4444;
      box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
    }

    .input-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0 0.9rem;
      color: #94a3b8;
      font-size: 1.15rem;
      transition: color 0.2s ease;
    }

    .input-group-modern:focus-within .input-icon {
      color: var(--primary-green);
    }

    .input-modern {
      width: 100%;
      border: none;
      background: transparent;
      padding: 0.8rem 0.9rem 0.8rem 0;
      font-size: 0.925rem;
      color: var(--text-dark);
      font-family: inherit;
      outline: none;
    }

    .input-modern::placeholder {
      color: #94a3b8;
      font-size: 0.875rem;
    }

    .btn-toggle-password {
      border: none;
      background: transparent;
      color: #94a3b8;
      padding: 0 1rem;
      cursor: pointer;
      font-size: 1.15rem;
      transition: color 0.2s ease;
      display: flex;
      align-items: center;
    }

    .btn-toggle-password:hover {
      color: var(--primary-green);
    }



    .btn-login {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      color: #ffffff;
      border: none;
      border-radius: 12px;
      padding: 0.85rem 1.5rem;
      font-size: 0.95rem;
      font-weight: 700;
      letter-spacing: 0.2px;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.6rem;
      box-shadow: 0 10px 20px -5px rgba(4, 120, 87, 0.35);
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, #047857 0%, #065f46 100%);
      transform: translateY(-2px);
      box-shadow: 0 14px 24px -5px rgba(4, 120, 87, 0.45);
      color: #ffffff;
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .register-prompt {
      text-align: center;
      font-size: 0.875rem;
      color: var(--text-muted);
      margin-top: 1.75rem;
    }

    .register-prompt a {
      color: var(--primary-green);
      font-weight: 700;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .register-prompt a:hover {
      color: var(--primary-emerald);
      text-decoration: underline;
    }



    /* Mobile Brand Strip (Shown only on small screens) */
    .mobile-brand-bar {
      display: none;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--border-color);
    }

    .mobile-brand-bar img {
      width: 46px;
      height: 46px;
      object-fit: contain;
    }

    .mobile-brand-text h3 {
      font-size: 1rem;
      font-weight: 700;
      color: var(--primary-emerald);
      margin: 0;
    }

    .mobile-brand-text p {
      font-size: 0.75rem;
      color: var(--text-muted);
      margin: 0;
    }

    /* Responsive Breakpoints - Strictly No Horizontal/Vertical Overflow */
    @media (max-width: 991.98px) {
      .auth-wrapper {
        padding: 1rem;
      }
      .brand-side {
        display: none; /* Hide heavy side on tablet & mobile */
      }
      .mobile-brand-bar {
        display: flex;
      }
      .form-side {
        padding: 2.25rem 1.75rem;
      }
      .auth-card {
        max-width: 480px;
      }
    }

    @media (max-width: 480px) {
      .form-side {
        padding: 1.75rem 1.25rem;
      }
      .form-header h2 {
        font-size: 1.45rem;
      }
    }
  </style>
</head>

<body>

  <div class="bg-pattern"></div>
  <div class="bg-glow-1"></div>
  <div class="bg-glow-2"></div>

  <main class="auth-wrapper">
    <div class="auth-card">
      <div class="row g-0">

        <!-- Sisi Kiri: Identitas Resmi SD Islam Plus Al-Wafa Batam -->
        <div class="col-lg-6 brand-side">
          <div class="brand-content">
            <div class="logo-container">
              <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo SD Islam Plus Al-Wafa Batam">
            </div>

            <div>
              <span class="badge-school">
                <i class="bi bi-star-fill me-1 text-warning"></i> Akreditasi B • NPSN: 69888848
              </span>
              <h1 class="brand-title">SD Islam Plus<br>Al-Wafa Batam</h1>
              <p class="brand-subtitle">
                Yayasan Daarul Aitam Batam (YDAB)<br>
                <em>"Membentuk Generasi Qur'ani, Berkarakter, Cerdas & Berakhlak Mulia"</em>
              </p>
            </div>

            <ul class="feature-list">
              <li class="feature-item">
                <div class="feature-icon"><i class="bi bi-book-half"></i></div>
                <div>
                  <strong>Program Tahfidz & Tartil Qur'an</strong>
                  <div class="text-white-50 small">Bimbingan hafalan dan tajwid terpadu</div>
                </div>
              </li>
              <li class="feature-item">
                <div class="feature-icon"><i class="bi bi-clock-history"></i></div>
                <div>
                  <strong>Islamic Full Day School</strong>
                  <div class="text-white-50 small">Pembiasaan ibadah harian dan adab Islami</div>
                </div>
              </li>
              <li class="feature-item">
                <div class="feature-icon"><i class="bi bi-mortarboard"></i></div>
                <div>
                  <strong>Kurikulum Holistik & Berkarakter</strong>
                  <div class="text-white-50 small">Pengembangan minat, bakat sains & keislaman</div>
                </div>
              </li>
            </ul>
          </div>

          <div class="brand-footer">
            <span><i class="bi bi-geo-alt me-1"></i> Belian, Batam Kota</span>
            <span>PPDB Online SD Islam Plus Al-Wafa</span>
          </div>
        </div>

        <!-- Sisi Kanan: Form Login Modern -->
        <div class="col-lg-6 form-side">

          <!-- Mobile Header Brand (Hanya tampil di Tablet/HP) -->
          <div class="mobile-brand-bar">
            <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo SD Al-Wafa">
            <div class="mobile-brand-text">
              <h3>SD Islam Plus Al-Wafa</h3>
              <p>Portal PPDB & Sistem Informasi</p>
            </div>
          </div>

          <div class="form-header">
            <h2>Masuk ke Akun</h2>
            <p>Silakan masukkan email & password Anda untuk melanjutkan</p>
          </div>

          <!-- Alert Notifikasi Berhasil -->
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="border-radius: 12px; font-size: 0.875rem;">
              <i class="bi bi-check-circle-fill me-2 fs-5"></i>
              <div>{{ session('success') }}</div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <!-- Alert Notifikasi Error -->
          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="border-radius: 12px; font-size: 0.875rem;">
              <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
              <div>{{ session('error') }}</div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if(isset($errors) && $errors->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="border-radius: 12px; font-size: 0.875rem;">
              <i class="bi bi-shield-lock-fill me-2 fs-5"></i>
              <div>{{ $errors->first('loginError') }}</div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <!-- Form Login -->
          <form action="{{ route('login.proses') }}" method="POST" novalidate>
            @csrf

            <!-- Input Email -->
            <div class="mb-3">
              <label for="inputEmail" class="form-label">Alamat Email</label>
              <div class="input-group-modern @error('email') is-invalid @enderror">
                <span class="input-icon"><i class="bi bi-envelope"></i></span>
                <input 
                  type="email" 
                  name="email" 
                  id="inputEmail" 
                  class="input-modern" 
                  value="{{ old('email') }}" 
                  placeholder="nama@email.com" 
                  autocomplete="email"
                  required
                >
              </div>
              @error('email')
                <div class="text-danger mt-1 small" style="font-size: 0.78rem;">
                  <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                </div>
              @enderror
            </div>

            <!-- Input Password dengan Fitur Toggle Show/Hide -->
            <div class="mb-4">
              <label for="inputPassword" class="form-label">Password</label>
              <div class="input-group-modern @error('password') is-invalid @enderror">
                <span class="input-icon"><i class="bi bi-lock"></i></span>
                <input 
                  type="password" 
                  name="password" 
                  id="inputPassword" 
                  class="input-modern" 
                  placeholder="Masukkan password" 
                  autocomplete="current-password"
                  required
                >
                <button type="button" class="btn-toggle-password" id="togglePasswordBtn" title="Tampilkan/Sembunyikan Password" tabindex="-1">
                  <i class="bi bi-eye" id="togglePasswordIcon"></i>
                </button>
              </div>
              @error('password')
                <div class="text-danger mt-1 small" style="font-size: 0.78rem;">
                  <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                </div>
              @enderror
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn-login">
              <span>Masuk ke Akun</span>
              <i class="bi bi-arrow-right"></i>
            </button>

            <!-- Link Pendaftaran Akun Baru -->
            <div class="register-prompt">
              Belum memiliki akun pendaftar? 
              <a href="{{ route('register') }}">Daftar PPDB Baru</a>
            </div>



          </form>

        </div>

      </div>
    </div>
  </main>

  <!-- Vendor JS -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Script Toggle Show/Hide Password -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggleBtn = document.getElementById('togglePasswordBtn');
      const passwordInput = document.getElementById('inputPassword');
      const toggleIcon = document.getElementById('togglePasswordIcon');

      if (toggleBtn && passwordInput && toggleIcon) {
        toggleBtn.addEventListener('click', function () {
          const isPassword = passwordInput.getAttribute('type') === 'password';
          passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
          
          if (isPassword) {
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
          } else {
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
          }
        });
      }
    });
  </script>

</body>

</html>