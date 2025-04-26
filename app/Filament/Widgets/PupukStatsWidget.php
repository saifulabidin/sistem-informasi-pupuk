<?php

namespace App\Filament\Widgets;

use App\Models\Pupuk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class PupukStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        // Get total pupuk value (stock * price)
        $totalValue = Pupuk::select(DB::raw('SUM(stok * harga) as total_value'))->first()->total_value ?? 0;

        // Get total pupuk items
        $totalItems = Pupuk::sum('stok');

        // Get low stock items (less than 100 units)
        $lowStockCount = Pupuk::where('stok', '<', 100)->count();

        return [
            Stat::make('Nilai Total Inventori Pupuk', 'Rp ' . number_format($totalValue, 0, ',', '.'))
                ->description('Nilai seluruh stok pupuk')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
                
            Stat::make('Total Pupuk Tersedia', number_format($totalItems, 0, ',', '.') . ' unit')
                ->description('Jumlah total stok pupuk')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
                
            Stat::make('Pupuk Stok Rendah', $lowStockCount . ' jenis')
                ->description('Pupuk dengan stok < 100')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockCount > 0 ? 'danger' : 'success'),
        ];
    }
}