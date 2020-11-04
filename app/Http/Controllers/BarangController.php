<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\BarangModel;
use App\Models\TokoModel;
use DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataToko=TokoModel::all();
        $dataBarang=DB::table('barang')
        ->join('toko', 'toko.id_toko', '=', 'barang.id_toko')
        ->select('barang.*','toko.nama_toko')  
        ->orderBy('id_toko','ASC')->get();
        
        return view('menu.barang-dashboard')
        ->with('dataToko',$dataToko)
        ->with('dataBarang',$dataBarang);
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
        // validate
        $rules = array(

        );
        $validator = Validator::make($request->all(), [$rules]);

        // update barang
        if ($validator->fails()) {
            alert()->error('Gagal Disimpan !', $validator);
            return redirect()->back();
        } else {
            // store
            $dataBarang = new BarangModel;
            $dataBarang->id_toko = $request->input('id_toko');
            $dataBarang->nama_barang = $request->input('nama_barang');
            $dataBarang->jenis = $request->input('jenis');
            $dataBarang->harga_pokok = preg_replace('/\D/','',$request->input('harga_pokok'));
            $dataBarang->harga_jual = preg_replace('/\D/','',$request->input('harga_jual'));
            
            $dataBarang->save();

            // redirect
            alert()->success('Data Tersimpan !', '');
            return back();
        }
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
        // validate
        $rules = array(

        );
        $validator = Validator::make($request->all(), [$rules]);

        // update barang
        if ($validator->fails()) {
            alert()->error('Gagal Disimpan !', $validator);
            return redirect()->back();
        } else {
            // store
            $dataBarang = BarangModel::find($id);

            $dataBarang->id_toko = $request->input('id_toko');
            $dataBarang->nama_barang = $request->input('nama_barang');
            $dataBarang->jenis = $request->input('jenis');
            $dataBarang->harga_pokok = preg_replace('/\D/','',$request->input('harga_pokok'));
            $dataBarang->harga_jual = preg_replace('/\D/','',$request->input('harga_jual'));
            
            $dataBarang->save();

            // redirect
            alert()->success('Data Diupdate !', '');
            return back();
        }
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
}
