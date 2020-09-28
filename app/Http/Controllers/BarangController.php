<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('menu.barang-dashboard');
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
            'nama_barang' => 'required',
            'jenis' => 'required',
            'harga_pokok' => 'required|numeric',
            'harga_jual' => 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        } else {
            // store
            $dataBarang = new Barang;
            $dataBarang->nama_barang = Input::get('nama_barang');
            $dataBarang->jenis = 'dummy_jenis';
            $dataBarang->harga_pokok = 'harga_pokok';
            $dataBarang->harga_jual = 'harga_jual';
            
            $shark->save();

            // redirect
            return redirect()->back()
                ->withErrors($validator);
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
            'nama_barang' => 'required',
            'jenis' => 'required',
            'harga_pokok' => 'required|numeric',
            'harga_jual' => 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        } else {
            // store
            $shark = shark::find($id);

            $dataBarang->nama_barang = Input::get('nama_barang');
            $dataBarang->jenis = 'dummy_jenis';
            $dataBarang->harga_pokok = 'harga_pokok';
            $dataBarang->harga_jual = 'harga_jual';
            
            $shark->save();

            // redirect
            return redirect()->back()
                ->withErrors($validator);
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
