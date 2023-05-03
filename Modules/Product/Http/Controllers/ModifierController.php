<?php

namespace Modules\Product\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;

class ModifierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Topping',
            'sub_title'      => 'List Topping',
            'menu_active'    => 'product-modifier',
            'submenu_active' => 'product-modifier-list',
            'filter_title'   => 'Filter Topping',
        ];
        if (session('product_modifier_filter')) {
            $post             = session('product_modifier_filter');
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } else {
            $post = [];
        }
        $page = $request->page;
        if (!$page) {
            $page = 1;
        }
        $data['start'] = ($page - 1) * 10;
        $types         = MyHelper::get('product/modifier/type')['result'] ?? [];
        $data['types'] = array_map(function ($q) {
            return [$q, $q];
        }, $types);
        $data['modifiers'] = MyHelper::post('product/modifier?page=' . $page, $post)['result'] ?? [];

        $data['products'] = array_map(function ($q) {
            return [$q['id_product'], $q['product_code'] . '-' . $q['product_name']];
        }, MyHelper::get('product/be/list')['result'] ?? []);

        $data['categories'] = array_map(function ($q) {
            return [$q['id_product_category'], $q['product_category_name']];
        }, MyHelper::get('product/category/be/list')['result'] ?? []);

        $data['brands'] = array_map(function ($q) {
            return [$q['id_brand'], $q['name_brand']];
        }, MyHelper::get('brand')['result'] ?? []);

        if (!empty($data['modifiers']['data'])) {
            $data['mod']          = $data['modifiers']['data'];
            $data['modTotal']     = $data['modifiers']['total'];
            $data['modPerPage']   = $data['modifiers']['from'];
            $data['modUpTo']      = $data['modifiers']['from'] + count($data['modifiers']['data']) - 1;
            $data['modPaginator'] = new LengthAwarePaginator($data['modifiers']['data'], $data['modifiers']['total'], $data['modifiers']['per_page'], $data['modifiers']['current_page'], ['path' => url()->current()]);
        } else {
            $data['mod']          = [];
            $data['modTotal']     = 0;
            $data['modPerPage']   = 0;
            $data['modUpTo']      = 0;
            $data['modPaginator'] = false;
        }

        $data['total']     = $data['modifiers']['total'] ?? 0;
        return view('product::modifier.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Topping',
            'sub_title'      => 'New Topping',
            'menu_active'    => 'product-modifier',
            'submenu_active' => 'product-modifier-new',
        ];
        $data['types'] = MyHelper::get('product/modifier/type')['result'] ?? [];

        $data['subject']['products'] = array_map(function ($var) {
            return [
                'id'   => $var['id_product'],
                'text' => $var['product_code'] . ' - ' . $var['product_name'],
            ];
        }, MyHelper::get('product/be/list')['result'] ?? []);

        $data['subject']['product_categories'] = array_map(function ($var) {
            return [
                'id'   => $var['id_product_category'],
                'text' => $var['product_category_name'],
            ];
        }, MyHelper::get('product/category/be/list')['result'] ?? []);

        $data['subject']['brands'] = array_map(function ($var) {
            return [
                'id'   => $var['id_brand'],
                'text' => $var['name_brand'],
            ];
        }, MyHelper::get('brand/be/list')['result'] ?? []);
        return view('product::modifier.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['product_modifier_filter' => $post]);
            return redirect('product/modifier');
        }
        if ($post['clear'] ?? false) {
            session(['product_modifier_filter' => null]);
            return redirect('product/modifier');
        }
        if (isset($post['type_dropdown'])) {
            $post['type'] = $post['type_dropdown'];
            if ($post['type'] == '0') {
                $post['type'] = $post['type_textbox'];
            }
        } else {
            $post['type'] = "Topping";
        }

        $result = MyHelper::post('product/modifier/create', $post);
        if (($result['status'] ?? false) == 'success') {
            return redirect('product/modifier/create')->with('success', ['Success create topping']);
        } else {
            return back()->withErrors($result['messages'] ?? ['Something went wrong'])->withInput();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'title'          => 'Topping',
            'sub_title'      => 'Detail Topping',
            'menu_active'    => 'product-modifier',
            'submenu_active' => 'product-modifier-list',
        ];
        $modifier = MyHelper::post('product/modifier/detail', ['code' => $id]);
        if (!($modifier['result'] ?? false)) {
            return back()->withErrors($modifier['messages'] ?? ['Something went wrong']);
        }
        $data['modifier'] = $modifier['result'];

        $data['types'] = MyHelper::get('product/modifier/type')['result'] ?? [];

        $data['subject']['products'] = array_map(function ($var) {
            return [
                'id'   => $var['id_product'],
                'text' => $var['product_code'] . ' - ' . $var['product_name'],
            ];
        }, MyHelper::get('product/be/list')['result'] ?? []);

        $data['subject']['product_categories'] = array_map(function ($var) {
            return [
                'id'   => $var['id_product_category'],
                'text' => $var['product_category_name'],
            ];
        }, MyHelper::get('product/category/be/list')['result'] ?? []);

        $data['subject']['brands'] = array_map(function ($var) {
            return [
                'id'   => $var['id_brand'],
                'text' => $var['name_brand'],
            ];
        }, MyHelper::get('brand/be/list')['result'] ?? []);

        return view('product::modifier.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->except(['_token', '_method']);
        if ($request->isMethod('patch')) {
            $modifier = MyHelper::post('product/modifier/detail', ['id_product_modifier' => $id])['result'] ?? false;
            if (!$modifier) {
                return ['status' => 'fail'];
            }
            $post += $modifier;
            $post['patch'] = 1;
            $result        = MyHelper::post('product/modifier/update', $post);
            return $result;
        }
        if (isset($post['type_dropdown'])) {
            $post['type'] = $post['type_dropdown'];
        } else {
            $post['type'] = "Topping";
        }
        $post['id_product_modifier'] = $id;
        if ($post['type'] == '0') {
            $post['type'] = $post['type_textbox'];
        }
        $result = MyHelper::post('product/modifier/update', $post);
        if (($result['status'] ?? false) == 'success') {
            return redirect('product/modifier/' . $post['code'])->with('success', ['Success update topping']);
        } else {
            if (stristr($result['message'] ?? '', 'SQLSTATE[23000]')) {
                $result['message'] = 'Another topping with code "' . $post['code'] . '" aready exist';
            }
            return back()->withErrors($result['messages'] ?? [$result['message'] ?? 'Something went wrong'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::post('product/modifier/delete', ['id_product_modifier' => $id]);
        if ($result['status'] == 'success') {
            return redirect('product/modifier')->with('success', ['Success delete topping']);
        }
        return redirect('product/modifier')->withErrors(['Fail delete topping']);
    }
    /**
     * Get list product modifiers
     * @return view list modifiers price
     */
    public function listPrice(Request $request, $id_outlet = null)
    {
        $outlets = MyHelper::post('outlet/be/list', ['filter' => 'different_price'])['result'] ?? [];
        if (($id_outlet && !in_array($id_outlet, array_column($outlets, 'id_outlet'))) || !is_numeric($id_outlet)) {
            $outlet = 0;
            return redirect('product/modifier/price/' . $outlet);
        }
        $data = [
            'title'          => 'Topping',
            'sub_title'      => 'Topping Prices',
            'menu_active'    => 'product-modifier',
            'submenu_active' => 'product-modifier-price',
            'filter_title'   => 'Filter Topping',
        ];
        if (session('product_modifier_price_filter')) {
            $post             = session('product_modifier_price_filter');
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } else {
            $post = [];
        }
        $page = $request->page;
        if (!$page) {
            $page = 1;
        }
        $data['key']       = $id_outlet;
        $data['outlets']   = $outlets;
        $post['id_outlet'] = $id_outlet;
        $types             = MyHelper::get('product/modifier/type')['result'] ?? [];
        $data['types']     = array_map(function ($q) {
            return [$q, $q];
        }, $types);
        $data['modifiers'] = MyHelper::post('product/modifier/list-price?page=' . $page, $post)['result'] ?? [];
        $data['total']     = $data['modifiers']['total'];
        $data['paginator'] = new LengthAwarePaginator($data['modifiers']['data'], $data['modifiers']['total'], $data['modifiers']['per_page'], $data['modifiers']['current_page'], ['path' => url()->current()]);

        $data['start']     = ($page - 1) * 10;
        $data['next_page'] = $data['modifiers']['next_page_url'] ? url()->current() . '?page=' . ($page + 1) : '';
        $data['prev_page'] = $data['modifiers']['prev_page_url'] ? url()->current() . '?page=' . ($page - 1) : '';
        return view('product::modifier.price', $data);
    }

    /**
     * update price product modifiers
     * @return view list modifiers price
     */
    public function updatePrice(Request $request, $id_outlet = null)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['product_modifier_price_filter' => $post]);
            return redirect('product/modifier/price');
        }
        if ($post['clear'] ?? false) {
            session(['product_modifier_price_filter' => null]);
            return redirect('product/modifier/price');
        }
        $post['id_outlet'] = $id_outlet;
        $result            = MyHelper::post('product/modifier/update-price', $post);
        if (($result['status'] ?? false) == 'success') {
            return back()->with('success', ['Success update price']);
        } else {
            return back()->withErrors(['Fail update price']);
        }
    }
    /**
     * Get list product modifiers
     * @return view list modifiers detail
     */
    public function listDetail(Request $request, $id_outlet = null)
    {
        $outlets = MyHelper::get('outlet/be/list')['result'] ?? [];
        if (!$outlets) {
            return back()->withErrors(['Something went wrong']);
        }
        if (!$id_outlet || !in_array($id_outlet, array_column($outlets, 'id_outlet'))) {
            $outlet = $outlets[0]['id_outlet'] ?? false;
            if (!$outlet) {
                return back()->withErrors(['Something went wrong']);
            }
            return redirect('product/modifier/detail/' . $outlet);
        }
        $data = [
            'title'          => 'Topping',
            'sub_title'      => 'Topping Details',
            'menu_active'    => 'product-modifier',
            'submenu_active' => 'product-modifier-detail',
            'filter_title'   => 'Filter Topping',
        ];
        if (session('product_modifier_detail_filter')) {
            $post             = session('product_modifier_detail_filter');
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } else {
            $post = [];
        }
        $page = $request->page;
        if (!$page) {
            $page = 1;
        }
        $data['key']       = $id_outlet;
        $data['outlets']   = $outlets;
        $post['id_outlet'] = $id_outlet;
        $types             = MyHelper::get('product/modifier/type')['result'] ?? [];
        $data['types']     = array_map(function ($q) {
            return [$q, $q];
        }, $types);
        $data['modifiers'] = MyHelper::post('product/modifier/list-detail?page=' . $page, $post)['result'] ?? [];
        $data['total']     = $data['modifiers']['total'];
        $data['paginator'] = new LengthAwarePaginator($data['modifiers']['data'], $data['modifiers']['total'], $data['modifiers']['per_page'], $data['modifiers']['current_page'], ['path' => url()->current()]);

        $data['start']     = ($page - 1) * 10;
        $data['next_page'] = $data['modifiers']['next_page_url'] ? url()->current() . '?page=' . ($page + 1) : '';
        $data['prev_page'] = $data['modifiers']['prev_page_url'] ? url()->current() . '?page=' . ($page - 1) : '';
        return view('product::modifier.detail', $data);
    }

    /**
     * update detail product modifiers
     * @return view list modifiers detail
     */
    public function updateDetail(Request $request, $id_outlet = null)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['product_modifier_detail_filter' => $post]);
            return redirect('product/modifier/detail');
        }
        if ($post['clear'] ?? false) {
            session(['product_modifier_detail_filter' => null]);
            return redirect('product/modifier/detail');
        }
        $post['id_outlet'] = $id_outlet;
        $result            = MyHelper::post('product/modifier/update-detail', $post);
        if (($result['status'] ?? false) == 'success') {
            return back()->with('success', ['Success update detail']);
        } else {
            return back()->withErrors(['Fail update detail']);
        }
    }

    public function position()
    {
        $data = [
            'title'          => 'Topping',
            'sub_title'      => 'Topping Manage Position',
            'menu_active'    => 'product-modifier',
            'submenu_active' => 'product-modifier-position'
        ];

        $get = MyHelper::post('product/modifier', ['order_position' => 1]);

        if (isset($get['status']) && $get['status'] == 'success') {
            $data['list'] = $get['result'];
            return view('product::modifier.position', $data);
        } else {
            return redirect('product/modifier')->withErrors(['Fail get list position']);
        }
    }

    public function positionAssign(Request $request)
    {
        $post = $request->except('_token');
        if (!isset($post['modifier_ids'])) {
            return [
                'status' => 'fail',
                'messages' => ['Topping id is required']
            ];
        }
        $result = MyHelper::post('product/modifier/position-assign', $post);

        return $result;
    }

    public function inventoryBrand(Request $request)
    {
        $data = [
            'title'          => 'Topping',
            'sub_title'      => 'Topping Inventory Brand',
            'menu_active'    => 'product-modifier',
            'submenu_active' => 'product-modifier-inventory-brand'
        ];
        $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
        $data['modifiers'] = MyHelper::get('product/modifier/inventory-brand')['result'] ?? [];
        $data['modifiers'] = array_map(function ($modifier) {
            $modifier['inventory_brand'] = array_column($modifier['inventory_brand'], 'id_brand');
            return $modifier;
        }, $data['modifiers']);
        return view('product::modifier.inventory_brand', $data);
    }


    public function inventoryBrandUpdate(Request $request)
    {
        $result = MyHelper::post('product/modifier/inventory-brand', $request->all());
        if (($result['status'] ?? false) == 'success') {
            return back()->withSuccess(['Success update']);
        }
        return back()->withErrors($result['messages'] ?? ['Something went wrong']);
    }
}
