@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Tambah Kriteria</h2>
    <p class="text-muted mb-0">Masukkan data kriteria baru.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('criteria.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Kriteria</label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="Contoh: C1">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Kriteria</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: ROE">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Atribut</label>
                    <select name="attribute" class="form-select @error('attribute') is-invalid @enderror">
                        <option value="">-- Pilih Atribut --</option>
                        <option value="benefit" {{ old('attribute') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="cost" {{ old('attribute') == 'cost' ? 'selected' : '' }}>Cost</option>
                    </select>
                    @error('attribute')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Bobot</label>
                    <input type="number" step="0.0001" name="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight') }}" placeholder="Contoh: 0.2919">
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Deskripsi kriteria (opsional)">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <a href="{{ route('criteria.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection