@extends('layouts.frontend')

@section('title', 'Peta Tanaman - Oasis Djarum')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css"/>

<style>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

/* MAP FULLSCREEN */
#map-container {
    position: fixed;
    inset: 0;
    width: 100vw;
    height: 100vh;
}

#map {
    width: 100%;
    height: 100%;
}

/* LOADING */
.loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.3rem;
    color: #333;
    background: rgba(255,255,255,0.95);
    padding: 20px 40px;
    border-radius: 14px;
    z-index: 2000;
    box-shadow: 0 6px 25px rgba(0,0,0,0.25);
}

/* TOMBOL HOME FLOATING */
.floating-home {
    position: fixed;
    top: 16px;
    right: 90px;        /* ⬅ JARAK AMAN dari layer control */
    z-index: 3000;
    background: rgba(21, 128, 61, 0.95);
    color: #fff;
    padding: 10px 20px;
    border-radius: 9999px;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(0,0,0,0.3);
}

.floating-home:hover {
    background: #166534;
}

/* CLUSTER STYLE */
.marker-cluster-small,
.marker-cluster-medium,
.marker-cluster-large {
    background-color: rgba(21, 128, 61, 0.8) !important;
    border: 2px solid white;
}
.marker-cluster div {
    background-color: #15803d !important;
    color: white !important;
    font-weight: bold;
}

/* POPUP */
.leaflet-popup-content-wrapper {
    border-radius: 14px !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2) !important;
}
.leaflet-popup-tip {
    background: white !important;
}
</style>
@endsection

@section('content')
<a href="/" class="floating-home">← Home</a>

<div id="map-container">
    <div id="map"></div>
    <div class="loading">Memuat peta satelit tanaman… 🌍🌿</div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>
const tanamanData = @json($tanaman ?? []);

window.addEventListener('load', () => {

    document.querySelector('.loading')?.remove();

    const map = L.map('map', {
        zoomControl: true,
        preferCanvas: true
    }).setView([-6.780535, 110.859251], 15);

    const satellite = L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            maxNativeZoom: 18,
            attribution: 'Tiles © Esri'
        }
    );

    const osm = L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }
    );

    satellite.addTo(map);

    L.control.layers({
        "Satelit (HD)": satellite,
        "Peta Jalan": osm
    }, {}, { position: 'topright' }).addTo(map);

    const markers = L.markerClusterGroup({
        disableClusteringAtZoom: 18,
        maxClusterRadius: 30,
        showCoverageOnHover: false,
        spiderfyOnMaxZoom: false
    });

    const icons = {
        sehat: L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41]
        }),
        perhatian: L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41]
        }),
        sakit: L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41]
        }),
        default: L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-grey.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41]
        })
    };

    tanamanData.forEach((t, i) => {
        let lat = parseFloat(t.latitude);
        let lng = parseFloat(t.longitude);
        if (isNaN(lat) || isNaN(lng)) return;

        lat += i * 0.000005;
        lng += i * 0.000006;

        let key = 'default';
        if (t.status?.toLowerCase() === 'sehat') key = 'sehat';
        else if (t.status?.toLowerCase() === 'perhatian') key = 'perhatian';
        else if (t.status?.toLowerCase() === 'sakit') key = 'sakit';

        const marker = L.marker([lat, lng], { icon: icons[key] });

        marker.bindPopup(`
            <div style="width:260px;text-align:center">
                <h4 style="margin-bottom:8px">${t.nama_pohon ?? 'Tanaman'}</h4>
                <span style="display:inline-block;margin-bottom:10px;
                      padding:6px 14px;border-radius:9999px;
                      background:${key==='sehat'?'#15803d':key==='perhatian'?'#f39c12':'#e74c3c'};
                      color:white;font-weight:600">
                    ${t.status ?? 'Tidak diketahui'}
                </span>

                ${t.foto_pohon ? `
                    <img src="/images/${t.foto_pohon}"
                         style="width:100%;border-radius:10px;margin-bottom:12px">
                ` : '<p>Foto belum tersedia</p>'}

                <a href="/tanaman/${t.id}"
                   style="display:inline-block;padding:8px 18px;
                          background:#15803d;color:white;
                          border-radius:9999px;text-decoration:none">
                   Lihat Detail
                </a>
            </div>
        `);

        markers.addLayer(marker);
    });

    map.addLayer(markers);

    /* === FIX BUG MAP KLIK BARU NORMAL === */
    requestAnimationFrame(() => map.invalidateSize());
    setTimeout(() => map.invalidateSize(), 300);

    if (markers.getLayers().length) {
        setTimeout(() => {
            map.fitBounds(markers.getBounds(), { padding: [80, 80] });
        }, 350);
    }

    window.addEventListener('resize', () => map.invalidateSize());
});
</script>
@endsection
