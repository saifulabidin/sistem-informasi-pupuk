<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LandingPageController;

// Landing page route
Route::get('/', [LandingPageController::class, 'index']);

// Informational pages
Route::get('/tentang-kami', [LandingPageController::class, 'tentangKami'])->name('tentang-kami');
Route::get('/panduan-penggunaan', [LandingPageController::class, 'panduanPenggunaan'])->name('panduan-penggunaan');
Route::get('/kebijakan-privasi', [LandingPageController::class, 'kebijakanPrivasi'])->name('kebijakan-privasi');
Route::get('/syarat-ketentuan', [LandingPageController::class, 'syaratKetentuan'])->name('syarat-ketentuan');

// Export routes (protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/export/alokasi/pdf', [ExportController::class, 'exportAlokasiPdf'])->name('export.alokasi.pdf');
    Route::get('/export/alokasi/excel', [ExportController::class, 'exportAlokasiExcel'])->name('export.alokasi.excel');
});
