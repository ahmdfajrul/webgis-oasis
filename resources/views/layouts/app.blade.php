<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - WebGIS Oasis</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body { background: #f4f6f9; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #2e7d32, #1b5e20);
        }
        .sidebar a {
            color: #e8f5e9;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.15);
        }
        .sidebar .active {
            background: rgba(255,255,255,0.25);
        }
        .card {
            border-radius: 12px;
        }
    </style>

    @yield('styles')
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
<div class="col-md-2 sidebar p-0">
    <h4 class="text-center text-white py-3">🌿 OASIS GIS</h4>

    <a href="{{ route('dashboard') }}"
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fa fa-home"></i> Dashboard
    </a>

    <a href="{{ route('admin.tanaman.index') }}"
       class="{{ request()->routeIs('admin.tanaman.*') ? 'active' : '' }}">
        <i class="fa fa-tree"></i> Data Tanaman
    </a>

    <a href="{{ route('admin.penyakit.index') }}"
       class="{{ request()->routeIs('admin.penyakit.*') ? 'active' : '' }}">
        <i class="fa fa-bug"></i> Data Penyakit
    </a>

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
