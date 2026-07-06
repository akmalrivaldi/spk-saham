@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Manajemen User</h2>
        <p class="text-muted mb-0">Kelola dan setujui pendaftaran user baru.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th width="25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_approved)
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if(!$user->is_approved)
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm">Tolak</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada user terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
