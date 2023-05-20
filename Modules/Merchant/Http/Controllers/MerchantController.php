<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class MerchantController extends Controller
{
    public function settingRegisterIntroduction(Request $request)
    {
        $post = $request->all();
        if (empty($post)) {
            $data = [
                'title'          => 'Merchant',
                'menu_active'    => 'merchant',
                'sub_title'      => 'Setting Register Introduction',
                'submenu_active' => 'merchant-setting-register-introduction',
                'status'        => 'introduction'
            ];

            $data['result'] = MyHelper::get('merchant/register/introduction/detail')['result'] ?? [];
            return view('merchant::register_page', $data);
        } else {
            if (!empty($post['image'])) {
                $post['image'] = MyHelper::encodeImage($post['image']);
            }
            $update = MyHelper::post('merchant/register/introduction/save', $post);

            if (($update['status'] ?? false) == 'success') {
                return back()->with('success', ['Register introduction setting has been updated']);
            } else {
                return back()->withErrors($update['messages'] ?? ['Update failed']);
            }
        }
    }

    public function settingRegisterSuccess(Request $request)
    {
        $post = $request->all();
        if (empty($post)) {
            $data = [
                'title'          => 'Merchant',
                'menu_active'    => 'merchant',
                'sub_title'      => 'Setting Register Success',
                'submenu_active' => 'merchant-setting-register-success',
                'status'        => 'success'
            ];

            $data['result'] = MyHelper::get('merchant/register/success/detail')['result'] ?? [];
            return view('merchant::register_page', $data);
        } else {
            if (!empty($post['image'])) {
                $post['image'] = MyHelper::encodeImage($post['image']);
            }
            $update = MyHelper::post('merchant/register/success/save', $post);

            if (($update['status'] ?? false) == 'success') {
                return back()->with('success', ['Register success setting has been updated']);
            } else {
                return back()->withErrors($update['messages'] ?? ['Update failed']);
            }
        }
    }

    public function settingRegisterApproved(Request $request)
    {
        $post = $request->all();
        if (empty($post)) {
            $data = [
                'title'          => 'Merchant',
                'menu_active'    => 'merchant',
                'sub_title'      => 'Setting Register Approved',
                'submenu_active' => 'merchant-setting-register-aproved',
                'status'        => 'aproved'
            ];

            $data['result'] = MyHelper::get('merchant/register/approved/detail')['result'] ?? [];
            return view('merchant::register_page', $data);
        } else {
            if (!empty($post['image'])) {
                $post['image'] = MyHelper::encodeImage($post['image']);
            }
            $update = MyHelper::post('merchant/register/approved/save', $post);

            if (($update['status'] ?? false) == 'success') {
                return back()->with('success', ['Register approved setting has been updated']);
            } else {
                return back()->withErrors($update['messages'] ?? ['Update failed']);
            }
        }
    }

    public function settingRegisterRejected(Request $request)
    {
        $post = $request->all();
        if (empty($post)) {
            $data = [
                'title'          => 'Merchant',
                'menu_active'    => 'merchant',
                'sub_title'      => 'Setting Register Rejected',
                'submenu_active' => 'merchant-setting-register-rejected',
                'status'        => 'rejected'
            ];

            $data['result'] = MyHelper::get('merchant/register/rejected/detail')['result'] ?? [];
            return view('merchant::register_page', $data);
        } else {
            if (!empty($post['image'])) {
                $post['image'] = MyHelper::encodeImage($post['image']);
            }
            $update = MyHelper::post('merchant/register/rejected/save', $post);

            if (($update['status'] ?? false) == 'success') {
                return back()->with('success', ['Register rejected setting has been updated']);
            } else {
                return back()->withErrors($update['messages'] ?? ['Update failed']);
            }
        }
    }

    public function create()
    {
        $data = [
            'title'          => 'Tukang Sedot',
            'sub_title'      => 'New Tukang Sedot',
            'menu_active'    => 'Tukang Sedot',
            'submenu_active' => 'tukang-sedot-new'
        ];

        $data['province'] = MyHelper::get('province/list')['result'] ?? [];
        $data['users'] = MyHelper::get('merchant/user/list-not-register')['result'] ?? [];
        $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
        return view('merchant::create', $data);
    }

    public function store(Request $request)
    {
        $post = $request->all();
        $create = MyHelper::post('merchant/store', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return redirect('tukang-sedot/candidate')->withSuccess(['Success save data']);
        } else {
            return redirect('tukang-sedot/create')->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }

    public function list(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Tukang Sedot',
            'sub_title'      => 'Tukang Sedot List',
            'menu_active'    => 'tukang-sedot',
            'submenu_active' => 'tukang-sedot-list',
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

        return view('merchant::list', $data);
    }

    public function detail($id)
    {
        $data = [
            'title'          => 'Merchant',
            'sub_title'      => 'Merchant Detail',
            'menu_active'    => 'merchant',
            'submenu_active' => 'merchant-list'
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
            return view('merchant::detail', $data);
        } else {
            return redirect('tukang-sedot/candidate')->withErrors($save['messages'] ?? ['Failed get data']);
        }
    }

    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        unset($post['action_type']);
        $post['id_merchant'] = $id;
        $update = MyHelper::post('merchant/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('tukang-sedot/detail/' . $id)->withSuccess(['Success save data']);
        } else {
            return redirect('tukang-sedot/detail/' . $id)->withErrors($update['messages'] ?? ['Failed get data']);
        }
    }

    public function candidate(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Tukang Sedot',
            'sub_title'      => 'Tukang Sedot Candidate',
            'menu_active'    => 'tukang-sedot',
            'submenu_active' => 'tukang-sedot-candidate',
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

        return view('merchant::candidate_list', $data);
    }

    public function candidateUpdate(Request $request, $id)
    {
        $post = $request->all();
        $post['id_merchant'] = $id;
        $detail = MyHelper::post('merchant/candidate/update', $post);

        if (isset($detail['status']) && $detail['status'] == "success") {
            if ($post['action_type'] == 'approve') {
                return redirect('tukang-sedot/detail/' . $id)->withSuccess(['Success save data']);
            } else {
                return redirect('tukang-sedot/candidate/detail/' . $id)->withSuccess(['Success save data']);
            }
        } else {
            return redirect('tukang-sedot/candidate/detail/' . $id)->withErrors($detail['messages'] ?? ['Failed get data']);
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

        return view('merchant::withdrawal_list', $data);
    }

    public function withdrawalCompleted(Request $request)
    {
        $post = $request->all();
        $update = MyHelper::post('merchant/withdrawal/completed', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('tukang-sedot/withdrawal')->withSuccess(['Success change status to completed']);
        } else {
            return redirect('tukang-sedot/withdrawal')->withErrors($update['messages'] ?? ['Failed change status']);
        }
    }

    public function updateGrading(Request $request, $id)
    {
        $post = $request->except('_token');

        $post['id_merchant'] = $id;
        $update = MyHelper::post('merchant/update-grading', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('tukang-sedot/detail/' . $id . '#merchant_grading')->withSuccess(['Success save data']);
        } else {
            return redirect('tukang-sedot/detail/' . $id . '#merchant_grading')->withErrors($update['messages'] ?? ['Failed get data']);
        }
    }
}
