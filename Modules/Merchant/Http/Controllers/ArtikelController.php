<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class ArtikelController extends Controller
{
    public function create()
    {
        $data = [
            'title'          => 'Artikel',
            'sub_title'      => 'New Artikel',
            'menu_active'    => 'artikel',
            'submenu_active' => 'artikel-new'
        ];
        return view('merchant::artikel.create', $data);
    }

    public function store(Request $request)
    {
        $post = $request->except('_token');
         if (isset($post['image'])) {
            $post['image'] = MyHelper::encodeImage($post['image']);
        }
        $create = MyHelper::post('artikel/store', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return redirect('artikel')->withSuccess(['Success save data']);
        } else {
            return redirect('artikel/create')->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }

    public function list(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Artikel',
            'sub_title'      => 'Artikel List',
            'menu_active'    => 'artikel',
            'submenu_active' => 'artikel-list',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
            'type' => ''
        ];
        

        if ($post) {
            Session::put('filter-artikel', $post);
        }
        if (Session::has('filter-artikel') && $post && isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-artikel');
            $post['page'] = $page;
            $data['conditions'] = $post['conditions'];
            $data['rule'] = $post['rule'];
        } else {
            Session::forget('filter-artikel');
        }

        $getList = MyHelper::post('artikel/list', $post);

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
        return view('merchant::artikel.list', $data);
    }

    public function detail($id)
    {
        $data = [
            'title'          => 'Artikel',
            'sub_title'      => 'Artikel Detail',
            'menu_active'    => 'artikel',
            'submenu_active' => 'artikel-list',
        ];
       $detail = MyHelper::post('artikel/detail', ['id_artikel' => $id]);
        
        if (isset($detail['status']) && $detail['status'] == "success") {
            $data['result'] = $detail['result'];
            return view('merchant::artikel.detail', $data);
        } else {
            return redirect('artikel')->withErrors($save['messages'] ?? ['Failed get data']);
        }
    }
    public function delete($id)
    {
        $detail = MyHelper::post('artikel/delete', ['id_artikel' => $id]);
        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('artikel')->withSuccess(['Success delete data']);
        } else {
            return redirect('artikel')->withErrors($update['messages'] ?? ['Failed delete data']);
        }
    }

    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        
        $post['id_artikel'] = $id;
         if (isset($post['image'])) {
            $post['image'] = MyHelper::encodeImage($post['image']);
        }
        $update = MyHelper::post('artikel/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('artikel/detail/' . $id)->withSuccess(['Success save data']);
        } else {
            return redirect('artikel/detail/' . $id)->withErrors($update['messages'] ?? ['Failed get data']);
        }
    }
}
