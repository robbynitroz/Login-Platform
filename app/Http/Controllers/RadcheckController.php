<?php

namespace App\Http\Controllers;

use App\Radcheck;

class RadcheckController extends Controller
{
    //

    public static function newClient(string $clientMac, int $hotel_id)
    {

        $data= array(

                [
                    'username' => $clientMac,
                    'attribute' => 'User-Password',
                    'op' => '==',
                    'value' => $clientMac,
                    'hotel_id' => $hotel_id

                ],
                [
                    'username' => $clientMac,
                    'attribute' => 'Auth-Type',
                    'op' => ':=',
                    'value' =>'Accept',
                    'hotel_id' => $hotel_id
                ]

        );

        Radcheck::insert($data);
    }
}
