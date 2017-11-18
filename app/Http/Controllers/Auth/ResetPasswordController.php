<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;


    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Overrides sendResetResponse in ResetPassword, change success response
     *
     * @return string
     */
    protected function sendResetResponse()
    {
        return json_encode('success');
    }

    /**
     * Overrides sendResetFailedResponse in ResetPassword, change failed response
     *
     * @return string
     */
    protected function sendResetFailedResponse()
    {
        return json_encode('failure');
    }


}
