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

class TransactionController extends Controller
{
    public function banksList(Request $request)
    {
        $data = [
            'title'          => 'Bank List',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'bank',
            'submenu_active' => 'bank'
        ];

        $lists = MyHelper::get('transaction/manualpayment/bank');
        // print_r($lists);exit;
        if (isset($lists['status']) && $lists['status'] == 'success') {
            $data['lists'] = $lists['result'];
        } elseif (isset($lists['status']) && $lists['status'] == 'fail') {
            return back()->withErrors($lists['messages']);
        } else {
            return back()->withErrors(['Data not found']);
        }

        return view('transaction::payment.bankList', $data);
    }

    public function banksDelete($id)
    {
        $delete = MyHelper::post('transaction/manualpayment/bank/delete', ['id' => $id]);
        return parent::redirect($delete, 'Bank has been deleted');
    }

    public function banksCreate(Request $request)
    {
        $post = $request->except('_token');
        $save = MyHelper::post('transaction/manualpayment/bank/create', $post);
        return parent::redirect($save, 'Bank has been created.');
    }

    public function banksMethodList(Request $request)
    {
         $data = [
            'title'          => 'Payment Method List',
            'menu_active'    => 'bank-method',
            'sub_title'      => 'bank-method',
            'submenu_active' => 'bank-method'
         ];

         $lists = MyHelper::get('transaction/manualpayment/bankmethod');

         if (isset($lists['status']) && $lists['status'] == 'success') {
             $data['lists'] = $lists['result'];
         } elseif (isset($lists['status']) && $lists['status'] == 'fail') {
             return back()->withErrors($lists['messages']);
         } else {
             return back()->withErrors(['Data not found']);
         }

         return view('transaction::payment.bankMethodList', $data);
    }

    public function bankMethodsDelete($id)
    {
        $delete = MyHelper::post('transaction/manualpayment/bankmethod/delete', ['id' => $id]);
        return parent::redirect($delete, 'Payment Method has been deleted');
    }

    public function bankMethodsCreate(Request $request)
    {
        $post = $request->except('_token');
        $save = MyHelper::post('transaction/manualpayment/bankmethod/create', $post);
        return parent::redirect($save, 'Payment Method has been created.');
    }

    public function autoResponse(Request $request, $subject)
    {
        $autocrmSubject = ucwords(str_replace('-', ' ', $subject));
        $data = [ 'title'             => 'Transaction Auto Response ' . $autocrmSubject,
                  'menu_active'       => 'transaction',
                  'submenu_active'    => 'transaction-autoresponse-' . $subject,
                  'type'              => 'trx'
                ];

        if ($subject == 'transaction-success') {
            $subject = 'transaction-completed';
        }

        switch ($subject) {
            case 'receive-inject-voucher':
                $data['menu_active'] = 'inject-voucher';
                $data['submenu_active'] = 'deals-autoresponse-receive-inject-voucher';
                $data['click_inbox'] = [
                    ['value' => "Voucher",'title' => 'Voucher']
                ];
                $data['click_notification'] = [
                    ['value' => 'Voucher','title' => 'Voucher']
                ];
                break;

            case 'receive-quest-voucher':
                $data['menu_active'] = 'quest';
                $data['submenu_active'] = 'quest-voucher';
                $data['child_active'] = 'deals-autoresponse-receive-quest-voucher';
                $data['click_inbox'] = [
                    ['value' => "Voucher",'title' => 'Voucher']
                ];
                $data['click_notification'] = [
                    ['value' => 'Voucher','title' => 'Voucher']
                ];
                break;

            case 'redeem-voucher-success':
                $data['menu_active'] = 'deals';
                $data['submenu_active'] = 'deals-autoresponse-redeem-deals-success';
                $data['click_inbox'] = [
                    ['value' => "Voucher",'title' => 'Voucher']
                ];
                $data['click_notification'] = [
                    ['value' => 'Voucher','title' => 'Voucher']
                ];
                break;

            case 'claim-free-deals-success':
                $data['menu_active'] = 'deals';
                $data['submenu_active'] = 'deals-autoresponse-claim-free-deals-success';
                $data['click_inbox'] = [
                    ['value' => "Voucher",'title' => 'Voucher']
                ];
                $data['click_notification'] = [
                    ['value' => 'Voucher','title' => 'Voucher']
                ];
                break;

            case 'claim-paid-deals-success':
                $data['menu_active'] = 'deals';
                $data['submenu_active'] = 'deals-autoresponse-claim-paid-deals-success';
                $data['click_inbox'] = [
                    ['value' => "Voucher",'title' => 'Voucher']
                ];
                $data['click_notification'] = [
                    ['value' => 'Voucher','title' => 'Voucher']
                ];
                break;

            case 'claim-point-deals-success':
                $data['menu_active'] = 'deals';
                $data['submenu_active'] = 'deals-autoresponse-claim-point-deals-success';
                $data['click_inbox'] = [
                    ['value' => "Voucher",'title' => 'Voucher']
                ];
                $data['click_notification'] = [
                    ['value' => 'Voucher','title' => 'Voucher']
                ];
                break;

            case 'transaction-point-achievement':
                $data['menu_active'] = 'transaction';
                $data['submenu_active'] = 'transaction-point-achievement';
                $data['click_inbox'] = [
                    ['value' => "home",'title' => 'Home'],
                    ['value' => "history_order",'title' => 'History Order'],
                    ['value' => "point_history",'title' => 'Point History']
                ];
                $data['click_notification'] = [
                    ['value' => "home",'title' => 'Home'],
                    ['value' => "history_order",'title' => 'History Order'],
                    ['value' => "point_history",'title' => 'Point History']
                ];
                break;

            case 'transaction-failed-point-refund':
                $data['menu_active'] = 'transaction';
                $data['submenu_active'] = 'transaction-failed-point-refund';
                $data['click_inbox'] = [
                    ['value' => "Home",'title' => 'Home'],
                    ['value' => "History Transaction",'title' => 'History Transaction']
                ];
                $data['click_notification'] = [
                    ['value' => "Home",'title' => 'Home'],
                    ['value' => "History Transaction",'title' => 'History Transaction']
                ];
                break;

            case 'rejected-order-point-refund':
                $data['menu_active'] = 'transaction';
                $data['submenu_active'] = 'rejected-order-point-refund';
                $data['click_inbox'] = [
                    ['value' => "Home",'title' => 'Home'],
                    ['value' => "History Transaction",'title' => 'History Transaction']
                ];
                $data['click_notification'] = [
                    ['value' => "Home",'title' => 'Home'],
                    ['value' => "History Transaction",'title' => 'History Transaction']
                ];
                break;

            case 'receive-welcome-voucher':
                $data['title'] = 'Auto Response ' . ucfirst(str_replace('-', ' ', $subject));
                $data['menu_active'] = 'welcome-voucher';
                $data['submenu_active'] = 'deals-autoresponse-welcome-voucher';
                $data['click_inbox'] = [
                    ['value' => "Voucher",'title' => 'Voucher']
                ];
                $data['click_notification'] = [
                    ['value' => 'Voucher','title' => 'Voucher']
                ];
                break;

            case 'delivery-status-update':
                $data['menu_active'] = 'transaction';
                $data['submenu_active'] = 'delivery-status-update';
                $data['click_inbox'] = [
                    ['value' => "History Transaction",'title' => 'History Transaction']
                ];
                $data['click_notification'] = [
                    ['value' => 'History Transaction','title' => 'History Transaction']
                ];
                break;

            case 'get-free-subscription-success':
                $data['menu_active'] = 'subscription';
                $data['submenu_active'] = 'subscription-autoresponse-get-free-subscription-success';
                $data['click_inbox'] = [
                    ['value' => "Subcription",'title' => 'Subcription']
                ];
                $data['click_notification'] = [
                    ['value' => 'Subcription','title' => 'Subcription']
                ];
                break;

            case 'buy-paid-subscription-success':
                $data['menu_active'] = 'subscription';
                $data['submenu_active'] = 'subscription-autoresponse-buy-paid-subscription-success';
                $data['click_inbox'] = [
                    ['value' => "Subcription",'title' => 'Subcription']
                ];
                $data['click_notification'] = [
                    ['value' => 'Subcription','title' => 'Subcription']
                ];
                break;

            case 'buy-point-subscription-success':
                $data['menu_active'] = 'subscription';
                $data['submenu_active'] = 'subscription-autoresponse-buy-point-subscription-success';
                $data['click_inbox'] = [
                    ['value' => "Subcription",'title' => 'Subcription']
                ];
                $data['click_notification'] = [
                    ['value' => 'Subcription','title' => 'Subcription']
                ];
                break;
            case 'order-taken-with-code':
                $data['menu_active'] = 'response-with-code';
                $data['submenu_active'] = 'order-taken-with-code';
                $data['click_inbox'] = [
                    ['value' => "History Transaction",'title' => 'History Transaction']
                ];
                $data['click_notification'] = [
                    ['value' => 'History Transaction','title' => 'History Transaction']
                ];
                break;
            case 'order-taken-delivery-with-code':
                $data['menu_active'] = 'response-with-code';
                $data['submenu_active'] = 'order-taken-delivery-with-code';
                $data['click_inbox'] = [
                    ['value' => "History Transaction",'title' => 'History Transaction']
                ];
                $data['click_notification'] = [
                    ['value' => 'History Transaction','title' => 'History Transaction']
                ];
                break;
            case 'payment-success':
                $data['click_inbox'] = [
                    ['value' => "history_order",'title' => 'History Order'],
                    ['value' => "history_order_detail",'title' => 'History Order Detail']
                ];
                $data['click_notification'] = [
                    ['value' => "history_order",'title' => 'History Order'],
                    ['value' => "history_order_detail",'title' => 'History Order Detail']
                ];
                break;
            case 'transaction-accepted':
                $data['click_inbox'] = [
                    ['value' => "history_order",'title' => 'History Order'],
                    ['value' => "history_order_detail",'title' => 'History Order Detail']
                ];
                $data['click_notification'] = [
                    ['value' => "history_order",'title' => 'History Order'],
                    ['value' => "history_order_detail",'title' => 'History Order Detail']
                ];
                break;
            case 'transaction-reject':
                $data['click_inbox'] = [
                    ['value' => "history_order",'title' => 'History Order'],
                    ['value' => "history_order_detail",'title' => 'History Order Detail']
                ];
                $data['click_notification'] = [
                    ['value' => "history_order",'title' => 'History Order'],
                    ['value' => "history_order_detail",'title' => 'History Order Detail']
                ];
                break;
            case 'merchant-transaction-new':
                $data['click_inbox'] = [
                    ['value' => "my_store",'title' => 'My Store'],
                    ['value' => "store_transaction_new",'title' => 'Store Transaction New']
                ];
                $data['click_notification'] = [
                    ['value' => "my_store",'title' => 'My Store'],
                    ['value' => "store_transaction_new",'title' => 'Store Transaction New']
                ];
                break;
            default:
                $data['click_inbox'] = [
                    ['value' => "history_order",'title' => 'History Order']
                ];
                $data['click_notification'] = [
                    ['value' => 'history_order','title' => 'History Order']
                ];
                break;
        }
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

        if ($subject == 'merchant-transaction-new') {
            $data['textreplaces'] = [];
        }

        $custom = [];
        if (isset($data['data']['custom_text_replace'])) {
            $custom = explode(';', $data['data']['custom_text_replace']);

            unset($custom[count($custom) - 1]);
        }

        if (stristr($request->url(), 'deals') || stristr($request->url(), 'voucher')) {
            $data['deals'] = true;
            $custom[] = '%outlet_name%';
            $custom[] = '%outlet_code%';
            $data['type'] = '';
        }

        $data['custom'] = $custom;

        return view('users::response', $data);
    }

