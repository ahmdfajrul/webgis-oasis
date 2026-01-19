<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Admin') — WebGIS Oasis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body { background:#f4f6f9; }
        .sidebar {
            width:260px;
            min-height:100vh;
            background: linear-gradient(180deg,#065f46,#064e3b);
        }
        .sidebar a {
            color:#e5f7ef;
            padding:12px 20px;
            display:block;
            text-decoration:none;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,.15);
        }
    </style>
</head>

<body>
<div class="d-flex">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h4 class="text-center text-white py-3">🌿 OASIS GIS</h4>

        <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard')?'active':'' }}">
            <i class="fa fa-home me-2"></i> Dashboard
        </a>

        <a href="{{ route('admin.tanaman.index') }}">
            <i class="fa fa-tree me-2"></i> Data Tanaman
        </a>

        <a href="{{ route('admin.penyakit.index') }}">
            <i class="fa fa-bug me-2"></i> Data Penyakit
        </a>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out-alt me-2"></i> Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
    </aside>

    <!-- CONTENT -->
    <main class="flex-fill p-4">
        @yield('content')
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
