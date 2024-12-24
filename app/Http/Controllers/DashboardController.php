<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $url = api_url('logDashboard');
        $res = requestGetAPI($url)->data;

        return view('dashboard.index', compact('res'));
    }
}
