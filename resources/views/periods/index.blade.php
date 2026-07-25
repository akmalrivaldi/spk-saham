@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Data Periode</h2>
        <p class="text-muted mb-0">
            @if(auth()->user()->isAdmin())
                Kelola periode penilaian saham.
            @else
                Daftar periode penilaian saham yang tersedia.
            @endif
        </p>
    </div>
    @if(auth()->user()->isAdmin())
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalCreatePeriod">
            <i class="ph-bold ph-plus"></i> Tambah Periode
        </button>
    @endif
</div>

<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Periode</th>
                    <th>Tahun</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    @if(auth()->user()->isAdmin())
                        <th width="20%">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse($periods as $index => $period)
                    <tr>
                        <td>{{ $periods->firstItem() + $index }}</td>
                        <td class="fw-bold">{{ $period->name }}</td>
                        <td>{{ $period->year }}</td>
                        <td>{{ $period->description ?? '-' }}</td>
                        <td>
                            @if($period->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        @if(auth()->user()->isAdmin())
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('periods.show', $period->id) }}" class="btn btn-info btn-sm text-white d-flex align-items-center gap-1" title="Detail">
                                        <i class="ph ph-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-warning btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditPeriod{{ $period->id }}" title="Edit">
                                        <i class="ph ph-pencil-simple"></i>
                                    </button>
                                    <form action="{{ route('periods.destroy', $period->id) }}" method="POST" class="form-delete d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1" title="Hapus">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            
                            <!-- Modal Edit Period -->
                            <div class="modal fade" id="modalEditPeriod{{ $period->id }}" tabindex="-1" aria-labelledby="modalEditPeriodLabel{{ $period->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                        <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                                            <h5 class="modal-title fw-bold" id="modalEditPeriodLabel{{ $period->id }}">Edit Periode</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form action="{{ route('periods.update', $period->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Nama Periode</label>
                                                    <input type="text" name="name" class="form-control" value="{{ old('name', $period->name) }}" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-semibold">Tahun</label>
                                                        <input type="number" name="year" class="form-control" value="{{ old('year', $period->year) }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-semibold">Status Aktif</label>
                                                        <select name="is_active" class="form-select" required>
                                                            <option value="1" {{ old('is_active', $period->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                                            <option value="0" {{ old('is_active', $period->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Deskripsi</label>
                                                    <textarea name="description" rows="3" class="form-control">{{ old('description', $period->description) }}</textarea>
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
                            <!-- End Modal Edit Period -->
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? '6' : '5' }}" class="text-center py-4 text-muted">Belum ada data periode.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $periods->links() }}
        </div>
    </div>
</div>

@if(auth()->user()->isAdmin())
<!-- Modal Create Period -->
<div class="modal fade" id="modalCreatePeriod" tabindex="-1" aria-labelledby="modalCreatePeriodLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalCreatePeriodLabel">Tambah Periode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('periods.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Periode</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Penilaian Tahun 2024" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tahun</label>
                            <input type="number" name="year" class="form-control" value="{{ old('year') }}" placeholder="Contoh: 2024" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status Aktif</label>
                            <select name="is_active" class="form-select" required>
                                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Deskripsi periode (opsional)">{{ old('description') }}</textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="ph-bold ph-plus-circle"></i> Tambah Periode
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Create Period -->
@endif

@endsection