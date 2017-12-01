<?php

namespace App\Http\Controllers;

use App\Hotel;
use Illuminate\Http\Request;
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
            Redis::set('hotel.' . $hotelID, json_encode($this->single_hotel));
        }
        return Redis::get('hotel.' . $hotelID);
    }

    public function getHotelAdmin(int $id)
    {
        return Hotel::find($id);
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
        Redis::del('hotel.' . $id);
        $templates = (Hotel::find($id))->templates()->delete();
        $hotel = (Hotel::find($id))->delete();
        return 'Success';
    }

    public function editHotel(Request $request)
    {


        $updateHotel=(Hotel::find($request->id));
        $updateHotel->name=$request->hotel['name'];
        $updateHotel->main_url=$request->hotel['main_url'];
        $updateHotel->facebook_url=$request->hotel['facebook_url'];
        $updateHotel->session_timeout=$request->hotel['session_timeout'];
        if ($request->timezone){
            $updateHotel->timezone= $request->timezone;
        }

        $updateHotel->save();

        Redis::del('hotel.' . $request->id);
    }


}
