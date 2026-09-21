@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Edit Data Kebutuhan Khusus</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('kebutuhan-khusus.index') }}">Kebutuhan Khusus</a></li>
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
          <h5 class="card-title">Form Edit Data Kebutuhan Khusus</h5>

          <form action="{{ route('kebutuhan-khusus.update', $kebutuhanKhusus->id_kebutuhan) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Kode -->
            <div class="mb-3">
              <label for="kode" class="form-label fw-semibold">Kode <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $kebutuhanKhusus->kode) }}" placeholder="Contoh: A, B, C, TIDAK, dll." required autofocus>
              </div>
              <div class="form-text">Kode unik referensi kebutuhan khusus (misal kode Dapodik / Kemdikbud).</div>
              @error('kode')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Nama -->
            <div class="mb-3">
              <label for="nama" class="form-label fw-semibold">Nama Kebutuhan Khusus <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-heart-pulse"></i></span>
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $kebutuhanKhusus->nama) }}" placeholder="Contoh: Tunanetra (A), Tunarungu (B), Autis, Tidak Ada" required>
              </div>
              @error('nama')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Keterangan -->
            <div class="mb-3">
              <label for="keterangan" class="form-label fw-semibold">Keterangan <span class="text-muted fw-normal">(Opsional)</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                <input type="text" name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan', $kebutuhanKhusus->keterangan) }}" placeholder="Catatan atau keterangan penjelasan">
              </div>
              @error('keterangan')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Status Aktif Switch -->
            <div class="mb-4">
              <label class="form-label fw-semibold d-block">Status Data</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $kebutuhanKhusus->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktifkan data kebutuhan khusus ini</label>
              </div>
              <div class="form-text">Jika non-aktif, data ini tidak akan tampil dalam pilihan registrasi siswa.</div>
            </div>

            <hr class="my-4">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('kebutuhan-khusus.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Perbarui Data
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
