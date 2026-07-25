@extends('layouts.app')

@section('content')
<div class="page-title-box d-flex justify-content-between align-items-center">
    <div>
        <h2>Dashboard</h2>
        <p>Selamat datang di Sistem Pendukung Keputusan Pemilihan Saham Terbaik.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
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

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body card-stat">
                <div class="stat-icon warning">
                    <i class="ph-fill ph-trophy"></i>
                </div>
                <div class="stat-details">
                    <h6>Total Ranking Tersedia</h6>
                    <h2>{{ $totalRankings }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
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
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="ph-fill ph-rocket-launch text-primary"></i> Akses Cepat
            </div>
            <div class="card-body pt-3">
                <div class="d-grid gap-3">
                    <a href="{{ route('rankings.index') }}" class="btn btn-primary d-flex align-items-center justify-content-center gap-2 py-3">
                        <i class="ph-fill ph-chart-bar fs-4"></i> Lihat Hasil Ranking Saham
                    </a>
                    <a href="{{ route('simulation.index') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center gap-2 py-3" style="border-width: 2px;">
                        <i class="ph-fill ph-flask fs-4"></i> Simulasi Bobot Kriteria
                    </a>
                    <a href="{{ route('criteria.index') }}" class="btn btn-light d-flex align-items-center justify-content-center gap-2 py-3 border">
                        <i class="ph-fill ph-clipboard-text fs-4 text-muted"></i> Lihat Data Kriteria & Bobot
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="ph-fill ph-calendar-check text-success"></i> Periode dengan Ranking
            </div>
            <div class="card-body pt-2">
                <ul class="list-group list-group-flush">
                    @forelse($periodsWithRanking as $period)
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-dark">{{ $period->name }}</span>
                                <div class="text-muted small mt-1">
                                    <i class="ph-fill ph-clock me-1"></i>Tahun {{ $period->year }} &middot; 
                                    <i class="ph-fill ph-chart-line-up ms-1 me-1"></i>{{ $period->rankings_count }} saham
                                </div>
                            </div>
                            <a href="{{ route('rankings.show', $period->id) }}" class="btn btn-sm btn-light border d-flex align-items-center gap-1">
                                <i class="ph ph-eye"></i> Lihat
                            </a>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-muted">Belum ada hasil ranking yang tersedia.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-12">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="ph-fill ph-list-numbers text-info"></i> Kriteria Penilaian
            </div>
            <div class="card-body pt-2">
                <div class="row">
                    @forelse($latestCriteria as $criterion)
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-center">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="fw-bold text-dark">{{ $criterion->code }}</span>
                                    <span class="badge bg-primary">Bobot: {{ $criterion->weight }}</span>
                                </div>
                                <div class="text-dark fw-semibold">{{ $criterion->name }}</div>
                                <div class="text-muted small mt-1"><i class="ph-fill ph-info me-1"></i>Sifat: {{ ucfirst($criterion->attribute) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-muted">Belum ada data kriteria.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
