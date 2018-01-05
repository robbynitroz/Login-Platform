<?php

namespace App\Http\Controllers\Newsfeed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Newsfeed extends Controller
{
    //

    /**
     * Test
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('newsfeed.index', ['hotel_name'=>$request->hotel_name]);
    }
}
