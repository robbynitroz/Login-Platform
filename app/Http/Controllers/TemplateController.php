<?php

namespace App\Http\Controllers;

use App\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;


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
        Redis::del('templates.' . $hotel_id);
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
        Redis::del("templates.reserved." . $hotel_id);

        if (Redis::get('templates.reserved.' . $hotel_id) === null) {
            $this->user_templates = (new Template())->where('hotel', $hotel_id)->where('type',
                'reserved')->get();
            Redis::set('templates.reserved.' . $hotel_id, json_encode($this->user_templates));
        }
        return Redis::get('templates.reserved.' . $hotel_id);
    }


    /**
     * Get necessary data for page
     *
     * @return array
     */
    public function getLoginMethods()
    {
        $hotels = (new HotelController())->getHotels();
        return ['methods' => ['Login', 'Email', 'Facebook'], 'hotels' => $hotels];
    }

    /**
     * Create new template in DB
     *
     * @param Request $request
     * @return mixed
     */
    public function newTemplate(Request $request)
    {

        $newTemplate = new Template();
        $newTemplate->hotel = (int)$request->hotelID;
        $newTemplate->type = $request->defaultComponent;
        $newTemplate->data = json_encode(
            [
                'texts' => $request->texts,
                'langs' => $request->langs,
                'requireName' => $request->requireName,
                'requireEmail' => $request->requireEmail,
                'button' => $request->button,
                'policy' => $request->policy,
                'greeting' => $request->greeting,
                'hotelLogo' => $request->hotelLogo,
                'greetingsTime' => $request->greetingsTime,
                'activeComponent' => $request->activeComponent,
                'defaultComponent' => $request->defaultComponent,
                'backgroundColor' => $request->backgroundColor,
                'littleTextColor' => $request->littleTextColor,
                'media' => ['src' => '', 'type' => ''],
                'hotelLogo' => ''
            ], JSON_FORCE_OBJECT
        );

        //if template is schedule
        if ($request->schedule) {
            $newTemplate->scheduled = 'yes';
            $newTemplate->schedule_start_time = date("Y-m-d H:i:s", (int)substr($request->startTime, 0, 10));
            $newTemplate->schedule_end_time = date("Y-m-d H:i:s", (int)substr($request->endTime, 0, 10));
            $newTemplate->activated = 'yes';
        }

        $newTemplate->save();
        return $newTemplate->id;
    }


    public function mediaFiles(Request $request)
    {
        if ($request->file('logo')->isValid() or $request->file('background')->isValid()) {
            $request->validate([
                'logo' => 'image:jpeg,jpg,png',
                'background' => 'mimes:jpeg,jpg,bmp,png,mp4,mpeg4',
            ]);

            if ($request->id == 'preview') {
                $videoPath = 'tmp';
                $imagePath = $videoPath;
            } else {
                $videoPath = 'videos';
                $imagePath = 'images';
            }
            if ($request->logo) {
                $hotelLogo = $request->logo->hashName();
                $request->logo->store('public/images');
            }

            if ($request->background) {
                $media = array();
                $media['type'] = $request->background->getClientOriginalExtension();

                if ($media['type'] == 'mp4' or $media['type'] == 'mpeg4') {
                    $media['src'] = '/storage/' . $videoPath . '/' . $request->background->hashName();
                    $request->background->store('public/' . $videoPath);
                } else {
                    $media['src'] = '/storage/' . $imagePath . '/' . $request->background->hashName();
                    $request->background->store('public/' . $imagePath);
                }
            }
            if ($videoPath !== 'tmp') {
                $this->saveFileNames($request->id, $hotelLogo, $media);
            } else {
             return  $this->previewFiles((int)$request->identity, $hotelLogo, $media);
            }

        }
        return 'success';
    }


    public function saveFileNames(int $id, string $hotelLogo, array $media): void
    {

        $templateModel = (Template::find($id));
        $jsonData = $templateModel->data;
        $data = json_decode($jsonData);

        //Prepare old files if exist
        $oldFiles = array();

        if ($data->media->src != '') {
            array_push($oldFiles, $data->media->src);
        }

        if ($data->hotelLogo != '') {
            array_push($oldFiles, $data->hotelLogo);
        }

        //Delete old files if exist
        $this->destroyFiles($oldFiles);

        $data->media = $media;
        $data->hotelLogo = $hotelLogo;
        $templateModel->data = json_encode($data, JSON_FORCE_OBJECT);
        $templateModel->save();

    }


    public function destroyFiles(array $files): void
    {
        Storage::delete($files);
    }

    public function previewFiles(int $identity, string $hotelLogo, array $media)
    {
        $jsonData = Redis::get('data-' . $identity);
        $data = json_decode($jsonData);

        $data->media = $media;
        $data->hotelLogo = $hotelLogo;
        $newData = json_encode($data, JSON_FORCE_OBJECT);
        Redis::set('data-' . $identity, $newData, 300);

        return $identity;

    }

    public function preparePreview(Request $request)
    {
        $data = json_encode(
            [
                'texts' => $request->texts,
                'langs' => $request->langs,
                'requireName' => $request->requireName,
                'requireEmail' => $request->requireEmail,
                'button' => $request->button,
                'policy' => $request->policy,
                'greeting' => $request->greeting,
                'hotelLogo' => $request->hotelLogo,
                'greetingsTime' => $request->greetingsTime,
                'activeComponent' => $request->activeComponent,
                'defaultComponent' => $request->defaultComponent,
                'backgroundColor' => $request->backgroundColor,
                'littleTextColor' => $request->littleTextColor,
                'media' => ['src' => '', 'type' => ''],
                'hotelLogo' => ''
            ], JSON_FORCE_OBJECT
        );

        $timestamp = Carbon::now()->timestamp;
        Redis::set('data-' . $timestamp, $data, 300);

        return $timestamp;

    }

    public function preview(Request $request)
    {

       $data=  Redis::get('data-' . $request->id);

        return view('clients.login', [
            'data' => $data,
            'type' => 'preview',
            'hotel' =>
                [
                    'id' => 'Preview',
                    'name' => 'Preview',
                    'url' => 'google.com',
                    'facebook_url' => 'Preview',
                ],
            'ip_address' => $request->ip(),
            'lang' => 'en',
            'mac_address' => '',
            'theme_color'=>str_replace('background:', '', ((json_decode($data))->backgroundColor))
        ]);

    }

}
