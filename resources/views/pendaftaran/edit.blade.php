@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Pendaftaran</h2>

    <form action="{{ route('pendaftaran.update', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Peserta</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $pendaftaran->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Ekstrakurikuler</label>
            <select name="ekstrakurikuler_id" class="form-control" required>
                @foreach($ekstrakurikulers as $ekstra)
                <option value="{{ $ekstra->id }}" {{ $pendaftaran->ekstrakurikuler_id == $ekstra->id ? 'selected' : '' }}>{{ $ekstra->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Daftar</label>
            <input type="date" name="tanggal_daftar" class="form-control" value="{{ $pendaftaran->tanggal_daftar }}" required>
        </div>

        <div class="mb-3">
            <label>Alasan</label>
            <textarea name="alasan" class="form-control" rows="3">{{ $pendaftaran->alasan }}</textarea>
        </div>

        <div class="mb-3">
            <label>Surat Keterangan Orang Tua</label>
            @if($pendaftaran->surat_keterangan_ortu)
                <p>File saat ini: <a href="{{ asset('storage/surat_ortu/'.$pendaftaran->surat_keterangan_ortu) }}" target="_blank">{{ $pendaftaran->surat_keterangan_ortu }}</a></p>
            @endif
            <input type="file" name="surat_keterangan_ortu" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="menunggu" {{ $pendaftaran->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="disetujui" {{ $pendaftaran->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ $pendaftaran->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
