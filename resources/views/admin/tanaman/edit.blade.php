@extends('layouts.admin')
@section('title', 'Edit Tanaman')

@section('content')
<h4 class="fw-bold mb-3">Edit Tanaman</h4>

<div class="card shadow-sm">
    <div class="card-body">

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.tanaman.update', $tanaman->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Kode Pohon</label>
                <input type="text" 
                       name="kode_pohon" 
                       class="form-control" 
                       value="{{ $tanaman->kode_pohon }}" 
                       readonly
                       disabled>
                <input type="hidden" name="kode_pohon" value="{{ $tanaman->kode_pohon }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Pohon</label>
                <input type="text" name="nama_pohon" class="form-control" value="{{ old('nama_pohon', $tanaman->nama_pohon) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Latin</label>
                <input type="text" name="nama_latin" class="form-control" value="{{ old('nama_latin', $tanaman->nama_latin ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tahun Tanam</label>
                <input type="number" name="tahun_tanam" class="form-control" value="{{ old('tahun_tanam', $tanaman->tahun_tanam) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="sehat"    {{ old('status', $tanaman->status) == 'sehat'    ? 'selected' : '' }}>Sehat</option>
                    <option value="perhatian" {{ old('status', $tanaman->status) == 'perhatian' ? 'selected' : '' }}>Perhatian</option>
                    <option value="sakit"    {{ old('status', $tanaman->status) == 'sakit'    ? 'selected' : '' }}>Sakit</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Latitude</label>
                <input type="number" step="any" name="latitude" class="form-control" value="{{ old('latitude', $tanaman->latitude) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Longitude</label>
                <input type="number" step="any" name="longitude" class="form-control" value="{{ old('longitude', $tanaman->longitude) }}">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Foto Pohon (kosongkan jika tidak ingin ganti)</label>
                <input type="file" name="foto_pohon" class="form-control" accept="image/*">

                @if($tanaman->foto_pohon)
                <div class="mt-3">
                    <small class="text-muted">Foto saat ini:</small><br>
                    <img src="{{ asset('images/' . $tanaman->foto_pohon) }}" 
                         alt="Foto Pohon Saat Ini" 
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

            <button type="submit" class="btn btn-success">
                <i class="fa fa-save"></i> Update Tanaman
            </button>
            <a href="{{ route('admin.tanaman.index') }}" class="btn btn-secondary ms-2">Kembali</a>

        </form>
    </div>
</div>

<!-- MODAL FOTO -->
@if($tanaman->foto_pohon)
<div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fotoModalLabel">Foto Pohon Saat Ini</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('images/' . $tanaman->foto_pohon) }}"
                     class="img-fluid rounded" alt="Foto Pohon">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection