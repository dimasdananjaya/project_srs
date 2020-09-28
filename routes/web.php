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
Route::get('/store-list', [App\Http\Controllers\RouteController::class,'storeList'])->name('store.list');
Route::get('/store-dashboard', [App\Http\Controllers\RouteController::class,'storeDashboard'])->name('store.dashboard');
Route::get('/barang-dashboard', [App\Http\Controllers\BarangController::class,'barangDashboard'])->name('barang.dashboard');
