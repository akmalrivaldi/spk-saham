<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::latest()->paginate(10);

        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:stocks,code',
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'subsector' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ], [
            'code.required' => 'Kode saham wajib diisi.',
            'code.unique' => 'Kode saham sudah digunakan.',
            'name.required' => 'Nama saham wajib diisi.',
            'issuer.required' => 'Nama emiten wajib diisi.',
            'subsector.required' => 'Subsektor wajib diisi.',
            'is_active.required' => 'Status aktif wajib dipilih.',
        ]);

        Stock::create($validated);

        return redirect()->route('stocks.index')
            ->with('success', 'Data saham berhasil ditambahkan.');
    }

    public function show(Stock $stock)
    {
        return view('stocks.show', compact('stock'));
    }

    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:stocks,code,' . $stock->id,
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'subsector' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ], [
            'code.required' => 'Kode saham wajib diisi.',
            'code.unique' => 'Kode saham sudah digunakan.',
            'name.required' => 'Nama saham wajib diisi.',
            'issuer.required' => 'Nama emiten wajib diisi.',
            'subsector.required' => 'Subsektor wajib diisi.',
            'is_active.required' => 'Status aktif wajib dipilih.',
        ]);

        $stock->update($validated);

        return redirect()->route('stocks.index')
            ->with('success', 'Data saham berhasil diperbarui.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()->route('stocks.index')
            ->with('success', 'Data saham berhasil dihapus.');
    }
}