<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tanaman - {{ $tanaman->nama_pohon }}</title>

    <!-- Bootstrap 5 CDN biar tampilan rapi & responsif -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .foto-utama {
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            max-height: 600px;
            object-fit: cover;
        }
        .btn-kembali {
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
        }
        .penyakit-card {
            border-radius: 12px;
            overflow: hidden;
        }
        .penyakit-img {
            border-radius: 10px;
            object-fit: cover;
        }
    </style>
</head>
<body class="py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Header + Tombol Kembali -->
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h1 class="fw-bold text-success">{{ $tanaman->nama_pohon }}</h1>
                    <p class="fs-5 text-muted fst-italic">{{ $tanaman->nama_latin ?? '-' }}</p>
                    <p class="fs-5 mb-1"><strong>Kode Pohon:</strong> <span class="text-primary">{{ $tanaman->kode_pohon }}</span></p>
                    <p class="fs-5 mb-0"><strong>Tahun Tanam:</strong> {{ $tanaman->tahun_tanam }}</p>
                </div>

                <a href="/map" class="btn btn-success btn-kembali shadow-sm">
                    <i class="fa fa-map me-2"></i> Kembali ke Peta
                </a>
            </div>

            <!-- Foto Utama (Portrait) -->
            <div class="text-center mb-5">
                @if($tanaman->foto_pohon)
                    <img src="/images/{{ $tanaman->foto_pohon }}" 
                         alt="{{ $tanaman->nama_pohon }}" 
                         class="img-fluid foto-utama">
                @else
                    <div class="bg-light py-5 rounded-4">
                        <i class="fa fa-tree fa-5x text-muted mb-3"></i>
                        <p class="text-muted fs-4">Foto belum tersedia</p>
                    </div>
                @endif
            </div>

            <!-- Riwayat Penyakit -->
            <h3 class="fw-bold text-success mb-4">
                <i class="fa fa-exclamation-triangle me-2"></i> Riwayat Penyakit
            </h3>

            @if($tanaman->penyakit->count() > 0)
                <div class="row g-4">
                    @foreach($tanaman->penyakit as $p)
                        <div class="col-md-6">
                            <div class="card penyakit-card shadow-sm">
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold">{{ $p->nama_penyakit }}</h5>

                                    @if($p->foto_penyakit)
                                        <img src="/images/{{ $p->foto_penyakit }}" 
                                             alt="{{ $p->nama_penyakit }}" 
                                             class="img-fluid penyakit-img mt-3" 
                                             style="height: 220px; width: 100%;">
                                    @else
                                        <div class="bg-secondary bg-opacity-10 py-5 mt-3 rounded">
                                            <i class="fa fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif

                                
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-success text-center py-4">
                    <i class="fa fa-check-circle fa-3x mb-3"></i>
                    <h5>Pohon ini sehat!</h5>
                    <p class="mb-0">Belum ada riwayat penyakit tercatat.</p>
                </div>
            @endif

        </div>
    </div>
</div>

<!-- Bootstrap JS (optional, untuk responsif) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>