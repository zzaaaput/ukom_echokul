@extends('layouts.template')

@section('title', 'Kehadiran')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between mb-3">
        <h3 class="fw-bold text-dark">Data Kehadiran</h3>

        @if(Auth::user()->role === 'pembina')
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                 Tambah Kehadiran
        </button>
        @endif
    </div>

    <!-- Tabel -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        @if(Auth::user()->role === 'pembina')
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @foreach($kehadiran as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $k->anggota->nama }}</td>
                        <td>{{ $k->tanggal }}</td>
                        <td class="text-capitalize">{{ $k->status }}</td>
                        <td>{{ $k->keterangan ?? '-' }}</td>

                        @if(Auth::user()->role === 'pembina')
                        <td>
                            <form action="{{ route('kehadiran.destroy', $k->id) }}" method="POST"
                                onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('kehadiran.store') }}" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Kehadiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Nama Anggota</label>
                    <select name="anggota_id" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach($anggota as $a)
                        <option value="{{ $a->id }}">{{ $a->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="alpha">Alpha</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Keterangan (opsional)</label>
                    <input type="text" name="keterangan" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Simpan</button>
            </div>

        </form>
    </div>
</div>

@endsection
