<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
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


    /**
     * Select all IP fields
     *
     * @return mixed
     */
    public static function allIPs()
    {
        return DB::select("SELECT nasname FROM `nas`");
    }

    public function allIPsByHotel(int $id)
    {
        return DB::select("SELECT nasname FROM `nas` WHERE  `hotel_id`== :id", ['id'=>$id]);
    }
}
