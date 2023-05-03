<?php

namespace Modules\PromoCampaign\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;

class PromoCampaignController extends Controller
{
    public function sessionMixer($request, &$post, $sess = 'promo_campaign_filter')
    {
        $session = session($sess);
        $session = is_array($session) ? $session : array();
        $post = array_merge($session, $post);
        session([$sess => $post]);
    }

    public function index(Request $request)
    {
        $post = $request->except('_token');

        if ($request->post('clear') == 'session') {
            session(['promo_campaign_filter' => '']);
        }

        $this->sessionMixer($request, $post);
        if (!$request->get('promo_type')) {
            unset($post['promo_type']);
        }


        $data = [
            'title'             => 'Promo Campaign List',
            'menu_active'       => 'promo-campaign',
            'submenu_active'    => 'promo-campaign-list'
        ];

        if (empty($post)) {
            $get_data = MyHelper::get('promo-campaign?promo_type=' . $request->get('promo_type') . '&page=' . $request->get('page'));
        } else {
            if (isset($post['page'])) {
                $get_data = MyHelper::post('promo-campaign/filter?page=' . $post['page'], $post);
            } else {
                $get_data = MyHelper::post('promo-campaign/filter?page=' . $request->get('page'), $post);
            }
        }

        if ($request->get('status') != '') {
            $url = url()->current() . '?status=' . $request->get('status');
        } else {
            $url = url()->current();
        }

        // pagination data
        if (!empty($get_data['result']['data']) && $get_data['status'] == 'success' && !empty($get_data['result']['data'])) {
            $get_data['result']['data'] = array_map(function ($var) {
                $var['id_promo_campaign'] = MyHelper::createSlug($var['id_promo_campaign'], $var['created_at']);
                return $var;
            }, $get_data['result']['data']);
            $data['promo']            = $get_data['result']['data'];
            $data['promoTotal']       = $get_data['result']['total'];
            $data['promoPerPage']     = $get_data['result']['from'];
            $data['promoUpTo']        = $get_data['result']['from'] + count($get_data['result']['data']) - 1;
            $data['promoPaginator']   = new LengthAwarePaginator($get_data['result']['data'], $get_data['result']['total'], $get_data['result']['per_page'], $get_data['result']['current_page'], ['path' => $url]);
            $data['total']            = $get_data['result']['total'];
        } else {
            $data['promo']          = [];
            $data['promoTotal']     = 0;
            $data['promoPerPage']   = 0;
            $data['promoUpTo']      = 0;
            $data['promoPaginator'] = false;
            $data['total']          = 0;
        }

        $getOutlet = MyHelper::get('outlet/be/list?log_save=0');
        if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') {
            $data['outlets'] = $getOutlet['result'];
        } else {
            $data['outlets'] = [];
        }

        $getProduct = MyHelper::get('product/list?log_save=0');
        if (isset($getProduct['status']) && $getProduct['status'] == 'success') {
            $data['products'] = $getProduct['result'];
        } else {
            $data['products'] = [];
        }

        // data product & outlet for filter
        $data['products'] = array_map(function ($x) {
            return [$x['id_product'], $x['product_name']];
        }, $data['products']);
        array_unshift($data['products'], ['0', 'All Products']);
        $data['outlets'] = array_map(function ($x) {
            return [$x['id_outlet'], $x['outlet_name']];
        }, $data['outlets']);
        array_unshift($data['outlets'], ['0', 'All Outlets']);

        // data rule for filter
        if (isset($get_data['rule'])) {
            $filter = array_map(function ($x) {
                return [$x['subject'], $x['operator'] ?? '', $x['parameter']];
            }, $get_data['rule']);
            $data['rule'] = $filter;
        }

