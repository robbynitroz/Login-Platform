<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;

class Login extends Controller
{
    //
    public function getData(Request $request)
    {
        //testing a solution



      $data = new Template();

      $result= $data->find(1);

       return view('login.login', ['data'=>$result, 'ip_address'=>$request->ip()]);



    }

}
