@extends('layouts.admin')
@section('title','Data Tanaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Data Tanaman</h4>
        <small class="text-muted">
            Total data: {{ $tanaman->total() }} pohon
        </small>
    </div>

    <a href="{{ route('admin.tanaman.create') }}" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Tanaman
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table id="tanamanTable" class="table table-striped table-hover align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Pohon</th>
                    <th>Status</th>
                    <th>Koordinat</th>
                    <th class="text-center">Foto</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tanaman as $i => $t)
                <tr>
                    <td>{{ $tanaman->firstItem() + $i }}</td>
                    <td class="fw-semibold text-muted">{{ $t->kode_pohon }}</td>
                    <td class="fw-semibold">{{ $t->nama_pohon }}</td>
                    <td>
                        <span class="badge rounded-pill
                            bg-{{ $t->status=='sehat'?'success':($t->status=='perhatian'?'warning':'danger') }}">
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $t->latitude }}, {{ $t->longitude }}</td>
                    <td class="text-center">
                        @if($t->foto_pohon)
                            <button class="btn btn-sm btn-outline-primary foto-btn" 
                                data-foto="{{ asset('images/'.$t->foto_pohon) }}"
                                data-bs-toggle="modal" data-bs-target="#modalFoto">
                                <i class="bi bi-image"></i>
                            </button>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.tanaman.edit',$t->id) }}" class="btn btn-sm btn-outline-warning me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.tanaman.destroy',$t->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $tanaman->links('pagination::bootstrap-5') }}
        </div>
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
    // DataTables
    $('#tanamanTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        language: {
            search: "Cari:",
            zeroRecords: "Data tidak ditemukan",
            paginate: { previous: "‹", next: "›" }
        },
        columnDefs: [{ orderable: false, targets: [5,6] }] // foto & aksi tidak bisa sort
    });

    // Modal Foto Global
    $('.foto-btn').click(function(){
        let foto = $(this).data('foto');
        $('#fotoPreview').attr('src', foto);
    });
});
</script>
@endpush
