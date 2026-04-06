@extends('layouts.app')

@section('content')
<div class="container hero-section">
    <div class="row align-items-center">
        <div class="col-lg-7 mb-4">
            <h1 class="display-5 fw-bold mb-3">
                Sistem Pendukung Keputusan Pemilihan Saham Terbaik
            </h1>
            <p class="lead text-secondary">
                Aplikasi berbasis web untuk membantu proses pemilihan saham terbaik
                menggunakan metode Weighted Product (WP).
            </p>
            <p class="text-muted">
                Kriteria yang digunakan meliputi ROE, PER, PBV, Dividend Yield, dan DER.
            </p>

            <div class="mt-4">
                <a href="#" class="btn btn-primary btn-lg me-2">Mulai</a>
                <a href="#" class="btn btn-outline-secondary btn-lg">Lihat Ranking</a>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0 card-hover">
                <div class="card-body p-4">
                    <h4 class="mb-3">Informasi Sistem</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">Metode: <strong>Weighted Product</strong></li>
                        <li class="list-group-item px-0">Framework: <strong>Laravel 12</strong></li>
                        <li class="list-group-item px-0">Frontend: <strong>Bootstrap CDN</strong></li>
                        <li class="list-group-item px-0">Database: <strong>MySQL (XAMPP)</strong></li>
                        <li class="list-group-item px-0">Pendekatan: <strong>Analisis Fundamental Investasi</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 card-hover">
                <div class="card-body">
                    <h5 class="card-title">Data Saham</h5>
                    <p class="card-text text-muted">
                        Mengelola daftar saham yang menjadi alternatif penilaian.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 card-hover">
                <div class="card-body">
                    <h5 class="card-title">Kriteria & Bobot</h5>
                    <p class="card-text text-muted">
                        Mengelola kriteria fundamental dan bobot yang digunakan dalam metode WP.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 card-hover">
                <div class="card-body">
                    <h5 class="card-title">Ranking Saham</h5>
                    <p class="card-text text-muted">
                        Menampilkan hasil perhitungan dan perangkingan saham terbaik.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection