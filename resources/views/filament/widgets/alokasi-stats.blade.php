<x-filament::section>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-base font-medium text-gray-700 dark:text-gray-200">Status Alokasi</h3>
            <div class="mt-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Belum Diambil</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $byStatus['belum_diambil'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Sebagian</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $byStatus['sebagian'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Selesai</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $byStatus['selesai'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between mt-3 pt-3 border-t">
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Total</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ ($byStatus['belum_diambil'] ?? 0) + ($byStatus['sebagian'] ?? 0) + ($byStatus['selesai'] ?? 0) }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-base font-medium text-gray-700 dark:text-gray-200">Alokasi Bulan Ini</h3>
            <div class="mt-4 flex flex-col items-center">
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $currentMonth }}</div>
                <div class="mt-2 text-sm font-medium {{ $percentChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    <span>{{ number_format(abs($percentChange), 1) }}% {{ $percentChange >= 0 ? '↑' : '↓' }}</span>
                    <span class="text-gray-500 dark:text-gray-400">dibanding bulan lalu</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-base font-medium text-gray-700 dark:text-gray-200">Persentase Status</h3>
            <div class="mt-4">
                @php
                    $total = ($byStatus['belum_diambil'] ?? 0) + ($byStatus['sebagian'] ?? 0) + ($byStatus['selesai'] ?? 0);
                    $belumDiambilPercentage = $total > 0 ? round((($byStatus['belum_diambil'] ?? 0) / $total) * 100) : 0;
                    $sebagianPercentage = $total > 0 ? round((($byStatus['sebagian'] ?? 0) / $total) * 100) : 0;
                    $selesaiPercentage = $total > 0 ? round((($byStatus['selesai'] ?? 0) / $total) * 100) : 0;
                @endphp
                
                <div class="mb-2">
                    <div class="flex justify-between mb-1">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Belum Diambil</span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ $belumDiambilPercentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                        <div class="bg-amber-400 h-2 rounded-full" :style="'width: ' + {{ $belumDiambilPercentage }} + '%'"></div>
                    </div>
                </div>
                
                <div class="mb-2">
                    <div class="flex justify-between mb-1">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Sebagian</span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ $sebagianPercentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                        <div class="bg-blue-400 h-2 rounded-full" :style="'width: ' + {{ $sebagianPercentage }} + '%'"></div>
                    </div>
                </div>
                
                <div class="mb-2">
                    <div class="flex justify-between mb-1">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Selesai</span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ $selesaiPercentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                        <div class="bg-green-400 h-2 rounded-full" :style="'width: ' + {{ $selesaiPercentage }} + '%'"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($topGroups->isNotEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b dark:border-gray-700">
            <h3 class="text-base font-medium text-gray-700 dark:text-gray-200">Top 5 Kelompok Tani dengan Alokasi Terbanyak</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kelompok Tani</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah Alokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Alokasi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($topGroups as $group)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $group->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $group->allocation_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ number_format($group->total_allocation, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center text-sm text-gray-500 dark:text-gray-400">
        Belum ada data alokasi untuk ditampilkan
    </div>
    @endif
</x-filament::section>