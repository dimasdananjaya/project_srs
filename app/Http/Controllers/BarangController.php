<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function barangDashboard()
    {
        return view('menu.barang-dashboard');
    }
}
