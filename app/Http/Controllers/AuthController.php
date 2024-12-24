<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $url = api_url('login');

        $post = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $res = requestPostAPI($url, $post);

        if ($res->status == 200) {
            $request->session()->regenerate();

            Session::put('token', $res->token);
            Session::put('id', $res->user->id);
            Session::put('username', $res->user->username);
            Session::put('email', $res->user->email);
            Session::put('satus', $res->user->status);
            Session::put('kewenangan_id', $res->user->kewenangan_id);
            Session::put('url_foto', $res->user->url_foto);

            Alert::success('Selamat Datang', $res->user->username);

            $getMenu = app(MenuController::class);
            $getMenu->getMenuUser();

            return redirect()->route('page-dashboard');
            // return redirect()->route('page-fr');
        } else {
            return redirect()
                ->route('page-login')
                ->withErrors(['error' => 'Username/Password Salah']);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }

    public function faceRecognition()
    {
        return view('auth.facerecog2');
    }

    // public function registFR()
    // {
    //     return view('auth.regis_fr2');
    // }

    public function registFR2($id)
    {
        $url_user = api_url('getIdUser/' . $id);
        $user = requestGetAPI($url_user)->data;

        return view('auth.regis_fr2', compact('user'));
    }

    // face api
    // public function postRegis(Request $request, $id)
    // {
    //     $url = api_url('regisFR/' . $id);

    //     $post = [
    //         'id_user' => $id,
    //         'descriptors' => json_encode($request->input('descriptors')),
    //     ];

    //     $res = requestPostAPI($url, $post);

    //     if ($res->status == 200) {
    //         Alert::success('Success', $res->message);
    //         return redirect()->route('page-fr');
    //     } else {
    //         Alert::error('Error', $res->message);
    //         return redirect()->route('page-fr');
    //     }
    // }

    // exalde
    public function postRegis($id)
    {
        $url = api_url('regisFR/' . $id);

        $post = [
            'id_user' => $id,
        ];

        $res = requestPostAPI($url, $post);

        if ($res->status == 200) {
            Alert::success('Success', $res->message);
            return redirect()->route('page-fr');
        } else {
            Alert::error('Error', $res->message);
            return redirect()->route('page-fr');
        }
    }

    public function getFR($id)
    {
        $url = api_url('getFR/' . $id);

        $res = requestGetAPI($url);

        return response()->json($res);
    }
}
