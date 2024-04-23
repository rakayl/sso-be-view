<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class PaketController extends Controller
{
    public function city()
    {
        $data = [
            'title'          => 'Paket Toilet',
            'sub_title'      => 'Paket Toilet',
            'menu_active'    => 'paket',
            'submenu_active' => 'paket'
        ];
        $data['data'] = MyHelper::get('city/pemda')['result'] ?? [];
        return view('merchant::province.city', $data);
    }
    public function detailCity($id)
    {
        $data = [
            'title'          => 'Paket Toilet',
            'menu_active'    => 'paket',
            'submenu_active' => 'paket'
        ];
        $post['id_city'] = $id;
        $getList = MyHelper::post('paket/be/list',$post);
         if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['data'];
            $data['id_city']       = $id; 
            $data['city']          = $getList['result']['city']['city_type'].' '.$getList['result']['city']['city_name'].', '.$getList['result']['city']['province_name'];
            
        } else {
            return redirect('paket')->withErrors($create['messages'] ?? ['Kota tidak ditemukan']);
        }
        return view('merchant::province.paket', $data);
    }

    public function create(Request $request)
    {
       $post = $request->except('_token');
       $post['price_paket'] = str_replace(',','', $post['price_paket']??0);
       $create = MyHelper::post('paket/be/store', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return back()->withSuccess(['Success save data']);
        } else {
            return back()->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }

    public function detail($id)
    {
        $data = [
            'title'          => 'Paket Toilet',
            'menu_active'    => 'paket',
            'submenu_active' => 'paket'
        ];
        $post['id_paket'] = $id;
        $getList = MyHelper::post('paket/be/detail',$post);
         if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['detail'];
            $data['id_paket']       = $id; 
            $data['paket']          = $getList['result']['paket'];
            
        } else {
            return redirect('paket')->withErrors($create['messages'] ?? ['Kota tidak ditemukan']);
        }
        return view('merchant::province.detail', $data);
    }
    public function update(Request $request)
    {
       $post = $request->except('_token');
       $post['price_paket'] = str_replace(',','', $post['price_paket']??0);
       $create = MyHelper::post('paket/be/update', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return back()->withSuccess(['Success save data']);
        } else {
            return back()->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }
    public function detailCreate(Request $request)
    {
       $post = $request->except('_token');
       $create = MyHelper::post('paket/be/detail/store', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return back()->withSuccess(['Success save data']);
        } else {
            return back()->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }
    public function detailDelete($id)
    {
        $update = MyHelper::post('paket/be/detail/delete', ['id_detail_paket' => $id]);
        if (isset($update['status']) && $update['status'] == "success") {
            return back()->withSuccess(['Success delete data']);
        } else {
            return back()->withErrors($update['messages'] ?? ['Failed delete data']);
        }
    }
}
