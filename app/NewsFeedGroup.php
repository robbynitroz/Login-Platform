<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsFeedGroup extends Model
{
    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'news_feed_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = ['group_name','group_tags'];

    /**
     * Timestamps on
     *
     * @var bool $timestamps
     */
    public $timestamps = true;

}
