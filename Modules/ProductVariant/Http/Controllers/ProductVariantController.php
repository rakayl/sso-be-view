<?php

namespace Modules\ProductVariant\Http\Controllers;

use App\Exports\MultisheetExport;
use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Excel;
use App\Imports\FirstSheetOnlyImport;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Variant',
            'sub_title'      => 'Variant List',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-list',
        ];

        $data['get_variant'] = MyHelper::post('product-variant', $request->all())['result'] ?? [];

        $data['variants'] = json_encode([]);
        if (!empty($data['get_variant'])) {
            $data['variants'] = json_encode($this->buildTree($data['get_variant']));
        }
        return view('productvariant::index', $data);
    }

    public function position(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Variant',
            'sub_title'      => 'Variant Position',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-position',
        ];

        if (empty($post)) {
            $data['get_variant'] = MyHelper::post('product-variant', $request->all())['result'] ?? [];

            $data['variants'] = json_encode([]);
            if (!empty($data['get_variant'])) {
                $data['variants'] = json_encode($this->buildTree($data['get_variant']));
            }
            return view('productvariant::position', $data);
        } else {
            $update_potition = MyHelper::post('product-variant/position', $post);

            if (($update_potition['status'] ?? '') == 'success') {
                return redirect('product-variant/position')->with('success', ['Update position success']);
            } else {
                return redirect('product-variant/position')->withErrors($update_potition['messages'] ?? ['Something went wrong']);
            }
        }
    }

    public function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['id_parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['id_product_variant']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Variant',
            'sub_title'      => 'New Variant',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-new',
        ];
        return view('productvariant::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $store = MyHelper::post('product-variant/store', $post);

        if (($store['status'] ?? '') == 'success') {
            return redirect('product-variant')->with('success', ['Create Variant Success']);
        } else {
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('productvariant::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'title'          => 'Variant',
            'sub_title'      => 'Update Variant',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant',
        ];

        $post['id_product_variant'] = $id;
        $get_data = MyHelper::post('product-variant/edit', $post);

        $data['all_parent'] = [];
        $data['product_variant'] = [];
        if (($get_data['status'] ?? '') == 'success') {
            $data['all_parent'] = $get_data['result']['all_parent'];
            $data['product_variant'] = $get_data['result']['product_variant'];
        }

        return view('productvariant::edit', $data);
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
        $post['id_product_variant'] = $id;


        if (isset($post['product_variant_visibility'])) {
            $post['product_variant_visibility'] = 'Visible';
        } else {
            $post['product_variant_visibility'] = 'Hidden';
        }

        $update = MyHelper::post('product-variant/update', $post);

        if (($update['status'] ?? '') == 'success') {
            return redirect('product-variant/edit/' . $id)->with('success', ['Updated Variant Success']);
        } else {
            return back()->withInput()->withErrors($update['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::post('product-variant/delete', ['id_product_variant' => $id]);
        return $result;
    }

    public function export(Request $request)
    {
        $post = $request->except('_token');
        $data = MyHelper::post('product-variant', [])['result'] ?? [];
        $tab_title = 'List Variant';

        if (empty($data)) {
            $datas['All Type'] = [
                [
                    'product_variant_name' => 'Size',
                    'product_variant_child' => 'S,M,L,XL'
                ],
                [
                    'product_variant_name' => 'Type',
                    'product_variant_child' => 'Hot,Ice'
                ]
            ];
        } else {
            $arr = [];
            foreach ($data as $dt) {
                $child = array_column($dt['product_variant_child'], 'product_variant_name');
                if (!empty($dt['product_variant_child'])) {
                    $arr[] = [
                        'product_variant_name' => $dt['product_variant_name'],
                        'product_variant_child' => implode(",", $child)
                    ];
                }
            }
            $datas['All Type'] = $arr;
        }
        return Excel::download(new MultisheetExport($datas), date('YmdHi') . '_variant.xlsx');
    }

    public function import()
    {
        $data = [
            'title'          => 'Variant',
            'sub_title'      => 'Import Variant',
            'menu_active'    => 'product-variant',
            'submenu_active' => 'product-variant-import-global'
        ];

        return view('productvariant::import', $data);
    }

    public function importSave(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(), $request->file('import_file'));
            if (!empty($data)) {
                $import = MyHelper::post('product-variant/import', ['data' => $data]);
            }
        }

        return $import;
    }
}
