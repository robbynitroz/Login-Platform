<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RadPostAuth extends Model
{

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'radpostauth';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'username',
        'pass',
        'reply',
        'authdate'
    ];
}
