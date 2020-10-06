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
        //coba link ini https://stackoverflow.com/questions/46375213/how-to-insert-into-database-invoice-and-products-in-laravel-5-3

        $penjualan = PenjualanModel::create($request->all());

        $products = $request->input('products', []);
        $quantities = $request->input('quantities', []);
        $total_harga_juals = $request->input('total_harga_juals', []);
        $total_harga_pokoks = $request->input('total_harga_pokoks', []);

       

        $penjualan = new PenjualanModel;
        $penjualan->id_toko = $request->input('id_toko');
        $penjualan->id_user = $request->input('id_user');
        $penjualan->id_member = $request->input('id_member');
        $penjualan->id_periode = $request->input('id_periode');
        $penjualan->total_harga_pokok = $request->input('total_harga_pokok');
        $penjualan->total_harga_jual = $request->input('total_harga_jual');
        $order->save();


     /** https://stackoverflow.com/questions/51686090/array-count-laravel */   

    
        return redirect()->back();
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
    

    public function searchResponse(Request $request){
        $query = $request->get('term','');
        $barangs=DB::table('barang');
        if($request->type=='nama_barang'){
            $barangs->where('nama_barang','LIKE','%'.$query.'%');
        }
        if($request->type=='harga_pokok'){
            $barangs->where('harga_pokok','LIKE','%'.$query.'%');
        }
        if($request->type=='harga_jual'){
            $barangs->where('harga_jual','LIKE','%'.$query.'%');
        }
        $barangs=$barangs->get();        
        $data=array();
        foreach ($barangs as $br) {
                $data[]=array('nama_barang'=>$br->nama_barang,'harga_pokok'=>$br->harga_pokok,'harga_jual'=>$br->harga_jual);
        }
        if(count($data))
             return $data;
        else
            return ['nama_barang'=>'','harga_pokok'=>'','harga_jual'=>''];
    }

}
