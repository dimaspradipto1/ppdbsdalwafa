@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Detail Hasil Seleksi & Pengumuman</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Proses & Seleksi</li>
      <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
      <li class="breadcrumb-item active">Hasil Seleksi</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <!-- Announcement Header Card -->
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
          <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom pb-3 mb-3">
            <div>
              <span class="badge {{ $pengumuman->is_published ? 'bg-success-subtle text-success border-success-subtle' : 'bg-secondary-subtle text-secondary border-secondary-subtle' }} border px-2 py-1 mb-2">
                {{ $pengumuman->is_published ? 'Status: Dipublikasikan' : 'Status: Draft / Ditutup' }}
              </span>
              <h4 class="fw-bold mb-1 text-dark">{{ $pengumuman->judul }}</h4>
              <div class="text-muted small">
                No. SK: <strong class="font-monospace text-dark">{{ $pengumuman->nomor_surat ?: '-' }}</strong> | 
                Target: <strong>{{ $pengumuman->gelombang->nama_gelombang ?? 'Semua Gelombang' }}</strong> ({{ $pengumuman->tahunAjaran->tahun_ajaran ?? 'Semua TA' }}) | 
                Dibuka: <strong>{{ $pengumuman->tanggal_buka ? $pengumuman->tanggal_buka->translatedFormat('d F Y H:i') : '-' }}</strong>
              </div>
            </div>
            <div class="d-flex gap-2">
              @if($pengumuman->file_lampiran)
                <a href="{{ asset('storage/' . $pengumuman->file_lampiran) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                  <i class="bi bi-file-earmark-pdf me-1"></i> Unduh Lampiran SK
                </a>
              @endif
              <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
              </a>
            </div>
          </div>

          @if($pengumuman->isi_pengumuman)
            <div class="p-3 bg-light rounded-3 text-secondary small mb-2">
              {!! nl2br(e($pengumuman->isi_pengumuman)) !!}
            </div>
          @endif
        </div>
      </div>

      <!-- Students Admission List Table -->
      <div class="card shadow-sm border-0">
        <div class="card-body pt-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="card-title p-0 m-0">Daftar Hasil Kelulusan Calon Siswa ({{ $daftarSiswa->count() }} Siswa)</h5>
              <p class="text-muted small mb-0">Rincian status kelulusan peserta didik dan tombol cetak Surat Keterangan Diterima (SKL).</p>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100">
              <thead class="table-light">
                <tr>
                  <th style="width: 5%" class="text-center">No</th>
                  <th style="width: 15%">No. Registrasi</th>
                  <th style="width: 30%">Nama Calon Siswa</th>
                  <th style="width: 15%">Jalur</th>
                  <th style="width: 15%" class="text-center">Status Kelulusan</th>
                  <th style="width: 20%" class="text-center">Aksi / Dokumen</th>
                </tr>
              </thead>
              <tbody>
                @forelse($daftarSiswa as $idx => $siswa)
                  <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="font-monospace fw-bold">{{ $siswa->no_pendaftaran ?: 'REG-' . $siswa->id_calon_siswa }}</td>
                    <td>
                      <div class="fw-bold text-dark">{{ $siswa->nama_lengkap }}</div>
                      <div class="text-muted small">{{ $siswa->asal_sekolah ?: '-' }}</div>
                    </td>
                    <td>{{ $siswa->jalur->nama_jalur ?? 'Reguler' }}</td>
                    <td class="text-center">
                      @if($siswa->status === 'diterima')
                        <span class="badge bg-success border border-success px-2 py-1"><i class="bi bi-check-circle me-1"></i>LULUS / DITERIMA</span>
                      @elseif($siswa->status === 'ditolak')
                        <span class="badge bg-danger border border-danger px-2 py-1"><i class="bi bi-x-circle me-1"></i>TIDAK LULUS</span>
                      @elseif($siswa->status === 'diverifikasi')
                        <span class="badge bg-info border border-info px-2 py-1"><i class="bi bi-hourglass-split me-1"></i>PROSES SELEKSI</span>
                      @else
                        <span class="badge bg-secondary border border-secondary px-2 py-1">{{ ucfirst($siswa->status) }}</span>
                      @endif
                    </td>
                    <td class="text-center">
                      @if($siswa->status === 'diterima')
                        <a href="{{ route('pengumuman.surat-kelulusan', $siswa->id_calon_siswa) }}" target="_blank" class="btn btn-sm btn-outline-success">
                          <i class="bi bi-file-earmark-check me-1"></i> Cetak Surat Diterima
                        </a>
                      @else
                        <span class="text-muted small fst-italic">Hanya untuk siswa diterima</span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada siswa pada gelombang / tahun ajaran ini.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
