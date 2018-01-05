<?php

namespace App\Http\Controllers\Newsfeed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Newsfeed extends Controller
{
    //

    public function index()
    {
        return view('newsfeed.index');
    }
}
