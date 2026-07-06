<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalculationController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockValueController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// ──────────────────────────────────────────────
// Guest routes (login & register)
// ──────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// ──────────────────────────────────────────────
// Authenticated + Approved routes (all users)
// ──────────────────────────────────────────────
Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ranking (read-only — accessible by all roles)
    Route::get('/rankings', [CalculationController::class, 'rankings'])->name('rankings.index');
    Route::get('/rankings/{period}', [CalculationController::class, 'showRanking'])->name('rankings.show');
    Route::get('/rankings/{period}/{stock}/detail', [CalculationController::class, 'detail'])->name('rankings.detail');

    // Criteria — admin CUD routes BEFORE wildcard show route
    Route::middleware('role:admin')->group(function () {
        Route::get('/criteria/create', [CriterionController::class, 'create'])->name('criteria.create');
        Route::post('/criteria', [CriterionController::class, 'store'])->name('criteria.store');
        Route::get('/criteria/{criterion}/edit', [CriterionController::class, 'edit'])->name('criteria.edit');
        Route::put('/criteria/{criterion}', [CriterionController::class, 'update'])->name('criteria.update');
        Route::delete('/criteria/{criterion}', [CriterionController::class, 'destroy'])->name('criteria.destroy');
    });
    Route::get('/criteria', [CriterionController::class, 'index'])->name('criteria.index');
    Route::get('/criteria/{criterion}', [CriterionController::class, 'show'])->name('criteria.show');

    // Periods — admin CUD routes BEFORE wildcard show route
    Route::middleware('role:admin')->group(function () {
        Route::get('/periods/create', [PeriodController::class, 'create'])->name('periods.create');
        Route::post('/periods', [PeriodController::class, 'store'])->name('periods.store');
        Route::get('/periods/{period}/edit', [PeriodController::class, 'edit'])->name('periods.edit');
        Route::put('/periods/{period}', [PeriodController::class, 'update'])->name('periods.update');
        Route::delete('/periods/{period}', [PeriodController::class, 'destroy'])->name('periods.destroy');
    });
    Route::get('/periods', [PeriodController::class, 'index'])->name('periods.index');
    Route::get('/periods/{period}', [PeriodController::class, 'show'])->name('periods.show');

    // Simulasi Bobot (accessible by all roles)
    Route::get('/simulation', [SimulationController::class, 'index'])->name('simulation.index');
    Route::post('/simulation/process', [SimulationController::class, 'process'])->name('simulation.process');

    // Export (accessible by all roles)
    Route::get('/export/ranking/{period}/pdf', [ExportController::class, 'exportPdf'])->name('export.ranking.pdf');
    Route::get('/export/ranking/{period}/excel', [ExportController::class, 'exportExcel'])->name('export.ranking.excel');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ──────────────────────────────────────────────
    // Admin-only routes
    // ──────────────────────────────────────────────
    Route::middleware('role:admin')->group(function () {
        // Stocks CRUD (admin only)
        Route::resource('stocks', StockController::class);

        // Stock Values (admin only)
        Route::get('/stock-values', [StockValueController::class, 'index'])->name('stock-values.index');
        Route::get('/stock-values/create', [StockValueController::class, 'create'])->name('stock-values.create');
        Route::post('/stock-values', [StockValueController::class, 'store'])->name('stock-values.store');
        Route::get('/stock-values/{stock}/{period}/edit', [StockValueController::class, 'edit'])->name('stock-values.edit');
        Route::put('/stock-values/{stock}/{period}', [StockValueController::class, 'update'])->name('stock-values.update');
        Route::delete('/stock-values/{stock}/{period}', [StockValueController::class, 'destroy'])->name('stock-values.destroy');
        Route::get('/stock-values/{stock}/{period}', [StockValueController::class, 'show'])->name('stock-values.show');

        // Calculations (admin only)
        Route::get('/calculations', [CalculationController::class, 'index'])->name('calculations.index');
        Route::post('/calculations/process', [CalculationController::class, 'process'])->name('calculations.process');

        // User Management (admin only)
        Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::patch('/admin/users/{user}/approve', [UserManagementController::class, 'approve'])->name('admin.users.approve');
        Route::patch('/admin/users/{user}/reject', [UserManagementController::class, 'reject'])->name('admin.users.reject');
        Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    });
});