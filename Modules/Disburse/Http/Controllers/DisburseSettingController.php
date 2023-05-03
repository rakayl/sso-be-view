<?php

namespace Modules\Disburse\Http\Controllers;

use App\Exports\MultisheetExport;
use App\Imports\FirstSheetOnlyImport;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Excel;

class DisburseSettingController extends Controller
{
    public function __construct()
    {
        $id_user_franchise = Session::get('id_user_franchise');
        if (!is_null($id_user_franchise)) {
            $this->baseuri = 'disburse/user-franchise';
        } else {
            $this->baseuri = 'disburse';
        }
    }

    public function editBankAccount(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Settings',
            'sub_title'      => 'Setting Bank Account',
            'menu_active'    => 'disburse-settings',
            'submenu_active' => 'disburse-setting-edit-bank-account'
        ];

        if (Session::has('filter-disburse-list-outlet') && !empty($post) && !isset($post['filter'])) {
            $post = Session::get('filter-disburse-list-outlet');
        } else {
            Session::forget('filter-disburse-list-outlet');
        }

        if ($request->get('page')) {
            $post['page'] = $request->get('page');
        } else {
            $post['page'] = 1;
        }
        $dataBank = MyHelper::post('disburse/setting/list-bank-account', $post);
        if (isset($dataBank['status']) && $dataBank['status'] == 'success') {
            $data['outlet_dont_have_account'] = [];
            if (!empty($dataBank['result']['list_outlet_dont_have_account'])) {
                $data['outlet_dont_have_account'] = $dataBank['result']['list_outlet_dont_have_account'];
            }

            if (!empty($dataBank['result']['list_bank']['data'])) {
                $data['bankAccount']          = $dataBank['result']['list_bank']['data'];
                $data['bankAccountTotal']     = $dataBank['result']['list_bank']['total'];
                $data['bankAccountPerPage']   = $dataBank['result']['list_bank']['from'];
                $data['bankAccountUpTo']      = $dataBank['result']['list_bank']['from'] + count($dataBank['result']['list_bank']['data']) - 1;
                $data['bankAccountPaginator'] = new LengthAwarePaginator($dataBank['result']['list_bank']['data'], $dataBank['result']['list_bank']['total'], $dataBank['result']['list_bank']['per_page'], $dataBank['result']['list_bank']['current_page'], ['path' => url()->current()]);
            } else {
                $data['bankAccount']          = [];
                $data['bankAccountTotal']     = 0;
                $data['bankAccountPerPage']   = 0;
                $data['bankAccountUpTo']      = 0;
                $data['bankAccountPaginator'] = false;
            }
        } else {
            $data['bankAccount']          = [];
            $data['bankAccountTotal']     = 0;
            $data['bankAccountPerPage']   = 0;
            $data['bankAccountUpTo']      = 0;
            $data['bankAccountPaginator'] = false;
        }

        $bank = MyHelper::post('disburse/bank', $post);
        if (isset($bank['status']) && $bank['status'] == 'success') {
            $data['bank'] = $bank['result'];
        } else {
            $data['bank'] = [];
        }

        $outlets = MyHelper::post('disburse/outlets', ['for' => 'select2']);

        if (isset($outlets['status']) && $outlets['status'] == 'success') {
            $data['outlets'] = $outlets['result'];
        } else {
            $data['outlets'] = [];
        }

