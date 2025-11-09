<nav class="navbar navbar-expand-lg shadow-sm" style="background-color: white;">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}" style="color: #001f3f;">
      <img src="{{ asset('build/assets/images/logo.png') }}" alt="Logo Echokul" width="70" height="40" class="me-2">
      ekskul
    </a>

    <ul class="navbar-nav mx-auto">
      <li class="nav-item">
        <a class="nav-link nav-hover" href="{{ route('home') }}">
          Beranda
        </a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle nav-hover" href="#" role="button">
          Ekstrakurikuler
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Materi</a></li>
        </ul>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle nav-hover" href="#" role="button">
          Informasi
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Kegiatan</a></li>
          <li><a class="dropdown-item" href="#">Jadwal</a></li>
          <li><a class="dropdown-item" href="#">Pengumuman</a></li>
          <li><a class="dropdown-item" href="#">Dokumentasi</a></li>
        </ul>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle nav-hover" href="#" role="button">
          Aktivitas
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Kehadiran</a></li>
          <li><a class="dropdown-item" href="#">Prestasi</a></li>
          <li><a class="dropdown-item" href="#">Diskusi</a></li>
        </ul>
      </li>
    </ul>

    <div class="d-flex align-items-center gap-2">
      
      @guest
        <a href="{{ route('login') }}" class="btn btn-sm btn-login">
           Login
        </a>

        <a href="{{ route('register') }}" class="btn btn-sm btn-register">
           Register
        </a>
      @endguest

      @auth
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-dashboard">
           Dashboard
        </a>
      @endauth

    </div>

  </div>
</nav>

<style>
.nav-hover {
  color: #001f3f !important;
  transition: 0.3s;
}

.nav-hover:hover {
  background-color: #001f3f;
  color: white !important;
  border-radius: 5px;
}

.nav-item.dropdown:hover .dropdown-menu {
  display: block;
  margin-top: 0;
}
.dropdown-item:hover {
  background-color: #001f3f;
  color: white;
}

.btn-login {
  background-color: #001f3f;
  color: white;
  border: 1px solid #001f3f;
  transition: 0.3s;
}
.btn-login:hover {
  background-color: white;
  color: #001f3f;
}

.btn-register {
  border: 1px solid #001f3f;
  color: #001f3f;
  transition: 0.3s;
}
.btn-register:hover {
  background-color: #001f3f;
  color: white;
}

.btn-dashboard {
  background-color: #001f3f;
  color: white;
  border: 1px solid #001f3f;
  transition: 0.3s;
}
.btn-dashboard:hover {
  background-color: white;
  color: #001f3f;
}
</style>
