<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class NonIpltController extends Controller
{
  
    public function list(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Non Iplt',
            'sub_title'      => 'Non Iplt List',
            'menu_active'    => 'non-iplt',
            'submenu_active' => 'non-iplt-pending-list'
        ];
        

        if ($post) {
            Session::put('filter-non-iplt', $post);
        }
        if (Session::has('filter-non-iplt') && $post && isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-non-iplt');
            $post['page'] = $page;
            $data['conditions'] = $post['conditions'];
            $data['rule'] = $post['rule'];
        } else {
            Session::forget('filter-non-iplt');
        }

        $getList = MyHelper::post('dumping/be/non-iplt', $post);

        if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['data'];
            $data['dataTotal']     = $getList['result']['total'];
            $data['dataPerPage']   = $getList['result']['from'];
            $data['dataUpTo']      = $getList['result']['from'] + count($getList['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($getList['result']['data'], $getList['result']['total'], $getList['result']['per_page'], $getList['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }
        return view('merchant::non-iplt', $data);
    }

    public function detail($id)
    {
        $data = [
            'title'          => 'Iplt',
            'sub_title'      => 'Iplt Detail',
            'menu_active'    => 'non-iplt',
            'submenu_active' => 'non-iplt-list',
        ];
        $detail = MyHelper::get('dumping/be/detail/'.$id);
        
        if (isset($detail['status']) && $detail['status'] == "success") {
            $data['detail'] = $detail['result'];
            return view('merchant::non-iplt.detail', $data);
        } else {
            return redirect()->back()->withErrors($save['messages'] ?? ['Failed get data']);
        }
    }
 
}
