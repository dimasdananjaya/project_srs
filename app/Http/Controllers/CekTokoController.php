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
        $periode=$request->input('periode');
        $idToko=$request->input('id_toko');
        $dari = $request->input('dari');   
        $dari = strtotime($dari); // Convert date to a UNIX timestamp  
        
        $hingga = $request->input('hingga');   
        $hingga = strtotime($hingga); // Convert date to a UNIX timestamp
        
        $dates = [];
        
        // Loop from the start date to end date and output all dates inbetween  
        for ($i=$dari; $i<=$hingga; $i+=86400) {  
            array_push($dates,date("Y-m-d", $i));  
        }
        
        return view('menu.toko-cek')
        ->with('tanggal',$dates)
        ->with('idToko',$idToko);
    }
}
