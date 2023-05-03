<?php

namespace Modules\Outlet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Excel;
use Validator;
use Session;
use Storage;
use File;

class OutletGroupFilterController extends Controller
{
    /**
     * list
     */
    public function index()
    {
        $data = [
            'title'          => 'Outlet Group Filter',
            'sub_title'      => 'Outlet Filter List',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-group-filter',
            'child_active' => 'outlet-group-filter-list'
        ];

        $data['data'] = MyHelper::get('outlet/group-filter')['result'] ?? [];
        return view('outlet::outlet_group_filter.list', $data);
    }

    public function create()
    {
        $data = [
            'title'          => 'Outlet Group Filter',
            'sub_title'      => 'New Outlet Group Filter',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-group-filter',
            'child_active' => 'outlet-group-filter-new'
        ];

        $data['provinces'] = MyHelper::get('province/list')['result'] ?? [];
        $data['cities'] = MyHelper::get('city/list')['result'] ?? [];
        $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
        $data['outlets'] = MyHelper::post('outlet/be/list', ['all_outlet' => 1])['result'] ?? [];
        return view('outlet::outlet_group_filter.create', $data);
    }

    public function store(Request $request)
    {
        $post = $request->except('_token');

        $store = MyHelper::post('outlet/group-filter/store', $post);

        if (isset($store['status']) && $store['status'] == 'success') {
            return redirect('outlet-group-filter')->withSuccess(['Success create outlet group filter']);
        } else {
            return redirect('outlet-group-filter/create')->withErrors($store['messages'] ?? ['Failed create outlet group filter'])->withInput();
        }
    }

    public function detail($id)
    {
        $detail = MyHelper::post('outlet/group-filter/detail', ['id_outlet_group' => $id]);

        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data = [
                'title'          => 'Outlet Group Filter',
                'sub_title'      => 'Outlet Group Filter Detail',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-group-filter',
                'child_active' => 'outlet-group-filter-list'
            ];

            $data['provinces'] = MyHelper::get('province/list')['result'] ?? [];
            $data['cities'] = MyHelper::get('city/list')['result'] ?? [];
            $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
            $data['outlets'] = MyHelper::post('outlet/be/list', ['all_outlet' => 1])['result'] ?? [];
            $data['detail'] = $detail['result'];
            $data['conditions'] = $detail['result']['conditions'] ?? [];
            $data['outlets_selected'] = array_column($detail['result']['outlet_group_filter_outlet'] ?? [], 'id_outlet');

            return view('outlet::outlet_group_filter.detail', $data);
        } else {
            return redirect('outlet-group-filter')->withErrors($store['messages'] ?? ['Failed get detail outlet group filter']);
        }
    }

    public function update(Request $request, $id)
    {
        $post = $request->except('_token');

        $post['id_outlet_group'] = $id;
        $update = MyHelper::post('outlet/group-filter/update', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('outlet-group-filter/detail/' . $id)->withSuccess(['Success update outlet group filter']);
        } else {
            return redirect('outlet-group-filter/detail/' . $id)->withErrors($update['messages'] ?? ['Failed update outlet group filter']);
        }
    }

    public function destroy(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('outlet/group-filter/delete', $post);
        return $delete;
    }
}
