<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Matakuliah extends Model
{
    use HasFactory;
    protected $table = 'matakuliah';

    /**
     * The Matakuliah that belong to the Dosen.
     */
    public function dosen(): BelongsToMany
    {
        return $this->belongsToMany(Dosen::class,'dosen_matakuliah')->withTimestamps();
    }
}
