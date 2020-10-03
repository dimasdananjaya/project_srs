<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TokoModel;
use App\Models\PeriodeModel;

class RouteController extends Controller
{
    public function tokoList(){
        $dataToko=TokoModel::all();
        $dataPeriode=PeriodeModel::all();

        return view('menu.toko-list')
        ->with('dataPeriode',$dataPeriode)
        ->with('dataToko',$dataToko);
    }
}
