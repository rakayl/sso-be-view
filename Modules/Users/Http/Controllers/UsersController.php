<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;
use Excel;
use App\Exports\ArrayExport;
use Illuminate\Support\Facades\Cookie;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function listPhoneUser()
    {
        $query = MyHelper::get('users/list/phone');
        // print_r($query);exit;
        if (isset($query['status']) && $query['status'] == "success") {
            $data = $query['result'];
        } else {
            $data = [];
        }
        return response()->json($data);
    }

    public function listEmailUser()
    {
        $query = MyHelper::get('users/list/email');

        if (isset($query['status']) && $query['status'] == "success") {
            $data = $query['result'];
        } else {
            $data = [];
        }
        return response()->json($data);
    }

    public function listNameUser()
    {
        $query = MyHelper::get('users/list/name');

        if (isset($query['status']) && $query['status'] == "success") {
            $data = $query['result'];
        } else {
            $data = [];
        }
        return response()->json($data);
    }

    public function listAddressUser(Request $request, $phone)
    {
        $post = $request->except('_token');
        $post['phone'] = $phone;
        $raw_data = MyHelper::post('users/list/address', $post)['result'] ?? [];
        $data['data'] = $raw_data['data'];
        $data['total'] = $raw_data['total'] ?? 0;
        $data['from'] = $raw_data['from'] ?? 0;
        $data['order_by'] = $raw_data['order_by'] ?? 0;
        $data['order_sorting'] = $raw_data['order_sorting'] ?? 0;
        $data['last_page'] = !($raw_data['next_page_url'] ?? false);
        return $data;
    }

    public function autoResponse(Request $request, $subject)
    {
        $autocrmSubject = ucwords(str_replace('-', ' ', $subject));
        $data = [ 'title'             => 'User Auto Response ' . $autocrmSubject,
                  'menu_active'       => 'user',
                  'submenu_active'    => 'user-autoresponse-' . $subject
                ];
        switch ($subject) {
            case 'complete-user-profile-point-bonus':
                $data['menu_active'] = 'profile-completion';
                $data['submenu_active'] = 'complete-user-profile-point-bonus';
                break;
            case 'new-user-franchise':
                $data['title'] = 'User Auto Response New User Mitra';
                $data['menu_active'] = 'user-franchise';
                break;
            case 'reset-password-user-franchise':
                $data['title'] = 'Reset Password User Mitra';
                $data['menu_active'] = 'user-franchise';
                break;

            default:
                # code...
                break;
        }
        $query = MyHelper::post('autocrm/list', ['autocrm_title' => $autocrmSubject]);
        $test = MyHelper::get('autocrm/textreplace?log_save=0');
        $auto = null;

        $getApiKey = MyHelper::get('setting/whatsapp?log_save=0');
        if (isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']) {
            $data['api_key_whatsapp'] = $getApiKey['result']['value'];
        } else {
            $data['api_key_whatsapp'] = null;
        }

        $post = $request->except('_token');
        if (!empty($post)) {
            if (isset($post['autocrm_push_image'])) {
                $post['autocrm_push_image'] = MyHelper::encodeImage($post['autocrm_push_image']);
            }

            if (isset($post['whatsapp_content'])) {
                foreach ($post['whatsapp_content'] as $key => $content) {
                    if ($content['content'] || isset($content['content_file']) && $content['content_file']) {
                        if ($content['content_type'] == 'image') {
                            $post['whatsapp_content'][$key]['content'] = MyHelper::encodeImage($content['content']);
                        } elseif ($content['content_type'] == 'file') {
                            $post['whatsapp_content'][$key]['content'] = base64_encode(file_get_contents($content['content_file']));
                            $post['whatsapp_content'][$key]['content_file_name'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_FILENAME);
                            $post['whatsapp_content'][$key]['content_file_ext'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_EXTENSION);
                            unset($post['whatsapp_content'][$key]['content_file']);
                        }
                    }
                }
            }

            $query = MyHelper::post('autocrm/update', $post);
            // print_r($query);exit;
            return back()->withSuccess(['Response updated']);
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

        if (stristr($request->url(), 'deals')) {
            $data['deals'] = true;
            $custom[] = '%outlet_name%';
            $custom[] = '%outlet_code%';
        }

        $data['custom'] = $custom;
        $data['click_inbox'] = [
            ['value' => "No Action",'title' => 'No Action']
        ];
        $data['click_notification'] = [
            ['value' => 'Home','title' => 'Home']
        ];

        if ($subject == 'pin-create') {
            $data['click_notification'] = [
                ['value' => "No Action",'title' => 'No Action']
            ];
            return view('users::response_push', $data);
        }

        // print_r($data);exit;
        return view('users::response', $data);
    }

    public function create(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post) && !empty($post)) {
            // print_r($post);exit;
            if (isset($post['relationship']) && $post['relationship'] == "-") {
                $post['relationship'] = null;
            }

            if (isset($post['id_card_image']) && !empty($post['id_card_image'])) {
                $post['id_card_image'] = MyHelper::encodeImage($post['id_card_image']);
            }

            $query = MyHelper::post('users/create', $post);

            if (isset($query['status']) && $query['status'] == 'success') {
                return back()->withSuccess(['User Create Success']);
            } else {
                if (!empty($query['messages'][0])) {
                    $query['messages'][0] = str_replace('pin', 'password', $query['messages'][0]);
                }
                return back()->withErrors($query['messages'])->withInput();
            }
        } else {
            $data = [ 'title'             => 'New User',
                      'menu_active'       => 'user',
                      'submenu_active'    => 'user-new'
                    ];

            $getCity = MyHelper::get('city/pemda');

            if ($getCity['status'] == 'success') {
                $data['city'] = $getCity['result'];
            } else {
                $data['city'] = null;
            }


            return view('users::create', $data);
        }
    }
    public function createPemda(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post) && !empty($post)) {

            if (isset($post['id_card_image']) && !empty($post['id_card_image'])) {
                $post['id_card_image'] = MyHelper::encodeImage($post['id_card_image']);
            }

            $query = MyHelper::post('users/create', $post);

            if (isset($query['status']) && $query['status'] == 'success') {
                return back()->withSuccess(['User Create Success']);
            } else {
                if (!empty($query['messages'][0])) {
                    $query['messages'][0] = str_replace('pin', 'password', $query['messages'][0]);
                }
                return back()->withErrors($query['messages'])->withInput();
            }
        } else {
            $data = [ 'title'             => 'New Pemda',
                      'menu_active'       => 'pemda',
                      'submenu_active'    => 'pemda-new'
                    ];

            $getCity = MyHelper::get('city/list/pemda');
            if ($getCity['status'] == 'success') {
                $data['city'] = $getCity['result'];
            } else {
                $data['city'] = null;
            }
            return view('users::create-pemda', $data);
        }
    }
    public function deleteAdminOutlet($phone, $id_outlet)
    {
        if (!empty($phone) && !empty($id_outlet)) {
            $query = MyHelper::post('users/adminoutlet/delete', ['phone' => $phone, 'id_outlet' => $id_outlet]);

            if (isset($query['status']) && $query['status'] == 'success') {
                return back()->withSuccess(['Admin Outlet Delete Success']);
            } else {
                return back()->withErrors($query['messages']);
            }
        } else {
            return back()->withErrors(['Admin Outlet not found']);
        }
    }

    public function createAdminOutlet(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post) && !empty($post)) {
            // print_r($post);exit;
            $query = MyHelper::post('users/adminoutlet/create', $post);

            if (isset($query['status']) && $query['status'] == 'success') {
                return back()->withSuccess(['Admin Outlet Create Success']);
            } else {
                return back()->withErrors($query['messages']);
            }
        } else {
            $data = [ 'title'             => 'New Admin Outlet',
                      'menu_active'       => 'admin-outlet',
                      'submenu_active'    => 'admin-outlet-create'
                    ];

            $getOutlet = MyHelper::get('outlet/be/list');
            // print_r($getOutlet);exit;
            if ($getOutlet['status'] == 'success') {
                $data['outlets'] = $getOutlet['result'];
            } else {
                $data['outlets'] = null;
            }
            return view('users::create_admin_outlet', $data);
        }
    }

    public function updateAdminOutlet(Request $request, $phone)
    {
        $post = $request->except('_token');
        if (isset($post) && !empty($post)) {
            $post['phone'] = $phone;
            $post['delete'] = true;

            $query = MyHelper::post('users/adminoutlet/create', $post);

            if (isset($query['status']) && $query['status'] == 'success') {
                return back()->withSuccess(['Admin Outlet Update Success']);
            } else {
                return back()->withErrors($query['messages']);
            }
        } else {
            $data = [ 'title'             => 'Update Admin Outlet',
                      'menu_active'       => 'admin-outlet',
                      'submenu_active'    => 'admin-outlet-list'
                    ];

            $query = MyHelper::post('users/adminoutlet/detail', ['phone' => $phone]);

            if ($query['status'] == 'success') {
                $data['details'] = $query['result'];
            } else {
                $data['details'] = null;
            }

            if ($data['details']) {
                $data['details']['outlets'] = explode(',', $data['details']['outlets']);
            }

            $getOutlet = MyHelper::get('outlet/be/list');
            // print_r($getOutlet);exit;
            if ($getOutlet['status'] == 'success') {
                $data['outlets'] = $getOutlet['result'];
            } else {
                $data['outlets'] = null;
            }

            return view('users::update_admin_outlet', $data);
        }
    }

    public function indexAdminOutlet(Request $request)
    {
        $post = $request->except('_token');
        $data = [ 'title'             => 'User',
                  'menu_active'       => 'admin-outlet',
                  'submenu_active'    => 'admin-outlet-list'
                ];

        $query = MyHelper::post('users/adminoutlet/list', $post);
        // print_r($query);exit;
        if (isset($query) && $query['status'] == 'success') {
            $data['result'] = $query['result'];
        } else {
            $data['result'] = null;
        }

        return view('users::index-admin-outlet', $data);
    }

    public function index(Request $request)
    {
        $post = $request->except('_token');

        if (Session::has('form') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }

            if (isset($post['order_field'])) {
                $orderField = $post['order_field'];
            }
            if (isset($post['order_method'])) {
                $orderMethod = $post['order_method'];
            }
            if (isset($post['take'])) {
                $take = $post['take'];
            }

            $post = Session::get('form');
            $post['page'] = $page;
            if (isset($orderField)) {
                $post['order_field'] = $orderField;
                $post['order_method'] = $orderMethod;
                $post['take'] = $take;
            }
        }

        $data = [ 'title'             => 'User',
            'menu_active'       => 'user',
            'submenu_active'    => 'user-list'
        ];

        if (!isset($post['order_field'])) {
            $post['order_field'] = 'id';
        }
        if (!isset($post['order_method'])) {
            $post['order_method'] = 'desc';
        }
        if (!isset($post['take'])) {
            $post['take'] = 10;
        }
        $post['page'] = $post['page'] ?? 1;

        $getUser = MyHelper::post('users/list', $post);
        if (isset($getUser['status']) && $getUser['status'] == "success") {
            $data['dataUser']          = $getUser['result']['data'];
            $data['dataUserTotal']     = $getUser['result']['total'];
            $data['dataUserPerPage']   = $getUser['result']['from'];
            $data['dataUserUpTo']      = $getUser['result']['from'] + count($getUser['result']['data']) - 1;
            $data['dataUserPaginator'] = new LengthAwarePaginator($getUser['result']['data'], $getUser['result']['total'], $getUser['result']['per_page'], $getUser['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['dataUser']          = [];
            $data['dataUserTotal']     = 0;
            $data['dataUserPerPage']   = 0;
            $data['dataUserUpTo']      = 0;
            $data['dataUserPaginator'] = false;
        }

        $getCity = MyHelper::get('city/list?log_save=0');
        if ($getCity['status'] == 'success') {
            $data['city'] = $getCity['result'];
        } else {
            $data['city'] = [];
        }

        $getProvince = MyHelper::get('province/list?log_save=0');
        if ($getProvince['status'] == 'success') {
            $data['province'] = $getProvince['result'];
        } else {
            $data['province'] = [];
        }

        $getCourier = MyHelper::get('courier/list?log_save=0');
        if ($getCourier['status'] == 'success') {
            $data['couriers'] = $getCourier['result'];
        } else {
            $data['couriers'] = [];
        }

        $getOutlet = MyHelper::get('outlet/be/list?log_save=0');
        if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') {
            $data['outlets'] = $getOutlet['result'];
        } else {
            $data['outlets'] = [];
        }

        $getProduct = MyHelper::get('product/be/list?log_save=0');
        if (isset($getProduct['status']) && $getProduct['status'] == 'success') {
            $data['products'] = $getProduct['result'];
        } else {
            $data['products'] = [];
        }

        $getTag = MyHelper::get('product/tag/list?log_save=0');
        if (isset($getTag['status']) && $getTag['status'] == 'success') {
            $data['tags'] = $getTag['result'];
        } else {
            $data['tags'] = [];
        }

        $getMembership = MyHelper::post('membership/be/list?log_save=0', []);
        if (isset($getMembership['status']) && $getMembership['status'] == 'success') {
            $data['memberships'] = $getMembership['result'];
        } else {
            $data['memberships'] = [];
        }

        $data['deals'] = MyHelper::post('deals/list-all', ['deals_type' => 'Deals'])['result'] ?? [];
        $data['quest'] = MyHelper::get('quest/list-all')['result'] ?? [];
        $data['subscription'] = MyHelper::post('subscription/list-all', ['subscription_type' => 'Subscription'])['result'] ?? [];
        $data['order_field'] = $post['order_field'];
        $data['order_method'] = $post['order_method'];
        $data['take'] = $post['take'];
        $data['page'] = $post['page'];
        $data['table_title'] = "User list order by " . $data['order_field'] . ", " . $data['order_method'] . "ending (" . $data['dataUserTotal'] . " data)";

        $data['show'] = 1;

        if ($post) {
            Session::put('form', $post);
        }

        return view('users::index', $data);
    }

    public function bulkAction(Request $request)
    {
        $post = $request->except('_token');

        if (isset($post['action']) && isset($post['users_check'])) {
            //Bulk action
            $post['users'] = json_decode($post['users_check']);
            $phone = $post['users'];

            if ($post['action'] == 'delete') {
                $action = MyHelper::post('users/delete', ['phone' => $phone]);
                if ($action['status'] == 'success') {
                    unset($post['action']);
                    return back()->withSuccess($action['result']);
                } else {
                    return back()->withErrors($action['messages']);
                }
            }

            if ($post['action'] == 'phone verified') {
                $action = MyHelper::post('users/phone/verified', ['phone' => $phone]);
                if ($action['status'] == 'success') {
                    unset($post['action']);
                    return back()->withSuccess($action['result']);
                } else {
                    return back()->withErrors($action['messages']);
                }
            }

            if ($post['action'] == 'phone not verified') {
                $action = MyHelper::post('users/phone/unverified', ['phone' => $phone]);
                if ($action['status'] == 'success') {
                    unset($post['action']);
                    return back()->withSuccess($action['result']);
                } else {
                    return back()->withErrors($action['messages']);
                }
            }

            if ($post['action'] == 'email verified') {
                $action = MyHelper::post('users/email/verified', ['phone' => $phone]);
                if ($action['status'] == 'success') {
                    unset($post['action']);
                    return back()->withSuccess($action['result']);
                } else {
                    return back()->withErrors($action['messages']);
                }
            }

            if ($post['action'] == 'email not verified') {
                $action = MyHelper::post('users/email/unverified', ['phone' => $phone]);
                if ($action['status'] == 'success') {
                    unset($post['action']);
                    return back()->withSuccess($action['result']);
                } else {
                    return back()->withErrors($action['messages']);
                }
            }
        } else {
            return back()->withErrors(['User can not be empty']);
        }
    }

    public function searchReset()
    {
        Session::forget('form');
        return back();
    }

    public function getExport(Request $request)
    {
        $post = $request->except('_token');

        if (!empty(Session::get('form'))) {
            $post = Session::get('form');
        }

        if (!isset($post['order_field'])) {
            $post['order_field'] = 'id';
        }
        if (!isset($post['order_method'])) {
            $post['order_method'] = 'desc';
        }
        $post['take'] = 999999999;
        $post['skip'] = 0;


        $export = MyHelper::post('users/list', $post);
        // print_r($export);exit;
        if ($export['status'] == 'success') {
            $data = $export['result']['data'] ?? [];
            $x = 1;
            $res = [];

            foreach ($data as $row) {
                if ($row['android_device'] == "" && $row['ios_device'] == "") {
                    $device = 'None';
                }
                if ($row['android_device'] != "" && $row['ios_device'] == "") {
                    $device = 'Android';
                }
                if ($row['android_device'] == "" && $row['ios_device'] != "") {
                    $device = 'IOS';
                }
                if ($row['android_device'] != "" && $row['ios_device'] != "") {
                    $device = 'Both';
                }

                $res[] = [
                    'Register Date' => date('d F Y H:i', strtotime($row['created_at'])),
                    'Name' => $row['name'],
                    'Phone' => $row['phone'],
                    'Device' => $device,
                    'Email' => $row['email'],
                    'City' => $row['city_name'],
                    'Province' => $row['province_name'],
                    'Postal Code' => $row['address_postal_code'],
                    'Gender' => $row['gender'],
                    'Provider' => $row['provider'],
                    'Birthday' => (!empty($row['birthday']) ? date('d F Y', strtotime($row['birthday'])) : ''),
                    'Age' => $row['age'],
                    'Points' => $row['balance'],
                    'Phone Verified' => ($row['phone_verified'] == 0 ? 'Not Verified' : 'Verified'),
                    'Email Verified' => ($row['email_verified'] == 0 ? 'Not Verified' : 'Verified')
                ];
            }
            return Excel::download(new ArrayExport($res, 'Users List-' . date('Y-m-d')), 'Users List-' . date('Y-m-d') . '.xls');
        }
    }

    public function getExportActivities(Request $request)
    {
        $post = $request->except('_token');

        if (!empty(Session::get('form'))) {
            $post = Session::get('form');
        }

        if (!isset($post['order_field'])) {
            $post['order_field'] = 'id';
        }
        if (!isset($post['order_method'])) {
            $post['order_method'] = 'desc';
        }
        if (!isset($post['take'])) {
            $post['take'] = 999999999;
        }
        $post['skip'] = 0;


        // print_r($post);exit;
        $export = MyHelper::post('users/activity', $post);

        if ($export['status'] == 'success') {
            $data = $export['result'];
            $x = 1;
            Excel::download(new ArrayExport($data), 'Log Activity List-' . date('Y-m-d') . '.xls');
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($phone, Request $request)
    {
        $post = $request->except('_token');
        // print_r($post);exit;
        if ($request->post('action') == 'delete_inbox' && !empty($request->post('id_inbox'))) {
            $delete = MyHelper::post('inbox/delete', ['id_inbox' => $request->post('id_inbox')]);
            if (($delete['status'] == 'success') ?? false) {
                return redirect('user/detail/' . $phone)->with('success', ['Delete success']);
            } else {
                return back()->withErrors(['Delete Failed']);
            }
        }

        if (isset($post['password'])) {
            $checkpin = MyHelper::post('users/pin/check-backend', array('phone' => Session::get('phone'), 'pin' => $post['password'], 'admin_panel' => 1));
            if ($checkpin['status'] != "success") {
                return back()->withErrors(['invalid_credentials' => 'Invalid PIN'])->withInput();
            } else {
                Session::put('secure', 'yes');
            }
            Session::put('secure_last_activity', time());
        }

        if (isset($post['phone'])) {
            if (isset($post['birthday'])) {
                if (stristr($post['birthday'], '/')) {
                    $explode = explode('/', $post['birthday']);
                    $post['birthday'] = $explode[2] . '-' . $explode[1] . '-' . $explode[0];
                }
                $post['birthday'] = date('Y-m-d', strtotime($post['birthday']));
            }
            if (isset($post['relationship']) && $post['relationship'] == "-") {
                $post['relationship'] = null;
            }

            if (isset($post['id_card_image']) && !empty($post['id_card_image'])) {
                $post['id_card_image'] = MyHelper::encodeImage($post['id_card_image']);
            }

            $update = MyHelper::post('users/update', ['phone' => $phone, 'update' => $post]);
            return parent::redirect($update, 'Profile has been updated');
        }

        if (isset($post['photo'])) {
            $photo = MyHelper::encodeImage($post['photo']);
            $update = MyHelper::post('users/update/photo', ['phone' => $phone, 'photo' => $photo]);
            return parent::redirect($update, 'Profile Photo has been updated');
        }

        if (isset($post['password_new'])) {
            $post['phone'] = $phone;
            $update = MyHelper::post('users/update/password', $post);
            return parent::redirect($update, 'Password has been changed.');
        }

        if (isset($post['password_level'])) {
            $post['phone'] = $phone;
            // print_r($post);exit;
            $update = MyHelper::post('users/update/level', $post);
            // print_r($update);exit;
            return parent::redirect($update, 'Account Level has been changed.', url()->current() . '#permission');
        }

        if (isset($post['password_permission'])) {
            $post['phone'] = $phone;
            $update = MyHelper::post('users/update/permission', $post);
            return parent::redirect($update, 'Account Permission has been changed.', url()->current() . '#permission');
        }
        if (isset($post['is_suspended'])) {
            $post['phone'] = $phone;
            $update = MyHelper::post('users/update/suspend', $post);
            return parent::redirect($update, 'Suspend Status has been changed.');
        }

        $getUser = MyHelper::post('users/detail', ['phone' => $phone]);
        // return $getUser;exit;
        $getLog = MyHelper::post('users/log?log_save=0', ['phone' => $phone, 'skip' => 0, 'take' => 50]);

        $getFeature = MyHelper::post('users/granted-feature?log_save=0', ['phone' => $phone]);

        $getFeatureAll = MyHelper::get('feature?log_save=0');

        $getFeatureModule = MyHelper::get('feature-module?log_save=0');

        $getVoucher = MyHelper::post('deals/voucher/user?log_save=0', ['phone' => $phone]);
//      return $getVoucher;

        $getInbox = MyHelper::post('inbox/be/user', ['phone' => $phone]);

        $data = [ 'title'             => 'User',
                  'menu_active'       => 'user',
                  'submenu_active'    => 'user-list'
                ];
        $data['profile'] = null;
        $data['log']['mobile'] = [];
        $data['log']['backend'] = [];
        $data['features'] = null;
        $data['featuresall'] = null;
        $data['featuresmodule'] = null;
        $data['voucher'] = null;
        $data['celebrates'] = MyHelper::get('setting/be/celebrate_list ')['result'] ?? [];
        $data['jobs'] = MyHelper::get('setting/be/jobs_list')['result'] ?? [];
        if (isset($getUser['result'])) {
            $data['profile'] = $getUser['result'];
//          $data['trx'] = $getUser['trx'];
//          $data['voucher'] = $getUser['voucher'];
        }
        if (isset($getLog['result']['mobile'])) {
            $data['log']['mobile'] = $getLog['result']['mobile'];
        }
        if (isset($getLog['result']['be'])) {
            $data['log']['backend'] = $getLog['result']['be'];
        }
        if (isset($getFeature['result'])) {
            $data['features'] = $getFeature['result'];
        }
        if (isset($getFeatureAll['result'])) {
            $data['featuresall'] = $getFeatureAll['result'];
        }
        if (isset($getFeatureModule['result'])) {
            $data['featuresmodule'] = $getFeatureModule['result'];
        }
        if (isset($getVoucher['result'])) {
            $data['voucher'] = $getVoucher['result'];
        }
        $data['inboxes'] = $getInbox['result'] ?? [];

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

        if (empty(Session::get('secure')) || Session::get('secure_last_activity') < (time() - 900)) {
            $data = [ 'title'             => 'User',
                'menu_active'       => 'user',
                'submenu_active'    => 'user-list',
                'phone'           => $phone
            ];
            return view('users::password', $data);
        } else {
            return view('users::detail', $data);
        }
    }

    public function showAllLog($phone, $tipe, Request $request)
    {
        $post = $request->except('_token');
        if (empty($post)) {
            Session::forget('form_filter_log');
        }

        $data = [
            'title'             => 'User',
            'menu_active'       => 'user',
            'submenu_active'    => 'user-list',
            'phone'             => $phone,
            'date_start'        => date('01 F Y 00:00'),
            'date_end'          => date('d F Y 23:59'),
            'rule'              => 'and'
        ];

        if (isset($post['date_start'])) {
            $data['date_start'] = $post['date_start'];
        }

        if (isset($post['rule'])) {
            $data['rule'] = $post['rule'];
        }

        if (isset($post['date_end'])) {
            $data['date_end'] = $post['date_end'];
        }

        if (isset($post['conditions'])) {
            Session::put('form_filter_log', $post['conditions']);
        }

        if (!empty(Session::get('form_filter_log'))) {
            $data['conditions'] = Session::get('form_filter_log');
        } else {
            $data['conditions'] = [];
        }

        $getLog = MyHelper::post('users/log?log_save=0', ['phone' => $phone, 'page' => $post['page'] ?? 1, 'pagination' => 1, 'take' => 20, 'conditions' => $data['conditions'], 'date_start' => $data['date_start'], 'date_end' => $data['date_end'], 'rule' => $data['rule']]);

        $data['log']['mobile'] = [];
        $data['log']['backend'] = [];
        $data['count'] = ($tipe == 'mobile' ? $getLog['result']['mobile']['total'] ?? 0 : $getLog['result']['be']['total'] ?? 0);

        if (isset($getLog['result']['mobile'])) {
            $data['log']['mobile'] = $getLog['result']['mobile']['data'];
            $data['mobile_page'] = new LengthAwarePaginator($getLog['result']['mobile']['data'], $getLog['result']['mobile']['total'], $getLog['result']['mobile']['per_page'], $getLog['result']['mobile']['current_page'], ['path' => url('user/log/' . $phone . '/' . $tipe)]);
        }
        if (isset($getLog['result']['be'])) {
            $data['log']['backend'] = $getLog['result']['be']['data'];
            $data['backend_page'] = new LengthAwarePaginator($getLog['result']['be']['data'], $getLog['result']['be']['total'], $getLog['result']['be']['per_page'], $getLog['result']['be']['current_page'], ['path' => url('user/log/' . $phone . '/' . $tipe)]);
        }

        $profile = MyHelper::post('users/get-detail?log_save=0', ['phone' => $phone]);
        if (isset($profile['result'])) {
            $data['profile'] = $profile['result'];
        }

        if (isset($tipe)) {
            $data['tipe'] = $tipe;
        }

        return view('users::log_all', $data);
    }

    public function showLog($phone, Request $request)
    {
        $post = $request->except('_token');

        $getLog = MyHelper::post('users/log', ['phone' => $phone, 'skip' => 0, 'take' => 5]);

        $data = [ 'title'             => 'User',
                  'menu_active'       => 'user',
                  'submenu_active'    => 'user-list',
                  'phone'             => $phone
                ];

        if (isset($getLog['result'])) {
            $data['log'] = $getLog['result'];
        }

        return view('users::detail_log', $data);
    }

    public function showDetailLog($id, $log_type, Request $request)
    {
        $getLog = MyHelper::get('users/log/detail/' . $id . '/' . $log_type);
        $data = [];

        if (isset($getLog['result'])) {
            $data = $getLog['result'];
        }

        return $data;
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
    public function delete($phone)
    {
        $deleteUser = MyHelper::post('users/delete', ['phone' => $phone]);
        if ($deleteUser['status'] == 'success') {
            return back()->withSuccess($deleteUser['result']);
        } else {
            return back()->withErrors($deleteUser['messages']);
        }
    }

    public function deleteLogApp($id)
    {
        $deleteUserLog = MyHelper::post('users/delete/log', ['id_log_activities_apps' => $id]);
        if ($deleteUserLog['status'] == 'success') {
            return back()->withSuccess($deleteUserLog['result']);
        } else {
            return back()->withErrors($deleteUserLog['messages']);
        }
    }

    public function deleteLogBE($id)
    {
        $deleteUserLog = MyHelper::post('users/delete/log', ['id_log_activities_be' => $id]);
        if ($deleteUserLog['status'] == 'success') {
            return back()->withSuccess($deleteUserLog['result']);
        } else {
            return back()->withErrors($deleteUserLog['messages']);
        }
    }

    public function activity(Request $request, $page = 1)
    {
        $input = $request->input();
        $post = $request->except('_token');

        if (Session::has('form') && !isset($post['filter']) && !isset($post['password'])) {
            $page = $page;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            if (isset($post['take'])) {
                $takes = $post['take'];
            }
            if (isset($post['order_field'])) {
                $order_fields = $post['order_field'];
            }
            if (isset($post['order_method'])) {
                $order_methods = $post['order_method'];
            }
            $post = Session::get('form');
            $post['page'] = $page;
            if (isset($order_fields)) {
                $post['order_field'] = $order_fields;
                $post['order_method'] = $order_methods;
                $post['take'] = $takes;
            }
        } else {
            Session::forget('form');
        }

        if (!empty($post) && !isset($post['password'])) {
            Session::put('form', $post);
        }

        if (isset($post['password'])) {
            $checkpin = MyHelper::post('users/pin/check-backend', array('phone' => Session::get('phone'), 'pin' => $post['password'], 'admin_panel' => 1));
            if ($checkpin['status'] != "success") {
                return back()->withErrors(['invalid_credentials' => 'Invalid PIN'])->withInput();
            } else {
                Session::put('secure', 'yes');
                Session::put('secure_last_activity', time());
            }
        }

        $data = [ 'title'             => 'User',
            'menu_active'       => 'user',
            'submenu_active'    => 'user-log'
        ];

        if (!isset($post['order_field'])) {
            $post['order_field'] = '';
        }
        if (!isset($post['order_method'])) {
            $post['order_method'] = 'desc';
        }
        if (!isset($post['take'])) {
            $post['take'] = 10;
        }
        $post['skip'] = 0 + (($page - 1) * $post['take']);

        $getLog = MyHelper::post('users/activity', $post);

        if (isset($getLog['status']) && $getLog['status'] == 'success') {
            $data['content']['mobile'] = $getLog['result']['mobile']['data'];
            $data['content']['be'] = $getLog['result']['be']['data'];
        } else {
            $data['content']['mobile'] = null;
            $data['content']['be'] = null;
        }

        if (isset($getLog['status']) && $getLog['status'] == 'success') {
            $data['total']['mobile'] = $getLog['result']['mobile']['total'];
            $data['total']['be'] = $getLog['result']['be']['total'];
        } else {
            $data['total']['mobile'] = null;
            $data['total']['be'] = null;
        }

        $data['begin'] = $post['skip'] + 1;
        $data['last'] = $post['take'] + $post['skip'];

        if ($data['total']['mobile'] <= $data['last']) {
            $data['last'] = $data['total']['mobile'];
        }
        $data['page'] = $page;
        if (!is_array($data['content']['mobile'])) {
            $data['jumlah'] = null;
        } else {
            $data['jumlah'] = count($data['content']['mobile']);
        }
        foreach ($post as $key => $row) {
            $data[$key] = $row;
        }

        $data['table_title'] = "User Log Activity list order by " . $data['order_field'] . ", " . $data['order_method'] . "ending (" . $data['begin'] . " to " . $data['jumlah'] . " From " . $data['total']['mobile'] . " data)";

        if (empty(Session::get('secure')) && Session::get('secure_last_activity') < (time() - 900)) {
            $data = [
                'title'             => 'User',
                'menu_active'       => 'user',
                'submenu_active'    => 'user-log'
            ];
            return view('users::password', $data);
        } else {
            $data['conditions'] = $post['conditions'] ?? [];
            $data['rule'] = $post['rule'] ?? "";
            return view('users::log', $data);
        }
    }

    public function favorite(Request $request, $phone)
    {
        $post = $request->post();
        $data = [ 'title'             => 'User',
            'subtitle'        => 'Favorite',
            'menu_active'       => 'user',
            'submenu_active'    => 'user-list'
        ];

        if (isset($post['password'])) {
            $checkpin = MyHelper::post('users/pin/check-backend', array('phone' => Session::get('phone'), 'pin' => $post['password'], 'admin_panel' => 1));
            if ($checkpin['status'] != "success") {
                return back()->withErrors(['invalid_credentials' => 'Invalid PIN'])->withInput();
            } else {
                Session::put('secure', 'yes');
            }
            Session::put('secure_last_activity', time());
        }

        $data['favorites'] = MyHelper::post('users/favorite?page=' . ($request->page ?: 1), ['phone' => $phone])['result'] ?? [];

        if (empty(Session::get('secure')) || Session::get('secure_last_activity') < (time() - 900)) {
            $data = [ 'title'             => 'User',
                      'menu_active'       => 'user',
                      'submenu_active'    => 'user-list',
                      'phone'             => $phone
                    ];
            return view('users::password', $data);
        } else {
            return view('users::favorite', $data);
        }
    }

    public function activateUserDeleted(Request $request)
    {
        $post = $request->except('_token');
        $activate = MyHelper::post('users/activate', $post);

        if (isset($activate['status']) && $activate['status'] == 'success') {
            return redirect('user')->with('success', ['Activated success']);
        } else {
            return redirect('user')->withErrors($activate['messages'] ?? ['Activated Failed']);
        }
    }
}
