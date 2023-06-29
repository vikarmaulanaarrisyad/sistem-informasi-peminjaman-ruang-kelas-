<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruang extends Model
{
    use HasFactory;
    protected $table   = 'ruang';

    public function perlengkapan()
    {
        return $this->belongsToMany(Perlengkapan::class,'alat_ruang','alat_id','ruang_id')->withTimestamps();
    }
}
