@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Edit Gelombang Pendaftaran</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('gelombang.index') }}">Gelombang</a></li>
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

      <div class="card shadow-sm border-0">
        <div class="card-body pt-3">
          <h5 class="card-title">Form Edit Gelombang: {{ $gelombang->nama_gelombang }}</h5>

          <form action="{{ route('gelombang.update', $gelombang->id_gelombang) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Tahun Ajaran -->
            <div class="mb-3">
              <label for="id_tahun_ajaran" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-range"></i></span>
                <select name="id_tahun_ajaran" id="id_tahun_ajaran" class="form-select @error('id_tahun_ajaran') is-invalid @enderror" required>
                  <option value="">-- Pilih Tahun Ajaran --</option>
                  @foreach($tahunAjaranList as $ta)
                    <option value="{{ $ta->id_tahun_ajaran }}" {{ old('id_tahun_ajaran', $gelombang->id_tahun_ajaran) == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                      {{ $ta->tahun_ajaran }} {{ $ta->is_active ? '(Tahun Aktif)' : '' }}
                    </option>
                  @endforeach
                </select>
              </div>
              @error('id_tahun_ajaran')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Nama Gelombang -->
            <div class="mb-3">
              <label for="nama_gelombang" class="form-label fw-semibold">Nama Gelombang <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-layers"></i></span>
                <input type="text" name="nama_gelombang" id="nama_gelombang" class="form-control @error('nama_gelombang') is-invalid @enderror" value="{{ old('nama_gelombang', $gelombang->nama_gelombang) }}" placeholder="Contoh: Gelombang 1" required autofocus>
              </div>
              @error('nama_gelombang')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Periode Mulai & Selesai -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai Pendaftaran <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                  <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $gelombang->tanggal_mulai ? $gelombang->tanggal_mulai->format('Y-m-d') : '') }}" required>
                </div>
                @error('tanggal_mulai')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai Pendaftaran <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-calendar-x"></i></span>
                  <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $gelombang->tanggal_selesai ? $gelombang->tanggal_selesai->format('Y-m-d') : '') }}" required>
                </div>
                @error('tanggal_selesai')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Kuota -->
            <div class="mb-3">
              <label for="kuota" class="form-label fw-semibold">Kuota Pendaftar <span class="text-muted fw-normal">(Opsional)</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-people"></i></span>
                <input type="number" name="kuota" id="kuota" min="0" class="form-control @error('kuota') is-invalid @enderror" value="{{ old('kuota', $gelombang->kuota) }}" placeholder="Kosongkan jika kuota tidak dibatasi">
                <span class="input-group-text">Siswa</span>
              </div>
              @error('kuota')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Status Aktif Switch -->
            <div class="mb-3">
              <label class="form-label fw-semibold d-block">Status Gelombang</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $gelombang->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktifkan gelombang pendaftaran ini</label>
              </div>
              <div class="form-text">Jika aktif, calon siswa dapat memilih gelombang ini saat pendaftaran dibuka.</div>
            </div>

            <!-- Keterangan -->
            <div class="mb-4">
              <label for="keterangan" class="form-label fw-semibold">Keterangan <span class="text-muted fw-normal">(Opsional)</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                <input type="text" name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan', $gelombang->keterangan) }}" placeholder="Catatan atau informasi tambahan mengenai gelombang ini">
              </div>
              @error('keterangan')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <hr class="my-4">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('gelombang.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle me-1"></i> Perbarui Gelombang
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
