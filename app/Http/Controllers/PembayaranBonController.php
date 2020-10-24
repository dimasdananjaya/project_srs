<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembayaranBonModel;

class PembayaranBonController extends Controller
{
    public function tambahPembayaranBon(Request $request){
        $pembayaran = new PembayaranBonModel;
        $pembayaran->id_toko = $request->input('id_toko');
        $pembayaran->id_penjualan = $request->input('id_penjualan');
        $pembayaran->id_periode = $request->input('id_periode');
        $pembayaran->tanggal = $request->input('tanggal');
        $pembayaran->metode_pembayaran = $request->input('metode_pembayaran');
        $pembayaran->referral = $request->input('referral');
        $pembayaran->jumlah_pembayaran = $request->input('jumlah_pembayaran');
        $pembayaran->bank = $request->input('bank');

        $pembayaran->save();

        alert()->success('Data Tersimpan Pembayaran Bon!');
        return back();

    }

    public function hapusPembayaranBon($id){
        PembayaranBonModel::find($id)->delete();
        alert()->success('Data Pembayaran Bon Berhasil Dihapus!', '');
        return back();
    }
    
}
