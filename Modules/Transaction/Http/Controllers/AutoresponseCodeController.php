<?php

namespace Modules\Transaction\Http\Controllers;

use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Imports\FirstSheetOnlyImport;
use App\Lib\MyHelper;
use Session;
use Excel;

class AutoresponseCodeController extends Controller
{
    public function list(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Autoresponse With Code',
            'sub_title'      => 'Code List',
            'menu_active'    => 'response-with-code',
            'submenu_active' => 'response-with-code-list',
        ];

        if (Session::has('filter-list-autoresponse-code') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-autoresponse-code');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-autoresponse-code');
        }

        $data['payment_list'] = MyHelper::post('transaction/available-payment', ['show_all' => 0])['result'] ?? [];
        $list = MyHelper::post('autoresponse-with-code/list', $post);
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
            Session::put('filter-list-autoresponse-code', $post);
        }
        return view('transaction::autoresponse_with_code.code_list', $data);
    }

    public function create()
    {
        $data = [
            'title'          => 'Autoresponse With Code',
            'sub_title'      => 'New Code',
            'menu_active'    => 'response-with-code',
            'submenu_active' => 'response-with-code-new',
        ];
        $data['payment_list'] = MyHelper::post('transaction/available-payment', ['show_all' => 0])['result'] ?? [];
        return view('transaction::autoresponse_with_code.code_create', $data);
    }

    public function store(Request $request)
    {
        $post = $request->except('_token');
        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $post['data_import'] = \Excel::toCollection(new FirstSheetOnlyImport(), $request->file('import_file'));
        }

        $store = MyHelper::post('autoresponse-with-code/store', $post);

        if (isset($store['status']) && $store['status'] == 'success') {
            return redirect('response-with-code')->withSuccess(['Success create list code']);
        } else {
            return redirect('response-with-code/create')->withErrors($store['messages'] ?? ['Failed create list code'])->withInput();
        }
    }

    public function edit($id)
    {
        $detail = MyHelper::post('autoresponse-with-code/detail', ['id_autoresponse_code' => $id]);
        $data = [
            'title'          => 'Autoresponse With Code',
            'sub_title'      => 'Code Edit',
            'menu_active'    => 'response-with-code',
            'submenu_active' => 'response-with-code-list',
        ];

        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data['result'] = $detail['result'];
            $data['payment_list'] = MyHelper::post('transaction/available-payment', ['show_all' => 0])['result'] ?? [];
            return view('transaction::autoresponse_with_code.code_edit', $data);
        } else {
            return redirect('response-with-code')->withErrors($store['messages'] ?? ['Failed get detail code']);
        }
    }

    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        $post['id_autoresponse_code'] = $id;
        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $post['data_import'] = \Excel::toCollection(new FirstSheetOnlyImport(), $request->file('import_file'));
        }
        $update = MyHelper::post('autoresponse-with-code/update', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('response-with-code/edit/' . $id)->withSuccess(['Success update']);
        } else {
            return redirect('response-with-code/edit/' . $id)->withErrors($update['messages'] ?? ['Failed update detail autoresponse code']);
        }
    }

    public function deleteCode(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('autoresponse-with-code/delete-code', $post);
        return $delete;
    }

    public function deleteAutoresponsecode(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('autoresponse-with-code/delete-autoresponsecode', $post);
        return $delete;
    }

    public function exportExample()
    {
        $datas['All Type'] = [
            [
                'list_codes' => 'CODE0001'
            ],
            [
                'list_codes' => 'CODE0002'
            ],
            [
                'list_codes' => 'CODE0004'
            ],
            [
                'list_codes' => 'CODE0005'
            ]
        ];

        return Excel::download(new MultisheetExport($datas), date('YmdHi') . '_list_codes.xlsx');
    }
}
