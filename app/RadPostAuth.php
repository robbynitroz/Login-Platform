<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RadPostAuth extends Model
{
    //

    protected $table = 'radpostauth';

    protected $fillable = [
        'id',
        'username',
        'pass',
        'reply',
        'authdate'
    ];
}
