  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SD Al Wafa">
        <span class="d-none d-lg-block">SD AL WAFA</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

@php
  $user = Auth::user();
  $userName = $user->name ?? 'User';
  $words = preg_split("/[\s,_-]+/", trim($userName));
  $initials = '';
  if (count($words) >= 2) {
      $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
  } else {
      $initials = strtoupper(substr($userName, 0, 2));
  }

  $notifData = \App\Http\Controllers\NotifikasiController::getNotifikasiData();
  $notifCount = $notifData['count'];
  $notifItems = $notifData['items'];
@endphp

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <!-- Notification Nav (Real-Time PPDB) -->
        <li class="nav-item dropdown">

          <a class="nav-link nav-icon position-relative" href="#" data-bs-toggle="dropdown" id="notifDropdownToggle" title="Notifikasi PPDB">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number" id="notifBadge" style="{{ $notifCount > 0 ? '' : 'display:none;' }}">{{ $notifCount }}</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications shadow-sm border-0" style="min-width: 320px; max-width: 380px;">
            <li class="dropdown-header d-flex align-items-center justify-content-between p-3 border-bottom">
              <div>
                <strong class="text-dark" id="notifHeaderTitle">Notifikasi PPDB</strong>
                <div class="small text-muted" id="notifHeaderSub"><span id="notifCountText">{{ $notifCount }}</span> item memerlukan tindakan</div>
              </div>
              <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 small">
                <i class="bi bi-broadcast me-1"></i> Live
              </span>
            </li>

            <div id="notifItemsContainer" style="max-height: 380px; overflow-y: auto;">
              @forelse($notifItems as $item)
                <li class="notification-item p-3 border-bottom d-flex align-items-start gap-3">
                  <div class="rounded-circle p-2 d-inline-flex align-items-center justify-content-center flex-shrink-0 {{ $item['bg'] }}" style="width: 36px; height: 36px;">
                    <i class="{{ $item['icon'] }} fs-5"></i>
                  </div>
                  <div class="flex-grow-1">
                    <a href="{{ $item['url'] }}" class="text-decoration-none text-dark d-block">
                      <h6 class="mb-1 fw-bold" style="font-size: 0.88rem;">{{ $item['title'] }}</h6>
                      <p class="mb-1 text-muted" style="font-size: 0.8rem; line-height: 1.4;">{{ $item['desc'] }}</p>
                      <small class="text-muted" style="font-size: 0.74rem;"><i class="bi bi-clock me-1"></i>{{ $item['time'] }}</small>
                    </a>
                  </div>
                </li>
              @empty
                <li class="p-4 text-center text-muted small" id="notifEmptyState">
                  <i class="bi bi-bell-slash fs-3 d-block mb-1 text-secondary opacity-50"></i>
                  Belum ada notifikasi baru saat ini.
                </li>
              @endforelse
            </div>

            <li class="dropdown-footer p-2 text-center bg-light">
              @if($user && $user->hasRole('pendaftar'))
                <a href="{{ route('dashboard') }}" class="small text-decoration-none fw-semibold">Buka Dashboard Saya</a>
              @else
                <a href="{{ route('calon-siswa.index') }}" class="small text-decoration-none fw-semibold">Lihat Semua Data Pendaftar</a>
              @endif
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <!-- Profile Nav (Avatar dengan Inisial Nama) -->
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm flex-shrink-0" style="width: 36px; height: 36px; background: linear-gradient(135deg, #05824e 0%, #035e38 100%); font-size: 0.88rem; letter-spacing: 0.5px;">
              {{ $initials }}
            </div>
            <span class="d-none d-md-block dropdown-toggle ps-2 fw-semibold text-dark">{{ $user->name ?? 'User' }}</span>
          </a><!-- End Profile Initials Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile shadow-sm border-0">
            <li class="dropdown-header text-center p-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm mx-auto mb-2" style="width: 52px; height: 52px; background: linear-gradient(135deg, #05824e 0%, #035e38 100%); font-size: 1.25rem; letter-spacing: 0.5px;">
                {{ $initials }}
              </div>
              <h6 class="fw-bold text-dark mb-0">{{ $user->name ?? 'Pengguna' }}</h6>
              <span class="small text-muted">{{ ucfirst($user->role ?? 'User') }}</span>
            </li>
            <li>
              <hr class="dropdown-divider my-0">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('dashboard') }}">
                <i class="bi bi-grid me-2 text-primary"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider my-0">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center py-2 text-danger" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right me-2 text-danger"></i>
                <span>Keluar (Logout)</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

    <!-- Script Polling Real-Time Notifikasi PPDB -->
    <script>
      (function() {
        var notifUrl = "{{ route('notifikasi.realtime') }}";
        
        function fetchRealtimeNotif() {
          fetch(notifUrl, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json'
            }
          })
          .then(function(res) {
            if (!res.ok) throw new Error('Network error');
            return res.json();
          })
          .then(function(data) {
            var badge = document.getElementById('notifBadge');
            var countText = document.getElementById('notifCountText');
            var container = document.getElementById('notifItemsContainer');

            if (badge) {
              if (data.count > 0) {
                badge.innerText = data.count;
                badge.style.display = '';
              } else {
                badge.style.display = 'none';
              }
            }

            if (countText) {
              countText.innerText = data.count;
            }

            if (container && data.items) {
              if (data.items.length === 0) {
                container.innerHTML = '<li class="p-4 text-center text-muted small"><i class="bi bi-bell-slash fs-3 d-block mb-1 text-secondary opacity-50"></i>Belum ada notifikasi baru saat ini.</li>';
              } else {
                var html = '';
                data.items.forEach(function(item) {
                  html += '<li class="notification-item p-3 border-bottom d-flex align-items-start gap-3">' +
                    '<div class="rounded-circle p-2 d-inline-flex align-items-center justify-content-center flex-shrink-0 ' + (item.bg || 'bg-primary-subtle') + '" style="width: 36px; height: 36px;">' +
                      '<i class="' + item.icon + ' fs-5"></i>' +
                    '</div>' +
                    '<div class="flex-grow-1">' +
                      '<a href="' + item.url + '" class="text-decoration-none text-dark d-block">' +
                        '<h6 class="mb-1 fw-bold" style="font-size: 0.88rem;">' + item.title + '</h6>' +
                        '<p class="mb-1 text-muted" style="font-size: 0.8rem; line-height: 1.4;">' + item.desc + '</p>' +
                        '<small class="text-muted" style="font-size: 0.74rem;"><i class="bi bi-clock me-1"></i>' + item.time + '</small>' +
                      '</a>' +
                    '</div>' +
                  '</li>';
                });
                container.innerHTML = html;
              }
            }
          })
          .catch(function(err) {
            // Silently handle network polling error
          });
        }

        // Jalankan polling setiap 25 detik
        setInterval(fetchRealtimeNotif, 25000);
      })();
    </script>

  </header><!-- End Header -->