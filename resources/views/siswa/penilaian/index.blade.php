@extends('layouts.template')

@section('title', 'Penilaian Siswa')

@section('content')
<div class="container py-4">

    <h3 class="fw-bold mb-4">Daftar Penilaian Siswa</h3>

     <!-- Search -->
    <div class="mb-3" style="max-width: 300px;">
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control"
                placeholder="Cari anggota / ekskul / semester..."
                value="{{ request('search') }}"
                onchange="this.form.submit()">
        </form>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="py-3 ps-4">No</th>
                <th class="py-3 ps-4">Anggota</th>
                <th class="py-3 ps-4">Ekstrakurikuler</th>
                <th class="py-3 ps-4">Semester</th>
                <th class="py-3 ps-4">Tahun Ajaran</th>
                <th class="py-3 ps-4">Keterangan</th>
                <th class="text-center py-3 ps-4">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($penilaian as $index => $item)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $index + 1 }}</td>
                            <td>{{ $item->anggota->user->nama ?? $item->anggota->nama_anggota }}</td>
                            <td>{{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
                            <td>{{ $item->semester }}</td>
                            <td>{{ $item->tahun_ajaran }}</td>
                            <td class="text-capitalize">{{ $item->keterangan }}</td>

                            <td class="text-center">

                                <!-- Detail -->
                                <button class="btn btn-sm fw-semibold text-white me-1"
                                    style="background-color:#0d6efd;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalDetail{{ $item->id }}">
                                    <i class="bi bi-eye"></i> Detail
                                </button>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada penilaian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
