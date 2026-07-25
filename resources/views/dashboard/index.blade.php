@extends('layouts.app')

@section('content')
<div class="page-title-box d-flex justify-content-between align-items-center">
    <div>
        <h2>Dashboard</h2>
        <p>Ringkasan data sistem pendukung keputusan saham perbankan.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body card-stat">
                <div class="stat-icon primary">
                    <i class="ph-fill ph-buildings"></i>
                </div>
                <div class="stat-details">
                    <h6>Total Saham</h6>
                    <h2>{{ $totalStocks }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body card-stat">
                <div class="stat-icon info">
                    <i class="ph-fill ph-list-numbers"></i>
                </div>
                <div class="stat-details">
                    <h6>Total Kriteria</h6>
                    <h2>{{ $totalCriteria }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body card-stat">
                <div class="stat-icon success">
                    <i class="ph-fill ph-calendar-blank"></i>
                </div>
                <div class="stat-details">
                    <h6>Total Periode</h6>
                    <h2>{{ $totalPeriods }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body card-stat">
                <div class="stat-icon warning">
                    <i class="ph-fill ph-trophy"></i>
                </div>
                <div class="stat-details">
                    <h6>Total Ranking</h6>
                    <h2>{{ $totalRankings }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body card-stat">
                <div class="stat-icon primary">
                    <i class="ph-fill ph-exam"></i>
                </div>
                <div class="stat-details">
                    <h6>Total Data Penilaian</h6>
                    <h2>{{ $totalStockValues }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body card-stat">
                <div class="stat-icon info">
                    <i class="ph-fill ph-users"></i>
                </div>
                <div class="stat-details">
                    <h6>Total User</h6>
                    <h2>{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 {{ $pendingUsers > 0 ? 'border-warning' : '' }}">
            <div class="card-body card-stat">
                <div class="stat-icon {{ $pendingUsers > 0 ? 'danger' : 'success' }}">
                    <i class="ph-fill ph-user-circle-plus"></i>
                </div>
                <div class="stat-details">
                    <h6 class="{{ $pendingUsers > 0 ? 'text-danger fw-bold' : '' }}">Menunggu Persetujuan</h6>
                    <div class="d-flex align-items-baseline gap-2">
                        <h2 class="{{ $pendingUsers > 0 ? 'text-danger' : '' }}">{{ $pendingUsers }}</h2>
                        @if($pendingUsers > 0)
                            <a href="{{ route('admin.users.index') }}" class="text-danger small text-decoration-none fw-semibold">Lihat &rarr;</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="ph-fill ph-list-numbers text-primary"></i> Kriteria Aktif
            </div>
            <div class="card-body pt-2">
                <ul class="list-group list-group-flush">
                    @forelse($latestCriteria as $criterion)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <span class="fw-bold text-dark">{{ $criterion->code }}</span> - {{ $criterion->name }}
                                <div class="text-muted small mt-1">Sifat: {{ ucfirst($criterion->attribute) }}</div>
                            </div>
                            <span class="badge bg-primary">Bobot: {{ $criterion->weight }}</span>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-muted">Belum ada data kriteria.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="ph-fill ph-buildings text-info"></i> Saham Terbaru
            </div>
            <div class="card-body pt-2">
                <ul class="list-group list-group-flush">
                    @forelse($latestStocks as $stock)
                        <li class="list-group-item px-0">
                            <span class="fw-bold text-dark">{{ $stock->code }}</span> - {{ $stock->name }}
                            <div class="text-muted small mt-1"><i class="ph-fill ph-bank me-1"></i>{{ $stock->issuer }}</div>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-muted">Belum ada data saham.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="ph-fill ph-calendar-blank text-success"></i> Periode Terbaru
            </div>
            <div class="card-body pt-2">
                <ul class="list-group list-group-flush">
                    @forelse($latestPeriods as $period)
                        <li class="list-group-item px-0">
                            <div class="fw-bold text-dark">{{ $period->name }}</div>
                            <div class="text-muted small mt-1"><i class="ph-fill ph-clock me-1"></i>Tahun {{ $period->year }}</div>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-muted">Belum ada data periode.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection