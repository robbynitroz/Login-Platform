<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NewsFeed extends Model
{
    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * @var string
     */
    protected $table = 'news_feeds';
    /**
     * @var array
     */
    protected $fillable = ['group_name','belongs_to', 'feed'];


    /**
     * Search in full text belongs_to column by given string, return feed
     *
     * @param string $name
     * @return array
     */
    public function getFeedsByName(string $name):array
    {
       return DB::select("SELECT feed FROM news_feeds WHERE MATCH (belongs_to) AGAINST (?) AND published ='yes'", array($name));
    }

}
