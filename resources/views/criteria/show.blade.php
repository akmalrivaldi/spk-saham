@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Detail Kriteria</h2>
    <p class="text-muted mb-0">Informasi lengkap data kriteria.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="25%">Kode Kriteria</th>
                <td>{{ $criterion->code }}</td>
            </tr>
            <tr>
                <th>Nama Kriteria</th>
                <td>{{ $criterion->name }}</td>
            </tr>
            <tr>
                <th>Atribut</th>
                <td>
                    @if($criterion->attribute === 'benefit')
                        <span class="badge bg-success">Benefit</span>
                    @else
                        <span class="badge bg-danger">Cost</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Bobot</th>
                <td>{{ $criterion->weight }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $criterion->description ?? '-' }}</td>
            </tr>
            <tr>
                <th>Dibuat Pada</th>
                <td>{{ $criterion->created_at }}</td>
            </tr>
            <tr>
                <th>Diperbarui Pada</th>
                <td>{{ $criterion->updated_at }}</td>
            </tr>
        </table>

        <a href="{{ route('criteria.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('criteria.edit', $criterion->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection