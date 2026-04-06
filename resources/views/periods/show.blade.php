@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Detail Periode</h2>
    <p class="text-muted mb-0">Informasi lengkap periode penilaian.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="25%">Nama Periode</th>
                <td>{{ $period->name }}</td>
            </tr>
            <tr>
                <th>Tahun</th>
                <td>{{ $period->year }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $period->description ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($period->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Dibuat Pada</th>
                <td>{{ $period->created_at }}</td>
            </tr>
            <tr>
                <th>Diperbarui Pada</th>
                <td>{{ $period->updated_at }}</td>
            </tr>
        </table>

        <a href="{{ route('periods.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('periods.edit', $period->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection