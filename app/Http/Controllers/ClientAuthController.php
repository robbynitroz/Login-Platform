<?php

namespace App\Http\Controllers;

use App\ClientAuth;
use Illuminate\Http\Request;

/**
 * Class ClientAuthController, meant for hotel clients authorization for using Mikrotik WiFi
 * @package App\Http\Controllers
 */
class ClientAuthController extends Controller
{
    /**
     * Check if user is new or already have used the platform
     *
     * @param int $hotel_id
     * @param string $clientMac
     * @return boolean
     */
    public function checkIfExist(int $hotel_id, string $clientMac)
    {
        $clientAuth= (new ClientAuth())->where('hotel_id', $hotel_id)->where('mac_address', $clientMac);
        return ($clientAuth->get()->isNotEmpty());
    }


    public function getAuth(Request $request)
    {

        if($request->has('email')){
            //Enail auth request here
            $request->email;
        }else{
            //other actions heres
        }
    }

}
