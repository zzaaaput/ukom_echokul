@php
    $backgroundImage = asset('storage/images/dashboard/background.png');
    $routeName = request()->route()->getName();

    $eksPembina = null;
    if (auth()->check() && auth()->user()->role == 'pembina') {
        $eksPembina = \App\Models\Ekstrakurikuler::where('user_pembina_id', auth()->id())->first();
    }
@endphp

@if($routeName != 'home')
<div class="position-relative w-100" style="height: 200px; background-image: url('{{ $backgroundImage }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
    
    <div class="position-relative d-flex flex-column justify-content-center align-items-center h-100 text-center px-3">

        @switch($routeName)
            @case('dashboard.pembina.index')
                <h1 class="text-white h2 fw-bold mb-2">
                    Dashboard Pembina 
                </h1>

                @if($eksPembina)
                    <p class="text-white-50 mb-0">
                        Ekstrakurikuler:
                        <strong>{{ $eksPembina->nama_ekstrakurikuler }}</strong>
                    </p>
                @else
                    <p class="text-white-50 mb-0"><strong>(Belum memiliki ekstrakurikuler)</strong></p>
                @endif
            @break

            @case('dashboard.ketua.index')
                <h1 class="text-white h2 fw-bold mb-2">Dashboard Ketua</h1>
                @break

            @case('dashboard.siswa.index')
                <h1 class="text-white h2 fw-bold mb-2">Dashboard</h1>
                @break

            @case('anggota.index')
                <h1 class="text-white h2 fw-bold mb-2">Anggota</h1>

                @if($eksPembina)
                    <p class="text-white-50 mb-0">
                        Ekstrakurikuler:
                        <strong>{{ $eksPembina->nama_ekstrakurikuler }}</strong>
                    </p>
                @endif
                @break

            @case('ekstrakurikuler.index')
                <h1 class="text-white h2 fw-bold mb-2">Ekstrakurikuler</h1>
                @break

            @case('ekstrakurikuler.pembina-list')
                <h1 class="text-white h2 fw-bold mb-2">Pembina Ekstrakurikuler</h1>
                @break

            @case('admin.user.index')
                <h1 class="text-white h2 fw-bold mb-2">User</h1>
                @break

            @case('profile.edit')
                <h1 class="text-white h2 fw-bold mb-2">Edit Profil</h1>
                @break

            @default
                <h1 class="text-white h2 fw-bold mb-2">
                    @yield('header-title', 'Selamat Datang di Echokul')
                </h1>
        @endswitch

        <hr class="w-25 border border-white border-2 rounded mb-3">

        @switch($routeName)
            @case('dashboard.admin.index')
                <p class="text-white small mb-0" style="max-width: 500px;">Kelola data user dan ekstrakurikuler</p>
            @break

            @case('dashboard.pembina.index')
                <p class="text-white small mb-0" style="max-width: 500px;">
                    Selamat datang di dashboard pembina
                </p>
            @break

            @case('dashboard.ketua.index')
                <p class="text-white small mb-0" style="max-width: 500px;">Kelola data pendaftaran, perlombaan, kegiatan, pengumuman</p>
                @break

            @case('dashboard.siswa.index')
                <p class="text-white small mb-0" style="max-width: 500px;">Akses informasi dan kegiatan siswa.</p>
                @break

            @case('anggota.index')
                <p class="text-white small mb-0" style="max-width: 500px;">Daftar siswa yang mengikuti ekstrakurikuler</p>
                @break

            @case('ekstrakurikuler.index')
                <p class="text-white small mb-0" style="max-width: 500px;">Ekstrakurikuler yang ada di SMKN 1 Kota Bekasi</p>
                @break

            @case('ekstrakurikuler.pembina-list')
                <p class="text-white small mb-0" style="max-width: 500px;">Daftar pembina untuk setiap ekstrakurikuler</p>
                @break

            @case('admin.user.index')
                <p class="text-white small mb-0" style="max-width: 500px;">Kelola data pengguna</p>
                @break

            @case('profile.edit')
                <p class="text-white small mb-0" style="max-width: 500px;">Perbarui informasi profil Anda.</p>
                @break

            @default
                <p class="text-white small mb-0" style="max-width: 500px;">
                    @yield('header-description', 'Platform inovatif untuk eksplorasi dan pembelajaran yang menarik. Temukan pengalaman baru bersama kami.')
                </p>
        @endswitch

    </div>
</div>
@endif