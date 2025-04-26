<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Petani extends Model
{
    use HasFactory;
    
    protected $table = 'petani';

    protected $fillable = [
        'nama',
        'nik',
        'kelompok_tani_id',
        'no_telepon',
        'alamat',
        'luas_lahan',
    ];

    /**
     * Get the farmer group that this farmer belongs to.
     */
    public function kelompokTani(): BelongsTo
    {
        return $this->belongsTo(KelompokTani::class);
    }

    /**
     * Get all fertilizer purchases made by this farmer.
     */
    public function pembelianPupuks(): HasMany
    {
        return $this->hasMany(PembelianPupuk::class);
    }
}
