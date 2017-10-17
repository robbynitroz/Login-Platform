<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Nas
 * @package App
 */
class Nas extends Model
{
    //
    /**
     * @var string
     */
    protected $table = 'nas';

    /**
     * @var array
     */
    protected $fillable = [
        'nasname',
        'shortname',
        'type',
        'secret',
        'description',
        'hotel_id',
        'wanmac',
        'wifi',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo('App\Hotel', 'hotel_id', 'id');
    }
}
