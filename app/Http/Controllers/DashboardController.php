<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\Period;
use App\Models\Ranking;
use App\Models\Stock;
use App\Models\StockValue;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStocks = Stock::count();
        $totalCriteria = Criterion::count();
        $totalPeriods = Period::count();
        $totalRankings = Ranking::count();
        $totalStockValues = StockValue::count();

        $latestStocks = Stock::latest()->take(5)->get();
        $latestPeriods = Period::latest()->take(5)->get();
        $latestCriteria = Criterion::orderBy('code')->get();

        return view('dashboard.index', compact(
            'totalStocks',
            'totalCriteria',
            'totalPeriods',
            'totalRankings',
            'totalStockValues',
            'latestStocks',
            'latestPeriods',
            'latestCriteria'
        ));
    }
}