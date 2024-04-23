<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class TarifController extends Controller
{
    public function city()
    {
        $data = [
            'title'          => 'Tarif Pengosongan WC',
            'menu_active'    => 'tarif',
            'submenu_active' => 'tarif'
        ];
        $data['data'] = MyHelper::get('city/pemda')['result'] ?? [];
        return view('merchant::tarif.city', $data);
    }
    public function detailCity($id)
    {
        $data = [
            'title'          => 'Tarif Pengosongan WC',
            'menu_active'    => 'tarif',
            'submenu_active' => 'tarif'
        ];
        $post['id_city'] = $id;
        $getList = MyHelper::post('tarif/be/list',$post);
         if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['data'];
            $data['id_city']       = $id; 
            $data['city']          = $getList['result']['city']['city_type'].' '.$getList['result']['city']['city_name'].', '.$getList['result']['city']['province_name'];
            
        } else {
            return redirect('tarif')->withErrors($create['messages'] ?? ['Kota tidak ditemukan']);
        }
        return view('merchant::tarif.paket', $data);
    }

    public function create(Request $request)
    {
       $post = $request->except('_token');
       $post['price_tarif'] = str_replace(',','', $post['price_tarif']??0);
       $create = MyHelper::post('tarif/be/store', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return back()->withSuccess(['Success save data']);
        } else {
            return back()->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }

    public function detail($id)
    {
        $data = [
            'title'          => 'Tarif Pengosongan WC',
            'menu_active'    => 'tarif',
            'submenu_active' => 'tarif'
        ];
        $post['id_tarif'] = $id;
        $getList = MyHelper::post('tarif/be/detail',$post);
         if (isset($getList['status']) && $getList['status'] == "success") {
            $data['id_tarif']       = $id; 
            $data['tarif']          = $getList['result']['tarif'];
            
        } else {
            return back()->withErrors($create['messages'] ?? ['Tarif tidak ditemukan']);
        }
        return view('merchant::tarif.detail', $data);
    }
    public function update(Request $request)
    {
       $post = $request->except('_token');
       $post['price_tarif'] = str_replace(',','', $post['price_tarif']??0);
       $create = MyHelper::post('tarif/be/update', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return back()->withSuccess(['Success save data']);
        } else {
            return back()->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }
    public function detailCreate(Request $request)
    {
       $post = $request->except('_token');
       $create = MyHelper::post('tarif/be/detail/store', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return back()->withSuccess(['Success save data']);
        } else {
            return back()->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }
    public function detailDelete($id)
    {
        $update = MyHelper::post('tarif/be/detail/delete', ['id_detail_tarif' => $id]);
        if (isset($update['status']) && $update['status'] == "success") {
            return back()->withSuccess(['Success delete data']);
        } else {
            return back()->withErrors($update['messages'] ?? ['Failed delete data']);
        }
    }
}
