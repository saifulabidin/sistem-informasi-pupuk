<?php

namespace App\Filament\Widgets;

use App\Models\PembelianPupuk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembelianChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan';
    
    protected static ?string $pollingInterval = '300s';

    protected function getData(): array
    {
        $data = PembelianPupuk::select(
                DB::raw('DATE(tanggal_pembelian) as date'),
                DB::raw('SUM(total_harga) as total')
            )
            ->where('tanggal_pembelian', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $labels = $data->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('d M');
        })->toArray();
        
        $values = $data->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan (Rp)',
                    'data' => $values,
                    'fill' => true,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgb(75, 192, 192)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => "function(value) { return 'Rp ' + Number(value).toLocaleString('id-ID'); }",
                    ],
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) { return 'Rp ' + Number(context.parsed.y).toLocaleString('id-ID'); }",
                    ],
                ],
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
}