        return view('promocampaign::list', $data);
    }

    public function detail(Request $request, $slug)
    {
        $exploded = MyHelper::explodeSlug($slug);
        $id_promo_campaign = $exploded[0];
        $created_at = $exploded[1];
        $post = $request->except('_token');
        $launch_modal = $post['modal'] ?? 0;

        if ($request->post('clear') == 'session') {
            session(['report_promo_campaign_' . $id_promo_campaign => '']);
            unset($post['rule']);
            $session = session('coupon_promo_campaign_' . $id_promo_campaign);
            unset($session['rule']);
            session(['coupon_promo_campaign_' . $id_promo_campaign => $session]);
        } elseif ($request->post('clear2') == 'session') {
            session(['coupon_promo_campaign_' . $id_promo_campaign => '']);
            unset($post['rule2']);
            $session = session('report_promo_campaign_' . $id_promo_campaign);
            unset($session['rule2']);
            session(['report_promo_campaign_' . $id_promo_campaign => $session]);
        }

        $this->sessionMixer($request, $post, 'report_promo_campaign_' . $id_promo_campaign);
        $this->sessionMixer($request, $post, 'coupon_promo_campaign_' . $id_promo_campaign);

        $post['id_promo_campaign'] = $id_promo_campaign;
        if ($request->input('coupon') == 'true') {
            return $this->ajaxCoupon($post);
        } elseif ($request->input('ajax') == 'true') {
            return $this->ajaxPromoCampaign($post);
        }

        $result = MyHelper::post('promo-campaign/detail', $post);

        if (($result['status'] == 'success') ?? false) {
            $result['result']['id_promo_campaign'] = MyHelper::createSlug($result['result']['id_promo_campaign'], $result['result']['created_at']);
            $data = [
                'title'             => 'Promo Campaign',
                'sub_title'         => 'Detail',
                'menu_active'       => 'promo-campaign',
                'submenu_active'    => 'promo-campaign-list',
                'result'            => $result['result']
            ];

            $data['rule'] = $post['rule'] ?? [];
            if (isset($data['rule'])) {
                $filter = array_map(function ($x) {
                    return [$x['subject'], $x['operator'] ?? '', $x['parameter']];
                }, $data['rule']);
                $data['rule'] = $filter;
            }

            $data['rule2'] = $post['rule2'] ?? [];
            if (isset($data['rule2'])) {
                $filter = array_map(function ($x) {
                    return [$x['subject'], $x['operator'] ?? '', $x['parameter']];
                }, $data['rule2']);
                $data['rule2'] = $filter;
            }

            $outlets = MyHelper::post('outlet/be/list', $post);
            $data['payment_list'] = MyHelper::post('transaction/available-payment', ['show_all' => 0])['result'] ?? [];
            $data['delivery_list'] = MyHelper::get('transaction/be/available-delivery')['result']['delivery'] ?? [];

            $outlets = isset($outlets['status']) && isset($outlets['status']) == 'success' ? $outlets['result'] : [];
            $data['outlets'] = array_map(function ($x) {
                return [$x['id_outlet'],$x['outlet_name']];
            }, $outlets);
            $data['operator'] = $post['operator'] ?? 'and';
            $data['operator2'] = $post['operator2'] ?? 'and';
            if ($launch_modal) {
                $data['launch_modal'] = 1;
            }

            return view('promocampaign::detail', $data);
        } else {
            return redirect('promo-campaign')->withErrors(['Promo Campaign Not Found']);
        }
    }

    public function ajaxPromoCampaign($input)
    {
        $return = $input;

        $return['draw'] = (int)$input['draw'];
        $getPromoCampaignReport = MyHelper::post('promo-campaign/report', $input);

        if ($getPromoCampaignReport['status'] == 'success') {
            $return['recordsTotal'] = $getPromoCampaignReport['total'];
            $return['recordsFiltered'] = $getPromoCampaignReport['count'];
            $return['data'] = array_map(function ($x) {
                $trxUrl = url('transaction/detail/' . $x['id_transaction'] . '/' . strtolower($x['transaction']['trasaction_type']));
                return [
                    $x['promo_campaign_promo_code']['promo_code'],
                    $x['user_name'] . ' (' . $x['user_phone'] . ')',
                    $x['created_at'],
                    "<a href='$trxUrl' target='_blank'>{$x['transaction']['transaction_receipt_number']}</a>",
                    $x['device_type']
                ];
            }, $getPromoCampaignReport['result']);
            return $return;
        } else {
            $return['recordsTotal'] = 0;
            $return['recordsFiltered'] = 0;
            $return['data'] = [];
            return $return;
        }
    }

    public function ajaxCoupon($input)
    {
        $return = $input;
        $return['draw'] = (int)$input['draw'];

        $getPromoCampaignCoupon = MyHelper::post('promo-campaign/coupon', $input);

        if (($getPromoCampaignCoupon['status'] ?? false) == 'success') {
            $return['recordsTotal'] = $getPromoCampaignCoupon['total'];
            $return['recordsFiltered'] = $getPromoCampaignCoupon['count'];
            $return['data'] = array_map(function ($x) {
                $status = $x['usage'] == 0 ? 'Not used' : ($x['usage'] == $x['code_limit'] ? 'Used' : 'Available');
                $used = $x['usage'] != 0 ? $x['usage'] : '';
                $available = $x['code_limit'] != 0 ? $x['code_limit'] - $x['usage'] : 'Unlimited';
                $max_usage = $x['code_limit'] != 0 ? $x['code_limit'] : 'Unlimited';
                return [
                    $x['promo_code'],
                    $status,
                    $used,
                    $available,
                    $max_usage
                ];
            }, $getPromoCampaignCoupon['result']);
            return $return;
        } else {
            $return['recordsTotal'] = 0;
            $return['recordsFiltered'] = 0;
            $return['data'] = [];
            return $return;
        }
    }

    public function step1(Request $request, $slug = null)
    {
        if ($slug) {
            $exploded = MyHelper::explodeSlug($slug);
            $id_promo_campaign = $exploded[0];
            $created_at = $exploded[1];
        } else {
            $id_promo_campaign = null;
            $created_at = null;
        }
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'             => 'Promo Campaign',
                'sub_title'         => 'Step 1',
                'menu_active'       => 'promo-campaign',
                'submenu_active'    => 'promo-campaign-create'
            ];

            if (isset($id_promo_campaign)) {
                $get_data = MyHelper::post('promo-campaign/show-step1', ['id_promo_campaign' => $id_promo_campaign]);

                if (($get_data['status'] ?? false) == 'success') {
                    $data['result'] = $get_data['result'] ?? '';
                    $data['result']['id_promo_campaign_decrypt'] = $data['result']['id_promo_campaign'];
                    $data['result']['id_promo_campaign'] = $slug;
                } else {
                    return redirect('promo-campaign')->withErrors($get_data['messages'] ?? ['Something went wrong']);
                }
            }
            $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
            return view('promocampaign::create-promo-campaign-step-1', $data);
        } else {
            if ((isset($post['charged_central']) || isset($post['charged_outlet']) && !isset($post['used_code_update']))) {
                $check = $post['charged_central'] + $post['charged_outlet'];
                if ($check != 100) {
                    return back()->withErrors(['Value charged central and charged outlet not valid'])->withInput();
                }
            }

            if (!empty($id_promo_campaign)) {
                $post['id_promo_campaign'] = $id_promo_campaign;
                $messages = ['Promo Campaign has been updated'];
            }

            if (!empty($post['promo_image'])) {
                $post['promo_image']  = MyHelper::encodeImage($post['promo_image']);
            }

            if (!empty($post['promo_image_detail'])) {
                $post['promo_image_detail']  = MyHelper::encodeImage($post['promo_image_detail']);
            }

            $action = MyHelper::post('promo-campaign/step1', $post);

            if (isset($action['status']) && $action['status'] == 'success') {
                return redirect('promo-campaign/step2/' . ($slug ?: MyHelper::createSlug($action['promo-campaign']['id_promo_campaign'], '')))->withSuccess($messages ?? ['Promo Campaign has been created']);
            } else {
                return back()->withErrors($action['message'] ?? $action['messages'] ?? $action['result'] ?? ['Something went wrong'])->withInput();
            }
        }
    }

    public function step2(Request $request, $slug)
    {
        $exploded = MyHelper::explodeSlug($slug);
        $id_promo_campaign = $exploded[0];
        $created_at = $exploded[1];
        $post = $request->except('_token');

        if (empty($post)) {
            $get_data = MyHelper::post('promo-campaign/show-step2', ['id_promo_campaign' => $id_promo_campaign]);

            $data = [
                'title'             => 'Promo Campaign',
                'sub_title'         => 'Step 2',
                'menu_active'       => 'promo-campaign',
                'submenu_active'    => 'promo-campaign-create'
            ];

            if (isset($get_data['status']) && $get_data['status'] == 'success') {
                $data['result'] = $get_data['result'];
                $data['result']['id_promo_campaign'] = $slug;
                $data['payment_list'] = MyHelper::post('transaction/available-payment', ['show_all' => 0])['result'] ?? [];
                $data['delivery_list'] = MyHelper::get('transaction/be/available-delivery')['result']['delivery'] ?? [];
            } else {
                return redirect('promo-campaign')->withErrors($get_data['messages'] ?? ['Something went wrong']);
            }

            return view('promocampaign::promo-campaign-step-2', $data);
        } else {
            $post['id_promo_campaign'] = $id_promo_campaign;
            $msg_success = ['Promo Campaign has been updated'];
            if (($post['promo_type'] ?? false) == 'Discount delivery') {
                if (isset($post['shipment_method'])) {
                    $shipment = $post['shipment_method'];
                    $shipment = array_flip($shipment);
                    unset($shipment['Pickup Order']);
                    $shipment = array_flip($shipment);
                }

                if (!empty($shipment)) {
                    $shipment_text  = implode(', ', $shipment);
                    $msg_shipment   = 'Tipe shipment yang tersimpan adalah delivery ' . $shipment_text . ' karena tipe promo yang dipilih merupakan diskon delivery';
                } else {
                    $msg_shipment   = 'Tipe shipment yang tersimpan adalah all shipment';
                }

                $msg_success[]  = $msg_shipment;
            }

            $action = MyHelper::post('promo-campaign/step2', $post);

            if (isset($action['status']) && $action['status'] == 'success') {
                $redirect = redirect('promo-campaign/detail/' . $slug)->withSuccess($msg_success);

                if (isset($action['brand_product_error'])) {
                    $redirect = redirect('promo-campaign/step2/' . $slug)->withSuccess($msg_success)->withErrors($action['brand_product_error'] ?? []);
                }

                return $redirect;
            } elseif ($action['messages'] ?? false) {
                return back()->withErrors($action['messages'])->withInput();
            } else {
                return back()->withErrors(['Something went wrong'])->withInput();
            }
        }
    }

    public function getTag()
    {
        $action = MyHelper::post('promo-campaign/getTag', ['get' => 'Tag']);

        if (empty($action)) {
            $action = [];
        }
        return $action;
    }

    public function checkCode()
    {
        $action = MyHelper::post('promo-campaign/check', $_GET);

        return $action;
    }

    public function getData(Request $request)
    {
        $action = MyHelper::post('promo-campaign/getData', $request->all());

        return $action;
    }

    public function delete(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['id_promo_campaign'])) {
            $post['id_promo_campaign'] = MyHelper::explodeSlug($post['id_promo_campaign'])[0];
        }

        $delete = MyHelper::post('promo-campaign/delete', $post);

        if (($delete['status'] ?? '') == 'success') {
            return redirect()->back()->withSuccess([$delete['status']]);
        } elseif (($delete['status'] ?? '') == 'fail') {
            return redirect()->back()->withErrors([$delete['messages'] ?? $delete['status']]);
        } else {
            return redirect()->back()->withErrors(['Something went wrong']);
        }
    }

    public function exportPromoCode(Request $request)
    {
        $post = $request->except('_token');
        $id_encrypt = $post['id_promo_campaign'];
        $post['id_promo_campaign'] = MyHelper::explodeSlug($post['id_promo_campaign'])[0];
        $export = MyHelper::post('promo-campaign/export/create', $post);

        if (isset($export['status']) && $export['status'] == "success") {
            return redirect('promo-campaign/detail/' . $id_encrypt . '?modal=1#coupon')->withSuccess(['Success create export to queue']);
        } else {
            return redirect('promo-campaign/detail/' . $id_encrypt . '?modal=1#coupon')->withErrors(['Failed create export to queue']);
        }
    }

    public function actionExport(Request $request, $action, $id)
    {
        $post = $request->except('_token');

        $post['action'] = $action;
        $id_encrypt = $id;
        $post['id_promo_campaign'] = MyHelper::explodeSlug($id)[0];

        $actions = MyHelper::post('promo-campaign/export/action', $post);

        if ($action == 'deleted') {
            if (isset($actions['status']) && $actions['status'] == "success") {
                return redirect('promo-campaign/detail/' . $id_encrypt . '?modal=1#coupon')->withSuccess(['Success to Remove file']);
            } else {
                return redirect('promo-campaign/detail/' . $id_encrypt . '?modal=1#coupon')->withErrors(['Failed to Remove file']);
            }
        } else {
            if (isset($actions['status']) && $actions['status'] == "success") {
                $link = $actions['result']['export_url'];
                $filename = urlencode("Promo Code_" . $actions['result']['campaign_name'] . '_' . strtotime(date('Ymdhis')) . '.xlsx');
                $tempImage = tempnam(sys_get_temp_dir(), $filename);
                copy($link, $tempImage);

                return response()->download($tempImage, $filename)->deleteFileAfterSend(true);
            } else {
                return redirect('promo-campaign/detail/' . $id_encrypt . '?modal=1#coupon')->withErrors(['Failed to Download file']);
            }
        }
    }

    public function extendPeriod(Request $request)
    {
        $post = $request->except('_token');
        $id_deals_encrypt = $post['id_deals'];
        $id_promo_campaign_encrypt = $post['id_promo_campaign'];
        $id_subscription_encrypt = $post['id_subscription'];
        $post['id_deals'] = MyHelper::explodeSlug($id_deals_encrypt)[0] ?? null;
        $post['id_promo_campaign'] = MyHelper::explodeSlug($id_promo_campaign_encrypt)[0] ?? null;
        $post['id_subscription'] = MyHelper::explodeSlug($id_subscription_encrypt)[0] ?? null;

        $action = MyHelper::post('promo-campaign/extend-period', $post);

        $redirect = redirect()->back();
        if (($action['status'] ?? false) == 'success') {
            $redirect->withSuccess(['Period has been extended']);
        } else {
            $redirect->withInput()->withErrors($action['messages'] ?? ['Failed to extend period']);
        }
        return $redirect;
    }

    public function updatePromoDescription(Request $request)
    {
        $post = $request->except('_token');
        $id_deals_encrypt = $post['id_deals'];
        $id_promo_campaign_encrypt = $post['id_promo_campaign'];
        $id_subscription_encrypt = $post['id_subscription'];
        $id_deals_promotion_encrypt = $post['id_deals_promotion_template'];
        $post['id_deals'] = MyHelper::explodeSlug($id_deals_encrypt)[0] ?? null;
        $post['id_promo_campaign'] = MyHelper::explodeSlug($id_promo_campaign_encrypt)[0] ?? null;
        $post['id_subscription'] = MyHelper::explodeSlug($id_subscription_encrypt)[0] ?? null;
        $post['id_deals_promotion_template'] = MyHelper::explodeSlug($id_deals_promotion_encrypt)[0] ?? null;

        $action = MyHelper::post('promo-campaign/promo-description', $post);

        $redirect = redirect()->back();
        if (($action['status'] ?? false) == 'success') {
            $redirect->withSuccess(['Promo description has been updated']);
        } else {
            $redirect->withInput()->withErrors($action['messages'] ?? ['Failed to update promo description']);
        }
        return $redirect;
    }

    /* Featured Promo Campaign */
    public function listFeaturedPromoCampaign(Request $request)
    {
        $data = [
            'title'             => 'Promo Campaign',
            'sub_title'         => 'Featured Promo Campaign Merchant',
            'menu_active'       => 'promo-campaign',
            'submenu_active'    => 'promo-campaign-featured-merchant'
        ];

        // featured promo campaign
        $data['featured_promo_campaigns'] = MyHelper::get('setting/featured_promo_campaign/list-merchant')['result'] ?? [];
        $data['promo_campaigns'] = MyHelper::get('promo-campaign/active-campaign?featured=true&promo_use=Product&featured_type=merchant')['result'] ?? [];

        return view('promocampaign::featured_promo_campaign', $data);
    }

    public function createFeaturedPromoCampaign(Request $request)
    {
        $post = $request->except('_token');
        $post['feature_type'] = 'merchant';
        $result = MyHelper::post('setting/featured_promo_campaign/create', $post);

        if (isset($result['status']) && $result['status'] == 'success') {
            return redirect('promo-campaign/featured-merchant')->withSuccess(['New featured promo campaign has been created']);
        } else {
            return redirect('promo-campaign/featured-merchant')->withErrors($result['messages'] ?? ['Something went wrong']);
        }
    }

    public function updateFeaturedPromoCampaign(Request $request)
    {
        $post = $request->except('_token');
        $validatedData = $request->validate([
            'id_featured_promo_campaign'    => 'required'
        ]);
        $result = MyHelper::post('setting/featured_promo_campaign/update', $post);

        if (isset($result['status']) && $result['status'] == 'success') {
            return redirect('promo-campaign/featured-merchant')->withSuccess(['Featured promo campaign has been updated']);
        } else {
            return redirect('promo-campaign/featured-merchant')->withErrors($result['messages'] ?? ['Something went wrong']);
        }
    }

    public function reorderFeaturedPromoCampaign(Request $request)
    {
        $post = $request->except("_token");
        $result = MyHelper::post('setting/featured_promo_campaign/reorder', $post);

        if (isset($result['status']) && $result['status'] == 'success') {
            return redirect('promo-campaign/featured-merchant')->withSuccess(['Featured promo campaign has been sorted']);
        } else {
            return redirect('promo-campaign/featured-merchant')->withErrors($result['messages'] ?? ['Something went wrong']);
        }
    }

    public function deleteFeaturedPromoCampaign($id_promo_campaign)
    {
        $post['id_featured_promo_campaign'] = $id_promo_campaign;
        $result = MyHelper::post('setting/featured_promo_campaign/delete', $post);

        if (isset($result['status']) && $result['status'] == 'success') {
            return redirect('promo-campaign/featured-merchant')->withSuccess(['Featured promo campaign has been deleted']);
        } else {
            return redirect('promo-campaign/featured-merchant')->withErrors($result['messages'] ?? ['Something went wrong']);
        }
    }

    public function updateVisibility(Request $request)
    {
        $post = $request->except('_token');
        $post['id_promo_campaign'] = MyHelper::explodeSlug($post['id_promo_campaign'])[0] ?? null;
        $update = MyHelper::post('promo-campaign/update-visibility', $post);
        return $update;
    }

    public function sharePromo(Request $request)
    {
        $data = [
            'title'             => 'Share Promo Campaign Code Message',
            'menu_active'       => 'promo-campaign',
            'submenu_active'    => 'promo-campaign-share-promo-code'
        ];
        if ($post = $request->except('_token')) {
            $data = [
                'update' => [
                    'share_promo_code' => ['value_text',$post['share_promo_code']],
                ]
            ];

            $result = MyHelper::post('setting/update2', $data);
            if (($result['status'] ?? '') == 'success') {
                return redirect('promo-campaign/share-promo')->with('success', ['Share promo campaign code message has been updated']);
            } else {
                return back()->withErrors($result['messages'] ?? ['Something went wrong']);
            }
        } else {
            $share_promo_code = MyHelper::post('setting', ['key' => 'share_promo_code'])['result']['value_text'] ?? '';
            $data['msg'] = [
                'share_promo_code' => $share_promo_code
            ];

            return view('promocampaign::share_promo_code', $data);
        }
    }
}
