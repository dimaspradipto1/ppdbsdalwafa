@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Edit Transaksi Pembayaran</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Proses & Seleksi</li>
      <li class="breadcrumb-item"><a href="{{ route('pembayaran.index') }}">Pembayaran</a></li>
      <li class="breadcrumb-item active">{{ $pembayaran->kode_transaksi }}</li>
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
          <form action="{{ route('pembayaran.update', $pembayaran->id_pembayaran) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label text-muted small fw-semibold">Kode Transaksi</label>
              <input type="text" class="form-control bg-light font-monospace fw-bold" value="{{ $pembayaran->kode_transaksi }}" readonly>
            </div>

            <div class="mb-3">
              <label for="id_calon_siswa" class="form-label fw-semibold">Calon Siswa <span class="text-danger">*</span></label>
              <select name="id_calon_siswa" id="id_calon_siswa" class="form-select @error('id_calon_siswa') is-invalid @enderror" required>
                @foreach($daftarSiswa as $siswa)
                  <option value="{{ $siswa->id_calon_siswa }}" {{ old('id_calon_siswa', $pembayaran->id_calon_siswa) == $siswa->id_calon_siswa ? 'selected' : '' }}>
                    {{ $siswa->nama_lengkap }} ({{ $siswa->no_pendaftaran ?: 'REG-' . $siswa->id_calon_siswa }})
                  </option>
                @endforeach
              </select>
              @error('id_calon_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="id_biaya" class="form-label fw-semibold">Jenis Tagihan / Biaya</label>
              <select name="id_biaya" id="id_biaya" class="form-select @error('id_biaya') is-invalid @enderror">
                <option value="">-- Pembayaran Bebas / Umum --</option>
                @foreach($daftarBiaya as $b)
                  <option value="{{ $b->id_biaya }}" {{ old('id_biaya', $pembayaran->id_biaya) == $b->id_biaya ? 'selected' : '' }}>
                    {{ $b->nama_biaya }} (Rp {{ number_format($b->nominal, 0, ',', '.') }})
                  </option>
                @endforeach
              </select>
              @error('id_biaya')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="nominal" class="form-label fw-semibold">Nominal Pembayaran (Rp) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light fw-bold">Rp</span>
                  <input type="number" name="nominal" id="nominal" class="form-control font-monospace fw-bold text-success @error('nominal') is-invalid @enderror" value="{{ old('nominal', (int)$pembayaran->nominal) }}" required>
                </div>
                @error('nominal')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6">
                <label for="metode_pembayaran" class="form-label fw-semibold">Metode Pembayaran <span class="text-danger">*</span></label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select @error('metode_pembayaran') is-invalid @enderror" required>
                  <option value="Transfer Bank BSI" {{ old('metode_pembayaran', $pembayaran->metode_pembayaran) == 'Transfer Bank BSI' ? 'selected' : '' }}>Transfer Bank BSI (Bank Syariah Indonesia)</option>
                  <option value="Transfer Bank Lain" {{ old('metode_pembayaran', $pembayaran->metode_pembayaran) == 'Transfer Bank Lain' ? 'selected' : '' }}>Transfer Bank Lain (BCA, Mandiri, BRI, dll)</option>
                  <option value="Tunai / Kasir Sekolah" {{ old('metode_pembayaran', $pembayaran->metode_pembayaran) == 'Tunai / Kasir Sekolah' ? 'selected' : '' }}>Tunai / Kasir Sekolah</option>
                </select>
              </div>
            </div>

            <div class="card bg-light border-0 p-3 mb-3 rounded-3">
              <div class="fw-semibold text-secondary mb-2 small"><i class="bi bi-bank me-1"></i>Informasi Rekening Pengirim</div>
              <div class="row g-2">
                <div class="col-md-4">
                  <input type="text" name="nama_bank_pengirim" class="form-control form-control-sm" placeholder="Nama Bank Pengirim" value="{{ old('nama_bank_pengirim', $pembayaran->nama_bank_pengirim) }}">
                </div>
                <div class="col-md-4">
                  <input type="text" name="nomor_rekening_pengirim" class="form-control form-control-sm font-monospace" placeholder="Nomor Rekening Pengirim" value="{{ old('nomor_rekening_pengirim', $pembayaran->nomor_rekening_pengirim) }}">
                </div>
                <div class="col-md-4">
                  <input type="text" name="atas_nama_pengirim" class="form-control form-control-sm" placeholder="Atas Nama Pengirim" value="{{ old('atas_nama_pengirim', $pembayaran->atas_nama_pengirim) }}">
                </div>
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="bukti_transfer" class="form-label fw-semibold">Ganti Bukti Transfer</label>
                <input type="file" name="bukti_transfer" id="bukti_transfer" class="form-control @error('bukti_transfer') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                @if($pembayaran->bukti_transfer)
                  <div class="mt-2">
                    <a href="{{ asset('storage/' . $pembayaran->bukti_transfer) }}" target="_blank" class="small text-primary">
                      <i class="bi bi-paperclip me-1"></i>Lihat Bukti Transfer Saat Ini
                    </a>
                  </div>
                @endif
              </div>

              <div class="col-md-6">
                <label for="status_pembayaran" class="form-label fw-semibold">Status Pembayaran <span class="text-danger">*</span></label>
                <select name="status_pembayaran" id="status_pembayaran" class="form-select @error('status_pembayaran') is-invalid @enderror" required>
                  <option value="menunggu_konfirmasi" {{ old('status_pembayaran', $pembayaran->status_pembayaran) == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                  <option value="lunas" {{ old('status_pembayaran', $pembayaran->status_pembayaran) == 'lunas' ? 'selected' : '' }}>Lunas (Terkonfirmasi)</option>
                  <option value="ditolak" {{ old('status_pembayaran', $pembayaran->status_pembayaran) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
              </div>
            </div>

            <div class="mb-4">
              <label for="catatan" class="form-label fw-semibold">Catatan</label>
              <textarea name="catatan" id="catatan" rows="2" class="form-control">{{ old('catatan', $pembayaran->catatan) }}</textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
              <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Perbarui Transaksi</button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
