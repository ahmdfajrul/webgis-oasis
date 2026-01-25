<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Oasis')</title>
    @vite('resources/css/app.css') <!-- Tailwind -->
    @yield('styles')
</head>
<body class="bg-gray-100">

<header class="bg-green-700 text-white p-4">
    <h1 class="text-xl font-bold">Oasis</h1>
</header>

<main class="p-4">
    @yield('content')
</main>

<footer class="text-center p-4 text-gray-500">&copy; {{ date('Y') }} Oasis Djarum</footer>

@yield('scripts')
</body>
</html>
