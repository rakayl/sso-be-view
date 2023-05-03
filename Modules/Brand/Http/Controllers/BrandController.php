<?php

namespace Modules\Brand\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Brand',
            'sub_title'      => 'Brand List',
            'menu_active'    => 'brand',
            'submenu_active' => 'brand-list',
        ];

        $brand = MyHelper::get('brand');
        $default = MyHelper::get('brand/default')['result'] ?? null;
        if (isset($brand['status']) && $brand['status'] == "success") {
            foreach ($brand['result'] as $key => $value) {
                $brand['result'][$key]['default_brand_status'] = 0;
                if ($default == $value['id_brand']) {
                    $brand['result'][$key]['default_brand_status'] = 1;
                }
                $brand['result'][$key]['id_brand'] = MyHelper::createSlug($value['id_brand'], $value['created_at']);
            }
            $data['brand'] = $brand['result'];
        } else {
            $data['brand'] = [];
        }
        return view('brand::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'New Brand',
            'menu_active'    => 'brand',
            'submenu_active' => 'brand-new',
        ];

        return view('brand::form', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except(['_token']);
        $post['brand_active'] = $post['brand_active'] ?? 0;
        if (isset($post['id_brand'])) {
            $id_brand_encrypt = $post['id_brand'] ?? null;
            $post['id_brand'] = MyHelper::explodeSlug($post['id_brand'])[0] ?? '';
        }

        $data = [
            'title'          => 'New Brand',
            'menu_active'    => 'brand',
            'submenu_active' => 'brand-new',
        ];

        if (isset($post['logo_brand']) && $post['logo_brand'] != null) {
            $post['logo_brand'] = MyHelper::encodeImage($post['logo_brand']);
        }

        if (isset($post['image_brand']) && $post['image_brand'] != null) {
            $post['image_brand'] = MyHelper::encodeImage($post['image_brand']);
        }

        $action = MyHelper::post('brand/store', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            if (!empty($action['result']['created_at'])) {
                $slug = MyHelper::createSlug($action['result']['id_brand'], $action['result']['created_at']);
            } else {
                $slug = $id_brand_encrypt;
                ;
            }
            return redirect('brand/detail/' . $slug)->with('success', ['Update brand success']);
        } else {
            return redirect('brand/create')->withInput()->withErrors($action['messages']);
        }
    }

    public function createOutlet(Request $request)
    {
        $post   = $request->all();
        $id_brand_decrypt = MyHelper::explodeSlug($post['id_brand'])[0] ?? '';

        foreach ($post['outlet'] as $key => $value) {
            $data['outlet'][$key]['id_brand']   = $id_brand_decrypt;
            $data['outlet'][$key]['id_outlet']  = $value;
            $data['outlet'][$key]['created_at']  = $value;
            $data['outlet'][$key]['updated_at']  = $value;
        }
        $action = MyHelper::post('brand/outlet/store', $data['outlet']);
        if (isset($action['status']) && $action['status'] == 'success') {
            return redirect('brand/outlet/' . $post['id_brand']);
        } else {
            return redirect('brand/outlet/' . $post['id_brand'])->withInput()->withErrors($action['messages']);
        }
    }

    public function createProduct(Request $request)
    {
        $post   = $request->all();
        $id_brand_decrypt = MyHelper::explodeSlug($post['id_brand'])[0] ?? '';

        foreach ($post['product'] as $key => $value) {
            $data['product'][$key]['id_brand']      = $id_brand_decrypt;
            $data['product'][$key]['id_product']    = $value;
            $data['product'][$key]['created_at']    = $value;
            $data['product'][$key]['updated_at']    = $value;
        }

        $action = MyHelper::post('brand/product/store', $data['product']);

        if (isset($action['status']) && $action['status'] == 'success') {
            return redirect('brand/product/' . $post['id_brand']);
        } else {
            return redirect('brand/product/' . $post['id_brand'])->withInput()->withErrors($action['messages']);
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id_brand)
    {
        $data = [
            'menu_active'    => 'brand',
            'submenu_active' => 'brand-list',
        ];

        $id_brand_decrypt = MyHelper::explodeSlug($id_brand)[0] ?? '';

        $action = MyHelper::post('brand/show', ['id_brand' => $id_brand_decrypt]);
        if (($action['status'] == 'success') ?? false) {
            $action['result']['id_brand'] = $id_brand;

            if (!empty($action['result']['brand_outlet'])) {
                foreach ($action['result']['brand_outlet'] as $key => $value) {
                    $action['result']['brand_outlet'][$key]['id_brand'] = $action['result']['id_brand'];
                }
            }
        }
        // dd($action);
        $urlNow = array_slice(explode('/', $_SERVER['REQUEST_URI']), 0, -1);

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            if (end($urlNow) == 'detail') {
                $data['title']      = 'Detail Brand ';
                return view('brand::form', $data);
            } elseif (end($urlNow) == 'outlet') {
                $data['title']      = 'Brand ';
                $data['sub_title']  = 'List Outlet';
                return view('brand::outlet', $data);
            } elseif (end($urlNow) == 'product') {
                $data['title']      = 'Brand ';
                $data['sub_title']  = 'List Product';
                return view('brand::product', $data);
            } elseif (end($urlNow) == 'deals') {
                $data['title']      = 'Brand ';
                $data['sub_title']  = 'List Deals';
                return view('brand::deals', $data);
            } else {
                return abort(404);
            }
        } else {
            $data['title']      = 'New Brand ';
            return redirect('brand/create')->withInput()->withErrors($action['messages']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request)
    {
        $post   = $request->all();
        $urlNow = explode('/', $_SERVER['REQUEST_URI']);

        if (end($urlNow) == 'outlet') {
            $delete = MyHelper::post('brand/delete/outlet', ['id_brand_outlet' => $post['id_brand_outlet']]);
        } elseif (end($urlNow) == 'product') {
            $delete = MyHelper::post('brand/delete/product', ['id_brand_product' => $post['id_brand_product']]);
        } elseif (end($urlNow) == 'deals') {
            $delete = MyHelper::post('brand/delete/deals', ['id_deals' => $post['id_deals']]);
        } else {
            $post['id_brand'] = MyHelper::explodeSlug($post['id_brand'])[0] ?? '';
            $delete = MyHelper::post('brand/delete', ['id_brand' => $post['id_brand']]);
        }

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    public function reOrder(Request $request)
    {
        $post = $request->except('_token');
        if (!empty($post['order'])) {
            foreach ($post['order'] as $key => $value) {
                $post['order'][$key] = MyHelper::explodeSlug($value)[0] ?? '';
            }
        }

        $update = MyHelper::post('brand/reorder', $post);
        if (($update['status'] ?? false) == 'success') {
            return redirect('brand')->with('success', ['Update brand order success']);
        } else {
            return back()->withErrors($delete['messages'] ?? ['Something went wrong']);
        }
    }

    public function inactiveImage(Request $request)
    {
        $data = [
            'title'          => 'Inactive Brand Image',
            'menu_active'    => 'brand',
            'submenu_active' => 'inactive-brand-image',
        ];

        $post = $request->except('_token');
        if ($post) {
            if (isset($post['image_brand']) && $post['image_brand'] != null) {
                $post['image_brand'] = MyHelper::encodeImage($post['image_brand']);
            }

            $action = MyHelper::post('brand/inactive-image', $post);
            if (($action['status'] ?? false) == 'success') {
                return redirect('brand/inactive-image')->with('success', ['Upload image success']);
            }
            return back()->withErrors($action['messages'] ?? ['Upload image fail']);
        } else {
            $data['inactive_image_brand'] = MyHelper::get('setting/get/inactive_image_brand')['result']['value'] ?? null;
            return view('brand::inactive-image', $data);
        }
    }

    public function list(Request $request)
    {
        $post   = $request->all();
        $post['id_brand'] = MyHelper::explodeSlug($post['id_brand'])[0] ?? '';
        $urlNow = array_slice(explode('/', $_SERVER['REQUEST_URI']), 0, -2);

        if (end($urlNow) == 'outlet') {
            $action = MyHelper::post('brand/outlet/list', ['id_brand' => $post['id_brand']]);
            return $action;
        } elseif (end($urlNow) == 'product') {
            $action = MyHelper::post('brand/product/list', ['id_brand' => $post['id_brand']]);
            return $action;
        }
    }
    /**
     * Switch status active/inactive of brand
     * @param  {'id_brand':'1','status':'1'}
     * @return {'status':'error/success','messages':['error']}
     */
    public function switchStatus(Request $request)
    {
        $post = $request->except('_token');
        $post['id_brand'] = MyHelper::explodeSlug($post['id_brand'])[0] ?? '';
        $action = MyHelper::post('brand/switch_status', $post);
        return $action;
    }
    public function switchVisibility(Request $request)
    {
        $post = $request->except('_token');
        $post['id_brand'] = MyHelper::explodeSlug($post['id_brand'])[0] ?? '';
        $action = MyHelper::post('brand/switch_visibility', $post);
        return $action;
    }
}
