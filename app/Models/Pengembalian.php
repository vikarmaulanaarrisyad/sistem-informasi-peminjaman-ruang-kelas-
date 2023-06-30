<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table = "pengembalian";

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
