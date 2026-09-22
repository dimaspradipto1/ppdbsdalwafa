@extends('layouts.dahsboard.template')

@push('styles')
<style>
  .nav-pills .nav-link {
    font-weight: 600;
    color: #495057;
    border-radius: 8px;
    padding: 0.65rem 1.1rem;
    transition: all 0.2s ease;
  }
  .nav-pills .nav-link.active {
    background-color: #0d6efd;
    color: #fff;
    box-shadow: 0 4px 10px rgba(13, 110, 253, 0.25);
  }
  .section-card-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #012970;
    margin-bottom: 1.25rem;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 0.5rem;
  }
  .dynamic-table th {
    background-color: #f8f9fa;
    font-weight: 600;
    font-size: 0.85rem;
  }
</style>
@endpush

@section('content')
<div class="pagetitle">
  <h1>Edit Formulir Calon Siswa</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pendaftaran</li>
      <li class="breadcrumb-item"><a href="{{ route('calon-siswa.index') }}">Calon Siswa</a></li>
      <li class="breadcrumb-item active">Edit Siswa</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

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

      <form action="{{ route('calon-siswa.update', $calonSiswa->id_calon_siswa) }}" method="POST" id="form-calon-siswa">
        @csrf
        @method('PUT')

        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body pt-3">

            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-fill mb-4 gap-2 bg-light p-2 rounded-3" id="pendaftaranTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-identitas-btn" data-bs-toggle="pill" data-bs-target="#tab-identitas" type="button" role="tab">
                  <i class="bi bi-person me-1"></i> 1. Identitas Siswa
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-alamat-btn" data-bs-toggle="pill" data-bs-target="#tab-alamat" type="button" role="tab">
                  <i class="bi bi-geo-alt me-1"></i> 2. Alamat & Kontak
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-ortu-btn" data-bs-toggle="pill" data-bs-target="#tab-ortu" type="button" role="tab">
                  <i class="bi bi-people me-1"></i> 3. Orang Tua & Wali
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-prestasi-btn" data-bs-toggle="pill" data-bs-target="#tab-prestasi" type="button" role="tab">
                  <i class="bi bi-trophy me-1"></i> 4. Prestasi ({{ $calonSiswa->prestasi->count() }})
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-beasiswa-btn" data-bs-toggle="pill" data-bs-target="#tab-beasiswa" type="button" role="tab">
                  <i class="bi bi-award me-1"></i> 5. Beasiswa ({{ $calonSiswa->beasiswa->count() }})
                </button>
              </li>
            </ul>

            <!-- Tab Contents -->
            <div class="tab-content pt-2" id="pendaftaranTabContent">

              <!-- ============================================================= -->
              <!-- 1. IDENTITAS PESERTA DIDIK                                    -->
              <!-- ============================================================= -->
              <div class="tab-pane fade show active" id="tab-identitas" role="tabpanel">
                <div class="card bg-primary-subtle border border-primary-subtle mb-4 p-3 rounded-3 shadow-none">
                  <div class="fw-bold text-primary mb-2"><i class="bi bi-info-circle me-1"></i> Program & Jalur Pendaftaran PPDB</div>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label for="id_tahun_ajaran" class="form-label fw-semibold text-dark">Tahun Ajaran</label>
                      <select name="id_tahun_ajaran" id="id_tahun_ajaran" class="form-select bg-white">
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($daftarTahunAjaran as $ta)
                          <option value="{{ $ta->id_tahun_ajaran }}" {{ old('id_tahun_ajaran', $calonSiswa->id_tahun_ajaran) == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} {{ $ta->is_active ? '(Aktif)' : '' }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="id_gelombang" class="form-label fw-semibold text-dark">Gelombang Pendaftaran</label>
                      <select name="id_gelombang" id="id_gelombang" class="form-select bg-white">
                        <option value="">-- Pilih Gelombang --</option>
                        @foreach($daftarGelombang as $gel)
                          <option value="{{ $gel->id_gelombang }}" {{ old('id_gelombang', $calonSiswa->id_gelombang) == $gel->id_gelombang ? 'selected' : '' }}>
                            {{ $gel->nama_gelombang }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="id_jalur" class="form-label fw-semibold text-dark">Jalur Pendaftaran</label>
                      <select name="id_jalur" id="id_jalur" class="form-select bg-white">
                        <option value="">-- Pilih Jalur --</option>
                        @foreach($daftarJalur as $j)
                          <option value="{{ $j->id_jalur }}" {{ old('id_jalur', $calonSiswa->id_jalur) == $j->id_jalur ? 'selected' : '' }}>
                            {{ $j->nama_jalur }} (Kuota: {{ $j->kuota ?? 'Tak Terbatas' }})
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="section-card-title"><i class="bi bi-person-badge text-primary me-2"></i>1. Identitas Peserta Didik</div>
                
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap Calon Siswa <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $calonSiswa->nama_lengkap) }}" placeholder="Masukkan nama lengkap siswa" required>
                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-md-3">
                    <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                      <option value="">-- Pilih Jenis Kelamin --</option>
                      <option value="Laki-laki" {{ old('jenis_kelamin', $calonSiswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                      <option value="Perempuan" {{ old('jenis_kelamin', $calonSiswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-md-3">
                    <label for="id_agama" class="form-label fw-semibold">Agama</label>
                    <select name="id_agama" id="id_agama" class="form-select @error('id_agama') is-invalid @enderror">
                      <option value="">-- Pilih Agama --</option>
                      @foreach($daftarAgama as $ag)
                        <option value="{{ $ag->id_agama }}" {{ old('id_agama', $calonSiswa->id_agama) == $ag->id_agama ? 'selected' : '' }}>{{ $ag->nama_agama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label for="nik" class="form-label fw-semibold">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" id="nik" maxlength="16" class="form-control font-monospace @error('nik') is-invalid @enderror" value="{{ old('nik', $calonSiswa->nik) }}" placeholder="16 digit NIK calon siswa">
                    @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-md-6">
                    <label for="nisn" class="form-label fw-semibold">NISN (Nomor Induk Siswa Nasional)</label>
                    <input type="text" name="nisn" id="nisn" maxlength="10" class="form-control font-monospace @error('nisn') is-invalid @enderror" value="{{ old('nisn', $calonSiswa->nisn) }}" placeholder="10 digit NISN jika sudah ada">
                  </div>

                  <div class="col-md-6">
                    <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $calonSiswa->tempat_lahir) }}" placeholder="Kota / Kabupaten kelahiran" required>
                    @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-md-6">
                    <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', optional($calonSiswa->tanggal_lahir)->format('Y-m-d')) }}" required>
                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-md-3">
                    <label for="anak_ke" class="form-label fw-semibold">Anak Urutan Ke</label>
                    <input type="number" name="anak_ke" id="anak_ke" min="1" class="form-control" value="{{ old('anak_ke', $calonSiswa->anak_ke) }}">
                  </div>

                  <div class="col-md-3">
                    <label for="jumlah_saudara_kandung" class="form-label fw-semibold">Jumlah Saudara Kandung</label>
                    <input type="number" name="jumlah_saudara_kandung" id="jumlah_saudara_kandung" min="0" class="form-control" value="{{ old('jumlah_saudara_kandung', $calonSiswa->jumlah_saudara_kandung) }}">
                  </div>

                  <div class="col-md-6">
                    <label for="id_kebutuhan_khusus" class="form-label fw-semibold">Berkebutuhan Khusus</label>
                    <select name="id_kebutuhan_khusus" id="id_kebutuhan_khusus" class="form-select">
                      <option value="">-- Tidak Ada / Normal --</option>
                      @foreach($daftarKebutuhanKhusus as $k)
                        <option value="{{ $k->id_kebutuhan }}" {{ old('id_kebutuhan_khusus', $calonSiswa->id_kebutuhan_khusus) == $k->id_kebutuhan ? 'selected' : '' }}>
                          {{ $k->kode }} - {{ $k->nama }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label for="asal_sekolah" class="form-label fw-semibold">Asal Sekolah (TK / RA)</label>
                    <input type="text" name="asal_sekolah" id="asal_sekolah" class="form-control" value="{{ old('asal_sekolah', $calonSiswa->asal_sekolah) }}" placeholder="Contoh: TK Islam Terpadu Al-Wafa">
                  </div>

                  <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status Pendaftaran</label>
                    <select name="status" id="status" class="form-select">
                      <option value="menunggu_verifikasi" {{ old('status', $calonSiswa->status) == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                      <option value="draft" {{ old('status', $calonSiswa->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                      <option value="diverifikasi" {{ old('status', $calonSiswa->status) == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                      <option value="diterima" {{ old('status', $calonSiswa->status) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                      <option value="ditolak" {{ old('status', $calonSiswa->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                  </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                  <button type="button" class="btn btn-primary next-tab-btn" data-next="#tab-alamat-btn">
                    Lanjut ke Alamat & Kontak <i class="bi bi-arrow-right ms-1"></i>
                  </button>
                </div>
              </div>

              <!-- ============================================================= -->
              <!-- 2. ALAMAT TEMPAT TINGGAL & KONTAK                             -->
              <!-- ============================================================= -->
              <div class="tab-pane fade" id="tab-alamat" role="tabpanel">
                <div class="section-card-title"><i class="bi bi-geo-alt text-danger me-2"></i>2. Alamat Tempat Tinggal & Kontak</div>

                <div class="row g-3">
                  <div class="col-md-8">
                    <label for="alamat_jalan" class="form-label fw-semibold">Alamat (Dusun / Jalan)</label>
                    <input type="text" name="alamat_jalan" id="alamat_jalan" class="form-control" value="{{ old('alamat_jalan', $calonSiswa->alamat_jalan) }}" placeholder="Jl. Merpati No. 12, Dusun Harapan">
                  </div>

                  <div class="col-md-2">
                    <label for="rt" class="form-label fw-semibold">RT</label>
                    <input type="text" name="rt" id="rt" maxlength="5" class="form-control" value="{{ old('rt', $calonSiswa->rt) }}" placeholder="001">
                  </div>

                  <div class="col-md-2">
                    <label for="rw" class="form-label fw-semibold">RW</label>
                    <input type="text" name="rw" id="rw" maxlength="5" class="form-control" value="{{ old('rw', $calonSiswa->rw) }}" placeholder="002">
                  </div>

                  <div class="col-md-4">
                    <label for="kelurahan" class="form-label fw-semibold">Kelurahan / Desa</label>
                    <input type="text" name="kelurahan" id="kelurahan" class="form-control" value="{{ old('kelurahan', $calonSiswa->kelurahan) }}" placeholder="Kelurahan">
                  </div>

                  <div class="col-md-4">
                    <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                    <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="{{ old('kecamatan', $calonSiswa->kecamatan) }}" placeholder="Kecamatan">
                  </div>

                  <div class="col-md-4">
                    <label for="kode_pos" class="form-label fw-semibold">Kode Pos</label>
                    <input type="text" name="kode_pos" id="kode_pos" maxlength="10" class="form-control font-monospace" value="{{ old('kode_pos', $calonSiswa->kode_pos) }}" placeholder="Contoh: 17530">
                  </div>

                  <div class="col-md-6">
                    <label for="kabupaten_kota" class="form-label fw-semibold">Kabupaten / Kota</label>
                    <input type="text" name="kabupaten_kota" id="kabupaten_kota" class="form-control" value="{{ old('kabupaten_kota', $calonSiswa->kabupaten_kota) }}" placeholder="Kabupaten / Kota">
                  </div>

                  <div class="col-md-6">
                    <label for="provinsi" class="form-label fw-semibold">Provinsi</label>
                    <input type="text" name="provinsi" id="provinsi" class="form-control" value="{{ old('provinsi', $calonSiswa->provinsi) }}" placeholder="Provinsi">
                  </div>

                  <div class="col-md-4">
                    <label for="jenis_tinggal" class="form-label fw-semibold">Jenis Tinggal</label>
                    <select name="jenis_tinggal" id="jenis_tinggal" class="form-select">
                      <option value="">-- Pilih Jenis Tinggal --</option>
                      @php $jt = old('jenis_tinggal', $calonSiswa->jenis_tinggal); @endphp
                      <option value="Bersama Orangtua" {{ $jt == 'Bersama Orangtua' ? 'selected' : '' }}>Bersama Orangtua</option>
                      <option value="Wali" {{ $jt == 'Wali' ? 'selected' : '' }}>Wali</option>
                      <option value="Kost" {{ $jt == 'Kost' ? 'selected' : '' }}>Kost</option>
                      <option value="Asrama" {{ $jt == 'Asrama' ? 'selected' : '' }}>Asrama</option>
                      <option value="Panti Asuhan" {{ $jt == 'Panti Asuhan' ? 'selected' : '' }}>Panti Asuhan</option>
                      <option value="Lainnya" {{ $jt == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label for="alat_transportasi" class="form-label fw-semibold">Alat Transportasi ke Sekolah</label>
                    <select name="alat_transportasi" id="alat_transportasi" class="form-select">
                      <option value="">-- Pilih Transportasi --</option>
                      @php $at = old('alat_transportasi', $calonSiswa->alat_transportasi); @endphp
                      <option value="Jalan Kaki" {{ $at == 'Jalan Kaki' ? 'selected' : '' }}>Jalan Kaki</option>
                      <option value="Sepeda Motor" {{ $at == 'Sepeda Motor' ? 'selected' : '' }}>Sepeda Motor</option>
                      <option value="Mobil Pribadi" {{ $at == 'Mobil Pribadi' ? 'selected' : '' }}>Mobil Pribadi</option>
                      <option value="Antar Jemput Sekolah" {{ $at == 'Antar Jemput Sekolah' ? 'selected' : '' }}>Antar Jemput Sekolah</option>
                      <option value="Angkutan Umum" {{ $at == 'Angkutan Umum' ? 'selected' : '' }}>Angkutan Umum</option>
                      <option value="Sepeda" {{ $at == 'Sepeda' ? 'selected' : '' }}>Sepeda</option>
                      <option value="Lainnya" {{ $at == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label for="telepon_rumah" class="form-label fw-semibold">No. Telepon Rumah</label>
                    <input type="text" name="telepon_rumah" id="telepon_rumah" class="form-control" value="{{ old('telepon_rumah', $calonSiswa->telepon_rumah) }}" placeholder="021-xxxxxxx">
                  </div>

                  <div class="col-md-4">
                    <label for="no_hp" class="form-label fw-semibold">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', $calonSiswa->no_hp) }}" placeholder="08xxxxxxxxxx">
                  </div>

                  <div class="col-md-4">
                    <label for="email" class="form-label fw-semibold">Email Pribadi</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $calonSiswa->email) }}" placeholder="nama@email.com">
                  </div>

                  <div class="col-md-4">
                    <label for="jarak_ke_sekolah" class="form-label fw-semibold">Jarak Rumah ke Sekolah</label>
                    <select name="jarak_ke_sekolah" id="jarak_ke_sekolah" class="form-select">
                      <option value="">-- Pilih Jarak --</option>
                      @php $js = old('jarak_ke_sekolah', $calonSiswa->jarak_ke_sekolah); @endphp
                      <option value="kurang dari 1 km" {{ $js == 'kurang dari 1 km' ? 'selected' : '' }}>Kurang dari 1 km</option>
                      <option value="lebih dari 1 km" {{ $js == 'lebih dari 1 km' ? 'selected' : '' }}>Lebih dari 1 km</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label for="jarak_ke_sekolah_detail" class="form-label fw-semibold">Jarak Spesifik (Jika > 1 km)</label>
                    <input type="text" name="jarak_ke_sekolah_detail" id="jarak_ke_sekolah_detail" class="form-control" value="{{ old('jarak_ke_sekolah_detail', $calonSiswa->jarak_ke_sekolah_detail) }}" placeholder="Contoh: 3.5 km">
                  </div>

                  <div class="col-md-6">
                    <label for="waktu_tempuh" class="form-label fw-semibold">Waktu Tempuh ke Sekolah</label>
                    <select name="waktu_tempuh" id="waktu_tempuh" class="form-select">
                      <option value="">-- Pilih Waktu Tempuh --</option>
                      @php $wt = old('waktu_tempuh', $calonSiswa->waktu_tempuh); @endphp
                      <option value="kurang dari 30 menit" {{ $wt == 'kurang dari 30 menit' ? 'selected' : '' }}>Kurang dari 30 menit</option>
                      <option value="30 - 60 menit" {{ $wt == '30 - 60 menit' ? 'selected' : '' }}>30 - 60 menit</option>
                      <option value="lebih dari 60 menit" {{ $wt == 'lebih dari 60 menit' ? 'selected' : '' }}>Lebih dari 60 menit</option>
                    </select>
                  </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn btn-secondary prev-tab-btn" data-prev="#tab-identitas-btn">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                  </button>
                  <button type="button" class="btn btn-primary next-tab-btn" data-next="#tab-ortu-btn">
                    Lanjut ke Data Orang Tua & Wali <i class="bi bi-arrow-right ms-1"></i>
                  </button>
                </div>
              </div>

              <!-- ============================================================= -->
              <!-- 3. DATA ORANG TUA KANDUNG & WALI                              -->
              <!-- ============================================================= -->
              <div class="tab-pane fade" id="tab-ortu" role="tabpanel">
                
                <!-- A. DATA AYAH KANDUNG -->
                <div class="card mb-3 border">
                  <div class="card-header bg-primary-subtle text-primary fw-bold">
                    <i class="bi bi-gender-male me-2"></i>2. Data Ayah Kandung
                  </div>
                  <div class="card-body pt-3">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label for="nama_ayah" class="form-label fw-semibold">Nama Lengkap Ayah</label>
                        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control" value="{{ old('nama_ayah', $calonSiswa->nama_ayah) }}" placeholder="Nama ayah kandung">
                      </div>
                      <div class="col-md-3">
                        <label for="tempat_lahir_ayah" class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah" class="form-control" value="{{ old('tempat_lahir_ayah', $calonSiswa->tempat_lahir_ayah) }}">
                      </div>
                      <div class="col-md-3">
                        <label for="tanggal_lahir_ayah" class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" class="form-control" value="{{ old('tanggal_lahir_ayah', optional($calonSiswa->tanggal_lahir_ayah)->format('Y-m-d')) }}">
                      </div>
                      <div class="col-md-3">
                        <label for="pekerjaan_ayah_id" class="form-label fw-semibold">Pekerjaan</label>
                        <select name="pekerjaan_ayah_id" id="pekerjaan_ayah_id" class="form-select">
                          <option value="">-- Pilih Pekerjaan --</option>
                          @foreach($daftarPekerjaan as $pek)
                            <option value="{{ $pek->id_pekerjaan }}" {{ old('pekerjaan_ayah_id', $calonSiswa->pekerjaan_ayah_id) == $pek->id_pekerjaan ? 'selected' : '' }}>{{ $pek->nama_pekerjaan }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="pendidikan_ayah_id" class="form-label fw-semibold">Pendidikan</label>
                        <select name="pendidikan_ayah_id" id="pendidikan_ayah_id" class="form-select">
                          <option value="">-- Pilih Pendidikan --</option>
                          @foreach($daftarPendidikan as $pen)
                            <option value="{{ $pen->id_pendidikan }}" {{ old('pendidikan_ayah_id', $calonSiswa->pendidikan_ayah_id) == $pen->id_pendidikan ? 'selected' : '' }}>{{ $pen->nama_pendidikan }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="agama_ayah_id" class="form-label fw-semibold">Agama</label>
                        <select name="agama_ayah_id" id="agama_ayah_id" class="form-select">
                          <option value="">-- Pilih Agama --</option>
                          @foreach($daftarAgama as $ag)
                            <option value="{{ $ag->id_agama }}" {{ old('agama_ayah_id', $calonSiswa->agama_ayah_id) == $ag->id_agama ? 'selected' : '' }}>{{ $ag->nama_agama }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="penghasilan_ayah_id" class="form-label fw-semibold">Penghasilan Bulanan</label>
                        <select name="penghasilan_ayah_id" id="penghasilan_ayah_id" class="form-select">
                          <option value="">-- Pilih Penghasilan --</option>
                          @foreach($daftarPenghasilan as $peng)
                            <option value="{{ $peng->id_penghasilan }}" {{ old('penghasilan_ayah_id', $calonSiswa->penghasilan_ayah_id) == $peng->id_penghasilan ? 'selected' : '' }}>{{ $peng->label }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- B. DATA IBU KANDUNG -->
                <div class="card mb-3 border">
                  <div class="card-header bg-danger-subtle text-danger fw-bold">
                    <i class="bi bi-gender-female me-2"></i>3. Data Ibu Kandung
                  </div>
                  <div class="card-body pt-3">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label for="nama_ibu" class="form-label fw-semibold">Nama Lengkap Ibu</label>
                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="{{ old('nama_ibu', $calonSiswa->nama_ibu) }}" placeholder="Nama ibu kandung">
                      </div>
                      <div class="col-md-3">
                        <label for="tempat_lahir_ibu" class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu" class="form-control" value="{{ old('tempat_lahir_ibu', $calonSiswa->tempat_lahir_ibu) }}">
                      </div>
                      <div class="col-md-3">
                        <label for="tanggal_lahir_ibu" class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" class="form-control" value="{{ old('tanggal_lahir_ibu', optional($calonSiswa->tanggal_lahir_ibu)->format('Y-m-d')) }}">
                      </div>
                      <div class="col-md-3">
                        <label for="pekerjaan_ibu_id" class="form-label fw-semibold">Pekerjaan</label>
                        <select name="pekerjaan_ibu_id" id="pekerjaan_ibu_id" class="form-select">
                          <option value="">-- Pilih Pekerjaan --</option>
                          @foreach($daftarPekerjaan as $pek)
                            <option value="{{ $pek->id_pekerjaan }}" {{ old('pekerjaan_ibu_id', $calonSiswa->pekerjaan_ibu_id) == $pek->id_pekerjaan ? 'selected' : '' }}>{{ $pek->nama_pekerjaan }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="pendidikan_ibu_id" class="form-label fw-semibold">Pendidikan</label>
                        <select name="pendidikan_ibu_id" id="pendidikan_ibu_id" class="form-select">
                          <option value="">-- Pilih Pendidikan --</option>
                          @foreach($daftarPendidikan as $pen)
                            <option value="{{ $pen->id_pendidikan }}" {{ old('pendidikan_ibu_id', $calonSiswa->pendidikan_ibu_id) == $pen->id_pendidikan ? 'selected' : '' }}>{{ $pen->nama_pendidikan }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="agama_ibu_id" class="form-label fw-semibold">Agama</label>
                        <select name="agama_ibu_id" id="agama_ibu_id" class="form-select">
                          <option value="">-- Pilih Agama --</option>
                          @foreach($daftarAgama as $ag)
                            <option value="{{ $ag->id_agama }}" {{ old('agama_ibu_id', $calonSiswa->agama_ibu_id) == $ag->id_agama ? 'selected' : '' }}>{{ $ag->nama_agama }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="penghasilan_ibu_id" class="form-label fw-semibold">Penghasilan Bulanan</label>
                        <select name="penghasilan_ibu_id" id="penghasilan_ibu_id" class="form-select">
                          <option value="">-- Pilih Penghasilan --</option>
                          @foreach($daftarPenghasilan as $peng)
                            <option value="{{ $peng->id_penghasilan }}" {{ old('penghasilan_ibu_id', $calonSiswa->penghasilan_ibu_id) == $peng->id_penghasilan ? 'selected' : '' }}>{{ $peng->label }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- C. DATA WALI -->
                <div class="card mb-3 border">
                  <div class="card-header bg-secondary-subtle text-dark fw-bold">
                    <i class="bi bi-person-check me-2"></i>4. Data Wali <span class="text-muted fw-normal">(Diisi bila diasuh wali)</span>
                  </div>
                  <div class="card-body pt-3">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label for="nama_wali" class="form-label fw-semibold">Nama Lengkap Wali</label>
                        <input type="text" name="nama_wali" id="nama_wali" class="form-control" value="{{ old('nama_wali', $calonSiswa->nama_wali) }}" placeholder="Nama lengkap wali">
                      </div>
                      <div class="col-md-3">
                        <label for="tempat_lahir_wali" class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_wali" id="tempat_lahir_wali" class="form-control" value="{{ old('tempat_lahir_wali', $calonSiswa->tempat_lahir_wali) }}">
                      </div>
                      <div class="col-md-3">
                        <label for="tanggal_lahir_wali" class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_wali" id="tanggal_lahir_wali" class="form-control" value="{{ old('tanggal_lahir_wali', optional($calonSiswa->tanggal_lahir_wali)->format('Y-m-d')) }}">
                      </div>
                      <div class="col-md-3">
                        <label for="pekerjaan_wali_id" class="form-label fw-semibold">Pekerjaan</label>
                        <select name="pekerjaan_wali_id" id="pekerjaan_wali_id" class="form-select">
                          <option value="">-- Pilih Pekerjaan --</option>
                          @foreach($daftarPekerjaan as $pek)
                            <option value="{{ $pek->id_pekerjaan }}" {{ old('pekerjaan_wali_id', $calonSiswa->pekerjaan_wali_id) == $pek->id_pekerjaan ? 'selected' : '' }}>{{ $pek->nama_pekerjaan }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="pendidikan_wali_id" class="form-label fw-semibold">Pendidikan</label>
                        <select name="pendidikan_wali_id" id="pendidikan_wali_id" class="form-select">
                          <option value="">-- Pilih Pendidikan --</option>
                          @foreach($daftarPendidikan as $pen)
                            <option value="{{ $pen->id_pendidikan }}" {{ old('pendidikan_wali_id', $calonSiswa->pendidikan_wali_id) == $pen->id_pendidikan ? 'selected' : '' }}>{{ $pen->nama_pendidikan }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="agama_wali_id" class="form-label fw-semibold">Agama</label>
                        <select name="agama_wali_id" id="agama_wali_id" class="form-select">
                          <option value="">-- Pilih Agama --</option>
                          @foreach($daftarAgama as $ag)
                            <option value="{{ $ag->id_agama }}" {{ old('agama_wali_id', $calonSiswa->agama_wali_id) == $ag->id_agama ? 'selected' : '' }}>{{ $ag->nama_agama }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="penghasilan_wali_id" class="form-label fw-semibold">Penghasilan Bulanan</label>
                        <select name="penghasilan_wali_id" id="penghasilan_wali_id" class="form-select">
                          <option value="">-- Pilih Penghasilan --</option>
                          @foreach($daftarPenghasilan as $peng)
                            <option value="{{ $peng->id_penghasilan }}" {{ old('penghasilan_wali_id', $calonSiswa->penghasilan_wali_id) == $peng->id_penghasilan ? 'selected' : '' }}>{{ $peng->label }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn btn-secondary prev-tab-btn" data-prev="#tab-alamat-btn">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                  </button>
                  <button type="button" class="btn btn-primary next-tab-btn" data-next="#tab-prestasi-btn">
                    Lanjut ke Catatan Prestasi <i class="bi bi-arrow-right ms-1"></i>
                  </button>
                </div>
              </div>

              <!-- ============================================================= -->
              <!-- 4. CATATAN PRESTASI                                           -->
              <!-- ============================================================= -->
              <div class="tab-pane fade" id="tab-prestasi" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="section-card-title mb-0 border-0 p-0">
                    <i class="bi bi-trophy text-warning me-2"></i>5. Catatan Prestasi
                  </div>
                  <button type="button" class="btn btn-sm btn-outline-success" id="btn-tambah-prestasi">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Baris Prestasi
                  </button>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered dynamic-table align-middle" id="table-prestasi">
                    <thead>
                      <tr>
                        <th style="width: 20%">Jenis Prestasi</th>
                        <th style="width: 20%">Tingkat</th>
                        <th style="width: 25%">Nama Prestasi</th>
                        <th style="width: 12%">Tahun</th>
                        <th style="width: 18%">Penyelenggara</th>
                        <th style="width: 5%" class="text-center">Hapus</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $listPrestasi = old('prestasi', $calonSiswa->prestasi->toArray());
                      @endphp
                      @if(count($listPrestasi) > 0)
                        @foreach($listPrestasi as $index => $item)
                          <tr>
                            <td>
                              <select name="prestasi[{{ $index }}][jenis_prestasi]" class="form-select form-select-sm">
                                @foreach($pilihanJenisPrestasi as $key => $val)
                                  <option value="{{ $key }}" {{ ($item['jenis_prestasi'] ?? '') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                              <select name="prestasi[{{ $index }}][tingkat]" class="form-select form-select-sm">
                                @foreach($pilihanTingkat as $key => $val)
                                  <option value="{{ $key }}" {{ ($item['tingkat'] ?? '') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                              <input type="text" name="prestasi[{{ $index }}][nama_prestasi]" class="form-control form-select-sm" value="{{ $item['nama_prestasi'] ?? '' }}" placeholder="Nama perlombaan / kejuaraan">
                            </td>
                            <td>
                              <input type="text" name="prestasi[{{ $index }}][tahun]" maxlength="4" class="form-control form-select-sm font-monospace text-center" value="{{ $item['tahun'] ?? date('Y') }}">
                            </td>
                            <td>
                              <input type="text" name="prestasi[{{ $index }}][penyelenggara]" class="form-control form-select-sm" value="{{ $item['penyelenggara'] ?? '' }}" placeholder="Instansi penyelenggara">
                            </td>
                            <td class="text-center">
                              <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row"><i class="bi bi-x-lg"></i></button>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <!-- 1 Baris Default -->
                        <tr>
                          <td>
                            <select name="prestasi[0][jenis_prestasi]" class="form-select form-select-sm">
                              @foreach($pilihanJenisPrestasi as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            <select name="prestasi[0][tingkat]" class="form-select form-select-sm">
                              @foreach($pilihanTingkat as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            <input type="text" name="prestasi[0][nama_prestasi]" class="form-control form-select-sm" placeholder="Nama perlombaan / kejuaraan">
                          </td>
                          <td>
                            <input type="text" name="prestasi[0][tahun]" maxlength="4" class="form-control form-select-sm font-monospace text-center" value="{{ date('Y') }}">
                          </td>
                          <td>
                            <input type="text" name="prestasi[0][penyelenggara]" class="form-control form-select-sm" placeholder="Instansi penyelenggara">
                          </td>
                          <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row"><i class="bi bi-x-lg"></i></button>
                          </td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn btn-secondary prev-tab-btn" data-prev="#tab-ortu-btn">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                  </button>
                  <button type="button" class="btn btn-primary next-tab-btn" data-next="#tab-beasiswa-btn">
                    Lanjut ke Riwayat Beasiswa <i class="bi bi-arrow-right ms-1"></i>
                  </button>
                </div>
              </div>

              <!-- ============================================================= -->
              <!-- 5. RIWAYAT BEASISWA                                           -->
              <!-- ============================================================= -->
              <div class="tab-pane fade" id="tab-beasiswa" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="section-card-title mb-0 border-0 p-0">
                    <i class="bi bi-award text-success me-2"></i>6. Riwayat Beasiswa
                  </div>
                  <button type="button" class="btn btn-sm btn-outline-success" id="btn-tambah-beasiswa">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Baris Beasiswa
                  </button>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered dynamic-table align-middle" id="table-beasiswa">
                    <thead>
                      <tr>
                        <th style="width: 35%">Jenis Beasiswa</th>
                        <th style="width: 35%">Penyelenggara / Sumber</th>
                        <th style="width: 12%">Tahun Mulai</th>
                        <th style="width: 13%">Tahun Selesai</th>
                        <th style="width: 5%" class="text-center">Hapus</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $listBeasiswa = old('beasiswa', $calonSiswa->beasiswa->toArray());
                      @endphp
                      @if(count($listBeasiswa) > 0)
                        @foreach($listBeasiswa as $index => $item)
                          <tr>
                            <td>
                              <input type="text" name="beasiswa[{{ $index }}][jenis_beasiswa]" class="form-control form-select-sm" value="{{ $item['jenis_beasiswa'] ?? '' }}" placeholder="Contoh: Beasiswa Prestasi, PIP, dll">
                            </td>
                            <td>
                              <input type="text" name="beasiswa[{{ $index }}][penyelenggara]" class="form-control form-select-sm" value="{{ $item['penyelenggara'] ?? '' }}" placeholder="Penyelenggara beasiswa">
                            </td>
                            <td>
                              <input type="text" name="beasiswa[{{ $index }}][tahun_mulai]" maxlength="4" class="form-control form-select-sm font-monospace text-center" value="{{ $item['tahun_mulai'] ?? date('Y') }}">
                            </td>
                            <td>
                              <input type="text" name="beasiswa[{{ $index }}][tahun_selesai]" maxlength="4" class="form-control form-select-sm font-monospace text-center" value="{{ $item['tahun_selesai'] ?? '' }}" placeholder="Tahun / Kosongkan bila aktif">
                            </td>
                            <td class="text-center">
                              <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row"><i class="bi bi-x-lg"></i></button>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <!-- 1 Baris Default -->
                        <tr>
                          <td>
                            <input type="text" name="beasiswa[0][jenis_beasiswa]" class="form-control form-select-sm" placeholder="Contoh: Beasiswa Prestasi, PIP, dll">
                          </td>
                          <td>
                            <input type="text" name="beasiswa[0][penyelenggara]" class="form-control form-select-sm" placeholder="Penyelenggara beasiswa">
                          </td>
                          <td>
                            <input type="text" name="beasiswa[0][tahun_mulai]" maxlength="4" class="form-control form-select-sm font-monospace text-center" value="{{ date('Y') }}">
                          </td>
                          <td>
                            <input type="text" name="beasiswa[0][tahun_selesai]" maxlength="4" class="form-control form-select-sm font-monospace text-center" placeholder="Tahun / Kosongkan bila aktif">
                          </td>
                          <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row"><i class="bi bi-x-lg"></i></button>
                          </td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                  <button type="button" class="btn btn-secondary prev-tab-btn" data-prev="#tab-prestasi-btn">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                  </button>
                  <div class="d-flex gap-2">
                    <a href="{{ route('calon-siswa.index') }}" class="btn btn-outline-secondary">
                      <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg px-4 shadow">
                      <i class="bi bi-save me-1"></i> Perbarui Pendaftaran Siswa
                    </button>
                  </div>
                </div>
              </div>

            </div><!-- End Tab Contents -->

          </div>
        </div>

      </form>

    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  $(document).ready(function () {
    // Navigasi tombol Next dan Prev antar tab
    $('.next-tab-btn').on('click', function () {
      const target = $(this).data('next');
      $(target).tab('show');
      window.scrollTo({ top: 150, behavior: 'smooth' });
    });

    $('.prev-tab-btn').on('click', function () {
      const target = $(this).data('prev');
      $(target).tab('show');
      window.scrollTo({ top: 150, behavior: 'smooth' });
    });

    // Indeks row prestasi & beasiswa
    let prestasiIdx = {{ count($listPrestasi ?? [1]) + 10 }};
    let beasiswaIdx = {{ count($listBeasiswa ?? [1]) + 10 }};

    // Tambah baris Prestasi
    $('#btn-tambah-prestasi').on('click', function () {
      const row = `
        <tr>
          <td>
            <select name="prestasi[${prestasiIdx}][jenis_prestasi]" class="form-select form-select-sm">
              @foreach($pilihanJenisPrestasi as $key => $val)
                <option value="{{ $key }}">{{ $val }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <select name="prestasi[${prestasiIdx}][tingkat]" class="form-select form-select-sm">
              @foreach($pilihanTingkat as $key => $val)
                <option value="{{ $key }}">{{ $val }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <input type="text" name="prestasi[${prestasiIdx}][nama_prestasi]" class="form-control form-select-sm" placeholder="Nama perlombaan / kejuaraan">
          </td>
          <td>
            <input type="text" name="prestasi[${prestasiIdx}][tahun]" maxlength="4" class="form-control form-select-sm font-monospace text-center" value="{{ date('Y') }}">
          </td>
          <td>
            <input type="text" name="prestasi[${prestasiIdx}][penyelenggara]" class="form-control form-select-sm" placeholder="Instansi penyelenggara">
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row"><i class="bi bi-x-lg"></i></button>
          </td>
        </tr>
      `;
      $('#table-prestasi tbody').append(row);
      prestasiIdx++;
    });

    // Tambah baris Beasiswa
    $('#btn-tambah-beasiswa').on('click', function () {
      const row = `
        <tr>
          <td>
            <input type="text" name="beasiswa[${beasiswaIdx}][jenis_beasiswa]" class="form-control form-select-sm" placeholder="Contoh: Beasiswa Prestasi, PIP, dll">
          </td>
          <td>
            <input type="text" name="beasiswa[${beasiswaIdx}][penyelenggara]" class="form-control form-select-sm" placeholder="Penyelenggara beasiswa">
          </td>
          <td>
            <input type="text" name="beasiswa[${beasiswaIdx}][tahun_mulai]" maxlength="4" class="form-control form-select-sm font-monospace text-center" value="{{ date('Y') }}">
          </td>
          <td>
            <input type="text" name="beasiswa[${beasiswaIdx}][tahun_selesai]" maxlength="4" class="form-control form-select-sm font-monospace text-center" placeholder="Tahun / Kosongkan bila aktif">
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row"><i class="bi bi-x-lg"></i></button>
          </td>
        </tr>
      `;
      $('#table-beasiswa tbody').append(row);
      beasiswaIdx++;
    });

    // Hapus baris dinamis
    $(document).on('click', '.btn-remove-row', function () {
      const tbody = $(this).closest('tbody');
      if (tbody.find('tr').length > 1) {
        $(this).closest('tr').remove();
      } else {
        $(this).closest('tr').find('input').val('');
      }
    });
  });
</script>
@endpush
