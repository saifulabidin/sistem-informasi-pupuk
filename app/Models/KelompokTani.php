<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelompokTani extends Model
{
    use HasFactory;
    
    protected $table = 'kelompok_tani';

    protected $fillable = [
        'nama',
        'ketua',
        'desa',
        'kecamatan',
        'alamat',
    ];

    /**
     * Get all petani (farmers) in this group.
     */
    public function petani(): HasMany
    {
        return $this->hasMany(Petani::class);
    }

    /**
     * Get all fertilizer allocations for this group.
     */
    public function alokasiPupuks(): HasMany
    {
        return $this->hasMany(AlokasiPupuk::class);
    }
}
