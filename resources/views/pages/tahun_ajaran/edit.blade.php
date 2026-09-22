@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Edit Tahun Ajaran</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('tahun-ajaran.index') }}">Tahun Ajaran</a></li>
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
          <h5 class="card-title">Form Edit Tahun Ajaran: {{ $tahunAjaran->tahun_ajaran }}</h5>

          <form action="{{ route('tahun-ajaran.update', $tahunAjaran->id_tahun_ajaran) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Tahun Ajaran -->
            <div class="mb-3">
              <label for="tahun_ajaran" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-range"></i></span>
                <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror" value="{{ old('tahun_ajaran', $tahunAjaran->tahun_ajaran) }}" placeholder="Contoh: 2025/2026" required autofocus>
              </div>
              <div class="form-text">Format yang disarankan: <strong>YYYY/YYYY</strong> (misal: 2025/2026).</div>
              @error('tahun_ajaran')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Nama Tahun Ajaran -->
            <div class="mb-3">
              <label for="nama_tahun_ajaran" class="form-label fw-semibold">Nama / Deskripsi Tahun Ajaran <span class="text-muted fw-normal">(Opsional)</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                <input type="text" name="nama_tahun_ajaran" id="nama_tahun_ajaran" class="form-control @error('nama_tahun_ajaran') is-invalid @enderror" value="{{ old('nama_tahun_ajaran', $tahunAjaran->nama_tahun_ajaran) }}" placeholder="Contoh: Tahun Ajaran 2025/2026">
              </div>
              @error('nama_tahun_ajaran')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Periode Mulai & Selesai -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai <span class="text-muted fw-normal">(Opsional)</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                  <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $tahunAjaran->tanggal_mulai ? $tahunAjaran->tanggal_mulai->format('Y-m-d') : '') }}">
                </div>
                @error('tanggal_mulai')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai <span class="text-muted fw-normal">(Opsional)</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-calendar-x"></i></span>
                  <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $tahunAjaran->tanggal_selesai ? $tahunAjaran->tanggal_selesai->format('Y-m-d') : '') }}">
                </div>
                @error('tanggal_selesai')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Status Aktif Switch -->
            <div class="mb-3">
              <label class="form-label fw-semibold d-block">Status Tahun Ajaran</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $tahunAjaran->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Jadikan sebagai tahun ajaran aktif</label>
              </div>
              <div class="form-text">Jika diaktifkan, tahun ajaran aktif lainnya secara otomatis akan dinonaktifkan.</div>
            </div>

            <!-- Keterangan -->
            <div class="mb-4">
              <label for="keterangan" class="form-label fw-semibold">Keterangan <span class="text-muted fw-normal">(Opsional)</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                <input type="text" name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan', $tahunAjaran->keterangan) }}" placeholder="Catatan tambahan seputar tahun ajaran ini">
              </div>
              @error('keterangan')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <hr class="my-4">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('tahun-ajaran.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle me-1"></i> Perbarui Tahun Ajaran
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
