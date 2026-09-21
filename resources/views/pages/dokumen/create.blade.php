@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Unggah Dokumen Persyaratan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pendaftaran</li>
      <li class="breadcrumb-item"><a href="{{ route('dokumen.index') }}">Dokumen</a></li>
      <li class="breadcrumb-item active">Unggah</li>
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
          <h5 class="card-title mb-3">Formulir Unggah Berkas Dokumen</h5>

          <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. Pilih Calon Siswa -->
            <div class="mb-3">
              <label for="id_calon_siswa" class="form-label fw-semibold">Pilih Calon Siswa <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <select name="id_calon_siswa" id="id_calon_siswa" class="form-select @error('id_calon_siswa') is-invalid @enderror" required autofocus>
                  <option value="">-- Pilih Calon Peserta Didik --</option>
                  @foreach($calonSiswa as $siswa)
                    <option value="{{ $siswa->id_calon_siswa }}" {{ old('id_calon_siswa') == $siswa->id_calon_siswa ? 'selected' : '' }}>
                      {{ $siswa->nama_lengkap }} (NIK: {{ $siswa->nik ?? '-' }}) - {{ $siswa->jenis_kelamin }}
                    </option>
                  @endforeach
                </select>
              </div>
              @error('id_calon_siswa')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- 2. Pilih Jenis Dokumen -->
            <div class="mb-3">
              <label for="id_jenis_dokumen" class="form-label fw-semibold">Jenis Dokumen Persyaratan <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                <select name="id_jenis_dokumen" id="id_jenis_dokumen" class="form-select @error('id_jenis_dokumen') is-invalid @enderror" required>
                  <option value="">-- Pilih Jenis Dokumen Persyaratan --</option>
                  
                  <optgroup label="PERSYARATAN SISWA BARU">
                    @foreach($jenisDokumen->where('kategori', 'siswa_baru') as $jd)
                      <option value="{{ $jd->id_jenis_dokumen }}" 
                              data-kategori="Siswa Baru"
                              data-lembar="{{ $jd->jumlah_lembar }}"
                              data-keterangan="{{ $jd->keterangan }}"
                              {{ old('id_jenis_dokumen') == $jd->id_jenis_dokumen ? 'selected' : '' }}>
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
                              {{ old('id_jenis_dokumen') == $jd->id_jenis_dokumen ? 'selected' : '' }}>
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
                              {{ old('id_jenis_dokumen') == $jd->id_jenis_dokumen ? 'selected' : '' }}>
                        {{ $jd->nama_dokumen }}
                      </option>
                    @endforeach
                  </optgroup>
                </select>
              </div>
              @error('id_jenis_dokumen')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Box Info Syarat Dokumen (Live Script) -->
            <div id="dokumen-info-box" class="p-3 mb-3 bg-light rounded border d-none">
              <div class="d-flex align-items-center mb-1">
                <span id="badge-kategori" class="badge bg-primary me-2"></span>
                <strong id="info-nama-dokumen" class="text-dark"></strong>
              </div>
              <div class="small text-muted mt-1" id="info-ketentuan-lembar"></div>
              <div class="small text-danger mt-1 fst-italic" id="info-keterangan"></div>
            </div>

            <!-- 3. Unggah Berkas File -->
            <div class="mb-3">
              <label for="berkas" class="form-label fw-semibold">Pilih Berkas Dokumen <span class="text-danger">*</span></label>
              <input type="file" name="berkas" id="berkas" class="form-control @error('berkas') is-invalid @enderror" accept=".pdf,image/jpeg,image/png,image/jpg" required>
              <div class="form-text">Format yang didukung: <strong>PDF, JPG, JPEG, PNG</strong>. Ukuran file maksimal: <strong>3 MB (3072 KB)</strong>.</div>
              @error('berkas')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- 4. Status Verifikasi (Khusus Petugas / Default Menunggu) -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="status_verifikasi" class="form-label fw-semibold">Status Verifikasi</label>
                <select name="status_verifikasi" id="status_verifikasi" class="form-select">
                  <option value="menunggu" {{ old('status_verifikasi', 'menunggu') == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                  <option value="valid" {{ old('status_verifikasi') == 'valid' ? 'selected' : '' }}>Valid / Diterima</option>
                  <option value="ditolak" {{ old('status_verifikasi') == 'ditolak' ? 'selected' : '' }}>Ditolak / Berkas Kurang</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="catatan_verifikasi" class="form-label fw-semibold">Catatan Petugas <span class="text-muted fw-normal">(Opsional)</span></label>
                <input type="text" name="catatan_verifikasi" id="catatan_verifikasi" class="form-control" value="{{ old('catatan_verifikasi') }}" placeholder="Contoh: Berkas jelas dan lengkap">
              </div>
            </div>

            <hr class="my-4">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan & Unggah Dokumen
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  $(document).ready(function () {
    function updateDokumenInfo() {
      const selected = $('#id_jenis_dokumen option:selected');
      const val = $('#id_jenis_dokumen').val();

      if (val) {
        const kategori = selected.data('kategori');
        const lembar = selected.data('lembar');
        const keterangan = selected.data('keterangan');
        const text = selected.text().trim();

        $('#badge-kategori').text(kategori);
        $('#info-nama-dokumen').text(text);
        
        if (lembar) {
          $('#info-ketentuan-lembar').html('<i class="bi bi-files me-1 text-primary"></i>Ketentuan fisik berkas: <strong>' + lembar + '</strong>');
        } else {
          $('#info-ketentuan-lembar').html('');
        }

        if (keterangan) {
          $('#info-keterangan').html('<i class="bi bi-exclamation-triangle me-1"></i>Catatan: ' + keterangan);
        } else {
          $('#info-keterangan').html('');
        }

        $('#dokumen-info-box').removeClass('d-none');
      } else {
        $('#dokumen-info-box').addClass('d-none');
      }
    }

    $('#id_jenis_dokumen').on('change', updateDokumenInfo);
    updateDokumenInfo();
  });
</script>
@endpush
