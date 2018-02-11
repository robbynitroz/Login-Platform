<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get current user account details
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getCurrentUser():object
    {
        return Auth::user();
    }

    /**
     * Change user avatar
     *
     * @param Request $request
     *
     * @return string
     */
    public function setCurrentUserAvatar(Request $request)
    {
        if ($request->file('avatar')->isValid()) {
            $request->validate([
                'background' => 'mimes:jpeg,jpg,png'
            ]);
            $user = $this->getCurrentUser();
            $old_avatar =str_replace('/storage/', '', $user->picture);
            //delete old avatar
            $old_file_path = storage_path('app/public/'.$old_avatar);
            if(!is_int(strpos($old_avatar, 'standard-avatar'))){
                $this->deleteOldAvatar($old_file_path);
            }
            $new_img = $request->avatar->hashName();
            $request->avatar->store('public/images/avatars');
            $img = '/storage/images/avatars/'.$new_img;
            $user->picture =$img;
            $this->optimizeAvatar('app/public/images/avatars/'.$new_img);
            $user->save();
            return $img;
        }else{
            return 'Wrong file format!';
        }
    }

    /**
     * Delete given file
     *
     * @param string $old_file_path
     *
     * @return void
     */
    private function deleteOldAvatar(string $old_file_path):void
    {
        if(is_file($old_file_path)){
            unlink($old_file_path);
        }
    }

    /**
     * Optimize image size
     *
     * @param string $file
     *
     * @return void
     */
    private function optimizeAvatar(string $file):void
    {
        $path = storage_path();
        $path .= '/' . $file;
        $img = Image::make($path);
        if ($img->width() > 250) {
            $img->resize(250, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($path);
        } else {
            return;
        }
    }

    /**
     * Changed logged in user data
     *
     * @param Request $request
     *
     * @return void
     */
    public function setCurrentUserData(Request $request):void
    {
        $user = Auth::user();
        $request->validate([
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'name'=>'required|string|max:255'
        ]);
        $user = Auth::user();
        $user->name = request()->input('name');
        $user->email =  request()->input('email');
        $user->save();
    }
}
