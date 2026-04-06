@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Detail Saham</h2>
    <p class="text-muted mb-0">Informasi lengkap data saham.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="25%">Kode Saham</th>
                <td>{{ $stock->code }}</td>
            </tr>
            <tr>
                <th>Nama Saham</th>
                <td>{{ $stock->name }}</td>
            </tr>
            <tr>
                <th>Nama Emiten</th>
                <td>{{ $stock->issuer }}</td>
            </tr>
            <tr>
                <th>Subsektor</th>
                <td>{{ $stock->subsector }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($stock->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Dibuat Pada</th>
                <td>{{ $stock->created_at }}</td>
            </tr>
            <tr>
                <th>Diperbarui Pada</th>
                <td>{{ $stock->updated_at }}</td>
            </tr>
        </table>

        <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection