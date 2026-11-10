<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PlantReportController;
use App\Models\Plant;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $plants = auth()->user()->plants();

    $totalPlants = $plants->count();

    $inStockPlants = (clone $plants)
        ->where('stock_status', 'in_stock')
        ->count();

    $outOfStockPlants = (clone $plants)
        ->where('stock_status', 'out_of_stock')
        ->count();

    $totalCategories = (clone $plants)
        ->distinct()
        ->count('category');

     $categoryStats = (clone $plants)
    ->select('category')
    ->selectRaw('COUNT(*) as total')
    ->groupBy('category')
    ->get();

    $recentPlants = (clone $plants)
        ->latest()
        ->take(5)
        ->get();

   return view('dashboard', compact(
    'totalPlants',
    'inStockPlants',
    'outOfStockPlants',
    'totalCategories',
    'recentPlants',
    'categoryStats'
));

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Plant CRUD resource routes.
    Route::resource('plants', PlantController::class);

    Route::get('/reports', [PlantReportController::class, 'index'])
    ->name('reports.index');

    Route::get('/reports/pdf', [PlantReportController::class, 'pdf'])
    ->name('reports.pdf');

    Route::get('/reports/excel', [PlantReportController::class, 'excel'])
    ->name('reports.excel');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
