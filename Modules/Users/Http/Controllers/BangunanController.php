<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;
use Excel;
use App\Exports\ArrayExport;
use Illuminate\Support\Facades\Cookie;

class BangunanController  extends Controller
{
   
    public function index(Request $request)
    {
       $post = $request->except('_token');

        if(Session::has('bangun') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('bangun');
            $post['page'] = $page;
        }else{
            Session::forget('bangun');
        }

        $data = [ 'title'             => 'Bangunan',
            'menu_active'       => 'bangunan',
            'submenu_active'    => 'bangunan-list'
        ];

     
        $post['page'] = $post['page'] ?? 1;
        $getList = MyHelper::post('users/bangunan/list', $post);
         if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['data'];
            $data['dataTotal']     = $getList['result']['total'];
            $data['dataPerPage']   = $getList['result']['from'];
            $data['dataUpTo']      = $getList['result']['from'] + count($getList['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($getList['result']['data'], $getList['result']['total'], $getList['result']['per_page'], $getList['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }
        
        $getCity = MyHelper::get('city/list?log_save=0');
        if ($getCity['status'] == 'success') {
            $data['city'] = $getCity['result'];
        } else {
            $data['city'] = [];
        }

        $getProvince = MyHelper::get('province/list?log_save=0');
        if ($getProvince['status'] == 'success') {
            $data['province'] = $getProvince['result'];
        } else {
            $data['province'] = [];
        }
        
        if ($post) {
            Session::put('bangun', $post);
        }

        return view('users::bangunan.index', $data);
    }

    public function searchReset()
    {
        Session::forget('bangunan');
        return back();
    }
    public function create()
    {
        $data = [
            'title'          => 'Bangunan',
            'sub_title'      => 'New Bangunan',
            'menu_active'    => 'Bangunan',
            'submenu_active' => 'bangunan-new'
        ];
        $data['province'] = MyHelper::get('province/list')['result'] ?? [];
        $data['user'] = MyHelper::get('users/bangunan/user')['result'] ?? [];
        return view('users::bangunan.create', $data);
    }
}
