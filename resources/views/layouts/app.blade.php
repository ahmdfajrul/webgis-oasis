<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- ADMIN CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <span>OASIS GIS</span>
    </div>

    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-house"></i> Dashboard
    </a>

    <a href="{{ route('admin.tanaman.index') }}" class="{{ request()->routeIs('admin.tanaman.*') ? 'active' : '' }}">
        <i class="bi bi-tree"></i> Data Tanaman
    </a>

    <a href="{{ route('admin.penyakit.index') }}" class="{{ request()->routeIs('admin.penyakit.*') ? 'active' : '' }}">
        <i class="bi bi-bug"></i> Data Penyakit
    </a>

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>

<!-- CONTENT -->
<div class="content">
    <div class="topbar">
        <h1>@yield('page-title', 'Dashboard Admin')</h1>

        <a href="{{ url('/') }}" class="btn btn-home">
            <i class="bi bi-house"></i> Kembali ke home
        </a>
    </div>

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
