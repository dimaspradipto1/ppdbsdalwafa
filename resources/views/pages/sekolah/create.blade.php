@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Tambah Lembaga / Sekolah Baru</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
      <li class="breadcrumb-item active">Tambah</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row justify-content-center">
    <div class="col-lg-10">

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
          <h5 class="card-title">Form Profil Sekolah Baru</h5>

          <form action="{{ route('sekolah.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Bagian 1: Identitas Sekolah -->
            <div class="card bg-light border-0 p-3 mb-4">
              <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-info-circle me-1"></i> 1. Identitas Sekolah</h6>
              <div class="row g-3">
                <div class="col-md-8">
                  <label for="nama_sekolah" class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                  <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror" value="{{ old('nama_sekolah') }}" placeholder="Contoh: SD Islam Plus Al-Wafa" required>
                  @error('nama_sekolah')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label for="npsn" class="form-label fw-semibold">NPSN</label>
                  <input type="text" name="npsn" id="npsn" class="form-control font-monospace @error('npsn') is-invalid @enderror" value="{{ old('npsn') }}" placeholder="8 digit angka">
                  @error('npsn')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label for="jenjang" class="form-label fw-semibold">Jenjang Pendidikan <span class="text-danger">*</span></label>
                  <select name="jenjang" id="jenjang" class="form-select @error('jenjang') is-invalid @enderror" required>
                    @foreach($jenjangList as $key => $label)
                      <option value="{{ $key }}" {{ old('jenjang', 'SD') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                  </select>
                  @error('jenjang')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label for="status_sekolah" class="form-label fw-semibold">Status Sekolah <span class="text-danger">*</span></label>
                  <select name="status_sekolah" id="status_sekolah" class="form-select @error('status_sekolah') is-invalid @enderror" required>
                    @foreach($statusList as $key => $label)
                      <option value="{{ $key }}" {{ old('status_sekolah', 'Swasta') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                  </select>
                  @error('status_sekolah')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label for="nama_yayasan" class="form-label fw-semibold">Nama Yayasan / Naungan</label>
                  <input type="text" name="nama_yayasan" id="nama_yayasan" class="form-control" value="{{ old('nama_yayasan') }}" placeholder="Contoh: Yayasan Daarul Aitam Batam">
                </div>
              </div>
            </div>

            <!-- Bagian 2: Alamat & Wilayah -->
            <div class="card bg-light border-0 p-3 mb-4">
              <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-geo-alt me-1"></i> 2. Alamat & Wilayah</h6>
              <div class="row g-3">
                <div class="col-12">
                  <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                  <textarea name="alamat" id="alamat" rows="2" class="form-control" placeholder="Jalan, Blok, Nomor Bangunan...">{{ old('alamat') }}</textarea>
                </div>

                <div class="col-md-4">
                  <label for="desa_kelurahan" class="form-label fw-semibold">Kelurahan / Desa</label>
                  <input type="text" name="desa_kelurahan" id="desa_kelurahan" class="form-control" value="{{ old('desa_kelurahan') }}" placeholder="Contoh: Belian">
                </div>

                <div class="col-md-4">
                  <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                  <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="{{ old('kecamatan') }}" placeholder="Contoh: Batam Kota">
                </div>

                <div class="col-md-4">
                  <label for="kabupaten_kota" class="form-label fw-semibold">Kabupaten / Kota</label>
                  <input type="text" name="kabupaten_kota" id="kabupaten_kota" class="form-control" value="{{ old('kabupaten_kota') }}" placeholder="Contoh: Kota Batam">
                </div>

                <div class="col-md-6">
                  <label for="provinsi" class="form-label fw-semibold">Provinsi</label>
                  <input type="text" name="provinsi" id="provinsi" class="form-control" value="{{ old('provinsi', 'Kepulauan Riau') }}" placeholder="Contoh: Kepulauan Riau">
                </div>

                <div class="col-md-6">
                  <label for="kode_pos" class="form-label fw-semibold">Kode Pos</label>
                  <input type="text" name="kode_pos" id="kode_pos" class="form-control" value="{{ old('kode_pos') }}" placeholder="Contoh: 29464">
                </div>
              </div>
            </div>

            <!-- Bagian 3: Kontak, Media & Logo -->
            <div class="card bg-light border-0 p-3 mb-4">
              <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-telephone me-1"></i> 3. Kontak, Media & Logo</h6>
              <div class="row g-3">
                <div class="col-md-4">
                  <label for="telepon" class="form-label fw-semibold">Nomor Telepon / WhatsApp</label>
                  <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon') }}" placeholder="Contoh: 082323222606">
                </div>

                <div class="col-md-4">
                  <label for="email" class="form-label fw-semibold">Alamat Email</label>
                  <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="sdipalwafa@gmail.com">
                  @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label for="website" class="form-label fw-semibold">Website Resmi</label>
                  <input type="url" name="website" id="website" class="form-control" value="{{ old('website') }}" placeholder="https://...">
                </div>

                <div class="col-md-6">
                  <label for="logo" class="form-label fw-semibold">Unggah Logo Sekolah</label>
                  <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                  <div class="form-text">Format: JPG, PNG, WEBP. Maksimal 2MB.</div>
                  @error('logo')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-3">
                  <label for="latitude" class="form-label fw-semibold">Latitude GPS</label>
                  <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude') }}" placeholder="Contoh: 1.11860000">
                </div>

                <div class="col-md-3">
                  <label for="longitude" class="form-label fw-semibold">Longitude GPS</label>
                  <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude') }}" placeholder="Contoh: 104.05310000">
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('sekolah.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan Data Sekolah
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
