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
    #pembayaran-table .btn-sm {
      font-size: 0.78rem;
      padding: 0.28rem 0.65rem;
      border-radius: 6px;
      font-weight: 500;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
      transition: all 0.15s ease-in-out;
    }
    #pembayaran-table .btn-sm:hover {
      transform: translateY(-1px);
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
    .filter-card {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
    }
  </style>
@endpush

@section('content')
<div class="pagetitle">
  <h1>Transaksi & Pembayaran PPDB</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Proses & Seleksi</li>
      <li class="breadcrumb-item active">Pembayaran PPDB</li>
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

      <!-- Filter Panel -->
      <div class="card shadow-sm border-0 mb-3 filter-card">
        <div class="card-body py-3">
          <div class="row g-2 align-items-center">
            <div class="col-md-6">
              <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-calendar-event me-1"></i> Filter Tahun Ajaran</label>
              <select id="filter-tahun" class="form-select form-select-sm">
                <option value="">Semua Tahun Ajaran</option>
                @foreach($tahunAjaranList as $ta)
                  <option value="{{ $ta->id_tahun_ajaran }}">{{ $ta->tahun_ajaran }} {{ $ta->is_active ? '(Aktif)' : '' }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-patch-question me-1"></i> Filter Status Bayar</label>
              <select id="filter-status-bayar" class="form-select form-select-sm">
                <option value="">Semua Status Pembayaran</option>
                <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
                <option value="lunas">Lunas (Terkonfirmasi)</option>
                <option value="ditolak">Ditolak / Belum Masuk</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Main DataTables Card -->
      <div class="card shadow-sm border-0">
        <div class="card-body pt-3">
          <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
              <h5 class="card-title p-0 m-0">Daftar Transaksi Pembayaran Calon Siswa</h5>
              <p class="text-muted small mb-0">Kelola konfirmasi pembayaran formulir, uang pangkal, SPP, dan penerbitan kwitansi resmi.</p>
            </div>
            <a href="{{ route('pembayaran.create') }}" class="btn btn-primary btn-sm">
              <i class="bi bi-cash-stack me-1"></i> Catat Pembayaran Baru
            </a>
          </div>

          <!-- Table with Yajra DataTables -->
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100" id="pembayaran-table">
              <thead>
                <tr>
                  <th style="width: 4%" class="text-center">No</th>
                  <th style="width: 14%">No. Transaksi</th>
                  <th style="width: 20%">Calon Siswa</th>
                  <th style="width: 15%">Tagihan / Biaya</th>
                  <th style="width: 13%">Nominal</th>
                  <th style="width: 13%">Metode</th>
                  <th style="width: 8%" class="text-center">Bukti</th>
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

<!-- Modal Quick Update Status Bayar -->
<div class="modal fade" id="modalStatusBayar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fs-6"><i class="bi bi-patch-check me-2"></i>Konfirmasi Pembayaran</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formStatusBayar">
        @csrf
        <input type="hidden" id="status-bayar-id">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label text-muted small fw-semibold">Kode Transaksi</label>
            <input type="text" id="status-bayar-kode" class="form-control bg-light font-monospace fw-bold" readonly>
          </div>
          <div class="mb-3">
            <label for="status-bayar-select" class="form-label fw-semibold">Status Pembayaran <span class="text-danger">*</span></label>
            <select class="form-select" id="status-bayar-select" required>
              <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
              <option value="lunas">Lunas (Uang Masuk & Sah)</option>
              <option value="ditolak">Ditolak (Transfer Tidak Valid/Salah Nominal)</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="status-bayar-catatan" class="form-label fw-semibold">Catatan Bendahara <small class="text-muted fw-normal">(Opsional)</small></label>
            <textarea class="form-control" id="status-bayar-catatan" rows="3" placeholder="Catatan transaksi atau alasan penolakan..."></textarea>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm" id="btn-save-status-bayar">
            <i class="bi bi-check-lg me-1"></i> Simpan Status
          </button>
        </div>
      </form>
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
      const table = $('#pembayaran-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('pembayaran.index') }}",
          data: function (d) {
            d.id_tahun_ajaran = $('#filter-tahun').val();
            d.status_pembayaran = $('#filter-status-bayar').val();
          }
        },
        columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
          { data: 'transaksi', name: 'kode_transaksi' },
          { data: 'siswa', name: 'calonSiswa.nama_lengkap' },
          { data: 'tagihan', name: 'biaya.nama_biaya' },
          { data: 'nominal', name: 'nominal' },
          { data: 'metode_info', name: 'metode_pembayaran' },
          { data: 'bukti', name: 'bukti', orderable: false, searchable: false, className: 'text-center' },
          { data: 'status_pembayaran', name: 'status_pembayaran', className: 'text-center' },
          { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap' },
        ],
        language: {
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ data",
          zeroRecords: "Tidak ada transaksi pembayaran yang cocok",
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

      $('#filter-tahun, #filter-status-bayar').on('change', function () {
        table.ajax.reload();
      });

      // Quick Status Modal
      $(document).on('click', '.btn-quick-status-bayar', function () {
        const id = $(this).data('id');
        const kode = $(this).data('kode');
        const status = $(this).data('status');
        const catatan = $(this).data('catatan');

        $('#status-bayar-id').val(id);
        $('#status-bayar-kode').val(kode);
        $('#status-bayar-select').val(status);
        $('#status-bayar-catatan').val(catatan);

        $('#modalStatusBayar').modal('show');
      });

      $('#formStatusBayar').on('submit', function (e) {
        e.preventDefault();
        const id = $('#status-bayar-id').val();
        const status = $('#status-bayar-select').val();
        const catatan = $('#status-bayar-catatan').val();
        const btn = $('#btn-save-status-bayar');

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

        $.ajax({
          url: `/pembayaran/${id}/status`,
          type: 'POST',
          data: {
            _method: 'PATCH',
            _token: '{{ csrf_token() }}',
            status_pembayaran: status,
            catatan: catatan
          },
          success: function (res) {
            $('#modalStatusBayar').modal('hide');
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: res.message,
              timer: 1800,
              showConfirmButton: false
            });
            table.ajax.reload(null, false);
          },
          error: function (xhr) {
            const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Gagal memperbarui status.';
            Swal.fire('Gagal!', msg, 'error');
          },
          complete: function () {
            btn.prop('disabled', false).html('<i class="bi bi-check-lg me-1"></i> Simpan Status');
          }
        });
      });

      // SweetAlert2 Delete
      $(document).on('click', '.btn-delete', function () {
        const url = $(this).data('url');
        const name = $(this).data('name');

        Swal.fire({
          title: 'Hapus Transaksi?',
          text: `Apakah Anda yakin ingin menghapus transaksi "${name}"?`,
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
