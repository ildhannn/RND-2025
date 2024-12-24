<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $url = api_url('getAllUser');
        $url2 = api_exadel('subjects');
        $url3 = api_url('getAllKewenangan');
        $url4 = api_url('getFR/' . $request->id_user);

        $res = requestGetAPI($url);
        $res2 = requestGetAPIExadel($url2);
        $res3 = requestGetAPI($url3);

        $user = [];
        $user['face'] = $res2->subjects;
        $user['namaKewenangan'] = array_column($res3->data, 'nama');

        if ($res->status === 200) {
            $user['users'] = $res->data->users;
            $user['total'] = $res->data->total;
            $user['aktif'] = $res->data->aktif;
            $user['tidak_aktif'] = $res->data->tidak_aktif;
        } else {
            Alert::success('Error', $res->message);
        }

        // dd($user);

        return view('user.index', compact('user'));
    }

    public function fetchUser()
    {
        $url = api_url('getAllUser');
        $res = requestGetAPI($url);

        $user = [];

        if ($res->status === 200) {
            $user = $res->data->users;
        } else {
            Alert::success('Error', $res->message);
        }

        return response()->json($user);
    }

    public function createUser()
    {
        return view('user.create');
    }

    public function postCreate(Request $request)
    {
        $url = api_url('createUser');

        $foto = null;
        $url_foto = null;

        if ($request->hasFile('foto')) {
            $fotoFile = $request->file('foto');
            $filename = 'foto_' . $request->username . '.' . $fotoFile->getClientOriginalName();
            $filePath = base_path('public/images/foto/') . $filename;

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $fotoFile->move(base_path('public/images/foto/'), $filename);

            $foto = $filename;
            $url_foto = image_url() . $filename;
        }

        $post = [
            'username' => $request->username,
            'password' => $request->password,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'foto' => $foto,
            'url_foto' => $url_foto,
        ];

        $res = requestPostAPI($url, $post);

        if ($res->status === 200) {
            Alert::success('Success', $res->message);
            return redirect()->route('page-user');
        } else {
            Alert::error('Error', $res->error);
            return redirect()->route('create-user');
        }
    }

    public function editUser($id)
    {
        $url_user = api_url('getIdUser/' . $id);
        $url_kewenangan = api_url('getAllKewenangan');

        $user = requestGetAPI($url_user)->data;

        $kewenangan = requestGetAPI($url_kewenangan)->data;

        return view('user.edit', compact('id', 'user', 'kewenangan'));
    }

    public function postEdit(Request $request, $id)
    {
        $user = User::find($id);
        $url = api_url('updateUser/' . $id);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = $user->foto;
            $oldFotoPath = base_path('public/images/foto/') . $filename;

            if ($user->foto && file_exists($oldFotoPath)) {
                unlink($oldFotoPath);
            }

            $foto->move(base_path('public/images/foto/'), $filename);

            $foto = $filename;
            $user->save();

            $url_foto = image_url() . $filename;
        } else {
            $foto = $user->foto;
            $url_foto = image_url() . $user->url_foto;
        }

        $post = [
            'username' => $request->username,
            'password' => $request->password,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'kewenangan_id' => $request->kewenangan_id,
            'status' => $request->status,
            'foto' => $foto,
            'url_foto' => $url_foto,
        ];

        $res = requestPostAPI($url, $post);

        if ($res->status === 200) {
            Alert::success('Success', $res->message);
            return redirect()->route('page-user');
        } else {
            Alert::error('Error', $res->error);
            return redirect()->route('edit-user');
        }
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $url = api_url('deleteUser/' . $id);

        $post = [
            'id' => $id,
        ];

        $res = requestPostAPI($url, $post);

        if ($res->status === 200) {
            // hapus foto
            $filePathfront = image_url() . $user->foto;
            if (file_exists($filePathfront)) {
                unlink($filePathfront);
            }

            Alert::success('Success', $res->message);
            return redirect()->route('page-user');
        } else {
            Alert::error('Error', $res->error);
        }
    }
}
