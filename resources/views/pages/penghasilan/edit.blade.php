@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Edit Rentang Penghasilan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('penghasilan.index') }}">Penghasilan</a></li>
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
          <h5 class="card-title">Form Edit Rentang Penghasilan</h5>

          <form action="{{ route('penghasilan.update', $penghasilan->id_penghasilan) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Label -->
            <div class="mb-3">
              <label for="label" class="form-label fw-semibold">Label Rentang Penghasilan <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-wallet2"></i></span>
                <input type="text" name="label" id="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label', $penghasilan->label) }}" placeholder="Contoh: Rp 1.000.000 - Rp 1.999.999" required autofocus>
              </div>
              <div class="form-text">Nama atau teks label yang akan tampil pada pilihan formulir pendaftaran.</div>
              @error('label')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <!-- Batas Bawah -->
              <div class="col-md-6 mb-3">
                <label for="batas_bawah" class="form-label fw-semibold">Batas Bawah (Rp) <span class="text-muted fw-normal">(Opsional)</span></label>
                <div class="input-group">
                  <span class="input-group-text">Rp</span>
                  <input type="number" step="any" name="batas_bawah" id="batas_bawah" class="form-control @error('batas_bawah') is-invalid @enderror" value="{{ old('batas_bawah', $penghasilan->batas_bawah) }}" placeholder="Contoh: 1000000">
                </div>
                <div class="form-text">Batas nominal minimal (kosongkan jika tanpa batas bawah).</div>
                @error('batas_bawah')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Batas Atas -->
              <div class="col-md-6 mb-3">
                <label for="batas_atas" class="form-label fw-semibold">Batas Atas (Rp) <span class="text-muted fw-normal">(Opsional)</span></label>
                <div class="input-group">
                  <span class="input-group-text">Rp</span>
                  <input type="number" step="any" name="batas_atas" id="batas_atas" class="form-control @error('batas_atas') is-invalid @enderror" value="{{ old('batas_atas', $penghasilan->batas_atas) }}" placeholder="Contoh: 1999999">
                </div>
                <div class="form-text">Batas nominal maksimal (kosongkan jika tanpa batas atas).</div>
                @error('batas_atas')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Urutan -->
            <div class="mb-3">
              <label for="urutan" class="form-label fw-semibold">Urutan Tampilan <span class="text-muted fw-normal">(Opsional)</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-sort-numeric-down"></i></span>
                <input type="number" name="urutan" id="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', $penghasilan->urutan) }}" placeholder="Contoh: 1, 2, 3">
              </div>
              <div class="form-text">Angka urutan untuk mengatur posisi tampilan dropdown (angka kecil tampil lebih awal).</div>
              @error('urutan')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Status Aktif Switch -->
            <div class="mb-4">
              <label class="form-label fw-semibold d-block">Status Data</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $penghasilan->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktifkan pilihan rentang penghasilan ini</label>
              </div>
              <div class="form-text">Jika non-aktif, pilihan ini tidak akan muncul di formulir pendaftaran siswa.</div>
            </div>

            <hr class="my-4">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('penghasilan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Perbarui Penghasilan
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
