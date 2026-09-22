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
    #pengumuman-table .btn-sm {
      font-size: 0.78rem;
      padding: 0.28rem 0.65rem;
      border-radius: 6px;
      font-weight: 500;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
      transition: all 0.15s ease-in-out;
    }
    #pengumuman-table .btn-sm:hover {
      transform: translateY(-1px);
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
    .stat-card {
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      transition: all 0.2s;
    }
  </style>
@endpush

@section('content')
<div class="pagetitle">
  <h1>Pengumuman & Kelulusan PPDB</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Proses & Seleksi</li>
      <li class="breadcrumb-item active">Pengumuman Kelulusan</li>
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

      <!-- Summary Statistics Row -->
      <div class="row g-3 mb-4">
        <div class="col-md-3">
          <div class="card stat-card shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <span class="text-muted small fw-semibold">Total Calon Siswa</span>
                <h3 class="fw-bold mb-0 text-dark">{{ $totalPendaftar }}</h3>
              </div>
              <div class="bg-primary-subtle text-primary rounded-circle p-3">
                <i class="bi bi-people fs-4"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <span class="text-muted small fw-semibold">Siswa Diterima</span>
                <h3 class="fw-bold mb-0 text-success">{{ $totalDiterima }}</h3>
              </div>
              <div class="bg-success-subtle text-success rounded-circle p-3">
                <i class="bi bi-check-circle fs-4"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <span class="text-muted small fw-semibold">Diverifikasi / Proses</span>
                <h3 class="fw-bold mb-0 text-info">{{ $totalDiverifikasi }}</h3>
              </div>
              <div class="bg-info-subtle text-info rounded-circle p-3">
                <i class="bi bi-hourglass-split fs-4"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <span class="text-muted small fw-semibold">Tidak Diterima</span>
                <h3 class="fw-bold mb-0 text-danger">{{ $totalDitolak }}</h3>
              </div>
              <div class="bg-danger-subtle text-danger rounded-circle p-3">
                <i class="bi bi-x-circle fs-4"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main DataTables Card -->
      <div class="card shadow-sm border-0">
        <div class="card-body pt-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="card-title p-0 m-0">Daftar Pengumuman Hasil Seleksi Penerimaan</h5>
              <p class="text-muted small mb-0">Publikasikan SK kelulusan dan rilis hasil penetapan penerimaan peserta didik baru.</p>
            </div>
            <a href="{{ route('pengumuman.create') }}" class="btn btn-primary btn-sm">
              <i class="bi bi-plus-lg me-1"></i> Buat Pengumuman Baru
            </a>
          </div>

          <!-- Table with Yajra DataTables -->
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100" id="pengumuman-table">
              <thead>
                <tr>
                  <th style="width: 4%" class="text-center">No</th>
                  <th style="width: 45%">Judul Pengumuman & Nomor Surat</th>
                  <th style="width: 22%">Target Gelombang / TA</th>
                  <th style="width: 15%" class="text-center">Status Publikasi</th>
                  <th style="width: 14%" class="text-center">Aksi</th>
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
@endsection

@push('scripts')
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function () {
      const table = $('#pengumuman-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('pengumuman.index') }}",
        columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
          { data: 'info_pengumuman', name: 'judul' },
          { data: 'target', name: 'gelombang.nama_gelombang' },
          { data: 'is_published', name: 'is_published', className: 'text-center' },
          { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap' },
        ],
        language: {
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ data",
          zeroRecords: "Belum ada pengumuman hasil seleksi",
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

      // SweetAlert2 Delete
      $(document).on('click', '.btn-delete', function () {
        const url = $(this).data('url');
        const name = $(this).data('name');

        Swal.fire({
          title: 'Hapus Pengumuman?',
          text: `Apakah Anda yakin ingin menghapus pengumuman "${name}"?`,
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
