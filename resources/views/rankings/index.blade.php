@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Data Ranking</h2>
    <p class="text-muted mb-0">
        Daftar hasil perankingan saham berdasarkan periode penilaian.
    </p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Periode</th>
                    <th>Tahun</th>
                    <th>Jumlah Ranking</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($periods as $index => $period)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $period->name }}</td>
                        <td>{{ $period->year }}</td>
                        <td>{{ $period->rankings_count }}</td>
                        <td>
                            @if($period->rankings_count > 0)
                                <a href="{{ route('rankings.show', $period->id) }}" class="btn btn-primary btn-sm">
                                    Lihat Ranking
                                </a>
                            @else
                                <span class="badge bg-secondary">Belum dihitung</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data periode.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection