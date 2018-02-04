<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Radcheck
 * @package App
 */
class Radcheck extends Model
{

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'radcheck';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'username',
        'attribute',
        'op',
        'value',
        'hotel_id',
        'router',
    ];

    /**
     * Timestamps off
     *
     * @var bool $timestamps
     */
    public $timestamps = false;

}
