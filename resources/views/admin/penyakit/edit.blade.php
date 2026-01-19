@extends('layouts.admin')
@section('title', 'Edit Penyakit')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Edit Data Penyakit</h4>
    <p class="text-muted">Perbarui data penyakit tanaman beserta dokumentasi foto</p>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal memperbarui!</strong> Periksa kembali isian berikut:
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form action="{{ route('admin.penyakit.update', $penyakit->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <!-- Tanaman -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kode Pohon <span class="text-danger">*</span></label>
                    <select name="tanaman_id" class="form-select @error('tanaman_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kode Pohon --</option>
                        @foreach($tanaman as $t)
                            <option value="{{ $t->id }}"
                                    {{ old('tanaman_id', $penyakit->tanaman_id) == $t->id ? 'selected' : '' }}>
                                {{ $t->kode_pohon }} — {{ $t->nama_pohon }}
                            </option>
                        @endforeach
                    </select>
                    @error('tanaman_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama Penyakit -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Penyakit <span class="text-danger">*</span></label>
                    <input type="text" name="nama_penyakit"
                           class="form-control @error('nama_penyakit') is-invalid @enderror"
                           value="{{ old('nama_penyakit', $penyakit->nama_penyakit) }}" required>
                    @error('nama_penyakit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Foto Penyakit -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Foto Penyakit</label>
                    <input type="file" name="foto_penyakit" class="form-control @error('foto_penyakit') is-invalid @enderror"
                           accept="image/jpeg,image/png">
                    <small class="text-muted d-block mt-1">Format: JPG / PNG (maks. 10 MB). Kosongkan jika tidak ingin mengganti.</small>
                    @error('foto_penyakit')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    @if($penyakit->foto_penyakit)
                    <div class="mt-3">
                        <small class="text-muted">Foto saat ini:</small><br>
                        <img src="{{ asset('images/' . $penyakit->foto_penyakit) }}"
                             alt="Foto Penyakit Saat Ini"
                             class="img-thumbnail mt-2"
                             style="max-height: 200px; object-fit: contain;">
                        <br>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2"
                                data-bs-toggle="modal" data-bs-target="#fotoModal">
                            <i class="fa fa-eye"></i> Perbesar Foto
                        </button>
                    </div>
                    @endif
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Update
                </button>
                <a href="{{ route('admin.penyakit.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>

<!-- MODAL FOTO -->
@if($penyakit->foto_penyakit)
<div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fotoModalLabel">Foto Penyakit Saat Ini</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('images/' . $penyakit->foto_penyakit) }}"
                     class="img-fluid rounded" alt="Foto Penyakit">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection