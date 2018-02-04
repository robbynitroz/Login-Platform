<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Email
 * @package App
 */
class Email extends Model
{

    /**
     * Timestamps on
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'hotel_id',
        'type',
        'email'
    ];

    /**
     * Relation to hotel, foreign key hotel_id
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo('App\Hotel', 'hotel_id', 'id');
    }

}
