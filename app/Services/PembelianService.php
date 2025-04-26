<?php

namespace App\Services;

use App\Models\Petani;
use App\Models\Pupuk;
use App\Models\AlokasiPupuk;
use App\Models\PembelianPupuk;
use Exception;
use Illuminate\Support\Facades\DB;

class PembelianService
{
    /**
     * Process a fertilizer purchase.
     *
     * @param Petani $petani
     * @param Pupuk $pupuk
     * @param int $jumlah
     * @param array $additionalData
     * @return PembelianPupuk
     * @throws Exception
     */
    public function beli(Petani $petani, Pupuk $pupuk, int $jumlah, array $additionalData = [])
    {
        // Check if there's an active allocation for this farmer group and fertilizer
        $alokasi = AlokasiPupuk::where('kelompok_tani_id', $petani->kelompok_tani_id)
                    ->where('pupuk_id', $pupuk->id)
                    ->where('status', '!=', 'selesai')
                    ->first();
                    
        // Validate stock availability
        if ($pupuk->stok < $jumlah) {
            throw new Exception('Stok pupuk tidak cukup. Tersedia: ' . $pupuk->stok);
        }
        
        // Validate allocation if exists
        if ($alokasi) {
            $sisaAlokasi = $alokasi->jumlah_alokasi - $alokasi->jumlah_diambil;
            if ($sisaAlokasi < $jumlah) {
                throw new Exception('Sisa alokasi tidak cukup. Tersedia: ' . $sisaAlokasi);
            }
        }
        
        // Begin transaction
        return DB::transaction(function () use ($petani, $pupuk, $jumlah, $alokasi, $additionalData) {
            // Create purchase record
            $pembelian = PembelianPupuk::create(array_merge([
                'petani_id' => $petani->id,
                'pupuk_id' => $pupuk->id,
                'alokasi_pupuk_id' => $alokasi ? $alokasi->id : null,
                'jumlah' => $jumlah,
                'harga_satuan' => $pupuk->harga,
                'total_harga' => $pupuk->harga * $jumlah,
                'tanggal_pembelian' => $additionalData['tanggal_pembelian'] ?? now(),
                'metode_pembayaran' => $additionalData['metode_pembayaran'] ?? 'cash',
                'status_pembayaran' => $additionalData['status_pembayaran'] ?? 'lunas',
                'keterangan' => $additionalData['keterangan'] ?? null,
            ], $additionalData));
            
            // Note: Stock reduction and allocation update are handled by model events
            
            return $pembelian;
        });
    }
}