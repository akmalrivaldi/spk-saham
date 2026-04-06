<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\Period;
use App\Models\Ranking;
use App\Models\Stock;
use App\Models\StockValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalculationController extends Controller
{
    public function index()
    {
        $periods = Period::orderByDesc('year')->get();

        return view('calculations.index', compact('periods'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'period_id' => 'required|exists:periods,id',
        ], [
            'period_id.required' => 'Periode wajib dipilih.',
        ]);

        $period = Period::findOrFail($request->period_id);
        $criteria = Criterion::orderBy('code')->get();
        $stocks = Stock::where('is_active', true)->orderBy('code')->get();

        if ($criteria->isEmpty()) {
            return back()->with('error', 'Data kriteria belum tersedia.');
        }

        if ($stocks->isEmpty()) {
            return back()->with('error', 'Data saham belum tersedia.');
        }

        $results = [];
        $sumS = 0;

        foreach ($stocks as $stock) {
            $stockValues = StockValue::where('stock_id', $stock->id)
                ->where('period_id', $period->id)
                ->get()
                ->keyBy('criterion_id');

            if ($stockValues->count() !== $criteria->count()) {
                return back()->with('error', 'Penilaian untuk saham ' . $stock->code . ' pada periode ' . $period->year . ' belum lengkap.');
            }

            $vectorS = 1;
            $calculationDetails = [];

            foreach ($criteria as $criterion) {
                $value = (float) $stockValues[$criterion->id]->value;
                $weight = (float) $criterion->weight;
                $effectiveWeight = $criterion->attribute === 'cost' ? -$weight : $weight;

                if ($value <= 0) {
                    return back()->with('error', 'Nilai kriteria ' . $criterion->name . ' untuk saham ' . $stock->code . ' harus lebih besar dari 0 agar dapat dihitung dengan metode WP.');
                }

                $poweredValue = pow($value, $effectiveWeight);
                $vectorS *= $poweredValue;

                $calculationDetails[] = [
                    'criterion_code' => $criterion->code,
                    'criterion_name' => $criterion->name,
                    'attribute' => $criterion->attribute,
                    'weight' => $weight,
                    'effective_weight' => $effectiveWeight,
                    'value' => $value,
                    'powered_value' => $poweredValue,
                ];
            }

            $results[] = [
                'stock' => $stock,
                'vector_s' => $vectorS,
                'details' => $calculationDetails,
            ];

            $sumS += $vectorS;
        }

        if ($sumS <= 0) {
            return back()->with('error', 'Jumlah total vektor S tidak valid.');
        }

        foreach ($results as $index => $result) {
            $results[$index]['vector_v'] = $result['vector_s'] / $sumS;
        }

        usort($results, function ($a, $b) {
            return $b['vector_v'] <=> $a['vector_v'];
        });

        DB::transaction(function () use ($period, $results) {
            Ranking::where('period_id', $period->id)->delete();

            foreach ($results as $index => $result) {
                Ranking::create([
                    'period_id' => $period->id,
                    'stock_id' => $result['stock']->id,
                    'vector_s' => $result['vector_s'],
                    'vector_v' => $result['vector_v'],
                    'rank' => $index + 1,
                ]);
            }
        });

        return redirect()->route('rankings.show', $period->id)
            ->with('success', 'Perhitungan Weighted Product berhasil dilakukan untuk periode ' . $period->year . '.');
    }

    public function rankings()
    {
        $periods = Period::withCount('rankings')
            ->orderByDesc('year')
            ->get();

        return view('rankings.index', compact('periods'));
    }

    public function showRanking(Period $period)
    {
        $rankings = Ranking::with('stock')
            ->where('period_id', $period->id)
            ->orderBy('rank')
            ->get();

        if ($rankings->isEmpty()) {
            return redirect()->route('rankings.index')
                ->with('error', 'Belum ada hasil ranking untuk periode tersebut.');
        }

        return view('rankings.show', compact('period', 'rankings'));
    }

    public function detail(Period $period, Stock $stock)
    {
        $criteria = Criterion::orderBy('code')->get();

        $stockValues = StockValue::with('criterion')
            ->where('stock_id', $stock->id)
            ->where('period_id', $period->id)
            ->get()
            ->keyBy('criterion_id');

        if ($stockValues->count() !== $criteria->count()) {
            return redirect()->route('rankings.show', $period->id)
                ->with('error', 'Data penilaian saham tidak lengkap.');
        }

        $detailRows = [];
        $vectorS = 1;

        foreach ($criteria as $criterion) {
            $value = (float) $stockValues[$criterion->id]->value;
            $weight = (float) $criterion->weight;
            $effectiveWeight = $criterion->attribute === 'cost' ? -$weight : $weight;
            $poweredValue = pow($value, $effectiveWeight);

            $vectorS *= $poweredValue;

            $detailRows[] = [
                'code' => $criterion->code,
                'name' => $criterion->name,
                'attribute' => $criterion->attribute,
                'weight' => $weight,
                'effective_weight' => $effectiveWeight,
                'value' => $value,
                'powered_value' => $poweredValue,
            ];
        }

        $sumS = Ranking::where('period_id', $period->id)->sum('vector_s');
        $ranking = Ranking::where('period_id', $period->id)
            ->where('stock_id', $stock->id)
            ->first();

        if (!$ranking) {
            return redirect()->route('rankings.show', $period->id)
                ->with('error', 'Ranking saham tidak ditemukan. Silakan lakukan perhitungan ulang.');
        }

        $vectorV = $sumS > 0 ? $vectorS / $sumS : 0;

        return view('rankings.detail', compact(
            'period',
            'stock',
            'detailRows',
            'vectorS',
            'vectorV',
            'ranking',
            'sumS'
        ));
    }
}