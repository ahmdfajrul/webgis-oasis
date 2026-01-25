@extends('layouts.admin')
@section('title','Data Penyakit')

@section('content')

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Data Penyakit</h4>
        <small class="text-muted">
            Total data: {{ count($penyakit) }} penyakit
        </small>
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
                    
                    <!-- Kode Pohon -->
                    <td class="fw-semibold text-muted">{{ $p->tanaman->kode_pohon ?? '-' }}</td>

                    <td class="fw-semibold">{{ $p->tanaman->nama_pohon ?? '-' }}</td>

                    <td class="text-muted fw-semibold">{{ $p->nama_penyakit }}</td>

                    <td class="text-center">
                        @if($p->foto_penyakit)
                            <button class="btn btn-sm btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#fotoPenyakit{{ $p->id }}">
                                <i class="bi bi-image"></i>
                            </button>

                            <!-- MODAL FOTO -->
                            <div class="modal fade" id="fotoPenyakit{{ $p->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $p->nama_penyakit }}</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center bg-light">
                                            <img src="{{ asset('images/'.$p->foto_penyakit) }}"
                                                 class="img-fluid rounded shadow">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="{{ route('admin.penyakit.edit', $p->id) }}"
                           class="btn btn-sm btn-outline-warning me-1">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('admin.penyakit.destroy', $p->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Hapus data penyakit ini?')">
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
        order: [[1, 'asc']] // urut default berdasarkan kolom Kode Pohon
    });
});
</script>
@endpush
