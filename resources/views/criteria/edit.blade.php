@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Edit Kriteria</h2>
    <p class="text-muted mb-0">Perbarui data kriteria dan bobot.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('criteria.update', $criterion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Kriteria</label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $criterion->code) }}">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Kriteria</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $criterion->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Atribut</label>
                    <select name="attribute" class="form-select @error('attribute') is-invalid @enderror">
                        <option value="benefit" {{ old('attribute', $criterion->attribute) == 'benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="cost" {{ old('attribute', $criterion->attribute) == 'cost' ? 'selected' : '' }}>Cost</option>
                    </select>
                    @error('attribute')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Bobot</label>
                    <input type="number" step="0.0001" name="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight', $criterion->weight) }}">
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $criterion->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <a href="{{ route('criteria.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection