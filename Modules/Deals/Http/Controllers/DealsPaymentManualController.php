<?php

namespace Modules\Deals\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Deals\Http\Requests\Create;

class DealsPaymentManualController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function manualPaymentList(Request $request, $type = null)
    {
        if (empty($type)) {
            Session::forget('filterDealPaymentManual');
            $type = 'unconfirmed';
        }
        $data = [
            'title'          => 'Manual Payment',
            'menu_active'    => 'manual-payment',
            'sub_title'      => 'Manual Payment Deals',
            'submenu_active' => 'manual-payment-deals',
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
            Session::put('filterDealPaymentManual', $post);

            $list = MyHelper::post('deals/manualpayment/filter/' . $type, $post);
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
                return view('deals::manual_payment.list', $data)->withErrors(['Data not found']);
            } else {
                return view('deals::manual_payment.list', $data)->withErrors($list['messages']);
            }
        } else {
            if (!empty(Session::get('filterDealPaymentManual'))) {
                $session = Session::get('filterDealPaymentManual');
                $data['date_start'] = $session['date_start'];
                $data['date_end'] = $session['date_end'];
                $data['conditions'] = $session['conditions'];
                $data['rule'] = $session['rule'];
                $data['filter'] = true;

                if (!empty($page)) {
                    $list = MyHelper::post('deals/manualpayment/filter/' . $type . '?page=' . $page, $session);
                } else {
                    $list = MyHelper::post('deals/manualpayment/filter/' . $type, $session);
                }
            } else {
                $data['date_start'] = date('Y-m-01');
                $data['date_end'] = date('Y-m-d');

                if (!empty($page)) {
                    $list = MyHelper::get('deals/manualpayment/' . $type . '?page=' . $page);
                } else {
                    $list = MyHelper::get('deals/manualpayment/' . $type);
                }
            }
            if (isset($list['status']) && $list['status'] == 'success') {
                if (!empty($list['result']['data'])) {
                    foreach ($list['result']['data'] as $key => $value) {
                        $list['result']['data'][$key]['id_deals_payment_manual'] = MyHelper::createSlug($value['id_deals_payment_manual'], $value['created_at']);
                    }
                }
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
                return view('deals::manual_payment.list', $data)->withErrors($list['messages']);
            } else {
                $data['list'] = [];
            }
        }
        $data['pagination'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url('transaction/manualpayment/list/' . $type)]);
        return view('deals::manual_payment.list', $data);
    }

    public function resetFilter($type = null)
    {
        if (empty($type)) {
            $type = 'unconfirmed';
        }
        Session::forget('filterDealPaymentManual');
        return redirect('deals/manualpayment/list/' . $type);
    }


    public function manualPaymentConfirm(Request $request, $id)
    {
        $post = $request->except('_token');
        $id = MyHelper::explodeSlug($id)[0] ?? '';

        if (empty($post)) {
            $data = [
                'title'          => 'Manual Payment',
                'menu_active'    => 'manual-payment',
                'sub_title'      => 'Manual Payment Deals Detail',
                'submenu_active' => 'manual-payment-deals',
            ];

            $detail = MyHelper::post('deals/manualpayment/detail', ['id_deals_payment_manual' => $id]);
            if (isset($detail['status']) && $detail['status'] == 'success') {
                $data['result'] = $detail['result'];
            } else {
                return parent::redirect($detail, 'Data not valid');
            }

            return view('deals::manual_payment.confirm', $data);
        } else {
            $confirm = MyHelper::post('deals/manualpayment/confirm', $post);
            return parent::redirect($confirm, 'Deals Payment Manual has been confirmed.');
        }
    }
}
