@extends('layouts.admin')

@section('title','Peta Tanaman Admin')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css"/>
<style>
#map-admin {
    width: 100%;
    height: 500px; /* wajib agar map muncul */
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3 class="fw-bold">Peta Tanaman (Drag Marker untuk Update)</h3>
</div>

<div id="map-admin"></div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanamanData = @json($tanaman ?? []);

    // Init map
    const map = L.map('map-admin').setView([-6.780535, 110.859251], 15);

    L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        { maxZoom: 19, attribution: 'Tiles © Esri' }
    ).addTo(map);

    const markers = L.markerClusterGroup({ disableClusteringAtZoom: 18, maxClusterRadius: 30 });

    const icons = {
        sehat: L.icon({
            iconUrl:'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl:'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize:[25,41], iconAnchor:[12,41]
        }),
        perhatian: L.icon({
            iconUrl:'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
            shadowUrl:'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize:[25,41], iconAnchor:[12,41]
        }),
        sakit: L.icon({
            iconUrl:'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl:'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize:[25,41], iconAnchor:[12,41]
        }),
        default: L.icon({
            iconUrl:'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-grey.png',
            shadowUrl:'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize:[25,41], iconAnchor:[12,41]
        })
    };

    // Add markers
    if(tanamanData.length) {
        tanamanData.forEach(t => {
            const lat = parseFloat(t.latitude);
            const lng = parseFloat(t.longitude);
            if(isNaN(lat) || isNaN(lng)) return;

            let key='default';
            if(t.status?.toLowerCase()==='sehat') key='sehat';
            else if(t.status?.toLowerCase()==='perhatian') key='perhatian';
            else if(t.status?.toLowerCase()==='sakit') key='sakit';

            const marker = L.marker([lat,lng], { icon: icons[key], draggable:true });
            marker.bindPopup(`<b>${t.nama_pohon}</b><br>Status: ${t.status}<br>ID: ${t.id}`);
            
            // Drag event update lokasi
            marker.on('dragend', function(e){
                const pos = e.target.getLatLng();
                fetch(`/admin/tanaman/${t.id}/update-location`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ latitude: pos.lat, longitude: pos.lng })
                }).then(r => r.json())
                  .then(data => alert('Lokasi diperbarui!'))
                  .catch(err => alert('Gagal update lokasi'));
            });

            markers.addLayer(marker);
        });
    } else {
        // Dummy marker
        markers.addLayer(L.marker([-6.780535, 110.859251], { icon: icons['default'] })
            .bindPopup('Belum ada data tanaman'));
    }

    map.addLayer(markers);

    if(markers.getLayers().length) map.fitBounds(markers.getBounds(), {padding:[50,50]});

    // Sidebar toggle fix
    setTimeout(()=>map.invalidateSize(), 500);
    const toggleSidebarBtn = document.getElementById('toggleSidebar');
    if(toggleSidebarBtn) toggleSidebarBtn.addEventListener('click',()=>setTimeout(()=>map.invalidateSize(),400));
});
</script>
@endsection