        if ($post) {
            Session::put('filter-disburse-list-outlet', $post);
        }
        return view('disburse::setting_bank_account.edit', $data);
    }

    public function bankAccountUpdate(Request $request)
    {
        $post = $request->all();

        if ($post) {
            $udpateSetting = MyHelper::post('disburse/setting/edit-bank-account', $post);
            if (isset($udpateSetting['status']) && $udpateSetting['status'] == 'success') {
                return redirect('disburse/setting/edit-bank-account')->withSuccess(['Success Update Data']);
            } else {
                return redirect('disburse/setting/edit-bank-account')->withErrors([$udpateSetting['message']]);
            }
        }
    }

    public function bankAccount(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Settings',
            'sub_title'      => 'Setting Bank Account',
            'menu_active'    => 'disburse-settings',
            'submenu_active' => 'disburse-setting-add-bank-account'
        ];

        if ($post) {
            $storeSetting = MyHelper::post('disburse/setting/bank-account', $post);
            if (isset($storeSetting['status']) && $storeSetting['status'] == 'success') {
                return redirect('disburse/setting/bank-account#add')->withSuccess(['Success Add Bank Account Data']);
            } else {
                return redirect('disburse/setting/bank-account#add')->withErrors([$storeSetting['message']]);
            }
        } else {
            $bank = MyHelper::post('disburse/bank', $post);
            if (isset($bank['status']) && $bank['status'] == 'success') {
                $data['bank'] = $bank['result'];
            } else {
                $data['bank'] = [];
            }

            $outlets = MyHelper::post('disburse/outlets', ['for' => 'select2']);

            if (isset($outlets['status']) && $outlets['status'] == 'success') {
                $data['outlets'] = $outlets['result'];
            } else {
                $data['outlets'] = [];
            }

            return view('disburse::setting_bank_account.add', $data);
        }
    }

    public function deleteBankAccount(Request $request)
    {
        $post = $request->all();
        $delete = MyHelper::post('disburse/setting/delete-bank-account', $post);
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    public function exportListBank(Request $request)
    {
        $bank = MyHelper::get('disburse/bank');
        if (isset($bank['status']) && $bank['status'] == 'success') {
            $arr['All Type'] = [];
            foreach ($bank['result'] as $value) {
                $dt = [
                    'bank_code' => $value['bank_code'],
                    'bank_name' => $value['bank_name']
                ];
                $arr['All Type'][] = $dt;
            }
            $data = new MultisheetExport($arr);
            return Excel::download($data, 'list_bank.xls');
        } else {
            return redirect('disburse/setting/bank-account#export-import')->withErrors(['Failed Get Data List Bank']);
        }
    }

    public function exportBankAccoutOutlet(Request $request)
    {
        $outlet =  MyHelper::get('disburse/outlets');
        if (isset($outlet['status']) && $outlet['status'] == 'success') {
            $arr['All Type'] = [];
            foreach ($outlet['result'] as $value) {
                $dt = [
                    'outlet_code' => $value['outlet_code'],
                    'outlet_name' => $value['outlet_name'],
                    'bank_code' => $value['bank_code'],
                    'beneficiary_name' => $value['beneficiary_name'],
                    'beneficiary_alias' => $value['beneficiary_alias'],
                    'beneficiary_account' => ' ' . $value['beneficiary_account'],
                    'beneficiary_email' => $value['beneficiary_email']
                ];
                $arr['All Type'][] = $dt;
            }
            $data = new MultisheetExport($arr);
            return Excel::download($data, 'janji_jiwa_bank_accout_outlet_' . date('dmYHis') . '.xls');
        } else {
            return redirect('disburse/setting/bank-account#export-import')->withErrors(['Failed Get Data List Bank']);
        }
    }

    public function importBankAccoutOutlet(Request $request)
    {
        $post = $request->except('_token');

        if ($request->file('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $name = $request->file('import_file')->getClientOriginalName();
            $dataimport = Excel::toArray(new FirstSheetOnlyImport(), $request->file('import_file'));
            $dataimport = array_map(function ($x) {
                return (object)$x;
            }, $dataimport[0] ?? []);
            $save = MyHelper::post('disburse/setting/import-bank-account-outlet', ['data_import' => $dataimport]);
            if (isset($save['status']) && $save['status'] == "success") {
                if (!empty($save['data_failed'])) {
                    return redirect('disburse/setting/bank-account#export-import')->withErrors($save['data_failed'])->withInput();
                }

                $message = ['Success import ' . count($save['data_success'])];
                return redirect('disburse/setting/bank-account#export-import')->withSuccess($message);
            } else {
                if (isset($save['errors'])) {
                    return redirect('disburse/setting/bank-account#export-import')->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }
                return redirect('disburse/setting/bank-account#export-import')->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
            return redirect('disburse/setting/bank-account#export-import')->withErrors(['Something when wrong. Please try again.'])->withInput();
        } else {
            return redirect('disburse/setting/bank-account#export-import')->withErrors(['File is required.'])->withInput();
        }
    }

    public function mdr(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Settings',
            'sub_title'      => 'Merchan Discount Rate (MDR)',
            'menu_active'    => 'disburse-settings',
            'submenu_active' => 'disburse-setting-mdr'
        ];

        if ($post) {
            $storeSetting = MyHelper::post('disburse/setting/mdr', $post);
            if (isset($storeSetting['status']) && $storeSetting['status'] == 'success') {
                return redirect('disburse/setting/mdr')->withSuccess(['Success Update Data']);
            } else {
                return redirect('disburse/setting/mdr')->withErrors(['Failed Update Data']);
            }
        } else {
            $mdr = MyHelper::get('disburse/setting/mdr');
            if (isset($mdr['status']) && $mdr['status'] == 'success') {
                $data['mdr'] = $mdr['result']['mdr'];
            } else {
                $data['mdr'] = [];
            }

            return view('disburse::setting_mdr.setting', $data);
        }
    }

    public function mdrGlobal(Request $request)
    {
        $post = $request->all();
        $updateSetting = MyHelper::post('disburse/setting/mdr-global', $post);

        if (isset($updateSetting['status']) && $updateSetting['status'] == 'success') {
            return redirect('disburse/setting/mdr')->withSuccess(['Success Update Data MDR Global']);
        } else {
            return redirect('disburse/setting/mdr')->withErrors(['Failed Update Data MDR Global']);
        }
    }

    public function settingGlobal()
    {
        $data = [
            'title'          => 'Settings',
            'sub_title'      => 'Setting Global',
            'menu_active'    => 'disburse-settings',
            'submenu_active' => 'disburse-setting-global'
        ];
        $fee = MyHelper::get('disburse/setting/fee-global');
        if (isset($fee['status']) && $fee['status'] == 'success') {
            $data['fee'] = $fee['result'];
        } else {
            $data['fee'] = [];
        }


        $outlets = MyHelper::post($this->baseuri . '/outlets', []);
        if (isset($outlets['status']) && $outlets['status'] == 'success') {
            $data['outlets'] = $outlets['result'];
        } else {
            $data['outlets'] = [];
        }

        $approver = MyHelper::get('disburse/setting/approver');
        if (isset($approver['status']) && $approver['status'] == 'success') {
            $data['approver'] = $approver['result'];
        } else {
            $data['approver'] = [];
        }

        $feePorductPlastic = MyHelper::get('disburse/setting/fee-product-plastic');
        if (isset($feePorductPlastic['status']) && $feePorductPlastic['status'] == 'success') {
            $data['fee_product_plastic'] = $feePorductPlastic['result'];
        } else {
            $data['fee_product_plastic'] = [];
        }

        $timeToSent = MyHelper::get('disburse/setting/time-to-sent');
        if (isset($timeToSent['status']) && $timeToSent['status'] == 'success') {
            $data['time_to_sent'] = $timeToSent['result'];
        } else {
            $data['time_to_sent'] = [];
        }

        $feeDisburse = MyHelper::get('disburse/setting/fee-disburse');
        if (isset($feeDisburse['status']) && $feeDisburse['status'] == 'success') {
            $data['fee_disburse'] = $feeDisburse['result'];
        } else {
            $data['fee_disburse'] = [];
        }

        $sendEmailTo = MyHelper::get('disburse/setting/send-email-to');
        if (isset($sendEmailTo['status']) && $sendEmailTo['status'] == 'success') {
            $data['send_email_to'] = (array)json_decode($sendEmailTo['result']['value_text']);
        } else {
            $data['send_email_to'] = [];
        }

        return view('disburse::setting_global.setting', $data);
    }
    public function feeGlobal(Request $request)
    {
        $post = $request->all();

        $update = MyHelper::post('disburse/setting/fee-global', $post);
        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('disburse/setting/global#fee')->withSuccess(['Success Update Fee Global']);
        } else {
            return redirect('disburse/setting/global#fee')->withErrors(['Failed Update Fee Global']);
        }
    }

    public function pointChargedGlobal(Request $request)
    {
        $post = $request->all();

        $update = MyHelper::post('disburse/setting/point-charged-global', $post);
        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('disburse/setting/global#point')->withSuccess(['Success Update Fee Global']);
        } else {
            return redirect('disburse/setting/global#point')->withErrors([$update['message']]);
        }
    }

    public function listOutletAjax(Request $request)
    {
        $post = $request->except('_token');
        $draw = $post["draw"];
        $list = MyHelper::post('disburse/setting/fee-outlet-special/outlets', $post);

        if (isset($list['status']) && isset($list['status']) == 'success') {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $list['total'];
            $arr_result['recordsFiltered'] = $list['total'];
            $arr_result['data'] = $list['result'];
        } else {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }
        return response()->json($arr_result);
    }

    public function listOutletNotSpecialAjax(Request $request)
    {
        $post = $request->except('_token');
        $draw = $post["draw"];
        $list = MyHelper::post('disburse/setting/fee-outlet-special/outlets-not-special', $post);

        if (isset($list['status']) && isset($list['status']) == 'success') {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $list['total'];
            $arr_result['recordsFiltered'] = $list['total'];
            $arr_result['data'] = $list['result'];
        } else {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }
        return response()->json($arr_result);
    }

    public function settingFeeOutletSpecial(Request $request)
    {
        $post = $request->except('_token');

        if ($post['id_outlet'] != 'all') {
            $post['id_outlet'] = explode(',', $post['id_outlet']);
        }
        $update = MyHelper::post('disburse/setting/fee-outlet-special/update', $post);
        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('disburse/setting/global#fee-special-outlet')->withSuccess(['Success Update Fee Special Outlet']);
        } else {
            return redirect('disburse/setting/global#fee-special-outlet')->withErrors([$update['messages']]);
        }
    }

    public function settingSpecialOutlet(Request $request)
    {
        $post = $request->except('_token');
        $post['id_outlet'] = explode(',', $post['id_outlet']);
        $save = MyHelper::post('disburse/setting/outlet-special', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            $data = ['status' => 'success'];
        } else {
            $data = ['status' => 'fail'];
            if (isset($save['messages'])) {
                $data['messages'] = $save['messages'];
            }
        }
        return response()->json($save);
    }

    public function settingApprover(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['approver'])) {
            $data['value'] = 1;
        } else {
            $data['value'] = 0;
        }
        $save = MyHelper::post('disburse/setting/approver', $data);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('disburse/setting/global#approver')->withSuccess(['Success Update Data']);
        } else {
            return redirect('disburse/setting/global#approver')->withErrors(['Failed Update Data']);
        }
    }

    public function settingFeeProductPlastic(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['fee_product_plastic'])) {
            $data['value'] = 1;
        } else {
            $data['value'] = 0;
        }
        $save = MyHelper::post('disburse/setting/fee-product-plastic', $data);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('disburse/setting/global#fee-product-plastic')->withSuccess(['Success Update Data']);
        } else {
            return redirect('disburse/setting/global#fee-product-plastic')->withErrors(['Failed Update Data']);
        }
    }

    public function settingTimeToSent(Request $request)
    {
        $post = $request->except('_token');

        $save = MyHelper::post('disburse/setting/time-to-sent', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('disburse/setting/global#time-to-sent')->withSuccess(['Success Update Data']);
        } else {
            return redirect('disburse/setting/global#time-to-sent')->withErrors(['Failed Update Data']);
        }
    }

    public function settingFeeDisburse(Request $request)
    {
        $post = $request->except('_token');

        $save = MyHelper::post('disburse/setting/fee-disburse', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('disburse/setting/global#fee-disburse')->withSuccess(['Success Update Data']);
        } else {
            return redirect('disburse/setting/global#fee-disburse')->withErrors(['Failed Update Data']);
        }
    }

    public function settingSendEmailTo(Request $request)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            $update['value_text'] = json_encode($post);
        }

        $save = MyHelper::post('disburse/setting/send-email-to', $update);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('disburse/setting/global#send-email-to')->withSuccess(['Success Update Data']);
        } else {
            return redirect('disburse/setting/global#send-email-to')->withErrors(['Failed Update Data']);
        }
    }

    public function autoResponse(Request $request, $subject)
    {
        $autocrmSubject = ucwords(str_replace('-', ' ', $subject));
        $data = [
            'title'             => 'Disburse Auto Response ' . $autocrmSubject,
            'menu_active'       => 'disburse-settings',
            'submenu_active'    => 'autoresponse-' . $subject
        ];

        $data['click_notification'] = [];
        $data['click_inbox'] = [];
        $query = MyHelper::post('autocrm/list', ['autocrm_title' => $autocrmSubject]);
        $test = MyHelper::get('autocrm/textreplace');
        $auto = null;
        $post = $request->except('_token');
        if (!empty($post)) {
            if (isset($post['autocrm_push_image'])) {
                $post['autocrm_push_image'] = MyHelper::encodeImage($post['autocrm_push_image']);
            }

            if (isset($post['files'])) {
                unset($post['files']);
            }

            $query = MyHelper::post('autocrm/update', $post);
            return back()->withSuccess(['Response updated']);
        }

        $getApiKey = MyHelper::get('setting/whatsapp');
        if (isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']) {
            $data['api_key_whatsapp'] = $getApiKey['result']['value'];
        } else {
            $data['api_key_whatsapp'] = null;
        }

        if (isset($query['result'])) {
            $auto = $query['result'];
        } else {
            return back()->withErrors(['No such response']);
        }

        $data['data'] = $auto;
        if ($test['status'] == 'success') {
            $data['textreplaces'] = $test['result'];
            $data['subject'] = $subject;
        }

        $custom = [];
        if (isset($data['data']['custom_text_replace'])) {
            $custom = explode(';', $data['data']['custom_text_replace']);

            unset($custom[count($custom) - 1]);
        }

        $data['custom'] = $custom;
        $data['active_response'] = ['forward'];

        return view('users::response', $data);
    }
}
