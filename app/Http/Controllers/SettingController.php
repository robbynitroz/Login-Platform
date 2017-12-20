<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

/**
 * Class SettingController
 * @package App\Http\Controllers
 */
class SettingController extends Controller
{
    /**
     * Get email schedule time and store it in Redis
     * @return string
     */
    public static function getEmailSchedule():string
    {

        if (Redis::get('email_schedule') === null) {
            $setting = Setting::where('type', 'email_schedule')->first();
            Redis::set('email_schedule', $setting->setting);
        }
        return Redis::get('email_schedule');
    }

    /**
     * Store last saved email id in DB
     *
     * @param int $last_id
     * @return void
     */
    public function storeEmailScheduleLastID(int $last_id):void
    {
        Redis::del('email_schedule');
        Setting::where('type', 'email_schedule')->update(['setting->last_id' => $last_id]);
        self::getEmailSchedule();
    }

}
