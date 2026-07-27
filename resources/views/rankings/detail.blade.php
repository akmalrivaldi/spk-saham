@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Detail Perhitungan Weighted Product</h2>
    <p class="text-muted mb-0">
        Saham: <strong>{{ $stock->code }} - {{ $stock->name }}</strong><br>
        Periode: <strong>{{ $period->name }} ({{ $period->year }})</strong>
    </p>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <table class="table table-bordered mb-0">
            <tr>
                <th width="25%">Kode Saham</th>
                <td>{{ $stock->code }}</td>
            </tr>
            <tr>
                <th>Nama Saham</th>
                <td>{{ $stock->name }}</td>
            </tr>
            <tr>
                <th>Ranking</th>
                <td>{{ $ranking->rank }}</td>
            </tr>
            <tr>
                <th>Vektor S</th>
                <td>{{ number_format($vectorS, 4) }}</td>
            </tr>
            <tr>
                <th>Jumlah Total S</th>
                <td>{{ number_format($sumS, 4) }}</td>
            </tr>
            <tr>
                <th>Vektor V</th>
                <td>{{ number_format($vectorV, 4) }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-semibold">
        Tabel Detail Perhitungan
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Kriteria</th>
                    <th>Atribut</th>
                    <th>Bobot</th>
                    <th>Bobot Efektif</th>
                    <th>Nilai</th>
                    <th>Hasil \( x^w \)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detailRows as $row)
                    <tr>
                        <td>{{ $row['code'] }}</td>
                        <td>{{ $row['name'] }}</td>
                        <td>
                            @if($row['attribute'] === 'benefit')
                                <span class="badge bg-success">Benefit</span>
                            @else
                                <span class="badge bg-danger">Cost</span>
                            @endif
                        </td>
                        <td>{{ number_format($row['weight'], 4) }}</td>
                        <td>{{ number_format($row['effective_weight'], 4) }}</td>
                        <td>{{ number_format($row['value'], 4) }}</td>
                        <td>{{ number_format($row['powered_value'], 10) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            <h6>Rumus yang digunakan:</h6>
            <p class="mb-1">
                <strong>Vektor S</strong> = hasil perkalian seluruh nilai kriteria yang telah dipangkatkan dengan bobot efektif.
            </p>
            <p class="mb-1">
                <strong>Vektor V</strong> = Vektor S / jumlah seluruh Vektor S.
            </p>
            <p class="mb-0">
                Untuk atribut <strong>cost</strong>, bobot efektif dibuat bernilai negatif.
            </p>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('rankings.show', $period->id) }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection