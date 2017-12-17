<?php

namespace App\Http\Controllers;

use App\Nas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;


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

    /**
     * Delete router and OVPN setting from filesystem
     *
     * @param Request $reqouest
     */
    public function deleteRouter(Request $request): void
    {
        $router = Nas::find($request->id);
        $secret = $router->secret;
        Storage::disk('local')->delete('ccd/' . $secret);
        $router->forceDelete();
    }

    /**
     * Get router by ID
     *
     * @param Request $request
     * @return mixed
     */
    public function getRouterByID(Request $request)
    {
        return Nas::find($request->id);
    }


    /**
     * Edit router
     *
     * @param Request $request
     * @return string
     */
    public function editRouter(Request $request)
    {
        $router = Nas::find($request->id);
        $data = $request->data;
        $router->description = $data['description'];
        $router->shortname = $data['shortname'];
        $router->hotel_id = $data['hotel_id'];
        $router->mikrotik_password = $data['mikrotik_password'];
        $router->mikrotik_username = $data['mikrotik_username'];
        $router->wanmac = $data['wanmac'];
        $router->save();

        return 'success';
    }

}
