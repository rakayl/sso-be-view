<?php

namespace Modules\Product\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use function GuzzleHttp\Promise\queue;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function categoryList(Request $request)
    {
        $data = [
            'title'          => 'Category',
            'sub_title'      => 'Category List',
            'menu_active'    => 'product',
            'submenu_active' => 'product-category-list'
        ];

        $data['get_category'] = MyHelper::post('product/category/be/list', $request->all())['result'] ?? [];

        $data['category'] = json_encode([]);
        if (!empty($data['get_category'])) {
            $data['category'] = json_encode($this->buildTree($data['get_category']));
        }

        return view('product::category.list', $data);
    }

    public function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['id_parent_category'] == $parentId) {
                $children = $this->buildTree($elements, $element['id_product_category']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        if (isset($post['data'][0]['product_category_image'])) {
            $post['data'][0]['product_category_image'] = MyHelper::encodeImage($post['data'][0]['product_category_image']);
        }

        if (!empty($post['data']['child'])) {
            foreach ($post['data']['child'] as $key => $child) {
                if (!empty($child['product_category_image'])) {
                    $post['data']['child'][$key]['product_category_image'] = MyHelper::encodeImage($child['product_category_image']);
                }
            }
        }

        $store = MyHelper::post('product/category/create', $post);

        if (($store['status'] ?? '') == 'success') {
            return redirect('product/category')->with('success', ['Create Category Success']);
        } else {
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'title'          => 'Category',
            'sub_title'      => 'Update Category',
            'menu_active'    => 'product',
            'submenu_active' => 'role'
        ];

        $post['id_product_category'] = $id;
        $get_data = MyHelper::post('product/category/edit', $post);

        $data['all_parent'] = [];
        $data['category'] = [];
        if (($get_data['status'] ?? '') == 'success') {
            $data['all_parent'] = $get_data['result']['all_parent'];
            $data['category'] = $get_data['result']['category'];
        }

        return view('product::category.update', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->all();
        $post['id_product_category'] = $id;
        if (!empty($post['product_category_image'])) {
            $post['product_category_image'] = MyHelper::encodeImage($post['product_category_image']);
        }

        if (!empty($post['child'])) {
            foreach ($post['child'] as $key => $child) {
                if (!empty($child['product_category_image'])) {
                    $post['child'][$key]['product_category_image'] = MyHelper::encodeImage($child['product_category_image']);
                }
            }
        }

        $update = MyHelper::post('product/category/update', $post);

        if (($update['status'] ?? '') == 'success') {
            return redirect('product/category/edit/' . $id)->with('success', ['Updated Category Success']);
        } else {
            return back()->withInput()->withErrors($update['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function delete($id)
    {
        $result = MyHelper::post('product/category/delete', ['id_product_category' => $id]);
        return $result;
    }
}
