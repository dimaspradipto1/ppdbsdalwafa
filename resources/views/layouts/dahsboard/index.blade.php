@extends('layouts.dahsboard.template')

@section('content')
  <div class="pagetitle">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h1 class="mb-1">Dashboard</h1>
        <nav>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">
              {{ $user->role ? ucwords(str_replace('_', ' ', $user->role)) : 'Dashboard' }}
            </li>
          </ol>
        </nav>
      </div>
      <div class="d-none d-md-block text-end">
        <span class="badge bg-light text-dark border px-3 py-2">
          <i class="bi bi-calendar3 me-1 text-primary"></i>
          {{ now()->translatedFormat('l, d F Y') }}
        </span>
      </div>
    </div>
  </div><!-- End Page Title -->

  <section class="section dashboard mt-3">
    @if(in_array($role, ['super_admin', 'admin_ppdb']))
      {{-- Admin & Super Admin: Tampilan Full gabungan seluruh role --}}
      @include('layouts.dahsboard.roles.admin')
    @elseif($role === 'verifikator')
      {{-- Verifikator: Fokus Berkas Dokumen & Verifikasi Calon Siswa --}}
      @include('layouts.dahsboard.roles.verifikator')
    @elseif($role === 'bendahara')
      {{-- Bendahara: Fokus Keuangan, Tarif Biaya & Konfirmasi Transaksi --}}
      @include('layouts.dahsboard.roles.bendahara')
    @elseif($role === 'kepala_sekolah')
      {{-- Kepala Sekolah: Fokus Monitoring Eksekutif, Daya Tampung & Kelulusan --}}
      @include('layouts.dahsboard.roles.kepala_sekolah')
    @elseif($role === 'guru')
      {{-- Guru / Penguji: Fokus Penilaian Seleksi & Observasi --}}
      @include('layouts.dahsboard.roles.guru')
    @elseif($role === 'pendaftar')
      {{-- Pendaftar / Orang Tua: Fokus Alur PPDB, Formulir, Berkas & Status Bayar --}}
      @include('layouts.dahsboard.roles.pendaftar')
    @else
      {{-- Default Fallback --}}
      @include('layouts.dahsboard.roles.admin')
    @endif
  </section>
@endsection
