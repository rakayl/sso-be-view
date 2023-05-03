<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class TransactionSettingController extends Controller
{
    public function list(Request $request)
    {
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'order',
            'sub_title'      => 'Global ' . env('POINT_NAME', 'Points'),
            'submenu_active' => 'transaction-setting'
        ];

        $lists = MyHelper::get('transaction/setting/cashback');

        if (isset($lists['status']) && $lists['status'] == 'success') {
            $data['lists'] = $lists['result'];

            return view('transaction::setting.cashback_list', $data);
        } elseif (isset($lists['status']) && $lists['status'] == 'fail') {
            if (isset($lists['messages'][0]) && $lists['messages'][0] == 'empty') {
                return view('transaction::setting.cashback_list', $data);
            }
            return view('transaction::setting.cashback_list', $data)->withErrors($lists['messages']);
        } else {
            return view('transaction::setting.cashback_list', $data)->withErrors(['Data not found']);
        }
    }

    public function update(Request $request)
    {
        $post = $request->except('_token');

        $update = MyHelper::post('transaction/setting/cashback/update', $post);
        if (isset($update['status']) && $update['status'] == 'success') {
            return back()->with('success', ['Update setting success']);
        } elseif (isset($update['status']) && $update['status'] == 'fail') {
            return back()->withErrors([$update['messages']]);
        } else {
            return back()->withErrors(['Something went wrong']);
        }
    }

    public function refundRejectOrder(Request $request)
    {
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Refund Reject Order',
            'submenu_active' => 'refund-reject-order'
        ];

        $data['status'] = [
            'refund_midtrans' => MyHelper::post('setting', ['key' => 'refund_midtrans'])['result']['value'] ?? 0,
            'refund_ipay88' => MyHelper::post('setting', ['key' => 'refund_ipay88'])['result']['value'] ?? 0,
            'refund_shopeepay' => MyHelper::post('setting', ['key' => 'refund_shopeepay'])['result']['value'] ?? 0,
            'refund_xendit' => MyHelper::post('setting', ['key' => 'refund_xendit'])['result']['value'] ?? 0,
            'refund_failed_process_balance' => MyHelper::post('setting', ['key' => 'refund_failed_process_balance'])['result']['value'] ?? 0,
        ];

        $get = MyHelper::post('autocrm/list', ['autocrm_title' => 'Payment Void Failed']);
        if (isset($get['status']) && $get['status'] == 'success') {
            $data['result'] = $get['result'];

            $data['textreplaces'] = [];

            $custom = [];
            if (isset($get['result']['custom_text_replace'])) {
                $custom = explode(';', $get['result']['custom_text_replace']);
            }
            $data['custom'] = $custom;
        } else {
            $data['result'] = [];
        }

        return view('transaction::setting.refund_reject_order', $data);
    }

    public function updateRefundRejectOrder(Request $request)
    {
        $sendData = [
            'refund_midtrans' => ['value', $request->refund_midtrans ? 1 : 0],
            'refund_ipay88' => ['value', $request->refund_ipay88 ? 1 : 0],
            'refund_shopeepay' => ['value', $request->refund_shopeepay ? 1 : 0],
            'refund_xendit' => ['value', $request->refund_xendit ? 1 : 0],
            'refund_failed_process_balance' => ['value', $request->refund_failed_process_balance ? 1 : 0]
        ];
        $data = MyHelper::post('setting/update2', ['update' => $sendData]);

        $updateAutocrm = [
            'id_autocrm' => $request->id_autocrm,
            'autocrm_forward_toogle' => '1',
            'autocrm_forward_email' => $request->autocrm_forward_email,
            'autocrm_forward_email_subject' => $request->autocrm_forward_email_subject,
            'autocrm_forward_email_content' => $request->autocrm_forward_email_content,
        ];

        $query = MyHelper::post('autocrm/update', $updateAutocrm);

        if (($data['status'] ?? false) == 'success') {
            return back()->withSuccess(['Success update']);
        } else {
            return back()->withErrors(['Update failed']);
        }
    }

    public function forwardWeHelpYouLowBalance(Request $request)
    {
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'delivery-settings',
            'sub_title'      => '[Forward] WeHelpYou Low Balance',
            'submenu_active' => 'delivery-method',
            'child_active' => 'forward-wehelpyou'
        ];

        $data['wehelpyou_limit_balance'] = MyHelper::post('setting', ['key' => 'wehelpyou_limit_balance'])['result']['value'] ?? 0;

        $get = MyHelper::post('autocrm/list', ['autocrm_title' => 'WeHelpYou Low Balance']);
        if (isset($get['status']) && $get['status'] == 'success') {
            $data['result'] = $get['result'];

            $data['textreplaces'] = [];

            $custom = [];
            if (isset($get['result']['custom_text_replace'])) {
                $custom = explode(';', $get['result']['custom_text_replace']);
            }
            $data['custom'] = $custom;
        } else {
            $data['result'] = [];
        }

        return view('transaction::setting.delivery_setting.forward_wehelpyou', $data);
    }

    public function updateForwardWeHelpYouLowBalance(Request $request)
    {
        $sendData = [
            'wehelpyou_limit_balance' => ['value', $request->wehelpyou_limit_balance],
        ];
        $data = MyHelper::post('setting/update2', ['update' => $sendData]);

        $updateAutocrm = [
            'id_autocrm' => $request->id_autocrm,
            'autocrm_forward_toogle' => '1',
            'autocrm_forward_email' => $request->autocrm_forward_email,
            'autocrm_forward_email_subject' => $request->autocrm_forward_email_subject,
            'autocrm_forward_email_content' => $request->autocrm_forward_email_content,
        ];

        $query = MyHelper::post('autocrm/update', $updateAutocrm);

        if (($data['status'] ?? false) == 'success') {
            return back()->withSuccess(['Success update']);
        } else {
            return back()->withErrors(['Update failed']);
        }
    }

    public function autoReject(Request $request)
    {
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Auto Reject time',
            'submenu_active' => 'auto-reject-time'
        ];

        $data['auto_reject_time'] = MyHelper::post('setting', ['key' => 'auto_reject_time'])['result']['value'] ?? 15;

        return view('transaction::setting.auto_reject', $data);
    }

    public function updateAutoReject(Request $request)
    {
        $sendData = [
            'auto_reject_time' => ['value', $request->auto_reject_time ?: 15]
        ];
        $data = MyHelper::post('setting/update2', ['update' => $sendData]);
        if (($data['status'] ?? false) == 'success') {
            return back()->withSuccess(['Success update']);
        } else {
            return back()->withErrors(['Update failed']);
        }
    }

    public function cashbackCalculation(Request $request)
    {
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Cashback Calculation',
            'submenu_active' => 'setting-cashback-calculation'
        ];

        $data['status'] = [
            'cashback_include_bundling' => MyHelper::post('setting', ['key' => 'cashback_include_bundling'])['result']['value'] ?? 0,
        ];

        return view('transaction::setting.cashback_calculation', $data);
    }

    public function cashbackCalculationUpdate(Request $request)
    {
        $sendData = [
            'cashback_include_bundling' => ['value', $request->cashback_include_bundling ?: 0]
        ];
        $data = MyHelper::post('setting/update2', ['update' => $sendData]);
        if (($data['status'] ?? false) == 'success') {
            return back()->withSuccess(['Success update']);
        } else {
            return back()->withErrors(['Update failed']);
        }
    }

    public function updateTransactionMessages(Request $request)
    {
        if (empty($request->all())) {
            $data = [
                'title'          => 'Order',
                'menu_active'    => 'order',
                'sub_title'      => 'Transaction Messages',
                'submenu_active' => 'transaction-messages'
            ];

            $data['messages'] = [
                'cashback_earned_text' => [
                    'label' => 'Cashback Earned',
                    'tooltip' => 'Teks yang akan tampil pada halaman checkout saat customer mendapatkan point cashback',
                    'value' => MyHelper::post('setting', ['key' => 'cashback_earned_text'])['result']['value'] ?? 'Point yang akan didapatkan',
                    'text_replaces' => []
                ]
            ];

            return view('transaction::setting.transaction_messages', $data);
        } else {
            $update = MyHelper::post('setting/update2', [
                'update' => [
                    'cashback_earned_text' => ['value', $request->cashback_earned_text]
                ]
            ]);

            if (($update['status'] ?? false) == 'success') {
                return back()->with('success', ['Transaction messages has been updated']);
            } else {
                return back()->withErrors($update['messages'] ?? ['Update failed']);
            }
        }
    }

    public function settingAllFee(Request $request, $type = null)
    {
        $post = $request->all();

        if (empty($post)) {
            $data = [
                'title'          => 'Order',
                'menu_active'    => 'order',
                'sub_title'      => 'Setting Fee',
                'submenu_active' => 'setting-fee'
            ];

            $data['service'] = MyHelper::post('setting', ['key' => 'service'])['result']['value'] ?? 0;
            $data['service'] = $data['service'] * 100;
            $data['tax'] = MyHelper::post('setting', ['key' => 'tax'])['result']['value'] ?? 0;
            $data['tax'] = $data['tax'] * 100;
            $data['mdr_charged'] = MyHelper::post('setting', ['key' => 'mdr_charged'])['result']['value'] ?? '';
            $mdrFormula = MyHelper::post('setting', ['key' => 'mdr_formula'])['result']['value_text'] ?? '';
            $data['mdr_formula'] = (array)json_decode($mdrFormula);
            $data['withdrawal_fee_global'] = MyHelper::post('setting', ['key' => 'withdrawal_fee_global'])['result']['value'] ?? 0;
            $data['banks'] = MyHelper::post('disburse/bank', $post)['result'] ?? [];

            return view('transaction::setting.all_fee', $data);
        } else {
            if ($type == 'service') {
                $service = $post['service'] / 100;
                $service = ($service == 0 ? '0.0' : $service);
                $tax = $post['tax'] / 100;
                $tax = ($tax == 0 ? '0.0' : $tax);

                $sendData = [
                    'service' => ['value', $service],
                    'tax' => ['value', $tax]
                ];
                $update = MyHelper::post('setting/update2', ['update' => $sendData]);
            } elseif ($type == 'mdr') {
                $update = MyHelper::post('transaction/setting/mdr', $post);
            } elseif ($type == 'withdrawal') {
                $update = MyHelper::post('transaction/setting/withdrawal', $post);
            }

            if (($update['status'] ?? false) == 'success') {
                return redirect('transaction/setting/all-fee#' . $type . '_fee')->withSuccess(['Success update']);
            } else {
                return back()->withErrors(['Update failed']);
            }
        }
    }
}
