@extends('layouts.dahsboard.template')

@push('styles')
  <!-- DataTables CSS Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 0 !important;
    }
    table.dataTable tbody td {
      vertical-align: middle;
    }
    .requirement-box {
      border-left: 4px solid #0d6efd;
      background: #f8faff;
      border-radius: 8px;
    }
    .badge-status-lg {
      font-size: 0.85rem;
      padding: 0.45rem 0.85rem;
      border-radius: 8px;
    }
    .doc-card-item {
      transition: all 0.2s ease-in-out;
      border-radius: 8px;
    }
    .doc-card-item:hover {
      background-color: #f8faff;
    }
  </style>
@endpush

@section('content')
<div class="pagetitle">
  <h1>Dokumen Persyaratan Calon Siswa</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pendaftaran</li>
      <li class="breadcrumb-item active">Verifikasi Dokumen</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <!-- Ringkasan Statistik Berkas Siswa -->
  <div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
      <div class="card shadow-sm border-0 border-start border-primary border-4 h-100 mb-0">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="text-muted small fw-semibold text-uppercase">Total Calon Siswa</span>
              <h4 class="fw-bold text-dark mb-0 mt-1">{{ $stats['totalSiswa'] ?? 0 }}</h4>
            </div>
            <div class="bg-primary-subtle text-primary rounded-circle p-3">
              <i class="bi bi-people-fill fs-4"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card shadow-sm border-0 border-start border-warning border-4 h-100 mb-0">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="text-muted small fw-semibold text-uppercase">Menunggu Verifikasi</span>
              <h4 class="fw-bold text-warning mb-0 mt-1">{{ $stats['siswaMenunggu'] ?? 0 }}</h4>
            </div>
            <div class="bg-warning-subtle text-warning rounded-circle p-3">
              <i class="bi bi-hourglass-split fs-4"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card shadow-sm border-0 border-start border-success border-4 h-100 mb-0">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="text-muted small fw-semibold text-uppercase">Semua Berkas Valid</span>
              <h4 class="fw-bold text-success mb-0 mt-1">{{ $stats['siswaValid'] ?? 0 }}</h4>
            </div>
            <div class="bg-success-subtle text-success rounded-circle p-3">
              <i class="bi bi-check2-all fs-4"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card shadow-sm border-0 border-start border-danger border-4 h-100 mb-0">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="text-muted small fw-semibold text-uppercase">Ada Berkas Ditolak</span>
              <h4 class="fw-bold text-danger mb-0 mt-1">{{ $stats['siswaDitolak'] ?? 0 }}</h4>
            </div>
            <div class="bg-danger-subtle text-danger rounded-circle p-3">
              <i class="bi bi-exclamation-triangle-fill fs-4"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle me-1"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-octagon me-1"></i>
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <!-- Info Ketentuan Persyaratan Berkas Dokumen -->
      <div class="card shadow-sm border-0 mb-4 requirement-box">
        <div class="card-body p-3 p-md-4">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center">
              <i class="bi bi-info-circle-fill text-primary fs-4 me-2"></i>
              <h5 class="fw-bold text-primary mb-0">Ketentuan Berkas Dokumen Persyaratan PPDB</h5>
            </div>
            <button class="btn btn-sm btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKetentuan" aria-expanded="false" aria-controls="collapseKetentuan">
              <i class="bi bi-chevron-down me-1"></i> Detail Ketentuan
            </button>
          </div>

          <div class="collapse show" id="collapseKetentuan">
            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <div class="p-3 bg-white rounded border border-success-subtle h-100">
                  <span class="badge bg-success mb-2"><i class="bi bi-person-plus me-1"></i>Bagi Siswa Baru</span>
                  <ul class="mb-0 ps-3 small text-dark">
                    <li><strong>Akta Kelahiran & Kartu Keluarga (KK)</strong>: Unggah scan / foto dokumen yang jelas</li>
                    <li><strong>KTP Orang Tua</strong>: Unggah scan / foto e-KTP Ayah dan Ibu (atau Wali)</li>
                    <li><strong>Pas Foto Berwarna 3 x 4</strong>: File foto formal berseragam putih latar belakang merah</li>
                    <li><strong>Kehadiran Siswa</strong>: Menghadirkan calon siswa ke sekolah saat observasi</li>
                  </ul>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 bg-white rounded border border-info-subtle h-100">
                  <span class="badge bg-info text-dark mb-2"><i class="bi bi-arrow-left-right me-1"></i>Bagi Siswa Pindahan</span>
                  <ul class="mb-0 ps-3 small text-dark">
                    <li><strong>Surat Pindah</strong> dari sekolah asal (File scan surat resmi bermaterai / legalisir)</li>
                    <li><strong>Buku Rapor</strong> lengkap dari sekolah asal (File scan rapor semester terakhir)</li>
                    <li><strong>Akta Kelahiran, KK, &amp; KTP Orang Tua</strong></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Card Data Dokumen Siswa (Grouped by Student) -->
      <div class="card shadow-sm border-0">
        <div class="card-body pt-3">
          
          <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
              <h5 class="card-title p-0 m-0">Daftar Verifikasi Dokumen per Calon Siswa</h5>
              <p class="text-muted small mb-0">Data dokumen dikelompokkan per calon siswa agar panitia dapat memverifikasi berkas secara menyeluruh.</p>
            </div>
            <div class="d-flex gap-2">
              <a href="{{ route('dokumen.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Unggah Dokumen Baru
              </a>
            </div>
          </div>

          <!-- Filter Section -->
          <div class="row g-2 mb-3 bg-light p-3 rounded-3 border">
            @if(!$isPendaftar)
              <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Filter Kategori Siswa</label>
                <select id="filter-kategori" class="form-select form-select-sm">
                  <option value="">Semua Kategori</option>
                  <option value="siswa_baru">Siswa Baru</option>
                  <option value="siswa_pindahan">Siswa Pindahan</option>
                </select>
              </div>
              <div class="col-md-5">
                <label class="form-label small fw-semibold text-muted mb-1">Filter Status Verifikasi Berkas</label>
                <select id="filter-status" class="form-select form-select-sm">
                  <option value="">Semua Status Berkas</option>
                  <option value="menunggu">Menunggu Verifikasi (Ada berkas perlu diperiksa)</option>
                  <option value="valid">Lengkap &amp; Valid (Semua berkas diterima)</option>
                  <option value="ditolak">Perlu Perbaikan (Ada berkas ditolak)</option>
                  <option value="belum_unggah">Belum Ada Berkas yang Diunggah</option>
                </select>
              </div>
              <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-secondary btn-sm w-100" id="btn-reset-filter">
                  <i class="bi bi-arrow-clockwise me-1"></i> Reset Filter
                </button>
              </div>
            @else
              <input type="hidden" id="filter-kategori" value="">
              <div class="col-md-8">
                <label class="form-label small fw-semibold text-muted mb-1">Filter Status Verifikasi</label>
                <select id="filter-status" class="form-select form-select-sm">
                  <option value="">Semua Status Berkas</option>
                  <option value="menunggu">Menunggu Verifikasi</option>
                  <option value="valid">Lengkap &amp; Valid</option>
                  <option value="ditolak">Perlu Perbaikan (Ditolak)</option>
                </select>
              </div>
              <div class="col-md-4 d-flex align-items-end">
                <button type="button" class="btn btn-secondary btn-sm w-100" id="btn-reset-filter">
                  <i class="bi bi-arrow-clockwise me-1"></i> Reset Filter
                </button>
              </div>
            @endif
          </div>

          <!-- Table with Yajra DataTables Grouped by Calon Siswa -->
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100" id="dokumen-table">
              <thead>
                <tr>
                  <th style="width: 4%" class="text-center">No</th>
                  <th style="width: 30%">Calon Siswa</th>
                  <th style="width: 18%">Kategori &amp; Gelombang</th>
                  <th style="width: 24%">Kelengkapan Berkas</th>
                  <th style="width: 12%" class="text-center">Status Berkas</th>
                  <th style="width: 12%" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<!-- ============================================================== -->
