<?php

namespace Modules\ProductBundling\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Session;

class BundlingCategoryController extends Controller
{
    //Product Bundling Category
    public function indexBundlingCategory()
    {
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'Product Bundling Category',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-category',
        ];

        $bundling = MyHelper::get('product-bundling-category/list');

        if (isset($bundling['status']) && $bundling['status'] == "success") {
            $data['data']          = $bundling['result'];
        } else {
            $data['data']          = [];
        }

        return view('productbundling::category.list', $data);
    }

    public function createBundlingCategory()
    {
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'New Bundling Category',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-category-new',
        ];

        $data['bundling_category_parent'] = MyHelper::post('product-bundling-category/list', ['id_parent_category' => 0])['result'] ?? [];
        return view('productbundling::category.create', $data);
    }

    public function storeBundlingCategory(Request $request)
    {
        $post = $request->except('_token');
        $store = MyHelper::post('product-bundling-category/store', $post);

        if (isset($store['status']) && $store['status'] == 'success') {
            return redirect('product-bundling/category')->withSuccess(['Success create bundling category']);
        } else {
            return redirect('product-bundling/category/create')->withErrors($store['messages'] ?? ['Failed create bundling category'])->withInput();
        }
    }

    public function updateBundlingCategory(Request $request, $id)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Product Bundling',
            'sub_title'      => 'Bundling Category Update',
            'menu_active'    => 'product-bundling',
            'submenu_active' => 'product-bundling-category',
        ];

        if (empty($post)) {
            $detail = MyHelper::post('product-bundling-category/list', ['id_bundling_category' => $id]);
            if (isset($detail['status']) && $detail['status'] == 'success') {
                $data['parent'] = MyHelper::post('product-bundling-category/list', ['id_parent_category' => 0])['result'] ?? [];
                $data['category'] = $detail['result'];
                return view('productbundling::category.update', $data);
            } else {
                return redirect('product-bundling/category')->withErrors($store['messages'] ?? ['Failed get detail bundling category'])->withInput();
            }
        } else {
            if (isset($post['id_parent_category']) && $post['id_parent_category'] == 0) {
                $post['id_parent_category'] = null;
            }

            $save = MyHelper::post('product-bundling-category/update', $post);
            if (isset($save['status']) && $save['status'] == 'success') {
                return redirect('product-bundling/category/edit/' . $id)->withSuccess(['Success create bundling category']);
            } else {
                return redirect('product-bundling/category/edit/' . $id)->withErrors($store['messages'] ?? ['Failed create bundling category'])->withInput();
            }
        }
    }

    public function deleteBundlingCategory(Request $request)
    {
        $post = $request->except('_token');

        $delete = MyHelper::post('product-bundling-category/delete', $post);
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    public function positionCategoryAssign(Request $request)
    {
        $post = $request->except('_token');
        if (!isset($post['category_ids'])) {
            return [
                'status' => 'fail',
                'messages' => ['Category id is required']
            ];
        }

        $result = MyHelper::post('product-bundling-category/position/assign', $post);

        return $result;
    }
}
