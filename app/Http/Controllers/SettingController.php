<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;


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
     * Return emails settings
     *
     * @return object
     */
    public function getEmailsSettings(): object
    {
        return Setting::where('type', 'email')->get();
    }


    /**
     * Return email settings by ID
     *
     * @param Request $request
     * @return object
     */
    public function getEmailsSettingsByID(Request $request): object
    {
        return Setting::where('id', $request->id)->get();
    }


    /**
     * Delete setting by ID
     *
     * @param Request $request
     */
    public function deleteSettingByID(Request $request): void
    {
        Setting::find($request->id)->delete();
    }


    /**
     * Create new email setting
     *
     * @param Request $request
     * @return int
     */
    public function newEmailsSettings(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'hotels' => 'required',
            'token' => 'required',
        ]);
        $setting = new Setting();
        $setting->type = 'email';
        $setting->setting = json_encode([
            'name' => $request->name,
            'token' => $request->token,
            'hotels' => $request->hotels
        ]);
        $setting->save();
        return $setting->id;
    }


    /**
     * Update email setting
     *
     * @param Request $request
     * @return void
     */
    public function editEmailsSettings(Request $request):void
    {
        $request->validate([
            'name' => 'required',
            'hotels' => 'required',
            'token' => 'required',
        ]);
        Setting::where('id',
            $request->id)->update([
            'setting->name' => $request->name,
            'setting->token' => $request->token,
            'setting->hotels' => json_encode($request->hotels)
        ]);
    }

}
