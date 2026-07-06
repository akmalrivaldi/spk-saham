@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Dashboard</h2>
        <p class="text-muted mb-0">Selamat datang di Sistem Pendukung Keputusan Pemilihan Saham Terbaik.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Periode</h6>
                <h2 class="fw-bold">{{ $totalPeriods }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Ranking Tersedia</h6>
                <h2 class="fw-bold">{{ $totalRankings }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Kriteria</h6>
                <h2 class="fw-bold">{{ $totalCriteria }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">Akses Cepat</div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('rankings.index') }}" class="btn btn-primary">
                        📊 Lihat Hasil Ranking Saham
                    </a>
                    <a href="{{ route('simulation.index') }}" class="btn btn-outline-primary">
                        🔬 Simulasi Bobot Kriteria
                    </a>
                    <a href="{{ route('criteria.index') }}" class="btn btn-outline-secondary">
                        📋 Lihat Data Kriteria & Bobot
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">Periode dengan Ranking</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($periodsWithRanking as $period)
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $period->name }}</strong>
                                <br>
                                <small class="text-muted">Tahun {{ $period->year }} &middot; {{ $period->rankings_count }} saham</small>
                            </div>
                            <a href="{{ route('rankings.show', $period->id) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
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
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">Kriteria Penilaian</div>
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
</div>
@endsection
