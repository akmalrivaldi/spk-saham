<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\Period;
use App\Models\Stock;
use App\Models\StockValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockValueController extends Controller
{
    public function index(Request $request)
    {
        $selectedPeriod = $request->period_id;

        $periods = Period::orderByDesc('year')->get();

        $query = StockValue::with(['stock', 'period', 'criterion']);

        if ($selectedPeriod) {
            $query->where('period_id', $selectedPeriod);
        }

        $stockValueRows = $query->get();

        $groupedValues = $stockValueRows
            ->groupBy(function ($item) {
                return $item->stock_id . '-' . $item->period_id;
            })
            ->map(function ($items) {
                $first = $items->first();

                $criterionValues = [];
                foreach ($items as $item) {
                    $criterionValues[$item->criterion->name] = $item->value;
                }

                return [
                    'stock' => $first->stock,
                    'period' => $first->period,
                    'values' => $criterionValues,
                ];
            })
            ->values();

        return view('stock-values.index', compact('groupedValues', 'periods', 'selectedPeriod'));
    }

    public function create()
    {
        $stocks = Stock::where('is_active', true)->orderBy('code')->get();
        $periods = Period::where('is_active', true)->orderByDesc('year')->get();
        $criteria = Criterion::orderBy('code')->get();

        return view('stock-values.create', compact('stocks', 'periods', 'criteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'period_id' => 'required|exists:periods,id',
            'values' => 'required|array',
        ], [
            'stock_id.required' => 'Saham wajib dipilih.',
            'period_id.required' => 'Periode wajib dipilih.',
            'values.required' => 'Nilai kriteria wajib diisi.',
        ]);

        $criteria = Criterion::orderBy('code')->get();

        foreach ($criteria as $criterion) {
            $request->validate([
                'values.' . $criterion->id => 'required|numeric',
            ], [
                'values.' . $criterion->id . '.required' => 'Nilai untuk ' . $criterion->name . ' wajib diisi.',
                'values.' . $criterion->id . '.numeric' => 'Nilai untuk ' . $criterion->name . ' harus berupa angka.',
            ]);
        }

        $exists = StockValue::where('stock_id', $request->stock_id)
            ->where('period_id', $request->period_id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Data penilaian untuk saham dan periode tersebut sudah ada.');
        }

        DB::transaction(function () use ($request, $criteria) {
            foreach ($criteria as $criterion) {
                StockValue::create([
                    'stock_id' => $request->stock_id,
                    'period_id' => $request->period_id,
                    'criterion_id' => $criterion->id,
                    'value' => $request->values[$criterion->id],
                ]);
            }
        });

        return redirect()->route('stock-values.index')
            ->with('success', 'Data penilaian saham berhasil disimpan.');
    }

    public function show(Stock $stock, Period $period)
    {
        $values = StockValue::with('criterion')
            ->where('stock_id', $stock->id)
            ->where('period_id', $period->id)
            ->get()
            ->sortBy('criterion.code');

        if ($values->isEmpty()) {
            return redirect()->route('stock-values.index')
                ->with('error', 'Data penilaian tidak ditemukan.');
        }

        return view('stock-values.show', compact('stock', 'period', 'values'));
    }

    public function edit(Stock $stock, Period $period)
    {
        $criteria = Criterion::orderBy('code')->get();

        $values = StockValue::where('stock_id', $stock->id)
            ->where('period_id', $period->id)
            ->get()
            ->keyBy('criterion_id');

        if ($values->isEmpty()) {
            return redirect()->route('stock-values.index')
                ->with('error', 'Data penilaian tidak ditemukan.');
        }

        return view('stock-values.edit', compact('stock', 'period', 'criteria', 'values'));
    }

    public function update(Request $request, Stock $stock, Period $period)
    {
        $request->validate([
            'values' => 'required|array',
        ], [
            'values.required' => 'Nilai kriteria wajib diisi.',
        ]);

        $criteria = Criterion::orderBy('code')->get();

        foreach ($criteria as $criterion) {
            $request->validate([
                'values.' . $criterion->id => 'required|numeric',
            ], [
                'values.' . $criterion->id . '.required' => 'Nilai untuk ' . $criterion->name . ' wajib diisi.',
                'values.' . $criterion->id . '.numeric' => 'Nilai untuk ' . $criterion->name . ' harus berupa angka.',
            ]);
        }

        DB::transaction(function () use ($request, $stock, $period, $criteria) {
            foreach ($criteria as $criterion) {
                StockValue::updateOrCreate(
                    [
                        'stock_id' => $stock->id,
                        'period_id' => $period->id,
                        'criterion_id' => $criterion->id,
                    ],
                    [
                        'value' => $request->values[$criterion->id],
                    ]
                );
            }
        });

        return redirect()->route('stock-values.index')
            ->with('success', 'Data penilaian saham berhasil diperbarui.');
    }

    public function destroy(Stock $stock, Period $period)
    {
        StockValue::where('stock_id', $stock->id)
            ->where('period_id', $period->id)
            ->delete();

        return redirect()->route('stock-values.index')
            ->with('success', 'Data penilaian saham berhasil dihapus.');
    }
}