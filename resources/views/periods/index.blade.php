@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Data Periode</h2>
        <p class="text-muted mb-0">
            @if(auth()->user()->isAdmin())
                Kelola periode penilaian saham.
            @else
                Daftar periode penilaian saham yang tersedia.
            @endif
        </p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('periods.create') }}" class="btn btn-primary">Tambah Periode</a>
    @endif
</div>

<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Periode</th>
                    <th>Tahun</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    @if(auth()->user()->isAdmin())
                        <th width="20%">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($periods as $index => $period)
                    <tr>
                        <td>{{ $periods->firstItem() + $index }}</td>
                        <td>{{ $period->name }}</td>
                        <td>{{ $period->year }}</td>
                        <td>{{ $period->description ?? '-' }}</td>
                        <td>
                            @if($period->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        @if(auth()->user()->isAdmin())
                            <td>
                                <a href="{{ route('periods.show', $period->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                                <a href="{{ route('periods.edit', $period->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('periods.destroy', $period->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus periode ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? '6' : '5' }}" class="text-center">Belum ada data periode.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $periods->links() }}
    </div>
</div>
@endsection