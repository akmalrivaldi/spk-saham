@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Data Saham</h2>
        <p class="text-muted mb-0">Kelola data saham subsektor perbankan.</p>
    </div>
    <a href="{{ route('stocks.create') }}" class="btn btn-primary">Tambah Saham</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Kode</th>
                    <th>Nama Saham</th>
                    <th>Emiten</th>
                    <th>Subsektor</th>
                    <th>Status</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $index => $stock)
                    <tr>
                        <td>{{ $stocks->firstItem() + $index }}</td>
                        <td>{{ $stock->code }}</td>
                        <td>{{ $stock->name }}</td>
                        <td>{{ $stock->issuer }}</td>
                        <td>{{ $stock->subsector }}</td>
                        <td>
                            @if($stock->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('stocks.show', $stock->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                            <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data saham ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data saham.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $stocks->links() }}
    </div>
</div>
@endsection