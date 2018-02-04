<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * @package App
 */
class Setting extends Model
{
    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'id',
        'type',
        'setting',
    ];
}
