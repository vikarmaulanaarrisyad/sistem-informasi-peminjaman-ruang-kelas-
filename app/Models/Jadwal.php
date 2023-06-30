<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    //scope binding untuk mencari hari
    public function scopeHariIni()
    {
        $hari = format_hari(date("D"));

        return $this->where('hari', $hari);
    }

    //scope binding untuk mencari Kelas
    public function scopeKelas()
    {
        $userId = Auth::id();
        $mahasiswa = Mahasiswa::where('user_id', $userId)->first();
        $kelasMahasiswa = $mahasiswa->kelas_mahasiswa()->first();

        return $this->where('kelas_id', $kelasMahasiswa->id);
    }
}