    public function ruleTransaction()
    {
        $data = [
            'title'          => 'Order',
            'menu_active'    => 'order',
            'sub_title'      => 'Rule Transaction',
            'submenu_active' => 'transaction-rule'
        ];

        $list = MyHelper::get('transaction/rule');

        if (isset($list['status']) && $list['status'] == 'success') {
            $data['trash'] = [];
            $attrKey = [];
            $attrColor = [];
            foreach ($list['result']['grand_total'] as $key => $id) {
                if ($list['result']['grand_total'][$key] == 'subtotal') {
                    $data['button'][$key] = '<button id="subtotal" type="button" class="button-drag btn blue-hoki">Subtotal <i class="fa fa-question-circle tooltips" data-original-title="Hasil Subtotal Transaksi" data-container="body"></i></button>';
                } elseif ($list['result']['grand_total'][$key] == 'service') {
                    $data['button'][$key] = '<button id="service" type="button" class="button-drag btn blue-madison" draggable="true" ondragstart="drag(event)">Service <i class="fa fa-question-circle tooltips" data-original-title="Total service Transaksi" data-container="body"></i></button>';
                } elseif ($list['result']['grand_total'][$key] == 'discount') {
                    $data['button'][$key] = '<button id="discount" type="button" class="button-drag btn green-meadow" draggable="true" ondragstart="drag(event)">Discount <i class="fa fa-question-circle tooltips" data-original-title="Total diskon Transaksi" data-container="body"></i></button>';
                } elseif ($list['result']['grand_total'][$key] == 'shipping') {
                    $data['button'][$key] = '<button id="shipping" type="button" class="button-drag btn btn-success" draggable="true" ondragstart="drag(event)">Shipping <i class="fa fa-question-circle tooltips" data-original-title="Total biaya pengiriman Transaksi" data-container="body"></i></button>';
                } elseif ($list['result']['grand_total'][$key] == 'tax') {
                    $data['button'][$key] = '<button id="tax" type="button" class="button-drag btn yellow-crusta" draggable="true" ondragstart="drag(event)">Tax <i class="fa fa-question-circle tooltips" data-original-title="Total pajak Transaksi" data-container="body"></i></button>';
                } else {
                    $data['button'][$key] = '<button type="button" id="' . $list['result']['grand_total'][$key] . '" class="button-drag btn grey-cascade">Empty <i class="fa fa-question-circle tooltips" data-original-title="Value kosong" data-container="body"></i></button>';

                    if ($list['result']['grand_total'][$key] == 'emptyservice') {
                        $trash = '<button id="service" type="button" class="button-drag btn blue-madison" draggable="true" ondragstart="drag(event)">Service <i class="fa fa-question-circle tooltips" data-original-title="Total service Transaksi" data-container="body"></i></button>';

                        array_push($data['trash'], $trash);
                    } elseif ($list['result']['grand_total'][$key] == 'emptydiscount') {
                        $trash = '<button id="discount" type="button" class="button-drag btn green-meadow" draggable="true" ondragstart="drag(event)">Discount <i class="fa fa-question-circle tooltips" data-original-title="Total diskon Transaksi" data-container="body"></i></button>';

                        array_push($data['trash'], $trash);
                    } elseif ($list['result']['grand_total'][$key] == 'emptyshipping') {
                        $trash = '<button id="shipping" type="button" class="button-drag btn btn-success" draggable="true" ondragstart="drag(event)">Shipping <i class="fa fa-question-circle tooltips" data-original-title="Total biaya pengiriman Transaksi" data-container="body"></i></button>';

                        array_push($data['trash'], $trash);
                    } else {
                        $trash = '<button id="tax" type="button" class="button-drag btn yellow-crusta" draggable="true" ondragstart="drag(event)">Tax <i class="fa fa-question-circle tooltips" data-original-title="Total pajak Transaksi" data-container="body"></i></button>';

                        array_push($data['trash'], $trash);
                    }
                }
            }

            $countData = count($list['result']['service']['data']) - 1;

            foreach ($list['result']['service']['data'] as $row => $value) {
                unset($list['result']['service']['data'][0]);
                unset($list['result']['service']['data'][$countData]);
                unset($list['result']['service']['data'][$countData - 1]);
                unset($list['result']['service']['data'][$countData - 2]);

                if ($row != $countData || $row != $countData - 1) {
                    if ($value == '*') {
                        $key = 'kali';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '/') {
                        $key = 'bagi';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '+') {
                        $key = 'tambah';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '-') {
                        $key = 'kurang';
                        $color = 'blue';
                    } elseif ($value == '(') {
                        $key = 'kbuka';
                        $color = 'red';
                    } elseif ($value == ')') {
                        $key = 'ktutup';
                        $color = 'red';
                    } else {
                        $key = $value;
                        $color = 'black';
                    }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['service']['attrKey'] = $attrKey;
                    $list['result']['service']['attrColor'] = $attrColor;

                    unset($list['result']['service']['attrKey'][0]);
                    unset($list['result']['service']['attrKey'][$countData]);
                    unset($list['result']['service']['attrKey'][$countData - 1]);
                    unset($list['result']['service']['attrKey'][$countData - 2]);

                    unset($list['result']['service']['attrColor'][0]);
                    unset($list['result']['service']['attrColor'][$countData]);
                    unset($list['result']['service']['attrColor'][$countData - 1]);
                    unset($list['result']['service']['attrColor'][$countData - 2]);
                }
            }

            $data['service'] = $list['result']['service'];
            $attrKey = [];
            $attrColor = [];

            $countDataDiscount = count($list['result']['discount']['data']) - 1;

            foreach ($list['result']['discount']['data'] as $row => $value) {
                unset($list['result']['discount']['data'][0]);
                unset($list['result']['discount']['data'][$countDataDiscount]);
                unset($list['result']['discount']['data'][$countDataDiscount - 1]);
                unset($list['result']['discount']['data'][$countDataDiscount - 2]);

                if ($row != $countDataDiscount || $row != $countDataDiscount - 1) {
                    if ($value == '*') {
                        $key = 'kali';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '/') {
                        $key = 'bagi';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '+') {
                        $key = 'tambah';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '-') {
                        $key = 'kurang';
                        $color = 'blue';
                    } elseif ($value == '(') {
                        $key = 'kbuka';
                        $color = 'red';
                    } elseif ($value == ')') {
                        $key = 'ktutup';
                        $color = 'red';
                    } else {
                        $key = $value;
                        $color = 'black';
                    }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['discount']['attrKey'] = $attrKey;
                    $list['result']['discount']['attrColor'] = $attrColor;

                    unset($list['result']['discount']['attrKey'][0]);
                    unset($list['result']['discount']['attrKey'][$countDataDiscount]);
                    unset($list['result']['discount']['attrKey'][$countDataDiscount - 1]);
                    unset($list['result']['discount']['attrKey'][$countDataDiscount - 2]);

                    unset($list['result']['discount']['attrColor'][0]);
                    unset($list['result']['discount']['attrColor'][$countDataDiscount]);
                    unset($list['result']['discount']['attrColor'][$countDataDiscount - 1]);
                    unset($list['result']['discount']['attrColor'][$countDataDiscount - 2]);
                }
            }

            $data['discount'] = $list['result']['discount'];
            $attrKey = [];
            $attrColor = [];

            $countDataTax = count($list['result']['tax']['data']) - 1;

            foreach ($list['result']['tax']['data'] as $row => $value) {
                unset($list['result']['tax']['data'][0]);
                unset($list['result']['tax']['data'][$countDataTax]);
                unset($list['result']['tax']['data'][$countDataTax - 1]);
                unset($list['result']['tax']['data'][$countDataTax - 2]);

                if ($row != $countDataTax || $row != $countDataTax - 1) {
                    if ($value == '*') {
                        $key = 'kali';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '/') {
                        $key = 'bagi';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '+') {
                        $key = 'tambah';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '-') {
                        $key = 'kurang';
                        $color = 'blue';
                    } elseif ($value == '(') {
                        $key = 'kbuka';
                        $color = 'red';
                    } elseif ($value == ')') {
                        $key = 'ktutup';
                        $color = 'red';
                    } else {
                        $key = $value;
                        $color = 'black';
                    }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['tax']['attrKey'] = $attrKey;
                    $list['result']['tax']['attrColor'] = $attrColor;

                    unset($list['result']['tax']['attrKey'][0]);
                    unset($list['result']['tax']['attrKey'][$countDataTax]);
                    unset($list['result']['tax']['attrKey'][$countDataTax - 1]);
                    unset($list['result']['tax']['attrKey'][$countDataTax - 2]);

                    unset($list['result']['tax']['attrColor'][0]);
                    unset($list['result']['tax']['attrColor'][$countDataTax]);
                    unset($list['result']['tax']['attrColor'][$countDataTax - 1]);
                    unset($list['result']['tax']['attrColor'][$countDataTax - 2]);
                }
            }

            $data['tax'] = $list['result']['tax'];
            $attrKey = [];
            $attrColor = [];

            $countDataPoint = count($list['result']['point']['data']) - 1;

            foreach ($list['result']['point']['data'] as $row => $value) {
                unset($list['result']['point']['data'][0]);
                unset($list['result']['point']['data'][$countDataPoint]);
                unset($list['result']['point']['data'][$countDataPoint - 1]);
                unset($list['result']['point']['data'][$countDataPoint - 2]);

                if ($row != $countDataPoint || $row != $countDataPoint - 1) {
                    if ($value == '*') {
                        $key = 'kali';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '/') {
                        $key = 'bagi';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '+') {
                        $key = 'tambah';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '-') {
                        $key = 'kurang';
                        $color = 'blue';
                    } elseif ($value == '(') {
                        $key = 'kbuka';
                        $color = 'red';
                    } elseif ($value == ')') {
                        $key = 'ktutup';
                        $color = 'red';
                    } else {
                        $key = $value;
                        $color = 'black';
                    }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['point']['attrKey'] = $attrKey;
                    $list['result']['point']['attrColor'] = $attrColor;

                    unset($list['result']['point']['attrKey'][0]);
                    unset($list['result']['point']['attrKey'][$countDataPoint]);
                    unset($list['result']['point']['attrKey'][$countDataPoint - 1]);
                    unset($list['result']['point']['attrKey'][$countDataPoint - 2]);

                    unset($list['result']['point']['attrColor'][0]);
                    unset($list['result']['point']['attrColor'][$countDataPoint]);
                    unset($list['result']['point']['attrColor'][$countDataPoint - 1]);
                    unset($list['result']['point']['attrColor'][$countDataPoint - 2]);
                }
            }

            $data['point'] = $list['result']['point'];
            $attrKey = [];
            $attrColor = [];

            $countDataCashback = count($list['result']['cashback']['data']) - 1;

            foreach ($list['result']['cashback']['data'] as $row => $value) {
                unset($list['result']['cashback']['data'][0]);
                unset($list['result']['cashback']['data'][$countDataCashback]);
                unset($list['result']['cashback']['data'][$countDataCashback - 1]);
                unset($list['result']['cashback']['data'][$countDataCashback - 2]);

                if ($row != $countDataCashback || $row != $countDataCashback - 1) {
                    if ($value == '*') {
                        $key = 'kali';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '/') {
                        $key = 'bagi';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '+') {
                        $key = 'tambah';
                        $color = 'blue';
                        $triger = 'operator';
                    } elseif ($value == '-') {
                        $key = 'kurang';
                        $color = 'blue';
                    } elseif ($value == '(') {
                        $key = 'kbuka';
                        $color = 'red';
                    } elseif ($value == ')') {
                        $key = 'ktutup';
                        $color = 'red';
                    } else {
                        $key = $value;
                        $color = 'black';
                    }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['cashback']['attrKey'] = $attrKey;
                    $list['result']['cashback']['attrColor'] = $attrColor;

                    unset($list['result']['cashback']['attrKey'][0]);
                    unset($list['result']['cashback']['attrKey'][$countDataCashback]);
                    unset($list['result']['cashback']['attrKey'][$countDataCashback - 1]);
                    unset($list['result']['cashback']['attrKey'][$countDataCashback - 2]);

                    unset($list['result']['cashback']['attrColor'][0]);
                    unset($list['result']['cashback']['attrColor'][$countDataCashback]);
                    unset($list['result']['cashback']['attrColor'][$countDataCashback - 1]);
                    unset($list['result']['cashback']['attrColor'][$countDataCashback - 2]);
                }
            }

            $data['cashback'] = $list['result']['cashback'];

            $data['outlet'] = $list['result']['outlet'];
            $data['default'] = $list['result']['default_outlet']['value'];
        } else {
            return redirect('home')->withErrors(['Something went wrong']);
        }

        return view('transaction::ruleView', $data);
    }

