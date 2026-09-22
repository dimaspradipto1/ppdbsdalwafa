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
    #seleksi-table .btn-sm {
      font-size: 0.78rem;
      padding: 0.28rem 0.65rem;
      border-radius: 6px;
      font-weight: 500;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
      transition: all 0.15s ease-in-out;
    }
    #seleksi-table .btn-sm:hover {
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
  <h1>Penilaian & Ujian Seleksi Calon Siswa</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Proses & Seleksi</li>
      <li class="breadcrumb-item active">Penilaian Seleksi</li>
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
              <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-calendar-event me-1"></i> Tahun Ajaran</label>
              <select id="filter-tahun" class="form-select form-select-sm">
                <option value="">Semua Tahun Ajaran</option>
                @foreach($tahunAjaranList as $ta)
                  <option value="{{ $ta->id_tahun_ajaran }}">{{ $ta->tahun_ajaran }} {{ $ta->is_active ? '(Aktif)' : '' }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-layers me-1"></i> Gelombang Pendaftaran</label>
              <select id="filter-gelombang" class="form-select form-select-sm">
                <option value="">Semua Gelombang</option>
                @foreach($gelombangList as $gel)
                  <option value="{{ $gel->id_gelombang }}">{{ $gel->nama_gelombang }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Main DataTables Card -->
      <div class="card shadow-sm border-0">
        <div class="card-body pt-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="card-title p-0 m-0">Rekapitulasi Nilai Observasi & Ujian Seleksi</h5>
              <p class="text-muted small mb-0">Input skor penilaian kesiapan belajar, tes Al-Qur'an/Iqro, dan wawancara calon siswa.</p>
            </div>
            <a href="{{ route('komponen-seleksi.index') }}" class="btn btn-outline-primary btn-sm">
              <i class="bi bi-gear me-1"></i> Atur Bobot Komponen
            </a>
          </div>

          <!-- Table with Yajra DataTables -->
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100" id="seleksi-table">
              <thead>
                <tr>
                  <th style="width: 4%" class="text-center">No</th>
                  <th style="width: 25%">Calon Siswa & Asal TK</th>
                  <th style="width: 16%">Program</th>
                  <th style="width: 30%">Rincian Skor Per Komponen</th>
                  <th style="width: 13%">Skor Akhir</th>
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
@endsection

@push('scripts')
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function () {
      const table = $('#seleksi-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('nilai-seleksi.index') }}",
          data: function (d) {
            d.id_tahun_ajaran = $('#filter-tahun').val();
            d.id_gelombang = $('#filter-gelombang').val();
          }
        },
        columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
          { data: 'siswa', name: 'nama_lengkap' },
          { data: 'program', name: 'gelombang.nama_gelombang' },
          { data: 'rincian_nilai', name: 'rincian_nilai', orderable: false, searchable: false },
          { data: 'total_skor', name: 'total_skor', orderable: false, searchable: false },
          { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap' },
        ],
        language: {
          search: "Cari Siswa:",
          lengthMenu: "Tampilkan _MENU_ data",
          zeroRecords: "Tidak ada data seleksi calon siswa yang cocok",
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

      $('#filter-tahun, #filter-gelombang').on('change', function () {
        table.ajax.reload();
      });
    });
  </script>
@endpush
