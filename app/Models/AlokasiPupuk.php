<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AlokasiPupuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelompok_tani_id',
        'pupuk_id',
        'jumlah_alokasi',
        'status',
        'jumlah_diambil',
        'tanggal_alokasi',
        'periode',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_alokasi' => 'date',
    ];

    /**
     * Get the farmer group of this allocation.
     */
    public function kelompokTani(): BelongsTo
    {
        return $this->belongsTo(KelompokTani::class);
    }

    /**
     * Get the fertilizer for this allocation.
     */
    public function pupuk(): BelongsTo
    {
        return $this->belongsTo(Pupuk::class);
    }

    /**
     * Get all purchases related to this allocation.
     */
    public function pembelianPupuks(): HasMany
    {
        return $this->hasMany(PembelianPupuk::class);
    }
}
