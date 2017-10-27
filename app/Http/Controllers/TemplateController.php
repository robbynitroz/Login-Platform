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
        Redis::del('templates.'.$hotel_id);
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
        Redis::del("Nas".$hotel_id);
        if (Redis::get('templates.reserved.' . $hotel_id) === null) {
            $this->user_templates = (new Template())->where('hotel', $hotel_id)->where('type',
                'reserved')->where('type', 'login')->get();
            Redis::set('templates.reserved.' . $hotel_id, json_encode($this->user_templates));
        }
        return Redis::get('templates.reserved.' . $hotel_id);
    }
}
