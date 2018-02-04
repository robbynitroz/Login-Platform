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
     * @param int    $hotel_id
     * @param string $clientMac
     * @return boolean
     */
    public function checkIfExist(int $hotel_id, string $clientMac): bool
    {
        $clientAuth = (new ClientAuth())->where('hotel_id', $hotel_id)->where('mac_address', $clientMac);
        return ($clientAuth->get()->isNotEmpty());
    }

    /**
     * Register Mikrotik user when login method used
     *
     * @param Request $request
     * @return string
     */
    public function getLoginAuth(Request $request): string
    {
        if ($request->ajax()) {
            $this->addNewClient((int)$request->hotel_id, $request->mac_address, $request->login_type);
            return "http://" . $request->ip() . ":64873/login?username=" . $request->mac_address . "&password=" . $request->mac_address . "&dst=" . $request->hotel_url;


        } else {
            return json_encode(['error' => 'Something went wrong']);

        }
    }

    /**
     * Add new Mikrotik client
     *
     * @param $hotel_id int
     * @param $mac_address string
     * @param $login_type string
     * @return void
     */
    private function addNewClient(int $hotel_id, string $mac_address, string $login_type): void
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
     * Process request from email login method, check if email exist, pass request to EmailController
     *
     * @param Request $request
     * @return string
     */
    public function getEmailAuth(Request $request): string
    {

        if ($request->ajax()) {
            $this->addNewClient((int)$request->hotel_id, $request->mac_address, $request->login_type);
            if ($request->filled('email')) {
                (new EmailController())->storeEmail($request->email, (int)$request->hotel_id, $request->login_type);
            }
            return "http://" . $request->ip() . ":64873/login?username=" . $request->mac_address . "&password=" . $request->mac_address . "&dst=" . $request->hotel_url;

        } else {
            return json_encode(['error' => 'Something went wrong']);

        }
    }

}
