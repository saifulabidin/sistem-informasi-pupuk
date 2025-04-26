<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Pupuk extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'nama',
        'jenis',
        'harga',
        'stok',
        'satuan',
        'deskripsi',
    ];

    /**
     * Get all allocations for this fertilizer.
     */
    public function alokasiPupuks(): HasMany
    {
        return $this->hasMany(AlokasiPupuk::class);
    }

    /**
     * Get all purchases for this fertilizer.
     */
    public function pembelianPupuks(): HasMany
    {
        return $this->hasMany(PembelianPupuk::class);
    }
}
