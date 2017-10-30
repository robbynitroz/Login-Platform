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
        $clientAuth = (new ClientAuth())->where('hotel_id', $hotel_id)->where('mac_address', $clientMac);
        return ($clientAuth->get()->isNotEmpty());
    }


    /**
     * Check request
     *
     * @param Request $request
     * @return string
     */
    public function getEmailAuth(Request $request)
    {

        if ($request->ajax()) {

            $this->addNewClient($request->hotel_id, $request->mac_address, $request->login_type);
            if(!empty($request->email)) {
                (new EmailController())->storeEmail($request->email, (int)$request->hotel_id, $request->login_type);
            }
            return "http://" . $request->ip() . ":64873/login?username=" . $request->mac_address . "&password=" . $request->mac_address . "&dst=" . $request->hotel_url;

        } else {
            return json_encode(['error' => 'Something went wrong']);
        }

    }

    /**
     * Add new client
     *
     * @param $hotel_id
     * @param $mac_address
     * @param $login_type
     */
    private function addNewClient($hotel_id, $mac_address, $login_type)
    {

        $clientAuth = (new ClientAuth())
            ->where('hotel_id', $hotel_id)
            ->where('method', $login_type)
            ->where('mac_address', $mac_address);

        if ($clientAuth->get()->isEmpty()) {
            $newclientAuth = new ClientAuth();
            $newclientAuth->hotel_id = $hotel_id;
            $newclientAuth->method = $login_type;
            $newclientAuth->mac_address = $mac_address;
            $newclientAuth->save();
        };
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getLoginAuth(Request $request)
    {
        if ($request->ajax()) {
            $this->addNewClient($request->hotel_id, $request->mac_address, $request->login_type);
            return "http://" . $request->ip() . ":64873/login?username=" . $request->mac_address . "&password=" . $request->mac_address . "&dst=" . $request->hotel_url;


        } else {
            return json_encode(['error' => 'Something went wrong']);
        }
    }

}
