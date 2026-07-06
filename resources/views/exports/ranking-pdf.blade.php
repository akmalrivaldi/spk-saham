<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Ranking Saham - {{ $period->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
            color: #0d6efd;
        }

        .header h2 {
            font-size: 14px;
            margin: 5px 0 0;
            font-weight: normal;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 3px 10px;
        }

        .info-table .label {
            font-weight: bold;
            width: 150px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.data th,
        table.data td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        table.data th {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
        }

        table.data tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table.data tr:first-child td {
            background-color: #d1e7dd;
            font-weight: bold;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #0d6efd;
            margin: 25px 0 10px;
            border-bottom: 1px solid #0d6efd;
            padding-bottom: 5px;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h1>Laporan Hasil Ranking Saham</h1>
        <h2>Sistem Pendukung Keputusan - Metode Weighted Product</h2>
    </div>

    {{-- Info Section --}}
    <table class="info-table">
        <tr>
            <td class="label">Periode</td>
            <td>: {{ $period->name }} ({{ $period->year }})</td>
        </tr>
        <tr>
            <td class="label">Jumlah Saham</td>
            <td>: {{ $rankings->count() }} saham</td>
        </tr>
        <tr>
            <td class="label">Tanggal Cetak</td>
            <td>: {{ $generatedAt }}</td>
        </tr>
    </table>

    {{-- Ranking Table --}}
    <div class="section-title">Hasil Ranking</div>
    <table class="data">
        <thead>
            <tr>
                <th style="width: 60px;">Ranking</th>
                <th style="width: 80px;">Kode Saham</th>
                <th>Nama Saham</th>
                <th>Emiten</th>
                <th style="width: 120px;">Vektor S</th>
                <th style="width: 120px;">Vektor V</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rankings as $ranking)
                <tr>
                    <td style="text-align: center;">{{ $ranking->rank }}</td>
                    <td>{{ $ranking->stock->code }}</td>
                    <td>{{ $ranking->stock->name }}</td>
                    <td>{{ $ranking->stock->issuer }}</td>
                    <td>{{ number_format($ranking->vector_s, 10) }}</td>
                    <td>{{ number_format($ranking->vector_v, 10) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Criteria Summary --}}
    <div class="section-title">Kriteria yang Digunakan</div>
    <table class="data">
        <thead>
            <tr>
                <th style="width: 80px;">Kode</th>
                <th>Nama Kriteria</th>
                <th style="width: 80px;">Atribut</th>
                <th style="width: 80px;">Bobot</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($criteria as $criterion)
                <tr>
                    <td>{{ $criterion->code }}</td>
                    <td>{{ $criterion->name }}</td>
                    <td style="text-align: center;">{{ ucfirst($criterion->attribute) }}</td>
                    <td style="text-align: center;">{{ $criterion->weight }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <p>Dicetak oleh: {{ $generatedBy }} pada {{ $generatedAt }}</p>
        <p>Dokumen ini dihasilkan secara otomatis oleh SPK Saham Bank</p>
    </div>
</body>
</html>
