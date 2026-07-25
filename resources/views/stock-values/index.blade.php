@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Data Penilaian Saham</h2>
        <p class="text-muted mb-0">Kelola nilai setiap saham berdasarkan kriteria dan periode.</p>
    </div>
    @if(auth()->user()->isAdmin())
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalCreateStockValue">
            <i class="ph-bold ph-plus"></i> Tambah Penilaian
        </button>
    @endif
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('stock-values.index') }}">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Filter Periode</label>
                    <select name="period_id" class="form-select">
                        <option value="">-- Semua Periode --</option>
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ (string)$selectedPeriod === (string)$period->id ? 'selected' : '' }}>
                                {{ $period->name }} ({{ $period->year }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('stock-values.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Saham</th>
                    <th>Periode</th>
                    @foreach($criteria as $criterion)
                        <th>{{ $criterion->code }}</th>
                    @endforeach
                    @if(auth()->user()->isAdmin())
                        <th width="15%">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse($groupedValues as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong class="fw-bold">{{ $row['stock']->code }}</strong><br>
                            <small class="text-muted">{{ $row['stock']->name }}</small>
                        </td>
                        <td>{{ $row['period']->year }}</td>
                        @foreach($criteria as $criterion)
                            <td>{{ $row['values'][$criterion->name] ?? '-' }}</td>
                        @endforeach
                        @if(auth()->user()->isAdmin())
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-warning btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditStockValue_{{ $row['stock']->id }}_{{ $row['period']->id }}" title="Edit">
                                        <i class="ph ph-pencil-simple"></i>
                                    </button>
                                    <form action="{{ route('stock-values.destroy', [$row['stock']->id, $row['period']->id]) }}" method="POST" class="form-delete d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1" title="Hapus">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            
                            <!-- Modal Edit Stock Value -->
                            <div class="modal fade" id="modalEditStockValue_{{ $row['stock']->id }}_{{ $row['period']->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                        <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                                            <h5 class="modal-title fw-bold">Edit Penilaian Saham</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form action="{{ route('stock-values.update', [$row['stock']->id, $row['period']->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Saham</label>
                                                        <input type="text" class="form-control bg-light" value="{{ $row['stock']->code }} - {{ $row['stock']->name }}" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Periode</label>
                                                        <input type="text" class="form-control bg-light" value="{{ $row['period']->name }} ({{ $row['period']->year }})" readonly>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    @foreach($criteria as $criterion)
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-semibold">
                                                                {{ $criterion->code }} - {{ $criterion->name }}
                                                                <span class="badge {{ $criterion->attribute === 'benefit' ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ ucfirst($criterion->attribute) }}
                                                                </span>
                                                            </label>
                                                            <input
                                                                type="number"
                                                                step="0.0001"
                                                                name="values[{{ $criterion->id }}]"
                                                                class="form-control"
                                                                value="{{ old('values.' . $criterion->id, $row['original_values'][$criterion->id] ?? '') }}"
                                                                required
                                                            >
                                                        </div>
                                                    @endforeach
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
                            <!-- End Modal Edit Stock Value -->
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? (count($criteria) + 4) : (count($criteria) + 3) }}" class="text-center py-4 text-muted">Belum ada data penilaian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(auth()->user()->isAdmin())
<!-- Modal Create Stock Value -->
<div class="modal fade" id="modalCreateStockValue" tabindex="-1" aria-labelledby="modalCreateStockValueLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalCreateStockValueLabel">Tambah Penilaian Saham</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('stock-values.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Pilih Saham</label>
                            <select name="stock_id" class="form-select" required>
                                <option value="">-- Pilih Saham --</option>
                                @foreach($stocks as $stock)
                                    <option value="{{ $stock->id }}" {{ old('stock_id') == $stock->id ? 'selected' : '' }}>
                                        {{ $stock->code }} - {{ $stock->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Pilih Periode</label>
                            <select name="period_id" class="form-select" required>
                                <option value="">-- Pilih Periode --</option>
                                @foreach($periods as $period)
                                    <option value="{{ $period->id }}" {{ old('period_id') == $period->id ? 'selected' : '' }}>
                                        {{ $period->name }} ({{ $period->year }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        @foreach($criteria as $criterion)
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    {{ $criterion->code }} - {{ $criterion->name }}
                                    <span class="badge {{ $criterion->attribute === 'benefit' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($criterion->attribute) }}
                                    </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.0001"
                                    name="values[{{ $criterion->id }}]"
                                    class="form-control"
                                    value="{{ old('values.' . $criterion->id) }}"
                                    placeholder="Masukkan nilai {{ $criterion->name }}"
                                    required
                                >
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="ph-bold ph-plus-circle"></i> Tambah Penilaian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Create Stock Value -->
@endif

@endsection