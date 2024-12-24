<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $url = api_url('getAllLog');

        $resData = requestGetAPI($url)->data;

        $res = $resData;

        // $offset = count($resData);

        // $res = $offset;

        // dd($res);

        return view('log.index', compact('res'));
    }
}
