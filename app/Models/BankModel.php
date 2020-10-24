<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankModel extends Model
{
    use HasFactory;

    protected $table = 'bank';
    public $timestamps = true;
    public $primaryKey='id_bank';
    protected $guarded = [];

}
