@extends('layouts.admin')
@section('title','Data Tanaman')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold">Data Tanaman</h4>
    <a href="{{ route('admin.tanaman.create') }}" class="btn btn-success">
        <i class="fa fa-plus"></i> Tambah
    </a>
</div>

<div class="card shadow-sm">
<div class="card-body table-responsive">
<table class="table table-bordered align-middle">
<thead class="table-success">
<tr>
    <th>No</th>
    <th>Kode</th>
    <th>Nama</th>
    <th>Status</th>
    <th>Koordinat</th>
    <th>Foto</th>
    <th width="130">Aksi</th>
</tr>
</thead>
<tbody>
@foreach($tanaman as $i => $t)
<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $t->kode_pohon }}</td>
    <td>{{ $t->nama_pohon }}</td>
    <td>
        <span class="badge bg-{{ $t->status=='sehat'?'success':($t->status=='perhatian'?'warning':'danger') }}">
            {{ ucfirst($t->status) }}
        </span>
    </td>
    <td>{{ $t->latitude }}, {{ $t->longitude }}</td>

    <td>
        @if($t->foto_pohon)
        <button class="btn btn-sm btn-outline-primary"
            data-bs-toggle="modal"
            data-bs-target="#fotoTanaman{{ $t->id }}">
            Lihat
        </button>

        <!-- MODAL -->
        <div class="modal fade" id="fotoTanaman{{ $t->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $t->nama_pohon }}</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('images/'.$t->foto_pohon) }}" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
        @else
            <span class="badge bg-secondary">Tidak ada</span>
        @endif
    </td>

    <td>
        <a href="{{ route('admin.tanaman.edit',$t->id) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.tanaman.destroy',$t->id) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endsection
