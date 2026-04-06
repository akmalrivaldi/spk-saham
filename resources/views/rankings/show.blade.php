@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Hasil Ranking Saham</h2>
        <p class="text-muted mb-0">
            Periode: <strong>{{ $period->name }} ({{ $period->year }})</strong>
        </p>
    </div>
    <a href="{{ route('rankings.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        @if($rankings->count() > 0)
            <h5 class="mb-3">Saham Terbaik</h5>
            <div class="alert alert-success mb-0">
                <strong>Peringkat 1:</strong>
                {{ $rankings->first()->stock->code }} - {{ $rankings->first()->stock->name }}
                dengan nilai preferensi <strong>{{ number_format($rankings->first()->vector_v, 10) }}</strong>
            </div>
        @endif
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th width="10%">Ranking</th>
                    <th>Kode Saham</th>
                    <th>Nama Saham</th>
                    <th>Vektor S</th>
                    <th>Vektor V</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rankings as $ranking)
                    <tr>
                        <td>
                            @if($ranking->rank == 1)
                                <span class="badge bg-success fs-6">#{{ $ranking->rank }}</span>
                            @elseif($ranking->rank == 2)
                                <span class="badge bg-primary fs-6">#{{ $ranking->rank }}</span>
                            @elseif($ranking->rank == 3)
                                <span class="badge bg-info text-dark fs-6">#{{ $ranking->rank }}</span>
                            @else
                                <span class="badge bg-secondary fs-6">#{{ $ranking->rank }}</span>
                            @endif
                        </td>
                        <td>{{ $ranking->stock->code }}</td>
                        <td>{{ $ranking->stock->name }}</td>
                        <td>{{ number_format($ranking->vector_s, 10) }}</td>
                        <td>{{ number_format($ranking->vector_v, 10) }}</td>
                        <td>
                            <a href="{{ route('rankings.detail', [$period->id, $ranking->stock->id]) }}" class="btn btn-info btn-sm text-white">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada hasil ranking.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection