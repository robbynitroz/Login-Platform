<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class Login
 * @package App\Http\Controllers
 */
class Login extends Controller
{


    /**
     * @var
     */
    public $nas_info;

    /**
     * @var
     */
    public $templates;


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getData(Request $request)
    {

        if ($request->clientmac !== null) {
            RadcheckController::newClient($request->clientmac);
            $this->nas_info = (new NasController())->getNas($request->ip());
            $hotel_id = (json_decode($this->nas_info)[0])->hotel_id;
            return $this->processData($hotel_id, $request);
        } else {
            return redirect('http://192.168.88.1/login');
        }

    }


    /**
     * @param int $hotel_id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function processData(int $hotel_id, Request $request)
    {
        $this->templates = (new TemplateController())->getTemplates($hotel_id);
        $template = json_decode($this->templates);

        if (empty($template)) {
            return redirect("http://" . $request->ip() . ":64873/login?username=" . $request->clientmac . "&password=" . $request->clientmac);
        }
        if (count($template) === 1) {
            return $this->serveLoginTemplate($template[0], $request);
        } else {
            return $this->checkScheduledTemplate($hotel_id, $template, $request);
        }
    }


    /**
     * @param int $hotel_id
     * @param $templates
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkScheduledTemplate(int $hotel_id, $templates, Request $request)
    {

        $hotels = (new HotelController())->getHotel($hotel_id);
        $timezone = json_decode($hotels)->timezone;
        foreach ($templates as $template) {
            if ($template->scheduled == 'yes') {
                $hotel_time = (Carbon::now($timezone))->timestamp;
                $start_time = (Carbon::createFromFormat('Y-m-d H:i:s', $template->schedule_start_time))->timestamp;
                $end_time = (Carbon::createFromFormat('Y-m-d H:i:s', $template->schedule_end_time))->timestamp;
                if ($hotel_time > $start_time and $hotel_time < $end_time) {
                    $scheduled_template[] = $template;
                }
            } else {
                $main_template[] = $template;
            }
        }

        if (isset($scheduled_template)) {
            return $this->serveLoginTemplate($scheduled_template[0], $request);
        }

        return $this->serveLoginTemplate($main_template[0], $request);
    }

    /**
     * @param $template
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serveLoginTemplate($template, Request $request)
    {
        return view('login.login', ['data' => $template->data, 'ip_address' => $request->ip()]);
    }

}
