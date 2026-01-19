@extends('layouts.admin')
@section('title', 'Tambah Penyakit')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Tambah Data Penyakit</h4>
    <p class="text-muted">Input data penyakit tanaman beserta dokumentasi foto</p>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal menyimpan!</strong> Periksa kembali isian berikut:
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form action="{{ route('admin.penyakit.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                <!-- Pilih Tanaman -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kode Pohon <span class="text-danger">*</span></label>
                    <select name="tanaman_id" class="form-select @error('tanaman_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kode Pohon --</option>
                        @foreach($tanaman as $t)
                            <option value="{{ $t->id }}" {{ old('tanaman_id') == $t->id ? 'selected' : '' }}>
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
                    <input type="text" name="nama_penyakit" class="form-control @error('nama_penyakit') is-invalid @enderror"
                           value="{{ old('nama_penyakit') }}" required>
                    @error('nama_penyakit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Foto Penyakit -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Foto Penyakit <span class="text-danger">*</span></label>
                    <input type="file" name="foto_penyakit" class="form-control @error('foto_penyakit') is-invalid @enderror"
                           accept="image/jpeg,image/png" required>
                    <small class="text-muted d-block mt-1">Format: JPG / PNG (maks. 10 MB)</small>
                    @error('foto_penyakit')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.penyakit.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>
@endsection