<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class AccommodationController extends Controller
{
    public function create()
    {
        $data = [
            'title'          => 'Accommodation',
            'sub_title'      => 'New Accommodation',
            'menu_active'    => 'accommodation',
            'submenu_active' => 'accommodation-new'
        ];
        $post = array();
        $data['outlet'] = MyHelper::post('accommodation/be/outlet', $post)['result']??[];
        return view('merchant::accommodation.create', $data);
    }

    public function store(Request $request)
    {
        $post = $request->except('_token');
         if (isset($post['attachment'])) {
            $post['attachment'] = MyHelper::encodeImage($post['attachment']);
        }
        $post['number_accommodation'] = strtoupper($post['number_accommodation']);
        $create = MyHelper::post('accommodation/be/store', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return redirect('accommodation')->withSuccess(['Success save data']);
        } else {
            return redirect('accommodation/create')->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }

    public function list(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Accommodation',
            'sub_title'      => 'Accommodation List',
            'menu_active'    => 'accommodation',
            'submenu_active' => 'accommodation-list'
        ];
        

        if ($post) {
            Session::put('filter-accommodation', $post);
        }
        if (Session::has('filter-accommodation') && $post && isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-accommodation');
            $post['page'] = $page;
            $data['conditions'] = $post['conditions'];
            $data['rule'] = $post['rule'];
        } else {
            Session::forget('filter-accommodation');
        }

        $getList = MyHelper::post('accommodation/be/list', $post);

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
        return view('merchant::accommodation.list', $data);
    }

    public function detail($id)
    {
        $data = [
            'title'          => 'Accommodation',
            'sub_title'      => 'Accommodation Detail',
            'menu_active'    => 'accommodation',
            'submenu_active' => 'accommodation-list',
        ];
        $detail = MyHelper::post('accommodation/be/detail', ['id_accommodation' => $id]);
        
        if (isset($detail['status']) && $detail['status'] == "success") {
            $data['result'] = $detail['result'];
            return view('merchant::accommodation.detail', $data);
        } else {
            return redirect('accommodation')->withErrors($save['messages'] ?? ['Failed get data']);
        }
    }
    public function delete($id)
    {
       $update = MyHelper::post('accommodation/be/delete', ['id_accommodation' => $id]);
        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('accommodation')->withSuccess(['Success update data']);
        } else {
            return redirect('accommodation')->withErrors($update['messages'] ?? ['Failed update data']);
        }
    }

    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        $post['id_accommodation'] = $id;
        if (isset($post['attachment'])) {
            $post['attachment'] = MyHelper::encodeImage($post['attachment']);
        }
        $post['number_accommodation'] = strtoupper($post['number_accommodation']);
        $update = MyHelper::post('accommodation/be/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('accommodation/detail/' . $id)->withSuccess(['Success save data']);
        } else {
            return redirect('accommodation/detail/' . $id)->withErrors($update['messages'] ?? ['Failed get data']);
        }
    }
}
