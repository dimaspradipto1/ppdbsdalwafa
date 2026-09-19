@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Edit Data Pengguna</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-octagon me-1"></i>
          <strong>Terdapat kesalahan input:</strong>
          <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="card shadow-sm">
        <div class="card-body pt-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title p-0 m-0">Edit Pengguna: {{ $user->name }}</h5>
            <span class="badge bg-light text-dark border">ID: #{{ $user->id }}</span>
          </div>

          <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div class="mb-3">
              <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
              </div>
              @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
              </div>
              @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Role Akses -->
            <div class="mb-4">
              <label for="role" class="form-label fw-semibold">Role Hak Akses <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                  @foreach($roles as $key => $label)
                    <option value="{{ $key }}" {{ old('role', $user->role) === $key ? 'selected' : '' }}>
                      {{ $label }} ({{ $key }})
                    </option>
                  @endforeach
                </select>
              </div>
              @error('role')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Bagian Update Password -->
            <div class="card bg-light border p-3 mb-4">
              <h6 class="fw-bold mb-1"><i class="bi bi-key me-1 text-primary"></i> Pengaturan Password</h6>
              <p class="text-muted small mb-3">
                <i class="bi bi-info-circle me-1"></i> Biarkan kolom di bawah ini <strong>kosong</strong> jika Anda <strong>tidak ingin mengubah</strong> password lama pengguna. Jika diisi, password lama akan digantikan dengan password baru.
              </p>

              <div class="row">
                <!-- Password Baru -->
                <div class="col-md-6 mb-3 mb-md-0">
                  <label for="password" class="form-label fw-semibold small">Password Baru (Opsional)</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tetap password lama">
                    <button class="btn btn-outline-secondary btn-toggle-pwd" type="button" data-target="password">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                  @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="col-md-6">
                  <label for="password_confirmation" class="form-label fw-semibold small">Ulangi Password Baru</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi jika mengubah password">
                    <button class="btn btn-outline-secondary btn-toggle-pwd" type="button" data-target="password_confirmation">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-warning text-dark fw-semibold">
                <i class="bi bi-check-circle me-1"></i> Perbarui Pengguna
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  document.querySelectorAll('.btn-toggle-pwd').forEach(button => {
    button.addEventListener('click', function () {
      const targetId = this.getAttribute('data-target');
      const input = document.getElementById(targetId);
      const icon = this.querySelector('i');

      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    });
  });
</script>
@endpush
