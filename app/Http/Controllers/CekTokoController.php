<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\MemberModel;
use App\Models\BarangModel;
use App\Models\BarangPenjualanModel;
use App\Models\PeriodeModel;
use App\Models\PenjualanModel;
use App\Models\TokoModel;

use DB;


class CekTokoController extends Controller
{
    public function cekToko(Request $request)
    {
        $idToko=$request->input('id_toko');
        $dari = $request->input('dari');   
        $dari1 = strtotime($dari); // Convert date to a UNIX timestamp  
        
        $hingga = $request->input('hingga');   
        $hingga1 = strtotime($hingga); // Convert date to a UNIX timestamp
        
        $dates = [];
        
        // Loop from the start date to end date and output all dates inbetween  
        for ($i=$dari1; $i<=$hingga1; $i+=86400) {  
            array_push($dates,date("Y-m-d", $i));  
        }

        $totalPenjualanDanPokok=DB::select(DB::raw(" 
        select sum(total_akhir) 
        as total_penjualan, 
        sum(total_harga_pokok) as pokok 
        from penjualan 
        WHERE tanggal BETWEEN '$dari' AND '$hingga'
        and id_toko = $idToko "));
        
        $totalPenjualanCash=DB::select(DB::raw(" 
        select sum(total_akhir) 
        as total_penjualan_cash, 
        sum(total_harga_pokok) as pokok 
        from penjualan 
        WHERE tanggal BETWEEN '$dari' AND '$hingga'
        and id_toko = $idToko
        and jenis_pembayaran='cash'")); 

        $totalPenjualanTransfer=DB::select(DB::raw(" 
        select sum(total_akhir) 
        as total_penjualan_transfer, 
        sum(total_harga_pokok) as pokok 
        from penjualan 
        WHERE tanggal BETWEEN '$dari' AND '$hingga'
        and id_toko = $idToko
        and jenis_pembayaran='transfer' ")); 

        $totalPenjualanBon=DB::select(DB::raw(" 
        select sum(total_akhir) 
        as total_penjualan_bon, 
        sum(total_harga_pokok) as pokok 
        from penjualan 
        WHERE tanggal BETWEEN '$dari' AND '$hingga'
        and id_toko = $idToko
        and jenis_pembayaran='bon'")); 

        $totalBayarBon=DB::select(DB::raw(" 
        select sum(jumlah_pembayaran) 
        as total_bayar_bon
        from pembayaran_bon 
        WHERE tanggal BETWEEN '$dari' AND '$hingga'
        and id_toko = $idToko")); 
        
        return view('menu.toko-cek')
        ->with('tanggal',$dates)
        ->with('idToko',$idToko)
        ->with('totalPenjualanDanPokok',$totalPenjualanDanPokok)
        ->with('totalPenjualanCash',$totalPenjualanCash)
        ->with('totalPenjualanTransfer',$totalPenjualanTransfer)
        ->with('totalPenjualanBon',$totalPenjualanBon)
        ->with('totalBayarBon',$totalBayarBon);
    }
}
