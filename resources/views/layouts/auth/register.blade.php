<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">

  <title>Daftar PPDB Baru - SD Islam Plus Al-Wafa Batam</title>
  <meta content="Registrasi Calon Siswa Baru PPDB SD Islam Plus Al-Wafa Batam" name="description">

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

    .auth-card {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 540px;
      background: var(--surface-card);
      border-radius: 24px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);
      overflow: hidden;
      margin: auto;
      padding: 2.5rem 2.25rem;
    }

    .brand-header {
      text-align: center;
      margin-bottom: 1.75rem;
    }

    .logo-container {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 72px;
      height: 72px;
      background: #ffffff;
      border-radius: 18px;
      padding: 6px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08), 0 0 0 2px rgba(4, 120, 87, 0.15);
      margin-bottom: 0.85rem;
    }

    .logo-container img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
    }

    .brand-header h2 {
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--text-dark);
      margin-bottom: 0.25rem;
      letter-spacing: -0.5px;
    }

    .brand-header p {
      color: var(--text-muted);
      font-size: 0.875rem;
      margin: 0;
    }

    .form-label {
      font-size: 0.825rem;
      font-weight: 600;
      color: #334155;
      margin-bottom: 0.35rem;
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
      font-size: 1.1rem;
      transition: color 0.2s ease;
    }

    .input-group-modern:focus-within .input-icon {
      color: var(--primary-green);
    }

    .input-modern {
      width: 100%;
      border: none;
      background: transparent;
      padding: 0.75rem 0.9rem 0.75rem 0;
      font-size: 0.9rem;
      color: var(--text-dark);
      font-family: inherit;
      outline: none;
    }

    .input-modern::placeholder {
      color: #94a3b8;
      font-size: 0.85rem;
    }

    .btn-submit {
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
      gap: 0.5rem;
      box-shadow: 0 10px 20px -5px rgba(4, 120, 87, 0.35);
      transition: all 0.3s ease;
      cursor: pointer;
      margin-top: 1.25rem;
    }

    .btn-submit:hover {
      background: linear-gradient(135deg, #047857 0%, #065f46 100%);
      transform: translateY(-2px);
      box-shadow: 0 14px 24px -5px rgba(4, 120, 87, 0.45);
      color: #ffffff;
    }

    .login-prompt {
      text-align: center;
      font-size: 0.875rem;
      color: var(--text-muted);
      margin-top: 1.5rem;
    }

    .login-prompt a {
      color: var(--primary-green);
      font-weight: 700;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .login-prompt a:hover {
      color: var(--primary-emerald);
      text-decoration: underline;
    }

    @media (max-width: 576px) {
      .auth-card {
        padding: 1.75rem 1.25rem;
      }
    }
  </style>
</head>

<body>

  <div class="bg-pattern"></div>
  <div class="bg-glow-1"></div>

  <main class="auth-wrapper">
    <div class="auth-card">
      <div class="brand-header">
        <a href="{{ route('login') }}" class="logo-container">
          <img src="{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}" alt="Logo SD Al-Wafa">
        </a>
        <h2>Pendaftaran Akun PPDB</h2>
        <p>SD Islam Plus Al-Wafa Batam • TP. 2026/2027</p>
      </div>

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-3" role="alert" style="border-radius: 12px; font-size: 0.85rem;">
          <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
          <div>{{ session('error') }}</div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <form action="{{ route('register.proses') }}" method="POST" novalidate>
        @csrf

        <!-- Nama Lengkap -->
        <div class="mb-3">
          <label for="inputName" class="form-label">Nama Lengkap (Wali / Calon Siswa)</label>
          <div class="input-group-modern @error('name') is-invalid @enderror">
            <span class="input-icon"><i class="bi bi-person"></i></span>
            <input 
              type="text" 
              name="name" 
              id="inputName" 
              class="input-modern" 
              value="{{ old('name') }}" 
              placeholder="Masukkan nama lengkap" 
              required
            >
          </div>
          @error('name')
            <div class="text-danger mt-1 small" style="font-size: 0.78rem;">
              <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
          @enderror
        </div>

        <!-- Alamat Email -->
        <div class="mb-3">
          <label for="inputEmail" class="form-label">Alamat Email Aktif</label>
          <div class="input-group-modern @error('email') is-invalid @enderror">
            <span class="input-icon"><i class="bi bi-envelope"></i></span>
            <input 
              type="email" 
              name="email" 
              id="inputEmail" 
              class="input-modern" 
              value="{{ old('email') }}" 
              placeholder="nama@email.com" 
              required
            >
          </div>
          @error('email')
            <div class="text-danger mt-1 small" style="font-size: 0.78rem;">
              <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
          @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label for="inputPassword" class="form-label">Password</label>
          <div class="input-group-modern @error('password') is-invalid @enderror">
            <span class="input-icon"><i class="bi bi-lock"></i></span>
            <input 
              type="password" 
              name="password" 
              id="inputPassword" 
              class="input-modern" 
              placeholder="Minimal 6 karakter" 
              required
            >
          </div>
          @error('password')
            <div class="text-danger mt-1 small" style="font-size: 0.78rem;">
              <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
          @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div class="mb-3">
          <label for="inputPasswordConfirmation" class="form-label">Konfirmasi Password</label>
          <div class="input-group-modern">
            <span class="input-icon"><i class="bi bi-shield-check"></i></span>
            <input 
              type="password" 
              name="password_confirmation" 
              id="inputPasswordConfirmation" 
              class="input-modern" 
              placeholder="Ulangi password" 
              required
            >
          </div>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn-submit">
          <i class="bi bi-person-plus-fill me-1"></i>
          <span>Daftar Akun Baru</span>
        </button>

        <div class="login-prompt">
          Sudah memiliki akun? 
          <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
      </form>
    </div>
  </main>

  <!-- Vendor JS -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
