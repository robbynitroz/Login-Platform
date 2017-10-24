<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Support\Facades\Redis;


/**
 * Class TemplateController
 * @package App\Http\Controllers
 */
class TemplateController extends Controller
{
    //

    /**
     * @var
     */
    public $user_templates;

    /**
     * @param $hotel_id
     * @return mixed
     */
    public function getTemplates($hotel_id)
    {
         Redis::del('templates.'.$hotel_id);
        if (Redis::get('templates.' . $hotel_id) === null) {
            $this->user_templates = Template::where('hotel', $hotel_id)->get();
            Redis::set('templates.' . $hotel_id, json_encode($this->user_templates));
        }
        return Redis::get('templates.' . $hotel_id);
    }

}
