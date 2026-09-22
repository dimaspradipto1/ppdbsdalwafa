@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Tambah Jalur Pendaftaran</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('jalur.index') }}">Jalur & Kuota</a></li>
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

      <div class="card shadow-sm border-0">
        <div class="card-body pt-3">
          <h5 class="card-title">Form Tambah Jalur & Kuota Pendaftaran</h5>

          <form action="{{ route('jalur.store') }}" method="POST">
            @csrf

            <!-- Tahun Ajaran -->
            <div class="mb-3">
              <label for="id_tahun_ajaran" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-range"></i></span>
                <select name="id_tahun_ajaran" id="id_tahun_ajaran" class="form-select @error('id_tahun_ajaran') is-invalid @enderror" required>
                  <option value="">-- Pilih Tahun Ajaran --</option>
                  @foreach($tahunAjaranList as $ta)
                    <option value="{{ $ta->id_tahun_ajaran }}" {{ old('id_tahun_ajaran', optional($activeTahunAjaran)->id_tahun_ajaran) == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                      {{ $ta->tahun_ajaran }} {{ $ta->is_active ? '(Tahun Aktif)' : '' }}
                    </option>
                  @endforeach
                </select>
              </div>
              @error('id_tahun_ajaran')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Nama Jalur -->
            <div class="mb-3">
              <label for="nama_jalur" class="form-label fw-semibold">Nama Jalur Pendaftaran <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-signpost-split"></i></span>
                <input type="text" name="nama_jalur" id="nama_jalur" class="form-control @error('nama_jalur') is-invalid @enderror" value="{{ old('nama_jalur') }}" placeholder="Contoh: Jalur Reguler, Jalur Prestasi / Tahfidz, Jalur Pindahan" required autofocus>
              </div>
              @error('nama_jalur')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <!-- Kode Jalur -->
              <div class="col-md-6 mb-3">
                <label for="kode_jalur" class="form-label fw-semibold">Kode Jalur <span class="text-muted fw-normal">(Opsional)</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-tag"></i></span>
                  <input type="text" name="kode_jalur" id="kode_jalur" class="form-control font-monospace @error('kode_jalur') is-invalid @enderror" value="{{ old('kode_jalur') }}" placeholder="Contoh: REG, PRESTASI">
                </div>
                @error('kode_jalur')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Kuota -->
              <div class="col-md-6 mb-3">
                <label for="kuota" class="form-label fw-semibold">Kuota Pendaftar</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-people"></i></span>
                  <input type="number" name="kuota" id="kuota" min="0" class="form-control @error('kuota') is-invalid @enderror" value="{{ old('kuota') }}" placeholder="Kosongkan jika tidak dibatasi">
                  <span class="input-group-text">Siswa</span>
                </div>
                @error('kuota')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
              <label for="deskripsi" class="form-label fw-semibold">Deskripsi Jalur</label>
              <textarea name="deskripsi" id="deskripsi" rows="2" class="form-control" placeholder="Penjelasan singkat mengenai kriteria jalur ini">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Persyaratan Khusus -->
            <div class="mb-3">
              <label for="persyaratan_khusus" class="form-label fw-semibold">Persyaratan Khusus <span class="text-muted fw-normal">(Opsional)</span></label>
              <textarea name="persyaratan_khusus" id="persyaratan_khusus" rows="2" class="form-control" placeholder="Misal: Minimal hafal Juz 30 untuk jalur tahfidz, atau menyertakan sertifikat kejuaraan">{{ old('persyaratan_khusus') }}</textarea>
            </div>

            <!-- Status Aktif Switch -->
            <div class="mb-4">
              <label class="form-label fw-semibold d-block">Status Jalur</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Buka jalur pendaftaran ini</label>
              </div>
            </div>

            <hr class="my-4">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('jalur.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan Jalur
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
