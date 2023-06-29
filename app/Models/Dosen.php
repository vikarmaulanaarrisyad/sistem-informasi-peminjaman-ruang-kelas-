<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosen';

    /**
     * The Dosen that belong to the matakuliah.
     */
    public function matakuliah(): BelongsToMany
    {
        return $this->belongsToMany(Matakuliah::class,'dosen_matakuliah')->withTimestamps();
    }

}
