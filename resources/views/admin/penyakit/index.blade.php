@extends('layouts.admin')
@section('title','Data Penyakit')

@section('content')
<div class="d-flex justify-content-between mb-3">
<h4 class="fw-bold">Data Penyakit</h4>
<a href="{{ route('admin.penyakit.create') }}" class="btn btn-success">
<i class="fa fa-plus"></i> Tambah
</a>
</div>

<div class="card shadow-sm">
<div class="card-body table-responsive">
<table class="table table-bordered">
<thead class="table-success">
<tr>
<th>No</th>
<th>Tanaman</th>
<th>Penyakit</th>
<th>Foto</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach($penyakit as $i => $p)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $p->tanaman->nama_pohon }}</td>
<td>{{ $p->nama_penyakit }}</td>
<td>
@if($p->foto_penyakit)
<button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
 data-bs-target="#fotoPenyakit{{ $p->id }}">Lihat</button>

<div class="modal fade" id="fotoPenyakit{{ $p->id }}">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<img src="{{ asset('images/'.$p->foto_penyakit) }}" class="img-fluid rounded">
</div>
</div>
</div>
@else
<span class="badge bg-secondary">Tidak ada</span>
@endif
</td>
<td>
    <a href="{{ route('admin.penyakit.edit', $p->id) }}"
       class="btn btn-sm btn-warning">
        Edit
    </a>

    <form action="{{ route('admin.penyakit.destroy', $p->id) }}"
          method="POST"
          class="d-inline">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger"
                onclick="return confirm('Hapus data penyakit ini?')">
            Hapus
        </button>
    </form>
</td>

</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endsection
