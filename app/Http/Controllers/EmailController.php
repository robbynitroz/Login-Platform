<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

/**
 * Class EmailController
 * @package App\Http\Controllers
 */
class EmailController extends Controller
{

    /**
     * Email address list, Model
     *
     * @var object $emails_address
     */
    public $emails_address;

    /**
     * Email address
     *
     * @var array
     */
    public $email_address_array = array();

    /**
     * File name (UNIX timestamp)
     *
     * @var int $file_name
     */
    public $file_name;

    /**
     * In case if no emails in DB
     *
     * @var bool
     */
    public $empty = false;

    /**
     * Wrong token attempts
     *
     * @var int
     */
    public $attempts = 0;

    /**
     * Hotels id list
     *
     * @var array $hotels_list
     */
    protected $hotels_list;

    /**
     * Data received from model
     *
     * @var mixed $data
     */
    private $data;

    /**
     * Store email in DB if not exist
     *
     * @param string $email
     * @param int    $hotel_id
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
     * Entry point, run necessary methods
     *
     * @param Request $request
     * @return $this|string
     */
    public function emailList(Request $request)
    {
        $this->setData($request->token);
        $this->checkData($request);

        if ($this->attempts > 0) {
            return 'Wrong token! You have left: ' . (3 - $this->attempts);
        }

        if ($this->empty === false) {
            return $this->downloadEmailsList();
        } else {
            return "Empty";
        }
    }

    /**
     * Set data
     *
     * @param string $token
     */
    public function setData(string $token)
    {
        $this->data = ((new SettingController())->getDataWithToken($token));
    }

    /**
     * Check if data empty, means, token was fake
     *
     * @param Request $request
     */
    private function checkData(Request $request): void
    {
        if ($this->data !== null) {
            $this->hotels_list = json_decode((json_decode(json_decode($this->data)->setting))->hotels);
            $this->prepareEmailList();
        } else {
            $this->blockUser($request->ip());
        }
    }

    /**
     * Getting emails columns from Email model
     *
     * @return void
     */
    protected function prepareEmailList(): void
    {
        $model = ((new Email())->whereIn('hotel_id', $this->hotels_list));
        $this->emails_address = $model->get();
        //$model->delete();
        $this->prepareEmailListForDownload();
    }

    /**
     * If emails exist, setting up emails in right format, save as json file in filesystem
     *
     * @return void
     */
    public function prepareEmailListForDownload(): void
    {
        if (($this->emails_address)->count() > 0) {
            foreach ($this->emails_address as $emails) {
                $this->email_address_array[] = Crypt::decryptString($emails->email);
            }
            $this->file_name = time();
            Storage::disk('local')->put('email-list/' . $this->file_name . '.json',
                json_encode($this->email_address_array));
        } else {
            $this->empty = true;
        };
    }

    /**
     * Blocking mechanism, setup attempts in Redis with expiration of 30 min
     *
     * @param string $ip
     */
    public function blockUser(string $ip): void
    {
        if (Redis::get("intruder-" . $ip) === null) {
            Redis::set("intruder-" . $ip, 1);
            Redis::expire("intruder-" . $ip, 1800);
            $this->attempts = 1;
        } else {
            $attempts = Redis::get("intruder-" . $ip);
            $this->attempts = $attempts + 1;
            Redis::set("intruder-" . $ip, $this->attempts);
            Redis::expire("intruder-" . $ip, 1800);
        }
    }

    /**
     * File download and removal from DB
     *
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function downloadEmailsList()
    {
        $path = (storage_path('app/email-list/') . $this->file_name . '.json');
        return response()->download($path, 'emails.json')->deleteFileAfterSend(true);;
    }

}
