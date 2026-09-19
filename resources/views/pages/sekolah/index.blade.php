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
    #sekolah-table .btn-sm {
      font-size: 0.78rem;
      padding: 0.28rem 0.6rem;
      border-radius: 6px;
      font-weight: 500;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
      transition: all 0.15s ease-in-out;
    }
    #sekolah-table .btn-sm:hover {
      transform: translateY(-1px);
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
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
      <li class="breadcrumb-item active">Sekolah</li>
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

      <div class="card">
        <div class="card-body pt-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title p-0 m-0">Daftar Lembaga / Sekolah</h5>
            @if(Auth::user()->hasRole('super_admin'))
              <a href="{{ route('sekolah.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Sekolah
              </a>
            @endif
          </div>

          <!-- Table with Yajra DataTables -->
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100" id="sekolah-table">
              <thead>
                <tr>
                  <th style="width: 5%">No</th>
                  <th style="width: 8%" class="text-center">Logo</th>
                  <th>Nama Sekolah</th>
                  <th>NPSN</th>
                  <th>Jenjang & Status</th>
                  <th>Kontak</th>
                  <th>Wilayah</th>
                  <th style="width: 15%" class="text-center">Aksi</th>
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

<!-- Modal Detail Sekolah -->
<div class="modal fade" id="modalDetailSekolah" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold" id="modalDetailLabel">
          <i class="bi bi-building me-2 text-primary"></i>Detail Informasi Sekolah
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center mb-3 pb-3 border-bottom">
          <div class="col-auto text-center">
            <img id="detailLogo" src="" alt="Logo Sekolah" class="rounded border p-2 bg-white" style="width: 80px; height: 80px; object-fit: contain;">
          </div>
          <div class="col">
            <h4 class="fw-bold mb-1" id="detailNamaSekolah">-</h4>
            <p class="text-muted mb-1" id="detailYayasan">-</p>
            <span class="badge bg-primary me-1" id="detailJenjang">-</span>
            <span class="badge bg-success me-1" id="detailStatus">-</span>
            <span class="badge bg-secondary font-monospace" id="detailNpsn">NPSN: -</span>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <h6 class="fw-semibold text-muted small text-uppercase mb-2"><i class="bi bi-geo-alt me-1"></i> Lokasi & Alamat</h6>
            <table class="table table-sm table-borderless small mb-0">
              <tr>
                <td class="text-muted" style="width: 35%">Alamat</td>
                <td id="detailAlamat">-</td>
              </tr>
              <tr>
                <td class="text-muted">Kelurahan/Desa</td>
                <td id="detailDesa">-</td>
              </tr>
              <tr>
                <td class="text-muted">Kecamatan</td>
                <td id="detailKecamatan">-</td>
              </tr>
              <tr>
                <td class="text-muted">Kabupaten/Kota</td>
                <td id="detailKabupaten">-</td>
              </tr>
              <tr>
                <td class="text-muted">Provinsi</td>
                <td id="detailProvinsi">-</td>
              </tr>
              <tr>
                <td class="text-muted">Kode Pos</td>
                <td id="detailKodePos">-</td>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            <h6 class="fw-semibold text-muted small text-uppercase mb-2"><i class="bi bi-telephone me-1"></i> Kontak & Media</h6>
            <table class="table table-sm table-borderless small mb-0">
              <tr>
                <td class="text-muted" style="width: 35%">Telepon / HP</td>
                <td id="detailTelepon">-</td>
              </tr>
              <tr>
                <td class="text-muted">Email</td>
                <td id="detailEmail">-</td>
              </tr>
              <tr>
                <td class="text-muted">Website</td>
                <td id="detailWebsite">-</td>
              </tr>
              <tr>
                <td class="text-muted">Koordinat GPS</td>
                <td id="detailKoordinat">-</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
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
      const table = $('#sekolah-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('sekolah.index') }}",
        columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
          { data: 'logo', name: 'logo', orderable: false, searchable: false, className: 'text-center' },
          { data: 'nama_sekolah', name: 'nama_sekolah' },
          { data: 'npsn', name: 'npsn' },
          { data: 'jenjang_status', name: 'jenjang_status', orderable: false },
          { data: 'kontak', name: 'kontak', orderable: false },
          { data: 'lokasi', name: 'lokasi', orderable: false },
          { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap' },
        ],
        language: {
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ data per halaman",
          zeroRecords: "Tidak ada data sekolah yang cocok",
          info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ sekolah",
          infoEmpty: "Menampilkan 0 s/d 0 dari 0 sekolah",
          infoFiltered: "(disaring dari total _MAX_ sekolah)",
          paginate: {
            first: "Pertama",
            last: "Terakhir",
            next: "Selanjutnya",
            previous: "Sebelumnya"
          },
          processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Memuat data...'
        }
      });

      // Modal Detail Sekolah
      $(document).on('click', '.btn-detail', function () {
        const row = $(this).data('sekolah');
        const defaultLogo = "{{ asset('assets/img/cropped-lodo-sdip-alwafa.webp') }}";
        const logoUrl = row.logo_path ? `{{ url('') }}/${row.logo_path}` : defaultLogo;

        $('#detailLogo').attr('src', logoUrl);
        $('#detailNamaSekolah').text(row.nama_sekolah || '-');
        $('#detailYayasan').text(row.nama_yayasan ? `Naungan: ${row.nama_yayasan}` : '');
        $('#detailJenjang').text(row.jenjang || '-');
        $('#detailStatus').text(row.status_sekolah || '-');
        $('#detailNpsn').text(`NPSN: ${row.npsn || '-'}`);

        $('#detailAlamat').text(row.alamat || '-');
        $('#detailDesa').text(row.desa_kelurahan || '-');
        $('#detailKecamatan').text(row.kecamatan || '-');
        $('#detailKabupaten').text(row.kabupaten_kota || '-');
        $('#detailProvinsi').text(row.provinsi || '-');
        $('#detailKodePos').text(row.kode_pos || '-');

        $('#detailTelepon').text(row.telepon || '-');
        $('#detailEmail').html(row.email ? `<a href="mailto:${row.email}">${row.email}</a>` : '-');
        $('#detailWebsite').html(row.website ? `<a href="${row.website}" target="_blank">${row.website}</a>` : '-');
        
        const coords = (row.latitude && row.longitude) ? `${row.latitude}, ${row.longitude}` : '-';
        $('#detailKoordinat').text(coords);

        const modal = new bootstrap.Modal(document.getElementById('modalDetailSekolah'));
        modal.show();
      });

      // SweetAlert2 Konfirmasi Hapus Sekolah
      $(document).on('click', '.btn-delete', function () {
        const url = $(this).data('url');
        const name = $(this).data('name');

        Swal.fire({
          title: 'Hapus Sekolah?',
          text: `Apakah Anda yakin ingin menghapus data sekolah "${name}"?`,
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
