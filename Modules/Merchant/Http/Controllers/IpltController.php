<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class IpltController extends Controller
{
  
    public function list(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Iplt',
            'sub_title'      => 'Iplt Pending List',
            'menu_active'    => 'iplt',
            'submenu_active' => 'iplt-pending-list'
        ];
        

        if ($post) {
            Session::put('filter-iplt', $post);
        }
        if (Session::has('filter-iplt') && $post && isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-iplt');
            $post['page'] = $page;
            $data['conditions'] = $post['conditions'];
            $data['rule'] = $post['rule'];
        } else {
            Session::forget('filter-iplt');
        }

       $getList = MyHelper::post('dumping/be', $post);

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
        return view('merchant::iplt.list', $data);
    }
    public function pending(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Iplt',
            'sub_title'      => 'Riwayat Iplt List',
            'menu_active'    => 'iplt',
            'submenu_active' => 'iplt-riwayat-list'
        ];
        

        if ($post) {
            Session::put('filter-iplt', $post);
        }
        if (Session::has('filter-iplt') && $post && isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-iplt');
            $post['page'] = $page;
            $data['conditions'] = $post['conditions'];
            $data['rule'] = $post['rule'];
        } else {
            Session::forget('filter-iplt');
        }

       $getList = MyHelper::post('dumping/be/riwayat', $post);

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
        return view('merchant::iplt.list', $data);
    }

    public function detail($id)
    {
        $data = [
            'title'          => 'Iplt',
            'sub_title'      => 'Iplt Detail',
            'menu_active'    => 'iplt',
            'submenu_active' => 'iplt-list',
        ];
        $detail = MyHelper::post('iplt/be/detail', ['id_iplt' => $id]);
        
        if (isset($detail['status']) && $detail['status'] == "success") {
            $data['result'] = $detail['result'];
            return view('merchant::iplt.detail', $data);
        } else {
            return redirect('iplt')->withErrors($save['messages'] ?? ['Failed get data']);
        }
    }
    public function delete($id)
    {
       $update = MyHelper::post('iplt/be/delete', ['id_iplt' => $id]);
        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('iplt')->withSuccess(['Success update data']);
        } else {
            return redirect('iplt')->withErrors($update['messages'] ?? ['Failed update data']);
        }
    }

    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        $post['id_iplt'] = $id;
        if (isset($post['attachment'])) {
            $post['attachment'] = MyHelper::encodeImage($post['attachment']);
        }
        $post['number_iplt'] = strtoupper($post['number_iplt']);
        $update = MyHelper::post('iplt/be/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('iplt/detail/' . $id)->withSuccess(['Success save data']);
        } else {
            return redirect('iplt/detail/' . $id)->withErrors($update['messages'] ?? ['Failed get data']);
        }
    }
}
