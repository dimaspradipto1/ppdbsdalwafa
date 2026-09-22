@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Tambah Komponen Seleksi</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('komponen-seleksi.index') }}">Komponen Seleksi</a></li>
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
          <h5 class="card-title">Form Tambah Komponen Seleksi</h5>

          <form action="{{ route('komponen-seleksi.store') }}" method="POST">
            @csrf

            <!-- Nama Komponen -->
            <div class="mb-3">
              <label for="nama_komponen" class="form-label fw-semibold">Nama Komponen / Aspek Seleksi <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-clipboard-check"></i></span>
                <input type="text" name="nama_komponen" id="nama_komponen" class="form-control @error('nama_komponen') is-invalid @enderror" value="{{ old('nama_komponen') }}" placeholder="Contoh: Observasi Kesiapan Belajar, Tes Baca Al-Qur'an / Iqro, Wawancara Orang Tua" required autofocus>
              </div>
              @error('nama_komponen')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <!-- Kode -->
              <div class="col-md-4 mb-3">
                <label for="kode" class="form-label fw-semibold">Kode Komponen</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-tag"></i></span>
                  <input type="text" name="kode" id="kode" class="form-control font-monospace @error('kode') is-invalid @enderror" value="{{ old('kode') }}" placeholder="Contoh: OBS, QURAN, WAWANCARA">
                </div>
                @error('kode')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Nilai Minimal / KKM -->
              <div class="col-md-4 mb-3">
                <label for="nilai_minimal" class="form-label fw-semibold">Nilai Minimal (KKM)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-speedometer2"></i></span>
                  <input type="number" step="0.1" name="nilai_minimal" id="nilai_minimal" min="0" max="100" class="form-control @error('nilai_minimal') is-invalid @enderror" value="{{ old('nilai_minimal', '70.0') }}" placeholder="Contoh: 70.0">
                </div>
                @error('nilai_minimal')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Bobot Persen -->
              <div class="col-md-4 mb-3">
                <label for="bobot_persen" class="form-label fw-semibold">Bobot Penilaian (%)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-percent"></i></span>
                  <input type="number" name="bobot_persen" id="bobot_persen" min="0" max="100" class="form-control @error('bobot_persen') is-invalid @enderror" value="{{ old('bobot_persen', 0) }}" placeholder="Contoh: 40">
                </div>
                @error('bobot_persen')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row">
              <!-- Urutan Tampil -->
              <div class="col-md-6 mb-3">
                <label for="urutan" class="form-label fw-semibold">Nomor Urutan Tampil</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-sort-numeric-down"></i></span>
                  <input type="number" name="urutan" id="urutan" min="1" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', 1) }}">
                </div>
                @error('urutan')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Status Aktif Switch -->
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold d-block">Status Penilaian</label>
                <div class="form-check form-switch mt-2">
                  <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_active">Aktifkan komponen ini</label>
                </div>
              </div>
            </div>

            <!-- Keterangan -->
            <div class="mb-4">
              <label for="keterangan" class="form-label fw-semibold">Keterangan / Panduan Penilaian</label>
              <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Contoh: Menguji motorik halus, pengenalan huruf/angka dasar, dan kemandirian siswa">{{ old('keterangan') }}</textarea>
            </div>

            <hr class="my-4">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('komponen-seleksi.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan Komponen
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
