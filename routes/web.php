<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LandingPageController;

// Landing page route
Route::get('/', [LandingPageController::class, 'index']);

// Export routes (protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/export/alokasi/pdf', [ExportController::class, 'exportAlokasiPdf'])->name('export.alokasi.pdf');
    Route::get('/export/alokasi/excel', [ExportController::class, 'exportAlokasiExcel'])->name('export.alokasi.excel');
});
