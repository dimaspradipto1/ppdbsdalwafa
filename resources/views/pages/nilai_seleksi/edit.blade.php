@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Input & Penilaian Seleksi Siswa</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Proses & Seleksi</li>
      <li class="breadcrumb-item"><a href="{{ route('nilai-seleksi.index') }}">Penilaian Seleksi</a></li>
      <li class="breadcrumb-item active">{{ $calonSiswa->nama_lengkap }}</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-10">

      <!-- Profile Header -->
      <div class="card shadow-sm border-0 mb-3 bg-light">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h5 class="fw-bold mb-1 text-dark">{{ $calonSiswa->nama_lengkap }}</h5>
              <div class="text-muted small">
                No. Registrasi: <strong class="font-monospace text-primary">{{ $calonSiswa->no_pendaftaran ?: 'REG-' . $calonSiswa->id_calon_siswa }}</strong> | 
                Jalur: <strong>{{ $calonSiswa->jalur->nama_jalur ?? 'Reguler' }}</strong> | 
                Gelombang: <strong>{{ $calonSiswa->gelombang->nama_gelombang ?? '-' }}</strong>
              </div>
            </div>
            <a href="{{ route('nilai-seleksi.index') }}" class="btn btn-secondary btn-sm">
              <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
          </div>
        </div>
      </div>

      <div class="card shadow-sm border-0">
        <div class="card-body pt-3">
          <form action="{{ route('nilai-seleksi.update', $calonSiswa->id_calon_siswa) }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="card-title p-0 mb-3">Lembar Penilaian Komponen Seleksi</h5>

            <div class="table-responsive mb-4">
              <table class="table table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th style="width: 5%" class="text-center">No</th>
                    <th style="width: 28%">Komponen Seleksi</th>
                    <th style="width: 12%" class="text-center">KKM (Min)</th>
                    <th style="width: 10%" class="text-center">Bobot</th>
                    <th style="width: 18%" class="text-center">Nilai Skor (0 - 100)</th>
                    <th>Catatan Penguji / Hasil Observasi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($komponenList as $idx => $komp)
                    @php
                      $rec = $nilaiMap->get($komp->id_komponen_seleksi);
                      $currNilai = $rec ? $rec->nilai : null;
                      $currCatatan = $rec ? $rec->catatan : null;
                    @endphp
                    <tr>
                      <td class="text-center">{{ $idx + 1 }}</td>
                      <td>
                        <strong class="d-block text-dark">{{ $komp->nama_komponen }}</strong>
                        <small class="text-muted">{{ $komp->keterangan ?: 'Kriteria evaluasi standar sekolah' }}</small>
                      </td>
                      <td class="text-center font-monospace">{{ $komp->nilai_minimal }}</td>
                      <td class="text-center font-monospace">{{ $komp->bobot_persen ? $komp->bobot_persen . '%' : '-' }}</td>
                      <td>
                        <input type="number" 
                               step="0.1" 
                               min="0" 
                               max="100" 
                               name="nilai[{{ $komp->id_komponen_seleksi }}]" 
                               class="form-control text-center font-monospace fw-bold fs-6 input-skor" 
                               value="{{ old('nilai.' . $komp->id_komponen_seleksi, $currNilai) }}" 
                               placeholder="0 - 100">
                      </td>
                      <td>
                        <input type="text" 
                               name="catatan[{{ $komp->id_komponen_seleksi }}]" 
                               class="form-control form-control-sm" 
                               value="{{ old('catatan.' . $komp->id_komponen_seleksi, $currCatatan) }}" 
                               placeholder="Contoh: Sangat baik / Perlu pendampingan">
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- Rekomendasi Status Kelulusan oleh Penguji -->
            <div class="card bg-light border-0 p-3 mb-4 rounded-3">
              <div class="row align-items-center">
                <div class="col-md-7">
                  <label class="form-label fw-semibold text-dark mb-0">Rekomendasi Status Calon Siswa</label>
                  <p class="text-muted small mb-0">Penguji dapat langsung memberikan rekomendasi status penerimaan siswa baru.</p>
                </div>
                <div class="col-md-5">
                  <select name="status_rekomendasi" class="form-select">
                    <option value="">-- Tetap Gunakan Status Saat Ini ({{ ucfirst(str_replace('_', ' ', $calonSiswa->status)) }}) --</option>
                    <option value="diterima" {{ $calonSiswa->status === 'diterima' ? 'selected' : '' }}>Diterima (Lulus Seleksi)</option>
                    <option value="diverifikasi" {{ $calonSiswa->status === 'diverifikasi' ? 'selected' : '' }}>Diverifikasi / Dipertimbangkan</option>
                    <option value="ditolak" {{ $calonSiswa->status === 'ditolak' ? 'selected' : '' }}>Ditolak (Tidak Memenuhi Kriteria)</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('nilai-seleksi.index') }}" class="btn btn-secondary">Batal</a>
              <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-1"></i> Simpan Penilaian Seleksi
              </button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
