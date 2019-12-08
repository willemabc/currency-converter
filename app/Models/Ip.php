<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    protected $fillable = [
        'from',
        'to',
    ];

    public $timestamps = true;
}
