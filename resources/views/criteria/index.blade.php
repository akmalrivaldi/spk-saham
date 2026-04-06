@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Data Kriteria</h2>
        <p class="text-muted mb-0">Kelola kriteria dan bobot metode Weighted Product.</p>
    </div>
    <a href="{{ route('criteria.create') }}" class="btn btn-primary">Tambah Kriteria</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Atribut</th>
                    <th>Bobot</th>
                    <th>Deskripsi</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($criteria as $index => $criterion)
                    <tr>
                        <td>{{ $criteria->firstItem() + $index }}</td>
                        <td>{{ $criterion->code }}</td>
                        <td>{{ $criterion->name }}</td>
                        <td>
                            @if($criterion->attribute === 'benefit')
                                <span class="badge bg-success">Benefit</span>
                            @else
                                <span class="badge bg-danger">Cost</span>
                            @endif
                        </td>
                        <td>{{ $criterion->weight }}</td>
                        <td>{{ $criterion->description ?? '-' }}</td>
                        <td>
                            <a href="{{ route('criteria.show', $criterion->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                            <a href="{{ route('criteria.edit', $criterion->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('criteria.destroy', $criterion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kriteria ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data kriteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $criteria->links() }}
    </div>
</div>
@endsection