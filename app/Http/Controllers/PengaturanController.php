<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Image\Image;
use RealRashid\SweetAlert\Facades\Alert;

class PengaturanController extends Controller
{
    public function index(Request $request)
    {
        $url = api_url('getPengaturan');

        $res = requestGetAPI($url)->data[0];

        return view('setting.index', compact('res'));
    }

    public function headerandFavico()
    {
        $url = api_url('getPengaturan');
        $res = requestGetAPI($url)->data[0];

        return response()->json($res);
    }
    public function updatePengaturan(Request $request)
    {
        $url_old = api_url('getPengaturan');
        $url = api_url('updatePengaturan');

        $res_old = requestGetAPI($url_old)->data[0];

        if ($request->nama_apk || $request->footer) {
            $nama_apk = $request->nama_apk;
            $footer = $request->footer;
        } else {
            $nama_apk = $res_old->nama_apk;
            $footer = $res_old->footer;
        }

        if ($request->hasFile('favico')) {
            $favico = $request->favico;
            $filenamefavico = 'favico' . '.ico';
            $filePath = base_path('public/images/setting/') . $filenamefavico;

            Image::load($favico)->optimize()->width(50)->height(50)->save($filePath);

            if ($request->favico && file_exists($filePath)) {
                unlink($filePath);
            }

            $favico->move(base_path('public/images/setting/'), $filenamefavico);
            $favico = $filenamefavico;
            $url_favico = image_url() . $filenamefavico;
        } else {
            $favico = $res_old->favico;
            $url_favico = $res_old->url_favico;
        }

        if ($request->hasFile('logo_header')) {
            $logo_header = $request->logo_header;
            $filenameheader = 'logo_header' . '.' . $logo_header->getClientOriginalExtension();
            $filePath = base_path('public/images/setting/') . $filenameheader;

            if ($request->logo_header && file_exists($filePath)) {
                unlink($filePath);
            }

            $logo_header->move(base_path('public/images/setting/'), $filenameheader);
            $logo_header = $filenameheader;
            $url_logo_header = image_url() . $filenameheader;
        } else {
            $logo_header = $res_old->logo_header;
            $url_logo_header = $res_old->url_logo_header;
        }

        $post = [
            'nama_apk' => $nama_apk,
            'footer' => $footer,
            'favico' => $favico,
            'url_favico' => $url_favico,
            'logo_header' => $logo_header,
            'url_logo_header' => $url_logo_header,
        ];

        $res = requestPostAPI($url, $post);

        if ($res->status === 200) {
            Alert::success('Success', $res->message);
            return redirect()->route('page-pengaturan');
        } else {
            Alert::error('Error', $res->message);
            return redirect()->route('page-pengaturan');
        }
    }

    public function settingFR()
    {
        return view('setting.setting_fr');
    }

    public function getSetting()
    {
        $dataSetting = [];
        $path = resource_path('settingFR/setting.json');
        if (File::exists($path)) {
            $dataSetting = json_decode(File::get($path), true);
        } else {
            Alert::error('Error', 'JSON tidak titemukan');
        }

        return response()->json($dataSetting);
    }

    public function postSettingFR(Request $request)
    {
        $dataSetting = [];
        $request->validate([
            'threshold' => 'required|string',
            'prediction' => 'required|string',
        ]);

        $path = resource_path('settingFR/setting.json');

        if (File::exists($path)) {
            $dataSetting = json_decode(File::get($path), true);
        } else {
            Alert::error('Error', 'JSON tidak titemukan');
        }

        // for create
        // $nextId = 1;
        // if (!empty($dataSetting)) {
        //     $ids = array_column($dataSetting, 'id');
        //     $nextId = max($ids) + 1;
        // }

        // $data = [
        //     'id' => 1,
        //     'threshold' => $request->input('threshold'),
        //     'prediction' => $request->input('prediction'),
        // ];

        // $dataSetting[] = $data;
        // end for create


        $index = array_search(1, array_column($dataSetting, 'id'));
        if ($index !== false) {
            $dataSetting[$index]['threshold'] = $request->input('threshold');
            $dataSetting[$index]['prediction'] = $request->input('prediction');

            File::put($path, json_encode($dataSetting, JSON_PRETTY_PRINT));
            Alert::success('Success', 'Pengaturan FR Telah Tersimpan');
            return redirect()->back()->with('success', 'Pengaturan Telah Tersimpan');
        } else {
            return response()->json(['message' => 'Object not found.'], 404);
        }

        // File::put($path, json_encode($dataSetting, JSON_PRETTY_PRINT));
    }
}
