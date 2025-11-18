<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
      <img src="{{ asset('build/assets/images/logo.png') }}" alt="Logo Echokul" width="70" height="40" class="me-2">
      ekskul
    </a>

    <!-- Toggle button untuk mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

        <!-- Beranda -->
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
        </li>

        <!-- User Menu: hanya admin -->
        @auth
          @if(Auth::user()->role === 'admin')
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.user.index') }}">User</a>
            </li>
          @endif
        @endauth

        <!-- Ekstrakurikuler Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Ekstrakurikuler
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('ekstrakurikuler.index') }}">Ekstrakurikuler</a></li>
            <li><a class="dropdown-item" href="{{ route('anggota.index') }}">Anggota</a></li>
          </ul>
        </li>

        <!-- Informasi Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Informasi
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Kegiatan</a></li>
            <li><a class="dropdown-item" href="#">Jadwal</a></li>
            <li><a class="dropdown-item" href="#">Pengumuman</a></li>
            <li><a class="dropdown-item" href="#">Dokumentasi</a></li>
          </ul>
        </li>

        <!-- Aktivitas Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Aktivitas
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('pembina.kehadiran.index')}}">Kehadiran</a></li>
            <li><a class="dropdown-item" href="{{ route('pembina.perlombaan.index') }}">Perlombaan</a></li>
            <li><a class="dropdown-item" href="{{ route('pembina.penilaian.index') }}">Penilaian</a></li>
          </ul>
        </li>
      </ul>

      <!-- Login/Register/Logout -->
      <div class="d-flex align-items-center gap-2">
        @auth
          <form action="{{ route('logout') }}" method="POST" style="display:inline;">
              @csrf
              <button type="submit" class="btn btn-sm btn-primary">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a>
          <a href="{{ route('register') }}" class="btn btn-sm btn-outline-primary">Register</a>
        @endauth
      </div>
    </div>
  </div>
</nav>

<!-- Optional: Hover dropdown untuk desktop -->
<style>
@media (min-width: 992px) {
  .nav-item.dropdown:hover .dropdown-menu {
    display: block;
  }
}
</style>
