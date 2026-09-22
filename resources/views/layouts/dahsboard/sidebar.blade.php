  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <!-- Menu Dashboard (Semua Role) -->
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      @php
        $user = Auth::user();
      @endphp

      @if($user)

        {{-- ========================================================================= --}}
        {{-- 1. PENGATURAN DAN MASTER                                                  --}}
        {{-- ========================================================================= --}}
        @if($user->hasRole('super_admin', 'admin_ppdb', 'bendahara', 'kepala_sekolah'))
          <li class="nav-heading">Pengaturan & Master</li>

          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('users.*', 'sekolah.*', 'agama.*', 'pendidikan.*', 'pekerjaan.*', 'penghasilan.*', 'kebutuhan-khusus.*', 'tahun-ajaran.*', 'gelombang.*', 'persyaratan-dokumen.*', 'jalur.*', 'biaya.*', 'komponen-seleksi.*') ? '' : 'collapsed' }}" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-sliders2"></i><span>Pengaturan & Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master-nav" class="nav-content collapse {{ request()->routeIs('users.*', 'sekolah.*', 'agama.*', 'pendidikan.*', 'pekerjaan.*', 'penghasilan.*', 'kebutuhan-khusus.*', 'tahun-ajaran.*', 'gelombang.*', 'persyaratan-dokumen.*', 'jalur.*', 'biaya.*', 'komponen-seleksi.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

              {{-- 1. Users (Khusus Super Admin) --}}
              @if($user->hasRole('super_admin'))
                <li>
                  <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i><span>Users</span>
                  </a>
                </li>
              @endif

              {{-- 2. Sekolah --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah'))
                <li>
                  <a href="{{ route('sekolah.index') }}" class="{{ request()->routeIs('sekolah.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i><span>Profil Sekolah</span>
                  </a>
                </li>
              @endif

              {{-- 3. Tahun Ajaran --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah'))
                <li>
                  <a href="{{ route('tahun-ajaran.index') }}" class="{{ request()->routeIs('tahun-ajaran.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-range"></i><span>Tahun Ajaran</span>
                  </a>
                </li>
              @endif

              {{-- 4. Gelombang --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah'))
                <li>
                  <a href="{{ route('gelombang.index') }}" class="{{ request()->routeIs('gelombang.*') ? 'active' : '' }}">
                    <i class="bi bi-layers"></i><span>Gelombang</span>
                  </a>
                </li>
              @endif

              {{-- 5. Persyaratan Dokumen (Integrasi Jenis & Syarat Dokumen) --}}
              @if($user->hasRole('super_admin', 'admin_ppdb'))
                <li>
                  <a href="{{ route('persyaratan-dokumen.index') }}" class="{{ request()->routeIs('persyaratan-dokumen.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-check"></i><span>Persyaratan Dokumen</span>
                  </a>
                </li>
              @endif

              {{-- 6. Jalur & Kuota Pendaftaran --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah'))
                <li>
                  <a href="{{ route('jalur.index') }}" class="{{ request()->routeIs('jalur.*') ? 'active' : '' }}">
                    <i class="bi bi-signpost-split"></i><span>Jalur & Kuota</span>
                  </a>
                </li>
              @endif

              {{-- 7. Tarif & Biaya PPDB (Integrasi Jenis & Tarif Biaya) --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'bendahara'))
                <li>
                  <a href="{{ route('biaya.index') }}" class="{{ request()->routeIs('biaya.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i><span>Tarif & Biaya</span>
                  </a>
                </li>
              @endif

              {{-- 8. Komponen Seleksi --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah'))
                <li>
                  <a href="{{ route('komponen-seleksi.index') }}" class="{{ request()->routeIs('komponen-seleksi.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check"></i><span>Komponen Seleksi</span>
                  </a>
                </li>
              @endif

              {{-- 11. Penghasilan --}}
              @if($user->hasRole('super_admin', 'admin_ppdb'))
                <li>
                  <a href="{{ route('penghasilan.index') }}" class="{{ request()->routeIs('penghasilan.*') ? 'active' : '' }}">
                    <i class="bi bi-wallet2"></i><span>Penghasilan</span>
                  </a>
                </li>
              @endif

              {{-- 12. Pekerjaan --}}
              @if($user->hasRole('super_admin', 'admin_ppdb'))
                <li>
                  <a href="{{ route('pekerjaan.index') }}" class="{{ request()->routeIs('pekerjaan.*') ? 'active' : '' }}">
                    <i class="bi bi-briefcase"></i><span>Pekerjaan</span>
                  </a>
                </li>
              @endif

              {{-- 13. Pendidikan --}}
              @if($user->hasRole('super_admin', 'admin_ppdb'))
                <li>
                  <a href="{{ route('pendidikan.index') }}" class="{{ request()->routeIs('pendidikan.*') ? 'active' : '' }}">
                    <i class="bi bi-mortarboard"></i><span>Pendidikan</span>
                  </a>
                </li>
              @endif

              {{-- 14. Agama --}}
              @if($user->hasRole('super_admin', 'admin_ppdb'))
                <li>
                  <a href="{{ route('agama.index') }}" class="{{ request()->routeIs('agama.*') ? 'active' : '' }}">
                    <i class="bi bi-moon-stars"></i><span>Agama</span>
                  </a>
                </li>
              @endif

              {{-- 15. Kebutuhan Khusus --}}
              @if($user->hasRole('super_admin', 'admin_ppdb'))
                <li>
                  <a href="{{ route('kebutuhan-khusus.index') }}" class="{{ request()->routeIs('kebutuhan-khusus.*') ? 'active' : '' }}">
                    <i class="bi bi-heart-pulse"></i><span>Kebutuhan Khusus</span>
                  </a>
                </li>
              @endif

            </ul>
          </li><!-- End Pengaturan & Master Nav -->
        @endif


        {{-- ========================================================================= --}}
        {{-- 2. DATA PENDAFTARAN                                                       --}}
        {{-- ========================================================================= --}}
        <li class="nav-heading">Pendaftaran</li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('calon-siswa.*', 'dokumen.*') ? '' : 'collapsed' }}" data-bs-target="#pendaftaran-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-folder2-open"></i><span>Data Pendaftaran</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="pendaftaran-nav" class="nav-content collapse {{ request()->routeIs('calon-siswa.*', 'dokumen.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

            {{-- 1. Calon Siswa / Data Pendaftaran Terpadu --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah', 'bendahara', 'guru', 'pendaftar'))
              <li>
                <a href="{{ route('calon-siswa.index') }}" class="{{ request()->routeIs('calon-siswa.*') ? 'active' : '' }}">
                  <i class="bi bi-person-lines-fill"></i>
                  <span>{{ $user->hasRole('pendaftar') ? 'Formulir Pendaftaran' : 'Data Pendaftaran' }}</span>
                </a>
              </li>
            @endif

            {{-- 2. Verifikasi Dokumen & Berkas Siswa --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah', 'pendaftar'))
              <li>
                <a href="{{ route('dokumen.index') }}" class="{{ request()->routeIs('dokumen.*') ? 'active' : '' }}">
                  <i class="bi bi-file-earmark-check"></i>
                  <span>{{ $user->hasRole('pendaftar') ? 'Unggah Dokumen' : 'Verifikasi Dokumen' }}</span>
                </a>
              </li>
            @endif

          </ul>
        </li><!-- End Data Pendaftaran Nav -->


        {{-- ========================================================================= --}}
        {{-- 3. PROSES PPDB                                                            --}}
        {{-- ========================================================================= --}}
        @if($user->hasRole('super_admin', 'admin_ppdb', 'bendahara', 'kepala_sekolah', 'guru', 'pendaftar'))
          <li class="nav-heading">Proses & Seleksi</li>

          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('pembayaran.*', 'nilai-seleksi.*', 'pengumuman.*') ? '' : 'collapsed' }}" data-bs-target="#proses-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-arrow-repeat"></i><span>Proses PPDB</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="proses-nav" class="nav-content collapse {{ request()->routeIs('pembayaran.*', 'nilai-seleksi.*', 'pengumuman.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

              {{-- 1. Pembayaran PPDB --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'bendahara', 'pendaftar'))
                <li>
                  <a href="{{ route('pembayaran.index') }}" class="{{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">
                    <i class="bi bi-credit-card"></i><span>Pembayaran PPDB</span>
                  </a>
                </li>
              @endif

              {{-- 2. Penilaian & Ujian Seleksi --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah', 'guru'))
                <li>
                  <a href="{{ route('nilai-seleksi.index') }}" class="{{ request()->routeIs('nilai-seleksi.*') ? 'active' : '' }}">
                    <i class="bi bi-card-checklist"></i><span>Penilaian Seleksi</span>
                  </a>
                </li>
              @endif

              {{-- 3. Pengumuman Kelulusan --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah', 'pendaftar'))
                <li>
                  <a href="{{ route('pengumuman.index') }}" class="{{ request()->routeIs('pengumuman.*') ? 'active' : '' }}">
                    <i class="bi bi-megaphone"></i><span>Pengumuman Kelulusan</span>
                  </a>
                </li>
              @endif

            </ul>
          </li><!-- End Proses PPDB Nav -->
        @endif

      @endif

    </ul>

  </aside><!-- End Sidebar -->