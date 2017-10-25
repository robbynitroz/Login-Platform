<?php

namespace App\Http\Controllers;

use App\ClientAuth;
use Illuminate\Http\Request;

class ClientAuthController extends Controller
{
    public function checkIfExist(int $hotel_id, string $clientMac)
    {
        $clientAuth= (new ClientAuth())->where('hotel_id', $hotel_id)->where('mac_address', $clientMac);
        return ($clientAuth->get()->isNotEmpty());
    }


    public function getAuth(Request $request)
    {

    }

}
