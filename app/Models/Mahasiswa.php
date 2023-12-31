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
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class,'mahasiswa_id','id');
        // return $this->belongsTo(Peminjaman::class,'mahasiswa_id','id');
    }

    public function kelas_mahasiswa ()
    {
        return $this->belongsToMany(Kelas::class,'kelas_mahasiswa')->withTimestamps();
    }
}