<!-- MODAL DETAIL & VERIFIKASI BERKAS PER CALON SISWA -->
<!-- ============================================================== -->
<div class="modal fade" id="modalDetailBerkas" tabindex="-1" aria-labelledby="modalDetailBerkasLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-light py-3 border-bottom">
        <div>
          <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="modalDetailBerkasLabel">
            <i class="bi bi-folder-check text-primary"></i>
            <span id="detail-nama-siswa">Detail Berkas Dokumen</span>
          </h5>
          <div class="small text-muted mt-1" id="detail-sub-siswa">
            <!-- Diisi via JS: No Pendaftaran, Kategori, Jalur -->
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-3 p-md-4">
        <!-- Loading State -->
        <div id="detail-loading" class="text-center py-5">
          <div class="spinner-border text-primary" role="status"></div>
          <p class="text-muted small mt-2 mb-0">Memuat berkas calon siswa...</p>
        </div>

        <!-- Detail Content -->
        <div id="detail-content" style="display: none;">
          
          <!-- Quick Action Bar -->
          <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 p-2 bg-light rounded border">
            <div class="d-flex align-items-center gap-2">
              <span class="fw-bold small text-dark"><i class="bi bi-collection me-1 text-primary"></i>Daftar Berkas Terunggah:</span>
              <span id="detail-badge-count" class="badge bg-primary">0 Berkas</span>
            </div>
            <div id="detail-action-header" class="d-flex gap-2">
              <!-- Tombol Verifikasi Semua Hanya Muncul untuk Verifikator/Admin -->
              <button type="button" class="btn btn-sm btn-success fw-semibold shadow-sm btn-verify-all" data-status="valid">
                <i class="bi bi-check2-all me-1"></i> Setujui Semua Berkas Valid
              </button>
            </div>
          </div>

          <!-- Alert Dokumen Wajib Yang Belum Diunggah -->
          <div id="alert-missing-docs" class="alert alert-warning border-warning d-flex align-items-start gap-2 mb-3" style="display: none;">
            <i class="bi bi-exclamation-triangle-fill fs-5 mt-1"></i>
            <div>
              <strong class="d-block mb-1">Dokumen Wajib yang Belum Diunggah:</strong>
              <ul class="mb-0 ps-3 small" id="list-missing-docs"></ul>
            </div>
          </div>

          <!-- Tabel Dokumen Terunggah -->
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width: 4%" class="text-center">No</th>
                  <th style="width: 28%">Jenis Dokumen Persyaratan</th>
                  <th style="width: 25%">File Berkas</th>
                  <th style="width: 15%" class="text-center">Status Verifikasi</th>
                  <th style="width: 16%">Catatan Panitia</th>
                  <th style="width: 12%" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody id="detail-table-body">
                <!-- Diisi via JS -->
              </tbody>
            </table>
          </div>

        </div>
      </div>

      <div class="modal-footer bg-light py-2 border-top d-flex justify-content-between">
        <span class="text-muted small">Klik tombol <strong>Verifikasi</strong> untuk mengubah status berkas atau beri catatan perbaikan.</span>
        <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- MODAL UBAH STATUS VERIFIKASI DOKUMEN -->
