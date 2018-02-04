<?php

namespace App\Http\Controllers;

use App\Nas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use PEAR2\Net\RouterOS;


/**
 * Class NasController
 * @package App\Http\Controllers
 */
class NasController extends Controller
{

    /**
     * Fetch NAS infro from DB and store in Redis or fetch NAS from Redis if exist
     *
     * @param string $ip
     * @return string
     */
    public function getNas(string $ip): string
    {
        if (Redis::get("Nas." . $ip) === null) {
            $nas_profile = Nas::where('nasname', $ip)->get();
            Redis::set('Nas.' . $ip, json_encode($nas_profile));
        }
        return Redis::get("Nas." . $ip);
    }

    /**
     * Delete router and OVPN setting from filesystem
     *
     * @param Request $reqouest
     */
    public function deleteRouter(Request $request): void
    {
        $router = Nas::find($request->id);
        $secret = $router->secret;
        Redis::del("Nas." . $secret);
        Storage::disk('local')->delete('ccd/' . $secret);
        $router->forceDelete();
    }

    /**
     * Delete all routers releted to Hotel (by id)
     *
     * @param int $id
     * @return string
     */
    public function deleteHotelRouters(int $id)
    {
        $routers = (new Nas())->where('hotel_id', $id)->get();
        foreach ($routers as $router) {
            $ids[] = $router['id'];
            Redis::del("Nas." . $router['nasname']);
            Storage::disk('local')->delete('ccd/' . $router['nasname']);
        }

        (new Nas())->where('hotel_id', $id)->forceDelete();
        return 'Success';
    }

    /**
     * Get router by ID
     *
     * @param Request $request
     * @return mixed
     */
    public function getRouterByID(Request $request)
    {
        return Nas::find($request->id);
    }

    /**
     * Edit router
     *
     * @param Request $request
     * @return string
     */
    public function editRouter(Request $request)
    {

        $router = Nas::find($request->id);
        $data = $request->data;
        $router->description = $data['description'];
        $router->shortname = $data['shortname'];
        $router->hotel_id = $data['hotel_id'];
        if ($request->mikrotik_username != '') {
            $router->mikrotik_username = Crypt::encryptString($request->mikrotik_username);
        }
        if ($request->mikrotik_password != '') {
            $router->mikrotik_password = Crypt::encryptString($request->mikrotik_password);
        }
        $router->wanmac = $data['wanmac'];
        $router->save();

        Redis::del("Nas." . $data['nasname']);

        return 'success';
    }

    /**
     * Check router IP
     *
     * @param Request $request
     * @return string
     */
    public function addRouter(Request $request)
    {
        $ids = Nas::allIPs();
        $result = array();
        foreach ($ids as $id) {
            preg_match('~(?<=\.)[^.]*$~', $id->nasname, $i);
            $result[] = $i[0];
        }
        $new_IP = '';
        for ($i = 5; $i <= 255; $i++) {
            if (!in_array((string)$i, $result, true)) {
                $new_IP = $i;
                break;
            }
        }
        if (is_int($new_IP)) {
            return $this->newRouter($request, $new_IP);
        }
        return 'Special error';
    }

    /**
     * Add new router
     *
     * @param Request $request
     * @param         $ip
     * @return void
     */
    public function newRouter(Request $request, $ip): void
    {
        $new_router = new Nas();
        $data = $request->data;
        $new_ip = '192.168.253.' . $ip;
        Storage::disk('local')->put('ccd/' . $new_ip, "ifconfig-push $new_ip 255.255.255.0");
        chmod(base_path() . '/storage/app/ccd/' . $new_ip, 777);
        $new_router->nasname = $new_ip;
        $new_router->secret = $new_ip;
        $new_router->shortname = $data['shortname'];
        $new_router->hotel_id = $data['hotel_id'];
        $new_router->description = $data['description'];
        $new_router->wanmac = $data['wanmac'];
        $new_router->mikrotik_username = Crypt::encryptString($data['mikrotik_username']);
        $new_router->mikrotik_password = Crypt::encryptString($data['mikrotik_password']);
        $new_router->wifi = true;
        $new_router->save();
    }

    /**
     * Get mikrotik status
     *
     * @param Request $request
     * @return array
     */
    public function mikrotikStatus(Request $request)
    {

        if ($request->id) {
            $routers = $this->getHotelRouters($request);
        } else {
            $routers = $this->getAllRouters($request);
        }

        $response = array();
        foreach ($routers as $router) {
            try {
                $host = $router->nasname;
                $port = 8728;
                $waitTimeoutInSeconds = 2;
                $fp = fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds);
                fclose($fp);
                $mikrotik_data['ip'] = $router->nasname;
                $mikrotik_data['username'] = Crypt::decryptString($router->mikrotik_username);
                $mikrotik_data['password'] = Crypt::decryptString($router->mikrotik_password);
                $count_users = $this->getNumberOfUsers($mikrotik_data);
                $response[$router->nasname] = array('online' => 'yes', 'users' => $count_users);
            } catch (\Exception $e) {
                //do nothing, we don't need to trow an exception
                $response[$router->nasname] = array('online' => 'no', 'users' => 0);

            }
        }
        return $response;
    }

    /**
     * Get Routers by hotel ID
     *
     * @param Request $request
     * @return mixed
     */
    public function getHotelRouters(Request $request)
    {
        return (new HotelController())->getHotelRouters($request);
    }

    /**
     * Get all routers
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllRouters(Request $request)
    {
        return Nas::all();
    }


    /**
     * Get number of users on Mikrotik
     *
     * @param array $mikrotik_data
     * @return int
     */
    public function getNumberOfUsers(array $mikrotik_data): int
    {
        $util = new RouterOS\Util(
            $client = new RouterOS\Client(
                $mikrotik_data['ip'],
                $mikrotik_data['username'],
                $mikrotik_data['password']
            )
        );
        $response = $util->setMenu('/ip hotspot active')->count();
        return $response;
    }

}
