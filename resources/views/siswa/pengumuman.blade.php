@extends('layouts.template') {{-- atau layout siswa yang kamu pakai --}}

@section('content')
<h3>Pengumuman</h3>

<div class="row g-4">
@forelse($pengumuman as $row)
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>{{ $row->judul_pengumuman }}</h5>
                <small>{{ \Carbon\Carbon::parse($row->tanggal)->format('d F Y') }}</small>
                <p>{{ Str::limit($row->isi, 100) }}</p>
            </div>
        </div>
    </div>
@empty
    <p>Belum ada pengumuman.</p>
@endforelse
</div>

{{ $pengumuman->links() }}
@endsection
