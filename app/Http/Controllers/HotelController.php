<?php

namespace App\Http\Controllers;

use App\Hotel;
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


}
