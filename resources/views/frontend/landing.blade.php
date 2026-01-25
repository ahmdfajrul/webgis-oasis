<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oasis Djarum Kudus | Sistem Informasi Geospasial Tanaman</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }

        /* Card Interactive */
        .card {
            transition: all .35s ease;
            background: #fff;
        }
        .card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,.25);
            border-color: #2e7d32;
        }

        /* Statistik hover */
        .stat-box {
            transition: all .35s ease;
        }
        .stat-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(34,197,94,.25);
            background: linear-gradient(135deg,#e8f5e9,#ffffff);
        }

    .text-justify-fix {
        text-align: justify;
        text-justify: inter-word;
        hyphens: auto;
        -webkit-hyphens: auto;
        -ms-hyphens: auto;
    }

    </style>
</head>

<body class="bg-white">

<!-- HEADER -->
<header class="fixed top-0 w-full bg-white/90 backdrop-blur border-b z-50">
    <div class="max-w-7xl mx-auto px-6 h-16 md:h-20 flex justify-between items-center">

        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/logo-oasis.png') }}"
                 class="w-10 h-10 object-contain"
                 alt="Oasis Kretek Factory Park">
            <span class="font-semibold text-lg">
                Oasis Kretek Park
            </span>
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

<div class="h-16 md:h-20"></div>

<!-- HERO -->
<section class="bg-gradient-to-br from-green-50 to-white py-12 md:py-28">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">

        <div data-aos="fade-right">
            <p class="uppercase tracking-widest text-sm text-green-700 font-medium">
                Digital Green Mapping
            </p>

            <h1 class="text-4xl md:text-4xl font-bold mt-4 leading-tight">
                Setiap Pohon Punya Cerita
                <span class="block text-green-700">
                    Oasis Kretek Park
                </span>
            </h1>

            <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-xl text-justify-fix">
    Di balik rimbunnya Oasis Kretek Park, 
    terdapat data yang terus hidup. Gunakan peta ini untuk menjelajahi profil tanaman, 
    mengikuti perkembangan pertumbuhannya, dan memahami peran pentingnya bagi keseimbangan alam kita.
</p>



            <div class="mt-10 flex flex-wrap gap-4">
                <a href="{{ route('map') }}"
                   class="bg-green-700 text-white px-8 py-3 rounded-full hover:bg-green-800 transition">
                    Buka Peta Interaktif
                </a>

                <a href="#statistik"
                   class="border border-green-700 text-green-700 px-8 py-3 rounded-full hover:bg-green-50 transition">
                    Lihat Ringkasan Data
                </a>
            </div>
        </div>

        <div data-aos="fade-left" class="hidden md:block">
            <img src="{{ asset('assets/hero-oasis.jpg') }}"
                 class="rounded-3xl shadow-2xl"
                 alt="Oasis Kretek Factory Park">
        </div>
    </div>
</section>

<!-- FITUR -->
<section id="fitur" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold">Fitur Utama Sistem</h2>
            <p class="mt-4 text-gray-600 max-w-3xl mx-auto">
                Fitur utama untuk pengelolaan kawasan hijau berbasis data spasial.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-10">
            <div class="card p-8 rounded-3xl border" data-aos="zoom-in">
                <h3 class="text-xl font-semibold mb-3">Data Spasial Tanaman</h3>
                <p class="text-gray-600">
                    Visualisasi lokasi tanaman berbasis peta digital interaktif.
                </p>
            </div>

            <div class="card p-8 rounded-3xl border" data-aos="zoom-in" data-aos-delay="150">
                <h3 class="text-xl font-semibold mb-3">Detail Informasi</h3>
                <p class="text-gray-600">
                    Informasi jenis, kondisi, dokumentasi, dan riwayat tanaman.
                </p>
            </div>

            <div class="card p-8 rounded-3xl border" data-aos="zoom-in" data-aos-delay="300">
                <h3 class="text-xl font-semibold mb-3">Monitoring Berkelanjutan</h3>
                <p class="text-gray-600">
                    Mendukung evaluasi dan perawatan tanaman secara periodik.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- STATISTIK -->
<section id="statistik" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold">
                Ringkasan <span class="text-green-700">Data Tanaman</span>
            </h2>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-10">
            <div class="stat-box bg-white p-8 rounded-3xl border text-center">
                <p class="text-gray-500">Total Pohon</p>
                <p class="text-5xl font-bold text-green-700 mt-2">{{ $jumlahTanaman }}</p>
            </div>

            <div class="stat-box bg-white p-8 rounded-3xl border text-center">
                <p class="text-gray-500">Jenis Tanaman</p>
                <p class="text-5xl font-bold text-green-700 mt-2">{{ $jumlahJenis }}</p>
            </div>

            <div class="stat-box bg-white p-8 rounded-3xl border text-center">
                <p class="text-gray-500">Penyakit</p>
                <p class="text-5xl font-bold text-green-700 mt-2">{{ $jumlahPenyakit }}</p>
            </div>

            <div class="stat-box bg-white p-8 rounded-3xl border text-center">
                <p class="text-gray-500">Jenis Penyakit</p>
                <p class="text-5xl font-bold text-green-700 mt-2">{{ $jumlahjenispenyakit }}</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-white border-t py-6">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <p class="text-xs text-gray-500 tracking-wide">
            © {{ date('Y') }} 
            <span class="font-medium text-gray-700">
                Oasis Djarum Kudus
            </span> · Sistem Informasi Geospasial Tanaman
        </p>
    </div>
</footer>


<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 800, easing: 'ease-out-cubic' });
</script>

</body>
</html>
