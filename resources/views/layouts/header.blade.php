@php
use Illuminate\Support\Str;

$routeName = request()->route()->getName();

// Tentukan apakah header akan ditampilkan
$showHeader = $routeName != 'dashboard.siswa.index' && $routeName != 'home';

if ($showHeader) {
$backgroundImage = asset('storage/images/background.png');

// Judul dan deskripsi dinamis per route
$headers = [
'dashboard.pembina.index' => ['title' => 'Dashboard Pembina', 'desc' => 'Selamat datang di dashboard pembina'],
'dashboard.ketua.index' => ['title' => 'Dashboard Ketua', 'desc' => 'Kelola data pendaftaran, perlombaan, kegiatan, pengumuman'],
'dashboard.siswa.index' => ['title' => 'Dashboard', 'desc' => 'Akses informasi dan kegiatan siswa.'],
'anggota.index' => ['title' => 'Anggota', 'desc' => 'Daftar siswa yang mengikuti ekstrakurikuler'],
'ekstrakurikuler.index' => ['title' => 'Ekstrakurikuler', 'desc' => 'Ekstrakurikuler yang ada di SMKN 1 Kota Bekasi'],
'ekstrakurikuler.pembina-list' => ['title' => 'Pembina Ekstrakurikuler', 'desc' => 'Daftar pembina untuk setiap ekstrakurikuler'],
'admin.user.index' => ['title' => 'User', 'desc' => 'Kelola data pengguna'],
'profile.edit' => ['title' => 'Edit Profil', 'desc' => 'Perbarui informasi profil Anda.'],
];

$currentHeader = $headers[$routeName] ?? [
'title' => Str::title(str_replace('.', ' ', $routeName)),
'desc' => 'Platform inovatif untuk eksplorasi dan pembelajaran yang menarik. Temukan pengalaman baru bersama kami.'
];

$eksPembina = null;
if (auth()->check() && auth()->user()->role == 'pembina') {
$eksPembina = \App\Models\Ekstrakurikuler::where('user_pembina_id', auth()->id())->first();
}
}
@endphp

@if($showHeader)
<div class="position-relative w-100" style="height: 200px; background-image: url('{{ $backgroundImage }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

    <div class="position-relative d-flex flex-column justify-content-center align-items-center h-100 text-center px-3">
        <h1 class="text-white h2 fw-bold mb-2">{{ $currentHeader['title'] }}</h1>

        @if(in_array($routeName, ['dashboard.pembina.index', 'anggota.index']) && $eksPembina)
        <p class="text-white-50 mb-0">
            Ekstrakurikuler: <strong>{{ $eksPembina->nama_ekstrakurikuler }}</strong>
        </p>
        @elseif($routeName == 'dashboard.pembina.index' && !$eksPembina)
        <p class="text-white-50 mb-0"><strong>(Belum memiliki ekstrakurikuler)</strong></p>
        @endif

        <hr class="w-25 border border-white border-2 rounded mb-3">
        <p class="text-white small mb-0" style="max-width: 500px;">{{ $currentHeader['desc'] }}</p>
    </div>
</div>
@endif