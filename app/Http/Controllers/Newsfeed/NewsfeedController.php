<?php

namespace App\Http\Controllers\Newsfeed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NewsFeed;


class NewsfeedController extends Controller
{

    /**
     * Get all feeds based on request
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request):array
    {
        $model = new NewsFeed();
        if($request->hotel_name === null){
            $hotel_tag = 'all';
        }else{
            $hotel_tag = $request->hotel_name;
        }
        $results = $model->getFeedsByName($hotel_tag);
        $feed = array();
        foreach ($results as $result){
            $feed[]= json_decode($result->feed);
        }
        return $feed;
    }
}
