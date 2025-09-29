<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ongkir extends Model
{
    protected $table = 'ongkir';

    protected $fillable = [
        'min_trans','ongkir', 'status'
    ];
}
