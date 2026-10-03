@extends('layouts.dahsboard.template')

@section('content')
<div class="pagetitle">
  <h1>Banner Homepage PPDB</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Homepage</li>
      <li class="breadcrumb-item active">Banner & Slider</li>
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

      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
          <div>
            <h5 class="card-title p-0 m-0 fw-bold text-dark">Daftar Banner & Slider Hero</h5>
            <small class="text-muted">Kelola gambar slide, teks promosi, dan tombol aksi pada banner utama homepage</small>
          </div>
          <a href="{{ route('homepage-banner.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Banner Baru
          </a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
              <thead class="table-light">
                <tr>
                  <th style="width: 60px;" class="text-center">No</th>
                  <th style="width: 130px;">Preview</th>
                  <th>Judul & Deskripsi</th>
                  <th>Tombol CTA</th>
                  <th style="width: 80px;" class="text-center">Urutan</th>
                  <th style="width: 100px;" class="text-center">Status</th>
                  <th style="width: 120px;" class="text-end pe-3">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($banners as $index => $b)
                  <tr>
                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                    <td>
                      <div class="rounded overflow-hidden border shadow-sm" style="width: 110px; height: 60px;">
                        <img src="{{ $b->gambar_url }}" alt="{{ $b->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                      </div>
                    </td>
                    <td>
                      @if($b->badge_text)
                        <span class="badge bg-warning-subtle text-dark border border-warning-subtle mb-1">{{ $b->badge_text }}</span>
                      @endif
                      <div class="fw-bold text-dark">{{ $b->judul }}</div>
                      <div class="text-muted small">{{ Str::limit($b->subjudul, 90) }}</div>
                    </td>
                    <td>
                      @if($b->tombol_text_1)
                        <div class="small"><i class="bi bi-link-45deg me-1 text-primary"></i><strong>{{ $b->tombol_text_1 }}</strong> &rarr; <code>{{ $b->tombol_link_1 }}</code></div>
                      @endif
                      @if($b->tombol_text_2)
                        <div class="small"><i class="bi bi-link-45deg me-1 text-secondary"></i><strong>{{ $b->tombol_text_2 }}</strong> &rarr; <code>{{ $b->tombol_link_2 }}</code></div>
                      @endif
                    </td>
                    <td class="text-center">
                      <span class="badge bg-light text-dark border font-monospace">{{ $b->urutan }}</span>
                    </td>
                    <td class="text-center">
                      @if($b->is_active)
                        <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                      @else
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Nonaktif</span>
                      @endif
                    </td>
                    <td class="text-end pe-3">
                      <div class="d-inline-flex gap-1">
                        <a href="{{ route('homepage-banner.edit', $b->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Banner">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('homepage-banner.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?');" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Banner">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                      <i class="bi bi-images fs-2 text-secondary d-block mb-2"></i>
                      Belum ada banner homepage yang ditambahkan. Silakan klik tombol <strong>Tambah Banner Baru</strong>.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
