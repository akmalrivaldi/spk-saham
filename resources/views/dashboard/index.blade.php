@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Dashboard</h2>
        <p class="text-muted mb-0">Ringkasan data sistem pendukung keputusan saham perbankan.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Saham</h6>
                <h2 class="fw-bold">{{ $totalStocks }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Kriteria</h6>
                <h2 class="fw-bold">{{ $totalCriteria }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Periode</h6>
                <h2 class="fw-bold">{{ $totalPeriods }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Ranking</h6>
                <h2 class="fw-bold">{{ $totalRankings }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Data Penilaian</h6>
                <h2 class="fw-bold">{{ $totalStockValues }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total User</h6>
                <h2 class="fw-bold">{{ $totalUsers }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">User Menunggu Persetujuan</h6>
                <h2 class="fw-bold {{ $pendingUsers > 0 ? 'text-warning' : '' }}">{{ $pendingUsers }}</h2>
                @if($pendingUsers > 0)
                    <a href="{{ route('admin.users.index') }}" class="small text-decoration-none">Lihat &rarr;</a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">Kriteria Aktif</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($latestCriteria as $criterion)
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $criterion->code }}</strong> - {{ $criterion->name }}
                                <br>
                                <small class="text-muted">{{ ucfirst($criterion->attribute) }}</small>
                            </div>
                            <span class="badge bg-primary">{{ $criterion->weight }}</span>
                        </li>
                    @empty
                        <li class="list-group-item px-0">Belum ada data kriteria.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">Saham Terbaru</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($latestStocks as $stock)
                        <li class="list-group-item px-0">
                            <strong>{{ $stock->code }}</strong> - {{ $stock->name }}
                            <br>
                            <small class="text-muted">{{ $stock->issuer }}</small>
                        </li>
                    @empty
                        <li class="list-group-item px-0">Belum ada data saham.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">Periode Terbaru</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($latestPeriods as $period)
                        <li class="list-group-item px-0">
                            <strong>{{ $period->name }}</strong>
                            <br>
                            <small class="text-muted">Tahun {{ $period->year }}</small>
                        </li>
                    @empty
                        <li class="list-group-item px-0">Belum ada data periode.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection