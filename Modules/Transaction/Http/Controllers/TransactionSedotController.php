<?php

namespace Modules\Transaction\Http\Controllers;

use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;
use Excel;
use App\Imports\FirstSheetOnlyImport;

class TransactionSedotController extends Controller
{
    public function pending(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transaction Sedot WC',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Pending',
            'submenu_active' => 'transaction-sedot-wc-pending',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
        ];

        if (Session::has('filter-transaction-sedot-wc-pending') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-transaction-sedot-wc-pending');
            $post['page'] = $page;
        } else {
            Session::forget('filter-transaction-sedot-wc-pending');
        }
        $post['filter_status_code'] = [3];
        $list = MyHelper::post('transaction/list-all', $post);

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
            Session::put('filter-transaction-sedot-wc-pending', $post);
        }
        return view('transaction::transactionList', $data);
    }
    public function proses(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transaction Sedot WC',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Diproses',
            'submenu_active' => 'transaction-sedot-wc-proses',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
        ];

        if (Session::has('filter-transaction-sedot-wc-proses') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-transaction-sedot-wc-proses');
            $post['page'] = $page;
        } else {
            Session::forget('filter-transaction-sedot-wc-proses');
        }
        $post['filter_status_code'] = [4];
        $list = MyHelper::post('transaction/list-all', $post);

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
            Session::put('filter-transaction-sedot-wc-proses', $post);
        }

        
        return view('transaction::transactionList', $data);
    }
    public function selesai(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transaction Sedot WC',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Selesai',
            'submenu_active' => 'transaction-sedot-wc-selesai',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
        ];

        if (Session::has('filter-transaction-sedot-wc-selesai') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-transaction-sedot-wc-selesai');
            $post['page'] = $page;
        } else {
            Session::forget('filter-transaction-sedot-wc-selesai');
        }
        $post['filter_status_code'] = [5];
        $list = MyHelper::post('transaction/list-all', $post);

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
            Session::put('filter-transaction-sedot-wc-selesai', $post);
        }
        return view('transaction::transactionList', $data);
    }
    public function complete(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transaction Sedot WC',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Completed',
            'submenu_active' => 'transaction-sedot-wc-complete',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
        ];

        if (Session::has('filter-transaction-sedot-wc-complete') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-transaction-sedot-wc-complete');
            $post['page'] = $page;
        } else {
            Session::forget('filter-transaction-sedot-wc-complete');
        }
        $post['filter_status_code'] = [6];
       $list = MyHelper::post('transaction/list-all', $post);

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
            Session::put('filter-transaction-sedot-wc-complete', $post);
        }
        return view('transaction::transactionList', $data);
    }
}
