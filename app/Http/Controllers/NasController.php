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
        Redis::del("Nas." . $secret);
        Storage::disk('local')->delete('ccd/' . $secret);
        $router->forceDelete();
    }

    /**
     * Delete all routers releted to Hotel (by id)
     *
     * @param int $id
     * @return string
     */
    public function deleteHotelRouters(int $id)
    {
        $routers = (new Nas())->where('hotel_id', $id)->get();
        foreach ($routers as $router){
            $ids[]=$router['id'];
            Redis::del("Nas." . $router['nasname']);
            Storage::disk('local')->delete('ccd/' . $router['nasname']);
        }

        (new Nas())->where('hotel_id', $id)->forceDelete();
        return 'Success';
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

    /**
     * Check router IP
     *
     * @param Request $request
     * @return string
     */
    public function addRouter(Request $request)
    {
        $ids = Nas::allIPs();
        $result=array();
        foreach ($ids as $id){
            preg_match('~(?<=\.)[^.]*$~', $id->nasname, $i);
            $result[]=$i[0];
        }
        $new_IP='';
        for ($i = 5; $i <= 255; $i++) {
            if(!in_array((string)$i, $result, true)){
                $new_IP= $i;
                break;
            }
        }
        if(is_int ($new_IP)){
            return $this->newRouter($request, $new_IP);
        }
        return 'Special error';
    }


    /**
     * Add new router
     *
     * @param Request $request
     * @param $ip
     * @return void
     */
    public function newRouter(Request $request, $ip):void
    {
        $new_router = new Nas();
        $data = $request->data;
        $new_ip = '192.168.253.'.$ip;
        Storage::disk('local')->put('ccd/' . $new_ip, "ifconfig-push $new_ip 255.255.255.0");
        chmod ( base_path() .'/storage/app/ccd/'. $new_ip ,777);
        $new_router->nasname = $new_ip;
        $new_router->secret = $new_ip;
        $new_router->shortname = $data['shortname'];
        $new_router->hotel_id = $data['hotel_id'];
        $new_router->description = $data['description'];
        $new_router->wanmac = $data['wanmac'];
        $new_router->mikrotik_username = $data['mikrotik_username'];
        $new_router->mikrotik_password = $data['mikrotik_password'];
        $new_router->wifi = true;
        $new_router->save();
    }

}
