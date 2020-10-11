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

    protected $guarded = [];
}
