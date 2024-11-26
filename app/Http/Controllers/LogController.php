<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LogController extends Controller
{
    public function index()
    {
        $url = api_url('getAllLog');

        $res = requestGetAPI($url)->data;
        return view('log.index2', compact('res'));
    }
}
