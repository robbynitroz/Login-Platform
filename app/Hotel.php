<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Hotel
 * @package App
 */
class Hotel extends Model
{
    use SoftDeletes;

    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * @var string
     */
    protected $table = 'hotels';
    /**
     * @var array
     */
    protected $fillable = ['name', 'session_timeout'];
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

}
