@extends('layouts.frontend') 

@section('title', 'Peta Tanaman - Oasis Djarum')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

<style>
    html, body { height: 100%; margin:0; padding:0; overflow:hidden; }
    #map-container { height:100vh; width:100vw; position:relative; }
    #map { height:100%; width:100%; }
    .loading { 
        position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);
        font-size:1.5rem; color:#333; background:rgba(255,255,255,0.9);
        padding:20px 40px; border-radius:12px; z-index:1000;
        box-shadow:0 4px 20px rgba(0,0,0,0.2); 
    }
    .marker-cluster-small, .marker-cluster-medium, .marker-cluster-large {
        background-color: rgba(34, 139, 34, 0.7) !important;
        border: 2px solid white;
    }
    .marker-cluster div {
        background-color: rgba(0, 100, 0, 0.9) !important;
        color: white !important;
        font-weight: bold;
    }

    /* Popup lebih bagus & selaras hijau */
    .leaflet-popup-content-wrapper {
        border-radius: 12px !important;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2) !important;
        background: white;
    }
    .leaflet-popup-tip {
        background: white !important;
    }
    .custom-popup img {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        margin: 12px auto;
        display: block;
        max-width: 100%;
    }
</style>
@endsection

@section('content')
<div id="map-container">
    <div id="map"></div>
    <div class="loading">Memuat peta satelit tanaman... sabar ya bro 🌍🌿</div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>
const tanamanData = @json($tanaman ?? []);

window.addEventListener('load', function() {
    document.querySelector('.loading')?.remove();

    const map = L.map('map').setView([-6.780535, 110.859251], 15);

    const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles © Esri — Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
        maxZoom: 19,
        maxNativeZoom: 18
    });

    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    });

    satellite.addTo(map);

    L.control.layers({
        "Satelit (HD)": satellite,
        "Peta Jalan": osm
    }, {}, { position: 'topright' }).addTo(map);

    const markers = L.markerClusterGroup({
        spiderfyOnMaxZoom: false,
        showCoverageOnHover: false,
        zoomToBoundsOnClick: true,
        disableClusteringAtZoom: 18,
        maxClusterRadius: 30,
        animate: true,
        animateAddingMarkers: false
    });

    const icons = {
        'sehat': L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        'perhatian': L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        'sakit': L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        'default': L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-grey.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        })
    };

    tanamanData.forEach((t, index) => {
        let lat = parseFloat(t.latitude);
        let lng = parseFloat(t.longitude);
        if (isNaN(lat) || isNaN(lng)) return;

        // Offset kecil untuk pisah visual kalau koordinat sama
        const offset = (index * 0.000005);
        lat += offset;
        lng += offset * 1.2;

        let statusKey = 'default';
        const statusLower = t.status?.toLowerCase();
        if (statusLower === 'sehat') statusKey = 'sehat';
        else if (statusLower === 'perhatian') statusKey = 'perhatian';
        else if (statusLower === 'sakit') statusKey = 'sakit';

        const marker = L.marker([lat, lng], { 
            icon: icons[statusKey] 
        });

        // Popup dengan tombol hijau (selaras dashboard)
        marker.bindPopup(`
            <div style="width: 280px; padding: 16px; text-align: center; background: white; border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.18); font-family: 'Segoe UI', Arial, sans-serif;">
                <!-- Nama Pohon -->
                <h5 style="margin: 0 0 10px 0; font-size: 1.35em; font-weight: 700; color: #1e272e;">
                    ${t.nama_pohon || 'Tanaman'}
                </h5>

                <!-- Status Badge -->
                <div style="margin-bottom: 14px;">
                    <span style="padding: 8px 18px; border-radius: 30px; font-weight: 600; font-size: 0.95em; color: white; 
                                 background: ${statusKey === 'sehat' ? '#27ae60' : statusKey === 'perhatian' ? '#f39c12' : '#e74c3c'}">
                        ${t.status ? t.status.charAt(0).toUpperCase() + t.status.slice(1) : 'Tidak diketahui'}
                    </span>
                </div>

                <!-- Foto (ke tengah sempurna) -->
                ${t.foto_pohon ? 
                    `<div style="margin: 0 auto 16px auto; max-width: 240px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 14px rgba(0,0,0,0.12);">
                        <img src="/images/${t.foto_pohon}" 
                             alt="${t.nama_pohon}" 
                             style="width: 100%; height: auto; display: block; object-fit: cover;">
                    </div>` 
                    : 
                    `<div style="margin: 20px 0; color: #7f8c8d; font-size: 1.1em;">
                        <i class="fa fa-image fa-3x mb-2"></i><br>
                        <small>Foto belum tersedia</small>
                    </div>`
                }

                <a href="/tanaman/${t.id}"
                   style="display:inline-block; padding:10px 24px; background:#27ae60; color:white;
                          text-decoration:none; border-radius:8px; font-weight:600;">
                    <i class="fa fa-eye"></i> Lihat Detail
                </a>
            </div>
        `, {
            maxWidth: 300,
            closeButton: true,
            autoPan: true,
            autoPanPadding: [20, 20]
        });

        markers.addLayer(marker);
    });

    map.addLayer(markers);

    if (markers.getLayers().length > 0) {
        map.fitBounds(markers.getBounds(), { padding: [60, 60] });
    }

    window.addEventListener('resize', () => map.invalidateSize());
});
</script>
@endsection