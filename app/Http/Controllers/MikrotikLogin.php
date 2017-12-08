<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;


/**
 * Class MikrotikLogin
 * @package App\Http\Controllers
 */
class MikrotikLogin extends Controller
{


    /**
     * Mikrotik client IP address
     *
     * @var string
     */
    public $nas_info;

    /**
     * User template
     *
     * @var object
     */
    public $templates;


    /**
     * Mikrotik client/device MAC address
     *
     * @var string
     */
    public $client_mac;


    /**
     * Get the request see if MAC address received, if yes check the IP address
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getData(Request $request)
    {

        if ($request->has('clientmac')) {
            $this->client_mac = $request->query('clientmac');
            $this->nas_info = (new NasController())->getNas(env('TEST_IP', $request->ip()));
            if(empty(json_decode($this->nas_info))){
                return redirect()->route('base_URL');
            }
            $hotel_id = (json_decode($this->nas_info)[0])->hotel_id;
            (new RadcheckController())->checkClient($this->client_mac, $hotel_id);
            return $this->processData($hotel_id, $request);
        } else {
            return redirect('http://192.168.88.1/login');
        }

    }


    /**
     * Get template
     *
     * @param int $hotel_id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    private function processData(int $hotel_id, Request $request)
    {

        if ((new ClientAuthController())->checkIfExist($hotel_id, $this->client_mac)) {
            $this->templates = (new TemplateController())->getTemplate($hotel_id);
        } else {
            $this->templates = (new TemplateController())->getTemplates($hotel_id);
        }
        $template = json_decode($this->templates);
        if (empty($template)) {
            $hotel = json_decode((new HotelController())->getHotel($hotel_id));
            return redirect("http://" . $request->ip() . ":64873/login?username=" . $this->client_mac . "&password=" . $this->client_mac . "&dst=" . $hotel->main_url);
        }
        if (count($template) === 1) {
            $hotel = json_decode((new HotelController())->getHotel($hotel_id));

            return $this->serveLoginTemplate($template[0], $hotel, $request);
        } else {
            return $this->checkScheduledTemplate($hotel_id, $template, $request);
        }
    }

    /**
     * Return template view to user
     *
     * @param $template
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serveLoginTemplate($template, $hotel, Request $request)
    {

        $lang = $request->server('HTTP_ACCEPT_LANGUAGE');
        $lang = substr($lang, 0, 2);

        if (!isset(json_decode($template->data)->texts->{$lang})) {
            $lang = 'en';
        };

        return view('clients.login', [
            'data' => $template->data,
            'type' => $template->type,
            'hotel' =>
                [
                    'id' => $hotel->id,
                    'name' => $hotel->name,
                    'url' => $hotel->main_url,
                    'facebook_url' => $hotel->facebook_url,
                ],
            'ip_address' => $request->ip(),
            'lang' => $lang,
            'mac_address' => $this->client_mac,
            'theme_color'=>str_replace('background:', '', ((json_decode($template->data))->backgroundColor))
        ]);
    }

    /**
     * Check for schedule template, return template
     *
     * @param int $hotel_id
     * @param $templates
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkScheduledTemplate(int $hotel_id, $templates, Request $request)
    {
        $hotels = json_decode((new HotelController())->getHotel($hotel_id));
        $timezone = $hotels->timezone;
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
            return $this->serveLoginTemplate($scheduled_template[0], $hotels, $request);
        }

        return $this->serveLoginTemplate($main_template[0], $hotels, $request);
    }

}
