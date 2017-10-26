<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Email
 * @package App
 */
class Email extends Model
{
    //

    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * @var string
     */
    protected $table = 'emails';
    /**
     * @var array
     */
    protected $fillable = [
        'hotel_id',
        'type',
        'email'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo('App\Hotel', 'hotel_id', 'id');
    }

}
