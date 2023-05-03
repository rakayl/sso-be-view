<?php

namespace Modules\Plastic\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use App\Lib\MyHelper;

class PlasticTypeController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = [
            'title'          => 'Plastic Type',
            'sub_title'      => 'New Plastic Type',
            'menu_active'    => 'product-plastic',
            'submenu_active' => 'plastic-type',
            'child_active'   => 'plastic-type-list'
        ];

        $data['data'] = MyHelper::get('plastic-type/list')['result'] ?? [];

        return view('plastic::plastic_type.list', $data);
    }

    public function create()
    {
        $data = [
            'title'          => 'Plastic Type',
            'sub_title'      => 'New Plastic Type',
            'menu_active'    => 'product-plastic',
            'submenu_active' => 'plastic-type',
            'child_active'   => 'plastic-type-new'
        ];
        $data['outlet_group_filter'] = MyHelper::get('outlet/group-filter')['result'] ?? [];
        return view('plastic::plastic_type.create', $data);
    }

    public function store(Request $request)
    {
        $post = $request->except('_token');

        $store = MyHelper::post('plastic-type/store', $post);

        if (isset($store['status']) && $store['status'] == 'success') {
            return redirect('plastic-type')->withSuccess(['Success create plastic type']);
        } else {
            return redirect('plastic-type/create')->withErrors($store['messages'] ?? ['Failed create plastic type'])->withInput();
        }
    }

    public function detail($id)
    {
        $detail = MyHelper::post('plastic-type/detail', ['id_plastic_type' => $id]);

        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data = [
                'title'          => 'Plastic Type',
                'sub_title'      => 'Plastic Type Detail',
                'menu_active'    => 'product-plastic',
                'submenu_active' => 'plastic-type',
                'child_active'   => 'plastic-type-list'
            ];

            $data['detail'] = $detail['result'];
            $data['outlet_group_filter'] = MyHelper::get('outlet/group-filter')['result'] ?? [];
            return view('plastic::plastic_type.detail', $data);
        } else {
            return redirect('plastic-type')->withErrors($store['messages'] ?? ['Failed get detail plastic type']);
        }
    }

    public function update(Request $request, $id)
    {
        $post = $request->except('_token');

        $post['id_plastic_type'] = $id;
        $update = MyHelper::post('plastic-type/update', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('plastic-type/detail/' . $id)->withSuccess(['Success update plastic type']);
        } else {
            return redirect('plastic-type/detail/' . $id)->withErrors($update['messages'] ?? ['Failed update plastic type']);
        }
    }

    public function destroy(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('plastic-type/delete', $post);
        return $delete;
    }

    public function position(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Plastic Type',
                'sub_title'      => 'Position Plastic Type',
                'menu_active'    => 'product-plastic',
                'submenu_active' => 'plastic-type',
                'child_active' => 'plastic-type-position'
            ];
            $data['data'] = MyHelper::get('plastic-type/list')['result'] ?? [];
            return view('plastic::plastic_type.position', $data);
        } else {
            $update = MyHelper::post('plastic-type/position', $post);

            if (isset($update['status']) && $update['status'] == 'success') {
                return redirect('plastic-type/position')->withSuccess(['Success update position plastic type']);
            } else {
                return redirect('plastic-type/position')->withErrors($update['messages'] ?? ['Failed update position plastic type']);
            }
        }
    }
}
