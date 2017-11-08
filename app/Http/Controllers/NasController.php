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
    public function getNas(string $ip):string
    {

        if(Redis::get("Nas.".$ip)===null){
            $nas_profile = Nas::where('nasname', $ip)->get();
            Redis::set('Nas.'.$ip, json_encode($nas_profile));
        }
        return Redis::get("Nas.".$ip);
    }

}
