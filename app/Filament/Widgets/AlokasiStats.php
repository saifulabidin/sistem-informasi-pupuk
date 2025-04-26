<?php

namespace App\Filament\Widgets;

use App\Models\AlokasiPupuk;
use App\Models\KelompokTani;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlokasiStats extends Widget
{
    protected static ?string $heading = 'Status Alokasi Pupuk';
    
    // For a wider table layout
    protected int | string | array $columnSpan = 2;

    protected function getViewData(): array
    {
        // Get allocation statistics by status
        $byStatus = AlokasiPupuk::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->total];
            })
            ->toArray();
            
        // Get total allocations for current and previous month
        $currentMonthAllocations = AlokasiPupuk::whereYear('tanggal_alokasi', Carbon::now()->year)
            ->whereMonth('tanggal_alokasi', Carbon::now()->month)
            ->count();
            
        $previousMonthAllocations = AlokasiPupuk::whereYear('tanggal_alokasi', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal_alokasi', Carbon::now()->subMonth()->month)
            ->count();
            
        // Calculate percentage change
        $percentChange = 0;
        if ($previousMonthAllocations > 0) {
            $percentChange = (($currentMonthAllocations - $previousMonthAllocations) / $previousMonthAllocations) * 100;
        }
        
        // Get top 5 farmer groups with most allocations
        $topGroups = KelompokTani::select(
                'kelompok_tani.nama',
                DB::raw('COUNT(alokasi_pupuks.id) as allocation_count'),
                DB::raw('SUM(alokasi_pupuks.jumlah_alokasi) as total_allocation')
            )
            ->join('alokasi_pupuks', 'kelompok_tani.id', '=', 'alokasi_pupuks.kelompok_tani_id')
            ->groupBy('kelompok_tani.id', 'kelompok_tani.nama')
            ->orderBy('allocation_count', 'desc')
            ->take(5)
            ->get();

        return [
            'byStatus' => $byStatus,
            'currentMonth' => $currentMonthAllocations,
            'previousMonth' => $previousMonthAllocations,
            'percentChange' => $percentChange,
            'topGroups' => $topGroups,
        ];
    }

    protected static string $view = 'filament.widgets.alokasi-stats';
}