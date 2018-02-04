<?php

namespace App\Http\Controllers;

use App\Setting;
use DB;
use Illuminate\Http\Request;


/**
 * Class SettingController
 * @package App\Http\Controllers
 */
class SettingController extends Controller
{

    /**
     * Radacct table rows count
     *
     * @var int $count_radacct
     */
    private $count_radacct;

    /**
     * client_auths table rows count
     *
     * @var int $count_client_auths
     */
    private $count_client_auths;

    /**
     * radcheck table rows count
     *
     * @var int $count_radcheck
     */
    private $count_radcheck;

    /**
     * Utilisation percent
     *
     * @var int $utilisation_percent
     */
    private $utilisation_percent;


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
    public function newEmailsSettings(Request $request): int
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
            'hotels' => json_encode($request->hotels)
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
    public function editEmailsSettings(Request $request): void
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

    /**
     * Register utilizations
     *
     * @return void
     */
    public function utilitiesRegister(): void
    {
        $this->utilizeDatabase();
    }

    /**
     * Database utilizations mechanism
     *
     * @return void
     */
    protected function utilizeDatabase(): void
    {
        $this->setCountTables();
        $this->setUtilisationPercent();
        $this->deleteUnusefulRaws();
    }

    /**
     * Set count properties, count tables
     *
     * @return void
     */
    private function setCountTables(): void
    {
        $this->count_radacct = DB::table('radacct')->where('nasporttype', 'Wireless-802.11')->count();
        $this->count_client_auths = DB::table('client_auths')->count();
        $this->count_radcheck = DB::table('radcheck')->where('router', 'no')->count();
    }

    /**
     * Set utilisation percent to be deleted from tables
     *
     * @return void
     */
    public function setUtilisationPercent(): void
    {
        $model = Setting::where('type', 'database_utilisation')->first();
        $model = $model->setting;
        $this->utilisation_percent = json_decode($model)->utilize;
        $this->utilisation_percent;
    }

    /**
     * Delete old, not in use anymore data from DB
     *
     * @return void
     */
    private function deleteUnusefulRaws(): void
    {
        $limit = $this->getLimit($this->count_radacct);
        DB::table('radacct')->where('nasporttype', 'Wireless-802.11')->limit($limit)->delete();
        $limit = $this->getLimit($this->count_client_auths);
        DB::table('client_auths')->limit($limit)->delete();
        $limit = $this->getLimit($this->count_radcheck);
        if ($limit % 2 !== 0) {
            $limit += 1;
        }
        DB::table('radcheck')->where('router', 'no')->limit($limit)->delete();
        unset($limit);
    }

    /**
     * Get the percentage of rows to be deleted
     *
     * @param int $number
     * @return int
     */
    private function getLimit(int $number): int
    {
        return (int)(($number * $this->utilisation_percent) / 100);
    }

}
