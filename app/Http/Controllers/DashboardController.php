<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();


        if ($user->hasRole('admin')) {
            return view('admin.dashboard.index');
        } else {
            return view('karyawan.dashboard.index');
        }
    }
}
