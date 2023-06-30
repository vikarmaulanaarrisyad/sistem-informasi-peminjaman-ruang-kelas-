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

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function statusText()
    {
        $text = '';

        switch ($this->status) {
            case 'pinjam':
                $text = 'Belum dikembalikan';
                break;
            case 'kembali':
                $text = 'Dikembalikan';
                break;

            default:
                # code...
                break;
        }

        return $text;
    }
    public function statusColor()
    {
        $color = '';

        switch ($this->status) {
            case 'pinjam':
                $color = 'danger';
                break;
            case 'kembali':
                $color = 'warning';
                break;

            default:
                # code...
                break;
        }

        return $color;
    }
}
