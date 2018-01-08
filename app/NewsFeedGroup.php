<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsFeedGroup extends Model
{
    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * @var string
     */
    protected $table = 'news_feed_groups';
    /**
     * @var array
     */
    protected $fillable = ['group_name','group_tags'];


}
