@extends('layouts.template')

@section('title', 'Visi Misi Sekolah')

@section('content')
<div class="container py-4">

  <!-- Header -->
  <div class="text-center mb-5">
    <h2 class="fw-bold text-dark">Visi Misi Sekolah</h2>
    <p class="text-muted">Mengenal tujuan dan arah sekolah kami untuk masa depan yang lebih baik.</p>
  </div>

  <!-- Tampilan Visi Misi -->
  @if($visi_misi && $visi_misi->count() > 0)
    @foreach($visi_misi as $item)
      <div class="row g-4 mb-4">
        <!-- Visi -->
        <div class="col-lg-6">
          <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body text-center">
              <div class="mb-3">
                <i class="bi bi-eye text-primary" style="font-size: 3rem;"></i>
              </div>
              <h5 class="card-title fw-bold text-dark">Visi</h5>
              <p class="card-text text-muted">{{ $item->visi ?? 'Visi belum ditentukan.' }}</p>
              <button class="btn btn-primary fw-semibold" 
                      data-bs-toggle="modal" 
                      data-bs-target="#modalDetailVisi">
                <i class="bi bi-eye me-1"></i> Lihat Detail
              </button>
            </div>
          </div>
        </div>

        <!-- Misi -->
        <div class="col-lg-6">
          <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body text-center">
              <div class="mb-3">
                <i class="bi bi-target text-success" style="font-size: 3rem;"></i>
              </div>
              <h5 class="card-title fw-bold text-dark">Misi</h5>
              <p class="card-text text-muted">{{ Str::limit($item->misi, 150) ?? 'Misi belum ditentukan.' }}</p>
              <button class="btn btn-success fw-semibold" 
                      data-bs-toggle="modal" 
                      data-bs-target="#modalDetailMisi">
                <i class="bi bi-eye me-1"></i> Lihat Detail
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Deskripsi Tambahan (jika ada) -->
      @if($item->deskripsi)
        <div class="card border-0 shadow-sm rounded-3 mb-4">
          <div class="card-body">
            <h5 class="fw-bold text-dark mb-3">Deskripsi Tambahan</h5>
            <p class="text-muted">{{ $item->deskripsi }}</p>
            @if($item->foto && file_exists(public_path($item->foto)))
              <div class="text-center mt-3">
                <img src="{{ asset($item->foto) }}" 
                     class="img-fluid rounded shadow-sm" 
                     style="max-width: 400px; object-fit: cover;" 
                     alt="Foto Visi Misi">
              </div>
            @endif
          </div>
        </div>
      @endif

      <!-- Modal Detail Visi -->
      <div class="modal fade" id="modalDetailVisi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title">Detail Visi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <i class="bi bi-eye text-primary mb-3" style="font-size: 4rem;"></i>
              <p class="fs-5">{{ $item->visi ?? 'Visi belum ditentukan.' }}</p>
              <hr>
              <p class="text-muted small">
                <strong>Diperbarui:</strong> {{ $item->updated_at?->format('d M Y, H:i') ?? '-' }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Detail Misi -->
      <div class="modal fade" id="modalDetailMisi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
              <h5 class="modal-title">Detail Misi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <i class="bi bi-target text-success mb-3" style="font-size: 4rem;"></i>
              <p class="fs-5">{{ $item->misi ?? 'Misi belum ditentukan.' }}</p>
              <hr>
              <p class="text-muted small">
                <strong>Diperbarui:</strong> {{ $item->updated_at?->format('d M Y, H:i') ?? '-' }}
              </p>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  @else
    <div class="text-center py-5">
      <i class="bi bi-exclamation-circle text-muted" style="font-size: 3rem;"></i>
      <h5 class="text-muted mt-3">Belum ada data visi misi.</h5>
      <p class="text-muted">Silakan hubungi admin untuk informasi lebih lanjut.</p>
    </div>
  @endif

</div>
@endsection