<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/toko-list', [App\Http\Controllers\RouteController::class,'tokoList'])->name('toko.list');
Route::get('/toko-dashboard', [App\Http\Controllers\PenjualanController::class,'showPenjualanToko'])->name('toko.dashboard');
Route::get('/toko-cek', [App\Http\Controllers\CekTokoController::class,'cekToko'])->name('toko.cek-toko');
Route::get('/searchajax', [App\Http\Controllers\PenjualanController::class,'searchResponse'])->name('searchajax');

Route::post('/pembayaran-bon', [App\Http\Controllers\PembayaranBonController::class,'tambahPembayaranBon'])->name('tambah.pembayaran-bon');
Route::delete('/hapus-pembayaran-bon/{id}', [App\Http\Controllers\PembayaranBonController::class,'hapusPembayaranBon'])->name('hapus.pembayaran-bon');
Route::delete('/hapus-penjualan-bon/{id}', [App\Http\Controllers\PenjualanController::class,'hapusPenjualanBon'])->name('hapus.penjualan-bon');

use App\Http\Controllers\BarangController;
Route::resource('/barang', BarangController::class);

use App\Http\Controllers\MemberController;
Route::resource('/member', MemberController::class);

use App\Http\Controllers\PenjualanController;
Route::resource('/penjualan', PenjualanController::class);

