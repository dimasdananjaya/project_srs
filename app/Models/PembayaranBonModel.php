<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranBonModel extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_bon';
    public $timestamps = false;
    public $primaryKey='id_pembayaran_bon';
}
