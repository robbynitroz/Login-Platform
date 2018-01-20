<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class EmailController
 * @package App\Http\Controllers
 */
class EmailController extends Controller
{
    /**
     * Store email in DB if not exist
     *
     * @param string $email
     * @param int $hotel_id
     * @param string $login_type
     * @return void
     */
    public function storeEmail(string $email, int $hotel_id, string $login_type): void
    {
        if (strlen($email) > 47) {
            return;
        }
        $emailModel = new Email();
        $emailModel->email = Crypt::encryptString($email);
        $emailModel->hotel_id = $hotel_id;
        $emailModel->type = $login_type;
        $emailModel->save();
        return;
    }


    /**
     * Generates email list for hotel management
     *
     * @return void
     */
    public function generateEmailList(): void
    {
        $last_numb = json_decode(SettingController::getEmailSchedule())->last_id;
        $emails = DB::table('emails')
            ->join('hotels', 'emails.hotel_id', '=', 'hotels.id')
            ->select('hotels.name', 'emails.email', 'emails.id')->where('emails.id', '>', $last_numb)
            ->get();
        $result = array();
        foreach ($emails as $email) {
            $result[$email->name][] = $email->email;
            $new_las_id = $email->id;
        }
        if (isset($new_las_id)) {
            (new SettingController())->storeEmailScheduleLastID($new_las_id);
        }
        foreach ($result as $key => $value) {
            Storage::disk('local')->put('ftp/' . $key . '/email.txt', json_encode($value));
        }
    }

}
