<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class Template
 * @package App
 */
class Template extends Model
{
    use SoftDeletes;

    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * @var string
     */
    protected $table = 'templates';
    /**
     * @var array
     */
    protected $fillable = ['hotel', 'activated', 'data', 'scheduled', 'schedule_start_time', 'schedule_end_time'];
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo('App\Hotel', 'hotel', 'id');
    }

    public static function getTemplate(string $ip)
    {
        return DB::select("SELECT id, hotel, data, scheduled, schedule_start_time, schedule_end_time FROM `templates` WHERE hotel IN (SELECT id from hotels WHERE id IN (SELECT hotel FROM nas WHERE nasname = :ip)) AND `activated`='yes' AND `deleted_at` IS NULL ",
            ['ip' => $ip]);
    }


}
