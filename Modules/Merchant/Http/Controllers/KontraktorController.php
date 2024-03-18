<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class KontraktorController extends Controller
{

    public function create()
    {
        $data = [
            'title'          => 'Vendor Pembangunan',
            'sub_title'      => 'New Vendor Pembangunan',
            'menu_active'    => 'Vendor Pembangunan',
            'submenu_active' => 'kontraktor-new'
        ];

        $getCity = MyHelper::get('city/pemda');
        if ($getCity['status'] == 'success') {
            $data['city'] = $getCity['result'];
        } else {
            $data['city'] = null;
        }
        return view('merchant::kontraktor.create', $data);
    }

    public function store(Request $request)
    {
        $post = $request->all();
        if (!empty($post['outlet_latitude']) && (strpos($post['outlet_latitude'], ',') !== false || $post['outlet_latitude'] == 'NaN')) {
            return back()->withErrors(['Please input invalid latitude'])->withInput();
        }

        if (!empty($post['outlet_longitude']) && (strpos($post['outlet_longitude'], ',') !== false || $post['outlet_longitude'] == 'NaN')) {
            return back()->withErrors(['Please input invalid longitude'])->withInput();
        }
        if (!empty($post['outlet_image_logo_portrait'])) {
            $post['outlet_image_logo_portrait'] = MyHelper::encodeImage($post['outlet_image_logo_portrait']);
        }

        if (!empty($post['outlet_image_logo_landscape'])) {
            $post['outlet_image_logo_landscape'] = MyHelper::encodeImage($post['outlet_image_logo_landscape']);
        }

        if (!empty($post['outlet_image_cover'])) {
            $post['outlet_image_cover'] = MyHelper::encodeImage($post['outlet_image_cover']);
        }
        if (!empty($post['merchant_pic_attachment'])) {
                $post['merchant_pic_attachment_ext'] = pathinfo($post['merchant_pic_attachment']->getClientOriginalName(), PATHINFO_EXTENSION);
                $post['merchant_pic_attachment'] = MyHelper::encodeImage($post['merchant_pic_attachment']);
        }
        if (!empty($post['phone'])) {
                $post['merchant_phone'] = $post['phone'];
        }
        if (!empty($post['email'])) {
                $post['merchant_email'] = $post['email'];
        }
        
        $create = MyHelper::post('merchant/store', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return redirect('kontraktor/candidate')->withSuccess(['Success save data']);
        } else {
            return redirect('kontraktor/create')->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }

    public function list(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Vendor Pembangunan',
            'sub_title'      => 'Vendor Pembangunan List',
            'menu_active'    => 'kontraktor',
            'submenu_active' => 'kontraktor-list',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
            'type' => ''
        ];

        if (Session::has('filter-merchant') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-merchant');
            $post['page'] = $page;
        } else {
            Session::forget('filter-merchant');
        }
        $post['level'] = "Kontraktor";
        $getList = MyHelper::post('merchant/list', $post);

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
            Session::put('filter-merchant', $post);
        }

        return view('merchant::kontraktor.list', $data);
    }

    public function detail($id)
    {
        $data = [
            'title'          => 'Vendor Pembangunan',
            'sub_title'      => 'Vendor Pembangunan Detail',
            'menu_active'    => 'kontraktor',
            'submenu_active' => 'kontraktor-list',
        ];

        $data['outlets'] = MyHelper::get('outlet/be/list/simple')['result'] ?? [];
        $data['provinces'] = MyHelper::get('province/list')['result'] ?? [];
        $data['cities'] = MyHelper::get('city/list')['result'] ?? [];
        $detail = MyHelper::post('merchant/detail', ['id_merchant' => $id]);

        if (isset($detail['status']) && $detail['status'] == "success") {
            $data['detail'] = $detail['result'];
            if (in_array($detail['result']['merchant_status'], ['Pending', 'Rejected'])) {
                $data['submenu_active'] = 'merchant-candidate';
            }
            return view('merchant::kontraktor.detail', $data);
        } else {
            return redirect('kontraktor/candidate')->withErrors($save['messages'] ?? ['Failed get data']);
        }
    }

    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        unset($post['action_type']);
        $post['id_merchant'] = $id;
        $update = MyHelper::post('merchant/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('kontraktor/detail/' . $id)->withSuccess(['Success save data']);
        } else {
            return redirect('kontraktor/detail/' . $id)->withErrors($update['messages'] ?? ['Failed get data']);
        }
    }

    public function candidate(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Vendor Pembangunan',
            'sub_title'      => 'Vendor Pembangunan Candidate',
            'menu_active'    => 'kontraktor',
            'submenu_active' => 'kontraktor-candidate',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
            'type' => 'candidate'
        ];

        if (Session::has('filter-merchant-candidate') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-merchant-candidate');
            $post['page'] = $page;
        } else {
            Session::forget('filter-merchant-candidate');
        }
        $post['level'] = "Kontraktor";
        $getList = MyHelper::post('merchant/candidate/list', $post);

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
            Session::put('filter-merchant-candidate', $post);
        }

        return view('merchant::kontraktor.candidate_list', $data);
    }

    public function candidateUpdate(Request $request, $id)
    {
        $post = $request->all();
        $post['id_merchant'] = $id;
        $detail = MyHelper::post('merchant/candidate/update', $post);

        if (isset($detail['status']) && $detail['status'] == "success") {
            if ($post['action_type'] == 'approve') {
                return redirect('kontraktor/detail/' . $id)->withSuccess(['Success save data']);
            } else {
                return redirect('kontraktor/candidate/detail/' . $id)->withSuccess(['Success save data']);
            }
        } else {
            return redirect('kontraktor/candidate/detail/' . $id)->withErrors($detail['messages'] ?? ['Failed get data']);
        }
    }

    public function candidateDelete($id)
    {
        $delete = MyHelper::post('merchant/delete', ['id_merchant' => $id]);
        return $delete;
    }

    public function withdrawalList(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Merchant',
            'sub_title'      => 'Withdrawal List',
            'menu_active'    => 'merchant',
            'submenu_active' => 'withdrawal-list',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
            'type' => ''
        ];

        if (Session::has('filter-merchant-withdrawal') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-merchant-withdrawal');
            $post['page'] = $page;
        } else {
            Session::forget('filter-merchant-withdrawal');
        }

        $getList = MyHelper::post('merchant/withdrawal/list', $post);

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
            Session::put('filter-merchant-withdrawal', $post);
        }

        return view('merchant::kontraktor.withdrawal_list', $data);
    }

    public function withdrawalCompleted(Request $request)
    {
        $post = $request->all();
        $update = MyHelper::post('merchant/withdrawal/completed', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('kontraktor/withdrawal')->withSuccess(['Success change status to completed']);
        } else {
            return redirect('kontraktor/withdrawal')->withErrors($update['messages'] ?? ['Failed change status']);
        }
    }

    public function updateGrading(Request $request, $id)
    {
        $post = $request->except('_token');

        $post['id_merchant'] = $id;
        $update = MyHelper::post('merchant/update-grading', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('kontraktor/detail/' . $id . '#merchant_grading')->withSuccess(['Success save data']);
        } else {
            return redirect('kontraktor/detail/' . $id . '#merchant_grading')->withErrors($update['messages'] ?? ['Failed get data']);
        }
    }
}
