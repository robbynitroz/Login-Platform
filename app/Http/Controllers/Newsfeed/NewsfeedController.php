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


    /**
     * Get necessary data for card creation
     *
     * @return string
     */
    public function getNecessaryData()
    {
        $groups = (new NewsFeedGroupController())->getGroups();
        $result = array();
        $i=0;
        foreach ($groups as $group){
            $result[$i]['value'] = json_decode($group['group_tags']);
            $result[$i]['label'] = $group['group_name'];
            ++$i;
        }
        return json_encode($result);
    }

    /**
     * Create news card
     *
     * @param Request $request
     * @return int
     */
    public function newCard(Request $request):int
    {
       $model =  new NewsFeed();

        $model->card_name = $request->card_name;
        $model->published = $request->published;
        $belong = '';
            foreach ($request->belongs_to as $belongs){
                if(count($belongs['value'])>1 and count($belongs['value'])>0){
                    $belong .= implode(" , ", $belongs['value']);
                }else{
                    $belong .= '  '. $belongs['value'][0]. ',  ';
                }
            }
        $model->belongs_to = $belong;
        $model->feed = json_encode(['title' => $request->description, 'text'=>$request->feed_content, 'img'=>'']);
        $model->save();
        return $model->id;
    }

    /**
     * Save news card img
     *
     * @param Request $request
     * @return string
     */
    public function editCardMedia(Request $request)
    {
        if ($request->file('cardimg')->isValid()) {
            $request->validate([
                'cardimg' => 'required|image:jpeg,jpg,png',
            ]);
             NewsFeed::where('id', $request->id)->update(['feed->img'=> '/storage/images/'.$request->cardimg->hashName()]);
            $request->cardimg->store('public/images');
            return 'success';
        }

        return 'fail';
    }

}