    public function internalCourier()
    {
        $attrKey = [];
        $attrColor = [];
        $data = [
            'title'          => 'Internal Courier',
            'menu_active'    => 'order',
            'sub_title'      => 'Rule',
            'submenu_active' => 'internal-courier'
        ];

        $list = MyHelper::get('transaction/courier');

        if (isset($list['status']) && $list['status'] == 'success') {
            $courier = explode(' ', $list['result'][0]['value']);
            $countData = count($courier);

            foreach ($courier as $row => $value) {
                if ($value == '*') {
                    $key = 'kali';
                    $color = 'blue';
                    $triger = 'operator';
                } elseif ($value == '/') {
                    $key = 'bagi';
                    $color = 'blue';
                    $triger = 'operator';
                } elseif ($value == '+') {
                    $key = 'tambah';
                    $color = 'blue';
                    $triger = 'operator';
                } elseif ($value == '-') {
                    $key = 'kurang';
                    $color = 'blue';
                } elseif ($value == '(') {
                    $key = 'kbuka';
                    $color = 'red';
                } elseif ($value == ')') {
                    $key = 'ktutup';
                    $color = 'red';
                } else {
                    $key = $value;
                    $color = 'black';
                }

                    array_push($attrKey, $key);
                    array_push($attrColor, $color);

                    $list['result']['courier']['attrKey'] = $attrKey;
                    $list['result']['courier']['attrColor'] = $attrColor;
                    $list['result']['courier']['courier'] = $courier;
            }

            $data['list'] = $list['result'];
        } else {
            return parent::redirect($list, 'Data not valid');
        }

        return view('transaction::courier', $data);
    }

    public function ruleTransactionUpdate(Request $request)
    {
        $post = $request->except('_token');

        $update = MyHelper::post('transaction/rule/update', $post);
        if ($post['key'] == 'delivery' || $post['key'] == 'outlet') {
            return parent::redirect($update, 'Setting has been updated.');
        } else {
            if (isset($update['status']) && $update['status'] == 'success') {
                return 'success';
            } elseif (isset($update['status']) && $update['status'] == 'fail') {
                return 'fail';
            } else {
                return 'abort';
            }
        }
    }

