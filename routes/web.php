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

use App\Http\Controllers\BarangController;
Route::resource('/barang', BarangController::class);

use App\Http\Controllers\MemberController;
Route::resource('/member', MemberController::class);



Route::get('/nama-barang', function () {

    $categoris = Category::where('parent_id',0)->get();
    
    return view('welcome',["categoris" => $categoris]);

});

Route::post('/harga-pokok', function (Request $request) {

    $parent_id = $request->cat_id;
    
    $subcategories = Category::where('id',$parent_id)
                          ->with('subcategories')
                          ->get();

    return response()->json([
        'subcategories' => $subcategories
    ]);
   
})->name('harga.pokok');
