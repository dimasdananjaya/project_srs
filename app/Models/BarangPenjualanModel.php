<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangPenjualanModel extends Model
{
    use HasFactory;

    protected $table = 'barang_penjualan';
    public $timestamps = false;
    public $primaryKey='id_barang_penjualan';

    protected $guarded = [];
}
