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
    .filter-card {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
    }
  </style>
@endpush

@section('content')
<div class="pagetitle">
  <h1>Data Pendaftaran Calon Siswa</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Pendaftaran</li>
      <li class="breadcrumb-item active">Data Pendaftaran</li>
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

      <!-- Filter Panel -->
      <div class="card shadow-sm border-0 mb-3 filter-card">
        <div class="card-body py-3">
          <div class="row g-2 align-items-center">
            <div class="col-md-3">
              <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-calendar-event me-1"></i> Tahun Ajaran</label>
              <select id="filter-tahun" class="form-select form-select-sm">
                <option value="">Semua Tahun Ajaran</option>
                @foreach($tahunAjaranList as $ta)
                  <option value="{{ $ta->id_tahun_ajaran }}">{{ $ta->tahun_ajaran }} {{ $ta->is_active ? '(Aktif)' : '' }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-layers me-1"></i> Gelombang</label>
              <select id="filter-gelombang" class="form-select form-select-sm">
                <option value="">Semua Gelombang</option>
                @foreach($gelombangList as $gel)
                  <option value="{{ $gel->id_gelombang }}">{{ $gel->nama_gelombang }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-signpost-2 me-1"></i> Jalur</label>
              <select id="filter-jalur" class="form-select form-select-sm">
                <option value="">Semua Jalur</option>
                @foreach($jalurList as $j)
                  <option value="{{ $j->id_jalur }}">{{ $j->nama_jalur }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-patch-question me-1"></i> Status</label>
              <select id="filter-status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="draft">Draft</option>
                <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                <option value="diverifikasi">Diverifikasi</option>
                <option value="diterima">Diterima</option>
                <option value="ditolak">Ditolak</option>
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
              <h5 class="card-title p-0 m-0">Daftar Pendaftar Calon Peserta Didik Baru</h5>
              <p class="text-muted small mb-0">Kelola identitas, orang tua/wali, berkas persyaratan, dan verifikasi kelulusan siswa.</p>
            </div>
            <div class="d-flex gap-2">
              <a href="{{ route('dokumen.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-file-earmark-check me-1"></i> Verifikasi Berkas
              </a>
              <a href="{{ route('calon-siswa.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Pendaftar
              </a>
            </div>
          </div>

          <!-- Table with Yajra DataTables -->
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100" id="calon-siswa-table">
              <thead>
                <tr>
                  <th style="width: 4%" class="text-center">No</th>
                  <th style="width: 14%">No. Registrasi</th>
                  <th style="width: 25%">Calon Siswa</th>
                  <th style="width: 17%">Jalur & Gelombang</th>
                  <th style="width: 12%" class="text-center">Berkas</th>
                  <th style="width: 14%" class="text-center">Status</th>
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

<!-- Modal Quick Update Status -->
<div class="modal fade" id="modalQuickStatus" tabindex="-1" aria-labelledby="modalQuickStatusLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fs-6" id="modalQuickStatusLabel"><i class="bi bi-patch-check me-2"></i>Ubah Status Pendaftaran</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formQuickStatus">
        @csrf
        <input type="hidden" id="status-siswa-id">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label text-muted small fw-semibold">Nama Calon Siswa</label>
            <input type="text" id="status-siswa-nama" class="form-control bg-light fw-bold" readonly>
          </div>
          <div class="mb-3">
            <label for="status-select" class="form-label fw-semibold">Status Pendaftaran <span class="text-danger">*</span></label>
            <select class="form-select" id="status-select" required>
              <option value="draft">Draft</option>
              <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
              <option value="diverifikasi">Diverifikasi (Berkas Lengkap & Sah)</option>
              <option value="diterima">Diterima (Lulus Seleksi)</option>
              <option value="ditolak">Ditolak (Tidak Memenuhi Syarat)</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="status-catatan" class="form-label fw-semibold">Catatan Verifikasi / Alasan <small class="text-muted fw-normal">(Opsional)</small></label>
            <textarea class="form-control" id="status-catatan" rows="3" placeholder="Tuliskan catatan verifikasi atau alasan bila berkas belum sesuai..."></textarea>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm" id="btn-save-status">
            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan Status
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
      const table = $('#calon-siswa-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('calon-siswa.index') }}",
          data: function (d) {
            d.id_tahun_ajaran = $('#filter-tahun').val();
            d.id_gelombang = $('#filter-gelombang').val();
            d.id_jalur = $('#filter-jalur').val();
            d.status = $('#filter-status').val();
          }
        },
        columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
          { data: 'no_pendaftaran', name: 'no_pendaftaran' },
          { data: 'nama_lengkap', name: 'nama_lengkap' },
          { data: 'jalur_gelombang', name: 'jalur.nama_jalur', orderable: false },
          { data: 'berkas', name: 'berkas', orderable: false, searchable: false, className: 'text-center' },
          { data: 'status', name: 'status', className: 'text-center' },
          { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap' },
        ],
        language: {
          search: "Cari Siswa:",
          lengthMenu: "Tampilkan _MENU_ data",
          zeroRecords: "Tidak ada data pendaftaran yang cocok",
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

      // Filter change events
      $('#filter-tahun, #filter-gelombang, #filter-jalur, #filter-status').on('change', function () {
        table.ajax.reload();
      });

      // Quick Status Modal
      $(document).on('click', '.btn-quick-status', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const status = $(this).data('status');
        const catatan = $(this).data('catatan');

        $('#status-siswa-id').val(id);
        $('#status-siswa-nama').val(name);
        $('#status-select').val(status);
        $('#status-catatan').val(catatan);

        $('#modalQuickStatus').modal('show');
      });

      $('#formQuickStatus').on('submit', function (e) {
        e.preventDefault();
        const id = $('#status-siswa-id').val();
        const status = $('#status-select').val();
        const catatan = $('#status-catatan').val();
        const btn = $('#btn-save-status');

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

        $.ajax({
          url: `/calon-siswa/${id}/status`,
          type: 'POST',
          data: {
            _method: 'PATCH',
            _token: '{{ csrf_token() }}',
            status: status,
            catatan_verifikasi: catatan
          },
          success: function (res) {
            $('#modalQuickStatus').modal('hide');
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
            btn.prop('disabled', false).html('<i class="bi bi-check-lg me-1"></i> Simpan Perubahan Status');
          }
        });
      });

      // SweetAlert2 Delete
      $(document).on('click', '.btn-delete', function () {
        const url = $(this).data('url');
        const name = $(this).data('name');

        Swal.fire({
          title: 'Hapus Data Pendaftaran?',
          text: `Apakah Anda yakin ingin menghapus "${name}"? Seluruh berkas dokumen dan rekam data siswa akan ikut terhapus.`,
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
