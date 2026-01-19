<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Oasis Djarum Kudus | Sistem Informasi Geospasial Tanaman</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding-top:80px;
        }
        .hero-image {
            border-radius:1rem;
            box-shadow:0 30px 60px -15px rgba(0,0,0,.25);
        }
        .card {
            border:1px solid #e5e7eb;
            transition:.3s;
        }
        .card:hover {
            transform:translateY(-5px);
            border-color:#2e7d32;
            box-shadow:0 25px 40px -15px rgba(0,0,0,.15);
        }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="fixed top-0 w-full bg-white border-b z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-700 rounded-full flex items-center justify-center text-white font-bold">
                DF
            </div>
            <span class="font-semibold text-lg">Djarum Foundation Park</span>
        </div>

        <nav class="hidden md:flex items-center gap-10 text-sm font-medium">
            <a href="{{ route('landing') }}" class="hover:text-green-700">Beranda</a>
            <a href="{{ route('map') }}" class="hover:text-green-700">Peta</a>
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-green-700">
                Akses Admin
            </a>
        </nav>
    </div>
</header>

<!-- HERO -->
<section class="min-h-[85vh] flex items-center bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">

        <div data-aos="fade-right">
            <p class="uppercase tracking-widest text-sm text-green-700 font-medium">
                Sistem Informasi Geospasial
            </p>

            <h1 class="text-4xl font-bold mt-6 leading-tight">
                Pemetaan Tanaman<br>
                <span class="text-green-700"> Djarum Foundation Park</span>
            </h1>

            <p class="mt-8 text-lg text-gray-600 max-w-xl leading-relaxed">
                Platform berbasis Web GIS yang dikembangkan untuk mendukung
                pendataan, pemantauan, dan pengelolaan tanaman secara terintegrasi,
                akurat, dan berkelanjutan.
            </p>

            <div class="mt-10 flex gap-4">
                <a href="{{ route('map') }}"
                   class="bg-green-700 text-white px-8 py-4 rounded-full hover:bg-green-800 transition">
                    Peta Interaktif
                </a>

                <a href="#statistik"
                   class="px-8 py-4 rounded-full border border-green-700 text-green-700 hover:bg-green-50 transition">
                    Ringkasan Data
                </a>
            </div>
        </div>

        <div data-aos="fade-left" class="hidden md:block">
            <img 
                src="https://images.pexels.com/photos/10479377/pexels-photo-10479377.jpeg?auto=compress&cs=tinysrgb&w=1200"
                class="hero-image w-full"
                alt="Kawasan hijau Oasis Djarum">
        </div>

    </div>
</section>

<!-- FITUR -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold">
                Fitur Utama Sistem
            </h2>
            <p class="mt-4 text-gray-600 max-w-3xl mx-auto">
                Sistem ini dikembangkan sebagai alat pendukung pengelolaan kawasan hijau
                berbasis data spasial dan informasi tanaman.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-10">
            <div class="card p-8 rounded-2xl" data-aos="fade-up">
                <h3 class="text-xl font-semibold mb-4">Data Spasial Tanaman</h3>
                <p class="text-gray-600">
                    Setiap tanaman direpresentasikan dalam peta digital berbasis koordinat geografis.
                </p>
            </div>

            <div class="card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="150">
                <h3 class="text-xl font-semibold mb-4">Informasi Detail Tanaman</h3>
                <p class="text-gray-600">
                    Menyediakan data jenis tanaman, nama ilmiah, tahun tanam, dan dokumentasi visual.
                </p>
            </div>

            <div class="card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-xl font-semibold mb-4">Monitoring & Evaluasi</h3>
                <p class="text-gray-600">
                    Mendukung pencatatan kondisi dan riwayat perawatan tanaman secara berkala.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- STATISTIK -->
<section id="statistik" class="py-28 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Judul -->
        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold">
                Ringkasan <span class="text-green-700">Data Tanaman</span>
            </h2>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                Informasi statistik berdasarkan data aktual yang tersimpan
                pada sistem pemetaan Oasis Djarum Kudus.
            </p>
        </div>

        <!-- Card Statistik -->
        <div class="grid md:grid-cols-4 gap-10">

            <!-- Total Pohon -->
            <div class="relative bg-white rounded-3xl p-10 border hover:shadow-2xl transition">
                <div class="absolute top-6 right-6 text-green-100 text-6xl"></div>
                <p class="text-sm uppercase tracking-wider text-gray-500">
                    Total Pohon
                </p>
                <p class="text-5xl font-bold text-green-700 mt-4">
                    {{ $jumlahTanaman }}
                </p>
                <p class="mt-2 text-gray-600">
                    Pohon terdata
                </p>
            </div>

            <!-- Jenis Tanaman -->
            <div class="relative bg-white rounded-3xl p-10 border hover:shadow-2xl transition">
                <div class="absolute top-6 right-6 text-green-100 text-6xl"></div>
                <p class="text-sm uppercase tracking-wider text-gray-500">
                    Jenis Tanaman
                </p>
                <p class="text-5xl font-bold text-green-700 mt-4">
                    {{ $jumlahJenis }}
                </p>
                <p class="mt-2 text-gray-600">
                    Klasifikasi tanaman
                </p>
            </div>

            <!-- Penyakit -->
            <div class="relative bg-white rounded-3xl p-10 border hover:shadow-2xl transition">
                <div class="absolute top-6 right-6 text-green-100 text-6xl"></div>
                <p class="text-sm uppercase tracking-wider text-gray-500">
                    Penyakit
                </p>
                <p class="text-5xl font-bold text-green-700 mt-4">
                    {{ $jumlahPenyakit }}
                </p>
                <p class="mt-2 text-gray-600">
                    Kategori penyakit
                </p>
            </div>

            <!-- GIS -->
            <div class="relative bg-gradient-to-br from-green-700 to-green-600 rounded-3xl p-10 text-white shadow-xl">
                <div class="absolute top-6 right-6 text-green-200 text-6xl"></div>
                <p class="text-sm uppercase tracking-wider text-green-100">
                    Sistem
                </p>
                <p class="text-5xl font-bold mt-4">
                    GIS
                </p>
                <p class="mt-2 text-green-100">
                    Peta Interaktif
                </p>
            </div>

        </div>
    </div>
</section>


<!-- FOOTER -->
<footer class="bg-gray-900 text-gray-300 py-14">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <p class="font-semibold text-white mb-2">
            Sistem Informasi Geospasial Tanaman Oasis Djarum Kudus
        </p>
        <p class="text-sm mb-4">
            Dikembangkan untuk mendukung pengelolaan lingkungan berbasis data
        </p>
        <p class="text-xs text-gray-400">
            © {{ date('Y') }} Oasis Djarum Kudus
        </p>
    </div>
</footer>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ once:true, duration:800 });
</script>

</body>
</html>
