<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SandboxController extends Controller
{
    public function index()
    {
        $url = api_url('getAllUser');
        $res = requestGetAPI($url);

        $user = [];

        if ($res->status === 200) {
            $user['users'] = $res->data->users;
            $user['total'] = $res->data->total;
            $user['aktif'] = $res->data->aktif;
            $user['tidak_aktif'] = $res->data->tidak_aktif;
        }

        return view('sandbox.index', compact('user'));
    }
}
