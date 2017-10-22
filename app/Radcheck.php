<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Radcheck
 * @package App
 */
class Radcheck extends Model
{
    //

    /**
     * @var string
     */
    protected $table = 'radcheck';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'username',
        'attribute',
        'op',
        'value',
    ];
}
