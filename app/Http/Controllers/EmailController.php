<?php

namespace App\Http\Controllers;

use App\Email;

/**
 * Class EmailController
 * @package App\Http\Controllers
 */
class EmailController extends Controller
{
    //

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

        $emailModel = new Email();

        if ($emailModel->where('email', $email)->where('hotel_id', $hotel_id)->where('type',
                $login_type)->count() === 0) {
            $emailModel->email = $email;
            $emailModel->hotel_id = $hotel_id;
            $emailModel->type = $login_type;
            $emailModel->save();
        };


        return;

    }
}
