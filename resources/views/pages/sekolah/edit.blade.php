@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Edit Data Sekolah</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
      <li class="breadcrumb-item active">Edit</li>
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
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title p-0 m-0">Edit Profil: {{ $sekolah->nama_sekolah }}</h5>
            <span class="badge bg-light text-dark border">ID: #{{ $sekolah->id_sekolah }}</span>
          </div>

          <form action="{{ route('sekolah.update', $sekolah->id_sekolah) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Identitas Sekolah -->
            <div class="card bg-light border-0 p-3 mb-4">
              <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-info-circle me-1"></i> 1. Identitas Sekolah</h6>
              <div class="row g-3">
                <div class="col-md-8">
                  <label for="nama_sekolah" class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                  <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror" value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}" required>
                  @error('nama_sekolah')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label for="npsn" class="form-label fw-semibold">NPSN</label>
                  <input type="text" name="npsn" id="npsn" class="form-control font-monospace @error('npsn') is-invalid @enderror" value="{{ old('npsn', $sekolah->npsn) }}">
                  @error('npsn')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label for="jenjang" class="form-label fw-semibold">Jenjang Pendidikan <span class="text-danger">*</span></label>
                  <select name="jenjang" id="jenjang" class="form-select @error('jenjang') is-invalid @enderror" required>
                    @foreach($jenjangList as $key => $label)
                      <option value="{{ $key }}" {{ old('jenjang', $sekolah->jenjang) === $key ? 'selected' : '' }}>{{ $label }}</option>
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
                      <option value="{{ $key }}" {{ old('status_sekolah', $sekolah->status_sekolah) === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                  </select>
                  @error('status_sekolah')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label for="nama_yayasan" class="form-label fw-semibold">Nama Yayasan / Naungan</label>
                  <input type="text" name="nama_yayasan" id="nama_yayasan" class="form-control" value="{{ old('nama_yayasan', $sekolah->nama_yayasan) }}">
                </div>
              </div>
            </div>

            <!-- Bagian 2: Alamat & Wilayah -->
            <div class="card bg-light border-0 p-3 mb-4">
              <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-geo-alt me-1"></i> 2. Alamat & Wilayah</h6>
              <div class="row g-3">
                <div class="col-12">
                  <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                  <textarea name="alamat" id="alamat" rows="2" class="form-control">{{ old('alamat', $sekolah->alamat) }}</textarea>
                </div>

                <div class="col-md-4">
                  <label for="desa_kelurahan" class="form-label fw-semibold">Kelurahan / Desa</label>
                  <input type="text" name="desa_kelurahan" id="desa_kelurahan" class="form-control" value="{{ old('desa_kelurahan', $sekolah->desa_kelurahan) }}">
                </div>

                <div class="col-md-4">
                  <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                  <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="{{ old('kecamatan', $sekolah->kecamatan) }}">
                </div>

                <div class="col-md-4">
                  <label for="kabupaten_kota" class="form-label fw-semibold">Kabupaten / Kota</label>
                  <input type="text" name="kabupaten_kota" id="kabupaten_kota" class="form-control" value="{{ old('kabupaten_kota', $sekolah->kabupaten_kota) }}">
                </div>

                <div class="col-md-6">
                  <label for="provinsi" class="form-label fw-semibold">Provinsi</label>
                  <input type="text" name="provinsi" id="provinsi" class="form-control" value="{{ old('provinsi', $sekolah->provinsi) }}">
                </div>

                <div class="col-md-6">
                  <label for="kode_pos" class="form-label fw-semibold">Kode Pos</label>
                  <input type="text" name="kode_pos" id="kode_pos" class="form-control" value="{{ old('kode_pos', $sekolah->kode_pos) }}">
                </div>
              </div>
            </div>

            <!-- Bagian 3: Kontak, Media & Logo -->
            <div class="card bg-light border-0 p-3 mb-4">
              <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-telephone me-1"></i> 3. Kontak, Media & Logo</h6>
              <div class="row g-3">
                <div class="col-md-4">
                  <label for="telepon" class="form-label fw-semibold">Nomor Telepon / WhatsApp</label>
                  <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $sekolah->telepon) }}">
                </div>

                <div class="col-md-4">
                  <label for="email" class="form-label fw-semibold">Alamat Email</label>
                  <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $sekolah->email) }}">
                  @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label for="website" class="form-label fw-semibold">Website Resmi</label>
                  <input type="url" name="website" id="website" class="form-control" value="{{ old('website', $sekolah->website) }}">
                </div>

                <div class="col-md-6">
                  <label for="logo" class="form-label fw-semibold">Ganti Logo Sekolah</label>
                  <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                  <div class="form-text">Format: JPG, PNG, WEBP. Maksimal 2MB. Biarkan kosong jika tidak ingin mengganti logo.</div>
                  @error('logo')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror

                  @if($sekolah->logo_path)
                    <div class="mt-2 d-flex align-items-center gap-2">
                      <span class="small text-muted">Logo saat ini:</span>
                      <img src="{{ $sekolah->logo_url }}" alt="Logo Saat Ini" class="rounded border p-1 bg-white" style="width: 44px; height: 44px; object-fit: contain;">
                    </div>
                  @endif
                </div>

                <div class="col-md-3">
                  <label for="latitude" class="form-label fw-semibold">Latitude GPS</label>
                  <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $sekolah->latitude) }}">
                </div>

                <div class="col-md-3">
                  <label for="longitude" class="form-label fw-semibold">Longitude GPS</label>
                  <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $sekolah->longitude) }}">
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('sekolah.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-warning text-dark fw-semibold">
                <i class="bi bi-check-circle me-1"></i> Perbarui Data Sekolah
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
