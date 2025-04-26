<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PembelianPupuk extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    protected $fillable = [
        'petani_id',
        'pupuk_id',
        'alokasi_pupuk_id',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'tanggal_pembelian',
        'metode_pembayaran',
        'status_pembayaran',
        'keterangan',
        'no_bukti',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($pembelian) {
            // Calculate total price if not set
            if (empty($pembelian->total_harga) && !empty($pembelian->harga_satuan)) {
                $pembelian->total_harga = $pembelian->jumlah * $pembelian->harga_satuan;
            }
        });

        static::created(function ($pembelian) {
            // Reduce fertilizer stock
            $pupuk = Pupuk::find($pembelian->pupuk_id);
            if ($pupuk) {
                $pupuk->decrement('stok', $pembelian->jumlah);
            }

            // Update allocation if applicable
            $alokasi = AlokasiPupuk::find($pembelian->alokasi_pupuk_id);
            if ($alokasi) {
                // Increase the amount taken (jumlah_diambil)
                $alokasi->increment('jumlah_diambil', $pembelian->jumlah);
                
                // Update status if fully allocated
                if ($alokasi->jumlah_diambil >= $alokasi->jumlah_alokasi) {
                    $alokasi->update(['status' => 'selesai']);
                } elseif ($alokasi->jumlah_diambil > 0) {
                    $alokasi->update(['status' => 'sebagian']);
                }
            }
        });

        static::updating(function ($pembelian) {
            $oldPembelian = static::find($pembelian->id);
            
            // Recalculate total price if quantities changed
            if ($pembelian->jumlah != $oldPembelian->jumlah || $pembelian->harga_satuan != $oldPembelian->harga_satuan) {
                $pembelian->total_harga = $pembelian->jumlah * $pembelian->harga_satuan;
            }
        });
    }

    /**
     * Get the farmer for this purchase.
     */
    public function petani(): BelongsTo
    {
        return $this->belongsTo(Petani::class);
    }

    /**
     * Get the fertilizer for this purchase.
     */
    public function pupuk(): BelongsTo
    {
        return $this->belongsTo(Pupuk::class);
    }

    /**
     * Get the allocation related to this purchase, if any.
     */
    public function alokasiPupuk(): BelongsTo
    {
        return $this->belongsTo(AlokasiPupuk::class);
    }
}
