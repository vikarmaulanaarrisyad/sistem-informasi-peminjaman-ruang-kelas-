<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User();
        $admin->name = 'Administrator';
        $admin->username = 'admin';
        $admin->password = Hash::make(123456);
        $admin->pass = '123456';
        $admin->email = 'admin@gmail.com';
        $admin->role_id = 1;
        $admin->save();
    }
}
