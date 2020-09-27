<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function storeList(){
        return view('menu.store-list');
    }

    public function storeDashboard(){
        return view('menu.store-dashboard');
    }
}
