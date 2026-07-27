@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Hasil Simulasi Bobot</h2>
        <p class="text-muted mb-0">
            Periode: <strong>{{ $period->name }} ({{ $period->year }})</strong>
        </p>
    </div>
    <a href="{{ route('simulation.index') }}" class="btn btn-secondary">Simulasi Ulang</a>
</div>

{{-- Card 1: Perbandingan Bobot --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Perbandingan Bobot</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="8%">Kode</th>
                    <th>Kriteria</th>
                    <th width="12%">Atribut</th>
                    <th width="15%">Bobot Asli</th>
                    <th width="15%">Bobot Simulasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($criteria as $criterion)
                    @php
                        $original = $originalWeights[$criterion->id] ?? 0;
                        $simulation = $userWeights[$criterion->id] ?? 0;
                        $isDifferent = abs($original - $simulation) > 0.0001;
                    @endphp
                    <tr class="{{ $isDifferent ? 'table-warning' : '' }}">
                        <td><strong>{{ $criterion->code }}</strong></td>
                        <td>{{ $criterion->name }}</td>
                        <td>
                            @if($criterion->attribute === 'benefit')
                                <span class="badge bg-success">Benefit</span>
                            @else
                                <span class="badge bg-danger">Cost</span>
                            @endif
                        </td>
                        <td>{{ number_format($original, 4) }}</td>
                        <td>
                            <strong>{{ number_format($simulation, 4) }}</strong>
                            @if($isDifferent)
                                @if($simulation > $original)
                                    <span class="text-success ms-1">▲</span>
                                @else
                                    <span class="text-danger ms-1">▼</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Card 2: Perbandingan Ranking --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Perbandingan Ranking</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="10%">Kode Saham</th>
                    <th>Nama Saham</th>
                    <th width="10%">Ranking Asli</th>
                    <th width="15%">Vektor V Asli</th>
                    <th width="10%">Ranking Simulasi</th>
                    <th width="15%">Vektor V Simulasi</th>
                    <th width="12%">Perubahan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comparison as $item)
                    <tr class="{{ $item['sim_rank'] === 1 ? 'table-success' : '' }}">
                        <td>
                            <strong>{{ $item['stock']->code }}</strong>
                        </td>
                        <td>{{ $item['stock']->name }}</td>
                        <td class="text-center">
                            @if($item['original_rank'] !== null)
                                <span class="badge bg-secondary fs-6">#{{ $item['original_rank'] }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($item['original_vector_v'] !== null)
                                {{ number_format($item['original_vector_v'], 4) }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item['sim_rank'] === 1)
                                <span class="badge bg-success fs-6">#{{ $item['sim_rank'] }}</span>
                            @elseif($item['sim_rank'] === 2)
                                <span class="badge bg-primary fs-6">#{{ $item['sim_rank'] }}</span>
                            @elseif($item['sim_rank'] === 3)
                                <span class="badge bg-info text-dark fs-6">#{{ $item['sim_rank'] }}</span>
                            @else
                                <span class="badge bg-secondary fs-6">#{{ $item['sim_rank'] }}</span>
                            @endif
                        </td>
                        <td>{{ number_format($item['sim_vector_v'], 4) }}</td>
                        <td class="text-center">
                            @if($item['rank_change'] === null)
                                <span class="badge bg-secondary">—</span>
                            @elseif($item['rank_change'] > 0)
                                <span class="badge bg-success">↑ {{ $item['rank_change'] }}</span>
                            @elseif($item['rank_change'] < 0)
                                <span class="badge bg-danger">↓ {{ abs($item['rank_change']) }}</span>
                            @else
                                <span class="badge bg-secondary">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="alert alert-info">
    <strong>Catatan:</strong>
    Hasil ini hanya simulasi. Ranking resmi menggunakan bobot yang ditetapkan oleh admin.
</div>

<div class="mb-4">
    <a href="{{ route('simulation.index') }}" class="btn btn-primary">Simulasi Ulang</a>
    <a href="{{ route('rankings.index') }}" class="btn btn-outline-secondary ms-2">Lihat Ranking Resmi</a>
</div>
@endsection
