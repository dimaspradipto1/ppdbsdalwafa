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
    #calon-siswa-table .btn-sm {
      font-size: 0.78rem;
      padding: 0.28rem 0.65rem;
      border-radius: 6px;
      font-weight: 500;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
      transition: all 0.15s ease-in-out;
    }
    #calon-siswa-table .btn-sm:hover {
      transform: translateY(-1px);
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
  </style>
@endpush

@section('content')
<div class="pagetitle">
  <h1>Data Calon Siswa</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pendaftaran</li>
      <li class="breadcrumb-item active">Calon Siswa</li>
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

      <div class="card shadow-sm border-0">
        <div class="card-body pt-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="card-title p-0 m-0">Daftar Calon Peserta Didik Baru</h5>
              <p class="text-muted small mb-0">Kelola biodata siswa, catatan prestasi, riwayat beasiswa, dan data orang tua/wali.</p>
            </div>
            <a href="{{ route('calon-siswa.create') }}" class="btn btn-primary btn-sm">
              <i class="bi bi-person-plus-fill me-1"></i> Tambah Calon Siswa
            </a>
          </div>

          <!-- Table with Yajra DataTables -->
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100" id="calon-siswa-table">
              <thead>
                <tr>
                  <th style="width: 4%" class="text-center">No</th>
                  <th style="width: 26%">Nama Siswa & Asal TK</th>
                  <th style="width: 17%">NIK & NISN</th>
                  <th style="width: 15%">Tempat & Tgl Lahir</th>
                  <th style="width: 14%">Prestasi / Beasiswa</th>
                  <th style="width: 10%" class="text-center">Status</th>
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
      const table = $('#calon-siswa-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('calon-siswa.index') }}",
        columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
          { data: 'nama_lengkap', name: 'nama_lengkap' },
          { data: 'nik_nisn', name: 'nik' },
          { data: 'ttl', name: 'tempat_lahir' },
          { data: 'prestasi_beasiswa', name: 'prestasi_beasiswa', orderable: false, searchable: false },
          { data: 'status', name: 'status', className: 'text-center' },
          { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap' },
        ],
        language: {
          search: "Cari Siswa:",
          lengthMenu: "Tampilkan _MENU_ data per halaman",
          zeroRecords: "Tidak ada data calon siswa yang cocok",
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

      // SweetAlert2 Konfirmasi Hapus Calon Siswa
      $(document).on('click', '.btn-delete', function () {
        const url = $(this).data('url');
        const name = $(this).data('name');

        Swal.fire({
          title: 'Hapus Data Calon Siswa?',
          text: `Apakah Anda yakin ingin menghapus data calon siswa "${name}"? Semua data prestasi dan beasiswa terkait juga akan dihapus.`,
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
