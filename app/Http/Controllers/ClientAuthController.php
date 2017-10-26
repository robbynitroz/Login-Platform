<?php

namespace App\Http\Controllers;

use App\ClientAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\EmailController;

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


    /**
     * @param Request $request
     */
    public function getEmailAuth(Request $request)
    {

        if($request->has('email')){
            //Enail auth request here
            $request->validate([
                'email' => 'required|email|max:250|min:6',
            ]);

            $this->addNewClient($request->hotel_id, $request->mac_address, $request->login_type);
            (new EmailController())->storeEmail($request->email, $request->hotel_id, $request->login_type);

            echo 'Yes';

        }else{
            echo json_encode(['error'=>'Something went wrong']);
        }

    }


    /**
     * @param $hotel_id
     * @param $mac_address
     * @param $login_type
     */
    private function addNewClient($hotel_id, $mac_address, $login_type)
    {

        $clientAuth= (new ClientAuth())
            ->where('hotel_id', $hotel_id)
            ->where('method', $login_type)
            ->where('mac_address', $mac_address);

        if($clientAuth->get()->isEmpty()){
            $newclientAuth= new ClientAuth();
            $newclientAuth->hotel_id = $hotel_id;
            $newclientAuth->method = $login_type;
            $newclientAuth->mac_address = $mac_address;
            $newclientAuth->save();
        };
    }

}
