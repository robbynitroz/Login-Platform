<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;

/**
 * Class SettingController
 * @package App\Http\Controllers
 */
class SettingController extends Controller
{

    /**
     * Get data by token
     *
     * @param string $token
     * @return mixed
     */
    public function getDataWithToken(string $token)
    {
        return ((new Setting())->where('setting->token', $token)->first());
    }


    /**
     * Store last saved email id in DB
     *
     * @param int $last_id
     * @return void
     */
    public function storeEmailScheduleLastID(int $last_id): void
    {
        Redis::del('email_schedule');
        Setting::where('type', 'email_schedule')->update(['setting->last_id' => $last_id]);
        self::getEmailSchedule();
    }

}
