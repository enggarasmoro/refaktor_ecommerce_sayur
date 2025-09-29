<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JamKirim extends Model
{
    protected $table = 'jam_kirim';

    protected $fillable = [
        'pengiriman', 'status'
    ];
}
