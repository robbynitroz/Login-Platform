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
        //Redis::del('templates.' . $hotel_id);
        if (Redis::get('templates.' . $hotel_id) === null) {
            $this->user_templates = (new Template())->where('hotel', $hotel_id)->where('activated', 'yes')->get();
            Redis::set('templates.' . $hotel_id, json_encode($this->user_templates));
        }
        return Redis::get('templates.' . $hotel_id);
    }

    /**
     * Get template by ID
     *
     * @param Request $request
     * @return mixed
     */
    public function getTemplateById(Request $request)
    {
        return Template::find($request->id);
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

        //Redis::del("templates.reserved." . $hotel_id);
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
            $start_date = date("Y-m-d H:i:s", (int)substr($request->startTime, 0, 10));
            $end_date = date("Y-m-d H:i:s", (int)substr($request->endTime, 0, 10));
            if ($this->checkIfBusy($request, $start_date, $end_date)) {
                return 'STOP';
            }
            $newTemplate->scheduled = 'yes';
            $newTemplate->schedule_start_time = $start_date;
            $newTemplate->schedule_end_time = $end_date;
            $newTemplate->activated = 'yes';
        }

        $newTemplate->save();
        return $newTemplate->id;
    }

    /**
     * Check if schedule template dates are busy
     *
     * @param $request
     * @param $start_date
     * @param $end_date
     * @return bool
     */
    public function checkIfBusy($request, $start_date, $end_date)
    {
        $id = $request->hotelID;
        $templates = (new HotelController())->getHotelTemplates($request, $id);
        foreach ($templates as $template) {
            if (($template->schedule_start_time >= $start_date and $template->schedule_end_time <= $start_date)
                or ($template->schedule_start_time <= $end_date and $template->schedule_end_time >= $end_date)
                or ($template->schedule_start_time >= $start_date and $template->schedule_start_time <= $end_date)
            ) {
                return true;
            }
        }
        return false;
    }


    /**
     * Manage templates media files
     *
     * @param Request $request
     * @return int|string
     */
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
                return $this->previewFiles((int)$request->identity, $hotelLogo, $media);
            }

        }
        return 'success';
    }


    /**
     * Saves file names in MySQL DB
     *
     * @param int $id
     * @param string $hotelLogo
     * @param array $media
     */
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
        $id = $templateModel->hotel;
        $this->deleteCachedTemplates((int)$id);
    }

    /**
     * Terminating files after changes
     *
     * @param array $files
     */
    public function destroyFiles(array $files): void
    {
        Storage::delete($files);
    }

    /**
     * Delete cached templates for updated or deleted hotel (REDIS)
     *
     * @param int $id
     */
    public function deleteCachedTemplates(int $id)
    {
        Redis::del('templates.' . $id);
        Redis::del("templates.reserved." . $id);
    }

    /**
     * Preview files management
     *
     * @param int $identity
     * @param string $hotelLogo
     * @param array $media
     * @return int
     */
    public function previewFiles(int $identity, string $hotelLogo, array $media)
    {
        $jsonData = Redis::get('data-' . $identity);
        $data = json_decode($jsonData);

        $data->media = $media;
        $data->hotelLogo = $hotelLogo;
        $newData = json_encode($data, JSON_FORCE_OBJECT);
        Redis::set('data-' . $identity, $newData, 300);
        Redis::expire('data-' . $identity, 60);
        return $identity;

    }

    /**
     * Prepare data for preview page, stores data in Redis
     *
     * @param Request $request
     * @return int
     */
    public function preparePreview(Request $request)
    {

        if ($request->type === 'alreadySaved') {
            return $this->prepareSavedTemplate((int)$request->id);
        }
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


    /**
     * Save template in Redis for preview
     *
     * @param int $id
     * @return int
     */
    public function prepareSavedTemplate(int $id)
    {
        $template = Template::find($id);
        $timestamp = Carbon::now()->timestamp;
        Redis::set('data-' . $timestamp, $template->data, 300);
        Redis::expire('data-' . $timestamp, 60);

        return $timestamp;
    }

    /**
     * Preview page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function preview(Request $request)
    {

        $data = Redis::get('data-' . $request->id);

        if (!$data) {
            return 'Sorry data expired';
        }
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
            'theme_color' => str_replace('background:', '', ((json_decode($data))->backgroundColor))
        ]);

    }

    /**
     * Activate template
     *
     * @param Request $request
     * @return string
     */
    public function activate(Request $request)
    {
        if(!$request->id or !$request->hotel){
            return 'fail';
        }
        $id = $request->id;
        $hotel_id = $request->hotel;
        //Deactivate old one
        (new Template())->where('hotel', $hotel_id)->where('activated', 'yes')->where('scheduled', 'no')->update(['activated' => 'no']);
        //Activate new one
        (Template::find($id))->update(['activated' => 'yes']);
        $this->deleteCachedTemplates($hotel_id);
        return 'success';
    }

    /**
     * Delete template
     *
     * @param Request $request
     * @return string
     */
    public function delete(Request $request)
    {
        if(!$request->id){
            return 'fail';
        }
        (Template::find($request->id))->delete();
        return 'success';
    }


}
