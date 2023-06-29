<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';

    public function kelas_mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'kelas_mahasiswa')->withTimestamps();
    }

    public function kelas_matakuliah()
    {
        return $this->belongsToMany(Matakuliah::class, 'kelas_matakuliah')->withTimestamps();
    }
}
