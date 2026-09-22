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
    #gelombang-table .btn-sm {
      font-size: 0.78rem;
      padding: 0.28rem 0.65rem;
      border-radius: 6px;
      font-weight: 500;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
      transition: all 0.15s ease-in-out;
    }
    #gelombang-table .btn-sm:hover {
      transform: translateY(-1px);
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
  </style>
@endpush

@section('content')
<div class="pagetitle">
  <h1>Master Gelombang Pendaftaran</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pengaturan & Master</li>
      <li class="breadcrumb-item active">Gelombang</li>
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
          
          <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h5 class="card-title p-0 m-0">Daftar Gelombang PPDB</h5>

            <div class="d-flex align-items-center gap-2">
              <!-- Filter Tahun Ajaran -->
              <select id="filter-tahun-ajaran" class="form-select form-select-sm" style="min-width: 180px;">
                <option value="">Semua Tahun Ajaran</option>
                @foreach($tahunAjaranList as $ta)
                  <option value="{{ $ta->id_tahun_ajaran }}">{{ $ta->tahun_ajaran }} {{ $ta->is_active ? '(Aktif)' : '' }}</option>
                @endforeach
              </select>

              <a href="{{ route('gelombang.create') }}" class="btn btn-primary btn-sm text-nowrap">
                <i class="bi bi-plus-lg me-1"></i> Tambah Gelombang
              </a>
            </div>
          </div>

          <!-- Table with Yajra DataTables -->
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100" id="gelombang-table">
              <thead>
                <tr>
                  <th style="width: 5%" class="text-center">No</th>
                  <th>Nama Gelombang</th>
                  <th>Tahun Ajaran</th>
                  <th>Periode Pendaftaran</th>
                  <th style="width: 12%" class="text-center">Kuota</th>
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
      const table = $('#gelombang-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('gelombang.index') }}",
          data: function (d) {
            d.id_tahun_ajaran = $('#filter-tahun-ajaran').val();
          }
        },
        columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
          { data: 'nama_gelombang', name: 'nama_gelombang' },
          { data: 'tahun_ajaran', name: 'tahunAjaran.tahun_ajaran' },
          { data: 'periode', name: 'tanggal_mulai' },
          { data: 'kuota', name: 'kuota', className: 'text-center' },
          { data: 'is_active', name: 'is_active', className: 'text-center' },
          { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap' },
        ],
        language: {
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ data per halaman",
          zeroRecords: "Tidak ada data gelombang yang cocok",
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
      $('#filter-tahun-ajaran').on('change', function () {
        table.ajax.reload();
      });

      // SweetAlert2 Konfirmasi Hapus Gelombang
      $(document).on('click', '.btn-delete', function () {
        const url = $(this).data('url');
        const name = $(this).data('name');

        Swal.fire({
          title: 'Hapus Gelombang?',
          text: `Apakah Anda yakin ingin menghapus gelombang "${name}"?`,
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
