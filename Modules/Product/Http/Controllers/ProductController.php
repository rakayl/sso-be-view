<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Excel;
use Session;
use App\Exports\ProductExport;
use App\Exports\MultisheetExport;
use App\Imports\ProductImport;
use App\Imports\FirstSheetOnlyImport;

class ProductController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->tag  = "Modules\Product\Http\Controllers\TagController";
        $this->categories  = "Modules\Product\Http\Controllers\CategoryController";
    }

    // get category and position
    public function positionAssign(Request $request)
    {
        $data = [
            'title'          => 'Manage Product Position',
            'sub_title'      => 'Assign Products Position',
            'menu_active'    => 'product',
            'submenu_active' => 'product-position',
        ];

        $catParent = MyHelper::get('product/category/be/list');

        if (isset($catParent['status']) && $catParent['status'] == "success") {
            $data['category'] = $catParent['result'];
        } else {
            $data['category'] = [];
        }

        $product = MyHelper::get('product/be/list');

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        } else {
            $data['product'] = [];
        }
        // dd($data);

        return view('product::product.product-position', $data);
    }

    // ajax sort product
    public function positionProductAssign(Request $request)
    {
        $post = $request->except('_token');
        if (!isset($post['product_ids'])) {
            return [
                'status' => 'fail',
                'messages' => ['Product id is required']
            ];
        }
        $result = MyHelper::post('product/position/assign', $post);

        return $result;
    }

    public function categoryAssign(Request $request)
    {
        $post = $request->except('_token');

        $data = [
            'title'          => 'Manage Product Category',
            'sub_title'      => 'Assign Products to Categories',
            'menu_active'    => 'product',
            'submenu_active' => 'product-category',
        ];

        if (!empty($post)) {
            $update = MyHelper::post('product/category/assign', $post);

            if (isset($update['status']) && $update['status'] == 'success') {
                // print_r($update);exit;
                return parent::redirect($update, 'Product categories has been updated.', 'product/category/assign');
            } elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
                return back()->withErrors($update['messages']);
            } else {
                return back()->witherrors(['Update Failed']);
            }
        }

        $catParent = MyHelper::get('product/category/be/list');

        if (isset($catParent['status']) && $catParent['status'] == "success") {
            $data['category'] = $catParent['result'];
        } else {
            $data['category'] = [];
        }

        $product = MyHelper::get('product/be/list');

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        } else {
            $data['product'] = [];
        }

        return view('product::product.product-category', $data);
    }

    public function importProduct($type)
    {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'Import Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-import',
            'type'           => $type
        ];
        switch ($type) {
            case 'global':
                $data['sub_title'] = 'Import Product Global';
                $data['submenu_active'] = 'product-import-global';
                $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
                break;

            case 'detail':
                $data['sub_title'] = 'Import Detail Product';
                $data['submenu_active'] = 'product-import-detail';
                $products = MyHelper::post('product/be/list', ['admin_list' => 1])['result'] ?? [];
                if (!$products) {
                    return redirect('product/import/global')->withErrors(['Product list empty','Upload global list product first']);
                }
                $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
                break;

            case 'price':
                $data['sub_title'] = 'Import Product Price';
                $data['submenu_active'] = 'product-import-price';
                $products = MyHelper::post('product/be/list', ['admin_list' => 1])['result'] ?? [];
                if (!$products) {
                    return redirect('product/import/global')->withErrors(['Product list empty','Upload global list product first']);
                }
                $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
                break;

            case 'modifier-price':
                $data['sub_title'] = 'Import Topping Price';
                $data['menu_active'] = 'product-modifier';
                $data['submenu_active'] = 'product-modifier-import-price';
                $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
                break;

            case 'modifier':
                $data['sub_title'] = 'Import Topping';
                $data['menu_active'] = 'product-modifier';
                $data['submenu_active'] = 'product-modifier-import-global';
                $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
                break;

            default:
                return abort(404);
                break;
        }
        return view('product::product.import.detail', $data);
    }

    /**
     * Export product
     */
    public function export(Request $request, $type)
    {
        $post = $request->except('_token');
        $data = MyHelper::post('product/export', ['type' => $type] + $post)['result'] ?? [];
        if (!$data) {
            return back()->withErrors(['Something went wrong']);
        }
        $tab_title = 'List Products';
        switch ($type) {
            case 'global':
                $tab_title = 'List Products';
                if (!$data['products']) {
                    $data['products'] = [
                        [
                            'product_code' => '001',
                            'product_name' => 'Product 1',
                            'product_description' => 'Example product 1'
                        ],
                        [
                            'product_code' => '002',
                            'product_name' => 'Product 2',
                            'product_description' => 'Example product 2'
                        ],
                        [
                            'product_code' => '003',
                            'product_name' => 'Product 3',
                            'product_description' => 'Example product 3'
                        ],
                    ];
                }
                break;

            case 'detail':
                $tab_title = 'Product Detail';
                if (!$data['products']) {
                    $data['products'] = [
                        [
                            'product_category_name' => 'Snacks',
                            'position' => '1',
                            'product_code' => '001',
                            'product_name' => 'Product 1',
                            'product_description' => 'Example product 1',
                            'product_visibility' => 'Visible'
                        ],
                        [
                            'product_category_name' => 'Snacks',
                            'position' => '2',
                            'product_code' => '002',
                            'product_name' => 'Product 2',
                            'product_description' => 'Example product 2',
                            'product_visibility' => 'Hidden'
                        ],
                        [
                            'product_category_name' => 'Drinks',
                            'position' => '1',
                            'product_code' => '003',
                            'product_name' => 'Product 3',
                            'product_description' => 'Example product 3',
                            'product_visibility' => 'Visible'
                        ],
                    ];
                }
                break;

            case 'price':
                $tab_title = 'Product Price';
                if (!$data['products']) {
                    $data['products'] = [
                        [
                            'product_code' => '001',
                            'product_name' => 'Product 1',
                            'product_description' => 'Example product 1',
                            'global_price' => 10000,
                            'price_PP001' => 15000,
                            'price_BL012' => 13500
                        ],
                        [
                            'product_code' => '002',
                            'product_name' => 'Product 2',
                            'product_description' => 'Example product 2',
                            'global_price' => 20000,
                            'price_PP001' => 30000,
                            'price_BL012' => 25000
                        ],
                        [
                            'product_code' => '003',
                            'product_name' => 'Product 3',
                            'product_description' => 'Example product 3',
                            'global_price' => 12000,
                            'price_PP001' => 18000,
                            'price_BL012' => 15000
                        ],
                    ];
                }
                break;

            case 'modifier-price':
                $tab_title = 'Topping Price';
                if (!$data['products']) {
                    $data['products'] = [
                        [
                            'type' => 'type1',
                            'code' => 'mod1',
                            'name' => 'Example Modifier 1',
                            'global_price' => 1000,
                            'price_PP001' => 1500,
                            'price_BL012' => 1350
                        ],
                        [
                            'type' => 'type1',
                            'code' => 'mod2',
                            'name' => 'Example Modifier 2',
                            'global_price' => 1400,
                            'price_PP001' => 1500,
                            'price_BL012' => 1600
                        ],
                        [
                            'type' => 'type2',
                            'code' => 'mod1',
                            'name' => 'Example Modifier 3',
                            'global_price' => 1200,
                            'price_PP001' => 1500,
                            'price_BL012' => 1500
                        ],
                    ];
                }
                $type = 'topping-price';
                break;

            case 'modifier':
                $tab_title = 'Topping';
                if (!$data['products']) {
                    $data['products'] = [
                        [
                            'type' => 'type1',
                            'code' => 'mod1',
                            'name' => 'Example Modifier 1'
                        ],
                        [
                            'type' => 'type1',
                            'code' => 'mod2',
                            'name' => 'Example Modifier 2'
                        ],
                        [
                            'type' => 'type2',
                            'code' => 'mod1',
                            'name' => 'Example Modifier 3'
                        ],
                    ];
                }
                $type = 'topping';
                break;

            default:
                # code...
                break;
        }
        return Excel::download(new ProductExport($data['products'], $data['brand'], $tab_title), date('YmdHi') . '_' . $type . '_' . $data['brand']['name_brand'] . '.xlsx');
    }

    /**
     * Import product
     */
    public function import(Request $request, $type)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $excel = \Excel::toArray(new ProductImport(), $request->file('import_file'))[0] ?? [];
            $data = [];
            $head = [];
            foreach ($excel as $key => $value) {
                if ($key === 0) {
                    $data['code_brand'] = $value[1];
                } elseif ($key == 2) {
                    $head = $value;
                } elseif ($key !== 1) {
                    $data['products'][] = array_combine($head, $value);
                }
            }
            if (!empty($data)) {
                $code_brand = '';
                $import = MyHelper::post('product/import', [
                    'id_brand' => $post['id_brand'],
                    'type' => $type,
                    'data' => $data
                ]);
                return $import;
            } else {
                return [
                    'status' => 'fail',
                    'messages' => ['File empty']
                ];
            }
        }

        return [
            'status' => 'fail',
            'messages' => ['Something went wrong']
        ];
    }

    public function example(Request $request)
    {
        $post = $request->except('_token');
        $listProduct = MyHelper::get('product/export', ['type' => $type] + $post);
        $listOutlet = MyHelper::post('outlet/be/list', ['admin' => 1, 'type' => 'export']);
        $dataPrice = [];

        if (isset($listProduct['status']) && $listProduct['status'] == 'fail') {
            $dataProduct = [];
        } elseif (!isset($listProduct['status'])) {
            return back()->witherrors(['Something went wrong']);
        } else {
            $dataProduct = $listProduct;
        }

        if (isset($listOutlet['status']) && $listOutlet['status'] == 'fail') {
            $dataOutlet = [];
        } elseif (!isset($listOutlet['status'])) {
            return back()->witherrors(['Something went wrong']);
        } else {
            $dataOutlet = $listOutlet;
        }

        if (!empty($dataOutlet)) {
            $dataOutlet = json_decode(json_encode($listOutlet['result'], JSON_NUMERIC_CHECK), true);
        }

        if (!empty($dataProduct)) {
            foreach ($listProduct['result'] as $key => $value) {
                unset($listProduct['result'][$key]['id_product']);
                unset($listProduct['result'][$key]['id_product_category']);
                unset($listProduct['result'][$key]['created_at']);
                unset($listProduct['result'][$key]['updated_at']);
                unset($listProduct['result'][$key]['product_category']);
                unset($listProduct['result'][$key]['product_discounts']);
                unset($listProduct['result'][$key]['photos']);
            }

            $dataProduct = json_decode(json_encode($listProduct['result'], JSON_NUMERIC_CHECK), true);
        } else {
            $dataProduct[] = [
                'product_code'        => null,
                'product_name'        => null,
                'product_name_pos'    => null,
                'product_description' => null,
                'product_video'       => null,
                'product_weight'      => null,
            ];

            $dataProduct = json_decode(json_encode($dataProduct, JSON_NUMERIC_CHECK), true);
            return Excel::download(new ArrayExport($dataProduct), 'product');
        }
        $excelData = [];
        // $excelData['Product']=$dataProduct;
        $excelData['Product'] = array_map(function ($x) {
            // $x['category']=$x['category']['product_category_name'];
            $x['category'] = $x['category']['id_product_category'];
            // $x['product_purchase_limitations']=$x['product_purchase_limitations']['product_purchase_limitation'];
            unset($x['product_purchase_limitations']);
            return $x;
        }, $dataProduct);
        //return $dataOutlet;
        foreach ($dataOutlet as $key => $value) {
            foreach ($value['product_prices'] as $row => $price) {
                $data = [
                    'product_code'       => $price['product']['product_code'],
                    'outlet_code'        => $value['outlet_code'],
                    'product_price'      => $price['product_price'],
                    'product_visibility' => $price['product_visibility']
                ];

                array_push($dataPrice, $data);
            }
            $outlet_name = substr($value['outlet_name'], 0, 31);
            $excelData[$outlet_name] = $dataPrice;
            $dataPrice = [];
        }
        return Excel::download(new MultisheetExport($excelData), 'products.xlsx');
    }

    public function importProductSave(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(), $request->file('import_file'));
            if (!empty($data)) {
                $import = MyHelper::post('product/import', ['data' => $data]);
            }
        }

        return parent::redirect($import, 'Product has been updated.', 'product');
    }

    /**
     * get category
     */
    public function category()
    {
        $data = [];

        $catParent = MyHelper::get('product/category/be/list');

        if (isset($catParent['status']) && $catParent['status'] == "success") {
            return $data = $catParent['result'];
        }
        return $data;
    }

    /**
     * create product
     */
    public function create(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Product',
                'sub_title'      => 'New Product',
                'menu_active'    => 'product',
                'submenu_active' => 'product-new',
            ];

            $getCategory = MyHelper::post('product/category/be/list', $request->all())['result'] ?? [];

            $data['parent'] = [];
            if (!empty($getCategory)) {
                $data['parent'] = app($this->categories)->buildTree($getCategory);
            }
            $data['outlets'] = MyHelper::get('outlet/be/list')['result'] ?? [];

            return view('product::product.create', $data);
        } else {
            if (isset($post['photo'])) {
                $post['image']      = MyHelper::encodeImage($post['photo'], $request->file('photo')->extension());
            }

            if (!empty($post['product_variant_status'])) {
                if (!empty($post['variant_color'])) {
                    $arr[] = [
                        "id_product_variant" => 0,
                        "variant_name" =>  "Color",
                        "variant_child" => []
                    ];
                }

                if (!empty($post['variant_size'])) {
                    $arr[] = [
                        "id_product_variant" => 0,
                        "variant_name" =>  "Size",
                        "variant_child" => []
                    ];
                }

                foreach ($post['variant_color'] ?? [] as $value) {
                    $arr[0]['variant_child'][] = [
                        "id_product_variant" => 0,
                        "variant_name" =>  $value
                    ];
                }

                foreach ($post['variant_size'] ?? [] as $value) {
                    $key = (isset($arr[1]) ? 1 : 0);
                    $arr[$key]['variant_child'][] = [
                        "id_product_variant" => 0,
                        "variant_name" =>  $value
                    ];
                }

                $variantPrice = $post['variant_price'];
                $resVariantPrice = [];
                $allPrice = [];
                foreach ($variantPrice as $val) {
                    $val['price'] = str_replace('.', '', $val['price']);

                    $replaceDt = str_replace('[', '', $val['data']);
                    $replaceDt = str_replace(']', '', $replaceDt);
                    $val['data'] = explode(',', $replaceDt);

                    $allPrice[] = $val['price'];
                    if (!empty($val['wholesaler_price'])) {
                        foreach ($val['wholesaler_price'] as $index => $whole) {
                            $val['wholesaler_price'][$index]['unit_price'] = str_replace('.', '', $whole['unit_price']);
                        }
                    }
                    $resVariantPrice[] = $val;
                }

                $variants = [
                    'variants' => $arr,
                    'variants_price' => $resVariantPrice
                ];

                if (!empty($arr)) {
                    $post['variant_status'] = 1;
                }

                $post['variants'] = json_encode($variants);
                $post['base_price'] = (count($allPrice) > 0 ? min($allPrice) : 0);
            }

            $post['admin'] = 1;
            $post['base_price'] = str_replace('.', '', $post['base_price']);
            $save = MyHelper::post('merchant/be/product/create', $post);

            return parent::redirect($save, 'Product has been created.');
        }
    }

    /**
     * list
     */
    public function listProduct(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-list'
        ];

        if (Session::has('filter-products') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-products');
            $post['page'] = $page;
        } else {
            Session::forget('filter-products');
        }

        $post['admin_list'] = 1;
        $post['pagination'] = true;
        $getList =  MyHelper::post('product/be/list', $post);

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

        if ($post) {
            Session::put('filter-products', $post);
        }

        $data['outlets'] = MyHelper::get('outlet/be/list')['result'] ?? [];
        $categories = $this->category();
        $resCat = [];
        foreach ($categories as $category) {
            if (!empty($category['id_parent_category']) && empty($category['category_child'])) {
                $resCat[] = $category;
            }
        }

        $data['categories'] = $resCat;
        return view('product::product.list', $data);
    }

    public function addImage(Request $request)
    {
        $post = $request->except('_token');
        if (!empty($post)) {
            $name = explode('.', $request->file('file')->getClientOriginalName())[0];
            $post = MyHelper::encodeImage($request->file('file'));
            $save = MyHelper::post('product/photo/createAjax', ['name' => $name, 'photo' => $post]);
            return $save;
        }
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-image',
            'child_active'   => 'product-image-add',
        ];
        $product = MyHelper::post('product/be/list/image', ['admin_list' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        } else {
            $data['product'] = [];
        }
        return view('product::product.image', $data);
    }

    public function addImageDetail(Request $request)
    {
        $post = $request->except('_token');
        if (!empty($post)) {
            $name = explode('.', $request->file('file')->getClientOriginalName())[0];
            $post = MyHelper::encodeImage($request->file('file'));
            $save = MyHelper::post('product/photo/createAjax', ['name' => $name, 'photo' => $post, 'detail' => 1]);
            return $save;
        }
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-image',
            'child_active'   => 'product-image-detail',
        ];
        $product = MyHelper::post('product/be/list/image', ['admin_list' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        } else {
            $data['product'] = [];
        }
        return view('product::product.image_detail', $data);
    }

    public function listImage(Request $request)
    {
        $post = $request->except('_token');
        if (!empty($post)) {
            $name = explode('.', $request->file('file')->getClientOriginalName())[0];
            $post = MyHelper::encodeImage($request->file('file'));
            $save = MyHelper::post('product/photo/createAjax', ['name' => $name, 'photo' => $post]);
            return $save;
        }
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-image',
            'child_active'   => 'product-image-list',
        ];
        $product = MyHelper::post('product/be/list/image', ['admin_list' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        } else {
            $data['product'] = [];
        }
        return view('product::product.image', $data);
    }

    public function overrideImage(Request $request)
    {
        $post = $request->except('_token');

        if (isset($post['state'])) {
            if ($post['state'] == 'true') {
                $status = 0;
            } else {
                $status = 1;
            }
            $setting = MyHelper::post('product/be/imageOverride', ['admin_list' => 1, 'status' => $status]);
            if ($setting['result'] == 'true') {
                $setting['result'] = $status;
                return $setting;
            }
        } else {
            $setting = MyHelper::post('product/be/imageOverride', ['admin_list' => 1]);
        }

        return $setting;
    }

    public function listProductAjax(Request $request)
    {
        $product = MyHelper::get('product/be/list?log_save=0');

        if (isset($product['status']) && $product['status'] == "success") {
            $data = $product['result'];
        } else {
            $data = [];
        }
        return response()->json($data);
    }

    public function listProductAjaxSimple(Request $request)
    {
        $product = MyHelper::get('product/list/ajax?log_save=0');

        if (isset($product['status']) && $product['status'] == "success") {
            $data = $product['result'];
        } else {
            $data = [];
        }
        return response()->json($data);
    }

    /**
     * detail
     */
    public function detail(Request $request, $code)
    {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'Product Detail',
            'menu_active'    => 'product',
            'submenu_active' => 'product-list',
        ];

        $product = MyHelper::post('product/be/list', ['product_code' => $code, 'outlet_prices' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        } else {
            $e = ['e' => 'Data product not found.'];
            return redirect('product')->witherrors($e);
        }

        $detail = MyHelper::post('merchant/be/product/detail', ['id_merchant' => $data['product'][0]['id_merchant'], 'id_product' => $data['product'][0]['id_product']]);

        if (isset($detail['status']) && $detail['status'] == "success") {
            $data['detail'] = $detail['result'];
        } else {
            $e = ['e' => 'Data product not found.'];
            return redirect('product')->witherrors($e);
        }
        $post = $request->except('_token');

        if (empty($post)) {
            $getCategory = MyHelper::post('product/category/be/list', $request->all())['result'] ?? [];

            $data['parent'] = [];
            if (!empty($getCategory)) {
                $data['parent'] = app($this->categories)->buildTree($getCategory);
            }
            $data['page'] = $post['page'] ?? 1;
            $data['outlet_all'] = [];

            $variants = $data['detail']['variants'] ?? [];

            $searchKeyColor = array_search('Color', array_column($variants['variants'] ?? [], 'variant_name'));
            $searchKeySize = array_search('Size', array_column($variants['variants'] ?? [], 'variant_name'));

            $data['variant_color'] = ($searchKeyColor !== false ? $variants['variants'][$searchKeyColor] : []);
            $data['variant_size'] = ($searchKeySize !== false ? $variants['variants'][$searchKeySize] : []);
            $data['array_color'] = $data['variant_color']['variant_child'] ?? [];
            $data['array_size'] = $data['variant_size']['variant_child'] ?? [];
            $data['variant_price'] = $variants['variants_price'] ?? [];
            $data['variant_use_transaction'] = $data['detail']['variant_use_transaction'] ?? null;

            return view('product::product.detail', $data);
        } else {
            if ($post['id_product_category'] == 0  || empty($post['id_product_category'])) {
                $post['id_product_category'] = null;
            }

            if (isset($post['photo'])) {
                $post['photo'] = MyHelper::encodeImage($post['photo'], $request->file('photo')->extension());
            }

            $save = MyHelper::post('product/update', $post);

            return parent::redirect($save, 'Product info has been updated.', 'product/detail/' . $post['product_code'] . '#info');
        }
    }

    public function productVarianGroup(Request $request, $product_code)
    {
        $post = $request->all();
        if (!empty($post['variant_deletes'])) {
            $delete = MyHelper::post('product-variant/delete', ['ids' => $post['variant_deletes']]);
            if (!isset($delete['status']) || (isset($delete['status']) && $delete['status'] == 'fail')) {
                return redirect('product/detail/' . $product_code . '#variant')->withErrors($create_update['messages'] ?? ['Failed delete variant, variant already use transaction']);
            }
        }

        $variantStatus = 0;
        if (!empty($post['product_variant_status'])) {
            $variantStatus = 1;
        }

        $update = MyHelper::post('product-variant/update/status', ['id_product' => $post['id_product'], 'status' => $variantStatus]);

        if (!isset($update['status']) || (isset($update['status']) && $update['status'] == 'fail')) {
            return redirect('product/detail/' . $product_code . '#variant')->withErrors($create_update['messages'] ?? ['Failed update status use variant']);
        } elseif ($variantStatus == 0 && isset($update['status']) && $update['status'] == 'success') {
            return redirect('product/detail/' . $product_code . '#variant')->with('success', ['Update Variant Status Success']);
        }

        if (!empty($post['variant_color'])) {
            $arr[] = [
                "id_product_variant" => $post['variant_color_id'] ?? 0,
                "variant_name" =>  "Color",
                "variant_child" => []
            ];
        }

        if (!empty($post['variant_size'])) {
            $arr[] = [
                "id_product_variant" => $post['variant_size_id'] ?? 0,
                "variant_name" =>  "Size",
                "variant_child" => []
            ];
        }

        foreach ($post['variant_color'] ?? [] as $value) {
            $arr[0]['variant_child'][] = [
                "id_product_variant" => $value['id'] ?? 0,
                "variant_name" =>  $value['name'] ?? $value
            ];
        }

        foreach ($post['variant_size'] ?? [] as $value) {
            $key = (isset($arr[1]) ? 1 : 0);
            $arr[$key]['variant_child'][] = [
                "id_product_variant" => $value['id'] ?? 0,
                "variant_name" =>  $value['name'] ?? $value
            ];
        }

        foreach ($post['variant_price'] as $key => $value) {
            $replace = str_replace('[', '', $value['data']);
            $replace = str_replace(']', '', $replace);
            $post['variant_price'][$key]['data'] = explode(',', $replace);
        }

        $data = [
            'id_product' => $post['id_product'],
            'id_merchant' => $post['id_merchant'],
            'variants' => $arr ?? [],
            'variants_price' => $post['variant_price'],
            'admin' => 1
        ];

        $create_update = MyHelper::post('merchant/be/product/variant/update', $data);

        if (($create_update['status'] ?? '') == 'success') {
            return redirect('product/detail/' . $product_code . '#variant')->with('success', ['Update Product Variant Success']);
        } else {
            return redirect('product/detail/' . $product_code . '#variant')->withErrors($create_update['messages'] ?? ['Something went wrong']);
        }
    }

    public function deleteProductVarianGroup(Request $request)
    {
        $post = $request->all();
        $delete = MyHelper::post('product-variant-group/delete', $post);
        return $delete;
    }
    /**
     * delete photo
     */
    public function deletePhoto(Request $request)
    {
        $post   = $request->all();

        $delete = MyHelper::post('product/photo/delete', ['id_product_photo' => $post['id_product_photo']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    /**
     * delete discount
     */
    public function deleteDiscount(Request $request)
    {
        $post   = $request->all();
        $delete = MyHelper::post('product/discount/delete', ['id_product_discount' => $post['id_product_discount']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    /**
     * update
     */
    public function update(Request $request)
    {
        $post = $request->except('_token');
        $save = MyHelper::post('product/update', $post);

        if (isset($save['status']) && $save['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    /**
     * delete product
     */
    public function delete(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('product/delete', $post);

        return $delete;
    }

    public function price(Request $request, $key = null)
    {
        $data = [
            'title'          => 'Order',
            'sub_title'      => 'Outlet Product Price',
            'menu_active'    => 'product-price',
            'submenu_active' => 'product-price',
            'filter_title'   => 'Filter Product Price',
            'product_setting_type' => 'product_price'
        ];

        $post = $request->except('_token');
        if (isset($post['clear'])) {
            session::forget('product_price_filter');
            unset($post['page']);
        }

        if ((isset($post['rule']) || isset($post['operator']) )) {
            unset($post['page']);
            session(['product_price_filter' => $post]);
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } elseif (session('product_price_filter')) {
            $filter             = session('product_price_filter');
            $data['rule']     = array_map('array_values', $filter['rule']);
            $data['operator'] = $filter['operator'];
        }

        if (isset($post['page'])) {
            $page = $post['page'];
            unset($post['page']);
        }

        if ($post && (!isset($post['rule']) || !isset($post['operator'])) && !isset($post['clear'])) {
            if (isset($post['sameall']) && !empty($post['sameall'])) {
                $dataToUpdate = [
                    'product_price'         => $post['price'][0],
                    'id_outlet'             => $post['id_outlet'],
                ];
                $updatePrice = MyHelper::post('product/prices/all-product', $dataToUpdate);

                if (isset($updatePrice['status']) && $updatePrice['status'] == 'success') {
                    return redirect('product/price/' . $key)->withSuccess(['Success update price']);
                } else {
                    return back()->witherrors([$updatePrice['messages']]);
                }
            } else {
                return $this->priceProcess($post);
            }
        }
        $data['admin'] = 1;
        $outlets = MyHelper::post('outlet/be/list', ['filter' => 'different_price'])['result'] ?? [];
        if (!$outlets) {
            $data['outlets'] = [];
        } else {
            $data['outlets'] = $outlets;
        }

        $data['pagination'] = true;
        $data['orderBy'] = 'product_name';

        if (!isset($data['product_name']) && Session::get('search_product_name')) {
            $data['product_name'] = Session::get('search_product_name');
        }

        $data['update_price'] = 1;
        $data['admin_list'] = 1;
        if (isset($page)) {
            $product = MyHelper::post('product/be/list?page=' . $page, $data);
        } else {
            $product = MyHelper::post('product/be/list', $data);
        }
        if (isset($product['status']) && $product['status'] == 'success') {
            $data['product'] = $product['result']['data'];
            $data['total'] = $product['result']['total'];
            $data['paginator'] = new LengthAwarePaginator($product['result']['data'], $product['result']['total'], $product['result']['per_page'], $product['result']['current_page'], ['path' => url()->current()]);
        } elseif (isset($product['status']) && $product['status'] == 'fail') {
            return back()->witherrors([$product['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }

        if (!is_null($key)) {
            $data['key'] = $key;
        } else {
            $data['key'] = $data['outlets'][0]['id_outlet'] ?? '';
        }

        return view('product::product.price', $data);
    }

    /* PROSES HARGA */
    public function priceProcess($post)
    {
        $price = array_filter($post['price']);
        if (!empty($price)) {
            foreach ($price as $key => $value) {
                $data = [
                    'id_product'            => $post['id_product'][$key],
                    'product_price'         => $value,
                    'id_outlet'             => $post['id_outlet'],
                ];
                $save = MyHelper::post('product/prices', $data);
                if (isset($save['status']) && $save['status'] != "success") {
                    return back()->witherrors(['Product price failed to update']);
                }
            }
        }

        return back()->with('success', ['Product price has been updated.']);
    }

    public function productOutletDetail(Request $request, $key = null)
    {
        $data = [
            'title'          => 'Order',
            'sub_title'      => 'Outlet Product Detail',
            'menu_active'    => 'product-detail',
            'submenu_active' => 'product-detail',
            'filter_title'   => 'Filter Product Detail',
            'product_setting_type' => 'outlet_product_detail'
        ];

        $post = $request->except('_token');
        if (isset($post['clear'])) {
            session::forget('product_detail_filter');
        }

        if (isset($post['page'])) {
            $page = $post['page'];
            unset($post['page']);
        }

        if ($post && (!isset($post['rule']) || !isset($post['operator'])) && !isset($post['clear'])) {
            if (isset($post['sameall']) && !empty($post['sameall'])) {
                $dataToUpdate = [
                    'product_visibility'    => $post['visible'][0],
                    'product_stock_status'  => $post['product_stock_status'][0],
                    'id_outlet'             => $post['id_outlet']
                ];
                $updatePrice = MyHelper::post('product/outlet-detail/all-product', $dataToUpdate);

                if (isset($updatePrice['status']) && $updatePrice['status'] == 'success') {
                    return redirect('product/outlet-detail/' . $key)->withSuccess(['Success update price']);
                } else {
                    return back()->witherrors([$updatePrice['messages']]);
                }
            } else {
                return $this->productOutletProcess($post);
            }
        }
        $data['admin'] = 1;
        $outlet = MyHelper::post('outlet/be/list', $data);

        if (isset($outlet['status']) && $outlet['status'] == 'success') {
            $data['outlets'] = $outlet['result'];
        } elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
            return back()->witherrors([$outlet['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }

        $data['pagination'] = true;
        $data['orderBy'] = 'product_name';

        if (session('product_detail_filter')) {
            $filter             = session('product_detail_filter');
            $data['rule']     = array_map('array_values', $filter['rule']);
            $data['operator'] = $filter['operator'];
        } else {
            if ((isset($post['rule']) || isset($post['operator']) )) {
                session(['product_detail_filter' => $post]);
                $data['rule']     = array_map('array_values', $post['rule']);
                $data['operator'] = $post['operator'];
            }
        }

        if (isset($page)) {
            $product = MyHelper::post('product/be/list?page=' . $page, $data);
        } else {
            $product = MyHelper::post('product/be/list', $data);
        }
        if (isset($product['status']) && $product['status'] == 'success') {
            $data['product'] = $product['result']['data'];
            $data['total'] = $product['result']['total'];
            $data['paginator'] = new LengthAwarePaginator($product['result']['data'], $product['result']['total'], $product['result']['per_page'], $product['result']['current_page'], ['path' => url()->current()]);
        } elseif (isset($product['status']) && $product['status'] == 'fail') {
            return back()->witherrors([$product['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }

        if (!is_null($key)) {
            $data['key'] = $key;
        } else {
            $data['key'] = $data['outlets'][0]['id_outlet'];
        }

        return view('product::product.outlet-product-detail', $data);
    }


    public function productOutletProcess($post)
    {
        if (!empty($post['visible'])) {
            foreach ($post['visible'] as $key => $value) {
                $data = [
                    'id_product'            => $post['id_product'][$key],
                    'product_visibility'    => $post['visible'][$key],
                    'product_stock_status'  => $post['product_stock_status'][$key],
                    'id_outlet'             => $post['id_outlet'],
                ];
                $save = MyHelper::post('product/outlet-detail', $data);
                if (isset($save['status']) && $save['status'] != "success") {
                    return back()->witherrors(['Product price failed to update']);
                }
            }
        }

        return back()->with('success', ['Product price has been updated.']);
    }

    public function updateAllowSync(Request $request)
    {
        $post = $request->except('_token');
        $update = MyHelper::post('product/update/allow_sync', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success'];
        } elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $update['messages']];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update product allow sync'];
        }
    }

    public function updateVisibility(Request $request)
    {
        $post = $request->except('_token');
        $update = MyHelper::post('product/update/visibility/global', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success'];
        } elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $update['messages']];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update product visibility'];
        }
    }

    public function visibility(Request $request, $key = null)
    {
        $visibility = strpos(url()->current(), 'visible');
        if ($visibility <= 0) {
            $visibility = 'Hidden';
        } else {
            $visibility = 'Visible';
        }
        $data = [
            'title'          => 'Product',
            'sub_title'      => $visibility . ' Product List',
            'menu_active'    => 'product',
            'submenu_active' => 'product-list-' . lcfirst($visibility),
            'visibility'     => $visibility
        ];

        $post = $request->except('_token');

        if ($key == null && empty($post)) {
            Session::forget('idVisibility');
            Session::forget('idVisibility_allOutlet');
            Session::forget('idVisibility_allProduct');
        }

        if (isset($post['page'])) {
            $page = $post['page'];
            unset($post['page']);
        } else {
            $page = null;
        }

        // Proses update visibility
        if ($post) {
            $ses = Session::get('idVisibility');
            if ($ses) {
                if (!$page) {
                    $page = 1;
                }
                foreach ($ses as $key => $value1) {
                    foreach ($value1 as $i => $value2) {
                        foreach ($value2 as $j => $value) {
                            if ($key == (int)$post['key'] && $i == (int)$page) {
                            } else {
                                $post['id_visibility'][] = $value;
                            }
                        }
                    }
                }
            };
            if ($visibility == 'Hidden') {
                $post['visibility'] = 'Visible';
            } else {
                $post['visibility'] = 'Hidden';
            }
            $save = MyHelper::post('product/update/visibility', $post);
            Session::forget('idVisibility');
            Session::forget('idVisibility_allOutlet');
            Session::forget('idVisibility_allProduct');
            if (isset($save['status']) && $save['status'] == "success") {
                return parent::redirect($save, 'Product visibility has been updated.', 'product/' . strtolower($visibility) . '/' . $post['key']);
            } else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }

        $outlet = MyHelper::get('outlet/be/list');
        if (isset($outlet['status']) && $outlet['status'] == 'success') {
            $data['outlet'] = $outlet['result'];
        } elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
            return back()->witherrors([$outlet['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }

        if (!is_null($key)) {
            $data['key'] = $key;
        } else {
            $data['key'] = $data['outlet'][0]['id_outlet'];
        }

        if ($page) {
            $product = MyHelper::post('product/be/list?page=' . $page, ['visibility' => $visibility, 'id_outlet' => $data['key'], 'pagination' => true]);
            $data['page'] = $page;
        } else {
            $product = MyHelper::post('product/be/list', ['visibility' => $visibility, 'id_outlet' => $data['key'], 'pagination' => true]);
            $data['page'] = 1;
        }
        // dd($product);
        if (Session::get('idVisibility')) {
            $ses = Session::get('idVisibility');
            if (isset($ses[$data['key']]) && isset($ses[$data['key']][$data['page']])) {
                $data['id_visibility'] = $ses[$data['key']][$data['page']];
            } else {
                $data['id_visibility'] = [];
            }
        } else {
            $data['id_visibility'] = [];
        }

        if (!empty(Session::get('idVisibility_allOutlet'))) {
            $data['allOutlet'] = Session::get('idVisibility_allOutlet');
        }

        if (!empty(Session::get('idVisibility_allProduct'))) {
            $ses = Session::get('idVisibility_allProduct');
            if (isset($ses[$data['key']])) {
                $data['allProduct'] = $ses[$data['key']];
            }
        }

        if (isset($product['status']) && $product['status'] == 'success') {
            $data['paginator'] = new LengthAwarePaginator($product['result']['data'], $product['result']['total'], $product['result']['per_page'], $product['result']['current_page'], ['path' => url()->current()]);
            $data['product'] = $product['result']['data'];
            $data['total'] = $product['result']['total'];
        } elseif (isset($product['status']) && $product['status'] == 'fail') {
            return back()->witherrors([$product['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }
        return view('product::product.visibility', $data);
    }

    // menyimpan id_product & id_outlet yang di select ke session
    public function addIdVisibility(Request $request)
    {
        $post = $request->except('_token');
        $idVisibility = Session::get('idVisibility');
        $ses_allProduct = Session::get('idVisibility_allProduct');
        $countProduct = 0;

        if ($post['checked'] == "true") {
            // select all product in all outlet
            if (isset($post['allOutlet'])) {
                Session::put('idVisibility_allOutlet', true);
                $outlet = MyHelper::get('outlet/be/list');
                if (isset($outlet['status']) && $outlet['status'] == 'success') {
                    foreach ($outlet['result'] as $o => $dataOutlet) {
                        $ses_allProduct[$dataOutlet['id_outlet']] = true;
                        $product = MyHelper::post('product/be/list', ['visibility' => $post['visibility'], 'id_outlet' => $dataOutlet['id_outlet']]);
                        if (isset($product['status']) && $product['status'] == 'success') {
                            $page = 1;
                            $i = 1;
                            $idVisibility[$dataOutlet['id_outlet']][$page] = [];
                            foreach ($product['result'] as $key => $value) {
                                $idVisibility[$dataOutlet['id_outlet']][$page][] = $value['id_product'] . '/' . $dataOutlet['id_outlet'];
                                if ($i % 10 == 0) {
                                    $page++;
                                }
                                $i++;
                                $countProduct++;
                            }
                        }
                    }
                }
            } elseif (isset($post['allProduct'])) {
                // select all product in 1 outlet
                $ses_allProduct[$post['key']] = true;
                Session::put('idVisibility_allProduct', $ses_allProduct);
                $product = MyHelper::post('product/be/list', ['visibility' => $post['visibility'], 'id_outlet' => $post['key']]);
                if (isset($product['status']) && $product['status'] == 'success') {
                    $page = 1;
                    $i = 1;
                    $idVisibility[$post['key']][$page] = [];
                    foreach ($product['result'] as $key => $value) {
                        $idVisibility[$post['key']][$page][] = $value['id_product'] . '/' . $post['key'];
                        if ($i % 10 == 0) {
                            $page++;
                        }
                        $i++;
                        $countProduct++;
                    }
                }
            } else {
                $idVisibility[$post['key']][$post['page']] = explode(',', $post['id_visibility']);
            }
        } else {
            // for uncheck
            if (isset($post['allOutlet'])) {
                $idVisibility = null;
                Session::forget('idVisibility');
                Session::forget('idVisibility_allOutlet');
                Session::forget('idVisibility_allProduct');
            } elseif (isset($post['allProduct'])) {
                unset($idVisibility[$post['key']]);
                unset($ses_allProduct[$post['key']]);
                Session::forget('idVisibility_allOutlet');
            }
        }
        Session::put('idVisibility_allProduct', $ses_allProduct);
        Session::put('idVisibility', $idVisibility);
        return Session::get('idVisibility');
    }

    public function photoDefault(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Product',
                'sub_title'      => 'Photo Default',
                'menu_active'    => 'product',
                'submenu_active' => 'product-photo-default',
            ];

            $data['photo'] = env('STORAGE_URL_API') . 'img/product/item/default.png?';
            $data['photo_detail'] = env('STORAGE_URL_API') . 'img/product/item/detail/default.png?';

            return view('product::product.photo-default', $data);
        } else {
            if (isset($post['photo'])) {
                $post['photo'] = MyHelper::encodeImage($post['photo']);
            }
            if (isset($post['photo_detail'])) {
                $post['photo_detail'] = MyHelper::encodeImage($post['photo_detail']);
            }
            $default = MyHelper::post('product/photo/default', $post);
            if (isset($default['status']) && $default['status'] == 'success') {
                return parent::redirect($default, 'Product Photo Default has been updated.', 'product/photo/default');
            } elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
                return back()->witherrors([$outlet['messages']]);
            } else {
                return back()->witherrors(['Product Not Found']);
            }
        }
    }

    public function updateVisibilityProduct(Request $request)
    {
        $post = $request->except('_token');
        $post['id_visibility'] = explode(',', $post['id_visibility']);
        $save = MyHelper::post('product/update/visibility', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            $data = ['status' => 'success'];
        } else {
            $data = ['status' => 'fail'];
            if (isset($save['messages'])) {
                $data['messages'] = $save['messages'];
            }
        }
        return response()->json($data);
    }

    public function ajaxProductBrand(Request $request)
    {
        $post = $request->except('_token');
        $product = MyHelper::post('product/ajax-product-brand', $post);
        return $product;
    }

    public function productRecommendation(Request $request)
    {
        $post = $request->except('_token');

        $data = [
            'title'          => 'Product',
            'sub_title'      => 'Product Recommendation',
            'menu_active'    => 'product',
            'submenu_active' => 'product-recommendation',
        ];

        if (empty($post)) {
            $data['products'] = MyHelper::post('product/be/list', ['admin_list' => 1, 'check_status' => 1])['result'] ?? [];
            return view('product::product.product_recommendation', $data);
        } else {
            $save = MyHelper::post('product/recommendation/save', $post);
            if (isset($save['status']) && $save['status'] == 'success') {
                return parent::redirect($save, 'Product recommendation success save.', 'product/recommendation');
            } else {
                return back()->witherrors($save['messages'] ?? ['Something went wrong']);
            }
        }
    }

    public function variantCombination(Request $request)
    {
        $post = $request->all();

        if (!empty($post['array_color'])) {
            $arr[] = [
                "id_product_variant" => $post['id_variant_color'] ?? 0,
                "variant_name" =>  "Color",
                "variant_child" => []
            ];
        }

        if (!empty($post['array_size'])) {
            $arr[] = [
                "id_product_variant" => $post['id_variant_size'] ?? 0,
                "variant_name" =>  "Size",
                "variant_child" => []
            ];
        }

        foreach ($post['array_color'] ?? [] as $value) {
            $arr[0]['variant_child'][] = [
                "id_product_variant" => $value['id_product_variant'] ?? 0,
                "variant_name" =>  $value['variant_name'] ?? $value
            ];
        }

        foreach ($post['array_size'] ?? [] as $value) {
            $key = (isset($arr[1]) ? 1 : 0);
            $arr[$key]['variant_child'][] = [
                "id_product_variant" => $value['id_product_variant'] ?? 0,
                "variant_name" =>  $value['variant_name'] ?? $value
            ];
        }

        $combination = MyHelper::post('merchant/be/product/variant/create-combination', $arr);

        return $combination;
    }
}