    public function manualPaymentList()
    {
        $data = [
            'title'          => 'Manual Payment',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'List',
            'submenu_active' => 'manual-payment-method-list'
        ];

        $list = MyHelper::get('transaction/manualpayment/list');

        if (isset($list['status']) && $list['status'] == 'success') {
            $data['list'] = array_map(function ($var) {
                $var['id_manual_payment'] = MyHelper::createSlug($var['id_manual_payment'], $var['created_at']);
                return $var;
            }, $list['result']);
        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return view('transaction::payment.manualPaymentList', $data)->withErrors($list['messages']);
        } else {
            return view('transaction::payment.manualPaymentList', $data)->withErrors(['Data not found']);
        }

        return view('transaction::payment.manualPaymentList', $data);
    }

    public function manualPaymentCreate()
    {
        $data = [
            'title'          => 'Manual Payment',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'New',
            'submenu_active' => 'manual-payment-method-new'
        ];

        return view('transaction::payment.manualPaymentCreate', $data);
    }

    public function manualPaymentSave(Request $request)
    {
        $post = $request->except('_token');

        if (isset($post['manual_payment_logo'])) {
            $post['manual_payment_logo'] = MyHelper::encodeImage($post['manual_payment_logo']);
        }

        $save = MyHelper::post('transaction/manualpayment/create', $post);

        return parent::redirect($save, 'Manual payment has been created.');
    }

    public function manualPaymentEdit($slug)
    {
        $exploded = MyHelper::explodeSlug($slug);
        $id = $exploded[0];
        $created_at = $exploded[1];
        $data = [
            'title'          => 'Manual Payment',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'Update',
            'submenu_active' => 'manual-payment-method-list'
        ];

        $edit = MyHelper::post('transaction/manualpayment/edit', ['id' => $id]);

        if (isset($edit['status']) && $edit['status'] == 'success') {
            $data['list'] = $edit['result'];
            $data['list']['id_manual_payment'] = $slug;
        } elseif (isset($edit['status']) && $edit['status'] == 'fail') {
            return view('transaction::payment.manualPaymentList', $data)->withErrors($edit['messages']);
        } else {
            return view('transaction::payment.manualPaymentList', $data)->withErrors(['Data not found']);
        }

        return view('transaction::payment.manualPaymentEdit', $data);
    }

    public function manualPaymentUpdate(Request $request, $slug)
    {
        $exploded = MyHelper::explodeSlug($slug);
        $id = $exploded[0];
        $created_at = $exploded[1];
        $post = $request->except('_token');

        if (isset($post['manual_payment_logo'])) {
            $post['manual_payment_logo'] = MyHelper::encodeImage($post['manual_payment_logo']);
        }

        $update = MyHelper::post('transaction/manualpayment/update', ['post' => $post, 'id' => $id]);

        return parent::redirect($update, 'Manual payment has been updated');
    }

    public function manualPaymentDetail($slug)
    {
        $exploded = MyHelper::explodeSlug($slug);
        $id = $exploded[0];
        $created_at = $exploded[1];
        $data = [
            'title'          => 'Manual Payment',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'Detail',
            'submenu_active' => 'manual-payment-method-list'
        ];

        $data['id_payment'] = $id;

        $detail = MyHelper::post('transaction/manualpayment/detail', ['id' => $id]);

        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data['detail'] = $detail['result'];
            $data['detail']['id_manual_payment'] = $slug;
        } elseif (isset($detail['status']) && $detail['status'] == 'fail') {
            return back()->withErrors($detail['messages']);
        } else {
            return back()->withErrors(['Data not found']);
        }

