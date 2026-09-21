@extends('layouts.dahsboard.template')

@push('styles')
<style>
  @media print {
    body * {
      visibility: hidden;
    }
    #print-area, #print-area * {
      visibility: visible;
    }
    #print-area {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
    }
    .no-print {
      display: none !important;
    }
  }
  .table-biodata th {
    background-color: #f8f9fa;
    font-weight: 600;
    width: 25%;
  }
  .section-header {
    background-color: #0d6efd;
    color: white;
    padding: 0.5rem 1rem;
    font-weight: 700;
    border-radius: 6px;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
  }
</style>
@endpush

@section('content')
<div class="pagetitle no-print">
  <h1>Detail Biodata Calon Siswa</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pendaftaran</li>
      <li class="breadcrumb-item"><a href="{{ route('calon-siswa.index') }}">Calon Siswa</a></li>
      <li class="breadcrumb-item active">{{ $calonSiswa->nama_lengkap }}</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <!-- Action toolbar (no print) -->
      <div class="d-flex justify-content-between align-items-center mb-3 no-print">
        <a href="{{ route('calon-siswa.index') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-outline-dark" onclick="window.print()">
            <i class="bi bi-printer me-1"></i> Cetak Formulir
          </button>
          <a href="{{ route('calon-siswa.edit', $calonSiswa->id_calon_siswa) }}" class="btn btn-primary">
            <i class="bi bi-pencil-square me-1"></i> Edit Biodata
          </a>
        </div>
      </div>

      <!-- Printable Area -->
      <div class="card shadow-sm border-0" id="print-area">
        <div class="card-body p-4 p-md-5">

          <!-- Header Formulir -->
          <div class="text-center border-bottom pb-4 mb-4">
            <h4 class="fw-bold text-uppercase mb-1">Formulir Pendaftaran Peserta Didik Baru</h4>
            <h5 class="fw-bold text-primary mb-1">SD ISLAM DAARUL AITAM BATAM (AL-WAFA)</h5>
            <p class="text-muted small mb-0">Nomor Registrasi: #REG-{{ str_pad($calonSiswa->id_calon_siswa, 5, '0', STR_PAD_LEFT) }} | Tanggal Pendaftaran: {{ $calonSiswa->created_at->translatedFormat('d F Y') }}</p>
          </div>

          <!-- 1. IDENTITAS PESERTA DIDIK -->
          <div class="section-header">1. IDENTITAS PESERTA DIDIK</div>
          <table class="table table-bordered table-biodata align-middle mb-4">
            <tbody>
              <tr>
                <th>Nama Lengkap</th>
                <td class="fw-bold text-dark fs-6">{{ $calonSiswa->nama_lengkap }}</td>
                <th>Jenis Kelamin</th>
                <td>
                  @if($calonSiswa->jenis_kelamin === 'Laki-laki')
                    <span class="badge bg-primary-subtle text-primary"><i class="bi bi-gender-male me-1"></i>Laki-laki</span>
                  @else
                    <span class="badge bg-danger-subtle text-danger"><i class="bi bi-gender-female me-1"></i>Perempuan</span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>NIK</th>
                <td class="font-monospace">{{ $calonSiswa->nik ?? '-' }}</td>
                <th>NISN</th>
                <td class="font-monospace">{{ $calonSiswa->nisn ?? '-' }}</td>
              </tr>
              <tr>
                <th>Tempat, Tanggal Lahir</th>
                <td>{{ $calonSiswa->tempat_lahir }}, {{ optional($calonSiswa->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                <th>Agama</th>
                <td>{{ optional($calonSiswa->agama)->nama_agama ?? '-' }}</td>
              </tr>
              <tr>
                <th>Jumlah Saudara Kandung</th>
                <td>{{ $calonSiswa->jumlah_saudara_kandung }} orang</td>
                <th>Anak Urutan Ke</th>
                <td>Ke-{{ $calonSiswa->anak_ke }}</td>
              </tr>
              <tr>
                <th>Berkebutuhan Khusus</th>
                <td colspan="3">
                  @if($calonSiswa->kebutuhanKhusus && $calonSiswa->kebutuhanKhusus->kode !== '01')
                    <span class="badge bg-warning text-dark px-2 py-1">
                      <i class="bi bi-heart-pulse me-1"></i>{{ $calonSiswa->kebutuhanKhusus->kode }} - {{ $calonSiswa->kebutuhanKhusus->nama }}
                    </span>
                  @else
                    <span class="badge bg-success-subtle text-success">Tidak Ada (Normal)</span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Asal Sekolah (TK / RA)</th>
                <td>{{ $calonSiswa->asal_sekolah ?? '-' }}</td>
                <th>Status Pendaftaran</th>
                <td><span class="badge bg-primary px-2 py-1 text-uppercase">{{ str_replace('_', ' ', $calonSiswa->status) }}</span></td>
              </tr>
            </tbody>
          </table>

          <!-- 2. ALAMAT TEMPAT TINGGAL & KONTAK -->
          <div class="section-header" style="background-color: #0dcaf0; color: #000;">2. ALAMAT TEMPAT TINGGAL & KONTAK</div>
          <table class="table table-bordered table-biodata align-middle mb-4">
            <tbody>
              <tr>
                <th>Alamat (Dusun/Jalan)</th>
                <td colspan="3">{{ $calonSiswa->alamat_jalan ?? '-' }} (RT {{ $calonSiswa->rt ?? '-' }} / RW {{ $calonSiswa->rw ?? '-' }})</td>
              </tr>
              <tr>
                <th>Kelurahan / Desa</th>
                <td>{{ $calonSiswa->kelurahan ?? '-' }}</td>
                <th>Kode Pos</th>
                <td class="font-monospace">{{ $calonSiswa->kode_pos ?? '-' }}</td>
              </tr>
              <tr>
                <th>Kecamatan</th>
                <td>{{ $calonSiswa->kecamatan ?? '-' }}</td>
                <th>Kabupaten / Kota</th>
                <td>{{ $calonSiswa->kabupaten_kota ?? '-' }}</td>
              </tr>
              <tr>
                <th>Provinsi</th>
                <td>{{ $calonSiswa->provinsi ?? '-' }}</td>
                <th>Jenis Tinggal</th>
                <td>{{ $calonSiswa->jenis_tinggal ?? '-' }}</td>
              </tr>
              <tr>
                <th>Alat Transportasi</th>
                <td>{{ $calonSiswa->alat_transportasi ?? '-' }}</td>
                <th>No. HP / WhatsApp</th>
                <td>{{ $calonSiswa->no_hp ?? '-' }}</td>
              </tr>
              <tr>
                <th>Telepon Rumah</th>
                <td>{{ $calonSiswa->telepon_rumah ?? '-' }}</td>
                <th>Email Pribadi</th>
                <td>{{ $calonSiswa->email ?? '-' }}</td>
              </tr>
              <tr>
                <th>Jarak ke Sekolah</th>
                <td>
                  {{ $calonSiswa->jarak_ke_sekolah ?? '-' }}
                  @if($calonSiswa->jarak_ke_sekolah_detail)
                    ({{ $calonSiswa->jarak_ke_sekolah_detail }})
                  @endif
                </td>
                <th>Waktu Tempuh</th>
                <td>{{ $calonSiswa->waktu_tempuh ?? '-' }}</td>
              </tr>
            </tbody>
          </table>

          <!-- 3. DATA ORANG TUA KANDUNG & WALI -->
          <div class="section-header" style="background-color: #198754;">3. DATA ORANG TUA & WALI</div>
          <div class="row g-3 mb-4">
            <!-- Ayah -->
            <div class="col-md-4">
              <div class="card h-100 border-primary shadow-none">
                <div class="card-header bg-primary text-white fw-bold py-2">
                  <i class="bi bi-gender-male me-1"></i> Data Ayah Kandung
                </div>
                <div class="card-body p-3 small">
                  <div class="mb-2"><strong>Nama:</strong> {{ $calonSiswa->nama_ayah ?? '-' }}</div>
                  <div class="mb-2"><strong>TTL:</strong> {{ $calonSiswa->tempat_lahir_ayah ?? '-' }}, {{ optional($calonSiswa->tanggal_lahir_ayah)->translatedFormat('d M Y') ?? '-' }}</div>
                  <div class="mb-2"><strong>Pekerjaan:</strong> {{ optional($calonSiswa->pekerjaanAyah)->nama_pekerjaan ?? '-' }}</div>
                  <div class="mb-2"><strong>Pendidikan:</strong> {{ optional($calonSiswa->pendidikanAyah)->nama_pendidikan ?? '-' }}</div>
                  <div class="mb-2"><strong>Agama:</strong> {{ optional($calonSiswa->agamaAyah)->nama_agama ?? '-' }}</div>
                  <div><strong>Penghasilan:</strong> {{ optional($calonSiswa->penghasilanAyah)->label ?? '-' }}</div>
                </div>
              </div>
            </div>

            <!-- Ibu -->
            <div class="col-md-4">
              <div class="card h-100 border-danger shadow-none">
                <div class="card-header bg-danger text-white fw-bold py-2">
                  <i class="bi bi-gender-female me-1"></i> Data Ibu Kandung
                </div>
                <div class="card-body p-3 small">
                  <div class="mb-2"><strong>Nama:</strong> {{ $calonSiswa->nama_ibu ?? '-' }}</div>
                  <div class="mb-2"><strong>TTL:</strong> {{ $calonSiswa->tempat_lahir_ibu ?? '-' }}, {{ optional($calonSiswa->tanggal_lahir_ibu)->translatedFormat('d M Y') ?? '-' }}</div>
                  <div class="mb-2"><strong>Pekerjaan:</strong> {{ optional($calonSiswa->pekerjaanIbu)->nama_pekerjaan ?? '-' }}</div>
                  <div class="mb-2"><strong>Pendidikan:</strong> {{ optional($calonSiswa->pendidikanIbu)->nama_pendidikan ?? '-' }}</div>
                  <div class="mb-2"><strong>Agama:</strong> {{ optional($calonSiswa->agamaIbu)->nama_agama ?? '-' }}</div>
                  <div><strong>Penghasilan:</strong> {{ optional($calonSiswa->penghasilanIbu)->label ?? '-' }}</div>
                </div>
              </div>
            </div>

            <!-- Wali -->
            <div class="col-md-4">
              <div class="card h-100 border-secondary shadow-none">
                <div class="card-header bg-secondary text-white fw-bold py-2">
                  <i class="bi bi-person-check me-1"></i> Data Wali
                </div>
                <div class="card-body p-3 small">
                  <div class="mb-2"><strong>Nama:</strong> {{ $calonSiswa->nama_wali ?? '-' }}</div>
                  <div class="mb-2"><strong>TTL:</strong> {{ $calonSiswa->tempat_lahir_wali ?? '-' }}, {{ optional($calonSiswa->tanggal_lahir_wali)->translatedFormat('d M Y') ?? '-' }}</div>
                  <div class="mb-2"><strong>Pekerjaan:</strong> {{ optional($calonSiswa->pekerjaanWali)->nama_pekerjaan ?? '-' }}</div>
                  <div class="mb-2"><strong>Pendidikan:</strong> {{ optional($calonSiswa->pendidikanWali)->nama_pendidikan ?? '-' }}</div>
                  <div class="mb-2"><strong>Agama:</strong> {{ optional($calonSiswa->agamaWali)->nama_agama ?? '-' }}</div>
                  <div><strong>Penghasilan:</strong> {{ optional($calonSiswa->penghasilanWali)->label ?? '-' }}</div>
                </div>
              </div>
            </div>
          </div>

          <!-- 4. CATATAN PRESTASI -->
          <div class="section-header" style="background-color: #ffc107; color: #000;">4. CATATAN PRESTASI</div>
          @if($calonSiswa->prestasi->count() > 0)
            <div class="table-responsive mb-4">
              <table class="table table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th style="width: 5%" class="text-center">No</th>
                    <th>Jenis Prestasi</th>
                    <th>Tingkat</th>
                    <th>Nama Prestasi</th>
                    <th class="text-center">Tahun</th>
                    <th>Penyelenggara</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($calonSiswa->prestasi as $idx => $pres)
                    <tr>
                      <td class="text-center">{{ $idx + 1 }}</td>
                      <td><span class="badge bg-primary-subtle text-primary">{{ $pres->jenis_prestasi }}</span></td>
                      <td><span class="badge bg-info-subtle text-info">{{ $pres->tingkat }}</span></td>
                      <td class="fw-bold">{{ $pres->nama_prestasi }}</td>
                      <td class="text-center font-monospace">{{ $pres->tahun }}</td>
                      <td>{{ $pres->penyelenggara }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="alert alert-light border text-muted small mb-4">
              <i class="bi bi-info-circle me-1"></i> Tidak ada catatan prestasi yang dilampirkan.
            </div>
          @endif

          <!-- 5. RIWAYAT BEASISWA -->
          <div class="section-header" style="background-color: #6f42c1;">5. RIWAYAT BEASISWA</div>
          @if($calonSiswa->beasiswa->count() > 0)
            <div class="table-responsive mb-4">
              <table class="table table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th style="width: 5%" class="text-center">No</th>
                    <th>Jenis Beasiswa</th>
                    <th>Penyelenggara / Sumber</th>
                    <th class="text-center">Tahun Mulai</th>
                    <th class="text-center">Tahun Selesai</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($calonSiswa->beasiswa as $idx => $bea)
                    <tr>
                      <td class="text-center">{{ $idx + 1 }}</td>
                      <td class="fw-bold">{{ $bea->jenis_beasiswa }}</td>
                      <td>{{ $bea->penyelenggara }}</td>
                      <td class="text-center font-monospace">{{ $bea->tahun_mulai }}</td>
                      <td class="text-center font-monospace">{{ $bea->tahun_selesai ?? 'Sekarang / Aktif' }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="alert alert-light border text-muted small mb-4">
              <i class="bi bi-info-circle me-1"></i> Tidak ada riwayat beasiswa yang dilampirkan.
            </div>
          @endif

          <!-- Lembar Tanda Tangan Cetak -->
          <div class="row mt-5 pt-3 border-top d-none d-print-flex">
            <div class="col-6 text-center">
              <p class="mb-5">Mengetahui,<br>Orang Tua / Wali Calon Siswa</p>
              <p class="fw-bold mt-5">( .................................................... )</p>
            </div>
            <div class="col-6 text-center">
              <p class="mb-5">Batam, {{ date('d F Y') }}<br>Panitia PPDB SD Islam Al-Wafa</p>
              <p class="fw-bold mt-5">( .................................................... )</p>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
