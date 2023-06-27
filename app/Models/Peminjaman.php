<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}
