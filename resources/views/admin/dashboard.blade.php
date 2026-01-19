@extends('layouts.admin')

@section('title','Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Dashboard Admin</h3>
    
    <!-- Tombol Kembali ke Landing Page – warna hijau seperti tombol Tambah -->
    <a href="{{ url('/') }}" class="btn btn-success shadow-sm">
        <i class="fa fa-home me-2"></i> Kembali ke home
    </a>
</div>

<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Tanaman</h6>
                <h2 class="fw-bold text-success">{{ $totalTanaman }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Penyakit</h6>
                <h2 class="fw-bold text-success">{{ $totalPenyakit }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Status Sistem</h6>
                <span class="badge bg-success p-2">Aktif</span>
            </div>
        </div>
    </div>

</div>
@endsection