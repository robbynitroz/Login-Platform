<?php

namespace App\Http\Controllers;

use App\Nas;
use Illuminate\Http\Request;

/**
 * Class NasController
 * @package App\Http\Controllers
 */
class NasController extends Controller
{
    //

    /**
     * @param Request $request
     * @return object
     */
    public function getHotel($request)
    {
        $nas_model = new Nas();
        $hotel = $nas_model->hotel()->where('nasname', '==', $request);
        return $hotel;
    }

}
