<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\MemberModel;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataMember=MemberModel::all();
        return view('menu.manage-member')
        ->with('dataMember',$dataMember);
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
            $dataBarang = new MemberModel;
            $dataBarang->nama_member = $request->input('nama_member');
            $dataBarang->no_kontak = $request->input('no_kontak');
            
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
            $dataBarang = MemberModel::find($id);
            $dataBarang->nama_member = $request->input('nama_member');
            $dataBarang->no_kontak = $request->input('no_kontak');
            
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
