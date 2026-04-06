@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Edit Penilaian Saham</h2>
    <p class="text-muted mb-0">
        Edit nilai saham <strong>{{ $stock->code }} - {{ $stock->name }}</strong> untuk periode <strong>{{ $period->year }}</strong>.
    </p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('stock-values.update', [$stock->id, $period->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Saham</label>
                    <input type="text" class="form-control" value="{{ $stock->code }} - {{ $stock->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Periode</label>
                    <input type="text" class="form-control" value="{{ $period->name }} ({{ $period->year }})" readonly>
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
                            value="{{ old('values.' . $criterion->id, isset($values[$criterion->id]) ? $values[$criterion->id]->value : '') }}"
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
            <button type="submit" class="btn btn-primary">Update Penilaian</button>
        </form>
    </div>
</div>
@endsection