<!-- ============================================================== -->
<div class="modal fade" id="modalQuickVerifikasi" tabindex="-1" aria-labelledby="modalQuickVerifikasiLabel" aria-hidden="true" style="z-index: 1060;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-warning-subtle py-3 border-bottom">
        <h5 class="modal-title fw-bold text-dark" id="modalQuickVerifikasiLabel">
          <i class="bi bi-pencil-square text-warning me-2"></i>Ubah Status Verifikasi Berkas
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="formQuickVerifikasi">
        <input type="hidden" id="verifikasi-doc-id">
        
        <div class="modal-body p-3 p-md-4">
          <div class="mb-3 p-2 bg-light rounded border">
            <div class="small text-muted">Nama Dokumen:</div>
            <div class="fw-bold text-dark" id="verifikasi-doc-name">-</div>
            <div class="small text-secondary mt-1">Calon Siswa: <strong id="verifikasi-student-name" class="text-dark">-</strong></div>
          </div>

          <!-- Radio Pilihan Status -->
          <div class="mb-3">
            <label class="form-label fw-semibold text-dark">Pilih Status Verifikasi <span class="text-danger">*</span></label>
            <div class="d-flex flex-column gap-2">
              
              <label class="p-2 border rounded d-flex align-items-center gap-2 cursor-pointer bg-white" for="status-valid">
                <input class="form-check-input mt-0" type="radio" name="status_verifikasi" id="status-valid" value="valid" required>
                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Valid / Diterima</span>
                <span class="small text-muted ms-auto">Berkas lengkap &amp; sesuai</span>
              </label>

              <label class="p-2 border rounded d-flex align-items-center gap-2 cursor-pointer bg-white" for="status-menunggu">
                <input class="form-check-input mt-0" type="radio" name="status_verifikasi" id="status-menunggu" value="menunggu">
                <span class="badge bg-warning text-dark border border-warning"><i class="bi bi-hourglass-split me-1"></i>Menunggu Verifikasi</span>
                <span class="small text-muted ms-auto">Perlu ditinjau ulang</span>
              </label>

              <label class="p-2 border rounded d-flex align-items-center gap-2 cursor-pointer bg-white" for="status-ditolak">
                <input class="form-check-input mt-0" type="radio" name="status_verifikasi" id="status-ditolak" value="ditolak">
                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak / Perlu Perbaikan</span>
                <span class="small text-muted ms-auto">Berkas buram/salah</span>
              </label>

            </div>
          </div>

          <!-- Catatan Verifikasi -->
          <div class="mb-2">
            <label for="verifikasi-catatan" class="form-label fw-semibold text-dark">Catatan Verifikasi Panitia (Opsional)</label>
            <textarea class="form-control" id="verifikasi-catatan" rows="3" placeholder="Contoh: File scan KTP kurang jelas/buram, mohon unggah ulang foto asli yang terang dan jelas."></textarea>
            <div class="form-text small">Catatan ini akan langsung terlihat oleh pendaftar pada dashboard akun mereka.</div>
          </div>
        </div>

        <div class="modal-footer bg-light py-2 border-top">
          <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3" id="btn-submit-verifikasi">
            <i class="bi bi-check-lg me-1"></i> Simpan Status
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- MODAL PREVIEW BERKAS (IMAGE / PDF) -->
<!-- ============================================================== -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true" style="z-index: 1070;">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="previewModalLabel">
          <i class="bi bi-file-earmark-text me-2"></i>Preview Berkas
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-0" id="previewModalBody" style="min-height: 400px; background-color: #f8f9fa;">
        <!-- Konten file akan dimuat secara dinamis via JS -->
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <a href="#" id="btn-download-file" class="btn btn-outline-primary btn-sm" target="_blank" download>
          <i class="bi bi-download me-1"></i> Unduh Berkas
        </a>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function () {
      let currentSiswaId = null;

      // Inisialisasi DataTable Calon Siswa
      const table = $('#dokumen-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('dokumen.index') }}",
          data: function (d) {
            d.kategori = $('#filter-kategori').val();
            d.status_verifikasi = $('#filter-status').val();
          }
        },
        columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
          { data: 'calon_siswa', name: 'nama_lengkap' },
          { data: 'kategori', name: 'jalur.nama_jalur', orderable: false },
          { data: 'kelengkapan', name: 'kelengkapan', orderable: false, searchable: false },
          { data: 'status_verifikasi', name: 'status_verifikasi', className: 'text-center', orderable: false, searchable: false },
          { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap' },
        ],
        language: {
          search: "Cari Calon Siswa:",
          lengthMenu: "Tampilkan _MENU_ data per halaman",
          zeroRecords: "Tidak ada data calon siswa yang cocok",
          info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ calon siswa",
          infoEmpty: "Menampilkan 0 s/d 0 dari 0 calon siswa",
          infoFiltered: "(disaring dari total _MAX_ calon siswa)",
          paginate: {
            first: "Pertama",
            last: "Terakhir",
            next: "Selanjutnya",
            previous: "Sebelumnya"
          },
          processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Memuat data...'
        }
      });

      // Filter change
      $('#filter-kategori, #filter-status').on('change', function () {
        table.ajax.reload();
      });

      $('#btn-reset-filter').on('click', function () {
        $('#filter-kategori').val('');
        $('#filter-status').val('');
        table.ajax.reload();
      });

      // Buka Modal Detail Berkas Calon Siswa
      $(document).on('click', '.btn-detail-dokumen', function () {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        currentSiswaId = id;

        $('#modalDetailBerkasLabel #detail-nama-siswa').text('Berkas Dokumen - ' + nama);
        $('#detail-loading').show();
        $('#detail-content').hide();
        
        const modal = new bootstrap.Modal(document.getElementById('modalDetailBerkas'));
        modal.show();

        loadSiswaDokumen(id);
      });

      // Fungsi memuat data dokumen milik 1 calon siswa
      function loadSiswaDokumen(siswaId) {
        $.ajax({
          url: "{{ url('dokumen/siswa') }}/" + siswaId,
          type: 'GET',
          dataType: 'json',
          success: function (res) {
            $('#detail-loading').hide();
            $('#detail-content').show();

            if (!res.success) {
              Swal.fire('Error', res.message || 'Gagal memuat data.', 'error');
              return;
            }

            const siswa = res.siswa;
            const docs = res.dokumen;
            const missing = res.missing_docs || [];
            const canVerify = res.can_verify;

            // Sub Header
            $('#detail-sub-siswa').html(
              `<span class="badge bg-light text-dark border me-1 font-monospace">No: ${siswa.no_pendaftaran}</span>` +
              `<span class="badge bg-secondary-subtle text-secondary border me-1">${siswa.kategori_label}</span>` +
              `<span class="text-secondary">${siswa.jalur} &bull; ${siswa.gelombang} (${siswa.tahun_ajaran})</span>`
            );

            $('#detail-badge-count').text(docs.length + ' Berkas Terunggah');

            // Kontrol tombol aksi header
            if (canVerify && docs.length > 0) {
              $('#detail-action-header').show();
            } else {
              $('#detail-action-header').hide();
            }

            // Missing mandatory docs alert
            if (missing.length > 0) {
              let missingHtml = '';
              missing.forEach(function (m) {
                missingHtml += `<li><strong>${m.nama_dokumen}</strong> (${m.kategori === 'siswa_pindahan' ? 'Syarat Pindahan' : 'Syarat Siswa Baru'})</li>`;
              });
              $('#list-missing-docs').html(missingHtml);
              $('#alert-missing-docs').show();
            } else {
              $('#alert-missing-docs').hide();
            }

            // Render baris dokumen
            let tbodyHtml = '';
            if (docs.length === 0) {
              tbodyHtml = `<tr>
                <td colspan="6" class="text-center py-4 text-muted">
                  <i class="bi bi-cloud-slash fs-1 d-block mb-2 text-secondary"></i>
                  <h6>Belum Ada Berkas yang Diunggah</h6>
                  <p class="small mb-0">Calon siswa ini belum mengunggah berkas persyaratan apapun.</p>
                </td>
              </tr>`;
            } else {
              docs.forEach(function (doc, idx) {
                let statusBadge = '';
                if (doc.status_verifikasi === 'valid') {
                  statusBadge = '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Valid / Diterima</span>';
                } else if (doc.status_verifikasi === 'ditolak') {
                  statusBadge = '<span class="badge bg-danger text-white px-2 py-1"><i class="bi bi-x-circle me-1"></i>Ditolak</span>';
                } else {
                  statusBadge = '<span class="badge bg-warning text-dark border border-warning px-2 py-1 fw-bold"><i class="bi bi-hourglass-split me-1 text-dark"></i>Menunggu</span>';
                }

                const fileIcon = doc.tipe_file === 'pdf' 
                  ? '<i class="bi bi-file-earmark-pdf text-danger fs-4 me-2"></i>' 
                  : '<i class="bi bi-file-earmark-image text-primary fs-4 me-2"></i>';

                let actionBtns = `<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">
                  <button type="button" class="btn btn-sm btn-info text-white btn-preview shadow-sm d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" data-url="${doc.file_url}" data-type="${doc.tipe_file}" data-name="${doc.nama_file}">
                    <i class="bi bi-eye"></i>
                  </button>`;

                if (canVerify) {
                  actionBtns += `<button type="button" class="btn btn-sm btn-warning text-dark btn-open-verify shadow-sm d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" 
                    data-id="${doc.id_dokumen}" 
                    data-name="${doc.nama_dokumen}" 
                    data-filename="${doc.nama_file}" 
                    data-status="${doc.status_verifikasi}" 
                    data-catatan="${doc.catatan_verifikasi || ''}" 
                    data-student="${siswa.nama_lengkap}">
                    <i class="bi bi-pencil-square"></i>
                  </button>`;

                  actionBtns += `<button type="button" class="btn btn-sm btn-danger btn-delete-doc shadow-sm d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" data-url="${doc.delete_url}" data-name="${doc.nama_dokumen}">
                    <i class="bi bi-trash3"></i>
                  </button>`;
                }
                actionBtns += '</div>';

                const catatanText = doc.catatan_verifikasi 
                  ? `<div class="small text-danger fst-italic"><i class="bi bi-chat-left-dots me-1"></i>${doc.catatan_verifikasi}</div>` 
                  : '<span class="text-muted small">-</span>';

                const verifiedInfo = doc.verified_by_name !== '-' 
                  ? `<div class="text-muted" style="font-size: 0.72rem;">Oleh: ${doc.verified_by_name} (${doc.verified_at || ''})</div>` 
                  : '';

                tbodyHtml += `<tr class="doc-card-item">
                  <td class="text-center fw-semibold">${idx + 1}</td>
                  <td>
                    <div class="fw-bold text-dark">${doc.nama_dokumen}</div>
                    <div class="text-muted small fst-italic">${doc.keterangan_syarat || ''}</div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      ${fileIcon}
                      <div>
                        <a href="javascript:void(0)" class="fw-semibold text-decoration-none btn-preview" data-url="${doc.file_url}" data-type="${doc.tipe_file}" data-name="${doc.nama_file}">
                          ${doc.nama_file}
                        </a>
                        <div class="text-muted small">${doc.tipe_file.toUpperCase()} &bull; ${doc.ukuran_file} KB</div>
                      </div>
                    </div>
                  </td>
                  <td class="text-center">
                    ${statusBadge}
                    ${verifiedInfo}
                  </td>
                  <td>${catatanText}</td>
                  <td class="text-center">${actionBtns}</td>
                </tr>`;
              });
            }

            $('#detail-table-body').html(tbodyHtml);
          },
          error: function () {
            $('#detail-loading').hide();
            Swal.fire('Gagal', 'Terjadi kesalahan saat mengambil dokumen.', 'error');
          }
        });
      }

      // Klik tombol Verifikasi pada suatu dokumen -> Buka Modal Ubah Status
      $(document).on('click', '.btn-open-verify', function () {
        const id = $(this).data('id');
        const docName = $(this).data('name');
        const fileName = $(this).data('filename');
        const status = $(this).data('status');
        const catatan = $(this).data('catatan');
        const student = $(this).data('student');

        $('#verifikasi-doc-id').val(id);
        $('#verifikasi-doc-name').text(docName + ' (' + fileName + ')');
        $('#verifikasi-student-name').text(student);
        $('#verifikasi-catatan').val(catatan);

        $(`input[name="status_verifikasi"][value="${status}"]`).prop('checked', true);

        const modalVerif = new bootstrap.Modal(document.getElementById('modalQuickVerifikasi'));
        modalVerif.show();
      });

      // Submit Form Ubah Status Verifikasi
      $('#formQuickVerifikasi').on('submit', function (e) {
        e.preventDefault();
        const docId = $('#verifikasi-doc-id').val();
        const status = $('input[name="status_verifikasi"]:checked').val();
        const catatan = $('#verifikasi-catatan').val();

        $('#btn-submit-verifikasi').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

        $.ajax({
          url: "{{ url('dokumen') }}/" + docId + "/quick-verifikasi",
          type: 'POST',
          data: {
            _method: 'PATCH',
            _token: '{{ csrf_token() }}',
            status_verifikasi: status,
            catatan_verifikasi: catatan
          },
          success: function (res) {
            $('#btn-submit-verifikasi').prop('disabled', false).html('<i class="bi bi-check-lg me-1"></i> Simpan Status');
            
            if (res.success) {
              const modalVerif = bootstrap.Modal.getInstance(document.getElementById('modalQuickVerifikasi'));
              if (modalVerif) modalVerif.hide();

              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: res.message,
                timer: 1800,
                showConfirmButton: false
              });

              // Refresh modal detail dan datatable
              if (currentSiswaId) {
                loadSiswaDokumen(currentSiswaId);
              }
              table.ajax.reload(null, false);
            } else {
              Swal.fire('Gagal!', res.message || 'Terjadi kesalahan.', 'error');
            }
          },
          error: function (xhr) {
            $('#btn-submit-verifikasi').prop('disabled', false).html('<i class="bi bi-check-lg me-1"></i> Simpan Status');
            const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
            Swal.fire('Gagal!', msg, 'error');
          }
        });
      });

      // Verifikasi Semua Dokumen Siswa Sekaligus
      $('.btn-verify-all').on('click', function () {
        if (!currentSiswaId) return;

        Swal.fire({
          title: 'Setujui Semua Dokumen?',
          text: 'Seluruh berkas dokumen yang telah diunggah siswa ini akan ditandai sebagai VALID.',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#198754',
          cancelButtonColor: '#6c757d',
          confirmButtonText: '<i class="bi bi-check2-all"></i> Ya, Setujui Semua',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ url('dokumen/siswa') }}/" + currentSiswaId + "/verifikasi-semua",
              type: 'POST',
              data: {
                _method: 'PATCH',
                _token: '{{ csrf_token() }}',
                status: 'valid'
              },
              success: function (res) {
                if (res.success) {
                  Swal.fire('Berhasil!', res.message, 'success');
                  loadSiswaDokumen(currentSiswaId);
                  table.ajax.reload(null, false);
                } else {
                  Swal.fire('Gagal!', res.message, 'error');
                }
              },
              error: function () {
                Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
              }
            });
          }
        });
      });

      // Modal Preview Dokumen (Gambar / PDF)
      $(document).on('click', '.btn-preview', function () {
        const url = $(this).data('url');
        const type = ($(this).data('type') || '').toLowerCase();
        const name = $(this).data('name');

        $('#previewModalLabel').text('Preview: ' + name);
        $('#btn-download-file').attr('href', url);

        let previewHtml = '';
        if (['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(type)) {
          previewHtml = `<div class="p-3"><img src="${url}" class="img-fluid rounded shadow-sm" style="max-height: 520px; object-fit: contain;" alt="${name}"></div>`;
        } else if (type === 'pdf') {
          previewHtml = `<iframe src="${url}#toolbar=1" width="100%" height="520px" frameborder="0"></iframe>`;
        } else {
          previewHtml = `<div class="p-5 text-center text-muted">
                          <i class="bi bi-file-earmark-arrow-down fs-1 d-block mb-3 text-secondary"></i>
                          <h5>Format file tidak dapat ditampilkan langsung</h5>
                          <p class="small">Silakan unduh file untuk melihat isi dokumen.</p>
                          <a href="${url}" class="btn btn-primary btn-sm mt-2" download target="_blank">Unduh ${name}</a>
                         </div>`;
        }

        $('#previewModalBody').html(previewHtml);
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
      });

      // SweetAlert2 Konfirmasi Hapus Dokumen
      $(document).on('click', '.btn-delete-doc', function () {
        const url = $(this).data('url');
        const name = $(this).data('name');

        Swal.fire({
          title: 'Hapus Berkas Dokumen?',
          text: `Apakah Anda yakin ingin menghapus berkas "${name}"?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: '<i class="bi bi-trash"></i> Ya, Hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: url,
              type: 'POST',
              data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}'
              },
              success: function (response) {
                if (response.success) {
                  Swal.fire('Berhasil!', response.message, 'success');
                  if (currentSiswaId) {
                    loadSiswaDokumen(currentSiswaId);
                  }
                  table.ajax.reload(null, false);
                } else {
                  Swal.fire('Gagal!', response.message, 'error');
                }
              },
              error: function (xhr) {
                const message = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
                Swal.fire('Gagal!', message, 'error');
              }
            });
          }
        });
      });
    });
  </script>
@endpush
