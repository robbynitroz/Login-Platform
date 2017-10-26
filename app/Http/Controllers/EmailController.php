<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Email;

/**
 * Class EmailController
 * @package App\Http\Controllers
 */
class EmailController extends Controller
{
    //
    /**
     * Store client email
     *
     * @param string $email
     * @param int $hotel_id
     * @param string $login_type
     */
    public function storeEmail(string $email, int $hotel_id, string $login_type)
    {
        $emailModel = new Email();
        $emailModel->email = $email;
        $emailModel->hotel_id = $hotel_id;
        $emailModel->type= $login_type;
        $emailModel->save();
    }
}
