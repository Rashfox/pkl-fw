
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('home.admin') }}" class="nav-link <?= ($hal == 'beranda_admin') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Beranda</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ Route('perak.admin') }}" class="nav-link <?= ($hal == 'periode_akademik') ? 'active' : '' ?>">
              <i class="nav-icon fa fa-book"></i>
              <p>Periode Akademik</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ Route('makul.admin') }}" class="nav-link <?= ($hal == 'mata_kuliah') ? 'active' : '' ?>">
              <i class="nav-icon fa fa-calendar"></i>
              <p>Mata Kuliah</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ Route('prodi.admin') }}" class="nav-link <?= ($hal == 'data_prodi') ? 'active' : '' ?>">
              <i class="nav-icon fa fa-university"></i>
              <p>Data Prodi</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('data.dosen') }}" class="nav-link <?= ($hal == 'data_dosen') ? 'active' : '' ?>">
              <i class="nav-icon fa fa-briefcase"></i>
              <p>Data Dosen</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('data.mahasiswa') }}" class="nav-link <?= ($hal == 'data_mahasiswa') ? 'active' : '' ?>">
              <i class="nav-icon fa fa-graduation-cap"></i>
              <p>Data Mahasiswa</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('data.user') }}" class="nav-link <?= ($hal == 'data_administrator') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>Data Administrator</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ Route('kelas.admin') }}" class="nav-link <?= ($hal == 'kelas') ? 'active' : '' ?>">
              <i class="nav-icon fa fa-home "></i>
              <p>Kelas Mata Kuliah</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{Route('admin.gantipass')}}" class="nav-link <?= ($hal == 'ganti_password') ? 'active' : '' ?>">
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