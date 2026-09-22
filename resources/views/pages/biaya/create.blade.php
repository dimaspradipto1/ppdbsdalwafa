@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Tambah Tarif & Biaya PPDB</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item"><a href="{{ route('biaya.index') }}">Tarif & Biaya</a></li>
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
          <h5 class="card-title">Form Tambah Tarif Biaya PPDB</h5>

          <form action="{{ route('biaya.store') }}" method="POST">
            @csrf

            <!-- Nama Biaya -->
            <div class="mb-3">
              <label for="nama_biaya" class="form-label fw-semibold">Nama Biaya / Komponen Tagihan <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-cash-coin"></i></span>
                <input type="text" name="nama_biaya" id="nama_biaya" class="form-control @error('nama_biaya') is-invalid @enderror" value="{{ old('nama_biaya') }}" placeholder="Contoh: Biaya Formulir, Uang Pangkal / Masuk, SPP Juli" required autofocus>
              </div>
              @error('nama_biaya')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <!-- Jenis Biaya -->
              <div class="col-md-6 mb-3">
                <label for="jenis_biaya" class="form-label fw-semibold">Kategori Biaya <span class="text-danger">*</span></label>
                <select name="jenis_biaya" id="jenis_biaya" class="form-select @error('jenis_biaya') is-invalid @enderror" required>
                  @foreach($kategoriBiaya as $key => $label)
                    <option value="{{ $key }}" {{ old('jenis_biaya', 'uang_pangkal') === $key ? 'selected' : '' }}>{{ $label }}</option>
                  @endforeach
                </select>
                @error('jenis_biaya')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Nominal -->
              <div class="col-md-6 mb-3">
                <label for="nominal" class="form-label fw-semibold">Nominal Tarif (Rp) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text fw-bold">Rp</span>
                  <input type="number" name="nominal" id="nominal" min="0" step="1000" class="form-control font-monospace @error('nominal') is-invalid @enderror" value="{{ old('nominal') }}" placeholder="Contoh: 5000000" required>
                </div>
                @error('nominal')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row">
              <!-- Tipe Pembayaran -->
              <div class="col-md-6 mb-3">
                <label for="tipe_pembayaran" class="form-label fw-semibold">Tipe Pembayaran <span class="text-danger">*</span></label>
                <select name="tipe_pembayaran" id="tipe_pembayaran" class="form-select @error('tipe_pembayaran') is-invalid @enderror" required>
                  @foreach($tipePembayaran as $key => $label)
                    <option value="{{ $key }}" {{ old('tipe_pembayaran', 'sekali_bayar') === $key ? 'selected' : '' }}>{{ $label }}</option>
                  @endforeach
                </select>
                @error('tipe_pembayaran')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Tahun Ajaran -->
              <div class="col-md-6 mb-3">
                <label for="id_tahun_ajaran" class="form-label fw-semibold">Tahun Ajaran <span class="text-muted fw-normal">(Opsional)</span></label>
                <select name="id_tahun_ajaran" id="id_tahun_ajaran" class="form-select">
                  <option value="">Semua Tahun Ajaran</option>
                  @foreach($tahunAjaranList as $ta)
                    <option value="{{ $ta->id_tahun_ajaran }}" {{ old('id_tahun_ajaran', optional($activeTahunAjaran)->id_tahun_ajaran) == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                      {{ $ta->tahun_ajaran }} {{ $ta->is_active ? '(Aktif)' : '' }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row">
              <!-- Gelombang Khusus (opsional) -->
              <div class="col-md-6 mb-3">
                <label for="id_gelombang" class="form-label fw-semibold">Khusus Gelombang <span class="text-muted fw-normal">(Opsional)</span></label>
                <select name="id_gelombang" id="id_gelombang" class="form-select">
                  <option value="">Berlaku untuk Semua Gelombang</option>
                  @foreach($gelombangList as $g)
                    <option value="{{ $g->id_gelombang }}" {{ old('id_gelombang') == $g->id_gelombang ? 'selected' : '' }}>
                      {{ $g->nama_gelombang }}
                    </option>
                  @endforeach
                </select>
              </div>

              <!-- Jalur Khusus (opsional) -->
              <div class="col-md-6 mb-3">
                <label for="id_jalur" class="form-label fw-semibold">Khusus Jalur <span class="text-muted fw-normal">(Opsional)</span></label>
                <select name="id_jalur" id="id_jalur" class="form-select">
                  <option value="">Berlaku untuk Semua Jalur</option>
                  @foreach($jalurList as $j)
                    <option value="{{ $j->id_jalur }}" {{ old('id_jalur') == $j->id_jalur ? 'selected' : '' }}>
                      {{ $j->nama_jalur }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- Keterangan -->
            <div class="mb-3">
              <label for="keterangan" class="form-label fw-semibold">Keterangan / Catatan Tagihan</label>
              <textarea name="keterangan" id="keterangan" rows="2" class="form-control" placeholder="Contoh: Denda keterlambatan SPP lewat tanggal 10 adalah Rp 10.000/hari">{{ old('keterangan') }}</textarea>
            </div>

            <div class="row mb-4">
              <!-- Sifat Wajib -->
              <div class="col-md-6 mb-2">
                <label class="form-label fw-semibold d-block">Sifat Tagihan</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="is_wajib" name="is_wajib" value="1" {{ old('is_wajib', true) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_wajib">Wajib Dibayar oleh Calon Siswa</label>
                </div>
              </div>

              <!-- Status Aktif -->
              <div class="col-md-6 mb-2">
                <label class="form-label fw-semibold d-block">Status Tagihan</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_active">Aktifkan pada rincian pembayaran</label>
                </div>
              </div>
            </div>

            <hr class="my-4">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('biaya.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan Tarif Biaya
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
