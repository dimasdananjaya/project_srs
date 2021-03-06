<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemberModel;
use App\Models\BarangModel;
use App\Models\BarangPenjualanModel;
use App\Models\PeriodeModel;
use App\Models\PenjualanModel;
use App\Models\TokoModel;
use App\Models\BankModel;
use DB;
use Session;

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

        $nama_barangs = $request->input('nama_barang', []);
        $id_barangs = $request->input('id_barang', []);
        $jumlah = $request->input('jumlah', []);
        $total_harga_juals = $request->input('total_harga_jual', []);
        $total_harga_pokoks = $request->input('total_harga_pokok', []);
       
        $penjualan = new PenjualanModel;
        $penjualan->tanggal = $request->input('tanggal');
        $penjualan->id_toko = $request->input('id_toko');
        $penjualan->id_user = $request->input('id_user');
        $penjualan->id_member = "1";
        $penjualan->id_periode = $request->input('id_periode');
        $penjualan->id_bank = $request->input('id_bank');
        $penjualan->total_harga_pokok = $request->input('total_harga_akhir_pokok_penjualan');
        $penjualan->total_harga_jual = $request->input('total_harga_akhir_jual_penjualan');
        $penjualan->total_akhir= $request->input('total_akhir');
        $penjualan->diskon = $request->input('diskon');
        $penjualan->no_bon = $request->input('no_bon');
        $penjualan->nama_pembeli = $request->input('nama_pembeli');

        $jenis_pembayaran=$request->input('jenis_pembayaran');
        $tanggal=$request->input('tanggal');

        $penjualan->keterangan = $request->input('keterangan');
        if($jenis_pembayaran=='bon'){
            $penjualan->jenis_pembayaran = $request->input('jenis_pembayaran');
            $penjualan->status = 'bon';
        }
        else{
            $penjualan->jenis_pembayaran = $request->input('jenis_pembayaran');
            $penjualan->status = 'lunas';
        }
        $penjualan->save();


        $idToko=$request->input('id_toko');
        $idPeriode=$request->input('id_periode');

        for ($i = 0; $i < count($nama_barangs); $i++) {
            $attribute = BarangPenjualanModel::create([

                'id_penjualan'=>$penjualan->id_penjualan,
                'id_barang' => $id_barangs[$i],
                'id_toko' => $idToko,
                'id_periode' => $idPeriode,
                'jumlah' => $jumlah[$i],
                'tanggal' => $tanggal,
                'total_harga_pokok' => $total_harga_pokoks[$i],
                'total_harga_jual' => $total_harga_juals[$i],
            ]);

            $attribute->save();
        }

        

     /** https://stackoverflow.com/questions/51686090/array-count-laravel */   
     alert()->success('Data Tersimpan!');
     return back();
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
        PenjualanModel::find($id)->delete();
        alert()->success('Data Penjualan Berhasil Dihapus!', '');
        return back();
    }

    public function showPenjualanToko(Request $request)
    {
        $periode=$request->input('periode');
        $idToko=$request->input('id_toko');

        $dataMember=MemberModel::all();
        $dataBarang=DB::table('barang')->where('id_toko', '=', $idToko);
        $dataPeriode=PeriodeModel::all();
        $dataBank=BankModel::all();
        $dataToko=DB::table('toko')->where('id_toko', '=', $idToko)->get();
        $dataPenjualanLunas=DB::table('penjualan')
        ->join('member', 'member.id_member', '=', 'penjualan.id_member')
        ->join('bank', 'bank.id_bank', '=', 'penjualan.id_bank')
        ->select('penjualan.*', 'member.nama_member','bank.nama_bank')  
        ->where('penjualan.id_periode', $periode)
        ->where('penjualan.id_toko', $idToko)
        ->where('penjualan.status', 'lunas')
        ->orderBy('tanggal','DESC')->get();

        $dataPenjualanBon=DB::table('penjualan')
        ->join('member', 'member.id_member', '=', 'penjualan.id_member')
        ->join('bank', 'bank.id_bank', '=', 'penjualan.id_bank')
        ->select('penjualan.*', 'member.nama_member','bank.nama_bank')  
        ->where('penjualan.id_periode', $periode)
        ->where('penjualan.id_toko', $idToko)
        ->where('penjualan.status', 'bon')
        ->orderBy('tanggal','ASC')->get();

        $dataPembayaranBon=DB::table('pembayaran_bon')
        ->join('penjualan', 'penjualan.id_penjualan', '=', 'pembayaran_bon.id_penjualan')
        ->join('bank', 'bank.id_bank', '=', 'penjualan.id_bank')
        ->select('pembayaran_bon.*','penjualan.no_bon','bank.nama_bank','penjualan.nama_pembeli')  
        ->where('pembayaran_bon.id_periode', $periode)
        ->where('pembayaran_bon.id_toko', $idToko)
        ->orderBy('tanggal','DESC')->get();

        $dataTotalBarangTerjual=DB::select(DB::raw(" 
        select *, sum(jumlah) as jumlah_barang_terjual from barang_penjualan
        INNER JOIN barang ON barang.id_barang=barang_penjualan.id_barang
        where barang_penjualan.id_toko = $idToko
        and id_periode = $periode
        group by nama_barang
        order by nama_barang asc"));

        $cekToko=DB::select(DB::raw(" 
        select tanggal, sum(total_akhir) as total_penjualan, 
        sum(total_harga_pokok) as pokok from penjualan
        where id_toko = $idToko
        and id_periode = $periode
        group by tanggal
        order by tanggal asc"));  

        return view('menu.toko-dashboard')
        ->with('dataBarang',$dataBarang)
        ->with('dataPeriode',$dataPeriode)
        ->with('dataMember',$dataMember)
        ->with('dataToko',$dataToko)
        ->with('dataBank',$dataBank)
        ->with('idToko',$idToko)
        ->with('periode',$periode)
        ->with('dataPenjualanLunas',$dataPenjualanLunas)
        ->with('dataPenjualanBon',$dataPenjualanBon)
        ->with('dataPembayaranBon',$dataPembayaranBon)
        ->with('dataTotalBarangTerjual',$dataTotalBarangTerjual)
        ->with('cekToko',$cekToko);
    }
    

    public function searchResponse(Request $request){
        $query = $request->get('term','');
        $id_toko= $request->get('id_toko');
        $barangs=DB::table('barang');
        if($request->type=='nama_barang'){
            $barangs->where('nama_barang','LIKE','%'.$query.'%')->where('id_toko','=',$id_toko);
        }
        $barangs=$barangs->get();        
        $data=array();
        foreach ($barangs as $br) {
                $data[]=array('id_barang'=>$br->id_barang,'nama_barang'=>$br->nama_barang,'harga_pokok'=>$br->harga_pokok,'harga_jual'=>$br->harga_jual,'id_toko'=>$br->id_toko);
        }
        if(count($data))
             return $data;
        else
            return ['nama_barang'=>'','harga_pokok'=>'','harga_jual'=>'','id_toko'=>''];
    }

    public function hapusPenjualanBon($id)
    {
        PenjualanModel::find($id)->delete();
        alert()->success('Data Penjualan Bon Berhasil Dihapus!', '');
        return back();
    }

}
