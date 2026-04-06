@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Proses Perhitungan Weighted Product</h2>
    <p class="text-muted mb-0">
        Pilih periode penilaian yang akan dihitung untuk menghasilkan ranking saham terbaik.
    </p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('calculations.process') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Pilih Periode</label>
                <select name="period_id" class="form-select @error('period_id') is-invalid @enderror">
                    <option value="">-- Pilih Periode --</option>
                    @foreach($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->name }} ({{ $period->year }})</option>
                    @endforeach
                </select>
                @error('period_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="alert alert-info">
                <strong>Catatan:</strong>
                Pastikan semua data penilaian saham untuk periode yang dipilih sudah lengkap sebelum proses perhitungan dilakukan.
            </div>

            <button type="submit" class="btn btn-primary">
                Proses Perhitungan
            </button>
        </form>
    </div>
</div>
@endsection