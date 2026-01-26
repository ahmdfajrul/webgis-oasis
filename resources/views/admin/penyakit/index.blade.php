@extends('layouts.admin')
@section('title','Data Penyakit')

@section('content')

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Data Penyakit</h4>
        <small class="text-muted">Total data: {{ $penyakit->count() }} penyakit</small>
    </div>

    <a href="{{ route('admin.penyakit.create') }}" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Penyakit
    </a>
</div>

<!-- TABLE CARD -->
<div class="card shadow-sm border-0">
    <div class="card-body">

        <table id="penyakitTable" class="table table-striped table-hover align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode Pohon</th>
                    <th>Nama Pohon</th>
                    <th>Nama Penyakit</th>
                    <th class="text-center">Foto</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penyakit as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->tanaman->kode_pohon ?? '-' }}</td>
                        <td>{{ $p->tanaman->nama_pohon ?? '-' }}</td>
                        <td>{{ $p->nama_penyakit }}</td>
                        <td class="text-center">
                            @if($p->foto_penyakit)
                                <button class="btn btn-sm btn-outline-primary foto-btn" 
                                    data-foto="{{ asset('images/'.$p->foto_penyakit) }}"
                                    data-bs-toggle="modal" data-bs-target="#modalFoto">
                                    <i class="bi bi-image"></i>
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.penyakit.edit',$p->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.penyakit.destroy',$p->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data penyakit ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<!-- Modal Foto Global -->
<div class="modal fade" id="modalFoto">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center bg-light p-3">
                <img id="fotoPreview" src="" class="img-fluid rounded shadow">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#penyakitTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        language: {
            search: "Cari:",
            zeroRecords: "Data tidak ditemukan",
            paginate: {
                previous: "‹",
                next: "›"
            }
        },
        columnDefs: [
            { orderable: false, targets: [4,5] } // Foto & Aksi tidak bisa di-sort
        ],
        order: [[1, 'asc']] // default urut berdasarkan kolom Kode Pohon
    });

    // Modal foto global
    $('.foto-btn').click(function(){
        let foto = $(this).data('foto');
        $('#fotoPreview').attr('src', foto);
    });
});
</script>
@endpush
