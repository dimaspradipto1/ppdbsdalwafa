@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Tambah Jenjang Pendidikan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('pendidikan.index') }}">Pendidikan</a></li>
      <li class="breadcrumb-item active">Tambah</li>
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
          <h5 class="card-title">Form Tambah Jenjang Pendidikan</h5>

          <form action="{{ route('pendidikan.store') }}" method="POST">
            @csrf

            <!-- Nama Pendidikan -->
            <div class="mb-3">
              <label for="nama_pendidikan" class="form-label fw-semibold">Nama Jenjang Pendidikan <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                <input type="text" name="nama_pendidikan" id="nama_pendidikan" class="form-control @error('nama_pendidikan') is-invalid @enderror" value="{{ old('nama_pendidikan') }}" placeholder="Contoh: SD / Sederajat, SMA / SMK / Sederajat, S1, dll." required autofocus>
              </div>
              @error('nama_pendidikan')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Keterangan -->
            <div class="mb-3">
              <label for="keterangan" class="form-label fw-semibold">Keterangan <span class="text-muted fw-normal">(Opsional)</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                <input type="text" name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan') }}" placeholder="Keterangan atau catatan tambahan">
              </div>
              @error('keterangan')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Status Aktif Switch -->
            <div class="mb-4">
              <label class="form-label fw-semibold d-block">Status Data</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktifkan jenjang pendidikan ini</label>
              </div>
              <div class="form-text">Jika aktif, opsi ini akan muncul pada formulir data orang tua/wali siswa.</div>
            </div>

            <hr class="my-4">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('pendidikan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan Pendidikan
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
