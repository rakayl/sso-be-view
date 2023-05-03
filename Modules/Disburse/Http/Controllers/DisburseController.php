<?php

namespace Modules\Disburse\Http\Controllers;

use App\Exports\MultisheetExport;
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

class DisburseController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $id_user_franchise = Session::get('id_user_franchise');
            if (!is_null($id_user_franchise)) {
                $this->baseuri = 'disburse/user-franchise';
            } else {
                $this->baseuri = 'disburse';
            }
            return $next($request);
        });
    }

    public function loginUserFranchise(Request $request)
    {
        $post = $request->except('_token');
        if (
            isset($post['username']) && !empty($post['username']) &&
            isset($post['password']) && !empty($post['password'])
        ) {
            $captcha = GoogleReCaptchaV3::verifyResponse($request->input('g-recaptcha-response'))->isSuccess();
            if (!$captcha) {
                return redirect()->back()->withErrors(['Recaptcha failed']);
            }


            if (strlen($request->input('password')) != 6) {
                return redirect('disburse/login')->withErrors(['Pin must be 6 digits' => 'Pin must be 6 digits'])->withInput();
            }

            $postLogin =  MyHelper::postLoginUserFranchise($request);

            if (isset($postLogin['error'])) {
                return redirect('disburse/login')->withErrors(['Invalid username / password'])->withInput();
            } else {
                if (isset($postLogin['status']) && $postLogin['status'] == "fail") {
                    return redirect('disburse/login')->withErrors(['Failed Login'])->withInput();
                } else {
                    session([
                        'access_token'  => 'Bearer ' . $postLogin['access_token'],
                        'username'      => $request->input('username'),
                    ]);

                    $userFranchise = MyHelper::post('disburse/user-franchise/detail', ['phone' => $request->input('username')]);

                    if (isset($userFranchise['status']) && $userFranchise['status'] == 'success') {
                        session([
                            'id_user_franchise'      => $userFranchise['result']['id_user_franchise'],
                            'username-franchise'   => $userFranchise['result']['phone'],
                            'phone-franchise'   => $userFranchise['result']['phone'],
                            'email-franchise'   => $userFranchise['result']['email'],
                            'granted_features'  => [234]
                        ]);
                        return redirect('disburse/user-franchise/dashboard');
                    } else {
                        return redirect('disburse/login')->withErrors(['User does not exist'])->withInput();
                    }
                }
            }
        } else {
            return redirect('disburse/login')->withErrors(['Incompleted Parameter'])->withInput();
        }
    }

    public function resetPassword(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Disburse',
            'sub_title'      => 'Disburse Reset Password',
            'menu_active'    => 'disburse-reset-password',
            'submenu_active' => 'disburse-reset-password'
        ];

        if ($post) {
            $post['id_user_franchise'] = session('id_user_franchise');
            $update = MyHelper::post('disburse/user-franchise/reset-password', $post);

            if (isset($update['status']) && $update['status'] == 'success') {
                $a = session('success')['s'];
                session()->flush();
                if ($a) {
                    session(['success' => ['s' => $a]]);
                }
                return redirect('disburse/login')->withSuccess(['Reset PIN success, pelase re-login']);
            } else {
                return redirect('disburse/user-franchise/reset-password')->withErrors([$update['message']]);
            }
        } else {
            return view('disburse::password', $data);
        }
    }

    public function dashboard(Request $request)
    {
        $post = $request->all();
        if (!empty($post)) {
            $post['id_user_franchise'] = session('id_user_franchise');
            $getData = MyHelper::post($this->baseuri . '/dashboard', $post);

            if (isset($getData['status']) && $getData['status'] == 'success') {
                $data['status'] = 'success';
                $data['pending'] = [
                    'nominal_success' => $getData['result']['pending']['nominal']['nom_success'],
                    'nominal_fail' => $getData['result']['pending']['nominal_fail']['disburse_nominal'] ?? 0,
                    'total_income_central' => $getData['result']['pending']['income_central'],
                    'total_disburse' => $getData['result']['pending']['total_disburse'],

                    'nominal_item' => $getData['result']['pending']['nominal']['nominal']['nom_item'] ?? 0,
                    'nominal_grandtotal' => $getData['result']['pending']['nominal']['nominal']['nom_grandtotal'] ?? 0,
                    'nominal_expense_central' => $getData['result']['pending']['nominal']['nominal']['nom_expense_central'] ?? 0,
                    'nominal_delivery' => $getData['result']['pending']['nominal']['nominal']['nom_delivery'] ?? 0,

                    'format_nominal_item' => number_format($getData['result']['pending']['nominal']['nom_item'], 2),
                    'format_nominal_grandtotal' => number_format($getData['result']['pending']['nominal']['nom_grandtotal'], 2),
                    'format_nominal_expense_central' => number_format($getData['result']['pending']['nominal']['nom_expense_central'], 2),
                    'format_nominal_delivery' => number_format($getData['result']['pending']['nominal']['nom_delivery'], 2),
                    'format_nominal_success' => number_format($getData['result']['pending']['nominal']['nom_success'], 2),
                    'format_nominal_fail' => number_format($getData['result']['pending']['nominal_fail']['disburse_nominal'] ?? 0, 2),
                    'format_total_income_central' => number_format($getData['result']['pending']['income_central'], 2),
                    'format_total_disburse' => number_format($getData['result']['pending']['total_disburse'], 2)
                ];
                $data['processed'] = [
                    'nominal_success' => $getData['result']['processed']['nominal']['nom_success'],
                    'nominal_fail' => $getData['result']['processed']['nominal_fail']['disburse_nominal'] ?? 0,
                    'total_income_central' => $getData['result']['processed']['income_central'],
                    'total_disburse' => $getData['result']['processed']['total_disburse'],

                    'nominal_item' => $getData['result']['processed']['nominal']['nominal']['nom_item'] ?? 0,
                    'nominal_grandtotal' => $getData['result']['processed']['nominal']['nominal']['nom_grandtotal'] ?? 0,
                    'nominal_expense_central' => $getData['result']['processed']['nominal']['nominal']['nom_expense_central'] ?? 0,
                    'nominal_delivery' => $getData['result']['processed']['nominal']['nominal']['nom_delivery'] ?? 0,

                    'format_nominal_item' => number_format($getData['result']['processed']['nominal']['nom_item'], 2),
                    'format_nominal_grandtotal' => number_format($getData['result']['processed']['nominal']['nom_grandtotal'], 2),
                    'format_nominal_expense_central' => number_format($getData['result']['processed']['nominal']['nom_expense_central'], 2),
                    'format_nominal_delivery' => number_format($getData['result']['processed']['nominal']['nom_delivery'], 2),
                    'format_nominal_success' => number_format($getData['result']['processed']['nominal']['nom_success'], 2),
                    'format_nominal_fail' => number_format($getData['result']['processed']['nominal_fail']['disburse_nominal'] ?? 0, 2),
                    'format_total_income_central' => number_format($getData['result']['processed']['income_central'], 2),
                    'format_total_disburse' => number_format($getData['result']['processed']['total_disburse'], 2)
                ];
            } else {
                $data['status'] = 'fail';
            }
            return response()->json($data);
        } else {
            $data = [
                'title'          => 'Disburse',
                'sub_title'      => 'Disburse Dashboard',
                'menu_active'    => 'disburse-dashboard',
                'submenu_active' => 'disburse-dashboard'
            ];

            $getData = MyHelper::post($this->baseuri . '/dashboard', ['id_user_franchise' => session('id_user_franchise')]);

            if (isset($getData['status']) && $getData['status'] == 'success') {
                $data['pending'] = [
                    'nominal_success' => $getData['result']['pending']['nominal']['nom_success'] ?? 0,
                    'nominal_item' => $getData['result']['pending']['nominal']['nom_item'] ?? 0,
                    'nominal_grandtotal' => $getData['result']['pending']['nominal']['nom_grandtotal'] ?? 0,
                    'nominal_expense_central' => $getData['result']['pending']['nominal']['nom_expense_central'] ?? 0,
                    'nominal_delivery' => $getData['result']['pending']['nominal']['nom_delivery'] ?? 0,

                    'nominal_fail' => $getData['result']['pending']['nominal_fail']['disburse_nominal'] ?? 0,
                    'total_income_central' => $getData['result']['pending']['income_central'],
                    'total_disburse' => $getData['result']['pending']['total_disburse']
                ];

                $data['processed'] = [
                    'nominal_success' => $getData['result']['processed']['nominal']['nom_success'] ?? 0,
                    'nominal_item' => $getData['result']['processed']['nominal']['nom_item'] ?? 0,
                    'nominal_grandtotal' => $getData['result']['processed']['nominal']['nom_grandtotal'] ?? 0,
                    'nominal_expense_central' => $getData['result']['processed']['nominal']['nom_expense_central'] ?? 0,
                    'nominal_delivery' => $getData['result']['processed']['nominal']['nom_delivery'] ?? 0,

                    'nominal_fail' => $getData['result']['processed']['nominal_fail']['disburse_nominal'] ?? 0,
                    'total_income_central' => $getData['result']['processed']['income_central'],
                    'total_disburse' => $getData['result']['processed']['total_disburse']
                ];
            } else {
                $data['nominal_success'] = 0;
                $data['nominal_item'] = 0;
                $data['nominal_grandtotal'] = 0;
                $data['nominal_expense_central'] = 0;
                $data['nominal_delivery'] = 0;
                $data['nominal_fail'] = 0;
                $data['total_income_central'] = 0;
                $data['total_disburse'] = 0;
                $data['pending'] = $data;
                $data['processed'] = $data;
            }

            $outlets = MyHelper::post($this->baseuri . '/outlets', $post);
            if (isset($getData['status']) && $getData['status'] == 'success') {
                $data['outlets'] = $outlets['result'];
            } else {
                $data['outlets'] = [];
            }

            return view('disburse::dashboard', $data);
        }
    }

    public function listDisburseDataTable(Request $request, $status)
    {
        $post = $request->all();
        $draw = $post["draw"];
        $post['id_user_franchise'] = session('id_user_franchise');

        $getDisburse = MyHelper::post($this->baseuri . '/list-datatable/fail', $post);
        if (isset($getDisburse['status']) && isset($getDisburse['status']) == 'success') {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $getDisburse['total'];
            $arr_result['recordsFiltered'] = $getDisburse['total'];
            $arr_result['data'] = $getDisburse['result'];
        } else {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }

        return response()->json($arr_result);
    }

    public function getOutlets(Request $request)
    {
        $post = $request->all();
        $post['id_user_franchise'] = session('id_user_franchise');

        $outlets = MyHelper::post($this->baseuri . '/outlets', $post);
        return response()->json($outlets);
    }

    public function listTrx(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Disburse',
            'sub_title'      => 'List Transactions',
            'menu_active'    => 'disburse-list-trx',
            'submenu_active' => 'disburse-list-trx'
        ];

        if (Session::has('filter-list-disburse-trx') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-disburse-trx');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-disburse-trx');
        }

        $post['id_user_franchise'] = session('id_user_franchise');
        $getTrx = MyHelper::post($this->baseuri . '/list/trx', $post);

        if (isset($getTrx['status']) && $getTrx['status'] == "success") {
            $data['trx']          = $getTrx['result']['data'];
            $data['trxTotal']     = $getTrx['result']['total'];
            $data['trxPerPage']   = $getTrx['result']['from'];
            $data['trxUpTo']      = $getTrx['result']['from'] + count($getTrx['result']['data']) - 1;
            $data['trxPaginator'] = new LengthAwarePaginator($getTrx['result']['data'], $getTrx['result']['total'], $getTrx['result']['per_page'], $getTrx['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['trx']          = [];
            $data['trxTotal']     = 0;
            $data['trxPerPage']   = 0;
            $data['trxUpTo']      = 0;
            $data['trxPaginator'] = false;
        }

        if ($post) {
            Session::put('filter-list-disburse-trx', $post);
        }
        return view('disburse::disburse.list_trx', $data);
    }

    public function listDisburse(Request $request, $status, $id_disburse = null)
    {
        $post = $request->all();
        $exportStatus = 0;
        if (isset($post['export'])) {
            $exportStatus = 1;
        }

        $data = [
            'title'          => 'Disburse',
            'sub_title'      => 'List Disburse ' . ucfirst($status),
            'menu_active'    => 'disburse-list-' . $status,
            'submenu_active' => 'disburse-list-' . $status,
            'status' => $status
        ];

        if (Session::has('filter-list-disburse') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-disburse');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-disburse');
        }

        $post['export'] = $exportStatus;
        $post['id_user_franchise'] = session('id_user_franchise');
        $post['id_disburse'] = $id_disburse;
        $getDisburse = MyHelper::post($this->baseuri . '/list/' . $status, $post);

        if ($exportStatus == 1) {
            if (isset($getDisburse['status']) && $getDisburse['status'] == "success") {
                $arr['All Type'] = $getDisburse['result'];
                $data = new MultisheetExport($arr);
                return Excel::download($data, 'disburse_' . date('dmYHis') . '.xls');
            } else {
                return redirect('disburse/list/' . $status)->withErrors(['No data to export']);
            }
        } else {
            if (isset($getDisburse['status']) && $getDisburse['status'] == "success") {
                $data['disburse']          = $getDisburse['result']['data'];
                $data['disburseTotal']     = $getDisburse['result']['total'];
                $data['disbursePerPage']   = $getDisburse['result']['from'];
                $data['disburseUpTo']      = $getDisburse['result']['from'] + count($getDisburse['result']['data']) - 1;
                $data['disbursePaginator'] = new LengthAwarePaginator($getDisburse['result']['data'], $getDisburse['result']['total'], $getDisburse['result']['per_page'], $getDisburse['result']['current_page'], ['path' => url()->current()]);
            } else {
                $data['disburse']          = [];
                $data['disburseTotal']     = 0;
                $data['disbursePerPage']   = 0;
                $data['disburseUpTo']      = 0;
                $data['disbursePaginator'] = false;
            }

            $bank = MyHelper::post($this->baseuri . '/bank', $post);
            if (isset($bank['status']) && $bank['status'] == 'success') {
                $data['banks'] = $bank['result'];
            } else {
                $data['banks'] = [];
            }

            if ($post) {
                Session::put('filter-list-disburse', $post);
            }

            return view('disburse::disburse.list', $data);
        }
    }

    public function listDisburseFailAction(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Disburse',
            'sub_title'      => 'List Disburse Fail',
            'menu_active'    => 'disburse-list-fail-action',
            'submenu_active' => 'disburse-list-fail-action',
            'status' => 'fail-action'
        ];

        if (Session::has('filter-list-disburse-fail') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-disburse-fail');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-disburse-fail');
        }

        $post['id_user_franchise'] = session('id_user_franchise');
        $getDisburse = MyHelper::post($this->baseuri . '/list/fail-action', $post);

        if (isset($getDisburse['status']) && $getDisburse['status'] == "success") {
            $data['disburse']          = $getDisburse['result']['data'];
            $data['disburseTotal']     = $getDisburse['result']['total'];
            $data['disbursePerPage']   = $getDisburse['result']['from'];
            $data['disburseUpTo']      = $getDisburse['result']['from'] + count($getDisburse['result']['data']) - 1;
            $data['disbursePaginator'] = new LengthAwarePaginator($getDisburse['result']['data'], $getDisburse['result']['total'], $getDisburse['result']['per_page'], $getDisburse['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['disburse']          = [];
            $data['disburseTotal']     = 0;
            $data['disbursePerPage']   = 0;
            $data['disburseUpTo']      = 0;
            $data['disbursePaginator'] = false;
        }

        $bank = MyHelper::post($this->baseuri . '/bank', $post);
        if (isset($bank['status']) && $bank['status'] == 'success') {
            $data['banks'] = $bank['result'];
        } else {
            $data['banks'] = [];
        }

        if ($post) {
            Session::put('filter-list-disburse-fail', $post);
        }

        return view('disburse::disburse.list_fail', $data);
    }

    public function detailDisburseTrx(Request $request, $id)
    {
        $post = $request->all();
        $exportStatus = 0;
        if (isset($post['export'])) {
            $exportStatus = 1;
        }
        $data = [
            'title'          => 'Disburse',
            'sub_title'      => 'Detail Disburse',
            'menu_active'    => '',
            'submenu_active' => ''
        ];

        $post['export'] = $exportStatus;
        $getDisburse = MyHelper::post($this->baseuri . '/detail/' . $id, $post);

        if ($exportStatus == 1) {
            if (isset($getDisburse['status']) && $getDisburse['status'] == "success") {
                $dis = $getDisburse['result']['data_disburse'];
                return Excel::download(new  DisburseDetailBladeExport($getDisburse['result']), '(' . $dis['outlet_code'] . ')disburse_detail_trx_' . date('dmYHis') . '.xls');
            } else {
                return redirect('disburse/detail-trx/' . $id)->withErrors(['No data to export']);
            }
        } else {
            if (isset($getDisburse['status']) && $getDisburse['status'] == "success") {
                $data['trx']          = $getDisburse['result']['list_trx']['data'];
                $data['trxTotal']     = $getDisburse['result']['list_trx']['total'];
                $data['trxPerPage']   = $getDisburse['result']['list_trx']['from'];
                $data['trxUpTo']      = $getDisburse['result']['list_trx']['from'] + count($getDisburse['result']['list_trx']['data']) - 1;
                $data['trxPaginator'] = new LengthAwarePaginator($getDisburse['result']['list_trx']['data'], $getDisburse['result']['list_trx']['total'], $getDisburse['result']['list_trx']['per_page'], $getDisburse['result']['list_trx']['current_page'], ['path' => url()->current()]);
                $data['disburse'] = $getDisburse['result']['data_disburse'];
            } else {
                $data['trx']          = [];
                $data['trxTotal']     = 0;
                $data['trxPerPage']   = 0;
                $data['trxUpTo']      = 0;
                $data['trxPaginator'] = false;
                $data['disburse'] = [];
            }

            return view('disburse::disburse.detail', $data);
        }
    }

    public function userFranchise(Request $request)
    {
        $post = $request->all();
        $post['id_user_franchise'] = session('id_user_franchise');

        $user = MyHelper::post($this->baseuri . '/user-franchise', $post);
        return response()->json($user);
    }

    public function updateStatusDisburse(Request $request, $id)
    {
        $post = $request->all();
        $post['disburse_status'] = 'Retry From Failed';
        $post['id'] = $id;
        $update = MyHelper::post($this->baseuri . '/update-status', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('disburse/list/all')->withSuccess(['Success update status']);
        } else {
            return redirect('disburse/list/fail')->withErrors(['Failed update status']);
        }
    }

    public function listCalculationDataTable(Request $request)
    {
        $post = $request->all();
        $draw = $post["draw"];
        $post['id_user_franchise'] = session('id_user_franchise');

        $getDisburse = MyHelper::post($this->baseuri . '/list-datatable/calculation', $post);
        if (isset($getDisburse['status']) && isset($getDisburse['status']) == 'success') {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $getDisburse['total'];
            $arr_result['recordsFiltered'] = $getDisburse['total'];
            $arr_result['data'] = $getDisburse['result'];
        } else {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }

        return response()->json($arr_result);
    }
}
