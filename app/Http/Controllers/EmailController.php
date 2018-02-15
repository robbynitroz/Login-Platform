<?php

namespace App\Http\Controllers;

use App\Email;
use App\Hotel;
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
     * Hotel names && IDs
     *
     * @var array
     */
    private $hotels = [];


    /**
     * Store email in DB if not exist
     *
     * @param Request $request
     * @return void
     */
    public function storeEmail(Request $request): void
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'string|nullable',
            'surname' => 'string|nullable'
        ]);
        //if email is longer then 47 symbols exit program, must not throw any error
        if (strlen($request->email) > 47 or strlen($request->name) > 45 or strlen($request->surname) > 45) {
            return;
        }
        $emailModel = new Email();
        $emailModel->email = Crypt::encryptString($request->email);
        if (!empty($request->name)) {
            $emailModel->name = Crypt::encryptString($request->name);
        }
        if (!empty($request->surname)) {
            $emailModel->last_name = Crypt::encryptString($request->surname);
        }
        $emailModel->hotel_id = (int)$request->hotel_id;
        $emailModel->type = $request->login_type;
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
     * @param bool   $api
     * @return void
     */
    public function setData(string $token, bool $api = false): void
    {
        $this->data = ((new SettingController())->getDataWithToken($token, $api));
    }

    /**
     * Check if data empty, means, token was fake
     *
     * @param Request $request
     * @param bool    $api
     * @return void
     */
    private function checkData(Request $request, bool $api = false): void
    {
        if ($this->data !== null) {
            $this->hotels_list = json_decode((json_decode(json_decode($this->data)->setting))->hotels);
            if (count($this->hotels_list) > 1) {
                $model = ((new Hotel())->find($this->hotels_list));
                foreach ($model as $hotel) {
                    $this->hotels[$hotel['id']] = $hotel['name'];
                }
            }
            if ($api !== true) {
                $this->prepareEmailList();
            }
        } else {
            if ($api !== true) {
                $this->blockUser($request->ip());
            }
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
        $model->delete();
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
            $x = 0;
            $hotel_name = '';
            foreach ($this->emails_address as $emails) {
                if (count($this->hotels) > 1) {
                    if ($hotel_name !== $this->hotels[$emails->hotel_id]) {
                        $hotel_name = $this->hotels[$emails->hotel_id];
                        $x = 0;
                    }
                    $this->email_address_array[$hotel_name][$x]['email'] = Crypt::decryptString($emails->email);
                    if (!empty($emails->name)) {
                        $this->email_address_array[$hotel_name][$x]['name'] = Crypt::decryptString($emails->name);
                    }
                    if (!empty($emails->last_name)) {
                        $this->email_address_array[$hotel_name][$x]['lastName'] = Crypt::decryptString($emails->last_name);
                    }
                } else {
                    $this->email_address_array[$x]['email'] = Crypt::decryptString($emails->email);
                    if (!empty($emails->name)) {
                        $this->email_address_array[$x]['name'] = Crypt::decryptString($emails->name);
                    }
                    if (!empty($emails->last_name)) {
                        $this->email_address_array[$x]['lastName'] = Crypt::decryptString($emails->last_name);
                    }
                }
                $x++;
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
    public function downloadEmailsList(): object
    {
        $path = (storage_path('app/email-list/') . $this->file_name . '.json');
        return response()->download($path, 'emails.json')->deleteFileAfterSend(true);;
    }

    /**
     * Store email address with additional data if received
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function apiStoreEmail(Request $request)
    {
        //Can be changed
        if ($request->ip() !== '37.186.103.198') {
            return response('Unauthorized action.', 401);
        }
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'hotel_name' => 'required|string',
            'name' => 'string',
        ]);
        $this->setData($request->token, true);
        if (empty($this->data)) {
            return response('Unauthorized action.', 403);
        }
        $this->checkData($request, true);

        $name = $request->name ?? '';
        $rezult = $this->sortEmailData($request->email, $request->hotel_name, $name);
        if (!empty($rezult)) {
            var_dump($rezult);
            $this->saveEmail($rezult);
        }
        return response('Success', 200);
    }

    /**
     * Sorting received data, preparing data for save in database
     *
     * @param string $email
     * @param string $hotel_name
     * @param string $name
     * @return array
     */
    private function sortEmailData(string $email, string $hotel_name, string $name = ''): array
    {
        $hotel_id = array_search(strtolower($hotel_name), array_map('strtolower', $this->hotels));
        if ($hotel_id === false) {
            return [];
        }
        $data = [
            'hotel_id' => $hotel_id,
            'type'=>'api',
            'email' => $email,
        ];
        if ($name !== '') {
            $with_surname = strrpos($name, " ");
            if (is_int($with_surname)) {
                $user_data = explode(" ", $name);
                if (strlen($user_data[0]) < 45) {
                    $data['name'] = $user_data[0];
                }
                if (strlen($user_data[1]) < 45) {
                    $data['last_name'] = $user_data[1];
                }
            } else {
                if (strlen($name) < 45) {
                    $data['name'] = $name;
                }
            }
        }
        return $data;
    }

    /**
     * Save given data in database
     *
     * @param array $data
     * @return void
     */
    private function saveEmail(array $data): void
    {
        if (strlen($data['email']) > 47) {
            return;
        }
        $model = new Email();
        $model->hotel_id = $data['hotel_id'];
        $model->type = $data['type'];
        $model->email = Crypt::encryptString($data['email']);
        if (array_key_exists("name", $data)) {
            $model->name = Crypt::encryptString($data['email']);
        }
        if (array_key_exists("last_name", $data)) {
            $model->last_name = Crypt::encryptString($data['last_name']);
        }
        $model->save();
    }

}
