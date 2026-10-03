@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Edit Banner Homepage</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('homepage-banner.index') }}">Banner Homepage</a></li>
      <li class="breadcrumb-item active">Edit Banner</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row justify-content-center">
    <div class="col-lg-10">

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle me-1"></i>
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
        <div class="card-header bg-white py-3">
          <h5 class="card-title p-0 m-0 fw-bold text-dark">Perbarui Banner</h5>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('homepage-banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="badge_text" class="form-label fw-semibold">Teks Badge / Tagline Kecil</label>
              <input type="text" name="badge_text" id="badge_text" class="form-control" value="{{ old('badge_text', $banner->badge_text) }}">
            </div>

            <div class="mb-3">
              <label for="judul" class="form-label fw-semibold">Judul Banner Utama <span class="text-danger">*</span></label>
              <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $banner->judul) }}" required>
            </div>

            <div class="mb-3">
              <label for="subjudul" class="form-label fw-semibold">Deskripsi / Subjudul</label>
              <textarea name="subjudul" id="subjudul" rows="3" class="form-control">{{ old('subjudul', $banner->subjudul) }}</textarea>
            </div>

            <div class="mb-3">
              <label for="gambar" class="form-label fw-semibold">Foto Banner / Background Slide</label>
              @if($banner->gambar)
                <div class="mb-2">
                  <img src="{{ $banner->gambar_url }}" alt="Preview" class="rounded border shadow-sm" style="max-height: 120px;">
                </div>
              @endif
              <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
              <div class="form-text">Biarkan kosong jika tidak ingin mengganti gambar. Format: JPG, PNG, WEBP (Max 3MB).</div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="tombol_text_1" class="form-label fw-semibold">Teks Tombol Utama</label>
                <input type="text" name="tombol_text_1" id="tombol_text_1" class="form-control" value="{{ old('tombol_text_1', $banner->tombol_text_1) }}">
              </div>
              <div class="col-md-6">
                <label for="tombol_link_1" class="form-label fw-semibold">Link Tombol Utama</label>
                <input type="text" name="tombol_link_1" id="tombol_link_1" class="form-control" value="{{ old('tombol_link_1', $banner->tombol_link_1) }}">
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="tombol_text_2" class="form-label fw-semibold">Teks Tombol Kedua</label>
                <input type="text" name="tombol_text_2" id="tombol_text_2" class="form-control" value="{{ old('tombol_text_2', $banner->tombol_text_2) }}">
              </div>
              <div class="col-md-6">
                <label for="tombol_link_2" class="form-label fw-semibold">Link Tombol Kedua</label>
                <input type="text" name="tombol_link_2" id="tombol_link_2" class="form-control" value="{{ old('tombol_link_2', $banner->tombol_link_2) }}">
              </div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label for="urutan" class="form-label fw-semibold">Urutan Tayang</label>
                <input type="number" name="urutan" id="urutan" class="form-control" value="{{ old('urutan', $banner->urutan) }}" min="1">
              </div>
              <div class="col-md-6 d-flex align-items-center mt-md-4">
                <div class="form-check form-switch fs-5 mt-2">
                  <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                  <label class="form-check-label fs-6 fw-semibold text-dark ms-2" for="is_active">Aktifkan Banner Ini</label>
                </div>
              </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between">
              <a href="{{ route('homepage-banner.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal & Kembali
              </a>
              <button type="submit" class="btn btn-primary px-4 shadow-sm">
                <i class="bi bi-save me-1"></i> Perbarui Banner
              </button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
