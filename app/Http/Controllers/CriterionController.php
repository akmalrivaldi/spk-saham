<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    public function index()
    {
        $criteria = Criterion::orderBy('code')->paginate(10);

        return view('criteria.index', compact('criteria'));
    }

    public function create()
    {
        return view('criteria.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:criteria,code',
            'name' => 'required|string|max:255',
            'attribute' => 'required|in:benefit,cost',
            'weight' => 'required|numeric|min:0|max:1',
            'description' => 'nullable|string',
        ], [
            'code.required' => 'Kode kriteria wajib diisi.',
            'code.unique' => 'Kode kriteria sudah digunakan.',
            'name.required' => 'Nama kriteria wajib diisi.',
            'attribute.required' => 'Atribut wajib dipilih.',
            'weight.required' => 'Bobot wajib diisi.',
            'weight.numeric' => 'Bobot harus berupa angka.',
            'weight.min' => 'Bobot minimal 0.',
            'weight.max' => 'Bobot maksimal 1.',
        ]);

        Criterion::create($validated);

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function show(Criterion $criterion)
    {
        return view('criteria.show', compact('criterion'));
    }

    public function edit(Criterion $criterion)
    {
        return view('criteria.edit', compact('criterion'));
    }

    public function update(Request $request, Criterion $criterion)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:criteria,code,' . $criterion->id,
            'name' => 'required|string|max:255',
            'attribute' => 'required|in:benefit,cost',
            'weight' => 'required|numeric|min:0|max:1',
            'description' => 'nullable|string',
        ], [
            'code.required' => 'Kode kriteria wajib diisi.',
            'code.unique' => 'Kode kriteria sudah digunakan.',
            'name.required' => 'Nama kriteria wajib diisi.',
            'attribute.required' => 'Atribut wajib dipilih.',
            'weight.required' => 'Bobot wajib diisi.',
            'weight.numeric' => 'Bobot harus berupa angka.',
            'weight.min' => 'Bobot minimal 0.',
            'weight.max' => 'Bobot maksimal 1.',
        ]);

        $criterion->update($validated);

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Criterion $criterion)
    {
        $criterion->delete();

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil dihapus.');
    }
}