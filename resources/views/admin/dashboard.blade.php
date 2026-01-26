@extends('layouts.admin')

@section('title','Dashboard')

@section('content')

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Dashboard Admin</h3>
        <small class="text-muted"></small>
    </div>

    <a href="{{ url('/') }}" class="btn btn-home shadow-sm">
        <i class="bi bi-house me-2"></i> Kembali ke home
    </a>
</div>

<!-- STAT CARDS -->
<div class="row g-4">

    <!-- Total Tanaman -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-title">Total Tanaman</div>
                    <div class="stat-value">{{ $totalTanaman }}</div>
                </div>
                <div class="fs-1 text-success opacity-25">
                    <i class="bi bi-tree"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Penyakit -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-title">Total Penyakit</div>
                    <div class="stat-value">{{ $totalPenyakit }}</div>
                </div>
                <div class="fs-1 text-success opacity-25">
                    <i class="bi bi-bug"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Sistem -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-title">Status Sistem</div>
                    <span class="badge-status">Aktif</span>
                </div>
                <div class="fs-1 text-success opacity-25">
                    <i class="bi bi-shield-check"></i>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
