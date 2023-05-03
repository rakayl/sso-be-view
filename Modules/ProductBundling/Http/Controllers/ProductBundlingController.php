<?php

namespace Modules\ProductBundling\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Session;

class ProductBundlingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'Product Bundling List',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-list',
        ];

        if (Session::has('filter-list-bundling') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-bundling');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-bundling');
        }

        $bundling = MyHelper::post('product-bundling/list', $post);

        if (isset($bundling['status']) && $bundling['status'] == "success") {
            $data['data']          = $bundling['result']['data'];
            $data['dataTotal']     = $bundling['result']['total'];
            $data['dataPerPage']   = $bundling['result']['from'];
            $data['dataUpTo']      = $bundling['result']['from'] + count($bundling['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($bundling['result']['data'], $bundling['result']['total'], $bundling['result']['per_page'], $bundling['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        $data['order_field'] = $post['order_field'] ?? 'id_bundling';
        $data['order_method'] = $post['order_method'] ?? 'asc';
        if ($post) {
            Session::put('filter-list-bundling', $post);
        }

        return view('productbundling::index', $data);
    }

    public function create()
    {
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'New Product Bundling',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-new',
        ];

        $data['outlet_group_filter'] = MyHelper::get('outlet/group-filter')['result'] ?? [];
        $data['category'] = MyHelper::get('product-bundling-category/list')['result'] ?? [];
        $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
        return view('productbundling::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['photo'])) {
            $post['photo'] = MyHelper::encodeImage($post['photo']);
        }

        if (isset($post['photo_detail'])) {
            $post['photo_detail'] = MyHelper::encodeImage($post['photo_detail']);
        }

        $store = MyHelper::post('product-bundling/store', $post);
        if (isset($store['status']) && $store['status'] == 'success') {
            return redirect('product-bundling')->withSuccess(['Success create product bundling']);
        } else {
            return redirect('product-bundling/create')->withErrors($store['messages'] ?? ['Failed create product bundling'])->withInput();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function detail($id)
    {
        $detail = MyHelper::post('product-bundling/be/detail', ['id_bundling' => $id]);

        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data = [
                'title'          => 'Product Bundling',
                'sub_title'      => 'Product Bundling Detail',
                'menu_active'    => 'product-bundling',
                'submenu_active' => 'product-bundling-list',
            ];

            $data['category'] = MyHelper::get('product-bundling-category/list')['result'] ?? [];
            $data['result'] = $detail['result']['detail'];
            $data['outlets'] = $detail['result']['outlets'] ?? [];
            $data['selected_outlet'] = $detail['result']['selected_outlet'] ?? [];
            $data['count_list_product'] = count($detail['result']['detail']['bundling_product'] ?? []);
            $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
            $data['brand_tmp'] = json_encode($detail['result']['brand_tmp']) ?? [];
            $data['outlet_group_filter'] = MyHelper::get('outlet/group-filter')['result'] ?? [];
            $data['selected_outlet_group_filter'] = array_column($detail['result']['detail']['bundling_outlet_group'] ?? [], 'id_outlet_group');

            return view('productbundling::detail', $data);
        } else {
            return redirect('product-bundling')->withErrors($store['messages'] ?? ['Failed get detail product bundling']);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        if (isset($post['photo'])) {
            $post['photo'] = MyHelper::encodeImage($post['photo']);
        }

        if (isset($post['photo_detail'])) {
            $post['photo_detail'] = MyHelper::encodeImage($post['photo_detail']);
        }

        $post['id_bundling'] = $id;
        $update = MyHelper::post('product-bundling/update', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('product-bundling/detail/' . $id)->withSuccess(['Success update product bundling']);
        } else {
            return redirect('product-bundling/detail/' . $id)->withErrors($update['messages'] ?? ['Failed update product bundling']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('product-bundling/delete', $post);
        return $delete;
    }

    public function destroyBundlingProduct(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('product-bundling/delete-product', $post);
        return $delete;
    }

    public function productBrand(Request $request)
    {
        $post = $request->except('_token');
        $getDataProduct = MyHelper::post('product/product-brand', $post);
        return $getDataProduct;
    }

    public function outletAvailable(Request $request)
    {
        $post = $request->except('_token');
        $outlets = MyHelper::post('product-bundling/outlet-available', $post);
        return $outlets;
    }
    public function getGlobalPrice(Request $request)
    {
        $post = $request->except('_token');
        $outlets = MyHelper::post('product-bundling/global-price', $post);
        return $outlets;
    }

    public function positionAssign()
    {
        $data = [
            'title'          => 'Manage Product Bundling Position',
            'sub_title'      => 'Assign Product Bundling Position',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-position'
        ];

        $catParent = MyHelper::get('product-bundling-category/list');
        if (isset($catParent['status']) && $catParent['status'] == "success") {
            $data['category'] = $catParent['result'];
        } else {
            $data['category'] = [];
        }

        $bundlings = MyHelper::post('product-bundling/list', ['all_data' => 1]);

        if (isset($bundlings['status']) && $bundlings['status'] == "success") {
            $data['bundlings'] = $bundlings['result'];
        } else {
            $data['bundlings'] = [];
        }

        return view('productbundling::category.position', $data);
    }

    public function updatePositionAssign(Request $request)
    {
        $post = $request->except('_token');
        if (!isset($post['product_ids'])) {
            return [
                'status' => 'fail',
                'messages' => ['Product id is required']
            ];
        }
        $result = MyHelper::post('product-bundling/position/assign', $post);

        return $result;
    }

    public function settings(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Product Bundling',
                'sub_title'      => 'Setting Name Brand Product Bundling',
                'menu_active'    => 'product-bundling',
                'submenu_active' => 'product-bundling-setting'
            ];
            $data['result'] = MyHelper::get('product-bundling/setting')['result'] ?? [];
            return view('productbundling::setting', $data);
        } else {
            $update = MyHelper::post('product-bundling/setting', $post);

            if (isset($update['status']) && $update['status'] == 'success') {
                return redirect('product-bundling/setting')->withSuccess(['Success update product bundling']);
            } else {
                return redirect('product-bundling/setting')->withErrors($update['messages'] ?? ['Failed update product bundling']);
            }
        }
    }
}
