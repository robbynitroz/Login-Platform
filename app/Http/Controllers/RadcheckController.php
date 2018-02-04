<?php

namespace App\Http\Controllers;

use App\Radcheck;

/**
 * Class RadcheckController
 * @package App\Http\Controllers
 */
class RadcheckController extends Controller
{

    /**
     * Check if device registered for Mikrotik auth
     *
     * @param string $clientMac
     * @param int    $hotel_id
     * @return mixed
     */
    public function checkClient(string $clientMac, int $hotel_id)
    {

        $radCheck = new Radcheck();

        if (($radCheck->where('username', $clientMac)->get())->isEmpty()) {
            return $this->newDevice($clientMac, $hotel_id);
        };
        return false;
    }

    /**
     * Create new device credentials for Mikrotik
     *
     * @param string $clientMac
     * @param int    $hotel_id
     * @param string $router
     * @return bool
     */
    public function newDevice(string $clientMac, int $hotel_id, string $router = 'no'): bool
    {
        $data = array(
            [
                'username' => $clientMac,
                'attribute' => 'User-Password',
                'op' => '==',
                'value' => $clientMac,
                'hotel_id' => $hotel_id,
                'router' => $router

            ],
            [
                'username' => $clientMac,
                'attribute' => 'Auth-Type',
                'op' => ':=',
                'value' => 'Accept',
                'hotel_id' => $hotel_id,
                'router' => $router
            ]
        );
        Radcheck::insert($data);
        return true;
    }

}
