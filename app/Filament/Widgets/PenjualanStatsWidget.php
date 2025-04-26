<?php

namespace App\Filament\Widgets;

use App\Models\PembelianPupuk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        // Total sales
        $totalSales = PembelianPupuk::sum('total_harga');
        
        // Today's sales
        $todaySales = PembelianPupuk::whereDate('tanggal_pembelian', Carbon::today())
            ->sum('total_harga');
            
        // This month's sales
        $monthSales = PembelianPupuk::whereYear('tanggal_pembelian', Carbon::now()->year)
            ->whereMonth('tanggal_pembelian', Carbon::now()->month)
            ->sum('total_harga');
            
        // Calculate % change from previous month
        $previousMonthSales = PembelianPupuk::whereYear('tanggal_pembelian', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal_pembelian', Carbon::now()->subMonth()->month)
            ->sum('total_harga');
            
        $percentChange = 0;
        if ($previousMonthSales > 0) {
            $percentChange = (($monthSales - $previousMonthSales) / $previousMonthSales) * 100;
        }
        
        $changeDescription = $percentChange > 0 
            ? number_format(abs($percentChange), 1) . '% kenaikan dari bulan lalu' 
            : number_format(abs($percentChange), 1) . '% penurunan dari bulan lalu';
            
        $changeColor = $percentChange >= 0 ? 'success' : 'danger';

        return [
            Stat::make('Total Penjualan', 'Rp ' . number_format($totalSales, 0, ',', '.'))
                ->description('Nilai total seluruh penjualan')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('success'),
                
            Stat::make('Penjualan Hari Ini', 'Rp ' . number_format($todaySales, 0, ',', '.'))
                ->description('Total penjualan hari ini')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),
                
            Stat::make('Penjualan Bulan Ini', 'Rp ' . number_format($monthSales, 0, ',', '.'))
                ->description($changeDescription)
                ->descriptionIcon($percentChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($changeColor),
        ];
    }
}