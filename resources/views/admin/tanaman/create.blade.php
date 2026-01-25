@extends('layouts.admin')
@section('title', 'Tambah Tanaman')

@section('content')
<h4 class="fw-bold mb-3">Tambah Tanaman</h4>

<style>
.coord-warning {
    display: none;
    margin-top: 4px;
    font-size: 0.8rem;
    color: #dc2626;
    font-weight: 500;
}

/* TOMBOL MAP */
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
}
.open-map-btn:hover {
    background: #166534;
}
</style>

<div class="card shadow-sm">
<div class="card-body">

<form method="POST"
      action="{{ route('admin.tanaman.store') }}"
      enctype="multipart/form-data"
      id="formTanaman">
@csrf

<div class="row g-3">

    <!-- KODE POHON -->
    <div class="col-md-6 position-relative">
        <label class="form-label">Kode Pohon *</label>
        <input type="text"
               name="kode_pohon"
               id="kode_pohon"
               class="form-control"
               required>

        <small class="coord-warning" id="kodeAlert">
            ⚠️ Kode pohon sudah digunakan
        </small>
    </div>

    <div class="col-md-6">
        <label class="form-label">Nama Pohon *</label>
        <input type="text" name="nama_pohon" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Nama Latin</label>
        <input type="text" name="nama_latin" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Tahun Tanam *</label>
        <input type="number" name="tahun_tanam" class="form-control" required>
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
            <option value="sehat">Sehat</option>
            <option value="perhatian">Perhatian</option>
            <option value="sakit">Sakit</option>
        </select>
    </div>

    <!-- LATITUDE -->
    <div class="col-md-4 position-relative">
        <label class="form-label">Latitude *</label>
        <input type="number" step="any"
               name="latitude" id="latitude"
               class="form-control" required>

        <small class="coord-warning" id="coordAlert">
            ⚠️ Latitude atau Longitude tidak valid
        </small>
    </div>

    <!-- LONGITUDE -->
    <div class="col-md-4 position-relative">
        <label class="form-label">Longitude *</label>
        <input type="number" step="any"
               name="longitude" id="longitude"
               class="form-control pe-5" required>

        <button type="button"
                class="open-map-btn"
                data-bs-toggle="modal"
                data-bs-target="#mapModal">
            🗺️
        </button>
    </div>

    <div class="col-md-12">
        <label class="form-label">Foto Pohon *</label>
        <input type="file" name="foto_pohon"
               class="form-control" required>
    </div>
</div>

<div class="mt-4">
    <button type="submit"
            class="btn btn-success"
            id="btnSubmit">
        Simpan Tanaman
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
const form = document.getElementById('formTanaman');
const btnSubmit = document.getElementById('btnSubmit');

const latitude = document.getElementById('latitude');
const longitude = document.getElementById('longitude');
const coordAlert = document.getElementById('coordAlert');

const kodePohon = document.getElementById('kode_pohon');
const kodeAlert = document.getElementById('kodeAlert');

let kodeValid = true;

/* ===== VALIDASI KOORDINAT ===== */
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
    } else {
        coordAlert.style.display = 'none';
        btnSubmit.disabled = false;
        return true;
    }
}

latitude.addEventListener('input', checkCoord);
longitude.addEventListener('input', checkCoord);

/* ===== CEK KODE POHON ===== */
let debounce;
kodePohon.addEventListener('input', () => {
    clearTimeout(debounce);

    debounce = setTimeout(() => {
        const kode = kodePohon.value.trim();

        if (kode.length < 2) {
            kodeAlert.style.display = 'none';
            kodeValid = true;
            btnSubmit.disabled = false;
            return;
        }

        fetch(`{{ route('admin.tanaman.cekKode') }}?kode=${kode}`)
            .then(res => res.json())
            .then(data => {
                if (data.exists) {
                    kodeAlert.style.display = 'block';
                    kodeValid = false;
                    btnSubmit.disabled = true;
                } else {
                    kodeAlert.style.display = 'none';
                    kodeValid = true;
                    btnSubmit.disabled = false;
                }
            });
    }, 400);
});

/* ===== SAAT SUBMIT ===== */
form.addEventListener('submit', function (e) {
    if (!checkCoord()) coordAlert.style.display = 'block';
    if (!kodeValid) kodeAlert.style.display = 'block';

    if (!checkCoord() || !kodeValid) {
        e.preventDefault();
    }
});

/* ===== MAP ===== */
let map, marker;
document.getElementById('mapModal').addEventListener('shown.bs.modal', () => {
    if (!map) {
        map = L.map('map').setView([-6.78, 110.86], 16);

        L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            { maxZoom: 18 }
        ).addTo(map);

        map.on('click', e => {
            latitude.value = e.latlng.lat.toFixed(6);
            longitude.value = e.latlng.lng.toFixed(6);
            checkCoord();

            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
        });
    }
    setTimeout(() => map.invalidateSize(), 300);
});
</script>
@endsection
