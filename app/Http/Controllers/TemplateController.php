<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;



/**
 * Class TemplateController
 * @package App\Http\Controllers
 */
class TemplateController extends Controller
{
    /**
     * @var
     */
    public $user_templates;

    /**
     * Get required template from DB or Redis, if template exist in DB cache in Redis
     *
     * @param int $hotel_id
     * @return mixed
     */
    public function getTemplates(int $hotel_id)
    {
        Redis::del('templates.' . $hotel_id);
        if (Redis::get('templates.' . $hotel_id) === null) {
            $this->user_templates = (new Template())->where('hotel', $hotel_id)->where('activated', 'yes')->get();
            Redis::set('templates.' . $hotel_id, json_encode($this->user_templates));
        }
        return Redis::get('templates.' . $hotel_id);
    }

    /**
     * Get specific template, usually used for users already authorized to use WiFi and shown after session timeout
     *
     * @param int $hotel_id
     * @param string $template_type
     * @return mixed
     */
    public function getTemplate(int $hotel_id, string $template_type = 'login')
    {
        Redis::del("templates.reserved." . $hotel_id);

        if (Redis::get('templates.reserved.' . $hotel_id) === null) {
            $this->user_templates = (new Template())->where('hotel', $hotel_id)->where('type',
                'reserved')->get();
            Redis::set('templates.reserved.' . $hotel_id, json_encode($this->user_templates));
        }
        return Redis::get('templates.reserved.' . $hotel_id);
    }


    /**
     * Get necessary data for page
     *
     * @return array
     */
    public function getLoginMethods()
    {
        $hotels = (new HotelController())->getHotels();
        return ['methods'=>['Login', 'Email', 'Facebook'], 'hotels'=>$hotels];
    }

    /**
     * Create new template in DB
     *
     * @param Request $request
     * @return mixed
     */
    public function newTemplate(Request $request)
    {

        $newTemplate = new Template();
        $newTemplate->hotel = (int) $request->hotelID;
        $newTemplate->type = $request->defaultComponent;
        $newTemplate->data = json_encode(
            [
                $request->texts,
                $request->langs,
                $request->requireName,
                $request->requireEmail,
                $request->button,
                $request->policy,
                $request->greeting,
                $request->hotelLogo,
                $request->greetingsTime,
                $request->activeComponent,
                $request->defaultComponent,
                $request->backgroundColor,
                $request->littleTextColor,
            ]
        );

        //if template is schedule
        if($request->schedule){
            $newTemplate->scheduled = 'yes';
            $newTemplate->schedule_start_time= date("Y-m-d H:i:s", (int) substr($request->startTime, 0, 10));
            $newTemplate->schedule_end_time= date("Y-m-d H:i:s", (int) substr($request->endTime, 0, 10));
            $newTemplate->activated = 'yes';
        }

        $newTemplate->save();
        return $newTemplate->id;
    }

}
