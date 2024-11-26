<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    public function index()
    {
        $url = api_url('getAllMenu');

        $menu = [];

        $res = requestGetAPI($url);

        if ($res->status === 200) {
            $menu['total'] = $res->data->total;
            $menu['aktif'] = $res->data->aktif;
            $menu['tidak_aktif'] = $res->data->tidak_aktif;

            foreach (['dashboard', 'users', 'menus', 'log', 'pengaturan'] as $category) {
                $menu[$category] = array_map(function ($item) {
                    $item->kewenangan_id = json_decode($item->kewenangan_id, true) ?? [];
                    return $item;
                }, $res->data->{$category});
            }
        } else {
            Alert::success('Error', $res->message);
        }

        return view('menu.index2', compact('menu'));
    }

    public function createMenu()
    {
        return view('menu.create');
    }

    public function postCreate(Request $request)
    {
        $url = api_url('createMenu');

        $post = [
            'nama' => $request->nama,
            'slug' => $request->slug,
            'url' => $request->url,
            'icon' => $request->icon,
            'status' => '1',
            'kewenangan_id' => $request->kewenangan_id,
            'kategori' => $request->kategori,
        ];

        $res = requestPostAPI($url, $post);

        if ($res->status === 200) {
            Alert::success('Success', $res->message);
            return redirect()->route('page-menu');
        } else {
            Alert::error('Error', $res->message);
            return redirect()->route('page-menu');
        }
    }

    public function editMenu($id)
    {
        $url = api_url('getMenuId/' . $id);
        $url_kewenangan = api_url('getAllKewenangan');

        $post = [
            'id' => $id,
        ];

        $res = requestPostAPI($url, $post)->data;
        $kewenangan = requestGetAPI($url_kewenangan)->data;

        return view('menu.edit', compact('id', 'res', 'kewenangan'));
    }

    public function postEdit(Request $request, $id)
    {
        $url = api_url('updateMenu/' . $id);

        $post = [
            'nama' => $request->nama,
            'slug' => $request->slug,
            'url' => $request->url,
            'icon' => $request->icon,
            'status' => $request->status,
            'kewenangan_id' => $request->kewenangan_id,
            'kategori' => $request->kategori,
        ];

        $res = requestPostAPI($url, $post);

        if ($res->status === 200) {
            $getMenu = app(MenuController::class);
            $getMenu->getMenuUser();
            Alert::success('Success', 'Menu berhasil diupdate');
            return redirect()->route('page-menu');
        } else {
            Alert::error('Error', $res->message);
            return redirect()->route('page-menu');
        }
    }

    public function postHapus($id)
    {
        $url = api_url('deleteMenu/' . $id);

        $post = [
            'id' => $id,
        ];

        $res = requestPostAPI($url, $post);

        if ($res->status === 200) {
            Alert::success('Success', $res->message);
            return redirect()->route('page-menu');
        } else {
            Alert::error('Error', $res->message);
            return redirect()->route('page-menu');
        }
    }

    // Menu on db
    public function getMenuUser()
    {
        $url = api_url('getMenuUser');
        $res = requestGetAPI($url);

        $menuData = File::get(resource_path('menu/horizontalMenu.json'));
        $menuData = json_decode($menuData, true);

        foreach ($res->data as $key => $menuItems) {
            foreach ($menuItems as &$item) {
                if (isset($item['url'])) {
                    $item['url'] = str_replace('\/', '/', $item['url']);
                }
            }
        }

        $menuData['menu'] = $res->data;
        $menuData = json_encode($menuData, JSON_PRETTY_PRINT);
        File::put(resource_path('menu/horizontalMenu.json'), $menuData);

        return response()->json($res);
    }
}
