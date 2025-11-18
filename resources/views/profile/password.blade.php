@extends('layouts.template')

@section('content')
<div class="container py-4">

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <h3>Edit Password</h3>
  <form action="{{ route('profile.password.update') }}" method="POST">
  @csrf
    <div class="mb-3">
      <label>Password Lama</label>
      <div class="input-group">
          <input type="password" name="password_lama" id="pw_lama" class="form-control">
          <span class="input-group-text" onclick="togglePw('pw_lama')">
              👁️
          </span>
      </div>
    </div>

    <div class="mb-3">
      <label>Password Baru</label>
      <div class="input-group">
          <input type="password" name="password" id="pw_baru" class="form-control">
          <span class="input-group-text" onclick="togglePw('pw_baru')">
              👁️
          </span>
      </div>
    </div>

    <div class="mb-3">
      <label>Konfirmasi Password Baru</label>
      <div class="input-group">
          <input type="password" name="password_confirmation" id="pw_konfirmasi" class="form-control">
          <span class="input-group-text" onclick="togglePw('pw_konfirmasi')">
              👁️
          </span>
      </div>
    </div>
    <button class="btn btn-primary">Simpan</button>

  </form>
</div>
<script>
function togglePw(id) {
    const x = document.getElementById(id);
    x.type = x.type === "password" ? "text" : "password";
}
</script>

@endsection