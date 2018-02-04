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

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'nas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
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

    /**
     * Get all ips by ID
     *
     * @param int $id
     * @return mixed
     */
    public function allIPsByHotel(int $id)
    {
        return DB::select("SELECT nasname FROM `nas` WHERE  `hotel_id`== :id", ['id'=>$id]);
    }
}
