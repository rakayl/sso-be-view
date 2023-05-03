<?php

namespace Modules\PointInjection\Http\Controllers;

use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Excel;

class PointInjectionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $page = 1)
    {
        $data = [
            'title'             => 'Point Injection List',
            'menu_active'       => 'point-injection',
            'submenu_active'    => 'point-injection-list'
        ];

        if ($request->post('clear') == 'session') {
            session(['point_injection_filter' => '']);
        }

        $post = $request->except(['_token']);
        $this->sessionMixer($request, $post);

        if (!isset($post['order_field'])) {
            $post['order_field'] = 'id_point_injection';
        }
        if (!isset($post['order_method'])) {
            $post['order_method'] = 'desc';
        }
        if (!isset($post['take'])) {
            $post['take'] = 10;
        }
        $post['skip'] = 0 + (($page - 1) * $post['take']);

        $getPointInjection = MyHelper::post('point-injection/list', $post);

        if (isset($getPointInjection['status']) && $getPointInjection['status'] == 'success') {
            $data['content'] = $getPointInjection['result'];
        } else {
            $data['content'] = null;
        }

        if ($getPointInjection['status'] == 'success') {
            $data['count'] = $getPointInjection['count'];
        } else {
            $data['count'] = null;
        }

        $data['begin'] = $post['skip'] + 1;
        $data['last'] = $post['take'] + $post['skip'];
        if ($data['count'] <= $data['last']) {
            $data['last'] = $data['count'];
        }
        $data['page'] = $page;
        if ($data['content']) {
            $data['jumlah'] = count($data['content']);
        } else {
            $data['jumlah'] = 0;
        }
        foreach ($post as $key => $row) {
            $data[$key] = $row;
        }

        $data['order_field'] = implode(' ', explode('_', $data['order_field']));

        $data['table_title'] = "Point Injection list order by " . $data['order_field'] . ", " . $data['order_method'] . "ending (" . $data['begin'] . " to " . $data['last'] . " From " . $data['count'] . " data)";

        $getOutlet = MyHelper::get('outlet/list?log_save=0');
        if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') {
            $data['outlets'] = $getOutlet['result'];
        } else {
            $data['outlets'] = [];
        }

        $getProduct = MyHelper::get('product/list?log_save=0');
        if (isset($getProduct['status']) && $getProduct['status'] == 'success') {
            $data['products'] = $getProduct['result'];
        } else {
            $data['products'] = [];
        }

        $getCategory = MyHelper::get('product/category/all?log_save=0');
        if (isset($getCategory['status']) && $getCategory['status'] == 'success') {
            $data['categories'] = $getCategory['result'];
        } else {
            $data['categories'] = [];
        }

        if (isset($data['rule'])) {
            $filter = array_map(function ($x) {
                return [$x['subject'], $x['operator'] ?? '', $x['parameter']];
            }, $data['rule']);
            $data['rule'] = $filter;
        }
        $data['products'] = array_map(function ($x) {
            return [$x['id_product'], $x['product_name']];
        }, $data['products']);
        array_unshift($data['products'], ['0', 'All Products']);
        $data['outlets'] = array_map(function ($x) {
            return [$x['id_outlet'], $x['outlet_name']];
        }, $data['outlets']);
        array_unshift($data['outlets'], ['0', 'All Outlets']);

        return view('pointinjection::index', $data);
    }

    public function sessionMixer($request, &$post)
    {
        $session = session('promo_campaign_filter');
        $session = is_array($session) ? $session : array();
        $post = array_merge($session, $post);
        session(['promo_campaign_filter' => $post]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'             => 'Point Injection',
            'menu_active'       => 'point-injection',
            'submenu_active'    => 'point-injection-create'
        ];

        $getCity = MyHelper::get('city/list?log_save=0');
        if ($getCity['status'] == 'success') {
            $data['city'] = $getCity['result'];
        } else {
            $data['city'] = [];
        }

        $getProvince = MyHelper::get('province/list?log_save=0');
        if ($getProvince['status'] == 'success') {
            $data['province'] = $getProvince['result'];
        } else {
            $data['province'] = [];
        }

        $getCourier = MyHelper::get('courier/list?log_save=0');
        if ($getCourier['status'] == 'success') {
            $data['couriers'] = $getCourier['result'];
        } else {
            $data['couriers'] = [];
        }

        $getOutlet = MyHelper::get('outlet/list?log_save=0');
        if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') {
            $data['outlets'] = $getOutlet['result'];
        } else {
            $data['outlets'] = [];
        }

        $getProduct = MyHelper::get('product/list?log_save=0');
        if (isset($getProduct['status']) && $getProduct['status'] == 'success') {
            $data['products'] = $getProduct['result'];
        } else {
            $data['products'] = [];
        }

        $getTag = MyHelper::get('product/tag/list?log_save=0');
        if (isset($getTag['status']) && $getTag['status'] == 'success') {
            $data['tags'] = $getTag['result'];
        } else {
            $data['tags'] = [];
        }

        $getMembership = MyHelper::post('membership/list?log_save=0', []);
        if (isset($getMembership['status']) && $getMembership['status'] == 'success') {
            $data['memberships'] = $getMembership['result'];
        } else {
            $data['memberships'] = [];
        }

        $data['deals'] = MyHelper::post('deals/list-all', ['deals_type' => 'Deals'])['result'] ?? [];
        $data['quest'] = MyHelper::get('quest/list-all')['result'] ?? [];
        $data['subscription'] = MyHelper::post('subscription/list-all', ['subscription_type' => 'Subscription'])['result'] ?? [];

        $getApiKey = MyHelper::get('setting/whatsapp?log_save=0');
        if (isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']) {
            $data['api_key_whatsapp'] = $getApiKey['result']['value'];
        } else {
            $data['api_key_whatsapp'] = null;
        }

        $getTextReplace = MyHelper::get('autocrm/textreplace?log_save=0');
        if ($getTextReplace['status'] == 'success') {
            $data['textreplaces'] = $getTextReplace['result'];
        }

        return view('pointinjection::create-step-1', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except(array('_token'));

        if ($post['list_user'] == "Upload CSV") {
            $path = $post['import_file']->getRealPath();
            $file = file($path);
            foreach ($file as $key => $value) {
                $deleteJunk[$key] = explode("\r\n", $value)[0];
            }
            foreach ($deleteJunk as $key => $value) {
                $file[$key] = str_split($value);
                if (str_split($value)[0] != '0') {
                    $file[$key] = '0' . $value;
                } else {
                    $file[$key] = $value;
                }
            }
            $post['phone_number'] = array_slice($file, 1);
            unset($post['import_file']);
            unset($post['filter_phone']);
        } elseif ($post['list_user'] == "Filter Phone") {
            $post['phone_number'] = explode(',', $post['filter_phone']);
            unset($post['filter_phone']);
        }

        if (isset($post['point_injection_push_image']) && $post['point_injection_push_image'] != null) {
            $post['point_injection_push_image'] = MyHelper::encodeImage($post['point_injection_push_image']);
        }

        if (isset($post['phone_number'])) {
            $post['phone_number'] = array_unique($post['phone_number']);
        }

        $action = MyHelper::post('point-injection/create', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            return redirect('point-injection/review/' . $action['result']['id_point_injection']);
        } else {
            return back()->withInput()->withErrors($action['message']);
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function review(Request $request, $id_point_injection, $page = 1)
    {
        $data = [
            'title'             => 'Point Injection',
            'menu_active'       => 'point-injection',
            'submenu_active'    => 'point-injection-create'
        ];

        $post = $request->except(['_token']);

        $post['id_field'] = $id_point_injection;
        $post['order_method'] = 'desc';
        $post['take'] = 5;
        $post['skip'] = 0 + (($page - 1) * $post['take']);

        $action = MyHelper::post('point-injection/review', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['content'] = $action['result']['point_injection_users'];
        } else {
            $data['content'] = null;
        }

        if ($action['status'] == 'success') {
            $data['count'] = $action['count'];
        } else {
            $data['count'] = null;
        }

        $data['begin'] = $post['skip'] + 1;
        $data['last'] = $post['take'] + $post['skip'];
        if ($data['count'] <= $data['last']) {
            $data['last'] = $data['count'];
        }
        $data['page'] = $page;
        if ($data['content']) {
            $data['jumlah'] = count($data['content']);
        } else {
            $data['jumlah'] = 0;
        }
        foreach ($post as $key => $row) {
            $data[$key] = $row;
        }

        $data['result'] = $action['result'];

        $getTextReplace = MyHelper::get('autocrm/textreplace?log_save=0');
        if ($getTextReplace['status'] == 'success') {
            $data['textreplaces'] = $getTextReplace['result'];
        }

        return view('pointinjection::create-step-2', $data);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Request $request, $id_point_injection, $page = 1)
    {
        $data = [
            'title'             => 'Point Injection',
            'menu_active'       => 'point-injection',
            'submenu_active'    => 'point-injection-create'
        ];

        $post = $request->except(['_token']);

        $post['id_field'] = $id_point_injection;
        $post['order_method'] = 'desc';
        $post['take'] = 5;
        $post['skip'] = 0 + (($page - 1) * $post['take']);

        $action = MyHelper::post('point-injection/review', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['content'] = $action['result']['point_injection_users'];
        } else {
            $data['content'] = null;
        }

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['count'] = $action['count'];
        } else {
            $data['count'] = null;
        }

        $data['begin'] = $post['skip'] + 1;
        $data['last'] = $post['take'] + $post['skip'];
        if ($data['count'] <= $data['last']) {
            $data['last'] = $data['count'];
        }
        $data['page'] = $page;
        if ($data['content']) {
            $data['jumlah'] = count($data['content']);
        } else {
            $data['jumlah'] = 0;
        }
        foreach ($post as $key => $row) {
            $data[$key] = $row;
        }

        $data['result'] = $action['result'];

        $getCity = MyHelper::get('city/list?log_save=0');
        if ($getCity['status'] == 'success') {
            $data['city'] = $getCity['result'];
        } else {
            $data['city'] = [];
        }

        $data['deals'] = MyHelper::post('deals/list-all', ['deals_type' => 'Deals'])['result'] ?? [];
        $data['quest'] = MyHelper::get('quest/list-all')['result'] ?? [];
        $data['subscription'] = MyHelper::post('subscription/list-all', ['subscription_type' => 'Subscription'])['result'] ?? [];

        $getProvince = MyHelper::get('province/list?log_save=0');
        if ($getProvince['status'] == 'success') {
            $data['province'] = $getProvince['result'];
        } else {
            $data['province'] = [];
        }

        $getCourier = MyHelper::get('courier/list?log_save=0');
        if ($getCourier['status'] == 'success') {
            $data['couriers'] = $getCourier['result'];
        } else {
            $data['couriers'] = [];
        }

        $getOutlet = MyHelper::get('outlet/list?log_save=0');
        if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') {
            $data['outlets'] = $getOutlet['result'];
        } else {
            $data['outlets'] = [];
        }

        $getProduct = MyHelper::get('product/list?log_save=0');
        if (isset($getProduct['status']) && $getProduct['status'] == 'success') {
            $data['products'] = $getProduct['result'];
        } else {
            $data['products'] = [];
        }

        $getTag = MyHelper::get('product/tag/list?log_save=0');
        if (isset($getTag['status']) && $getTag['status'] == 'success') {
            $data['tags'] = $getTag['result'];
        } else {
            $data['tags'] = [];
        }

        $getMembership = MyHelper::post('membership/list?log_save=0', []);
        if (isset($getMembership['status']) && $getMembership['status'] == 'success') {
            $data['memberships'] = $getMembership['result'];
        } else {
            $data['memberships'] = [];
        }

        $getApiKey = MyHelper::get('setting/whatsapp?log_save=0');
        if (isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']) {
            $data['api_key_whatsapp'] = $getApiKey['result']['value'];
        } else {
            $data['api_key_whatsapp'] = null;
        }

        $getTextReplace = MyHelper::get('autocrm/textreplace?log_save=0');
        if ($getTextReplace['status'] == 'success') {
            $data['textreplaces'] = $getTextReplace['result'];
        }
        if (isset($data['result']['start_date']) && isset($data['result']['send_time'])) {
            $date = date('Y-m-d - H:i', strtotime($data['result']['start_date'] . $data['result']['send_time']));
            if ($date <= date('Y-m-d - H:i', strtotime("+10 minutes"))) {
                return view('pointinjection::create-step-1', $data)->with('warning', ["Point Injection will begin or has already begun. You can't change it again"]);
            }
        }
        return view('pointinjection::create-step-1', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('pointinjection::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id_point_injection)
    {
        $post = $request->except(array('_token'));
        $post['id_point_injection'] = $id_point_injection;

        if ($post['filter_phone'] != null) {
            $post['phone_number'] = explode(',', $post['filter_phone']);
        }
        unset($post['filter_phone']);

        if (isset($post['point_injection_push_image']) && $post['point_injection_push_image'] != null) {
            $post['point_injection_push_image'] = MyHelper::encodeImage($post['point_injection_push_image']);
        }

        $action = MyHelper::post('point-injection/create?log_save=0', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            return redirect('point-injection/review/' . $action['result']);
        } else {
            return back()->withErrors($action['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id_point_injection)
    {
        $post['id_point_injection'] = $id_point_injection;

        $action = MyHelper::post('point-injection/delete?log_save=0', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            return redirect('point-injection')->withSuccess($action['message']);
        } else {
            return redirect('point-injection')->withErrors($action['message']);
        }
    }

    public function report(Request $request, $id_point_injection)
    {
        $post = $request->except('_token');
        $data = [
            'title'             => 'Report Point Injection',
            'menu_active'       => 'point-injection',
            'submenu_active'    => 'point-injection-report'
        ];
        $export = 0;
        if (isset($post['export'])) {
            $export = 1;
        }

        if (Session::has('filter-point-inject') && !empty($post) && !isset($post['filter'])) {
            $post = Session::get('filter-point-inject');
        } else {
            Session::forget('filter-point-inject');
        }

        $post['export'] = $export;
        $post['id_point_injection'] = $id_point_injection;
        $report = MyHelper::post('point-injection/report?page=' . $request->get('page'), $post);
        if (isset($report['status']) && $report['status'] == 'success') {
            if (isset($post['export']) && $post['export'] == 1) {
                foreach ($report['result'] as $row) {
                    $dt = [
                        'Name' => $row['name'],
                        'Phone' => $row['phone'],
                        'Email' => $row['email'],
                        'Date Send' => $row['created_at'] == null ? '' : date('d M Y H:i', strtotime($row['created_at'])),
                        'Status' => $row['status'],
                        'Total Point' => number_format($row['point']),
                        'Total Point Received' => number_format($row['total_point']),
                    ];
                    $arr['All Type'][] = $dt;
                }

                $dataExport = new MultisheetExport($arr);
                return Excel::download($dataExport, date('d M Y Hi') . '.xls');
            } else {
                $data['data']      = $report['result']['data'];
                $data['total']     = $report['result']['total'];
                $data['perPage']   = $report['result']['from'];
                $data['upTo']      = $report['result']['from'] + count($report['result']['data']) - 1;
                $data['paginator'] = new LengthAwarePaginator($report['result']['data'], $report['result']['total'], $report['result']['per_page'], $report['result']['current_page'], ['path' => url()->current()]);
            }
        } else {
            $data['data']          = [];
            $data['total']     = 0;
            $data['perPage']   = 0;
            $data['upTo']      = 0;
            $data['paginator'] = false;
        }

        if ($post) {
            Session::put('filter-point-inject', $post);
        }

        $detail = MyHelper::post('point-injection/detail', ['id_point_injection' => $id_point_injection]);
        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data['detail'] = $detail['result'];
            $data['detail']['count'] = $detail['count'];
        } else {
            $data['detail'] = [];
            $data['detail']['count'] = 0;
        }

        return view('pointinjection::report', $data);
    }
}
