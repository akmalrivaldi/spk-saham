@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Tambah Penilaian Saham</h2>
    <p class="text-muted mb-0">Input nilai saham berdasarkan seluruh kriteria pada periode tertentu.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('stock-values.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pilih Saham</label>
                    <select name="stock_id" class="form-select @error('stock_id') is-invalid @enderror">
                        <option value="">-- Pilih Saham --</option>
                        @foreach($stocks as $stock)
                            <option value="{{ $stock->id }}" {{ old('stock_id') == $stock->id ? 'selected' : '' }}>
                                {{ $stock->code }} - {{ $stock->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('stock_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Pilih Periode</label>
                    <select name="period_id" class="form-select @error('period_id') is-invalid @enderror">
                        <option value="">-- Pilih Periode --</option>
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ old('period_id') == $period->id ? 'selected' : '' }}>
                                {{ $period->name }} ({{ $period->year }})
                            </option>
                        @endforeach
                    </select>
                    @error('period_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>

            <div class="row">
                @foreach($criteria as $criterion)
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            {{ $criterion->code }} - {{ $criterion->name }}
                            <span class="badge {{ $criterion->attribute === 'benefit' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($criterion->attribute) }}
                            </span>
                        </label>
                        <input
                            type="number"
                            step="0.0001"
                            name="values[{{ $criterion->id }}]"
                            class="form-control @error('values.' . $criterion->id) is-invalid @enderror"
                            value="{{ old('values.' . $criterion->id) }}"
                            placeholder="Masukkan nilai {{ $criterion->name }}"
                        >
                        @error('values.' . $criterion->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($criterion->description)
                            <small class="text-muted">{{ $criterion->description }}</small>
                        @endif
                    </div>
                @endforeach
            </div>

            <a href="{{ route('stock-values.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
        </form>
    </div>
</div>
@endsection