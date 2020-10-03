<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanModel extends Model
{
    use HasFactory;


    protected $table = 'penjualan';
    public $timestamps = true;
    public $primaryKey='id_penjualan';

    public function barang()
    {
        return $this->belongsToMany('App\Models\BarangModel', 'barang_penjualan', 
        'id_penjualan','id_barang')->withPivot(['quantity']);
    }
}
