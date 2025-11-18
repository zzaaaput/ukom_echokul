@extends('layouts.template')

@section('content')
<div class="container py-4">

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<h3>Edit Profil</h3>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Foto Profil</label><br>
        <img src="{{ asset(Auth::user()->foto ?? 'default/default-user.jpg') }}"
        class="rounded-circle me-2" width="120" height="120" style="object-fit: cover;">
        <input type="file" name="foto" class="form-control">
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
