<?php

namespace Modules\Campaign\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;
use Excel;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('campaign::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function campaignList(Request $request, $page = null)
    {
        $data = [ 'title'             => 'Campaign',
                  'sub_title'          => 'Campaign List',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-list'
                ];

        $post = $request->except(['_token']);
        // print_r($post);exit;
        $page = 1;
        if (Session::has('search-campaign') && !empty($post) && !isset($post['filter'])) {
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('search-campaign');
        } else {
            Session::forget('search-campaign');
        }
        $post['page'] = $post['page'] ?? $page;

        $action = MyHelper::post('campaign/list', $post);

        if (isset($action['status']) && $action['status'] == "success") {
            if (!empty($action['result']['data'])) {
                foreach ($action['result']['data'] as $key => $val) {
                    $action['result']['data'][$key]['id_campaign'] = MyHelper::createSlug($val['id_campaign'], $val['created_at']);
                    $action['result']['data'][$key]['id_user'] = MyHelper::createSlug($val['id_user'], $val['created_at']);
                }
            }
            $data['campaign']     = $action['result']['data'];
            $data['campaignTotal']     = $action['result']['total'];
            $data['campaignPerPage']   = $action['result']['from'];
            $data['campaignUpTo']      = $action['result']['from'] + count($action['result']['data']) - 1;
            $data['campaignPaginator'] = new LengthAwarePaginator($action['result']['data'], $action['result']['total'], $action['result']['per_page'], $action['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['campaign']          = [];
            $data['campaignTotal']     = 0;
            $data['campaignPerPage']   = 0;
            $data['campaignUpTo']      = 0;
            $data['campaignPaginator'] = false;
        }

        if (isset($post['campaign_title']) && !empty($post['campaign_title'])) {
            Session::put('search-campaign', ['campaign_title' => $post['campaign_title']]);
        }

        $data['post'] = $post;

        return view('campaign::list', $data);
    }

    public function emailOutboxDetail(Request $request, $id = null)
    {
        $data = [ 'title'             => 'Campaign Email Outbox Detail',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-email-outbox'
                ];

        $post = $request->except(['_token']);
        $id_decrypt = MyHelper::explodeSlug($id)[0] ?? '';

        $action = MyHelper::post('campaign/email/outbox/detail', ['id_campaign_email_sent' => $id_decrypt]);

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            $data['post'] = $post;
            // print_r($data);exit;
            return view('campaign::email-outbox-detail', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function emailOutbox(Request $request, $page = null)
    {
        $data = [ 'title'             => 'Campaign Email Outbox List',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-email-outbox'
                ];

        $post = $request->except(['_token']);
        if (!empty($post)) {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15, 'email_sent_subject' => $post['email_sent_subject']];
            } else {
                $post = ['skip' => 0, 'take' => 15, 'email_sent_subject' => $post['email_sent_subject']];
            }
        } else {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15];
            } else {
                $post = ['skip' => 0, 'take' => 15];
            }
        }

        $action = MyHelper::post('campaign/email/outbox/list', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            if (!empty($action['result'])) {
                foreach ($action['result'] as $key => $value) {
                    $action['result'][$key]['id_campaign_email_sent'] = MyHelper::createSlug($value['id_campaign_email_sent'], $value['created_at']);
                    $action['result'][$key]['id_campaign'] = MyHelper::createSlug($value['id_campaign'], $value['created_at']);
                    $action['result'][$key]['id_user'] = MyHelper::createSlug($value['id_user'], $value['created_at']);
                }
            }
            $data['result'] = $action['result'];
            $data['count'] = $action['count'];
            $data['post'] = $post;

            return view('campaign::email-outbox', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function emailQueueDetail(Request $request, $id = null)
    {
        $data = [ 'title'             => 'Campaign Email Queue Detail',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-email-queue'
                ];

        $post = $request->except(['_token']);
        $action = MyHelper::post('campaign/email/queue/detail', ['id_campaign_email_queue' => $id]);

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            $data['post'] = $post;
            // print_r($data);exit;
            return view('campaign::email-queue-detail', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function emailQueue(Request $request, $page = null)
    {
        $data = [ 'title'             => 'Campaign Email Queue List',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-email-queue'
                ];

        $post = $request->except(['_token']);
        // print_r($post);exit;
        if (!empty($post)) {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15, 'email_queue_subject' => $post['email_queue_subject']];
            } else {
                $post = ['skip' => 0, 'take' => 15, 'email_queue_subject' => $post['email_queue_subject']];
            }
        } else {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15];
            } else {
                $post = ['skip' => 0, 'take' => 15];
            }
        }

        $action = MyHelper::post('campaign/email/queue/list', $post);
        // print_r($action);exit;
        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            $data['count'] = $action['count'];
            $data['post'] = $post;
            return view('campaign::email-queue', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function smsOutboxDetail(Request $request, $id = null)
    {
        $data = [ 'title'             => 'Campaign SMS Outbox Detail',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-sms-outbox'
                ];
        $id_decrypt = MyHelper::explodeSlug($id)[0] ?? '';

        $post = $request->except(['_token']);
        $action = MyHelper::post('campaign/sms/outbox/detail', ['id_campaign_sms_sent' => $id_decrypt]);

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            $data['post'] = $post;
            // print_r($data);exit;
            return view('campaign::sms-outbox-detail', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function smsOutbox(Request $request, $page = null)
    {
        $data = [ 'title'             => 'Campaign SMS Outbox List',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-sms-outbox'
                ];

        $post = $request->except(['_token']);
        // print_r($post);exit;
        if (!empty($post)) {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15, 'sms_sent_content' => $post['sms_sent_content']];
            } else {
                $post = ['skip' => 0, 'take' => 15, 'sms_sent_content' => $post['sms_sent_content']];
            }
        } else {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15];
            } else {
                $post = ['skip' => 0, 'take' => 15];
            }
        }

        $action = MyHelper::post('campaign/sms/outbox/list', $post);
        if (isset($action['status']) && $action['status'] == 'success') {
            if (!empty($action['result'])) {
                foreach ($action['result'] as $key => $value) {
                    $action['result'][$key]['id_campaign_sms_sent'] = MyHelper::createSlug($value['id_campaign_sms_sent'], $value['created_at']);
                    $action['result'][$key]['id_campaign'] = MyHelper::createSlug($value['id_campaign'], $value['created_at']);
                    $action['result'][$key]['id_user'] = MyHelper::createSlug($value['id_user'], $value['created_at']);
                }
            }
            $data['result'] = $action['result'];
            $data['count'] = $action['count'];
            $data['post'] = $post;

            return view('campaign::sms-outbox', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function smsQueueDetail(Request $request, $id = null)
    {
        $data = [ 'title'             => 'Campaign SMS Queue Detail',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-sms-queue'
                ];
        $id_decrypt = MyHelper::explodeSlug($id)[0] ?? '';

        $post = $request->except(['_token']);
        $action = MyHelper::post('campaign/sms/queue/detail', ['id_campaign_sms_queue' => $id_decrypt]);

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            $data['post'] = $post;
            // print_r($data);exit;
            return view('campaign::sms-queue-detail', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function smsQueue(Request $request, $page = null)
    {
        $data = [ 'title'             => 'Campaign SMS Queue List',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-sms-queue'
                ];

        $post = $request->except(['_token']);
        // print_r($post);exit;
        if (!empty($post)) {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15, 'sms_queue_content' => $post['sms_queue_content']];
            } else {
                $post = ['skip' => 0, 'take' => 15, 'sms_queue_content' => $post['sms_queue_content']];
            }
        } else {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15];
            } else {
                $post = ['skip' => 0, 'take' => 15];
            }
        }

        $action = MyHelper::post('campaign/sms/queue/list', $post);
        // print_r($action);exit;
        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            $data['count'] = $action['count'];
            $data['post'] = $post;
            return view('campaign::sms-queue', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function pushOutboxDetail(Request $request, $id = null)
    {
        $data = [ 'title'             => 'Campaign Push Notification Outbox Detail',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-push-outbox'
                ];

        $id_decrypt = MyHelper::explodeSlug($id)[0] ?? '';

        $post = $request->except(['_token']);
        $action = MyHelper::post('campaign/push/outbox/detail', ['id_campaign_push_sent' => $id_decrypt]);
        // print_r($action);exit;
        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            $data['post'] = $post;
            // print_r($data);exit;
            return view('campaign::push-outbox-detail', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function pushOutbox(Request $request, $page = null)
    {
        $data = [ 'title'             => 'Campaign Push Notification Outbox List',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-push-outbox'
                ];

        $post = $request->except(['_token']);
        // print_r($post);exit;
        if (!empty($post)) {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15, 'push_sent_subject' => $post['push_sent_subject']];
            } else {
                $post = ['skip' => 0, 'take' => 15, 'push_sent_subject' => $post['push_sent_subject']];
            }
        } else {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15];
            } else {
                $post = ['skip' => 0, 'take' => 15];
            }
        }

        $action = MyHelper::post('campaign/push/outbox/list', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            if (!empty($action['result'])) {
                foreach ($action['result'] as $key => $value) {
                    $action['result'][$key]['id_campaign_push_sent'] = MyHelper::createSlug($value['id_campaign_push_sent'], $value['created_at']);
                    $action['result'][$key]['id_campaign'] = MyHelper::createSlug($value['id_campaign'], $value['created_at']);
                    $action['result'][$key]['id_user'] = MyHelper::createSlug($value['id_user'], $value['created_at']);
                }
            }
            $data['result'] = $action['result'];
            $data['count'] = $action['count'];
            $data['post'] = $post;

            return view('campaign::push-outbox', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function pushQueueDetail(Request $request, $id = null)
    {
        $data = [ 'title'             => 'Campaign Push Notification Queue Detail',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-push-queue'
                ];
        $id_decrypt = MyHelper::explodeSlug($id)[0] ?? '';

        $post = $request->except(['_token']);
        $action = MyHelper::post('campaign/push/queue/detail', ['id_campaign_push_queue' => $id_decrypt]);

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            $data['post'] = $post;
            // print_r($data);exit;
            return view('campaign::push-queue-detail', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function pushQueue(Request $request, $page = null)
    {
        $data = [ 'title'             => 'Campaign Push Notification Queue List',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-push-queue'
                ];

        $post = $request->except(['_token']);
        // print_r($post);exit;
        if (!empty($post)) {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15, 'push_queue_subject' => $post['push_queue_subject']];
            } else {
                $post = ['skip' => 0, 'take' => 15, 'push_queue_subject' => $post['push_queue_subject']];
            }
        } else {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15];
            } else {
                $post = ['skip' => 0, 'take' => 15];
            }
        }

        $action = MyHelper::post('campaign/push/queue/list', $post);
        // print_r($action);exit;
        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            $data['count'] = $action['count'];
            $data['post'] = $post;
            return view('campaign::push-queue', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function whatsappList(Request $request, $page = null)
    {
        $data = [ 'title'             => 'Campaign Whatsapp Outbox List',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-whatsapp-outbox'
                ];

        $post = $request->except(['_token']);
        // print_r($post);exit;
        if (!empty($post)) {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15];
            } else {
                $post = ['skip' => 0, 'take' => 15];
            }
        } else {
            if (!empty($page)) {
                $skip = ($page - 1) * 15;
                $post = ['skip' => $skip, 'take' => 15];
            } else {
                $post = ['skip' => 0, 'take' => 15];
            }
        }

        if (strpos(url()->current(), 'outbox') !== false) {
            $action = MyHelper::post('campaign/whatsapp/outbox/list', $post);
            $data['type'] = 'sent';
        } else {
            $action = MyHelper::post('campaign/whatsapp/queue/list', $post);
            $data['title'] = 'Campaign Whatsapp Queue List';
            $data['submenu_active'] = 'campaign-whatsapp-queue';
            $data['type'] = 'queue';
        }
        if (isset($action['status']) && $action['status'] == 'success') {
            if (!empty($action['result'])) {
                foreach ($action['result'] as $key => $value) {
                    $action['result'][$key]['id_campaign_whatsapp_sent'] = MyHelper::createSlug($value['id_campaign_whatsapp_sent'], $value['created_at']);
                    $action['result'][$key]['id_campaign'] = MyHelper::createSlug($value['id_campaign'], $value['created_at']);
                    $action['result'][$key]['id_user'] = MyHelper::createSlug($value['id_user'], $value['created_at']);
                }
            }
            $data['result'] = $action['result'];
            $data['count'] = $action['count'];
            $data['post'] = $post;

            return view('campaign::whatsapp-list', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function whatsappDetail(Request $request, $id = null)
    {
        $data = [ 'title'             => 'Campaign Whatsapp Outbox Detail',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-whatsapp-outbox'
                ];
        $id_decrypt = MyHelper::explodeSlug($id)[0] ?? '';
        $post = $request->except(['_token']);
        if (strpos(url()->current(), 'outbox') !== false) {
            $action = MyHelper::post('campaign/whatsapp/outbox/list', ['id_campaign_whatsapp_sent' => $id_decrypt]);
            $data['type'] = 'sent';
        } else {
            $action = MyHelper::post('campaign/whatsapp/queue/list', ['id_campaign_whatsapp_queue' => $id_decrypt]);
            $data['title'] = 'Campaign Whatsapp Queue Detail';
            $data['submenu_active'] = 'campaign-whatsapp-queue';
            $data['type'] = 'queue';
        }

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            $data['post'] = $post;
            // print_r($data);exit;
            return view('campaign::whatsapp-detail', $data);
        } else {
            return redirect('campaign')->withErrors($action['messages']);
        }
    }

    public function create(Request $request)
    {
        $data = [ 'title'             => 'Campaign',
                  'sub_title'         => 'New Campaign',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-create'
                ];

        $getCity = MyHelper::get('city/list');
        if ($getCity['status'] == 'success') {
            $data['city'] = $getCity['result'];
        } else {
            $data['city'] = [];
        }

        $getProvince = MyHelper::get('province/list');
        if ($getProvince['status'] == 'success') {
            $data['province'] = $getProvince['result'];
        } else {
            $data['province'] = [];
        }

        $getCourier = MyHelper::get('courier/list');
        if ($getCourier['status'] == 'success') {
            $data['couriers'] = $getCourier['result'];
        } else {
            $data['couriers'] = [];
        }

        $getOutlet = MyHelper::get('outlet/be/list');
        if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') {
            $data['outlets'] = $getOutlet['result'];
        } else {
            $data['outlets'] = [];
        }

        $getProduct = MyHelper::get('product/be/list');
        if (isset($getProduct['status']) && $getProduct['status'] == 'success') {
            $data['products'] = $getProduct['result'];
        } else {
            $data['products'] = [];
        }

        $getTag = MyHelper::get('product/tag/list');
        if (isset($getTag['status']) && $getTag['status'] == 'success') {
            $data['tags'] = $getTag['result'];
        } else {
            $data['tags'] = [];
        }

        $getMembership = MyHelper::post('membership/be/list', []);
        if (isset($getMembership['status']) && $getMembership['status'] == 'success') {
            $data['memberships'] = $getMembership['result'];
        } else {
            $data['memberships'] = [];
        }

        $data['deals'] = MyHelper::post('deals/list-all', ['deals_type' => 'Deals'])['result'] ?? [];
        $data['quest'] = MyHelper::get('quest/list-all')['result'] ?? [];
        $data['subscription'] = MyHelper::post('subscription/list-all', ['subscription_type' => 'Subscription'])['result'] ?? [];

        if (isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']) {
            $data['api_key_whatsapp'] = $getApiKey['result']['value'];
        } else {
            $data['api_key_whatsapp'] = null;
        }

        $data['csv'] = $request->get('filter') == 'csv' ? true : false;
        $result=&$data['result'];
        $result['campaign_title'] = old('campaign_title', $request->get('campaign_title'));
        $result['campaign_send_at'] = old('campaign_send_at', $request->get('campaign_send_at'));
        $result['campaign_media'] = old('campaign_media', $request->get('campaign_media'));
        $result['campaign_generate_receipient'] = old('campaign_generate_receipient', $request->get('campaign_generate_receipient'));
        $result['campaign_send_at'] = $result['campaign_send_at'] ? str_replace('-', '', $result['campaign_send_at']) : '';

        return view('campaign::create-step-1', $data);
    }

    public function createPost(Request $request)
    {
        $post = $request->except(array('_token','import_file'));
        if (in_array($request->post('csv_content'), array('id','phone'))) {
            if ($request->file('import_file')) {
                $path = $request->file('import_file')->getRealPath();
                $action = MyHelper::postFile('campaign/create', 'import_file', $path, $post);
            } else {
                return back()->withInput()->withErrors('File empty');
            }
        } else {
            $action = MyHelper::post('campaign/create', $post);
        }
        if (isset($action['status']) && $action['status'] == 'success') {
            $action['campaign']['id_campaign'] = MyHelper::createSlug($action['campaign']['id_campaign'], $action['campaign']['created_at']);
            return redirect('campaign/step2/' . $action['campaign']['id_campaign']);
        } else {
            return back()->withInput()->withErrors($action['messages']);
        }
    }

    public function campaignStep1($id_campaign)
    {
        $id_campaign_decrypt = MyHelper::explodeSlug($id_campaign)[0] ?? '';
        $action = MyHelper::post('campaign/step2', ['id_campaign' => $id_campaign_decrypt]);

        if ($action['status'] == 'success') {
            $data = [ 'title'             => 'Campaign',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-create'
                ];

            $action['result']['id_campaign'] = $id_campaign;
            $action['result']['id_user'] = MyHelper::createSlug($action['result']['id_user'], $action['result']['created_at']);
            if (!empty($action['result']['user'])) {
                $action['result']['user']['id'] = $action['result']['id_user'];
            }
            $data['result'] = $action['result'];

            $getCity = MyHelper::get('city/list');
            if (isset($getCity['status']) && $getCity['status'] == 'success') {
                $data['city'] = $getCity['result'];
            } else {
                $data['city'] = [];
            }

            $getProvince = MyHelper::get('province/list');
            if (isset($getProvince['status']) && $getProvince['status'] == 'success') {
                $data['province'] = $getProvince['result'];
            } else {
                $data['province'] = [];
            }

            $getCourier = MyHelper::get('courier/list');
            if (isset($getCourier['status']) && $getCourier['status'] == 'success') {
                $data['couriers'] = $getCourier['result'];
            } else {
                $data['couriers'] = [];
            }

            $getOutlet = MyHelper::get('outlet/be/list');
            if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') {
                $data['outlets'] = $getOutlet['result'];
            } else {
                $data['outlets'] = [];
            }

            $getProduct = MyHelper::get('product/be/list');
            if (isset($getProduct['status']) && $getProduct['status'] == 'success') {
                $data['products'] = $getProduct['result'];
            } else {
                $data['products'] = [];
            }

            $getTag = MyHelper::get('product/tag/list');
            if (isset($getTag['status']) && $getTag['status'] == 'success') {
                $data['tags'] = $getTag['result'];
            } else {
                $data['tags'] = [];
            }

            $getMembership = MyHelper::post('membership/be/list', []);
            if (isset($getMembership['status']) && $getMembership['status'] == 'success') {
                $data['memberships'] = $getMembership['result'];
            } else {
                $data['memberships'] = [];
            }

            $data['deals'] = MyHelper::post('deals/list-all', ['deals_type' => 'Deals'])['result'] ?? [];
            $data['quest'] = MyHelper::get('quest/list-all')['result'] ?? [];
            $data['subscription'] = MyHelper::post('subscription/list-all', ['subscription_type' => 'Subscription'])['result'] ?? [];

            $getApiKey = MyHelper::get('setting/whatsapp');
            if (isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']) {
                $data['api_key_whatsapp'] = $getApiKey['result']['value'];
            } else {
                $data['api_key_whatsapp'] = null;
            }

            return view('campaign::create-step-1', $data);
        } else {
            return back()->withErrors($action['messages']);
        }
    }
    public function campaignStep1Post(Request $request, $id_campaign)
    {
        $post = $request->except(['_token','sample_1_length','files','import_file']);
        $id_campaign_decrypt = MyHelper::explodeSlug($id_campaign)[0] ?? '';
        $post['id_campaign'] = $id_campaign_decrypt;
        if (in_array($request->post('csv_content'), array('id','phone'))) {
            if ($request->file('import_file')) {
                $path = $request->file('import_file')->getRealPath();
                $action = MyHelper::postFile('campaign/create', 'import_file', $path, $post);
            } else {
                $action = MyHelper::postFile('campaign/create', 'import_file', null, $post);
            }
        } else {
            $action = MyHelper::post('campaign/create', $post);
        }//     $action = MyHelper::post('campaign/create', $post);
        //print json_encode($post);die();
        //dd($action);exit;
        if (isset($action['status']) && $action['status'] == 'success') {
            return redirect('campaign/step2/' . $id_campaign);
        } else {
            return back()->withErrors($action['messages']);
        }
    }

    public function campaignStep2($id_campaign)
    {
        $id_campaign_decrypt = MyHelper::explodeSlug($id_campaign)[0] ?? '';
        $action = MyHelper::post('campaign/step2', ['id_campaign' => $id_campaign_decrypt]);
        // print_r($action);exit;
        if ($action['status'] == 'success') {
            $data = [ 'title'         => 'Campaign',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-create'
                ];
            $test = MyHelper::get('autocrm/textreplace');

            $action['result']['id_campaign'] = $id_campaign;
            $action['result']['id_user'] = MyHelper::createSlug($action['result']['id_user'], $action['result']['created_at']);
            if (!empty($action['result']['user'])) {
                $action['result']['user']['id'] = $action['result']['id_user'];
            }
            $data['result'] = $action['result'];

            if ($test['status'] == 'success') {
                $data['textreplaces'] = $test['result'];
            }

            $getOutlet = MyHelper::get('outlet/be/list');
            if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') {
                $data['outlets'] = $getOutlet['result'];
            } else {
                $data['outlets'] = [];
            }

            $getProduct = MyHelper::get('product/be/list');
            if (isset($getProduct['status']) && $getProduct['status'] == 'success') {
                $data['products'] = $getProduct['result'];
            } else {
                $data['products'] = [];
            }

            $getTag = MyHelper::get('product/tag/list');
            if (isset($getTag['status']) && $getTag['status'] == 'success') {
                $data['tags'] = $getTag['result'];
            } else {
                $data['tags'] = [];
            }

            $getMembership = MyHelper::post('membership/be/list', []);
            if (isset($getMembership['status']) && $getMembership['status'] == 'success') {
                $data['memberships'] = $getMembership['result'];
            } else {
                $data['memberships'] = [];
            }

            $data['deals'] = MyHelper::post('deals/list-all', ['deals_type' => 'Deals'])['result'] ?? [];
            $data['quest'] = MyHelper::get('quest/list-all')['result'] ?? [];
            $data['subscription'] = MyHelper::post('subscription/list-all', ['subscription_type' => 'Subscription'])['result'] ?? [];

            return view('campaign::create-step-2', $data);
        } else {
            return back()->withErrors($action['messages']);
        }
    }

    public function showRecipient(Request $request, $id_campaign)
    {
        $id_campaign_decrypt = MyHelper::explodeSlug($id_campaign)[0] ?? '';
        if ($request->input('ajax')) {
            $post = array_merge(['id_campaign' => $id_campaign_decrypt], $request->input());
        } else {
            $post = ['id_campaign' => $id_campaign_decrypt];
        }
        if ($request->input('ajax')) {
            $post['page'] = $request->input('start') / $request->input('length') + 1;
            $action = MyHelper::post('campaign/recipient', $post);

            $return = $post;
            $i = ($post['start'] ?? 0);
            $return['recordsTotal'] = (int)($action['result']['users']['per_page'] ?? 0);
            $return['recordsFiltered'] = $action['result']['users']['total'] ?? 0;
            $return['data'] = array_map(function ($x) use (&$i) {
                $i++;
                return [
                    $i,
                    $x['name'],
                    $x['email'],
                    $x['phone'],
                    $x['gender'],
                    $x['city_name'],
                    $x['birthday']
                ];
            }, $action['result']['users']['data'] ?? []);
            $return['id_campaign'] = $id_campaign;
            return $return;
        }
        $data = [ 'title'         => 'Campaign',
              'sub_title'       => 'Show Recipient',
              'menu_active'       => 'campaign',
              'submenu_active'    => ''
            ];
        return view('campaign::show-recipient', $data);
    }

    public function campaignStep2Post(Request $request, $id_campaign)
    {
        $post = $request->except(['_token','sample_1_length','files']);

        if (!empty($post['campaign_push_clickto']) && $post['campaign_push_clickto'] == 'url' && !filter_var($post['campaign_push_link'] ?? '', FILTER_VALIDATE_URL)) {
            return back()->withErrors("Please use http:// or https:// for push notif url");
        }

        if (!empty($post['campaign_inbox_clickto']) && $post['campaign_inbox_clickto'] == 'url' && !filter_var($post['campaign_inbox_link'] ?? '', FILTER_VALIDATE_URL)) {
            return back()->withErrors("Please use http:// or https:// for inbox url");
        }

        $id_campaign_decrypt = MyHelper::explodeSlug($id_campaign)[0] ?? '';
        $post['id_campaign'] = $id_campaign_decrypt;
        if (isset($post['campaign_email_more_recipient'])) {
            $post['campaign_email_more_recipient'] = str_replace(';', ',', str_replace(' ', '', $post['campaign_email_more_recipient']));
        }

        if (isset($post['campaign_sms_more_recipient'])) {
            $post['campaign_sms_more_recipient'] = str_replace(';', ',', str_replace(' ', '', $post['campaign_sms_more_recipient']));
        }

        if (isset($post['campaign_push_more_recipient'])) {
            $post['campaign_push_more_recipient'] = str_replace(';', ',', str_replace(' ', '', $post['campaign_push_more_recipient']));
        }

        if (isset($post['campaign_inbox_more_recipient'])) {
            $post['campaign_inbox_more_recipient'] = str_replace(';', ',', str_replace(' ', '', $post['campaign_inbox_more_recipient']));
        }

        if (isset($post['campaign_whatsapp_more_recipient'])) {
            $post['campaign_whatsapp_more_recipient'] = str_replace(';', ',', str_replace(' ', '', $post['campaign_whatsapp_more_recipient']));
        }

        if (isset($post['campaign_push_image'])) {
            $post['campaign_push_image'] = MyHelper::encodeImage($post['campaign_push_image']);
        }

        if (isset($post['campaign_whatsapp_content'])) {
            foreach ($post['campaign_whatsapp_content'] as $key => $content) {
                if ($content['content'] || isset($content['content_file']) && $content['content_file']) {
                    if ($content['content_type'] == 'image') {
                        $post['campaign_whatsapp_content'][$key]['content'] = MyHelper::encodeImage($content['content']);
                    } elseif ($content['content_type'] == 'file') {
                        $post['campaign_whatsapp_content'][$key]['content'] = base64_encode(file_get_contents($content['content_file']));
                        $post['campaign_whatsapp_content'][$key]['content_file_name'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_FILENAME);
                        $post['campaign_whatsapp_content'][$key]['content_file_ext'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_EXTENSION);
                        unset($post['campaign_whatsapp_content'][$key]['content_file']);
                    }
                }
            }
        }
        $action = MyHelper::post('campaign/update', $post);

        if ($action['status'] == 'success') {
            return redirect('campaign/step3/' . $id_campaign);
        } else {
            return back()->withErrors($action['messages'] ?? "Something went wrong, please try again");
        }
    }

    public function campaignStep3($id_campaign)
    {
        $id_campaign_decrypt = MyHelper::explodeSlug($id_campaign)[0] ?? '';
        $action = MyHelper::post('campaign/step2', ['id_campaign' => $id_campaign_decrypt]);
        // print_r($action);exit;
        if ($action['status'] == 'success') {
            $data = [ 'title'         => 'Campaign',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-create'
                ];
            $test = MyHelper::get('autocrm/textreplace');

            $action['result']['id_campaign'] = $id_campaign;
            $action['result']['id_user'] = MyHelper::createSlug($action['result']['id_user'], $action['result']['created_at']);
            if (!empty($action['result']['user'])) {
                $action['result']['user']['id'] = $action['result']['id_user'];
            }
            $data['result'] = $action['result'];
            if ($test['status'] == 'success') {
                $data['textreplaces'] = $test['result'];
            }

            $setting = MyHelper::get('setting/email?is_log=0');

            if ($setting['status'] == 'success') {
                $data['setting'] = $setting['result'];
            }

            $getOutlet = MyHelper::get('outlet/be/list');
            if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') {
                $data['outlets'] = $getOutlet['result'];
            } else {
                $data['outlets'] = [];
            }

            $getProduct = MyHelper::get('product/be/list');
            if (isset($getProduct['status']) && $getProduct['status'] == 'success') {
                $data['products'] = $getProduct['result'];
            } else {
                $data['products'] = [];
            }

            $getTag = MyHelper::get('product/tag/list');
            if (isset($getTag['status']) && $getTag['status'] == 'success') {
                $data['tags'] = $getTag['result'];
            } else {
                $data['tags'] = [];
            }

            $getMembership = MyHelper::post('membership/be/list', []);
            if (isset($getMembership['status']) && $getMembership['status'] == 'success') {
                $data['memberships'] = $getMembership['result'];
            } else {
                $data['memberships'] = [];
            }

            $data['deals'] = MyHelper::post('deals/list-all', ['deals_type' => 'Deals'])['result'] ?? [];
            $data['quest'] = MyHelper::get('quest/list-all')['result'] ?? [];
            $data['subscription'] = MyHelper::post('subscription/list-all', ['subscription_type' => 'Subscription'])['result'] ?? [];


            $getSubcription = MyHelper::get('subscription/be/list/ajax');
            if (isset($getSubcription['status']) && $getSubcription['status'] == 'success') {
                $data['subcription'] = $getSubcription['result'];
            } else {
                $data['subcription'] = [];
            }

            return view('campaign::create-step-3', $data);
        } else {
            return back()->withErrors($action['messages'] ?? "Something went wrong, please try again");
        }
    }

    public function campaignStep3Post(Request $request, $id_campaign)
    {
        $id_campaign_decrypt = MyHelper::explodeSlug($id_campaign)[0] ?? '';
        $action = MyHelper::post('campaign/send', ['id_campaign' => $id_campaign_decrypt,'resend' => $request->post('resend')]);
        // return $action;

        if ($action['status'] == 'success') {
            if (!empty($action['result']) && $action['result'] != 1) {
                $action['result']['id_campaign'] = MyHelper::createSlug($action['result']['id_campaign'], $action['result']['created_at']);
                $action['result']['id_user'] = MyHelper::createSlug($action['result']['id_user'], $action['result']['created_at']);
            }
            $id_campaign = $action['result']['id_campaign'] ?? $id_campaign;
            return redirect('campaign/step3/' . $id_campaign);
        } else {
            return back()->withErrors($action['messages']);
        }
    }
    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('campaign::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('campaign::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request)
    {
        $post = $request->except(['_token']);
        $delete = MyHelper::post('campaign/delete', ['id_campaign' => MyHelper::explodeSlug($post['id_campaign'])[0]]);

        return $delete;
    }

    public function pushOutboxV2(Request $request, $page = null)
    {
        $data = [ 'title'             => 'Campaign Push Notification Outbox List',
                  'menu_active'       => 'campaign',
                  'submenu_active'    => 'campaign-push-outbox'
                ];

        $post = $request->except(['_token']);
        $page = 1;
        if (Session::has('search-campaign-push') && !empty($post) && !isset($post['filter'])) {
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('search-campaign-push');
        } else {
            Session::forget('search-campaign-push');
            $filter = true;
        }

        $post['page'] = $post['page'] ?? $page;

        $action = MyHelper::post('campaign/push/outbox/list', $post);

        if (isset($action['status']) && $action['status'] == "success") {
            if (!empty($action['result']['data'])) {
                foreach ($action['result']['data'] as $key => $val) {
                    $action['result']['data'][$key]['id_campaign_push_sent'] = MyHelper::createSlug($val['id_campaign_push_sent'], $val['created_at']);
                    $action['result']['data'][$key]['id_campaign'] = MyHelper::createSlug($val['id_campaign'], $val['created_at']);
                    $action['result']['data'][$key]['id_user'] = MyHelper::createSlug($val['id_user'], $val['created_at']);
                }
            }
            $data['campaignPush']     = $action['result']['data'];
            $data['campaignPushTotal']     = $action['result']['total'];
            $data['campaignPushPerPage']   = $action['result']['from'];
            $data['campaignPushUpTo']      = $action['result']['from'] + count($action['result']['data']) - 1;
            $data['campaignPushPaginator'] = new LengthAwarePaginator($action['result']['data'], $action['result']['total'], $action['result']['per_page'], $action['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['campaignPush']          = [];
            $data['campaignPushTotal']     = 0;
            $data['campaignPushPerPage']   = 0;
            $data['campaignPushUpTo']      = 0;
            $data['campaignPushPaginator'] = false;
        }

        if (isset($post['push_sent_subject']) && !empty($post['push_sent_subject'])) {
            Session::put('search-campaign-push', ['push_sent_subject' => $post['push_sent_subject']]);

            if ($filter ?? false) {
                return redirect('campaign/push/outbox?page=1');
            }
        }

        $data['post'] = $post;

        return view('campaign::push-outbox', $data);
    }

    public function campaignClickActionData(Request $request)
    {
        $post = $request->except(['_token']);
        $res = [];

        if ($post['type'] == 'promo_detail') {
            $res = MyHelper::get('promo-campaign/active-campaign')['result'] ?? [];
        } elseif ($post['type'] == 'merchant_detail') {
            $mp = ['select' => ['id_merchant', 'merchant_pic_name']];
            $res = MyHelper::post('merchant/list-setting', $mp)['result'] ?? [];
        } elseif ($post['type'] == 'doctor_detail') {
            $dcp = ['select' => ['id_doctor', 'doctor_name']];
            $res = MyHelper::post('doctor', $dcp)['result'] ?? [];
        }

        return $res;
    }
}
