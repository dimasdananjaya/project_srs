<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokoModel extends Model
{
    use HasFactory;

    protected $table = 'toko';
    public $timestamps = true;
    public $primaryKey='id_toko';
}
