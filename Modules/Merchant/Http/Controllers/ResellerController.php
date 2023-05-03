<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class ResellerController extends Controller
{
    public function candidate(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Reseller',
            'sub_title'      => 'Reseller',
            'menu_active'    => 'reseller',
            'submenu_active' => 'reseller-candidate-list',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
            'type' => ''
        ];

        if (Session::has('filter-candidate-reseller') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-candidate-reseller');
            $post['page'] = $page;
        } else {
            Session::forget('filter-candidate-reseller');
        }
        $getList = MyHelper::post('merchant/be/reseller/candidate', $post);
        $vas = array();
        foreach ($getList['result']['data'] ?? [] as $value) {
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_user_reseller_merchant'], date('Y-m-d H:i:s'));
            array_push($vas, $value);
        }
        if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $vas;
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
            Session::put('filter-candidate-reseller', $post);
        }

        return view('merchant::reseller.list', $data);
    }
    public function candidateDetail(Request $request, $id)
    {
        $data = [
                'title'          => 'Reseller',
                'sub_title'      => 'Detail Reseller',
                'menu_active'    => 'reseller',
                'submenu_active' => 'reseller-candidate',
                'child_active'   => 'detail-reseller-candidate',
                'url_back'      => 'merchant/reseller/candidate',
                'page_type'     => 'candidate'
            ];
        $data['id_enkripsi'] = $id;
        $id = MyHelper::explodeSlug($id)[0] ?? '';
        $detail = MyHelper::post('merchant/be/reseller/candidate/detail', ['id_user_reseller_merchant' => $id]);
        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data['detail'] = $detail['result'];
            return view('merchant::reseller.detail', $data);
        } else {
            return redirect('merchant/reseller/candidate')->withErrors($store['messages'] ?? ['Failed get detail candidate']);
        }
    }
    public function candidateUpdate(Request $request, $id)
    {
        $post = $request->except('_token');
        $id = MyHelper::createSlug($id, date('Y-m-d H:i:s'));
        $update = MyHelper::post('merchant/be/reseller/candidate/update', $post);
        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('merchant/reseller/detail/' . $id)->withSuccess(['Success update data']);
        } else {
            return redirect()->back()->withErrors($update['messages'] ?? ['Failed update data to approved']);
        }
    }


    public function detail(Request $request, $id)
    {
        $data = [
                'title'          => 'Reseller',
                'sub_title'      => 'Detail Reseller',
                'menu_active'    => 'reseller',
                'submenu_active' => 'reseller',
                'child_active'   => 'detail-reseller',
                'url_back'      => 'merchant/reseller',
                'page_type'     => ''
            ];
        $data['id_enkripsi'] = $id;
        $id = MyHelper::explodeSlug($id)[0] ?? '';
        $detail = MyHelper::post('merchant/be/reseller/detail', ['id_user_reseller_merchant' => $id]);
        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data['detail'] = $detail['result'];
            return view('merchant::reseller.detail', $data);
        } else {
            return redirect('merchant/reseller')->withErrors($store['messages'] ?? ['Failed get detail candidate']);
        }
    }
    public function index(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Reseller',
            'sub_title'      => 'Reseller',
            'menu_active'    => 'reseller',
            'submenu_active' => 'reseller-list',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
            'type' => ''
        ];

        if (Session::has('filter-reseller') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-reseller');
            $post['page'] = $page;
        } else {
            Session::forget('filter-reseller');
        }
        $getList = MyHelper::post('merchant/be/reseller', $post);
        $vas = array();
        foreach ($getList['result']['data'] ?? [] as $value) {
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_user_reseller_merchant'], date('Y-m-d H:i:s'));
            array_push($vas, $value);
        }
        if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $vas;
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
            Session::put('filter-reseller', $post);
        }

        return view('merchant::reseller.index', $data);
    }
    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        $id = MyHelper::createSlug($id, date('Y-m-d H:i:s'));
        $update = MyHelper::post('merchant/be/reseller/update', $post);
        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('merchant/reseller/detail/' . $id)->withSuccess(['Success update data']);
        } else {
            return redirect()->back()->withErrors($update['messages'] ?? ['Failed update data to approved']);
        }
    }
    public function active(Request $request)
    {
        $post = $request->except('_token');
        $data['id_user_reseller_merchant'] = MyHelper::explodeSlug($post['id_enkripsi'])[0] ?? '';
        $data['reseller_merchant_status'] = "Active";
        $update = MyHelper::post('merchant/be/reseller/update', $data);
        return $update;
    }
    public function inactive(Request $request)
    {
        $post = $request->except('_token');
        $data['id_user_reseller_merchant'] = MyHelper::explodeSlug($post['id_enkripsi'])[0] ?? '';
        $data['reseller_merchant_status'] = "Inactive";
        $update = MyHelper::post('merchant/be/reseller/update', $data);
        return $update;
    }
}
