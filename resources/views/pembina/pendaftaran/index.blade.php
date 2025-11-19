@extends('layouts.template')

@section('title', 'Pendaftaran')

@section('content')
<div class="container">
    <h3>Daftar Pendaftar</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Siswa</th>
                <th>Ekskul</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $p)
                <tr>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->ekstrakurikuler->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y H:i') }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                    <td>
                        @if($p->status === 'menunggu')
                            <form action="{{ route('pembina.pendaftaran.approve', $p->id) }}" method="POST" style="display:inline">
                                @csrf
                                <button class="btn btn-sm btn-success" type="submit">Setujui</button>
                            </form>
                            <form action="{{ route('pembina.pendaftaran.reject', $p->id) }}" method="POST" style="display:inline">
                                @csrf
                                <button class="btn btn-sm btn-danger" type="submit">Tolak</button>
                            </form>
                        @else
                            <small class="text-muted">Sudah {{ $p->status }}</small>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada pendaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection