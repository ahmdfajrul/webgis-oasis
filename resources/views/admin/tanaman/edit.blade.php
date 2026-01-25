@extends('layouts.admin')
@section('title', 'Edit Tanaman')

@section('content')
<h4 class="fw-bold mb-3">Edit Tanaman</h4>

<style>
.coord-warning {
    position: absolute;
    bottom: -18px;
    left: 0;
    font-size: 0.8rem;
    color: #dc2626;
    display: none;
}

.open-map-btn {
    position: absolute;
    right: 8px;
    bottom: 8px;
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    background: #15803d;
    color: #fff;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
}
.open-map-btn:hover {
    background: #166534;
}
</style>

<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.tanaman.update', $tanaman->id) }}"
              enctype="multipart/form-data"
              id="formTanaman">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Kode Pohon *</label>
                    <input type="text"
                           name="kode_pohon"
                           class="form-control"
                           value="{{ old('kode_pohon', $tanaman->kode_pohon) }}"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Pohon *</label>
                    <input type="text"
                           name="nama_pohon"
                           class="form-control"
                           value="{{ old('nama_pohon', $tanaman->nama_pohon) }}"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Latin</label>
                    <input type="text"
                           name="nama_latin"
                           class="form-control"
                           value="{{ old('nama_latin', $tanaman->nama_latin) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tahun Tanam *</label>
                    <input type="number"
                           name="tahun_tanam"
                           class="form-control"
                           value="{{ old('tahun_tanam', $tanaman->tahun_tanam) }}"
                           required>
                </div>

                <div class="col-md-12">
    <label class="form-label">Deskripsi Tanaman</label>
    <textarea name="deskripsi"
              class="form-control"
              rows="4"
              placeholder="Tuliskan deskripsi tanaman...">{{ old('deskripsi', $tanaman->deskripsi ?? '') }}</textarea>
</div>


                <div class="col-md-4">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="sehat" {{ $tanaman->status == 'sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="perhatian" {{ $tanaman->status == 'perhatian' ? 'selected' : '' }}>Perhatian</option>
                        <option value="sakit" {{ $tanaman->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                </div>

                <!-- LATITUDE -->
                <div class="col-md-4">
                    <label class="form-label">Latitude *</label>
                    <input type="number" step="any"
                           name="latitude" id="latitude"
                           class="form-control"
                           value="{{ old('latitude', $tanaman->latitude) }}"
                           required>
                           <div class="coord-warning" id="coordAlert">
                        ⚠️ Latitude atau Longitude tidak valid
                    </div>
                </div>

                <!-- LONGITUDE + ALERT + MAP -->
                <div class="col-md-4 position-relative">
                    <label class="form-label">Longitude *</label>
                    <input type="number" step="any"
                           name="longitude" id="longitude"
                           class="form-control pe-5"
                           value="{{ old('longitude', $tanaman->longitude) }}"
                           required>

                    <button type="button"
                            class="open-map-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#mapModal"
                            title="Pilih dari map">
                        🗺️
                    </button>

                    <div class="coord-warning" id="coordAlert">
                        ⚠️ Latitude atau Longitude tidak valid
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Foto Pohon</label>
                    <input type="file" name="foto_pohon" class="form-control">
                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti foto
                    </small>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit"
                        class="btn btn-success"
                        id="btnSubmit">
                    Update Tanaman
                </button>
                <a href="{{ route('admin.tanaman.index') }}"
                   class="btn btn-secondary ms-2">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<!-- MODAL MAP -->
<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Pilih Lokasi Tanaman</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="height:500px">
                <div id="map" style="height:100%"></div>
            </div>
        </div>
    </div>
</div>

{{-- LEAFLET --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
let map, marker;
const latitude = document.getElementById('latitude');
const longitude = document.getElementById('longitude');
const coordAlert = document.getElementById('coordAlert');
const btnSubmit = document.getElementById('btnSubmit');

function validCoord(lat, lng) {
    return lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180;
}

function checkCoord() {
    const lat = parseFloat(latitude.value);
    const lng = parseFloat(longitude.value);

    if (isNaN(lat) || isNaN(lng) || !validCoord(lat, lng)) {
        coordAlert.style.display = 'block';
        btnSubmit.disabled = true;
        return false;
    }

    coordAlert.style.display = 'none';
    btnSubmit.disabled = false;
    return true;
}

latitude.addEventListener('input', checkCoord);
longitude.addEventListener('input', checkCoord);

document.getElementById('formTanaman').addEventListener('submit', function (e) {
    if (!checkCoord()) {
        e.preventDefault();
        latitude.focus();
    }
});

document.getElementById('mapModal').addEventListener('shown.bs.modal', () => {
    if (!map) {
        const latInit = parseFloat(latitude.value) || -6.78;
        const lngInit = parseFloat(longitude.value) || 110.86;

        map = L.map('map').setView([latInit, lngInit], 16);

        L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            {
                maxZoom: 18,
                maxNativeZoom: 18,
                attribution: '© Esri'
            }
        ).addTo(map);

        marker = L.marker([latInit, lngInit]).addTo(map);

        map.on('click', e => {
            const { lat, lng } = e.latlng;

            latitude.value = lat.toFixed(6);
            longitude.value = lng.toFixed(6);
            checkCoord();

            marker.setLatLng([lat, lng]);
        });
    }
    setTimeout(() => map.invalidateSize(), 300);
});
</script>
@endsection
