<?php

namespace Modules\Report\Http\Controllers;

use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;
use Excel;
use File;

class ReportPayment extends Controller
{
    public function index(Request $request, $type)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-payment',
            'sub_title'      => 'Report Payment ' . ucfirst($type),
            'submenu_active' => 'report-payment-' . $type,
        ];

        if (Session::has('filter-list-payment-' . $type) && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-payment-' . $type);
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-payment-' . $type);
        }

        $report = MyHelper::post('report/payment/' . $type, $post);

        if (isset($report['status']) && $report['status'] == "success") {
            $data['data']          = $report['result']['data']['data'];
            $data['dataTotal']     = $report['result']['data']['total'];
            $data['dataPerPage']   = $report['result']['data']['from'];
            $data['dataUpTo']      = $report['result']['data']['from'] + count($report['result']['data']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($report['result']['data']['data'], $report['result']['data']['total'], $report['result']['data']['per_page'], $report['result']['data']['current_page'], ['path' => url()->current()]);
            $data['sum'] = $report['result']['sum'] ?? 0;
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
            $data['sum'] = 0;
        }

        if ($post) {
            Session::put('filter-list-payment-' . $type, $post);
        }

        $data['type'] = $type;
        return view('report::report_payment.index', $data);
    }

    public function createExport(Request $request, $type)
    {
        $post = $request->except('_token');

        if (Session::has('filter-list-payment-' . $type) && !isset($post['filter'])) {
            $post = Session::get('filter-list-payment-' . $type);
        }
        $post['export'] = 1;
        $post['type'] = $type;
        $post['report_type'] = 'Payment';
        $post['id_user'] = Session::get('id_user');
        $report = MyHelper::post('report/export/create', $post);

        if (isset($report['status']) && $report['status'] == "success") {
            return redirect('report/payment/list-export')->withSuccess(['Success create export to queue']);
        } else {
            return redirect('report/payment/' . $type)->withErrors(['Failed create export to queue']);
        }
    }

    public function listExport(Request $request)
    {
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-payment',
            'sub_title'      => 'Export Queue',
            'submenu_active' => 'report-payment-export'
        ];

        $id_user = Session::get('id_user');
        $report = MyHelper::post('report/export/list', ['id_user' => $id_user, 'report_type' => ' Payment']);
        if (isset($report['status']) && $report['status'] == "success") {
            $data['data']          = $report['result']['data'];
            $data['dataTotal']     = $report['result']['total'];
            $data['dataPerPage']   = $report['result']['from'];
            $data['dataUpTo']      = $report['result']['from'] + count($report['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($report['result']['data'], $report['result']['total'], $report['result']['per_page'], $report['result']['current_page'], ['path' => url()->current()]);
            $data['sum'] = 0;
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
            $data['sum'] = 0;
        }

        return view('report::export.list_export', $data);
    }

    public function actionExport(Request $request, $action, $id)
    {
        $post = $request->except('_token');

        $post['action'] = $action;
        $post['id_export_queue'] = $id;
        $actions = MyHelper::post('report/export/action', $post);
        if ($action == 'deleted') {
            if (isset($actions['status']) && $actions['status'] == "success") {
                return redirect('report/payment/list-export')->withSuccess(['Success to Remove file']);
            } else {
                return redirect('report/payment/list-export')->withErrors(['Failed to Remove file']);
            }
        } else {
            if (isset($actions['status']) && $actions['status'] == "success") {
                $link = $actions['result']['url_export'];
                $filename = "Report Payment_" . strtotime(date('Ymdhis')) . '.xlsx';
                $tempImage = tempnam(sys_get_temp_dir(), $filename);
                copy($link, $tempImage);

                return response()->download($tempImage, $filename)->deleteFileAfterSend(true);
            } else {
                return redirect('report/payment/list-export')->withErrors(['Failed to Download file']);
            }
        }
    }
}
