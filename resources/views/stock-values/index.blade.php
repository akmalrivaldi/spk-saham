@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Data Penilaian Saham</h2>
        <p class="text-muted mb-0">Kelola nilai setiap saham berdasarkan kriteria dan periode.</p>
    </div>
    <a href="{{ route('stock-values.create') }}" class="btn btn-primary">Tambah Penilaian</a>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('stock-values.index') }}">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Filter Periode</label>
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
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Saham</th>
                    <th>Periode</th>
                    <th>ROE</th>
                    <th>PER</th>
                    <th>PBV</th>
                    <th>Dividend Yield</th>
                    <th>DER</th>
                    <th width="22%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groupedValues as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $row['stock']->code }}</strong><br>
                            <small class="text-muted">{{ $row['stock']->name }}</small>
                        </td>
                        <td>{{ $row['period']->year }}</td>
                        <td>{{ $row['values']['ROE'] ?? '-' }}</td>
                        <td>{{ $row['values']['PER'] ?? '-' }}</td>
                        <td>{{ $row['values']['PBV'] ?? '-' }}</td>
                        <td>{{ $row['values']['Dividend Yield'] ?? '-' }}</td>
                        <td>{{ $row['values']['DER'] ?? '-' }}</td>
                        <td>
                            <a href="{{ route('stock-values.show', [$row['stock']->id, $row['period']->id]) }}" class="btn btn-info btn-sm text-white">Detail</a>
                            <a href="{{ route('stock-values.edit', [$row['stock']->id, $row['period']->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('stock-values.destroy', [$row['stock']->id, $row['period']->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data penilaian ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data penilaian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection