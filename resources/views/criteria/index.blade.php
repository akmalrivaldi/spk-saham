@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Data Kriteria</h2>
        <p class="text-muted mb-0">
            @if(auth()->user()->isAdmin())
                Kelola kriteria dan bobot metode Weighted Product.
            @else
                Daftar kriteria dan bobot yang digunakan dalam metode Weighted Product.
            @endif
        </p>
    </div>
    @if(auth()->user()->isAdmin())
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalCreateCriterion">
            <i class="ph-bold ph-plus"></i> Tambah Kriteria
        </button>
    @endif
</div>

<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Atribut</th>
                    <th>Bobot</th>
                    <th>Deskripsi</th>
                    @if(auth()->user()->isAdmin())
                        <th width="20%">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse($criteria as $index => $criterion)
                    <tr>
                        <td>{{ $criteria->firstItem() + $index }}</td>
                        <td class="fw-bold">{{ $criterion->code }}</td>
                        <td>{{ $criterion->name }}</td>
                        <td>
                            @if($criterion->attribute === 'benefit')
                                <span class="badge bg-success">Benefit</span>
                            @else
                                <span class="badge bg-danger">Cost</span>
                            @endif
                        </td>
                        <td>{{ $criterion->weight }}</td>
                        <td>{{ $criterion->description ?? '-' }}</td>
                        @if(auth()->user()->isAdmin())
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('criteria.show', $criterion->id) }}" class="btn btn-info btn-sm text-white d-flex align-items-center gap-1" title="Detail">
                                        <i class="ph ph-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-warning btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditCriterion{{ $criterion->id }}" title="Edit">
                                        <i class="ph ph-pencil-simple"></i>
                                    </button>
                                    <form action="{{ route('criteria.destroy', $criterion->id) }}" method="POST" class="form-delete d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1" title="Hapus">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            
                            <!-- Modal Edit Criterion -->
                            <div class="modal fade" id="modalEditCriterion{{ $criterion->id }}" tabindex="-1" aria-labelledby="modalEditCriterionLabel{{ $criterion->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                        <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                                            <h5 class="modal-title fw-bold" id="modalEditCriterionLabel{{ $criterion->id }}">Edit Kriteria</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form action="{{ route('criteria.update', $criterion->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-semibold">Kode Kriteria</label>
                                                        <input type="text" name="code" class="form-control" value="{{ old('code', $criterion->code) }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-semibold">Nama Kriteria</label>
                                                        <input type="text" name="name" class="form-control" value="{{ old('name', $criterion->name) }}" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-semibold">Atribut</label>
                                                        <select name="attribute" class="form-select" required>
                                                            <option value="benefit" {{ old('attribute', $criterion->attribute) == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                                            <option value="cost" {{ old('attribute', $criterion->attribute) == 'cost' ? 'selected' : '' }}>Cost</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-semibold">Bobot</label>
                                                        <input type="number" step="0.0001" name="weight" class="form-control" value="{{ old('weight', $criterion->weight) }}" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Deskripsi</label>
                                                    <textarea name="description" rows="3" class="form-control">{{ old('description', $criterion->description) }}</textarea>
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
                            <!-- End Modal Edit Criterion -->
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? '7' : '6' }}" class="text-center py-4 text-muted">Belum ada data kriteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $criteria->links() }}
        </div>
    </div>
</div>

@if(auth()->user()->isAdmin())
<!-- Modal Create Criterion -->
<div class="modal fade" id="modalCreateCriterion" tabindex="-1" aria-labelledby="modalCreateCriterionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalCreateCriterionLabel">Tambah Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('criteria.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kode Kriteria</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="Contoh: C1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Kriteria</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: ROE" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Atribut</label>
                            <select name="attribute" class="form-select" required>
                                <option value="">-- Pilih Atribut --</option>
                                <option value="benefit" {{ old('attribute') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                <option value="cost" {{ old('attribute') == 'cost' ? 'selected' : '' }}>Cost</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Bobot</label>
                            <input type="number" step="0.0001" name="weight" class="form-control" value="{{ old('weight') }}" placeholder="Contoh: 0.2919" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Deskripsi kriteria (opsional)">{{ old('description') }}</textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="ph-bold ph-plus-circle"></i> Tambah Kriteria
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Create Criterion -->
@endif

@endsection