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
     * Timestamps on
     *
     * @var bool $timestamps
     */
    public $timestamps = true;

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'hotels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = ['name', 'session_timeout', 'timezone', 'main_url', 'facebook_url'];

    /**
     * Soft deletes on
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Relation to templates
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function templates()
    {
        return $this->hasMany('App\Template','hotel', 'id');
    }

    /**
     * Relation to Nas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nas()
    {
        return $this->hasMany('App\Nas');
    }


}
