
<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('home.mahasiswa') }}" class="nav-link <?= ($hal == 'beranda_mahasiswa') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Beranda</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('presensi.mahasiswa') }}" class="nav-link <?= ($hal == 'presensi') ? 'active' : '' ?>">
              <i class="nav-icon fa fa-qrcode"></i>
              <p>Presensi</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{Route('mahasiswa.gantipass')}}" class="nav-link <?= ($hal == 'ganti_password') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-lock"></i>
              <p>Ganti Password</p>
            </a>
          </li>
          <li class="nav-item">
            <a onclick="return confirm('Apakah anda yakin ingin Logout?')" href="{{ route('logout') }}" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Keluar</p>
            </a>
          </li>
      </ul>
      </nav>