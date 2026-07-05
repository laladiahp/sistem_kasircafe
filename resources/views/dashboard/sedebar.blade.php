<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            @auth
              @if(auth()->user()->isAdmin())
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/admin') }}">
                    <i class="mdi mdi-grid-large menu-icon"></i>
                    <span class="menu-title">Dashboard Admin</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/admin/orders') }}">
                    <i class="mdi mdi-clipboard-list menu-icon"></i>
                    <span class="menu-title">Pesanan / Antrian</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/admin/tables') }}">
                    <i class="mdi mdi-qrcode-scan menu-icon"></i>
                    <span class="menu-title">Meja / QR Code</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/admin/menus') }}">
                    <i class="mdi mdi-silverware-fork-knife menu-icon"></i>
                    <span class="menu-title">Menu</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/admin/categories') }}">
                    <i class="mdi mdi-shape menu-icon"></i>
                    <span class="menu-title">Kategori</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/admin/reports') }}">
                    <i class="mdi mdi-chart-line menu-icon"></i>
                    <span class="menu-title">Laporan</span>
                  </a>
                </li>
              @endif
            @endauth
          </ul>
        </nav>
