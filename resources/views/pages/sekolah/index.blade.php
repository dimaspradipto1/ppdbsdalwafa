@extends('layouts.dahsboard.template')

@push('styles')
<style>
  .school-logo-container {
    position: relative;
    display: inline-block;
    cursor: pointer;
  }
  .school-logo-preview {
    width: 120px;
    height: 120px;
    object-fit: contain;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    transition: all 0.2s ease;
  }
  .school-logo-container:hover .school-logo-preview {
    transform: scale(1.02);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
  }
  .logo-edit-badge {
    position: absolute;
    bottom: -6px;
    right: -6px;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background-color: #0d6efd;
    color: #ffffff;
    border: 3px solid #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    transition: transform 0.2s;
  }
  .school-logo-container:hover .logo-edit-badge {
    transform: scale(1.1);
    background-color: #0b5ed7;
  }
  .section-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    font-size: 0.85rem;
  }
</style>
@endpush

@section('content')
<div class="pagetitle">
  <h1>Profil & Data Sekolah</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item active">Profil Sekolah</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

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

  <div class="row">
    <!-- Kolom Kiri: Ringkasan Profil Lembaga & Ganti Logo Cepat -->
    <div class="col-lg-4 mb-4">
      <div class="card shadow-sm border-0 text-center p-3 mb-3">
        <div class="card-body p-0">

          <!-- Hidden Input untuk Ganti Logo Cepat -->
          <input type="file" id="quick-logo-input" accept="image/png, image/jpeg, image/jpg, image/webp, image/svg+xml" style="display: none;">

          <!-- Container Foto Logo dengan Tombol Kamera Overlay -->
          <div class="my-3 d-flex justify-content-center">
            <div class="school-logo-container" onclick="document.getElementById('quick-logo-input').click()" title="Klik untuk mengganti logo sekolah">
              <img src="{{ $sekolah->logo_url }}" alt="Logo {{ $sekolah->nama_sekolah }}" id="preview-logo-display" class="school-logo-preview p-2 border">
              <div class="logo-edit-badge">
                <i class="bi bi-camera-fill"></i>
              </div>
            </div>
          </div>

          <!-- Tombol Ganti Logo -->
          <div class="mb-3">
            <button type="button" class="btn btn-sm btn-outline-primary px-3 rounded-pill" onclick="document.getElementById('quick-logo-input').click()">
              <i class="bi bi-upload me-1"></i> Ganti Logo Sekolah
            </button>
            <div class="text-muted small mt-1" style="font-size: 0.76rem;">Klik logo atau tombol di atas untuk upload logo baru</div>
          </div>

          <h5 class="fw-bold text-dark mb-1">{{ $sekolah->nama_sekolah }}</h5>
          <p class="text-muted small mb-2">{{ $sekolah->nama_yayasan ?: 'Yayasan Penyelenggara' }}</p>
          
          <div class="d-flex justify-content-center gap-1 mb-3 flex-wrap">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
              <i class="bi bi-award me-1"></i>Jenjang: {{ $sekolah->jenjang }}
            </span>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
              <i class="bi bi-building-check me-1"></i>{{ $sekolah->status_sekolah }}
            </span>
            @if($sekolah->npsn)
              <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                NPSN: {{ $sekolah->npsn }}
              </span>
            @endif
          </div>

          <hr class="my-3">

          <div class="text-start small">
            <div class="mb-2 d-flex align-items-start gap-2">
              <i class="bi bi-geo-alt text-primary mt-1"></i>
              <div>
                <strong>Alamat:</strong>
                <div class="text-muted">{{ $sekolah->alamat ?: '-' }}</div>
                @if($sekolah->kecamatan || $sekolah->kabupaten_kota)
                  <div class="text-muted">{{ implode(', ', array_filter([$sekolah->desa_kelurahan, $sekolah->kecamatan, $sekolah->kabupaten_kota, $sekolah->provinsi])) }}</div>
                @endif
              </div>
            </div>

            <div class="mb-2 d-flex align-items-center gap-2">
              <i class="bi bi-telephone text-success"></i>
              <div>
                <strong>Telepon/WA:</strong>
                <span class="text-muted ms-1">{{ $sekolah->telepon ?: '-' }}</span>
              </div>
            </div>

            <div class="mb-2 d-flex align-items-center gap-2">
              <i class="bi bi-envelope text-danger"></i>
              <div>
                <strong>Email:</strong>
                <span class="text-muted ms-1">{{ $sekolah->email ?: '-' }}</span>
              </div>
            </div>

            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-globe text-info"></i>
              <div>
                <strong>Website:</strong>
                @if($sekolah->website)
                  <a href="{{ $sekolah->website }}" target="_blank" class="text-decoration-none ms-1">{{ $sekolah->website }}</a>
                @else
                  <span class="text-muted ms-1">-</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="alert alert-info border-0 shadow-xs small mb-0">
        <i class="bi bi-info-circle-fill me-1"></i>
        <strong>Informasi:</strong> Data profil dan logo sekolah ini digunakan pada kop formulir pendaftaran, bukti registrasi, kartu seleksi, dan portal PPDB.
      </div>
    </div>

    <!-- Kolom Kanan: Form Lengkap Edit & Update Sekolah -->
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body pt-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title p-0 m-0">Edit Profil & Informasi Sekolah</h5>
            <span class="badge bg-light text-muted border">ID: #{{ $sekolah->id_sekolah }}</span>
          </div>

          <form action="{{ route('sekolah.update', $sekolah->id_sekolah) }}" method="POST" enctype="multipart/form-data" id="form-sekolah">
            @csrf
            @method('PUT')

            <!-- BAGIAN 1: IDENTITAS SEKOLAH -->
            <div class="card bg-light border-0 p-3 mb-4">
              <div class="d-flex align-items-center mb-3">
                <span class="section-badge bg-primary text-white me-2 fw-bold">1</span>
                <h6 class="fw-bold text-primary mb-0">Identitas Lembaga / Sekolah</h6>
              </div>

              <div class="row g-3">
                <div class="col-md-8">
                  <label for="nama_sekolah" class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                    <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror" value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}" placeholder="Contoh: SD Islam Plus Al-Wafa" required>
                  </div>
                  @error('nama_sekolah')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label for="npsn" class="form-label fw-semibold">NPSN</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                    <input type="text" name="npsn" id="npsn" class="form-control font-monospace @error('npsn') is-invalid @enderror" value="{{ old('npsn', $sekolah->npsn) }}" placeholder="8 digit NPSN">
                  </div>
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
                  <input type="text" name="nama_yayasan" id="nama_yayasan" class="form-control" value="{{ old('nama_yayasan', $sekolah->nama_yayasan) }}" placeholder="Contoh: Yayasan Daarul Aitam Batam">
                </div>
              </div>
            </div>

            <!-- BAGIAN 2: ALAMAT & WILAYAH -->
            <div class="card bg-light border-0 p-3 mb-4">
              <div class="d-flex align-items-center mb-3">
                <span class="section-badge bg-primary text-white me-2 fw-bold">2</span>
                <h6 class="fw-bold text-primary mb-0">Alamat & Lokasi Sekolah</h6>
              </div>

              <div class="row g-3">
                <div class="col-12">
                  <label for="alamat" class="form-label fw-semibold">Alamat Lengkap (Jalan, RT/RW, Blok)</label>
                  <textarea name="alamat" id="alamat" rows="2" class="form-control" placeholder="Contoh: Perumahan Bida Asri 2 Blok G2 No. 10-15">{{ old('alamat', $sekolah->alamat) }}</textarea>
                </div>

                <div class="col-md-4">
                  <label for="desa_kelurahan" class="form-label fw-semibold">Kelurahan / Desa</label>
                  <input type="text" name="desa_kelurahan" id="desa_kelurahan" class="form-control" value="{{ old('desa_kelurahan', $sekolah->desa_kelurahan) }}" placeholder="Contoh: Belian">
                </div>

                <div class="col-md-4">
                  <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                  <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="{{ old('kecamatan', $sekolah->kecamatan) }}" placeholder="Contoh: Batam Kota">
                </div>

                <div class="col-md-4">
                  <label for="kabupaten_kota" class="form-label fw-semibold">Kabupaten / Kota</label>
                  <input type="text" name="kabupaten_kota" id="kabupaten_kota" class="form-control" value="{{ old('kabupaten_kota', $sekolah->kabupaten_kota) }}" placeholder="Contoh: Kota Batam">
                </div>

                <div class="col-md-6">
                  <label for="provinsi" class="form-label fw-semibold">Provinsi</label>
                  <input type="text" name="provinsi" id="provinsi" class="form-control" value="{{ old('provinsi', $sekolah->provinsi) }}" placeholder="Contoh: Kepulauan Riau">
                </div>

                <div class="col-md-6">
                  <label for="kode_pos" class="form-label fw-semibold">Kode Pos</label>
                  <input type="text" name="kode_pos" id="kode_pos" class="form-control" value="{{ old('kode_pos', $sekolah->kode_pos) }}" placeholder="Contoh: 29464">
                </div>
              </div>
            </div>

            <!-- BAGIAN 3: KONTAK, MEDIA, LOGO & GPS -->
            <div class="card bg-light border-0 p-3 mb-4">
              <div class="d-flex align-items-center mb-3">
                <span class="section-badge bg-primary text-white me-2 fw-bold">3</span>
                <h6 class="fw-bold text-primary mb-0">Kontak, Media & Logo</h6>
              </div>

              <div class="row g-3">
                <div class="col-md-4">
                  <label for="telepon" class="form-label fw-semibold">No. Telepon / WA</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                    <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $sekolah->telepon) }}" placeholder="Contoh: 082323222606">
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="email" class="form-label fw-semibold">Alamat Email</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $sekolah->email) }}" placeholder="sekolah@gmail.com">
                  </div>
                  @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label for="website" class="form-label fw-semibold">Website Resmi</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                    <input type="url" name="website" id="website" class="form-control" value="{{ old('website', $sekolah->website) }}" placeholder="https://...">
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="form-logo-input" class="form-label fw-semibold">Upload / Ganti Logo Sekolah</label>
                  <div class="input-group">
                    <input type="file" name="logo" id="form-logo-input" class="form-control @error('logo') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg, image/webp, image/svg+xml">
                  </div>
                  <div class="form-text">Format: PNG, JPG, JPEG, WEBP, SVG. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah logo.</div>
                  @error('logo')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-3">
                  <label for="latitude" class="form-label fw-semibold">Latitude GPS</label>
                  <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $sekolah->latitude) }}" placeholder="Contoh: 1.1186">
                </div>

                <div class="col-md-3">
                  <label for="longitude" class="form-label fw-semibold">Longitude GPS</label>
                  <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $sekolah->longitude) }}" placeholder="Contoh: 104.0531">
                </div>
              </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="d-flex justify-content-end gap-2 pt-2">
              <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan Sekolah
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
    // 1. Preview saat input file pada form kanan dipilih
    $('#form-logo-input').on('change', function () {
      if (this.files && this.files[0]) {
        const file = this.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
          $('#preview-logo-display').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
      }
    });

    // 2. Handler saat klik tombol / avatar "Ganti Logo Sekolah" di kartu sebelah kiri
    $('#quick-logo-input').on('change', function () {
      const file = this.files[0];
      if (!file) return;

      // Validasi ukuran file (maksimal 2MB)
      if (file.size > 2 * 1024 * 1024) {
        Swal.fire('Ukuran Terlalu Besar', 'Ukuran file logo maksimal adalah 2MB.', 'error');
        this.value = '';
        return;
      }

      // Preview langsung pada layar
      const reader = new FileReader();
      reader.onload = function (e) {
        $('#preview-logo-display').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);

      // Konfirmasi ganti logo via AJAX langsung
      Swal.fire({
        title: 'Perbarui Logo Sekolah?',
        html: `Apakah Anda ingin langsung menerapkan dan menyimpan file <strong>${file.name}</strong> sebagai logo sekolah?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-upload me-1"></i> Ya, Simpan Logo',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          const formData = new FormData();
          formData.append('logo', file);
          formData.append('_token', '{{ csrf_token() }}');

          Swal.fire({
            title: 'Mengunggah Logo...',
            text: 'Sedang memproses penyimpanan file logo baru',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          $.ajax({
            url: "{{ route('sekolah.update-logo') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              if (response.success) {
                $('#preview-logo-display').attr('src', response.logo_url);
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil!',
                  text: response.message,
                  timer: 2500,
                  showConfirmButton: false
                });
              } else {
                Swal.fire('Gagal!', response.message, 'error');
              }
            },
            error: function (xhr) {
              const msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan saat mengunggah logo.';
              Swal.fire('Gagal!', msg, 'error');
            }
          });
        } else {
          $('#quick-logo-input').val('');
        }
      });
    });
  });
</script>
@endpush
