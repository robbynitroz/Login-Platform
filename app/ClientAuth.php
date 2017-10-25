<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientAuth
 * @package App
 */
class ClientAuth extends Model
{
    //
    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * @var string
     */
    protected $table = 'client_auths';
    /**
     * @var array
     */
    protected $fillable = [
        'hotel_id',
        'method',
        'mac_address',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo('App\Hotel', 'hotel_id', 'id');
    }
}
