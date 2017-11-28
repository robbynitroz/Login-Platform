<?php

namespace App\Http\Controllers;

use App\Hotel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redis;

/**
 * Class HotelController
 * @package App\Http\Controllers
 */
class HotelController extends Controller
{
    //

    /**
     * @var
     */
    public $single_hotel;


    /**
     * Fetch hotel info from DB and store in Redis or fetch info from Redis
     *
     * @param int $hotelID
     * @return mixed
     */
    public function getHotel(int $hotelID)
    {
        //Redis::del('hotel.' . $hotelID);
        if (Redis::get('hotel.' . $hotelID) === null) {
            $this->single_hotel = Hotel::find($hotelID);
            Redis::set('hotel.'.$hotelID, json_encode($this->single_hotel));
        }
        return Redis::get('hotel.' . $hotelID);
    }


    /**
     * Get * hotels
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getHotels()
    {
        return Hotel::all();
    }


    /**
     * Delete hotels and related templates
     *
     * @param $id
     * @return string
     */
    public function deleteHotel($id)
    {
        $templates = (Hotel::find($id))->templates()->delete();
        $hotel = (Hotel::find($id))->delete();
        return 'Success';
    }



}
