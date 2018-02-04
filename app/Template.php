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
    protected $table = 'templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = ['hotel', 'activated', 'type', 'data', 'scheduled', 'schedule_start_time', 'schedule_end_time'];

    /**
     * Soft deletes on
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Related to hotel, foreign key hotel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo('App\Hotel', 'hotel', 'id');
    }

    /**
     * Get template by IP address
     *
     * @param string $ip
     * @return mixed
     */
    public static function getTemplate(string $ip)
    {
        return DB::select("SELECT id, hotel, data, scheduled, schedule_start_time, schedule_end_time FROM `templates` WHERE hotel IN (SELECT id from hotels WHERE id IN (SELECT hotel FROM nas WHERE nasname = :ip)) AND `activated`='yes' AND `deleted_at` IS NULL ",
            ['ip' => $ip]);
    }


}
