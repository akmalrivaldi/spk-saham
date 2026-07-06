<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\Period;
use App\Models\Ranking;
use App\Models\Stock;
use App\Models\StockValue;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    public function index()
    {
        $criteria = Criterion::orderBy('code')->get();
        $periods = Period::whereHas('rankings')->orderByDesc('year')->get();

        return view('simulation.index', compact('criteria', 'periods'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'period_id' => 'required|exists:periods,id',
            'weights' => 'required|array',
            'weights.*' => 'numeric|min:0',
        ], [
            'period_id.required' => 'Periode wajib dipilih.',
            'period_id.exists' => 'Periode yang dipilih tidak valid.',
            'weights.required' => 'Bobot kriteria wajib diisi.',
            'weights.*.numeric' => 'Bobot harus berupa angka.',
            'weights.*.min' => 'Bobot tidak boleh bernilai negatif.',
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

        // Collect user weights and normalize them
        $rawWeights = [];
        $weightSum = 0;

        foreach ($criteria as $criterion) {
            $w = (float) ($request->weights[$criterion->id] ?? 0);
            $rawWeights[$criterion->id] = $w;
            $weightSum += $w;
        }

        if ($weightSum <= 0) {
            return back()->with('error', 'Total bobot tidak boleh nol. Minimal satu kriteria harus memiliki bobot lebih dari 0.');
        }

        // Normalize weights so they sum to 1
        $normalizedWeights = [];
        foreach ($rawWeights as $criterionId => $w) {
            $normalizedWeights[$criterionId] = $w / $weightSum;
        }

        // Run WP calculation with user's normalized weights
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

            foreach ($criteria as $criterion) {
                $value = (float) $stockValues[$criterion->id]->value;
                $userWeight = $normalizedWeights[$criterion->id];
                $effectiveWeight = $criterion->attribute === 'cost' ? -$userWeight : $userWeight;

                if ($value <= 0) {
                    return back()->with('error', 'Nilai kriteria ' . $criterion->name . ' untuk saham ' . $stock->code . ' harus lebih besar dari 0.');
                }

                $vectorS *= pow($value, $effectiveWeight);
            }

            $results[] = [
                'stock' => $stock,
                'vector_s' => $vectorS,
            ];

            $sumS += $vectorS;
        }

        if ($sumS <= 0) {
            return back()->with('error', 'Jumlah total vektor S tidak valid.');
        }

        // Calculate Vector V
        foreach ($results as $index => $result) {
            $results[$index]['vector_v'] = $result['vector_s'] / $sumS;
        }

        // Sort by Vector V descending and assign simulation ranks
        usort($results, function ($a, $b) {
            return $b['vector_v'] <=> $a['vector_v'];
        });

        foreach ($results as $index => $result) {
            $results[$index]['sim_rank'] = $index + 1;
        }

        // Load original rankings for comparison
        $originalRankings = Ranking::with('stock')
            ->where('period_id', $period->id)
            ->orderBy('rank')
            ->get()
            ->keyBy('stock_id');

        // Build comparison data
        $comparison = [];
        foreach ($results as $result) {
            $stockId = $result['stock']->id;
            $originalRanking = $originalRankings->get($stockId);

            $originalRank = $originalRanking ? $originalRanking->rank : null;
            $originalVectorV = $originalRanking ? $originalRanking->vector_v : null;

            $comparison[] = [
                'stock' => $result['stock'],
                'original_rank' => $originalRank,
                'original_vector_v' => $originalVectorV,
                'sim_rank' => $result['sim_rank'],
                'sim_vector_v' => $result['vector_v'],
                'rank_change' => $originalRank !== null ? ($originalRank - $result['sim_rank']) : null,
            ];
        }

        // Build original weights map for comparison
        $originalWeights = [];
        foreach ($criteria as $criterion) {
            $originalWeights[$criterion->id] = (float) $criterion->weight;
        }

        // User weights (normalized) for display
        $userWeights = $normalizedWeights;

        return view('simulation.result', compact(
            'period',
            'criteria',
            'userWeights',
            'originalWeights',
            'comparison'
        ));
    }
}
