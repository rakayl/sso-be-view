<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Modules\Reward\Http\Controllers\RewardController;
use Session;

class InvalidFlagController extends Controller
{
    public function markAsPendingInvalid(Request $request)
    {
        $post = $request->except('_token');

        $data = [
            'title'          => 'Mark as Pending Invalid',
            'menu_active'    => 'mark-as-pending-invalid',
            'sub_title'      => '',
            'submenu_active' => 'mark-as-pending-invalid'
        ];

        if (Session::has('filter-mark-as-pending-invalid') && !empty($post) && !isset($post['filter'])) {
            $post = Session::get('filter-mark-as-pending-invalid');
        } else {
            Session::forget('filter-mark-as-pending-invalid');
        }

        $data['list_trx'] = [];
        $list = MyHelper::post('transaction/invalid-flag/filter', $post);

        if (isset($list['result']['data']) && !empty($list['result']['data'])) {
            $data['data']          = $list['result']['data'];
            $data['dataTotal']     = $list['result']['total'];
            $data['dataPerPage']   = $list['result']['from'];
            $data['dataUpTo']      = $list['result']['from'] + count($list['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if ($post) {
            Session::put('filter-mark-as-pending-invalid', $post);
        }

        return view('transaction::flag_invalid.mark_as_pending_invalid', $data);
    }

    public function markAsInvalid(Request $request)
    {
        $post = $request->except('_token');

        $data = [
            'title'          => 'Mark as Invalid',
            'menu_active'    => 'mark-as-invalid',
            'sub_title'      => '',
            'submenu_active' => 'mark-as-invalid'
        ];

        if (Session::has('filter-mark-as-invalid') && !empty($post) && !isset($post['filter'])) {
            $post = Session::get('filter-mark-as-invalid');
        } else {
            Session::forget('filter-mark-as-invalid');
        }

        $data['list_trx'] = [];
        $post['pending_invalid'] = 1;
        $list = MyHelper::post('transaction/invalid-flag/filter', $post);

        if (isset($list['result']['data']) && !empty($list['result']['data'])) {
            $data['data']          = $list['result']['data'];
            $data['dataTotal']     = $list['result']['total'];
            $data['dataPerPage']   = $list['result']['from'];
            $data['dataUpTo']      = $list['result']['from'] + count($list['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if ($post) {
            Session::put('filter-mark-as-invalid', $post);
        }

        return view('transaction::flag_invalid.mark_as_invalid', $data);
    }

    public function markAsPendingInvalidAdd(Request $request)
    {
        $post = $request->except('_token');
        $add = MyHelper::post('transaction/invalid-flag/mark-as-pending-invalid/add', $post);

        if (isset($add['status']) && $add['status'] == 'success') {
            return redirect('transaction/invalid-flag/detail/' . $post['id_transaction'] . '?from=invalid')->withSuccess(['Success Update Data']);
        } else {
            return back()->withErrors($add['messages']);
        }
    }

    public function markAsInvalidAdd(Request $request)
    {
        $post = $request->except('_token');

        if (isset($post['image'])) {
            $post['image'] = MyHelper::encodeImage($post['image']);
        }

        $add = MyHelper::post('transaction/invalid-flag/mark-as-invalid/add', $post);

        if (isset($add['status']) && $add['status'] == 'success') {
            return redirect('transaction/invalid-flag/detail/' . $post['id_transaction'] . '?from=valid')->withSuccess(['Success Update Data']);
        } else {
            return back()->withErrors($add['messages']);
        }
    }

    public function markAsValidUpdate(Request $request)
    {
        $post = $request->except('_token');
        $update = MyHelper::post('transaction/invalid-flag/mark-as-valid/update', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('transaction/invalid-flag/detail/' . $post['id_transaction'] . '?from=invalid')->withSuccess(['Success Update Data']);
        } else {
            return back()->withErrors($update['messages']);
        }
    }

    public function markAsValid(Request $request)
    {
        $post = $request->except('_token');

        $data = [
            'title'          => 'Mark as Valid',
            'menu_active'    => 'mark-as-valid',
            'sub_title'      => '',
            'submenu_active' => 'mark-as-valid'
        ];

        if (Session::has('filter-mark-as-valid') && !empty($post) && !isset($post['filter'])) {
            $post = Session::get('filter-mark-as-valid');
        } else {
            Session::forget('filter-mark-as-valid');
        }

        $post['invalid'] = 1;
        $list = MyHelper::post('transaction/invalid-flag/filter', $post);
        if (isset($list['result']['data']) && !empty($list['result']['data'])) {
            $data['data']          = $list['result']['data'];
            $data['dataTotal']     = $list['result']['total'];
            $data['dataPerPage']   = $list['result']['from'];
            $data['dataUpTo']      = $list['result']['from'] + count($list['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if ($post) {
            Session::put('filter-mark-as-valid', $post);
        }

        return view('transaction::flag_invalid.mark_as_valid', $data);
    }

    public function detailTrx(Request $request, $id)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Invalid Flag',
            'menu_active'    => 'mark-as-invalid',
            'sub_title'      => 'Mark as Invalid',
            'submenu_active' => 'mark-as-invalid'
        ];

        $post['id_transaction'] = $id;
        $post['type'] = 'trx';
        $post['check'] = 1;

        $check = MyHelper::post('transaction/be/detail', ['id_transaction' => $id, 'type' => 'trx', 'admin' => 1]);

        if (isset($check['status']) && $check['status'] == 'success') {
            $data['data'] = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        if ($post['from'] == 'valid') {
            $data['menu_active'] = 'mark-as-valid';
            $data['submenu_active'] = 'mark-as-valid';
            $data['sub_title'] = 'Mark as Valid';
        } elseif ($post['from'] == 'invalid') {
            $data['menu_active'] = 'mark-as-invalid';
            $data['submenu_active'] = 'mark-as-invalid';
            $data['sub_title'] = 'Mark as Invalid';
        } elseif ($post['from'] == 'pendinginvalid') {
            $data['menu_active'] = 'mark-as-pending-invalid';
            $data['submenu_active'] = 'mark-as-pending-invalid';
            $data['sub_title'] = 'Mark as Pending Invalid';
        }

        $data['from'] = $post['from'];
        $data['id_transaction'] = $id;

        $data['logs'] = [];
        $detailLog = MyHelper::post('transaction/log-invalid-flag/detail', ['id_transaction' => $id]);

        if (isset($detailLog['status']) && $detailLog['status'] == 'success') {
            $data['logs'] = $detailLog['result'];
        }
        return view('transaction::transactionDetail3', $data);
    }

    public function listLogInvalidFlag(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'log-invalid-flag',
            'sub_title'      => 'Log Invalid Flag',
            'submenu_active' => 'log-invalid-flag'
        ];

        if (Session::has('filter-list-flag-invalid') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-flag-invalid');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-flag-invalid');
        }

        $list = MyHelper::post('transaction/log-invalid-flag/list', $post);

        if (isset($list['result']['data']) && !empty($list['result']['data'])) {
            $data['data']          = $list['result']['data'];
            $data['dataTotal']     = $list['result']['total'];
            $data['dataPerPage']   = $list['result']['from'];
            $data['dataUpTo']      = $list['result']['from'] + count($list['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if ($post) {
            Session::put('filter-list-flag-invalid', $post);
        }

        return view('transaction::flag_invalid.list', $data);
    }

    public function detailLogInvalidFlag(Request $request)
    {
        $post = $request->except('_token');
        $data = MyHelper::post('transaction/log-invalid-flag/detail', $post);

        return $data;
    }
}
