<?php

namespace App\Http\Controllers;

use App\Nas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


/**
 * Class NasController
 * @package App\Http\Controllers
 */
class NasController extends Controller
{


    /**
     * Fetch NAS infro from DB and store in Redis or fetch NAS from Redis if exist
     *
     * @param string $ip
     * @return string
     */
    public function getNas(string $ip): string
    {

        if (Redis::get("Nas." . $ip) === null) {
            $nas_profile = Nas::where('nasname', $ip)->get();
            Redis::set('Nas.' . $ip, json_encode($nas_profile));
        }
        return Redis::get("Nas." . $ip);
    }


    /**
     * Get Routers by hotel ID
     *
     * @param Request $request
     * @return mixed
     */
    public function getHotelRouters(Request $request)
    {
        return (new HotelController())->getHotelRouters($request);
    }

    /**
     * Get all routers
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllRouters(Request $request)
    {
        return Nas::all();
    }

    public function deleteRouter(Request $reqouest):void
    {
        (Nas::find($reqouest->id))->forceDelete();
    }


}
