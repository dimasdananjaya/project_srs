<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'barang';
    public $timestamps = true;
    public $primaryKey='id_barang';

    public function barang()
    {
        return $this->belongsToMany('App\Models', 'barang_penjualan', 
        'id_order','id_product')->withPivot(['quantity']);
    }
}
