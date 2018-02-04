<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NewsFeed extends Model
{

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'news_feeds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = ['card_name','belongs_to', 'feed'];

    /**
     * Timestamps on
     *
     * @var bool $timestamps
     */
    public $timestamps = true;

    /**
     * Search in full text belongs_to column by given string, return feed
     *
     * @param string $name
     * @return array
     */
    public function getFeedsByName(string $name):array
    {
       return DB::select("SELECT feed FROM news_feeds WHERE MATCH (belongs_to) AGAINST (?) AND published ='yes' ORDER BY id DESC", array($name));
    }

}
