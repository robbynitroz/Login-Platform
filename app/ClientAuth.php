<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientAuth
 * @package App
 */
class ClientAuth extends Model
{
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
    protected $table = 'client_auths';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'hotel_id',
        'method',
        'mac_address',
    ];

    /**
     * Relation to hotels, foreign key hotel_id
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo('App\Hotel', 'hotel_id', 'id');
    }
}
