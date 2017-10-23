<?php

namespace App\Http\Controllers;

use App\Radcheck;

class RadcheckController extends Controller
{
    //

    public static function newClient(string $clientMac)
    {

        $data= array(

                [
                    'username' => $clientMac,
                    'attribute' => 'User-Password',
                    'op' => '==',
                    'value' => $clientMac
                ],
                [
                    'username' => $clientMac,
                    'attribute' => 'Auth-Type',
                    'op' => ':=',
                    'value' =>'Accept'
                ]

        );

        Radcheck::insert($data);
    }
}
