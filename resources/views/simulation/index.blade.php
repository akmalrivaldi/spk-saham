@extends('layouts.app')
@section('content')
<div class="mb-4">
    <h2 class="page-title mb-1">Simulasi Bobot Kriteria</h2>
    <p class="text-muted mb-0">
        Ubah bobot kriteria untuk melihat perubahan ranking secara simulasi. Data asli tidak akan berubah.
    </p>
</div>

<div class="alert alert-info">
    <strong>Informasi:</strong>
    Fitur ini hanya untuk simulasi. Anda dapat mengubah bobot kriteria sesuai preferensi untuk melihat bagaimana ranking saham akan berubah.
    Bobot akan dinormalisasi secara otomatis sehingga totalnya menjadi 1. Data master tidak akan terpengaruh.
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('simulation.process') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label fw-semibold">Pilih Periode</label>
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

            <h5 class="mb-3">Pengaturan Bobot Kriteria</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="8%">Kode</th>
                            <th>Nama Kriteria</th>
                            <th width="10%">Atribut</th>
                            <th width="12%">Bobot Asli</th>
                            <th width="30%">Bobot Simulasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($criteria as $criterion)
                            <tr>
                                <td><strong>{{ $criterion->code }}</strong></td>
                                <td>{{ $criterion->name }}</td>
                                <td>
                                    @if($criterion->attribute === 'benefit')
                                        <span class="badge bg-success">Benefit</span>
                                    @else
                                        <span class="badge bg-danger">Cost</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary fs-6">{{ number_format($criterion->weight, 4) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="range"
                                               class="form-range flex-grow-1 sim-slider"
                                               id="slider_{{ $criterion->id }}"
                                               data-criterion="{{ $criterion->id }}"
                                               min="0" max="1" step="0.01"
                                               value="{{ old('weights.' . $criterion->id, $criterion->weight) }}">
                                        <input type="number"
                                               class="form-control sim-weight"
                                               name="weights[{{ $criterion->id }}]"
                                               id="weight_{{ $criterion->id }}"
                                               data-criterion="{{ $criterion->id }}"
                                               step="0.0001" min="0"
                                               value="{{ old('weights.' . $criterion->id, $criterion->weight) }}"
                                               style="width: 100px;">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                <div>
                    <span class="fw-semibold">Total Bobot:</span>
                    <span id="totalWeight" class="badge bg-primary fs-6 ms-2">0.0000</span>
                    <span id="totalWeightWarning" class="text-warning ms-2 d-none">
                        ⚠ Total bobot ≠ 1. Sistem akan menormalisasi bobot secara otomatis.
                    </span>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnResetWeights">
                    Reset ke Bobot Asli
                </button>
            </div>

            <button type="submit" class="btn btn-primary">
                Jalankan Simulasi
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.sim-slider');
    const weights = document.querySelectorAll('.sim-weight');
    const totalWeightEl = document.getElementById('totalWeight');
    const totalWeightWarning = document.getElementById('totalWeightWarning');

    const originalWeights = {
        @foreach($criteria as $criterion)
            '{{ $criterion->id }}': {{ $criterion->weight }},
        @endforeach
    };

    function updateTotalWeight() {
        let total = 0;
        weights.forEach(function(input) {
            total += parseFloat(input.value) || 0;
        });
        totalWeightEl.textContent = total.toFixed(4);

        if (Math.abs(total - 1) > 0.01) {
            totalWeightWarning.classList.remove('d-none');
            totalWeightEl.classList.remove('bg-primary');
            totalWeightEl.classList.add('bg-warning', 'text-dark');
        } else {
            totalWeightWarning.classList.add('d-none');
            totalWeightEl.classList.remove('bg-warning', 'text-dark');
            totalWeightEl.classList.add('bg-primary');
        }
    }

    // Sync slider -> number input
    sliders.forEach(function(slider) {
        slider.addEventListener('input', function() {
            const criterionId = this.dataset.criterion;
            document.getElementById('weight_' + criterionId).value = this.value;
            updateTotalWeight();
        });
    });

    // Sync number input -> slider
    weights.forEach(function(input) {
        input.addEventListener('input', function() {
            const criterionId = this.dataset.criterion;
            const slider = document.getElementById('slider_' + criterionId);
            let val = parseFloat(this.value) || 0;
            if (val > 1) {
                slider.value = 1;
            } else {
                slider.value = val;
            }
            updateTotalWeight();
        });
    });

    // Reset button
    document.getElementById('btnResetWeights').addEventListener('click', function() {
        for (const [criterionId, weight] of Object.entries(originalWeights)) {
            document.getElementById('weight_' + criterionId).value = weight;
            document.getElementById('slider_' + criterionId).value = weight;
        }
        updateTotalWeight();
    });

    // Initial calculation
    updateTotalWeight();
});
</script>
@endsection
