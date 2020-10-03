<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemberModel;
use App\Models\BarangModel;
use App\Models\PeriodeModel;
use App\Models\PenjualanModel;
use App\Models\TokoModel;
use DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showPenjualanToko(Request $request)
    {
        $periode=$request->input('periode');
        $idToko=$request->input('id_toko');

        $dataMember=MemberModel::all();
        $dataBarang=BarangModel::all();
        $dataPeriode=PeriodeModel::all();
        $dataToko=DB::table('toko')->where('id_toko', '=', $idToko)->get();
        $dataPenjualan=PenjualanModel::with('barang_penjualan')
        ->where('id_periode', '=', $periode)
        ->where('id_toko', '=', $idToko)
        ->orderBy('updated_at','DESC')->get();

        return view('menu.toko-dashboard')
        ->with('dataBarang',$dataBarang)
        ->with('dataPeriode',$dataPeriode)
        ->with('dataMember',$dataMember)
        ->with('dataPenjualan',$dataPenjualan)
        ->with('dataToko',$dataToko);
    }
}
