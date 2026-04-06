<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalculationController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockValueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('stocks', StockController::class);
    Route::resource('periods', PeriodController::class);
    Route::resource('criteria', CriterionController::class);

    Route::get('/stock-values', [StockValueController::class, 'index'])->name('stock-values.index');
    Route::get('/stock-values/create', [StockValueController::class, 'create'])->name('stock-values.create');
    Route::post('/stock-values', [StockValueController::class, 'store'])->name('stock-values.store');
    Route::get('/stock-values/{stock}/{period}/edit', [StockValueController::class, 'edit'])->name('stock-values.edit');
    Route::put('/stock-values/{stock}/{period}', [StockValueController::class, 'update'])->name('stock-values.update');
    Route::delete('/stock-values/{stock}/{period}', [StockValueController::class, 'destroy'])->name('stock-values.destroy');
    Route::get('/stock-values/{stock}/{period}', [StockValueController::class, 'show'])->name('stock-values.show');

    Route::get('/calculations', [CalculationController::class, 'index'])->name('calculations.index');
    Route::post('/calculations/process', [CalculationController::class, 'process'])->name('calculations.process');
    Route::get('/rankings', [CalculationController::class, 'rankings'])->name('rankings.index');
    Route::get('/rankings/{period}', [CalculationController::class, 'showRanking'])->name('rankings.show');
    Route::get('/rankings/{period}/{stock}/detail', [CalculationController::class, 'detail'])->name('rankings.detail');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});