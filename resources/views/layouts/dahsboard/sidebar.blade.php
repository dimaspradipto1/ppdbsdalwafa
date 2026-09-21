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
            <a class="nav-link {{ request()->routeIs('users.*', 'sekolah.*', 'agama.*') ? '' : 'collapsed' }}" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-sliders2"></i><span>Pengaturan & Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master-nav" class="nav-content collapse {{ request()->routeIs('users.*', 'sekolah.*', 'agama.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

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
                    <i class="bi bi-building"></i><span>Sekolah</span>
                  </a>
                </li>
              @endif

              {{-- 3. Jenis Dokumen --}}
              @if($user->hasRole('super_admin', 'admin_ppdb'))
                <li>
                  <a href="#">
                    <i class="bi bi-file-earmark-text"></i><span>Jenis Dokumen</span>
                  </a>
                </li>
              @endif

              {{-- 3.1 Syarat Dokumen --}}
              @if($user->hasRole('super_admin', 'admin_ppdb'))
                <li>
                  <a href="#">
                    <i class="bi bi-file-earmark-check"></i><span>Syarat Dokumen</span>
                  </a>
                </li>
              @endif

              {{-- 4. Jalur --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah'))
                <li>
                  <a href="#">
                    <i class="bi bi-signpost-split"></i><span>Jalur</span>
                  </a>
                </li>
              @endif

              {{-- 5. Kuota Jalur --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah'))
                <li>
                  <a href="#">
                    <i class="bi bi-pie-chart"></i><span>Kuota Jalur</span>
                  </a>
                </li>
              @endif

              {{-- 6. Tahun Ajaran --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah'))
                <li>
                  <a href="#">
                    <i class="bi bi-calendar-range"></i><span>Tahun Ajaran</span>
                  </a>
                </li>
              @endif

              {{-- 7. Gelombang --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah'))
                <li>
                  <a href="#">
                    <i class="bi bi-layers"></i><span>Gelombang</span>
                  </a>
                </li>
              @endif

              {{-- 8. Tarif Biaya --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'bendahara'))
                <li>
                  <a href="#">
                    <i class="bi bi-cash-coin"></i><span>Tarif Biaya</span>
                  </a>
                </li>
              @endif

              {{-- 9. Jenis Biaya --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'bendahara'))
                <li>
                  <a href="#">
                    <i class="bi bi-tags"></i><span>Jenis Biaya</span>
                  </a>
                </li>
              @endif

              {{-- 10. Komponen Seleksi --}}
              @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah'))
                <li>
                  <a href="#">
                    <i class="bi bi-clipboard-check"></i><span>Komponen Seleksi</span>
                  </a>
                </li>
              @endif

              {{-- 11. Penghasilan --}}
              @if($user->hasRole('super_admin', 'admin_ppdb'))
                <li>
                  <a href="#">
                    <i class="bi bi-wallet2"></i><span>Penghasilan</span>
                  </a>
                </li>
              @endif

              {{-- 12. Pekerjaan --}}
              @if($user->hasRole('super_admin', 'admin_ppdb'))
                <li>
                  <a href="#">
                    <i class="bi bi-briefcase"></i><span>Pekerjaan</span>
                  </a>
                </li>
              @endif

              {{-- 13. Pendidikan --}}
              @if($user->hasRole('super_admin', 'admin_ppdb'))
                <li>
                  <a href="#">
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
                  <a href="#">
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
          <a class="nav-link collapsed" data-bs-target="#pendaftaran-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-folder2-open"></i><span>Data Pendaftaran</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="pendaftaran-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

            {{-- 1. Pendaftaran --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah', 'bendahara', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-person-lines-fill"></i>
                  <span>{{ $user->hasRole('pendaftar') ? 'Formulir Pendaftaran' : 'Pendaftaran' }}</span>
                </a>
              </li>
            @endif

            {{-- 2. Dokumen --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-file-earmark-arrow-up"></i>
                  <span>{{ $user->hasRole('pendaftar') ? 'Unggah Dokumen' : 'Dokumen' }}</span>
                </a>
              </li>
            @endif

            {{-- 3. Orang Tua Wali --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-people-fill"></i><span>Orang Tua Wali</span>
                </a>
              </li>
            @endif

            {{-- 4. Alamat --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-geo-alt"></i><span>Alamat</span>
                </a>
              </li>
            @endif

            {{-- 5. Beasiswa --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah', 'bendahara', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-award"></i><span>Beasiswa</span>
                </a>
              </li>
            @endif

            {{-- 6. Calon Siswa --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah', 'bendahara', 'guru', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-person-badge"></i>
                  <span>{{ $user->hasRole('pendaftar') ? 'Biodata Siswa' : 'Calon Siswa' }}</span>
                </a>
              </li>
            @endif

            {{-- 7. Prestasi --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah', 'guru', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-trophy"></i><span>Prestasi</span>
                </a>
              </li>
            @endif

            {{-- 8. Sekolah Asal --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah', 'guru', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-bank"></i><span>Sekolah Asal</span>
                </a>
              </li>
            @endif

            {{-- 9. Siswa Kebutuhan Khusus --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'guru', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-bandaid"></i><span>Siswa Kebutuhan Khusus</span>
                </a>
              </li>
            @endif

          </ul>
        </li><!-- End Data Pendaftaran Nav -->


        {{-- ========================================================================= --}}
        {{-- 3. PROSES PPDB                                                            --}}
        {{-- ========================================================================= --}}
        <li class="nav-heading">Proses & Seleksi</li>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#proses-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-arrow-repeat"></i><span>Proses PPDB</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="proses-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

            {{-- 1. Pengumuman --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-megaphone"></i><span>Pengumuman</span>
                </a>
              </li>
            @endif

            {{-- 2. Verifikasi --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator'))
              <li>
                <a href="#">
                  <i class="bi bi-check2-circle"></i><span>Verifikasi</span>
                </a>
              </li>
            @endif

            {{-- 3. Seleksi --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah', 'guru'))
              <li>
                <a href="#">
                  <i class="bi bi-ui-checks"></i><span>Seleksi</span>
                </a>
              </li>
            @endif

            {{-- 4. Status --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'verifikator', 'kepala_sekolah', 'bendahara', 'guru', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-hourglass-split"></i><span>Status</span>
                </a>
              </li>
            @endif

            {{-- 5. Pembayaran --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'bendahara', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-credit-card"></i><span>Pembayaran</span>
                </a>
              </li>
            @endif

            {{-- 6. Nilai Seleksi --}}
            @if($user->hasRole('super_admin', 'admin_ppdb', 'kepala_sekolah', 'guru', 'pendaftar'))
              <li>
                <a href="#">
                  <i class="bi bi-card-checklist"></i><span>Nilai Seleksi</span>
                </a>
              </li>
            @endif

          </ul>
        </li><!-- End Proses PPDB Nav -->

      @endif

    </ul>

  </aside><!-- End Sidebar -->