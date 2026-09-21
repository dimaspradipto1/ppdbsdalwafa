@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Edit & Verifikasi Dokumen</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pendaftaran</li>
      <li class="breadcrumb-item"><a href="{{ route('dokumen.index') }}">Dokumen</a></li>
      <li class="breadcrumb-item active">Edit & Verifikasi</li>
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
          <h5 class="card-title mb-3">Formulir Verifikasi & Pembaruan Dokumen</h5>

          <form action="{{ route('dokumen.update', $dokumen->id_dokumen) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- 1. Calon Siswa -->
            <div class="mb-3">
              <label for="id_calon_siswa" class="form-label fw-semibold">Calon Siswa <span class="text-danger">*</span></label>
              <select name="id_calon_siswa" id="id_calon_siswa" class="form-select @error('id_calon_siswa') is-invalid @enderror" required>
                @foreach($calonSiswa as $siswa)
                  <option value="{{ $siswa->id_calon_siswa }}" {{ old('id_calon_siswa', $dokumen->id_calon_siswa) == $siswa->id_calon_siswa ? 'selected' : '' }}>
                    {{ $siswa->nama_lengkap }} (NIK: {{ $siswa->nik ?? '-' }}) - {{ $siswa->jenis_kelamin }}
                  </option>
                @endforeach
              </select>
              @error('id_calon_siswa')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- 2. Jenis Dokumen Persyaratan -->
            <div class="mb-3">
              <label for="id_jenis_dokumen" class="form-label fw-semibold">Jenis Dokumen Persyaratan <span class="text-danger">*</span></label>
              <select name="id_jenis_dokumen" id="id_jenis_dokumen" class="form-select @error('id_jenis_dokumen') is-invalid @enderror" required>
                <optgroup label="PERSYARATAN SISWA BARU">
                  @foreach($jenisDokumen->where('kategori', 'siswa_baru') as $jd)
                    <option value="{{ $jd->id_jenis_dokumen }}" 
                            data-kategori="Siswa Baru"
                            data-lembar="{{ $jd->jumlah_lembar }}"
                            data-keterangan="{{ $jd->keterangan }}"
                            {{ old('id_jenis_dokumen', $dokumen->id_jenis_dokumen) == $jd->id_jenis_dokumen ? 'selected' : '' }}>
                      {{ $jd->nama_dokumen }} ({{ $jd->jumlah_lembar }})
                    </option>
                  @endforeach
                </optgroup>

                <optgroup label="PERSYARATAN SISWA PINDAHAN">
                  @foreach($jenisDokumen->where('kategori', 'siswa_pindahan') as $jd)
                    <option value="{{ $jd->id_jenis_dokumen }}" 
                            data-kategori="Siswa Pindahan"
                            data-lembar="{{ $jd->jumlah_lembar }}"
                            data-keterangan="{{ $jd->keterangan }}"
                            {{ old('id_jenis_dokumen', $dokumen->id_jenis_dokumen) == $jd->id_jenis_dokumen ? 'selected' : '' }}>
                      {{ $jd->nama_dokumen }}
                    </option>
                  @endforeach
                </optgroup>

                <optgroup label="PERSYARATAN UMUM">
                  @foreach($jenisDokumen->where('kategori', 'semua') as $jd)
                    <option value="{{ $jd->id_jenis_dokumen }}" 
                            data-kategori="Semua Siswa"
                            data-lembar="{{ $jd->jumlah_lembar }}"
                            data-keterangan="{{ $jd->keterangan }}"
                            {{ old('id_jenis_dokumen', $dokumen->id_jenis_dokumen) == $jd->id_jenis_dokumen ? 'selected' : '' }}>
                      {{ $jd->nama_dokumen }}
                    </option>
                  @endforeach
                </optgroup>
              </select>
              @error('id_jenis_dokumen')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Box Berkas yang Saat Ini Terunggah -->
            <div class="card bg-light border mb-3">
              <div class="card-body p-3">
                <div class="fw-semibold small text-muted mb-2">BERKAS SAAT INI:</div>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    @if(strtolower($dokumen->tipe_file) === 'pdf')
                      <i class="bi bi-file-earmark-pdf fs-2 text-danger me-2"></i>
                    @else
                      <i class="bi bi-file-earmark-image fs-2 text-primary me-2"></i>
                    @endif
                    <div>
                      <div class="fw-bold text-dark">{{ $dokumen->nama_file }}</div>
                      <div class="text-muted small">{{ strtoupper($dokumen->tipe_file) }} &bull; {{ $dokumen->ukuran_file }} KB &bull; Diunggah {{ $dokumen->created_at->translatedFormat('d M Y H:i') }}</div>
                    </div>
                  </div>
                  <a href="{{ Storage::url($dokumen->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka Berkas
                  </a>
                </div>
              </div>
            </div>

            <!-- 3. Unggah Berkas Baru (Opsional Ganti File) -->
            <div class="mb-3">
              <label for="berkas" class="form-label fw-semibold">Ganti Berkas Dokumen <span class="text-muted fw-normal">(Kosongkan jika tidak ingin mengubah file)</span></label>
              <input type="file" name="berkas" id="berkas" class="form-control @error('berkas') is-invalid @enderror" accept=".pdf,image/jpeg,image/png,image/jpg">
              <div class="form-text">Format yang didukung: PDF, JPG, JPEG, PNG (Maks. 3MB).</div>
              @error('berkas')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="section-divider my-4 border-top pt-3">
              <h6 class="fw-bold text-primary mb-3"><i class="bi bi-shield-check me-2"></i>Verifikasi Berkas Panitia PPDB</h6>
            </div>

            <!-- 4. Status Verifikasi -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="status_verifikasi" class="form-label fw-semibold">Status Verifikasi <span class="text-danger">*</span></label>
                <select name="status_verifikasi" id="status_verifikasi" class="form-select @error('status_verifikasi') is-invalid @enderror" required>
                  <option value="menunggu" {{ old('status_verifikasi', $dokumen->status_verifikasi) == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                  <option value="valid" {{ old('status_verifikasi', $dokumen->status_verifikasi) == 'valid' ? 'selected' : '' }}>Valid / Diterima</option>
                  <option value="ditolak" {{ old('status_verifikasi', $dokumen->status_verifikasi) == 'ditolak' ? 'selected' : '' }}>Ditolak / Berkas Kurang</option>
                </select>
                @error('status_verifikasi')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <label for="catatan_verifikasi" class="form-label fw-semibold">Catatan Verifikasi</label>
                <input type="text" name="catatan_verifikasi" id="catatan_verifikasi" class="form-control" value="{{ old('catatan_verifikasi', $dokumen->catatan_verifikasi) }}" placeholder="Contoh: Berkas telah diverifikasi lengkap">
              </div>

              @if($dokumen->verified_by)
                <div class="col-12">
                  <div class="text-muted small">
                    <i class="bi bi-person-check me-1"></i> Terakhir diverifikasi oleh: <strong>{{ optional($dokumen->verifikator)->name ?? 'Petugas' }}</strong> pada {{ optional($dokumen->verified_at)->translatedFormat('d F Y H:i') }}
                  </div>
                </div>
              @endif
            </div>

            <hr class="my-4">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan Perubahan & Verifikasi
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
