@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Detail Penilaian Saham</h2>
    <p class="text-muted mb-0">
        Detail nilai saham <strong>{{ $stock->code }} - {{ $stock->name }}</strong> pada periode <strong>{{ $period->year }}</strong>.
    </p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="mb-3">
            <table class="table table-bordered">
                <tr>
                    <th width="25%">Kode Saham</th>
                    <td>{{ $stock->code }}</td>
                </tr>
                <tr>
                    <th>Nama Saham</th>
                    <td>{{ $stock->name }}</td>
                </tr>
                <tr>
                    <th>Emiten</th>
                    <td>{{ $stock->issuer }}</td>
                </tr>
                <tr>
                    <th>Periode</th>
                    <td>{{ $period->name }} ({{ $period->year }})</td>
                </tr>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="10%">Kode</th>
                        <th>Nama Kriteria</th>
                        <th width="15%">Atribut</th>
                        <th width="20%">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($values as $value)
                        <tr>
                            <td>{{ $value->criterion->code }}</td>
                            <td>{{ $value->criterion->name }}</td>
                            <td>
                                @if($value->criterion->attribute === 'benefit')
                                    <span class="badge bg-success">Benefit</span>
                                @else
                                    <span class="badge bg-danger">Cost</span>
                                @endif
                            </td>
                            <td>{{ $value->value }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data penilaian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('stock-values.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('stock-values.edit', [$stock->id, $period->id]) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection