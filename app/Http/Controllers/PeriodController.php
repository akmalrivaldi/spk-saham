<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        $periods = Period::orderByDesc('year')->paginate(10);

        return view('periods.index', compact('periods'));
    }

    public function create()
    {
        return view('periods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|unique:periods,year',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ], [
            'name.required' => 'Nama periode wajib diisi.',
            'year.required' => 'Tahun wajib diisi.',
            'year.digits' => 'Tahun harus 4 digit.',
            'year.unique' => 'Tahun periode sudah ada.',
            'is_active.required' => 'Status aktif wajib dipilih.',
        ]);

        Period::create($validated);

        return redirect()->route('periods.index')
            ->with('success', 'Periode berhasil ditambahkan.');
    }

    public function show(Period $period)
    {
        return view('periods.show', compact('period'));
    }

    public function edit(Period $period)
    {
        return view('periods.edit', compact('period'));
    }

    public function update(Request $request, Period $period)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|unique:periods,year,' . $period->id,
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ], [
            'name.required' => 'Nama periode wajib diisi.',
            'year.required' => 'Tahun wajib diisi.',
            'year.digits' => 'Tahun harus 4 digit.',
            'year.unique' => 'Tahun periode sudah ada.',
            'is_active.required' => 'Status aktif wajib dipilih.',
        ]);

        $period->update($validated);

        return redirect()->route('periods.index')
            ->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy(Period $period)
    {
        $period->delete();

        return redirect()->route('periods.index')
            ->with('success', 'Periode berhasil dihapus.');
    }
}