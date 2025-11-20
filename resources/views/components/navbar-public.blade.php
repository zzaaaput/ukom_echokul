<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
    <img src="{{ asset('storage/images/logo.png') }}" alt="Logo Echokul" width="70" height="40" class="me-2">
      Echokul
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
        </li>

        @auth
          @if(Auth::user()->role === 'admin')
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.user.index') }}">User</a>
            </li>
          @endif
        @endauth

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Daftar
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('ekstrakurikuler.index') }}">Ekstrakurikuler</a></li>
            <li><a class="dropdown-item" href="{{ route('anggota.index') }}">Anggota</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Informasi
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('kegiatan.index') }}">Kegiatan</a></li>
            <li><a class="dropdown-item" href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
            <li><a class="dropdown-item" href="{{ route('perlombaan.index') }}">Perlombaan</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Aktivitas
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('kehadiran.index')}}">Kehadiran</a></li>
            <li><a class="dropdown-item" href="{{ route('penilaian.index') }}">Penilaian</a></li>
          </ul>
        </li>
      </ul>

      <div class="d-flex align-items-center">
        @auth
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    
                    <!-- Foto Profil -->
                    <img src="{{ asset(Auth::user()->foto ?? 'default/default-user.jpg') }}"
                    class="rounded-circle me-2" width="50" height="50" style="object-fit: cover;">

                    <div class="d-flex flex-column" style="line-height: 1;">
                        <span class="fw-bold">{{ Auth::user()->nama_lengkap }}</span>
                        <small class="text-muted" style="margin-top:5px;">{{ Auth::user()->role }}</small>
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profil</a></li>
                    <li><a class="dropdown-item" href="{{ route('profile.password') }}">Edit Password</a></li>
                    @if(Auth::user()->role === 'siswa')
                        <li><a class="dropdown-item" href="{{ route('profile.pendaftaran') }}">Pendaftaran</a></li>
                    @endif

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-sm btn-outline-primary ms-2">Register</a>
        @endguest

      </div>

    </div>
  </div>
</nav>

<style>
@media (min-width: 992px) {
  .nav-item.dropdown:hover .dropdown-menu {
    display: block;
  }
}
</style>
