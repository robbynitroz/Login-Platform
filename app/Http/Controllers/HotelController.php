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

    /**
     * Single hotel data
     *
     * @var mixed $single_hotel
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

    /**
     * Get single hotel by id for administrator
     *
     * @param int $id
     * @return mixed
     */
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
     * All releted templates
     *
     * @param Request $request
     * @return mixed
     */
    public function getHotelTemplates(Request $request, $id = false)
    {
        if ($id) {
            return (Hotel::find($id))->templates;
        }
        return (Hotel::find($request->id))->templates;
    }

    /**
     * All releted routers
     *
     * @param Request $request
     * @return mixed
     */
    public function getHotelRouters(Request $request)
    {
        return (Hotel::find($request->id))->nas;
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
        (new NasController())->deleteHotelRouters((int)$id);
        $hotel = (Hotel::find($id))->delete();
        return 'Success';
    }

    /**
     * Edit/update hotel information
     *
     * @param Request $request
     */
    public function editHotel(Request $request)
    {
        $updateHotel = (Hotel::find($request->id));
        $updateHotel->name = $request->hotel['name'];
        $updateHotel->main_url = $request->hotel['main_url'];
        $updateHotel->facebook_url = $request->hotel['facebook_url'];
        $updateHotel->session_timeout = $request->hotel['session_timeout'];
        if ($request->timezone) {
            $updateHotel->timezone = $request->timezone;
        }
        $updateHotel->save();
        Redis::del('hotel.' . $request->id);
    }

    /**
     * Update/edit hotel logo
     *
     * @param Request $request
     * @return string
     */
    public function editHotelFiles(Request $request)
    {
        if ($request->file('logo')->isValid()) {
            $request->validate([
                'logo' => 'required|image:jpeg,jpg,png',
            ]);
            $updateHotelLogo = (Hotel::find($request->id));
            $updateHotelLogo->logo = $request->logo->hashName();
            $request->logo->store('public/images');
            $updateHotelLogo->save();
            return 'success';
        }
        return 'fail';
    }

    /**
     * Create new hotel
     *
     * @param Request $request
     * @return int
     */
    public function newHotel(Request $request): int
    {
        $newHotel = new Hotel();
        $newHotel->name = $request->hotel['name'];
        $newHotel->main_url = $request->hotel['main_url'];
        $newHotel->facebook_url = $request->hotel['facebook_url'];
        $newHotel->session_timeout = $request->hotel['session_timeout'];
        $newHotel->timezone = $request->timezone;
        $newHotel->save();
        return $newHotel->id;
    }


}
