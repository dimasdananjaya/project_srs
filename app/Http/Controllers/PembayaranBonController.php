<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranBonController extends Controller
{
    public function tambahPembayaranBon(){
        $pembayaran = new PembayaranBonModel;
        $pembayaran->id_toko = $request->input('id_toko');
        $pembayaran->id_penjualan = $request->input('id_penjualan');
        $pembayaran->id_periode = $request->input('id_periode');
        $pembayaran->jumlah_pembayaran = $request->input('jumlah_pembayaran');

    }

    public function hapusPembayaranBon(){
        $pembayaran = new PembayaranBonModel;
        $pembayaran->id_toko = $request->input('id_toko');
        $pembayaran->id_penjualan = $request->input('id_penjualan');
        $pembayaran->id_periode = $request->input('id_periode');
        $pembayaran->jumlah_pembayaran = $request->input('jumlah_pembayaran');

    }
}
