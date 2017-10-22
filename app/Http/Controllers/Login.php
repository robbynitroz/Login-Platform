<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Login extends Controller
{
    //
    public function getData(Request $request)
    {

        if ($request->clientmac !== null) {

            RadcheckController::newClient($request->clientmac);

            if (!Cache::has('data')) {

                $user_template = (new TemplateController())->getTemplate('192.168.253.5');

                if (empty($user_template)) {
                    return redirect("http://" . $request->ip() . ":64873/login?username=" . $request->clientmac . "&password=" . $request->clientmac);
                }

                return $this->processData($user_template, $request);

            } else {
                return view('login.login', ['data' => Cache::get('data'), 'ip_address' => $request->ip()]);

            }
        } else {
            return redirect('http://192.168.88.1/login?dst=http://login.com');
        }

    }


    public function processData(array $process_data, Request $request)
    {
        if (count($process_data) == 1) {
            Cache::forever('data', $process_data[0]->data);
            return view('login.login', ['data' => $process_data[0]->data, 'ip_address' => $request->ip()]);
            //dd($process_data[0]->data);
        }
    }

    public function serveLoginTemplate()
    {
        //testing a solution
        //$noonTodayLondonTime= Carbon::now('Europe/London');

        //dd($noonTodayLondonTime);
    }

}
