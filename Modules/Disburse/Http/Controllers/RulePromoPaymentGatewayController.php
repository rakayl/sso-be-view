<?php

namespace Modules\Disburse\Http\Controllers;

use App\Exports\MultisheetExport;
use App\Exports\ReportRulePromoPaymentGatewayBladeExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\LoginRequest;
use App\Lib\MyHelper;
use Session;
use GoogleReCaptchaV3;
use Excel;
use App\Exports\DisburseDetailBladeExport;
use App\Imports\FirstSheetOnlyImport;

class RulePromoPaymentGatewayController extends Controller
{
    public function index(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Rule Promo Payment Gateway',
            'sub_title'      => 'New Rule Promo Payment Gateway',
            'menu_active'    => 'disburse-promo-pg',
            'submenu_active' => 'disburse-promo-pg-list',
        ];

        if (Session::has('filter-list-rule-promo-pg') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-rule-promo-pg');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-rule-promo-pg');
        }

        $list = MyHelper::post('disburse/rule-promo-payment-gateway', $post);

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

        $data['payment_list'] = MyHelper::post('transaction/available-payment', ['show_all' => 0])['result'] ?? [];

        if ($post) {
            Session::put('filter-list-rule-promo-pg', $post);
        }

        return view('disburse::promo_payment_gateway.list', $data);
    }

    public function create()
    {
        $data = [
            'title'          => 'Rule Promo Payment Gateway',
            'sub_title'      => 'New Rule Promo Payment Gateway',
            'menu_active'    => 'disburse-promo-pg',
            'submenu_active' => 'disburse-promo-pg-new',
        ];
        $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
        $data['payment_list'] = MyHelper::post('transaction/available-payment', ['show_all' => 0])['result'] ?? [];
        return view('disburse::promo_payment_gateway.create', $data);
    }

    public function store(Request $request)
    {
        $post = $request->except('_token');
        $store = MyHelper::post('disburse/rule-promo-payment-gateway/store', $post);
        if (isset($store['status']) && $store['status'] == 'success') {
            return redirect('disburse/rule-promo-payment-gateway')->withSuccess(['Success create rule promo payment gateway']);
        } else {
            return redirect('disburse/rule-promo-payment-gateway/create')->withErrors($store['messages'] ?? ['Failed create rule promo payment gateway'])->withInput();
        }
    }

    public function detail($id)
    {
        $data = [
            'title'          => 'Rule Promo Payment Gateway',
            'sub_title'      => 'Rule Promo Payment Gateway Detail',
            'menu_active'    => 'disburse-promo-pg',
            'submenu_active' => 'disburse-promo-pg-list',
        ];
        $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
        $data['payment_list'] = MyHelper::post('transaction/available-payment', ['show_all' => 0])['result'] ?? [];
        $data['detail'] = MyHelper::post('disburse/rule-promo-payment-gateway/detail', ['id_rule_promo_payment_gateway' => $id])['result'] ?? [];
        $data['summary'] = MyHelper::post('disburse/rule-promo-payment-gateway/summary', ['id_rule_promo_payment_gateway' => $id])['result'] ?? [];
        return view('disburse::promo_payment_gateway.detail', $data);
    }

    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        $post['id_rule_promo_payment_gateway'] = $id;
        $update = MyHelper::post('disburse/rule-promo-payment-gateway/update', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('disburse/rule-promo-payment-gateway/detail/' . $id)->withSuccess(['Success update rule promo payment gateway']);
        } else {
            return redirect('disburse/rule-promo-payment-gateway/detail/' . $id)->withErrors($update['messages'] ?? ['Failed update rule promo payment gateway']);
        }
    }

    public function delete(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('disburse/rule-promo-payment-gateway/delete', $post);
        return $delete;
    }

    public function start(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('disburse/rule-promo-payment-gateway/start', $post);
        return $delete;
    }

    public function markAsValid(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('disburse/rule-promo-payment-gateway/mark-as-valid', $post);
        return $delete;
    }

    public function reportListTransaction(Request $request, $id)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Rule Promo Payment Gateway',
            'sub_title'      => 'Report Transaction Promo Payment Gateway',
            'menu_active'    => 'disburse-promo-pg',
            'submenu_active' => 'disburse-promo-pg-list',
        ];
        $export = 0;
        if (isset($post['export']) && $post['export'] == 1) {
            $export = 1;
        }

        $data['detail'] = MyHelper::post('disburse/rule-promo-payment-gateway/detail', ['id_rule_promo_payment_gateway' => $id])['result'] ?? [];
        $data['summary'] = MyHelper::post('disburse/rule-promo-payment-gateway/summary', ['id_rule_promo_payment_gateway' => $id])['result'] ?? [];
        $listTrx = MyHelper::post('disburse/rule-promo-payment-gateway/report', ['id_rule_promo_payment_gateway' => $id, 'export' => $export, 'page' => $post['page'] ?? 1])['result'] ?? [];

        if ($export == 1) {
            if (isset($listTrx) && !empty($listTrx)) {
                $dt = [
                    'detail' => $data['detail'],
                    'list_trx' => $listTrx,
                    'summary' => $data['summary']
                ];
                return Excel::download(new  ReportRulePromoPaymentGatewayBladeExport($dt), 'list_transaction_promo_payment_gateway_' . date('dmYHis') . '.xls');
            }
            return redirect('disburse/rule-promo-payment-gateway/report/' . $id)->withErrors($update['messages'] ?? ['Failed get data report rule promo payment gateway']);
        } else {
            if (isset($listTrx['data']) && !empty($listTrx['data'])) {
                $data['data']          = $listTrx['data'];
                $data['dataTotal']     = $listTrx['total'];
                $data['dataPerPage']   = $listTrx['from'];
                $data['dataUpTo']      = $listTrx['from'] + count($listTrx['data']) - 1;
                $data['dataPaginator'] = new LengthAwarePaginator($listTrx['data'], $listTrx['total'], $listTrx['per_page'], $listTrx['current_page'], ['path' => url()->current()]);
            } else {
                $data['data']          = [];
                $data['dataTotal']     = 0;
                $data['dataPerPage']   = 0;
                $data['dataUpTo']      = 0;
                $data['dataPaginator'] = false;
            }
            return view('disburse::promo_payment_gateway.report_list_transaction', $data);
        }
    }

    public function validation(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Rule Promo Payment Gateway',
            'sub_title'      => 'Promo Payment Gateway Validation',
            'menu_active'    => 'disburse-promo-pg',
            'submenu_active' => 'disburse-promo-pg-validation',
        ];

        if (empty($post)) {
            $data['list_promo_payment_gateway'] = MyHelper::post('disburse/rule-promo-payment-gateway', ['all_data' => 1])['result'] ?? [];
            return view('disburse::promo_payment_gateway.validation', $data);
        } else {
            if (isset($post['export']) && $post['export'] == 1) {
                $dataExport = MyHelper::post('disburse/rule-promo-payment-gateway/validation/export', $post);

                if (empty($dataExport['result'])) {
                    return redirect('disburse/rule-promo-payment-gateway/validation')->withErrors($dataExport['messages'] ?? ['Failed get data export']);
                }
                $arr['All Type'] = $dataExport['result'];
                $data = new MultisheetExport($arr);
                return Excel::download($data, 'promo_payment_gateway_validation_' . date('dmYHis') . '.xls');
            } elseif ($request->hasFile('import_file')) {
                    $path = $request->file('import_file')->getRealPath();
                    $data = \Excel::toCollection(new FirstSheetOnlyImport(), $request->file('import_file'));
                if (!empty($data)) {
                    //cek format data
                    foreach ($data[0] as $val) {
                        if (!isset($val['id_reference']) || !isset($val['amount'])) {
                            return redirect('disburse/rule-promo-payment-gateway/validation')->withErrors(['Invalid format please check example'])->withInput();
                        }

                        if ($post['validation_cashback_type'] == 'Check Cashback' && !isset($val['cashback'])) {
                            return redirect('disburse/rule-promo-payment-gateway/validation')->withErrors(['Data cashback not found'])->withInput();
                        }

                        if ($post['override_mdr_status'] == 1 && !isset($val['mdr'])) {
                            return redirect('disburse/rule-promo-payment-gateway/validation')->withErrors(['Data mdr not found'])->withInput();
                        }
                    }

                    $post['data'] = $data;
                    $import = MyHelper::post('disburse/rule-promo-payment-gateway/validation/import', $post);
                    if (isset($import['status']) && $import['status'] == 'success') {
                        return redirect('disburse/rule-promo-payment-gateway/validation/report')->withSuccess(['Success upload data']);
                    } else {
                        return redirect('disburse/rule-promo-payment-gateway/validation')->withErrors($import['messages'] ?? ['Failed import data'])->withInput();
                    }
                }
            }

            return redirect('disburse/rule-promo-payment-gateway/validation')->withErrors(['No action']);
        }
    }

    public function validationReport(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Rule Promo Payment Gateway',
            'sub_title'      => 'Rule Promo Payment Gateway Validation Report',
            'menu_active'    => 'disburse-promo-pg',
            'submenu_active' => 'disburse-promo-pg-validation-report',
        ];
        if (Session::has('filter-list-promo-pg-validation') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-promo-pg-validation');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-promo-pg-validation');
        }

        $list = MyHelper::post('disburse/rule-promo-payment-gateway/validation/report', $post);

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
            Session::put('filter-list-promo-pg-validation', $post);
        }

        $data['list_promo_payment_gateway'] = MyHelper::post('disburse/rule-promo-payment-gateway', ['all_data' => 1])['result'] ?? [];

        return view('disburse::promo_payment_gateway.validation_report', $data);
    }

    public function validationReportDetail($id)
    {
        $data = [
            'title'          => 'Rule Promo Payment Gateway',
            'sub_title'      => 'Rule Promo Payment Gateway Validation Report Detail',
            'menu_active'    => 'disburse-promo-pg',
            'submenu_active' => 'disburse-promo-pg-validation-report',
        ];
        $detail = MyHelper::post('disburse/rule-promo-payment-gateway/validation/report/detail', ['id_promo_payment_gateway_validation' => $id]);
        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data['detail'] = $detail['result'];
            return view('disburse::promo_payment_gateway.validation_report_detail', $data);
        } else {
            return redirect('disburse/rule-promo-payment-gateway/validation/report')->withErrors($update['messages'] ?? ['Failed get detail validation']);
        }
    }

    public function validationTemplate()
    {
        $arr['All Type'] = [
            [
                'id_reference' => '0000001',
                'amount' => 50000,
                'cashback' => 5000,
                'mdr' => 500
            ],
            [
                'id_reference' => '0000002',
                'amount' => 60000,
                'cashback' => 4000,
                'mdr' => 100
            ],
            [
                'id_reference' => '0000003',
                'amount' => 50000,
                'cashback' => 3000,
                'mdr' => 125
            ],
            [
                'id_reference' => '0000004',
                'amount' => 100000,
                'cashback' => 5000,
                'mdr' => 500
            ],
        ];
        $data = new MultisheetExport($arr);
        return Excel::download($data, 'template validation promo payment gateway.xls');
    }

    public function promoPaymentGatewayListTransaction(Request $request)
    {
        $post = $request->except('_token');

        $data = [
            'title'          => 'Rule Promo Payment Gateway',
            'sub_title'      => 'Rule Promo Payment Gateway List Transaction',
            'menu_active'    => 'disburse-promo-pg',
            'submenu_active' => 'disburse-promo-pg-list-trx'
        ];
        if (Session::has('filter-list-promo-pg-list-trx') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-promo-pg-list-trx');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-promo-pg-list-trx');
        }

        $list = MyHelper::post('disburse/rule-promo-payment-gateway/report', $post);

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
            Session::put('filter-list-promo-pg-list-trx', $post);
        }

        $data['list_promo_payment_gateway'] = MyHelper::post('disburse/rule-promo-payment-gateway', ['all_data' => 1])['result'] ?? [];

        return view('disburse::promo_payment_gateway.list_transaction', $data);
    }

    public function downloadFile($id)
    {
        $data = MyHelper::post('disburse/rule-promo-payment-gateway/validation/report/detail', ['id_promo_payment_gateway_validation' => $id]);

        if (isset($data['status']) && $data['status'] == 'success') {
            $filename = 'validation_promo_pg_' . strtotime(date('Ymdhis')) . '.xlsx';
            $tempImage = tempnam(sys_get_temp_dir(), $filename);
            copy($data['result']['file'], $tempImage);
            return response()->download($tempImage, $filename)->deleteFileAfterSend(true);
        } else {
            return redirect('disburse/rule-promo-payment-gateway/validation/report/detail/' . $id)->withErrors(['File not found']);
        }
    }
}
