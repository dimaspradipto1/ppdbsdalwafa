@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Edit Pengumuman Kelulusan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Proses & Seleksi</li>
      <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
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
        <div class="card-body pt-4">
          <form action="{{ route('pengumuman.update', $pengumuman->id_pengumuman) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="judul" class="form-label fw-semibold">Judul Pengumuman <span class="text-danger">*</span></label>
              <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $pengumuman->judul) }}" required>
              @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="id_tahun_ajaran" class="form-label fw-semibold">Tahun Ajaran</label>
                <select name="id_tahun_ajaran" id="id_tahun_ajaran" class="form-select">
                  <option value="">Semua Tahun Ajaran</option>
                  @foreach($daftarTahunAjaran as $ta)
                    <option value="{{ $ta->id_tahun_ajaran }}" {{ old('id_tahun_ajaran', $pengumuman->id_tahun_ajaran) == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                      {{ $ta->tahun_ajaran }} {{ $ta->is_active ? '(Aktif)' : '' }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="id_gelombang" class="form-label fw-semibold">Gelombang Pendaftaran</label>
                <select name="id_gelombang" id="id_gelombang" class="form-select">
                  <option value="">Semua Gelombang</option>
                  @foreach($daftarGelombang as $gel)
                    <option value="{{ $gel->id_gelombang }}" {{ old('id_gelombang', $pengumuman->id_gelombang) == $gel->id_gelombang ? 'selected' : '' }}>
                      {{ $gel->nama_gelombang }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="nomor_surat" class="form-label fw-semibold">Nomor Surat Keputusan (SK)</label>
                <input type="text" name="nomor_surat" id="nomor_surat" class="form-control font-monospace" value="{{ old('nomor_surat', $pengumuman->nomor_surat) }}">
              </div>

              <div class="col-md-6">
                <label for="tanggal_buka" class="form-label fw-semibold">Jadwal Tanggal & Jam Buka <span class="text-danger">*</span></label>
                <input type="datetime-local" name="tanggal_buka" id="tanggal_buka" class="form-control @error('tanggal_buka') is-invalid @enderror" value="{{ old('tanggal_buka', optional($pengumuman->tanggal_buka)->format('Y-m-d\TH:i')) }}" required>
                @error('tanggal_buka')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="mb-3">
              <label for="isi_pengumuman" class="form-label fw-semibold">Pesan / Isi Pengumuman</label>
              <textarea name="isi_pengumuman" id="isi_pengumuman" rows="4" class="form-control">{{ old('isi_pengumuman', $pengumuman->isi_pengumuman) }}</textarea>
            </div>

            <div class="mb-3">
              <label for="file_lampiran" class="form-label fw-semibold">Ganti Berkas SK / Lampiran (PDF)</label>
              <input type="file" name="file_lampiran" id="file_lampiran" class="form-control @error('file_lampiran') is-invalid @enderror" accept=".pdf,.jpg,.png">
              @if($pengumuman->file_lampiran)
                <div class="mt-2">
                  <a href="{{ asset('storage/' . $pengumuman->file_lampiran) }}" target="_blank" class="small text-primary">
                    <i class="bi bi-file-earmark-pdf me-1"></i>Lihat Berkas Lampiran Saat Ini
                  </a>
                </div>
              @endif
              @error('file_lampiran')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4 form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $pengumuman->is_published) ? 'checked' : '' }}>
              <label class="form-check-label fw-semibold" for="is_published">Publikasikan Pengumuman Ini</label>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Batal</a>
              <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Perbarui Pengumuman</button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
