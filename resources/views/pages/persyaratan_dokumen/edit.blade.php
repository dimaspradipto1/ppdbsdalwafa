@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Edit Persyaratan Dokumen</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('persyaratan-dokumen.index') }}">Persyaratan Dokumen</a></li>
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
          <h5 class="card-title">Edit Dokumen: {{ $jenisDokumen->nama_dokumen }}</h5>

          <form action="{{ route('persyaratan-dokumen.update', $jenisDokumen->id_jenis_dokumen) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Kode Dokumen -->
            <div class="mb-3">
              <label for="kode" class="form-label fw-semibold">Kode Dokumen <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                <input type="text" name="kode" id="kode" class="form-control font-monospace @error('kode') is-invalid @enderror" value="{{ old('kode', $jenisDokumen->kode) }}" required>
              </div>
              @error('kode')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Nama Dokumen -->
            <div class="mb-3">
              <label for="nama_dokumen" class="form-label fw-semibold">Nama Dokumen / Persyaratan <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                <input type="text" name="nama_dokumen" id="nama_dokumen" class="form-control @error('nama_dokumen') is-invalid @enderror" value="{{ old('nama_dokumen', $jenisDokumen->nama_dokumen) }}" required>
              </div>
              @error('nama_dokumen')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <!-- Kategori Calon Siswa -->
              <div class="col-md-6 mb-3">
                <label for="kategori" class="form-label fw-semibold">Kategori Calon Siswa <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person-check"></i></span>
                  <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                    @foreach($kategoriList as $key => $label)
                      <option value="{{ $key }}" {{ old('kategori', $jenisDokumen->kategori) === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                  </select>
                </div>
                @error('kategori')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Jumlah Lembar -->
              <div class="col-md-6 mb-3">
                <label for="jumlah_lembar" class="form-label fw-semibold">Jumlah Lembar / Berkas</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-files"></i></span>
                  <input type="text" name="jumlah_lembar" id="jumlah_lembar" class="form-control @error('jumlah_lembar') is-invalid @enderror" value="{{ old('jumlah_lembar', $jenisDokumen->jumlah_lembar) }}">
                </div>
                @error('jumlah_lembar')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Keterangan / Instruksi -->
            <div class="mb-3">
              <label for="keterangan" class="form-label fw-semibold">Catatan / Instruksi Khusus</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                <input type="text" name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan', $jenisDokumen->keterangan) }}">
              </div>
              @error('keterangan')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="row mb-4">
              <!-- Sifat Wajib -->
              <div class="col-md-6 mb-2">
                <label class="form-label fw-semibold d-block">Sifat Dokumen</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="is_wajib" name="is_wajib" value="1" {{ old('is_wajib', $jenisDokumen->is_wajib) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_wajib">Wajib Dilampirkan (Mandatory)</label>
                </div>
              </div>

              <!-- Status Aktif -->
              <div class="col-md-6 mb-2">
                <label class="form-label fw-semibold d-block">Status Persyaratan</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $jenisDokumen->is_active) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_active">Aktifkan pada formulir PPDB</label>
                </div>
              </div>
            </div>

            <hr class="my-4">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('persyaratan-dokumen.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle me-1"></i> Perbarui Persyaratan
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
