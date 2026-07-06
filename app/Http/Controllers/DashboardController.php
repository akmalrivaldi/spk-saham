<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\Period;
use App\Models\Ranking;
use App\Models\Stock;
use App\Models\StockValue;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    private function adminDashboard()
    {
        $totalStocks = Stock::count();
        $totalCriteria = Criterion::count();
        $totalPeriods = Period::count();
        $totalRankings = Ranking::count();
        $totalStockValues = StockValue::count();
        $totalUsers = User::where('role', 'user')->count();
        $pendingUsers = User::where('role', 'user')->where('is_approved', false)->count();

        $latestStocks = Stock::latest()->take(5)->get();
        $latestPeriods = Period::latest()->take(5)->get();
        $latestCriteria = Criterion::orderBy('code')->get();

        return view('dashboard.index', compact(
            'totalStocks',
            'totalCriteria',
            'totalPeriods',
            'totalRankings',
            'totalStockValues',
            'totalUsers',
            'pendingUsers',
            'latestStocks',
            'latestPeriods',
            'latestCriteria'
        ));
    }

    private function userDashboard()
    {
        $totalPeriods = Period::count();
        $totalRankings = Ranking::count();
        $totalCriteria = Criterion::count();

        $periodsWithRanking = Period::whereHas('rankings')
            ->withCount('rankings')
            ->orderByDesc('year')
            ->take(5)
            ->get();

        $latestCriteria = Criterion::orderBy('code')->get();

        return view('dashboard.user', compact(
            'totalPeriods',
            'totalRankings',
            'totalCriteria',
            'periodsWithRanking',
            'latestCriteria'
        ));
    }
}