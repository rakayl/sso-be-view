<?php

namespace Modules\Quest\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class QuestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Quest',
            'sub_title'      => 'Quest List',
            'menu_active'    => 'quest',
            'submenu_active' => 'quest-list',
            'filter_title'   => 'Filter Quest',
            // 'filter_date'    => true
        ];
        $post = $request->all();

        if (session('list_quest_filter')) {
            $extra = session('list_quest_filter');
            $data['rule'] = array_map('array_values', $extra['rule']);
            $data['operator'] = $extra['operator'];
        } else {
            $extra = [
                'rule' => [],
                'operator' => ''
            ];
            $data['rule'] = array_map('array_values', $extra['rule']);
            $data['operator'] = $extra['operator'];
            $data['hide_record_total'] = 1;
        }

        $dateRange = [];
        foreach ($data['rule'] ?? [] as $rule) {
            if ($rule[0] == 'transaction_date') {
                if ($rule[1] == '<=') {
                    $dateRange[0] = $rule[2];
                } elseif ($rule[1] == '>=') {
                    $dateRange[1] = $rule[2];
                }
            }
        }

        if (count($dateRange) == 2 && $dateRange[0] == $dateRange[1] && $dateRange[0] == date('Y-m-d')) {
            $is_today = true;
        }

        if ($request->wantsJson()) {
            // return \MyHelper::apiPost('franchise/report-transaction/product', $extra + $request->all());
            $data = MyHelper::post('quest', $extra + $post)['result'] ?? [];
            $data['recordsFiltered'] = $data['total'] ?? 0;
            $data['recordsTotal'] = $data['total'] ?? 0;
            $data['draw'] = $request->draw;

            return $data;
        }

        $data['deals'] = MyHelper::get('quest/list-quest-voucher')['result'] ?? [];
        return view('quest::index', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function filter(Request $request)
    {
        $post = $request->all();

        if (($post['rule'] ?? false) && !isset($post['draw'])) {
            if (($post['filter_type'] ?? false) == 'today') {
                $post['rule'][9998] = [
                    'subject' => 'transaction_date',
                    'operator' => '>=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
                $post['rule'][9999] = [
                    'subject' => 'transaction_date',
                    'operator' => '<=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
            }
            session(['list_quest_filter' => $post]);
            return back();
        }

        if ($post['clear'] ?? false) {
            session(['list_quest_filter' => null]);
            return back();
        }

        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $data = [
            'title'          => 'Quest',
            'sub_title'      => 'Quest Create',
            'menu_active'    => 'quest',
            'submenu_active' => 'quest-create'
        ];

        $data['category']   = MyHelper::get('product/category/be/list')['result'];
        $data['product']    = MyHelper::get('quest/list-product')['result'];
        $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
        $data['province']   = MyHelper::get('province/list')['result'];
        $data['deals']      = MyHelper::get('quest/list-quest-voucher')['result'] ?? [];
        $data['outlet_group_filters'] = MyHelper::get('outlet/group-filter')['result'] ?? [];
        $data['details']     = (old('detail') ?? false) ?: [[]];

        $data['product_variant_groups'] = [];
        foreach ($data['product'] as $product) {
            $data['product_variant_groups'][$product['id_product']] = $product['product_variant_group'];
        }
        $data['product_variant_groups'] = array_filter($data['product_variant_groups']);

        return view('quest::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');

        if (isset($post['id_quest'])) {
            foreach ($post['detail'] as $key => $value) {
                if ($post['detail'][$key]['logo_badge'] ?? false) {
                    $post['detail'][$key]['logo_badge'] = MyHelper::encodeImage($value['logo_badge']);
                }
                unset($post['detail'][$key]['rule_total']);
                unset($post['detail'][$key]['value_total']);
            }

            $save = MyHelper::post('quest/create-detail', $post);

            if (isset($save['status']) && $save['status'] == "success") {
                return back()->withSuccess(['Success add quest']);
            } else {
                return back()->with('error', $save['errors'])->withInput();
            }
        } else {
            $post['quest']['image'] = MyHelper::encodeImage($post['quest']['image']);

            if (isset($post['detail'])) {
                foreach ($post['detail'] as $key => $value) {
                    if ($post['detail'][$key]['logo_badge'] ?? false) {
                        $post['detail'][$key]['logo_badge'] = MyHelper::encodeImage($value['logo_badge']);
                    }
                    unset($post['detail'][$key]['rule_total']);
                    unset($post['detail'][$key]['value_total']);
                }
            }

            $save = MyHelper::post('quest/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('quest/detail/' . $save['data'] . '#content');
            } else {
                return back()->withErrors($save['messages'] ?? $save['errors'] ?? ['Something went wrong'])->withInput();
            }
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
            'title'          => 'Quest',
            'sub_title'      => 'Quest Detail',
            'menu_active'    => 'quest',
            'submenu_active' => 'quest-list'
        ];

        $getDetail = MyHelper::post('quest/detail', ['id_quest' => $id]);
        if (isset($getDetail['status']) && $getDetail['status'] == "success") {
            $data['data']       = $getDetail['data'];
            $data['category']   = MyHelper::get('product/category/be/list')['result'];
            $data['product']    = MyHelper::get('quest/list-product')['result'];
            $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
            $data['province']   = MyHelper::get('province/list')['result'];
            $data['deals']      = MyHelper::get('quest/list-quest-voucher')['result'] ?? [];
            $data['outlet_group_filters'] = MyHelper::get('outlet/group-filter')['result'] ?? [];

            $data['product_variant_groups'] = [];
            foreach ($data['product'] as $product) {
                $data['product_variant_groups'][$product['id_product']] = $product['product_variant_group'];
            }
            $data['product_variant_groups'] = array_filter($data['product_variant_groups']);

            return view('quest::detail', $data);
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('quest::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $post = $request->except('_token');

        $update = MyHelper::post('quest/detail/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return back()->withSuccess(['Success update detail']);
        } else {
            return back()->with('error', $update['errors'])->withInput();
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
        $result = MyHelper::post('quest/destroy', $post);
        return $result;
    }

    public function updateContent(Request $request, $slug)
    {
        $post = $request->all();
        $result = MyHelper::post('quest/update-content', $post + ['id_quest' => $slug]);
        if (($result['status'] ?? false) == 'success') {
            return redirect('quest/detail/' . $slug . '#content')->withSuccess(['Update Success']);
        }
        return redirect('quest/detail/' . $slug . '#content')->withErrors($result['messages'] ?? ['Something went wrong']);
    }

    public function updateQuest(Request $request, $slug)
    {
        $post = $request->all();
        if ($post['quest']['image'] ?? false) {
            $post['quest']['image'] = MyHelper::encodeImage($post['quest']['image']);
        }
        if ($post['quest']['publish_start'] ?? false) {
            $post['quest']['publish_start'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '', $post['quest']['publish_start'])));
        }
        if ($post['quest']['publish_end'] ?? false) {
            $post['quest']['publish_end'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '', $post['quest']['publish_end'])));
        }
        if ($post['quest']['date_start'] ?? false) {
            $post['quest']['date_start'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '', $post['quest']['date_start'])));
        }
        if ($post['quest']['date_end'] ?? false) {
            $post['quest']['date_end'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '', $post['quest']['date_end'])));
        }

        if ($post['quest']['user_rule_type'] == 'all') {
            $post['quest']['user_rule_subject'] = null;
            $post['quest']['user_rule_operator'] = null;
            $post['quest']['user_rule_parameter'] = null;
        }

        $result = MyHelper::post('quest/update-quest', $post + ['id_quest' => $slug]);
        if (($result['status'] ?? false) == 'success') {
            return redirect('quest/detail/' . $slug)->withSuccess(['Update Success']);
        }
        return redirect('quest/detail/' . $slug)->withErrors($result['messages'] ?? ['Something went wrong']);
    }

    public function updateBenefit(Request $request, $slug)
    {
        $post = $request->all();
        $result = MyHelper::post('quest/update-benefit', $post + ['id_quest' => $slug]);
        if (($result['status'] ?? false) == 'success') {
            return redirect('quest/detail/' . $slug)->withSuccess(['Update Success']);
        }
        return redirect('quest/detail/' . $slug)->withErrors($result['messages'] ?? ['Something went wrong']);
    }

    public function start(Request $request, $slug)
    {
        $result = MyHelper::post('quest/start', ['id_quest' => $slug]);
        if (($result['status'] ?? false) == 'success') {
            return redirect('quest/detail/' . $slug)->withSuccess(['Quest Started']);
        }
        return redirect('quest/detail/' . $slug)->withErrors($result['messages'] ?? ['Something went wrong']);
    }

    public function reclaim(Request $request, $slug)
    {
        $result = MyHelper::post('quest/trigger-manual-autoclaim', ['id_quest' => $slug]);
        if (($result['status'] ?? false) == 'success') {
            return redirect('quest/detail/' . $slug)->withSuccess($result['messages'] ?? ['Success']);
        }
        return redirect('quest/detail/' . $slug)->withErrors($result['messages'] ?? ['Something went wrong']);
    }
}
