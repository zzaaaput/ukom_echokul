
<nav class="navbar navbar-expand-lg shadow-sm" style="background-color: white;">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}" style="color: #001f3f;">
      <img src="{{ asset('build/assets/images/logo.png') }}" alt="Logo Echokul" width="70" height="40" class="me-2">
      Echokul
    </a>

    <ul class="navbar-nav mx-auto">
      <li class="nav-item">
        <a class="nav-link" href="#" style="color: #001f3f; transition: 0.3s;"
           onmouseover="this.style.color='white'; this.style.backgroundColor='#001f3f'; this.style.borderRadius='5px';"
           onmouseout="this.style.color='#001f3f'; this.style.backgroundColor='transparent';">
           Beranda
        </a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button"
           style="color: #001f3f; transition: 0.3s;"
           onmouseover="this.style.color='white'; this.style.backgroundColor='#001f3f'; this.style.borderRadius='5px';"
           onmouseout="this.style.color='#001f3f'; this.style.backgroundColor='transparent';">
           Ekstrakurikuler
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Materi</a></li>
        </ul>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button"
           style="color: #001f3f; transition: 0.3s;"
           onmouseover="this.style.color='white'; this.style.backgroundColor='#001f3f'; this.style.borderRadius='5px';"
           onmouseout="this.style.color='#001f3f'; this.style.backgroundColor='transparent';">
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
        <a class="nav-link dropdown-toggle" href="#" role="button"
           style="color: #001f3f; transition: 0.3s;"
           onmouseover="this.style.color='white'; this.style.backgroundColor='#001f3f'; this.style.borderRadius='5px';"
           onmouseout="this.style.color='#001f3f'; this.style.backgroundColor='transparent';">
           Aktivitas
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Kehadiran</a></li>
          <li><a class="dropdown-item" href="#">Prestasi</a></li>
          <li><a class="dropdown-item" href="#">Diskusi</a></li>
        </ul>
      </li>
    </ul>

    <div>
      <a href="#" class="btn btn-sm text-white"
         style="background-color: #001f3f; border: 1px solid #001f3f; transition: 0.3s;"
         onmouseover="this.style.backgroundColor='white'; this.style.color='#001f3f';"
         onmouseout="this.style.backgroundColor='#001f3f'; this.style.color='white';">
         Login
      </a>
    </div>
  </div>
</nav>

<style>
.nav-item.dropdown:hover .dropdown-menu {
  display: block;
  margin-top: 0;
}
.dropdown-item:hover {
  background-color: #001f3f;
  color: white;
}
</style>
