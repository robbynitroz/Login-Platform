<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use App\Http\Controllers\NasController;

class Login extends Controller
{
    //
    public function getData(Request $request)
    {
        //testing a solution

        if($request->clientmac !== null){


            $nas_result= (new NasController())->getHotel('192.168.253.12');



            //$nas_result->templates();

            dd($nas_result->id);

            $data = new Template();



            return view('login.login', ['data'=>$result, 'ip_address'=>$request->ip()]);
        }else{
            return redirect('http://192.168.88.1/login?dst=http://login.com');
        }



    }

}
