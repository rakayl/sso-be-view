<?php

namespace Modules\ProductVariant\Http\Controllers;

use App\Exports\MultisheetExport;
use App\Exports\ProductExport;
use App\Exports\ProductVariantPriceArrayExport;
use App\Exports\ProductVariantPriceMultisheetExport;
use App\Imports\ProductImport;
use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Excel;
use App\Imports\FirstSheetOnlyImport;
use Session;

class ProductVariantGroupController extends Controller
{
    public function listProductVariant(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Product Variant (SKU)',
            'sub_title'      => 'Product Variant (SKU) List',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-group-remove'
        ];

        if (Session::has('filter-product-variant-group') && !empty($post) && !isset($post['filter'])) {
            $post = Session::get('filter-product-variant-group');
        } else {
            Session::forget('filter-product-variant-group');
        }

        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('product-variant-group/list-group', $post);

            if (isset($list['status']) && $list['status'] == 'success') {
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            } else {
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }
            return response()->json($arr_result);
        }

        if ($post) {
            Session::put('filter-product-variant-group', $post);
        }

        $data['conditions'] = $post['conditions'] ?? [];
        return view('productvariant::group.product_variant_list', $data);
    }

    public function removeProductVariant(Request $request)
    {
        $post = $request->all();
        if (Session::has('filter-product-variant-group')) {
            $post['conditions'] = Session::get('filter-product-variant-group')['conditions'] ?? [];
        }
        $remove = MyHelper::post('product-variant-group/remove', $post);

        if (isset($remove['fail']) && !empty($remove['fail'])) {
            return redirect('product-variant-group/list-group')->withErrors($remove['messages'] ?? ['Something went wrong']);
        } else {
            return redirect('product-variant-group/list-group')->with('success', ['Success remove product variant']);
        }
    }

    public function listProduct(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Product Variant (SKU)',
            'sub_title'      => 'Product List',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-group-list'
        ];

        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('product-variant-group/list', $request->all());

            if (isset($list['status']) && $list['status'] == 'success') {
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            } else {
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }

        return view('productvariant::group.product_list', $data);
    }

    public function editProductVariant(Request $request, $product_code)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Product Variant (SKU)',
            'sub_title'      => 'Product Variant (SKU) Edit',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-group-list'
        ];

        if (empty($post)) {
            $data['products'] = MyHelper::post('product/be/list', ['product_code' => $product_code, 'outlet_prices' => 1])['result'] ?? [];
            $data['product_variant'] = MyHelper::get('product-variant')['result'] ?? [];
            $data['product_variant_group'] = MyHelper::post('product-variant-group', ['product_code' => $product_code])['result'] ?? [];
            $data['count'] = count($data['product_variant_group']);
            $data['product_code'] = $product_code;
            return view('productvariant::group.product_detail', $data);
        } else {
            $post = $request->all();
            $post['product_code'] = $product_code;
            $create_update = MyHelper::post('product-variant-group', $post);

            if (($create_update['status'] ?? '') == 'success') {
                return redirect('product-variant-group/edit/' . $product_code)->with('success', ['Update Product Variant Group Success']);
            } else {
                return redirect('product-variant-group/edit/' . $product_code)->withErrors($create_update['messages'] ?? ['Something went wrong']);
            }
        }
    }

    public function deleteProductVariant($product_code)
    {
        $result = MyHelper::post('product-variant-group/product-delete', ['product_code' => $product_code]);

        if (isset($result['status']) && $result['status'] == 'success') {
            return redirect('product-variant-group/list')->with('success', ['Delete All Product Variant Group Success']);
        }
        return redirect('product-variant-group/list')->withErrors($result['messages'] ?? ['Something went wrong']);
    }

    public function listPrice(Request $request, $id_outlet = null)
    {
        $outlets = MyHelper::post('outlet/be/list', ['filter' => 'different_price'])['result'] ?? [];
        if (($id_outlet && !in_array($id_outlet, array_column($outlets, 'id_outlet'))) || !is_numeric($id_outlet)) {
            $outlet = 0;
            return redirect('product-variant-group/price/' . $outlet);
        }

        $data = [
            'title'          => 'Product Variant (SKU)',
            'sub_title'      => 'Product Variant (SKU) Price',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-group-price',
            'filter_title'   => 'Filter Product Variant',
        ];
        if (session('product_variant_group_price_filter')) {
            $post             = session('product_variant_group_price_filter');
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } else {
            $post = [];
        }

        $data['key']       = $id_outlet;
        $data['outlets']   = $outlets;
        $post['id_outlet'] = $id_outlet;
        $page = $request->page;
        if (!$page) {
            $page = 1;
        }
        $post['page'] = $page;

        $get = MyHelper::post('product-variant-group/list-price', $post);

        if (isset($get['status']) && $get['status'] == "success") {
            $data['total']     = $get['result']['total'];
            $data['productVariant']  = $get['result']['data'];
            $data['productVariantTotal']     = $get['result']['total'];
            $data['productVariantPerPage']   = $get['result']['from'];
            $data['productVariantUpTo']      = $get['result']['from'] + count($get['result']['data']) - 1;
            $data['productVariantPaginator'] = new LengthAwarePaginator($get['result']['data'], $get['result']['total'], $get['result']['per_page'], $get['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['productVariant']  = [];
            $data['productVariantTotal']     = 0;
            $data['productVariantPerPage']   = 0;
            $data['productVariantUpTo']      = 0;
            $data['productVariantPaginator'] = false;
            $data['total'] = 0;
        }

        return view('productvariant::group.price', $data);
    }

    public function updatePrice(Request $request, $id_outlet = null)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['product_variant_group_price_filter' => $post]);
            return redirect('product-variant-group/price');
        }
        if ($post['clear'] ?? false) {
            session(['product_variant_group_price_filter' => null]);
            return redirect('product-variant-group/price');
        }
        $post['id_outlet'] = $id_outlet;
        $result            = MyHelper::post('product-variant-group/update-price', $post);

        if (($result['status'] ?? false) == 'success') {
            return back()->with('success', ['Success update price']);
        } else {
            return back()->withErrors(['Fail update price']);
        }
    }

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
            return redirect('product-variant-group/detail/' . $outlet);
        }
        $data = [
            'title'          => 'Product Variant (SKU)',
            'sub_title'      => 'Product Variant (SKU) Detail',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-group-detail',
            'filter_title'   => 'Filter Product Variant',
        ];
        if (session('product_variant_group_detail_filter')) {
            $post             = session('product_variant_group_detail_filter');
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } else {
            $post = [];
        }
        $data['key']       = $id_outlet;
        $data['outlets']   = $outlets;
        $post['id_outlet'] = $id_outlet;
        $page = $request->page;
        if (!$page) {
            $page = 1;
        }
        $post['page'] = $page;

        $get = MyHelper::post('product-variant-group/list-detail', $post);

        if (isset($get['status']) && $get['status'] == "success") {
            $data['total']     = $get['result']['total'];
            $data['productVariant']  = $get['result']['data'];
            $data['productVariantTotal']     = $get['result']['total'];
            $data['productVariantPerPage']   = $get['result']['from'];
            $data['productVariantUpTo']      = $get['result']['from'] + count($get['result']['data']) - 1;
            $data['productVariantPaginator'] = new LengthAwarePaginator($get['result']['data'], $get['result']['total'], $get['result']['per_page'], $get['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['productVariant']  = [];
            $data['productVariantTotal']     = 0;
            $data['productVariantPerPage']   = 0;
            $data['productVariantUpTo']      = 0;
            $data['productVariantPaginator'] = false;
            $data['total'] = 0;
        }

        return view('productvariant::group.detail', $data);
    }

    public function updateDetail(Request $request, $id_outlet = null)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['product_variant_group_detail_filter' => $post]);
            return redirect('product-variant-group/detail');
        }
        if ($post['clear'] ?? false) {
            session(['product_variant_group_detail_filter' => null]);
            return redirect('product-variant-group/detail');
        }
        $post['id_outlet'] = $id_outlet;
        $result            = MyHelper::post('product-variant-group/update-detail', $post);
        if (($result['status'] ?? false) == 'success') {
            return back()->with('success', ['Success update detail']);
        } else {
            return back()->withErrors(['Fail update detail']);
        }
    }

    public function export(Request $request)
    {
        $post = $request->except('_token');
        $data = MyHelper::post('product-variant-group/export', $post)['result'] ?? [];
        $tab_title = 'List Product Variant';

        if (empty($data)) {
            $datas['brand'] = [
                'name_brand' => '',
                'code_brand' => ''
            ];
            $datas['products'] = [
                [
                    'product_name' => 'Product 1',
                    'product_code' => 'P1',
                    'use_product_variant_status' => 'YES',
                    'Size' => 'S,M,L',
                    'Type' => 'Hot,Ice'
                ],
                [
                    'product_name' => 'Product 2',
                    'product_code' => 'P2',
                    'use_product_variant_status' => 'NO',
                    'Size' => '',
                    'Type' => ''
                ]
            ];
        } else {
            $datas = $data;
        }

        $tab_title = 'List Products';
        return Excel::download(new ProductExport($datas['products'], $datas['brand'], $tab_title), date('YmdHi') . '_product variant_' . $datas['brand']['name_brand'] . '.xlsx');
    }

    public function import(Request $request)
    {
        $data = [
            'title'          => 'Product Variant (SKU)',
            'sub_title'      => 'Import Product Variant',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-group-import-global'
        ];

        $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
        return view('productvariant::group.import', $data);
    }

    public function importSave(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $excel = \Excel::toCollection(new ProductImport(), $request->file('import_file'));
            $data = [];
            $head = [];
            foreach ($excel[0] ?? [] as $key => $value) {
                $value = json_decode($value);
                if ($key == 2) {
                    $head = $value;
                } elseif ($key > 2) {
                    $data[] = array_combine($head, $value);
                }
            }

            if (!empty($data)) {
                $import = MyHelper::post('product-variant-group/import', ['data' => $data]);
                return $import;
            } else {
                return [
                    'status' => 'fail',
                    'messages' => ['File empty']
                ];
            }
        } else {
            return [
                'status' => 'fail',
                'messages' => ['File empty']
            ];
        }
    }

    public function exportPrice(Request $request)
    {
        $post = $request->except('_token');
        $data = MyHelper::post('product-variant-group/export-price', $post)['result'] ?? [];
        $tab_title = 'List Product Variant Price';

        if (empty($data)) {
            $datas['brand'] = [
                'name_brand' => '',
                'code_brand' => ''
            ];
            $datas['products_variant'] = [
                [
                    'product' => 'P1 - Kopi Susu',
                    'current_product_variant_code' => 'PVG001',
                    'new_product_variant_code' => '',
                    'product_variant' => 'Hot,S',
                    'global_price' => 10000,
                    'price_PP001' => 15000,
                    'price_PP002' => 13500
                ],
                [
                    'product' => 'P2 - Kopi',
                    'current_product_variant_code' => 'PVG002',
                    'new_product_variant_code' => 'PVG002A',
                    'product_variant' => 'Hot,L',
                    'global_price' => 15000,
                    'price_PP001' => 20000,
                    'price_PP002' => 23000
                ],
                [
                    'product' => 'P3 - Es Milo',
                    'current_product_variant_code' => 'PVG003',
                    'new_product_variant_code' => '',
                    'product_variant' => 'Ice, S',
                    'global_price' => 15000,
                    'price_PP001' => 20000,
                    'price_PP002' => 23000
                ]
            ];
        } else {
            $datas = $data;
        }

        $tab_title = 'List Product Variant';
        return Excel::download(new ProductVariantPriceArrayExport($datas['products_variant'], $datas['brand'], $tab_title), date('YmdHi') . '_product variant price_' . $datas['brand']['name_brand'] . '.xlsx');
    }

    public function importPrice(Request $request)
    {
        $data = [
            'title'          => 'Product Variant (SKU)',
            'sub_title'      => 'Import Product Variant Price',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-group-import-price'
        ];
        $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
        return view('productvariant::group.import_price', $data);
    }

    public function importPriceSave(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $excel = \Excel::toCollection(new ProductImport(), $request->file('import_file'));
            $data = [];
            $head = [];
            foreach ($excel[0] ?? [] as $key => $value) {
                $value = json_decode($value);
                if ($key == 2) {
                    $head = $value;
                } elseif ($key > 2) {
                    $data[] = array_combine($head, $value);
                }
            }

            if (!empty($data)) {
                $import = MyHelper::post('product-variant-group/import-price', ['data' => $data]);
                return $import;
            } else {
                return [
                    'status' => 'fail',
                    'messages' => ['File empty']
                ];
            }
        } else {
            return [
                'status' => 'fail',
                'messages' => ['File empty']
            ];
        }
    }

    public function productVariantGroupList(Request $request)
    {
        $post = $request->except('_token');
        $get = MyHelper::post('product-variant-group', $post);
        return '';
    }

    public function ajaxProductvariantGroup($idProduct)
    {
        $productVariant = MyHelper::get('product-variant-group/ajax/' . $idProduct . '?log_save=0');
        if (isset($productVariant['result'])) {
            return $productVariant['result'];
        }
        return [];
    }
}