        return view('transaction::payment.manualPaymentDetail', $data);
    }

    public function manualPaymentDelete($slug)
    {
        $exploded = MyHelper::explodeSlug($slug);
        $id = $exploded[0];
        $created_at = $exploded[1];
        $delete = MyHelper::post('transaction/manualpayment/delete', ['id' => $id]);
        return parent::redirect($delete, 'Manual payment has been deleted');
    }

    public function manualPaymentMethod(Request $request)
    {
        $post = $request->except('_token');
        $save = MyHelper::post('transaction/manualpayment/method/save', $post);
        return parent::redirect($save, 'Success');
    }

    public function manualPaymentMethodDelete(Request $request)
    {
        $id = $request['id'];

        $delete = MyHelper::post('transaction/manualpayment/method/delete', ['id' => $id]);

        if (isset($delete['status']) && $delete['status'] == 'success') {
            return ['status' => 'success'];
        } elseif (isset($delete['status']) && $delete['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $delete['messages']];
        } else {
            return ['status' => 'fail', 'messages' => $delete['message']];
        }
    }

    public function pointUser(Request $request)
    {
        $data = [
            'title'          => 'Point',
            'menu_active'    => 'point',
            'sub_title'      => 'Log',
            'submenu_active' => 'point-log',
            'date_start'     => date('Y-m-01'),
            'date_end'       => date('Y-m-d')
        ];

        $list = MyHelper::post('transaction/point?page=' . $request->get('page'), $data);

        if (isset($list['status']) && $list['status'] == 'success') {
            if (!empty($list['result']['data'])) {
                $data['point']          = $list['result']['data'];
                $data['pointTotal']     = $list['result']['total'];
                $data['pointPerPage']   = $list['result']['from'];
                $data['pointUpTo']      = $list['result']['from'] + count($list['result']['data']) - 1;
                $data['pointPaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
            } else {
                $data['point']          = [];
                $data['pointTotal']     = 0;
                $data['pointPerPage']   = 0;
                $data['pointUpTo']      = 0;
                $data['pointPaginator'] = false;
            }
        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return view('transaction::.log.log_point', $data)->withErrors($list['messages']);
        } else {
            return view('transaction::.log.log_point', $data)->withErrors(['Data not found']);
        }

        return view('transaction::.log.log_point', $data);
    }

    public function pointUserFilter(Request $request, $date)
    {
        $post = $request->all();
        if (empty($post)) {
            return redirect('transaction/point');
        }

        if ($request->get('page') == null) {
            session(['date_start' => $post['date_start']]);
            session(['date_end'   => $post['date_end']]);
            if (isset($post['conditions'])) {
                session(['conditions' => $post['conditions']]);
                session(['rule'       => $post['rule']]);
            }
        } else {
            $post['date_start'] = session('date_start');
            $post['date_end']   = session('date_end');
            if (!empty(session('conditions'))) {
                $post['conditions'] = session('conditions');
                $post['rule']       = session('rule');
            }
        }

        $data = [
            'title'          => 'Point',
            'menu_active'    => 'point',
            'sub_title'      => 'Log',
            'submenu_active' => 'point-log',
            'date_start'     => $post['date_start'],
            'date_end'       => $post['date_end'],
            'rule'           => $post['rule'],
        ];

        if (isset($post['conditions'])) {
            $data['conditions'] = $post['conditions'];
        }

        $list = MyHelper::post('transaction/point/filter?page=' . $request->get('page'), $data);
        if (isset($list['status']) && $list['status'] == 'success') {
            if (!empty($list['data']['data'])) {
                $data['point']          = $list['data']['data'];
                $data['pointTotal']     = $list['data']['total'];
                $data['pointPerPage']   = $list['data']['from'];
                $data['pointUpTo']      = $list['data']['from'] + count($list['data']['data']) - 1;
                $data['pointPaginator'] = new LengthAwarePaginator($list['data']['data'], $list['data']['total'], $list['data']['per_page'], $list['data']['current_page'], ['path' => url()->current()]);
            } else {
                $data['point']          = [];
                $data['pointTotal']     = 0;
                $data['pointPerPage']   = 0;
                $data['pointUpTo']      = 0;
                $data['pointPaginator'] = false;
            }

            $data['count']      = $list['data']['total'];
            $data['rule']       = $post['rule'];
            $data['search']     = '1';
        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return back()->withErrors($list['messages']);
        } else {
            return view('transaction::.log.log_point', $data)->withErrors(['Data not found']);
        }

        return view('transaction::.log.log_point', $data);
    }

    public function balanceUser(Request $request)
    {
        $data = [
            'title'          => 'Balance',
            'menu_active'    => 'balance',
            'sub_title'      => 'Log',
            'submenu_active' => 'balance-log',
            'date_start'     => date('Y-m-01'),
            'date_end'       => date('Y-m-d')
        ];

        $list = MyHelper::post('transaction/balance?page=' . $request->get('page'), $data);

        if (isset($list['status']) && $list['status'] == 'success') {
            if (!empty($list['result']['data'])) {
                $data['balance']          = $list['result']['data'];
                $data['balanceTotal']     = $list['result']['total'];
                $data['balancePerPage']   = $list['result']['from'];
                $data['balanceUpTo']      = $list['result']['from'] + count($list['result']['data']) - 1;
                $data['balancePaginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
            } else {
                $data['balance']          = [];
                $data['balanceTotal']     = 0;
                $data['balancePerPage']   = 0;
                $data['balanceUpTo']      = 0;
                $data['balancePaginator'] = false;
            }
        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return back()->withErrors($list['messages']);
        } else {
            return view('transaction::log.log_balance', $data)->withErrors(['Data not found']);
        }

        return view('transaction::log.log_balance', $data);
    }

    public function balanceUserFilter(Request $request, $date)
    {
        $post = $request->all();
        if (empty($post)) {
            return redirect('transaction/balance');
        }
        // return $post;
        if ($request->get('page') == null) {
            session(['date_start' => $post['date_start']]);
            session(['date_end'   => $post['date_end']]);
            if (isset($post['conditions'])) {
                session(['conditions' => $post['conditions']]);
                session(['rule'       => $post['rule']]);
            }
        } else {
            $post['date_start'] = session('date_start');
            $post['date_end']   = session('date_end');
            if (!empty(session('conditions'))) {
                $post['conditions'] = session('conditions');
                $post['rule']       = session('rule');
            }
        }

        $data = [
            'title'          => 'Balance',
            'menu_active'    => 'balance',
            'sub_title'      => 'Log',
            'submenu_active' => 'balance-log',
            'date_start'     => $post['date_start'],
            'date_end'       => $post['date_end'],
            'rule'           => $post['rule'],
        ];

        if (isset($post['conditions'])) {
            $data['conditions'] = $post['conditions'];
        }

        $list = MyHelper::post('transaction/balance/filter?page=' . $request->get('page'), $data);
        if (isset($list['status']) && $list['status'] == 'success') {
            if (!empty($list['data']['data'])) {
                $data['balance']          = $list['data']['data'];
                $data['balanceTotal']     = $list['data']['total'];
                $data['balancePerPage']   = $list['data']['from'];
                $data['balanceUpTo']      = $list['data']['from'] + count($list['data']['data']) - 1;
                $data['balancePaginator'] = new LengthAwarePaginator($list['data']['data'], $list['data']['total'], $list['data']['per_page'], $list['data']['current_page'], ['path' => url()->current()]);
            } else {
                $data['balance']          = [];
                $data['balanceTotal']     = 0;
                $data['balancePerPage']   = 0;
                $data['balanceUpTo']      = 0;
                $data['balancePaginator'] = false;
            }

            $data['count']      = $list['data']['total'];
            $data['rule']       = $post['rule'];
            $data['search']     = '1';
        } elseif (isset($list['status']) && $list['status'] == 'fail') {
            return back()->withErrors($list['messages']);
        } else {
            return view('transaction::.log.log_balance', $data)->withErrors(['Data not found']);
        }

        return view('transaction::.log.log_balance', $data);
    }

    public function manualPaymentUnpay(Request $request, $type = null)
    {
        if (empty($type)) {
            Session::forget('filterPaymentManual');
            $type = 'unconfirmed';
        }
        $data = [
            'title'          => 'Manual Payment Transaction',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'List',
            'submenu_active' => 'manual-payment-list',
            $type            => true,
            'type'           => $type
        ];

        $post = $request->except('_token');

        if (isset($post['page'])) {
            $page =  $request->get('page');
            unset($post['page']);
        } else {
            $page = null;
        }

        if (!empty($post)) {
            if (!isset($post['conditions'])) {
                $post['conditions'] = [];
            }
            $data['date_start'] = $post['date_start'];
            $data['date_end'] = $post['date_end'];
            $data['conditions'] = $post['conditions'];
            $data['rule'] = $post['rule'];
            $data['filter'] = true;
            Session::put('filterPaymentManual', $post);

            $list = MyHelper::post('transaction/manualpayment/data/filter/' . $type, $post);

            if (isset($list['status']) && $list['status'] == 'success') {
                $data['list'] = $list['result']['data'];
                $data['page'] = $list['result']['current_page'];
                $data['to'] = $list['result']['to'];
                if (empty($data['to'])) {
                    $data['to'] = 0;
                }
                $data['from'] = $list['result']['from'];
                if (empty($data['from'])) {
                    $data['from'] = 0;
                }
                $data['total'] = $list['result']['total'];
            } elseif (isset($list['status']) && $list['status'] == 'fail') {
                return view('transaction::payment.manualPaymentListUnpay', $data)->withErrors(['Data not found']);
            } else {
                return view('transaction::payment.manualPaymentListUnpay', $data)->withErrors($list['messages']);
            }
        } else {
            if (!empty(Session::get('filterPaymentManual'))) {
                $session = Session::get('filterPaymentManual');
                $data['date_start'] = $session['date_start'];
                $data['date_end'] = $session['date_end'];
                $data['conditions'] = $session['conditions'];
                $data['rule'] = $session['rule'];
                $data['filter'] = true;

                if (!empty($page)) {
                    $list = MyHelper::post('transaction/manualpayment/data/filter/' . $type . '?page=' . $page, $session);
                } else {
                    $list = MyHelper::post('transaction/manualpayment/data/filter/' . $type, $session);
                }
            } else {
                $data['date_start'] = date('Y-m-01');
                $data['date_end'] = date('Y-m-d');

                if (!empty($page)) {
                    $list = MyHelper::get('transaction/manualpayment/data/' . $type . '?page=' . $page);
                } else {
                    $list = MyHelper::get('transaction/manualpayment/data/' . $type);
                }
            }
            if (isset($list['status']) && $list['status'] == 'success') {
                $data['list'] = $list['result']['data'];
                $data['page'] = $list['result']['current_page'];
                $data['to'] = $list['result']['to'];
                if (empty($data['to'])) {
                    $data['to'] = 0;
                }
                $data['from'] = $list['result']['from'];
                if (empty($data['from'])) {
                    $data['from'] = 0;
                }
                $data['total'] = $list['result']['total'];
            } elseif (isset($list['status']) && $list['status'] == 'fail') {
                return view('transaction::payment.manualPaymentListUnpay', $data)->withErrors($list['messages']);
            } else {
                $data['list'] = [];
            }
        }
        $data['paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url('transaction/manualpayment/list/' . $type)]);

        return view('transaction::payment.manualPaymentListUnpay', $data);
    }

    public function resetFilter($type = null)
    {
        if (empty($type)) {
            $type = 'unconfirmed';
        }
        Session::forget('filterPaymentManual');
        return redirect('transaction/manualpayment/list/' . $type);
    }

    public function manualPaymentConfirm(Request $request, $id)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Manual Payment Transaction',
                'menu_active'    => 'manual-payment',
                'sub_title'      => 'Manual Payment Confirmation',
                'submenu_active' => 'manual-payment-list'
            ];

            $detail = MyHelper::post('transaction/manualpayment/data/detail', ['transaction_receipt_number' => $id]);

            if (isset($detail['status']) && $detail['status'] == 'success') {
                $data['result'] = $detail['result'];
            } else {
                return parent::redirect($detail, 'Data not valid');
            }

            return view('transaction::payment.manualPaymentConfirm', $data);
        } else {
            $confirm = MyHelper::post('transaction/manualpayment/data/confirm', $post);
            return parent::redirect($confirm, 'Transaction Payment Manual has been confirmed.');
        }
    }

    public function transactionList(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'List Transaction',
            'submenu_active' => 'transaction',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
        ];

        if (Session::has('filter-transaction-list') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-transaction-list');
            $post['page'] = $page;
        } else {
            Session::forget('filter-transaction-list');
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
            Session::put('filter-transaction-list', $post);
        }

        
        return view('transaction::transactionList', $data);
    }

    public function transactionDetail($id)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Detail Transaction',
            'submenu_active' => 'transaction'
        ];

        $check = MyHelper::post('transaction/be/detail', ['id_transaction' => $id]);
        
        if (isset($check['status']) && $check['status'] == "success") {
            $data['detail'] = $check['result'];
            $city = $check['result']['trasaction_sedot_wc']['id_city']??null;
            $data['outlet'] = MyHelper::post('transaction/be/outlet/sedot', ['id_city' => $city])['result']??array();
            if($data['detail']['type'] == "renovasi"){
                $city = $check['result']['transaction_renovasi']['id_city']??null;
                $data['outlet'] = MyHelper::post('transaction/be/outlet/renov', ['id_city' => $city])['result']??array();
                return view('transaction::transactionDetail4', $data);
            }
            return view('transaction::transactionDetail3', $data);
        } else {
            return redirect('transaction')->withErrors(['Failed get detail transaction']);
        }
    }

    public function transactionDelete($id)
    {
        $delete = MyHelper::post('transaction/delete', ['transaction_receipt_number' => $id]);

        return parent::redirect($delete, 'Data transaction has been delete');
    }

    public function transaction(Request $request, $key)
    {
        $data = [];
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'List Transaction',
            'submenu_active' => 'transaction-' . $key,
            'key'            => $key,
            'date_start'     => date('Y-m-01'),
            'date_end'       => date('Y-m-d')
        ];

        if ($request->get('export') && $request->get('export') == 1) {
            $post = $request->all();
            $post['report_type'] = 'Transaction';
            $post['date_start'] = date('Y-m-01 00:00:00');
            $post['date_end'] = date('Y-m-d 23:59:59');
            $post['id_user'] = Session::get('id_user');
            $post['key'] = $key;
            $report = MyHelper::post('report/export/create', $post);

            if (isset($report['status']) && $report['status'] == "success") {
                return redirect('transaction/list-export')->withSuccess(['Success create export to queue']);
            } else {
                return redirect('transaction/list-export')->withErrors(['Failed create export to queue']);
            }
        } else {
            $getList = MyHelper::get('transaction/be/' . $key . '?page=' . $request->get('page'));

            if (isset($getList['result']['data']) && !empty($getList['result']['data'])) {
                $data['trx']          = $getList['result']['data'];
                $data['trxTotal']     = $getList['result']['total'];
                $data['trxPerPage']   = $getList['result']['from'];
                $data['trxUpTo']      = $getList['result']['from'] + count($getList['result']['data']) - 1;
                $data['trxPaginator'] = new LengthAwarePaginator($getList['result']['data'], $getList['result']['total'], $getList['result']['per_page'], $getList['result']['current_page'], ['path' => url()->current()]);
            } else {
                $data['trx']          = [];
                $data['trxTotal']     = 0;
                $data['trxPerPage']   = 0;
                $data['trxUpTo']      = 0;
                $data['trxPaginator'] = false;
            }

            if ($getList['status'] == 'success') {
                $data['list'] = $getList['result'];
            } else {
                $data['list'] = null;
            }

            $getCity = MyHelper::get('city/list?log_save=0');
            if ($getCity['status'] == 'success') {
                $data['city'] = $getCity['result'];
            } else {
                $data['city'] = null;
            }

            $getProvince = MyHelper::get('province/list?log_save=0');
            if ($getProvince['status'] == 'success') {
                $data['province'] = $getProvince['result'];
            } else {
                $data['province'] = null;
            }

            $getCourier = MyHelper::get('courier/list?log_save=0');
            if ($getCourier['status'] == 'success') {
                $data['couriers'] = $getCourier['result'];
            } else {
                $data['couriers'] = null;
            }

            $data['outlets'] = MyHelper::get('outlet/be/list?log_save=0')['result'] ?? [];
            $data['products'] = MyHelper::get('product/be/list?log_save=0')['result'] ?? [];

            return view('transaction::transaction.transaction_delivery', $data);
        }
    }

    public function transactionFilter(Request $request, $key)
    {
        $post = $request->all();
        if (empty($post)) {
            return redirect('transaction/point');
        }

        if ($request->get('page') == null && !isset($post['export'])) {
            session(['date_start' => $post['date_start']]);
            session(['date_end'   => $post['date_end']]);
            if (isset($post['conditions'])) {
                session(['conditions' => $post['conditions']]);
                session(['rule'       => $post['rule']]);
            }
        } else {
            $post['date_start'] = session('date_start');
            $post['date_end']   = session('date_end');
            if (!empty(session('conditions'))) {
                $post['conditions'] = session('conditions');
                $post['rule'] = session('rule');
            }
        }

        $data = [];
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'List Transaction',
            'submenu_active' => 'transaction-' . $key,
            'key'            => $key,
            'date_start'     => $post['date_start'],
            'date_end'       => $post['date_end'],
        ];

        $post['key'] = ucwords($key);
        if (!isset($post['rule'])) {
            $post['rule'] = 'and';
        }

        if ($request->get('export') && $request->get('export') == 1) {
            $post['export'] = 1;
            $post['report_type'] = 'Transaction';
            $post['id_user'] = Session::get('id_user');
            $post['key'] = $key;
            $report = MyHelper::post('report/export/create', $post);

            if (isset($report['status']) && $report['status'] == "success") {
                return redirect('transaction/list-export')->withSuccess(['Success create export to queue']);
            } else {
                return redirect('transaction/list-export')->withErrors(['Failed create export to queue']);
            }
        } else {
            $filter = MyHelper::post('transaction/be/filter', $post);

            $data['outlets'] = MyHelper::get('outlet/be/list?log_save=0')['result'] ?? [];
            $data['products'] = MyHelper::get('product/be/list?log_save=0')['result'] ?? [];

            if (isset($filter['status']) && $filter['status'] == 'success') {
                if (!empty($filter['data']['data'])) {
                    $data['trx']          = $filter['data']['data'];
                    $data['trxTotal']     = $filter['data']['total'];
                    $data['trxPerPage']   = $filter['data']['from'];
                    $data['trxUpTo']      = $filter['data']['from'] + count($filter['data']['data']) - 1;
                    $data['trxPaginator'] = new LengthAwarePaginator($filter['data']['data'], $filter['data']['total'], $filter['data']['per_page'], $filter['data']['current_page'], ['path' => url()->current()]);
                } else {
                    $data['trx']          = [];
                    $data['trxTotal']     = 0;
                    $data['trxPerPage']   = 0;
                    $data['trxUpTo']      = 0;
                    $data['trxPaginator'] = false;
                }

                $data['list']       = $filter['data'];
                $data['conditions'] = $filter['conditions'];
                $data['count']      = $filter['count'];
                $data['rule']       = $filter['rule'];
                $data['search']     = $filter['search'];

                return view('transaction::transaction.transaction_delivery', $data);
            } elseif (isset($filter['status']) && $filter['status'] == 'fail' && isset($filter['messages'])) {
                return redirect('transaction/' . $key . '/' . date('Ymdhis'))->withErrors([$filter['messages']]);
            } else {
                $data['list']       = $filter['data'];
                $data['conditions'] = $filter['conditions'];
                $data['count']      = $filter['count'];
                $data['rule']       = $filter['rule'];
                $data['search']     = $filter['search'];

                return view('transaction::transaction.transaction_delivery', $data);
            }
        }
    }

    public function adminOutlet($receipt, $phone)
    {
        $check = MyHelper::post('transaction/outlet', ['receipt' => $receipt, 'phone' => $phone]);

        $grand_total = MyHelper::post('transaction/grand-total', ['data' => $phone]);
        if (empty($grand_total)) {
            return view('transaction::not_found', ['messages' => ['Setting Not Found']]);
        } else {
            foreach ($grand_total as $key => $value) {
                if ($value == 'shipping') {
                    $grand_total[$key] = 'shipment';
                }
            }
        }

        $check['setting'] = $grand_total;

        if (isset($check['status']) && $check['status'] == 'success') {
            return view('transaction::admin_outlet', $check);
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('transaction::not_found', $check);
        } else {
            return view('transaction::not_found', ['messages' => ['Something Wrong']]);
        }
    }

    public function adminOutletConfirm($type, $status, $receipt, $id)
    {
        $update = MyHelper::post('transaction/admin/confirm', ['type' => $type, 'status' => $status, 'receipt' => $receipt, 'id' => $id]);

        if (isset($update['status']) && $update['status'] == 'success') {
            return back()->with(['success' => ['Update Success']]);
        } else {
            return back()->withErrors(['Update failed']);
        }
    }

    public function freeDelivery(Request $request)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            $update = MyHelper::post('setting/free-delivery', $post);
            if (isset($update['status']) && $update['status'] == 'success') {
                return redirect('transaction/setting/free-delivery')->with(['success' => ['Update Success']]);
            } else {
                return redirect('transaction/setting/free-delivery')->withErrors(['Update failed']);
            }
        }

        $data = [
            'title'          => 'Order',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Free Delivery',
            'submenu_active' => 'free-delivery'
        ];

        $data['result'] = [];
        $request = MyHelper::post('setting', ['key-like' => 'free_delivery']);
        if (isset($request['status']) && $request['status'] == 'success') {
            foreach ($request['result'] as $key => $result) {
                $data['result'][$result['key']] = $result['value'];
            }
        }

        return view('transaction::setting.free_delivery', $data);
    }

    public function goSendPackageDetail(Request $request)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            $update = MyHelper::post('transaction/setting/go-send-package-detail', $post);
            if (isset($update['status']) && $update['status'] == 'success') {
                return redirect('transaction/setting/go-send-package-detail')->with(['success' => ['Update Success']]);
            } else {
                return redirect('transaction/setting/go-send-package-detail')->withErrors(['Update failed']);
            }
        }

        $data = [
            'title'          => 'Order',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting GO-SEND Package Detail',
            'submenu_active' => 'go-send-package-detail'
        ];

        $request = MyHelper::post('setting', ['key' => 'go_send_package_detail']);
        if (isset($request['status']) && $request['status'] == 'success') {
            $data['result'] = $request['result'];
        }

        return view('transaction::setting.go_send_package', $data);
    }

    public function fakeTransaction(Request $request)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            if (in_array(0, $post['id_user'])) {
                unset($post['id_user']);
            }
            $update = MyHelper::post('transaction/dump', $post);
            // return $update;
            if (isset($update['status']) && $update['status'] == 'success') {
                return redirect('transaction/create/fake')->with(['success' => ['Create ' . $post['how_many'] . ' Data Transaction Success']]);
            } else {
                if (isset($update['errors'])) {
                    return back()->withErrors($update['errors'])->withInput();
                }

                if (isset($update['status']) && $update['status'] == "fail") {
                    return back()->withErrors($update['messages'])->withInput();
                }
                return redirect('transaction/create/fake')->withErrors(['Create Transaction Failed'])->withInput();
            }
        }

        $data = [
            'title'          => 'Order',
            'menu_active'    => 'order',
            'sub_title'      => 'Create Fake Transaction',
            'submenu_active' => 'fake-transaction'
        ];

        $user = MyHelper::get('users/get-all');
        if (isset($user['status']) && $user['status'] == 'success') {
            $data['user'] = $user['result'];
        }

        return view('transaction::fake_transaction', $data);
    }

    public function availablePayment(Request $request)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Payment Method',
            'submenu_active' => 'setting-payment-method'
        ];
        $data['payments'] = MyHelper::post('transaction/available-payment', ['show_all' => 1])['result'] ?? [];
        return view('transaction::setting.available_payment', $data);
    }
    public function availablePaymentUpdate(Request $request)
    {
        $post = $request->except('_token');
        $payments = [];
        foreach ($request->payments as $code => $payment) {
            $payments[] = [
                'code' => $code,
                'status' => $payment['status'] ?? 0
            ];
        }
        $data = MyHelper::post('transaction/available-payment/update', ['payments' => $payments]);
        if (($data['status'] ?? false) == 'success') {
            return back()->withSuccess(['Success update setting']);
        } else {
            return back()->withErrors(['Failed update setting']);
        }
    }

    /*================= Export with queue =================*/
    public function listExport(Request $request)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Export Transaction',
            'submenu_active' => 'transactions-export'
        ];

        $id_user = Session::get('id_user');
        $report = MyHelper::post('report/export/list', ['id_user' => $id_user, 'report_type' => ' Transaction']);
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
                return redirect('transaction/list-export')->withSuccess(['Success to Remove file']);
            } else {
                return redirect('transaction/list-export')->withErrors(['Failed to Remove file']);
            }
        } else {
            if (isset($actions['status']) && $actions['status'] == "success") {
                $link = $actions['result']['url_export'];
                $filter = (array)json_decode($actions['result']['filter']);

                if (isset($filter['detail'])) {
                    $filename = "Report Transaction Detail_" . strtotime(date('Ymdhis')) . '.xlsx';
                } else {
                    $filename = "Report Transaction_" . strtotime(date('Ymdhis')) . '.xlsx';
                }

                $tempImage = tempnam(sys_get_temp_dir(), $filename);
                copy($link, $tempImage);

                return response()->download($tempImage, $filename)->deleteFileAfterSend(true);
            } else {
                return redirect('transaction/list-export')->withErrors(['Failed to Download file']);
            }
        }
    }
    /*================= End Export with queue =================*/

    /*================ Start Setting Timer Payment Gateway ================*/
    public function timerPaymentGateway(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'order',
            'sub_title'      => 'Setting Timer Payment Gateway',
            'submenu_active' => 'setting-timer-payment-gateway'
        ];

        if ($post) {
            $dataUpdate = [];
            if ($post['timer_shopeepay'] ?? false) {
                $dataUpdate['shopeepay_validity_period'] = ['value', $post['timer_shopeepay']];
            }
            $update = MyHelper::post('setting/update2', [
                'update' => $dataUpdate
            ]);
            if (isset($update['status']) && $update['status'] == 'success') {
                return redirect('transaction/setting/timer-payment-gateway')->withSuccess(['Success update']);
            } else {
                return redirect('transaction/setting/timer-payment-gateway')->withErrors(['Failed update']);
            }
        } else {
            $data['timer_shopeepay'] = MyHelper::post('setting', ['key' => 'shopeepay_validity_period'])['result']['value'] ?? '';
            return view('transaction::setting.timer_payment', $data);
        }
    }
    /*================ End Setting Timer Payment Gateway ================*/

    public function updateStatusInvalidTrx(Request $request)
    {
        $post = $request->except('_token');
        $update = MyHelper::post('transaction/update-invalid-flag', $post);

        return $update;
    }

    public function listLogInvalidFlag(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
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

    public function sendReportToOutlet(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Transaction',
                'menu_active'    => 'transaction',
                'sub_title'      => 'Send Report To Outlet',
                'submenu_active' => 'transactions-send-report-to-outlet'
            ];
            $data['outlets'] = MyHelper::get('outlet/be/list?log_save=0')['result'] ?? [];
            return view('transaction::transaction.transaction_send_report_outlet', $data);
        } else {
            if ($post['outlet_available_type'] == 'no_all') {
                unset($post['outlet_available_type']);
            } else {
                unset($post['outlet_available_type']);
                $post['all_outlet'] = 1;
            }

            $data = MyHelper::post('disburse/sendRecapTransactionEachOultet', $post);

            if (isset($data['status']) && $data['status'] == 'success') {
                return redirect('transaction/send-report-outlet')->withSuccess(['Success triger send report transaction']);
            } else {
                return redirect('transaction/send-report-outlet')->withErrors(['Failed triger send report transaction']);
            }
        }
    }

    public function retryRefund(Request $request)
    {
        $post = $request->except('_token');
        $response = MyHelper::post('transaction/retry-void-payment/retry', $post);
        return $response;
    }

    /*================ Start Setting Delivery ================*/
    public function availableDelivery(Request $request)
    {
        $data = [
            'title'          => 'Available Delivery',
            'menu_active'    => 'delivery-settings',
            'sub_title'      => 'Available Delivery',
            'submenu_active' => 'delivery-setting-available'
        ];
        $get = MyHelper::post('transaction/be/available-delivery', ['all' => 1]);
        $data['default_delivery'] = $get['result']['default_delivery'] ?? [];
        $data['delivery'] = $get['result']['delivery'] ?? [];
        return view('transaction::setting.delivery_setting.available_delivery', $data);
    }
    public function availableDeliveryUpdate(Request $request)
    {
        $post = $request->except('_token');

        $delivery = [];
        foreach ($request->delivery as $code => $val) {
            $services = [];

            foreach ($val['service'] as $s) {
                $services[] = [
                    "code" => $s['code'],
                    "service_name" => $s['service_name'],
                    "available_status" => $s['available_status'] ?? 0,
                    "drop_counter_status" => $s['drop_counter_status'] ?? 0
                ];
            }

            $delivery[] = [
                "delivery_name" => $val['delivery_name'],
                "delivery_method" => $code,
                "service" => $services
            ];
        }

        $data = MyHelper::post('transaction/available-delivery/update', ['delivery' => $delivery]);

        if (($data['status'] ?? false) == 'success') {
            return back()->withSuccess(['Success update setting']);
        } else {
            return back()->withErrors(['Failed update setting']);
        }
    }

    public function deliveryOutlet()
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'delivery-settings',
            'sub_title'      => 'Outlet Availability',
            'submenu_active' => 'delivery-setting-outlet'
        ];
        $data['delivery'] = MyHelper::get('outlet/list-delivery/count-outlet')['result'] ?? [];
        return view('transaction::setting.delivery_setting.delivery_outlet_list', $data);
    }

    public function deliveryOutletDetail(Request $request, $code)
    {
        $post = $request->except('_token');

        if (!empty($post['submit_all'])) {
            $post['code'] = $code;
            $update = MyHelper::post('outlet/delivery-outlet/all/update', $post);

            if (($update['status'] ?? false) == 'success') {
                return redirect('transaction/setting/delivery-outlet/detail/' . $code)->withSuccess(['Success update setting']);
            } else {
                return redirect('transaction/setting/delivery-outlet/detail/' . $code)->withErrors($update['messages'] ?? ['Failed update setting']);
            }
        } elseif (!isset($post['id_outlet_not_available'])) {
            $data = [
                'title'          => 'Transaction',
                'menu_active'    => 'delivery-settings',
                'sub_title'      => 'Outlet Availability Detail',
                'submenu_active' => 'delivery-setting-outlet',
                'code' => $code
            ];
            $data['delivery_outlet'] = MyHelper::post('outlet/delivery-outlet/bycode', ['code' => $code])['result'] ?? [];
            $notAvailable = [];
            $hide = [];
            foreach ($data['delivery_outlet'] as $val) {
                if ($val['code'] == $code && $val['available_status'] == 0) {
                    $notAvailable[] = $val['id_outlet'];
                }

                if ($val['code'] == $code && $val['show_status'] == 0) {
                    $hide[] = $val['id_outlet'];
                }
            }
            $data['delivery_outlet_not_available'] = $notAvailable;
            $data['delivery_outlet_hide'] = $hide;
            $data['outlet_group_filter'] = MyHelper::get('outlet/group-filter')['result'] ?? [];

            $data['city'] = MyHelper::get('city/list')['result'] ?? [];
            $data['province'] = MyHelper::get('province/list')['result'] ?? [];
            $data['filter_type'] = $post['filter_type'] ?? '';

            $data['id_outlet_group_filter'] = null;
            $data['conditions'] = [];

            if ($data['filter_type'] == 'conditions') {
                $data['conditions'] = $post['conditions'] ?? [];
            } elseif ($data['filter_type'] == 'outlet_group') {
                $data['id_outlet_group_filter'] = $post['id_outlet_group_filter'] ?? null;
            }
            return view('transaction::setting.delivery_setting.delivery_outlet_detail', $data);
        } else {
            $post['id_outlet_not_available'] = str_replace('[', '', $post['id_outlet_not_available']);
            $post['id_outlet_not_available'] = str_replace(']', '', $post['id_outlet_not_available']);
            $post['id_outlet_hide'] = str_replace('[', '', $post['id_outlet_hide']);
            $post['id_outlet_hide'] = str_replace(']', '', $post['id_outlet_hide']);
            $update = MyHelper::post('outlet/delivery-outlet/update', ['code' => $code, 'id_outlet_not_available' => explode(',', $post['id_outlet_not_available'][0] ?? []),
                'id_outlet_hide' => explode(',', $post['id_outlet_hide'][0] ?? [])]);
            if (($update['status'] ?? false) == 'success') {
                return redirect('transaction/setting/delivery-outlet/detail/' . $code . (!empty($post['id_outlet_group_filter']) ? '?outlet_group_filter=' . $post['id_outlet_group_filter'] : ''))->withSuccess(['Success update setting']);
            } else {
                return back()->withErrors($update['messages'] ?? ['Failed update setting']);
            }
        }
    }

    public function deliveryOutletUpdateAll(Request $request, $code)
    {
        $post = $request->except('_token');
        $post['code'] = $code;
        $update = MyHelper::post('outlet/delivery-outlet/all/update', $post);

        return $update;
    }

    public function packageDetailDelivery(Request $request)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            $update = MyHelper::post('transaction/setting/package-detail-delivery', $post);
            if (isset($update['status']) && $update['status'] == 'success') {
                return redirect('transaction/setting/package-detail-delivery')->with(['success' => ['Update Success']]);
            } else {
                return redirect('transaction/setting/package-detail-delivery')->withErrors(['Update failed']);
            }
        } else {
            $data = [
                'title'          => 'Order',
                'menu_active'    => 'delivery-settings',
                'sub_title'      => 'Package Detail Delivery',
                'submenu_active' => 'delivery-setting-package-detail'
            ];

            $request = MyHelper::get('transaction/setting/package-detail-delivery');
            if (isset($request['status']) && $request['status'] == 'success') {
                $data['result'] = $request['result'];
            }

            return view('transaction::setting.delivery_setting.package_detail_delivery', $data);
        }
    }

    public function deliveryOutletImport(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Order',
                'menu_active'    => 'delivery-settings',
                'sub_title'      => 'Import/Export Outlet Availability',
                'submenu_active' => 'delivery-setting-outlet-import'
            ];
            return view('transaction::setting.delivery_setting.delivery_outlet_export_import', $data);
        } else {
            if ($request->file('import_file')) {
                $path = $request->file('import_file')->getRealPath();
                $name = $request->file('import_file')->getClientOriginalName();
                $dataimport = \Excel::toCollection(new FirstSheetOnlyImport(), $request->file('import_file'));
                $save = MyHelper::post('outlet/import-delivery', ['data_import' => $dataimport]);

                if (isset($save['status']) && $save['status'] == "success") {
                    return back()->withSuccess([$save['message'] ?? 'Success update setting']);
                } else {
                    if (isset($save['errors'])) {
                        return back()->withErrors($save['errors'])->withInput();
                    }

                    if (isset($save['status']) && $save['status'] == "fail") {
                        return back()->withErrors($save['messages'])->withInput();
                    }
                    return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
                }
            } else {
                return back()->withErrors(['File is required.'])->withInput();
            }
        }
    }

    public function exportDeliveryOutlet()
    {
        $deliveries = MyHelper::get('transaction/be/available-delivery')['result']['delivery'] ?? [];
        $codeOutlet =  MyHelper::get('outlet/list/code');

        $data = [];
        if (isset($codeOutlet['status']) && $codeOutlet['status'] == 'success') {
            $count = count($codeOutlet['result']);
            $result = $codeOutlet['result'];
            for ($i = 0; $i < $count; $i++) {
                $data[$i]['outlet_name'] = $result[$i]['outlet_name'];
                $data[$i]['outlet_code'] = $result[$i]['outlet_code'];
                $delivery = $result[$i]['delivery_outlet'];
                foreach ($deliveries as $value) {
                    $check = array_search($value['code'], array_column($delivery, 'code'));

                    if ($check !== false && $delivery[$check]['show_status'] == 0) {
                        $data[$i][$value['code'] . '(Show/Hide)'] = 'Hide';
                    } else {
                        $data[$i][$value['code'] . '(Show/Hide)'] = 'Show';
                    }

                    if ($check !== false && $delivery[$check]['available_status'] == 0) {
                        $data[$i][$value['code'] . '(Enable/Disable)'] = 'Disable';
                    } else {
                        $data[$i][$value['code'] . '(Enable/Disable)'] = 'Enable';
                    }
                }
            }
        }

        $dataExport['All Type'] = $data;
        $dataExport = new MultisheetExport($dataExport);
        return Excel::download($dataExport, 'Data_Delivery_Outlet_' . date('Ymdhis') . '.xls');
    }

    public function deliveryUploadImage(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Order',
                'menu_active'    => 'delivery-settings',
                'sub_title'      => 'Delivery Upload Image',
                'submenu_active' => 'delivery-setting-upload-image'
            ];
            $getData = MyHelper::get('transaction/setting/image-delivery')['result'] ?? [];
            $data['default_image_delivery'] = $getData['default_image_delivery'] ?? "";
            $data['delivery'] = $getData['delivery'] ?? [];
            return view('transaction::setting.delivery_setting.upload_image_delivery', $data);
        } else {
            $postdt = [];
            if (!empty($post['image_default'])) {
                $postdt['image_default'] = MyHelper::encodeImage($post['image_default']);
            }
            if (!empty($post['images'])) {
                foreach ($post['images'] as $key => $value) {
                    if (!empty($value)) {
                        $postdt['images'][$key] = MyHelper::encodeImage($value);
                    }
                }
            }

            $uploadImage = MyHelper::post('transaction/setting/image-delivery', $postdt);
            if (isset($uploadImage['status']) && $uploadImage['status'] == "success") {
                return redirect('transaction/setting/delivery-upload-image')->withSuccess(['Success upload image']);
            } else {
                return redirect('transaction/setting/delivery-upload-image')->withErrors($uploadImage['messages'] ?? ['Something when wrong. Failed upload image.'])->withInput();
            }
        }
    }
    /*================ End Setting Delivery ================*/
    
    
    public function step1(Request $request, $id){
        $post = $request->except('_token');
        $post['id'] = $id;
        $post['step_number'] = 1;
        $update = MyHelper::post('transaction/be/update/step',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success update data']);
        }else{
            return redirect()->back()->withErrors($update['messages']??['Failed update data to approved']);
        }
    }
    public function step(Request $request){
        $post = $request->except('_token');
        $update = MyHelper::post('transaction/be/update/step',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success update data']);
        }else{
            return redirect()->back()->withErrors($update['messages']??['Failed update data to approved']);
        }
    }
    
//    kontraktor
     public function kontraktorStep1(Request $request, $id){
        $post = $request->except('_token');
        $post['id'] = $id;
        $post['step_number'] = 1;
        $update = MyHelper::post('transaction/be/update/kontraktor/step',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success update data']);
        }else{
            return redirect()->back()->withErrors($update['messages']??['Failed update data to approved']);
        }
    }
    public function kontraktorStep(Request $request){
        $post = $request->except('_token');
        return $update = MyHelper::post('transaction/be/update/kontraktor/step',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success update data']);
        }else{
            return redirect()->back()->withErrors($update['messages']??['Failed update data to approved']);
        }
    }
    
    
    
    
}
