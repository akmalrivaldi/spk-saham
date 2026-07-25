@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Data Saham</h2>
        <p class="text-muted mb-0">Kelola data saham subsektor perbankan.</p>
    </div>
    <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalCreateStock">
        <i class="ph-bold ph-plus"></i> Tambah Saham
    </button>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Kode</th>
                    <th>Nama Saham</th>
                    <th>Emiten</th>
                    <th>Subsektor</th>
                    <th>Status</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse($stocks as $index => $stock)
                    <tr>
                        <td>{{ $stocks->firstItem() + $index }}</td>
                        <td class="fw-bold">{{ $stock->code }}</td>
                        <td>{{ $stock->name }}</td>
                        <td>{{ $stock->issuer }}</td>
                        <td>{{ $stock->subsector }}</td>
                        <td>
                            @if($stock->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('stocks.show', $stock->id) }}" class="btn btn-info btn-sm text-white d-flex align-items-center gap-1" title="Detail">
                                    <i class="ph ph-eye"></i>
                                </a>
                                <button type="button" class="btn btn-warning btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditStock{{ $stock->id }}" title="Edit">
                                    <i class="ph ph-pencil-simple"></i>
                                </button>
                                <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" class="form-delete d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1" title="Hapus">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Modal Edit Stock -->
                    <div class="modal fade" id="modalEditStock{{ $stock->id }}" tabindex="-1" aria-labelledby="modalEditStockLabel{{ $stock->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                                    <h5 class="modal-title fw-bold" id="modalEditStockLabel{{ $stock->id }}">Edit Data Saham</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('stocks.update', $stock->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Kode Saham</label>
                                                <input type="text" name="code" class="form-control" value="{{ old('code', $stock->code) }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Nama Saham</label>
                                                <input type="text" name="name" class="form-control" value="{{ old('name', $stock->name) }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Emiten</label>
                                            <input type="text" name="issuer" class="form-control" value="{{ old('issuer', $stock->issuer) }}" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Subsektor</label>
                                                <input type="text" name="subsector" class="form-control" value="{{ old('subsector', $stock->subsector) }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Status Aktif</label>
                                                <select name="is_active" class="form-select" required>
                                                    <option value="1" {{ old('is_active', $stock->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                                    <option value="0" {{ old('is_active', $stock->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end gap-2 mt-4">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                                                <i class="ph-bold ph-floppy-disk"></i> Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Edit Stock -->
                    
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data saham.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $stocks->links() }}
        </div>
    </div>
</div>

<!-- Modal Create Stock -->
<div class="modal fade" id="modalCreateStock" tabindex="-1" aria-labelledby="modalCreateStockLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalCreateStockLabel">Tambah Data Saham</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('stocks.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kode Saham</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="Contoh: BBCA" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Saham</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Bank Central Asia" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Emiten</label>
                        <input type="text" name="issuer" class="form-control" value="{{ old('issuer') }}" placeholder="Contoh: PT Bank Central Asia Tbk" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Subsektor</label>
                            <input type="text" name="subsector" class="form-control" value="{{ old('subsector', 'Perbankan') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status Aktif</label>
                            <select name="is_active" class="form-select" required>
                                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="ph-bold ph-plus-circle"></i> Tambah Saham
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Create Stock -->

@endsection