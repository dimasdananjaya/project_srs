<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreListModel;
use App\Models\PeriodeModel;

class RouteController extends Controller
{
    public function storeList(){
        $dataStore=StoreListModel::all();
        $dataPeriode=PeriodeModel::all();

        return view('menu.store-list')
        ->with('dataPeriode',$dataPeriode)
        ->with('dataStore',$dataStore);
    }
}
