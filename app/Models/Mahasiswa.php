<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
