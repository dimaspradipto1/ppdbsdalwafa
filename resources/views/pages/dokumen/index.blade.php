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
    #dokumen-table .btn-sm {
      font-size: 0.78rem;
      padding: 0.28rem 0.65rem;
      border-radius: 6px;
      font-weight: 500;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
      transition: all 0.15s ease-in-out;
    }
    #dokumen-table .btn-sm:hover {
      transform: translateY(-1px);
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
    .requirement-box {
      border-left: 4px solid #0d6efd;
      background: #f8faff;
      border-radius: 8px;
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
      <li class="breadcrumb-item active">Dokumen</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
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
          <div class="d-flex align-items-center mb-2">
            <i class="bi bi-info-circle-fill text-primary fs-4 me-2"></i>
            <h5 class="fw-bold text-primary mb-0">Ketentuan Berkas Dokumen Persyaratan PPDB</h5>
          </div>
          <div class="row g-3 mt-1">
            <div class="col-md-6">
              <div class="p-3 bg-white rounded border border-success-subtle h-100">
                <span class="badge bg-success mb-2"><i class="bi bi-person-plus me-1"></i>Bagi Siswa Baru</span>
                <ul class="mb-0 ps-3 small text-dark">
                  <li><strong>Fotocopy Akta Lahir & Kartu Keluarga (KK)</strong>: 3 lembar</li>
                  <li><strong>Fotocopy KTP Orang Tua</strong>: 1 lembar masing-masing</li>
                  <li><strong>Pas Foto berwarna 3 x 4</strong>: 3 lembar (Seragam Putih SD latar belakang merah)</li>
                  <li><strong>Membawa Siswa</strong> ke sekolah pada saat verifikasi fisik</li>
                </ul>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 bg-white rounded border border-info-subtle h-100">
                <span class="badge bg-info text-dark mb-2"><i class="bi bi-arrow-left-right me-1"></i>Bagi Siswa Pindahan</span>
                <ul class="mb-0 ps-3 small text-dark">
                  <li><strong>Surat Pindah</strong> dari sekolah asal (Asli & Fotocopy Legalisir)</li>
                  <li><strong>Buku Rapor</strong> lengkap dari sekolah asal</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Card Data Dokumen -->
      <div class="card shadow-sm border-0">
        <div class="card-body pt-3">
          
          <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
              <h5 class="card-title p-0 m-0">Daftar Dokumen Calon Siswa</h5>
              <p class="text-muted small mb-0">Kelola dan verifikasi berkas persyaratan yang diunggah oleh pendaftar.</p>
            </div>
            <div class="d-flex gap-2">
              <a href="{{ route('dokumen.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Unggah Dokumen Baru
              </a>
            </div>
          </div>

          <!-- Filter Section -->
          <div class="row g-2 mb-3 bg-light p-3 rounded-3 border">
            <div class="col-md-4">
              <label class="form-label small fw-semibold text-muted mb-1">Filter Kategori Siswa</label>
              <select id="filter-kategori" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                <option value="siswa_baru">Siswa Baru</option>
                <option value="siswa_pindahan">Siswa Pindahan</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold text-muted mb-1">Filter Status Verifikasi</label>
              <select id="filter-status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="menunggu">Menunggu Verifikasi</option>
                <option value="valid">Valid / Diterima</option>
                <option value="ditolak">Ditolak</option>
              </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
              <button type="button" class="btn btn-secondary btn-sm w-100" id="btn-reset-filter">
                <i class="bi bi-arrow-clockwise me-1"></i> Reset Filter
              </button>
            </div>
          </div>

          <!-- Table with Yajra DataTables -->
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100" id="dokumen-table">
              <thead>
                <tr>
                  <th style="width: 4%" class="text-center">No</th>
                  <th style="width: 25%">Calon Siswa</th>
                  <th style="width: 28%">Jenis Dokumen & Ketentuan</th>
                  <th style="width: 20%">File Berkas</th>
                  <th style="width: 11%" class="text-center">Status</th>
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

<!-- Modal Preview Berkas -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
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
          { data: 'calon_siswa', name: 'calonSiswa.nama_lengkap' },
          { data: 'jenis_dokumen', name: 'jenisDokumen.nama_dokumen' },
          { data: 'berkas', name: 'nama_file', orderable: false },
          { data: 'status_verifikasi', name: 'status_verifikasi', className: 'text-center' },
          { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap' },
        ],
        language: {
          search: "Cari Dokumen:",
          lengthMenu: "Tampilkan _MENU_ data per halaman",
          zeroRecords: "Tidak ada data berkas dokumen yang cocok",
          info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
          infoEmpty: "Menampilkan 0 s/d 0 dari 0 data",
          infoFiltered: "(disaring dari total _MAX_ data)",
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
      $(document).on('click', '.btn-delete', function () {
        const url = $(this).data('url');
        const name = $(this).data('name');

        Swal.fire({
          title: 'Hapus Berkas Dokumen?',
          text: `Apakah Anda yakin ingin menghapus dokumen "${name}"? File fisik pada server juga akan dihapus.`,
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
