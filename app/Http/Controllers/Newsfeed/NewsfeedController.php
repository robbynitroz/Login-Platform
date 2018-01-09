<?php

namespace App\Http\Controllers\Newsfeed;

use App\Http\Controllers\Controller;
use App\NewsFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class NewsfeedController extends Controller
{

    /**
     * Get all feeds based on request
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        $model = new NewsFeed();
        if ($request->hotel_name === null) {
            $hotel_tag = 'all';
        } else {
            $hotel_tag = $request->hotel_name;
        }
        $results = $model->getFeedsByName($hotel_tag);
        $feed = array();
        foreach ($results as $result) {
            $feed[] = json_decode($result->feed);
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
        $i = 0;
        foreach ($groups as $group) {
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
    public function newCard(Request $request): int
    {
        $model = new NewsFeed();

        $model->card_name = $request->card_name;
        $model->published = $request->published;
        $model->groups = json_encode($request->belongs_to);
        $belong = '';
        foreach ($request->belongs_to as $belongs) {
            if (count($belongs['value']) > 1 and count($belongs['value']) > 0) {
                $belong .= implode(" , ", $belongs['value']);
            } else {
                if (isset($belongs['value'][0])) {
                    $belong .= '  ' . $belongs['value'][0] . ',  ';
                }
            }
        }
        $model->belongs_to = $belong;
        $model->feed = json_encode(['title' => $request->description, 'text' => $request->feed_content, 'img' => '']);
        $model->save();
        return $model->id;
    }

    /**
     * Save news card img
     *
     * @param Request $request
     * @return string
     */
    public function editCardMedia(Request $request): string
    {
        if ($request->file('cardimg')->isValid()) {
            $request->validate([
                'cardimg' => 'required|image:jpeg,jpg,png',
            ]);
            $id = $request->id;
            $old_img = $this->getStoredMediaName($id);
            if ($old_img != '') {
                $this->deleteMedia('public/images/' . $old_img);
            }

            $new_img = $request->cardimg->hashName();
            NewsFeed::where('id',
                $id)->update(['feed->img' => '/storage/images/' . $new_img]);
            $request->cardimg->store('public/images');
            return '/storage/images/' . $new_img;
        }

        return 'fail';
    }

    private function getStoredMediaName(int $id): string
    {
        $model = NewsFeed::where('id', $id)->get(['feed']);
        $img = str_replace('/storage/images/', '', (json_decode($model[0]->feed)->img));
        return $img;
    }

    /**
     * Delete card image
     *
     * @param string $path
     * @return void
     */
    public function deleteMedia(string $path): void
    {
        Storage::delete($path);
    }

    /**
     *Get all cards
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCards(Request $request)
    {
        return NewsFeed::all();
    }

    /**
     * Delete card by ID
     *
     * @param Request $request
     * @return void
     */
    public function deleteCard(Request $request): void
    {
        $id = $request->id;
        $img = $this->getStoredMediaName((int)$id);
        if ($img != '') {
            $this->deleteMedia('public/images/' . $img);
        }
        NewsFeed::where('id', $id)->delete();
    }

    public function getCard(Request $request)
    {
        return NewsFeed::find($request->id);
    }

    public function editCard(Request $request)
    {
        $id = $request->id;
        $belong = '';
        foreach ($request->belongs_to as $belongs) {
            if (count($belongs['value']) > 1 and count($belongs['value']) > 0) {
                $belong .= implode(" , ", $belongs['value']);
            } else {
                if (isset($belongs['value'][0])) {
                    $belong .= '  ' . $belongs['value'][0] . ',  ';
                }
            }
        }
        NewsFeed::where('id', $id)
            ->update([
                'card_name'=> $request->card_name,
                'published'=> $request->published,
                'belongs_to'=> $belong,
                'groups'=>json_encode($request->belongs_to),
                'feed->title' => $request->description,
                'feed->text' => $request->feed_content,
            ]);

        return $id;
    }


}
