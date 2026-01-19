@extends('layouts.admin')
@section('title', 'Tambah Tanaman')

@section('content')
<h4 class="fw-bold mb-3">Tambah Tanaman</h4>

<div class="card shadow-sm">
    <div class="card-body">

        {{-- Tampilkan error validasi kalau ada --}}
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal menyimpan!</strong> Periksa kembali isian berikut:
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.tanaman.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Kode Pohon <span class="text-danger">*</span></label>
                    <input type="text" name="kode_pohon" class="form-control @error('kode_pohon') is-invalid @enderror"
                           value="{{ old('kode_pohon') }}" required>
                    @error('kode_pohon')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Pohon <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pohon" class="form-control @error('nama_pohon') is-invalid @enderror"
                           value="{{ old('nama_pohon') }}" required>
                    @error('nama_pohon')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Latin</label>
                    <input type="text" name="nama_latin" class="form-control"
                           value="{{ old('nama_latin') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tahun Tanam <span class="text-danger">*</span></label>
                    <input type="number" name="tahun_tanam" class="form-control @error('tahun_tanam') is-invalid @enderror"
                           value="{{ old('tahun_tanam') }}" min="1900" max="{{ date('Y') + 5 }}" required>
                    @error('tahun_tanam')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="sehat" {{ old('status') == 'sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="perhatian" {{ old('status') == 'perhatian' ? 'selected' : '' }}>Perhatian</option>
                        <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                    @error('status')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Latitude <span class="text-danger">*</span></label>
                    <input type="number" step="any" name="latitude" class="form-control @error('latitude') is-invalid @enderror"
                           value="{{ old('latitude') }}" required>
                    @error('latitude')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Longitude <span class="text-danger">*</span></label>
                    <input type="number" step="any" name="longitude" class="form-control @error('longitude') is-invalid @enderror"
                           value="{{ old('longitude') }}" required>
                    @error('longitude')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">Foto Pohon <span class="text-danger">*</span></label>
                    <input type="file" name="foto_pohon" class="form-control @error('foto_pohon') is-invalid @enderror"
                           accept="image/*" required>
                    @error('foto_pohon')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Simpan Tanaman</button>
                <a href="{{ route('admin.tanaman.index') }}" class="btn btn-secondary ms-2">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection