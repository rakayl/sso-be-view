<?php

namespace Modules\Users\Http\Controllers;

use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;
use Excel;
use App\Imports\FirstSheetOnlyImport;

class UsersFranchiseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     * @route GET {{be}}/user
     */
    public function index(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'User Mitra',
            'sub_title'      => 'User Mitra List',
            'menu_active'    => 'user-franchise',
            'submenu_active' => 'user-franchise-list',
        ];

        $order = 'created_at';
        $orderType = 'desc';
        $sorting = 0;
        if (isset($post['sorting'])) {
            $sorting = 1;
            $order = $post['order'];
            $orderType = $post['order_type'];
        }

        if (isset($post['reset']) && $post['reset'] == 1) {
            Session::forget('filter-list-user-franchise');
            $post['filter_type'] = 'today';
        } elseif (Session::has('filter-list-user-franchise') && !empty($post) && !isset($post['filter'])) {
            $pageSession = 1;
            if (isset($post['page'])) {
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-user-franchise');
            $post['page'] = $pageSession;
            if ($sorting == 0 && !empty($post['order'])) {
                $order = $post['order'];
                $orderType = $post['order_type'];
            }
        }
        $page = '?page=1';
        if (isset($post['page'])) {
            $page = '?page=' . $post['page'];
        }

        $data['outlets'] = MyHelper::get('franchise/outlets')['result'] ?? [];
        $data['order'] = $order;
        $data['order_type'] = $orderType;
        $post['order'] = $order;
        $post['order_type'] = $orderType;

        $list = MyHelper::post('franchise/user' . $page, $post);

        if (($list['status'] ?? '') == 'success') {
            $data['data']          = $list['result']['data'];
            $data['data_total']     = $list['result']['total'];
            $data['data_per_page']   = $list['result']['from'];
            $data['data_up_to']      = $list['result']['from'] + count($list['result']['data']) - 1;
            $data['data_paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['data_total']     = 0;
            $data['data_per_page']   = 0;
            $data['data_up_to']      = 0;
            $data['data_paginator'] = false;
        }

        if ($post) {
            Session::put('filter-list-user-franchise', $post);
        }

        return view('users::user_franchise.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     * @route GET {{be}}/user/create
     */
    public function create()
    {
        $data = [
            'title'          => 'User Mitra',
            'sub_title'      => 'New User Mitra',
            'menu_active'    => 'user-franchise',
            'submenu_active' => 'user-franchise-new',
        ];
        $data['outlets'] = MyHelper::get('franchise/outlets')['result'] ?? [];
        return view('users::user_franchise.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     * @route POST {{be}}/user
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        $result = MyHelper::post('franchise/user/store', $post);

        if (($result['status'] ?? false) == 'success') {
            return redirect('user/user-franchise')->withSuccess(['Success create new user mitra']);
        } else {
            return back()->withInput()->withErrors($result['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     * @route GET {{be}}/user/:id
     */
    public function detail($user_id)
    {
        $data = [
            'title'          => 'User Mitra',
            'sub_title'      => 'User Mitra Detail',
            'menu_active'    => 'user-franchise',
            'submenu_active' => 'user-franchise-list',
        ];
        $result = MyHelper::post('franchise/user/detail', ['id_user_franchise' => $user_id]);

        if (isset($result['status']) && $result['status'] == 'success') {
            $data['result'] = $result['result'];
            $data['outlets'] = MyHelper::get('franchise/outlets')['result'] ?? [];

            return view('users::user_franchise.detail', $data);
        } else {
            return redirect('user/user-franchise')->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     * @route PUT {{be}}/user/:id
     */
    public function update(Request $request, $user_id)
    {
        $post = $request->except('_token');
        $post['id_user_franchise'] = $user_id;

        $result = MyHelper::post('franchise/user/update', $post);
        if (isset($result['status']) && $result['status'] == 'success') {
            return redirect('user/user-franchise/detail/' . $user_id)->withSuccess(['Success update user mitra']);
        } else {
            return redirect('user/user-franchise/detail/' . $user_id)->withErrors($result['messages'] ?? ['Failed update detail user mitra']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     * @route DELETE {{be}}/user/:id
     */
    public function destroy($id)
    {
        $result = MyHelper::post("franchise/user/delete", ['id_user_franchise' => $id]);
        return $result;
    }

    public function autoresponseUser(Request $request, $key)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            if ($key == 'reset-pin-user') {
                $title = 'Reset Pin User Mitra';
            } else {
                $title = 'New User Mitra';
            }

            $data['page_title'] = '[Response] ' . $title;
            $data['data'] = \MyHelper::apiPost('franchise/user/autoresponse', ['title' => $title])['result'] ?? [];
            if (empty($data['data'])) {
                return redirect('user')->withErrors(['Failed get data']);
            }
            $data['key'] = $key;
            return view('user::autoresponse', $data);
        } else {
            unset($post['files']);
            $query = \MyHelper::apiPost('franchise/user/autoresponse/new-user/update', $post);

            if (isset($query['status']) && $query['status'] == 'success') {
                return redirect('user/autoresponse/' . $key)->withSuccess(['Response updated']);
            } else {
                return redirect('user/autoresponse/' . $key)->withErrors(['Failed update response']);
            }
        }
    }

    public function import()
    {
        $data = [
            'title'          => 'User Mitra',
            'sub_title'      => 'Import User Mitra',
            'menu_active'    => 'user-franchise',
            'submenu_active' => 'user-franchise-import',
        ];
        return view('users::user_franchise.import_user_franchise', $data);
    }

    public function export(Request $request)
    {
        $post = $request->except('_token');
        $data = MyHelper::post('franchise/user', ['export' => 1])['result'] ?? [];

        if (empty($data)) {
            $datas['All Type'] = [
                [
                    'username' => 'U01',
                    'email' => 'tes1@tes.com',
                    'name' => 'Tes 1',
                    'outlet_code' => '0001',
                    'status' => 'Active'
                ],
                [
                    'username' => 'U02',
                    'email' => 'tes2@tes.com',
                    'name' => 'Tes 2',
                    'outlet_code' => '',
                    'status' => 'Inactive'
                ]
            ];
        } else {
            $datas['All Type'] = $data;
        }

        return Excel::download(new MultisheetExport($datas), date('YmdHi') . '_user mitra.xlsx');
    }

    public function importSave(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(), $request->file('import_file'));
            if (!empty($data)) {
                $import = MyHelper::post('franchise/user/import', ['data' => $data]);
            }
        }

        return $import;
    }
}
