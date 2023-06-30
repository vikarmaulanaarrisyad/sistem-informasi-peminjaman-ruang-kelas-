<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = new Setting;
        $setting->nama_aplikasi = 'SISTEM INFORMASI PEMINJAMAN PERANGKAT PEMBELAJARAN';
        $setting->nama_singkatan = 'SIM-PPE';
        $setting->diskripsi_aplikasi = 'SISTEM INFORMASI PEMINJAMAN PERANGKAT PEMBELAJARAN';
        $setting->save();
    }
}
