<?php

namespace App\Http\Controllers;

use App\Exports\RankingExport;
use App\Models\Criterion;
use App\Models\Period;
use App\Models\Ranking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Export ranking results as PDF.
     */
    public function exportPdf(Period $period)
    {
        $rankings = Ranking::with('stock')
            ->where('period_id', $period->id)
            ->orderBy('rank')
            ->get();

        if ($rankings->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data ranking untuk periode ini.');
        }

        $criteria = Criterion::all();
        $generatedBy = Auth::user()->name;
        $generatedAt = now()->format('d F Y, H:i:s');

        $pdf = Pdf::loadView('exports.ranking-pdf', [
            'period' => $period,
            'rankings' => $rankings,
            'criteria' => $criteria,
            'generatedBy' => $generatedBy,
            'generatedAt' => $generatedAt,
        ]);

        return $pdf->download("ranking-saham-{$period->year}.pdf");
    }

    /**
     * Export ranking results as Excel.
     */
    public function exportExcel(Period $period)
    {
        $rankings = Ranking::where('period_id', $period->id)->get();

        if ($rankings->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data ranking untuk periode ini.');
        }

        return Excel::download(new RankingExport($period), "ranking-saham-{$period->year}.xlsx");
    }
}
