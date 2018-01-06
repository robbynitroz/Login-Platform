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
        $results = $model->getFeedsByName($request->hotel_name);
        $feed = array();
        foreach ($results as $result){
            $feed[]= json_decode($result->feed);
        }
        return $feed;
    }
}
