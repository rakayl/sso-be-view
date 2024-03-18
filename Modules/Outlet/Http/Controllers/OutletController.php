<?php

namespace Modules\Outlet\Http\Controllers;

use App\Imports\BrandOutletImport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\ArrayExport;
use App\Lib\MyHelper;
use Excel;
use Validator;
use Session;
use Storage;
use File;
use ZipArchive;
use App\Exports\MultisheetExport;
use App\Imports\FirstSheetOnlyImport;

class OutletController extends Controller
{
    /**
     * list
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet List',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-list',
        ];

        // outlet
        $outlet = MyHelper::post('outlet/be/list', ['all_outlet' => 1]);

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        } else {
            $data['outlet'] = [];
        }

        return view('outlet::list', $data);
    }
    public function tukangSedot(Request $request)
    {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet List',
            'menu_active'    => 'outlet',
            'submenu_active' => 'tukang-sedot-list',
        ];

        // outlet
        $post['level'] = "Tukang Sedot";
        $post['all_outlet'] = 1;
       $outlet = MyHelper::post('outlet/be/list', $post);

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        } else {
            $data['outlet'] = [];
        }

        return view('outlet::list', $data);
    }
    public function kontraktor(Request $request)
    {
        $data = [
            'title'          => 'Vendor Pembangunan',
            'sub_title'      => 'Vendor Pembangunan List',
            'menu_active'    => 'outlet',
            'submenu_active' => 'kontraktor-list',
        ];

         $post['level'] = "Kontraktor";
        $post['all_outlet'] = 1;
        $outlet = MyHelper::post('outlet/be/list', $post);

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        } else {
            $data['outlet'] = [];
        }

        return view('outlet::list', $data);
    }
    public function indexAjax(Request $request)
    {
        $post = $request->except('_token');

        if ($post) {
        }
        $outlet = MyHelper::get('outlet/be/list?log_save=0');

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data = $outlet['result'];
        } else {
            $data = [];
        }
        return response()->json($data);
    }

    public function indexAjaxFilter(Request $request, $type)
    {
        $post['latitude'] = 0;
        $post['longitude'] = 0;
        if ($type == 'Order') {
            $post['type'] = 'transaction';
        }
        $outlet = MyHelper::post('outlet/be/filter?log_save=0', $post);
        if (isset($outlet['result'])) {
            $data = $outlet['result'];
        } else {
            $data = [];
        }
        return response()->json($data);
    }


    /**
     * create
     */
    public function create(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'New Outlet',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-new',
            ];

            // province
            $data['province'] = $this->getPropinsi();
            $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
            $data['delivery'] = MyHelper::get('transaction/be/available-delivery')['result']['delivery'] ?? [];
            return view('outlet::create', $data);
        } else {
            if (!empty($post['outlet_latitude']) && (strpos($post['outlet_latitude'], ',') !== false || $post['outlet_latitude'] == 'NaN')) {
                return back()->withErrors(['Please input invalid latitude']);
            }

            if (!empty($post['outlet_longitude']) && (strpos($post['outlet_longitude'], ',') !== false || $post['outlet_longitude'] == 'NaN')) {
                return back()->withErrors(['Please input invalid longitude']);
            }

            if (isset($post['ampas'])) {
                unset($post['ampas']);
            }
            if (isset($post['next'])) {
                $next = 1;
                unset($post['next']);
            }
            //cek pin confirmation
            if ($post['outlet_pin'] != null) {
                $validator = Validator::make($request->all(), [
                    'outlet_pin' => 'required|confirmed|min:6|max:6',
                ], [
                    'confirmed' => 'Re-type PIN does not match',
                    'min'       => 'PIN must 6 digit',
                    'max'       => 'PIN must 6 digit'
                ]);

                if ($validator->fails()) {
                    return back()
                            ->withErrors($validator)
                            ->withInput();
                }
            }

            if (!empty($post['outlet_open_hours'])) {
                $post['outlet_open_hours'] = date('H:i:s', strtotime($post['outlet_open_hours']));
            }
            if (!empty($post['outlet_open_hours'])) {
                $post['outlet_close_hours'] = date('H:i:s', strtotime($post['outlet_close_hours']));
            }

            $post = array_filter($post);

            $save = MyHelper::post('outlet/create', $post);
            // return $save;
            if (isset($save['status']) && $save['status'] == "success") {
                if (isset($next)) {
                    return parent::redirect($save, 'Outlet has been created.', 'outlet/detail/' . $save['result']['outlet_code'] . '#photo');
                } else {
                    return parent::redirect($save, 'Outlet has been created.', 'outlet/list');
                }
            } else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    /*
    Detail
    */
    public function detail(Request $request, $code, $type = null)
    {

        $post = $request->except('_token');
        $data = [
                'title'          => 'Vendor',
                'sub_title'      => 'Detail Vendor',
                'menu_active'    => 'outlet'
            ];
        if (empty($post['outlet_name'])) {
            

            $outlet = MyHelper::post('outlet/be/list', ['outlet_code' => $code,'admin' => 1, 'qrcode' => 1]);
            
            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet']    = $outlet['result'];
            } else {
                $e = ['e' => 'Data outlet not found'];
                return back()->witherrors($e);
            }
            
            if($data['outlet'][0]['outlet_type']??null == "Tukang Sedot"){
                $data['submenu_active'] = 'tukang-sedot-list';
            }else{
                $data['submenu_active'] = 'kontraktor-list';
            }
           $data['merchant'] = MyHelper::post('merchant/detail', ['id_merchant' => $data['outlet'][0]['merchant']['id_merchant']])['result'] ?? [];
            $data['province'] = $this->getPropinsi();
            $pageBalance = 1;
            if ($type == 'log-balance') {
                $pageBalance = $post['page'] ?? 1;
            }
            if (!empty(Session::get('search_log_balance')) && empty($post['reset']) && empty($post['search_log_balance'])) {
                $post['search_log_balance'] = Session::get('search_log_balance');
            }
            $logBalance = MyHelper::post('merchant/balance/list', ['id_outlet' => $data['outlet'][0]['id_outlet'], 'page' => $pageBalance, 'search_key' => $post['search_log_balance'] ?? '']);
            if (isset($logBalance['status']) && $logBalance['status'] == "success") {
                $data['data_log_balance']          = $logBalance['result']['data'];
                $data['data_log_balance_paginator'] = new LengthAwarePaginator($logBalance['result']['data'], $logBalance['result']['total'], $logBalance['result']['per_page'], $logBalance['result']['current_page'], ['path' => url('outlet/detail/' . $code . '/log-balance')]);
            } else {
                $data['data_log_balance'] = [];
                $data['data_log_balance_paginator'] = false;
            }

            if (!empty($post['search_log_balance'])) {
                Session::put('search_log_balance', $post['search_log_balance']);
            }

            if (!empty($post['reset'])) {
                Session::forget('search_log_balance');
                Session::forget('search_list_payment');
            }

            if ($type == 'log-balance' || !empty($post['search_log_balance'])) {
                $data['tipe'] = 'log_balance';
            }

            $pagePayment = 1;
            if ($type == 'list-payment') {
                $pagePayment = $post['page'] ?? 1;
            }
            if (!empty(Session::get('search_list_payment')) && empty($post['reset']) && empty($post['search_list_payment'])) {
                $post['search_list_payment'] = Session::get('search_list_payment');
            }
            $listPayment = MyHelper::post('transaction/outlet/list-payment', ['id_outlet' => $data['outlet'][0]['id_outlet'], 'page' => $pagePayment, 'search_key' => $post['search_list_payment'] ?? '']);
            if (isset($listPayment['status']) && $listPayment['status'] == "success") {
                $data['data_list_payment']          = $listPayment['result']['data'];
                $data['data_list_payment_paginator'] = new LengthAwarePaginator($listPayment['result']['data'], $listPayment['result']['total'], $listPayment['result']['per_page'], $listPayment['result']['current_page'], ['path' => url('outlet/detail/' . $code . '/list-payment')]);
            } else {
                $data['data_list_payment'] = [];
                $data['data_list_payment_paginator'] = false;
            }

            if (!empty($post['search_list_payment'])) {
                Session::put('search_list_payment', $post['search_list_payment']);
            }

            if ($type == 'list-payment' || !empty($post['search_list_payment'])) {
                $data['tipe'] = 'list_payment';
            }

            $conditions = [
                "conditions" => [
                    [
                      "subject" => "id_outlet",
                      "operator" => $data['outlet'][0]['id_outlet'],
                      "parameter" => null
                    ]
                ],
                "rule" => "and",
                "filter" => "1",
                "admin_list" => 1
            ];
            $data['id_outlet'] = $data['outlet'][0]['id_outlet'];
            $data['outlet_code'] = $code;
            $data['provinces'] = MyHelper::get('province/list')['result'] ?? [];
            $data['cities'] = MyHelper::get('city/list')['result'] ?? [];
            return view('outlet::detail', $data);
        } else {
            if (!empty($post['outlet_latitude']) && (strpos($post['outlet_latitude'], ',') !== false || $post['outlet_latitude'] == 'NaN')) {
                return back()->withErrors(['Please input invalid latitude'])->withInput();
            }

            if (!empty($post['outlet_longitude']) && (strpos($post['outlet_longitude'], ',') !== false || $post['outlet_longitude'] == 'NaN')) {
                return back()->withErrors(['Please input invalid longitude'])->withInput();
            }

            //change pin
            // return $post;
            if (isset($post['outlet_pin']) || isset($post['generate_pin_outlet'])) {
                if (!isset($post['generate_pin_outlet'])) {
                    $validator = Validator::make($request->all(), [
                        'outlet_pin' => 'required|confirmed|min:6|max:6',
                    ], [
                        'confirmed' => 'Re-type PIN does not match',
                        'min'       => 'PIN must 6 digit',
                        'max'       => 'PIN must 6 digit'
                    ]);

                    if ($validator->fails()) {
                        return redirect('outlet/detail/' . $code . '#pin')
                                    ->withErrors($validator)
                                    ->withInput();
                    }
                }

                $save = MyHelper::post('outlet/update/pin', $post);
                return parent::redirect($save, 'Outlet pin has been changed.', 'outlet/detail/' . $code . '#pin');
            }

            if (isset($post['generate_pin_outlet'])) {
                $save          = MyHelper::post('outlet/update/pin', $post);
                return parent::redirect($save, 'Outlet photo has been added.', 'outlet/detail/' . $code . '#photo');
            }

            // photo
            if (isset($post['photo'])) {
                $post['photo'] = MyHelper::encodeImage($post['photo']);

                // save
                $save          = MyHelper::post('outlet/photo/create', $post);
                return parent::redirect($save, 'Outlet photo has been added.', 'outlet/detail/' . $code . '#photo');
            }

            // order photo
            if (isset($post['id_outlet_photo'])) {
                for ($x = 0; $x < count($post['id_outlet_photo']); $x++) {
                    $data = [
                        'id_outlet_photo' => $post['id_outlet_photo'][$x],
                        'outlet_photo_order' => $x + 1,
                    ];

                    /**
                     * save product photo
                     */
                    $save = MyHelper::post('outlet/photo/update', $data);

                    if (!isset($save['status']) || $save['status'] != "success") {
                        return redirect('outlet/detail/' . $code . '#photo')->witherrors(['Something went wrong. Please try again.']);
                    }
                }

                return redirect('outlet/detail/' . $code . '#photo')->with('success', ['Photo\'s order has been updated']);
            }

            // update
            if (isset($post['id_outlet'])) {
                if (!empty($post['outlet_open_hours'])) {
                    $post['outlet_open_hours']  = date('H:i:s', strtotime($post['outlet_open_hours']));
                }
                if (!empty($post['outlet_open_hours'])) {
                    $post['outlet_close_hours'] = date('H:i:s', strtotime($post['outlet_close_hours']));
                }

                $status_franchise = 0;

                if (isset($post['status_franchise'])) {
                    $status_franchise = $post['status_franchise'];
                }
                $post = array_filter($post);
                $post['status_franchise'] = $status_franchise;

                if (!empty($post['outlet_image_logo_portrait'])) {
                    $post['outlet_image_logo_portrait'] = MyHelper::encodeImage($post['outlet_image_logo_portrait']);
                }

                if (!empty($post['outlet_image_logo_landscape'])) {
                    $post['outlet_image_logo_landscape'] = MyHelper::encodeImage($post['outlet_image_logo_landscape']);
                }

                if (!empty($post['outlet_image_cover'])) {
                    $post['outlet_image_cover'] = MyHelper::encodeImage($post['outlet_image_cover']);
                }

                $save = MyHelper::post('outlet/update', $post);

                if (isset($post['outlet_code'])) {
                    $code = $post['outlet_code'];
                }

                if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, 'Outlet has been updated.', 'outlet/detail/' . $code . '#info');
                } else {
                    if (isset($save['errors'])) {
                        return back()->withErrors($save['errors'])->withInput();
                    }

                    if (isset($save['status']) && $save['status'] == "fail") {
                        return back()->withErrors($save['messages'])->withInput();
                    }

                       return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
                }
            }
        }
    }

    /*
    Manage Location
     */
    public function manageLocation(Request $request)
    {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Manage Location',
            'menu_active'    => 'outlet',
            'submenu_active' => 'manage-location',
        ];
        $page = $request->input('page') ?? 1;
        $data['take'] = 10;
        $post = [];
        if (session('outlet_location_filter')) {
            $post = session('outlet_location_filter');
            $data['rule'] = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        }
        if (session('outlet_location_take')) {
            $post['take'] = session('outlet_location_take') ?? 10;
            $data['take'] = $post['take'];
        }
        $post['order_field'] = session('outlet_location_order_field') ?? 'outlet_name';
        $data['order_field'] = $post['order_field'];
        $post['order_method'] = session('outlet_location_order_method') ?? 'asc';
        $data['order_method'] = $post['order_method'];
        $post['admin'] = 1;
        $req = MyHelper::post('outlet/be/list?page=' . $page, $post);
        $data['total'] = $req['result']['total'] ?? 0;
        $data['outlets'] = $req['result']['data'] ?? [];
        $data['next_page_url'] = ($req['result']['next_page_url'] ?? false) ? url()->current() . '?page=' . ($page + 1) : null;
        $data['prev_page_url'] = $page > 1 ? url()->current() . '?page=' . ($page - 1) : null;
        $data['outlets'] = $req['result']['data'] ?? [];
        $data['cities'] = MyHelper::get('city/list')['result'] ?? [];
        return view('outlet::manage_location', $data);
    }

    public function manageLocationPost(Request $request)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['outlet_location_filter' => $post]);
            return redirect('outlet/manage-location?page=1');
        }
        if ($post['take'] ?? false) {
            session(['outlet_location_take' => $post['take']]);
            session(['outlet_location_order_method' => $post['order_method'] ?? 'asc']);
            session(['outlet_location_order_field' => $post['order_field'] ?? 'outlet_name']);
            return redirect('outlet/manage-location?page=1');
        }
        if ($post['clear'] ?? false) {
            session(['outlet_location_take' => null]);
            session(['outlet_location_filter' => null]);
            return redirect('outlet/manage-location?page=1');
        }
        // clear filter
        session(['outlet_location_filter' => null]);
        // set order by last update first
        session(['outlet_location_order_method' => $post['order_method'] ?? 'desc']);
        session(['outlet_location_order_field' => $post['order_field'] ?? 'updated_at']);
        $req = MyHelper::post('outlet/batch-update', $post);
        if (($req['status'] ?? false) == 'success') {
            return redirect('outlet/manage-location?page=' . ($post['page'] ?? '1'))->with('success', ['Update success']);
        } else {
            return back()->withErrors(['Something went wrong. Please try again.']);
        }
    }

    public function updateStatus(Request $request)
    {
        $post = $request->except('_token');
        $update = MyHelper::post('outlet/update/status', $post);
        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success'];
        } elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $update['messages']];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update outlet status'];
        }
    }

    /*
    Propinsi
    */
    public function getPropinsi()
    {
        $province = MyHelper::get('province/list');

        if (isset($province['status']) && $province['status'] == "success") {
            return $province['result'];
        } else {
            return [];
        }
    }

    // get city
    public function getCity(Request $request)
    {
        $post = $request->except('_token');

        $query = MyHelper::post('city/list', $post);

        return $query;
    }

    public function getDistrict(Request $request)
    {
        $post = $request->except('_token');

        $query = MyHelper::post('district/list', $post);

        return $query;
    }

    public function getSubdistrict(Request $request)
    {
        $post = $request->except('_token');

        $query = MyHelper::post('subdistrict/list', $post);

        return $query;
    }

    /**
     * delete photo
     */
    public function deletePhoto(Request $request)
    {
        $post   = $request->all();

        $delete = MyHelper::post('outlet/photo/delete', ['id_outlet_photo' => $post['id_outlet_photo']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    /* DELETE OUTLET */
    public function delete(Request $request)
    {
        $post   = $request->all();

        $delete = MyHelper::post('outlet/delete', ['id_outlet' => $post['id_outlet']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    public function holiday(Request $request)
    {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet Holliday',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-holiday',
        ];
        $outlet = MyHelper::get('outlet/be/list');

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        } else {
            return redirect('outlet/create')->withErrors('Create Outlet First');
        }

        $holiday = MyHelper::get('outlet/holiday/list');
        if (isset($holiday['status']) && $holiday['status'] == "success") {
            $data['holiday'] = $holiday['result'];
        } else {
            $data['holiday'] = [];
        }
        return view('outlet::outlet_holiday', $data);
    }

    public function createHoliday(Request $request)
    {
        $post = $request->except('_token');
        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Outlet Holliday',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-holiday',
            ];

            $outlet = MyHelper::get('outlet/be/list');

            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet'] = $outlet['result'];
            } else {
                return redirect('outlet/create')->withErrors('Create Outlet First');
            }

            return view('outlet::holiday', $data);
        } else {
            $post = array_filter($post);

            $save = MyHelper::post('outlet/holiday/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, 'Outlet Holiday has been created.');
            } else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    public function deleteHoliday(Request $request)
    {
        $post   = $request->all();

        $delete = MyHelper::post('outlet/holiday/delete', ['id_holiday' => $post['id_holiday']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    public function detailHoliday(Request $request, $id_holiday)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Outlet Holliday',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-holiday',
            ];

            $holiday = MyHelper::post('outlet/holiday/list', ['id_holiday' => $id_holiday]);


            if (isset($holiday['status']) && $holiday['status'] == "success") {
                $data['holiday']    = $holiday['result'][0];
            } else {
                $e = ['e' => 'Data outlet holiday not found.'];
                return back()->witherrors($e);
            }

            $outlet = MyHelper::get('outlet/be/list');

            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet'] = $outlet['result'];
            } else {
                $e = ['e' => 'Data outlet not found.'];
                return redirect('outlet/list')->witherrors($e);
            }

            return view('outlet::outlet_holiday_update', $data);
        } else {
            //update
            $post['id_holiday'] = $id_holiday;
            $save = MyHelper::post('outlet/holiday/update', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return parent::redirect($save, 'Outlet Holiday has been updated.', 'outlet/holiday');
            } else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    public function exportImport(Request $request)
    {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Export & Import Outlet',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-export-import',
        ];
        $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
        return view('outlet::export_import', $data);
    }

    public function import(Request $request)
    {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Export & Import Outlet',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-import',
        ];

        return view('outlet::import', $data);
    }

    public function importOutlet(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Export & Import Outlet',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-export-import',
            ];
            $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
            return view('outlet::export_import', $data);
        } else {
            if ($request->file('import_file')) {
                $path = $request->file('import_file')->getRealPath();
                $name = $request->file('import_file')->getClientOriginalName();
                $dataimport = Excel::toArray(new FirstSheetOnlyImport(), $request->file('import_file'));
                $dataimport = array_map(function ($x) {
                    return (object)$x;
                }, $dataimport[0] ?? []);
                $save = MyHelper::post('outlet/import', ['data_import' => $dataimport]);

                if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, $save['message'], 'outlet/list');
                } else {
                    if (isset($save['errors'])) {
                        return back()->withErrors($save['errors'])->withInput();
                    }

                    if (isset($save['status']) && $save['status'] == "fail") {
                        return back()->withErrors($save['messages'])->withInput();
                    }
                    return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
                }
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            } else {
                return back()->withErrors(['File is required.'])->withInput();
            }
        }
    }

    public function importBrand(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Export & Import Outlet',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-export-import',
            ];
            $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];
            return view('outlet::export_import', $data);
        } else {
            if ($request->file('import_file')) {
                $path = $request->file('import_file')->getRealPath();
                $name = $request->file('import_file')->getClientOriginalName();
                $dataimport = Excel::toArray(new BrandOutletImport(), $request->file('import_file'));
                $dataimport = array_map(function ($x) {
                    return (object)$x;
                }, $dataimport[0] ?? []);
                $save = MyHelper::post('outlet/import-brand', ['data_import' => $dataimport]);

                if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, $save['message'], 'outlet/list');
                } else {
                    if (isset($save['errors'])) {
                        return back()->withErrors($save['errors'])->withInput();
                    }

                    if (isset($save['status']) && $save['status'] == "fail") {
                        return back()->withErrors($save['messages'])->withInput();
                    }
                    return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
                }
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            } else {
                return back()->withErrors(['File is required.'])->withInput();
            }
        }
    }

    public function exportForm(Request $request)
    {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Export Outlet',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-export',
        ];

        $data['brands'] = MyHelper::get('brand/be/list')['result'] ?? [];

        return view('outlet::export', $data);
    }

    public function exportDataCity(Request $request)
    {
        $post = $request->except('_token');
        $cities = MyHelper::post('outlet/export-city', $post);
        if (isset($cities['status']) && $cities['status'] == "success") {
            $dataExport['All Type'] = $cities['result'];
            $data = new MultisheetExport($dataExport);
            return Excel::download($data, 'Data_City_' . date('Ymdhis') . '.xls');
        } else {
            return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
        }
    }

    public function exportData(Request $request)
    {
        $post = $request->except('_token');
        $outlet = MyHelper::post('outlet/export', $post);
        if (isset($outlet['status']) && $outlet['status'] == "success") {
            if (isset($outlet['result']['All Type'])) {
                $ex = $outlet['result']['All Type'];
                //change long lat to float
                foreach ($ex as $key => $dt) {
                    $ex[$key]['latitude'] = ' ' . $dt['latitude'];
                    $ex[$key]['longitude'] = ' ' . $dt['longitude'];
                }
                $res = ['All Type' => $ex];
            } else {
                $res = $outlet['result'];
            }
            $data = new MultisheetExport($res);
            return Excel::download($data, 'Data_Outlets_' . date('Ymdhis') . '.xls');
        } else {
            return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
        }
    }

    public function createAdminOutlet(Request $request, $outlet_code)
    {
        $post = $request->except('_token');
        if (empty($post)) {
            $data = [
                'title'          => 'Outlet',
                'sub_title'      => 'Outlet Admin',
                'menu_active'    => 'outlet',
                'submenu_active' => 'outlet-list',
            ];
            // get user
            $user = MyHelper::post('users/list', $post);
            if (isset($user['status']) && $user['status'] == "success") {
                $data['users'] = $user['result'];
            } else {
                $data['users'] = [];
            }
            return view('outlet::create_admin_outlet', $data);
        } else {
            $post['outlet_code'] = $outlet_code;
            unset($post['user']);
            $post = array_filter($post);
            $save = MyHelper::post('outlet/admin/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, 'Admin Outlet has been created.', 'outlet/detail/' . $outlet_code . '#admin');
            } else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    public function deleteAdminOutlet(Request $request)
    {
        $post   = $request->all();

        $delete = MyHelper::post('outlet/admin/delete', $post);
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    public function detailAdminOutlet(Request $request, $outlet_code, $id_user_outlet)
    {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet Admin',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-list',
        ];
        $post['outlet_code'] = $outlet_code;
        $post['id_user_outlet'] = $id_user_outlet;
        $get = MyHelper::post('outlet/admin/detail', $post);
        if (isset($get['status']) && $get['status'] == "success") {
            $data['user_outlet'] = $get['result'];
        } else {
            if (isset($get['errors'])) {
                return back()->withErrors($get['errors'])->withInput();
            }

            if (isset($get['status']) && $get['status'] == "fail") {
                return back()->withErrors($get['messages'])->withInput();
            }

            return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
        }

        return view('outlet::edit_admin_outlet', $data);
    }

    public function updateAdminOutlet(Request $request, $outlet_code)
    {
        $post = $request->except('_token');

        $post = array_filter($post);
        $save = MyHelper::post('outlet/admin/update', $post);
        if (isset($save['status']) && $save['status'] == "success") {
                return parent::redirect($save, 'Admin Outlet has been updated.', 'outlet/detail/' . $outlet_code . '#admin');
        } else {
            if (isset($save['errors'])) {
                return back()->withErrors($save['errors'])->withInput();
            }

            if (isset($save['status']) && $save['status'] == "fail") {
                return back()->withErrors($save['messages'])->withInput();
            }

                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
        }
    }

    public function getUser(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['q'])) {
            $post['conditions'][0] = array(
                ['subject' => 'name', 'operator' => 'like', 'parameter' => $post['q']],
                ['subject' => 'email', 'operator' => 'like', 'parameter' => $post['q']],
                ['subject' => 'phone', 'operator' => 'like', 'parameter' => $post['q']]
            );
            $post['conditions'][0]['rule'] = 'or';
            $post['conditions'][0]['rule_next'] = 'or';
            unset($post['q']);
        }

        $user = parent::getData(MyHelper::post('users/list', $post));

        return $user;
    }

    public function scheduleSave(Request $request)
    {
        $post = $request->except('_token');

        $save = MyHelper::post('outlet/schedule/save', $post);
        // return $save;
        if (isset($save['status']) && $save['status'] == 'success') {
            return back()->with(['success' => ['Update schedule success']]);
        }

        return back()->withErrors(['Update failed']);
    }

    public function qrcodePrint()
    {
        $outlet = MyHelper::post('outlet/be/list', ['qrcode' => true]);

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        } else {
            $data['outlet'] = [];
        }
        return view('outlet::qrcode', $data);
    }

    public function qrcodeView(Request $request)
    {
        $post = $request->except('_token');

        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet QRCode',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-qrcode',
        ];

        $data['key'] = '';

        if (isset($post['page'])) {
            $dataPost = [
                'qrcode' => true,
                'qrcode_paginate' => true
            ];
            if (isset($post['key'])) {
                Session::forget('key_search');
                Session::put('key_search', $post['key']);
                $data['key'] = $post['key'];
                $dataPost['key_free'] = $post['key'];
            } else {
                if (Session::has('key_search')) {
                    $data['key'] = Session::get('key_search');
                    $dataPost['key_free'] = Session::get('key_search');
                }
            }
            $outlet = MyHelper::post('outlet/be/list?page=' . $post['page'], $dataPost);
        } else {
            $dataPost = [
                'qrcode' => true,
                'qrcode_paginate' => true
            ];
            if (isset($post['key'])) {
                Session::forget('key_search');
                Session::put('key_search', $post['key']);
                $data['key'] = $post['key'];
                $dataPost['key_free'] = $post['key'];
            } else {
                if (Session::has('key_search')) {
                    $data['key'] = Session::get('key_search');
                    $dataPost['key_free'] = Session::get('key_search');
                }
            }
            $outlet = MyHelper::post('outlet/be/list', $dataPost);
        }

        $data['from'] = 0;
        $data['to'] = 0;
        $data['total'] = 0;
        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['paginator'] = new LengthAwarePaginator($outlet['result']['data'], $outlet['result']['total'], $outlet['result']['per_page'], $outlet['result']['current_page'], ['path' => url()->current()]);
            $data['outlet'] = $outlet['result']['data'];
            $data['from'] = $outlet['result']['from'];
            $data['to'] = $outlet['result']['to'];
            $data['total'] = $outlet['result']['total'];
        } else {
            $data['outlet'] = [];
        }
        return view('outlet::qrcode_view', $data);
    }

    public function qrcodeExport()
    {
        ini_set('max_execution_time', '300');
        if (Session::has('key_search')) {
            $dataPost['qrcode'] = true;
            $dataPost['key_free'] = Session::get('key_search');
        } else {
            $dataPost['qrcode'] = true;
        }
        $outlet = MyHelper::post('outlet/be/list', $dataPost);
        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $folderName = "QRCode_" . date('Ymdhis');
            $createFolder = Storage::makeDirectory('QRCODE/' . $folderName, $mode = 0775);

            if ($createFolder) {
                foreach ($outlet['result'] as $val) {
                    $newFilename = $val['outlet_name'] . '.jpg';
                    $urlImage = $val['qrcode'];
                    $file_headers = @get_headers($urlImage);

                    if (isset($file_headers[0]) && strpos($file_headers[0], '200 OK') !== false) {
                        $putToStorange = Storage::put('QRCODE/' . $folderName . '/' . $newFilename, file_get_contents($urlImage));
                    } else {
                        continue;
                    }
                }

                $files = glob(storage_path('app/QRCODE/' . $folderName . '/*.jpg'));
                $archiveFile = storage_path('app/QRCODE/' . $folderName . '.zip');
                $zip = new ZipArchive();

                if ($zip->open($archiveFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
                    foreach ($files as $file) {
                        if ($zip->addFile($file, basename($file))) {
                            continue;
                        } else {
                            throw new Exception("file `{$file}` could not be added to the zip file: " . $zip->getStatusString());
                        }
                    }

                    // close the archive.
                    if ($zip->close()) {
                        // archive is now downloadable ...
                        File::deleteDirectory(storage_path('app/QRCODE/' . $folderName));
                        return response()->download($archiveFile, basename($archiveFile))->deleteFileAfterSend(true);
                    } else {
                        return redirect('outlet/qrcode')->withErrors('Can not export this file');
                    }
                }
            }
        } else {
            return redirect('outlet/qrcode')->withErrors('Not found QRCode outlet');
        }
    }

    public function qrcodeReset()
    {
        Session::forget('key_search');
        return redirect('outlet/qrcode');
    }

    public function ajaxHandler(Request $request)
    {
        $post = $request->except('_token');
        $outlets = MyHelper::post('outlet/ajax_handler', $post);
        return $outlets;
    }

    public function maxOrder(Request $request, $outlet_code = null)
    {
        $outlets = MyHelper::get('outlet/be/list')['result'] ?? [];
        if (!$outlets) {
            return back()->withErrors(['Something went wrong']);
        }
        if (!$outlet_code || !in_array($outlet_code, array_column($outlets, 'outlet_code'))) {
            $outlet = $outlets[0]['outlet_code'] ?? false;
            if (!$outlet) {
                return back()->withErrors(['Something went wrong']);
            }
            return redirect('outlet/max-order/' . $outlet);
        }
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => '',
            'menu_active'    => 'max-order',
            'submenu_active' => 'max-order',
            'filter_title'   => 'Filter Product',
        ];
        if (session('maxx_order_filter')) {
            $post = session('maxx_order_filter');
            $data['rule'] = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } else {
            $post = [];
        }
        $data['outlets'] = $outlets;
        $data['key'] = $outlet_code;
        $page = $request->page;
        if (!$page) {
            $page = 1;
        }
        $post['outlet_code'] = $outlet_code;
        $result = MyHelper::post('outlet/max-order?page=' . $page, $post)['result'] ?? false;
        if (!$result) {
            return MyHelper::post('outlet/max-order?page=' . $page, $post);
            return back()->withErrors(['Something went wrong']);
        }
        $data['total'] = $result['products']['total'];
        $data['start'] = $result['products']['from'];
        $data['data'] = $result;
        $data['paginator'] = new LengthAwarePaginator($result['products']['data'], $result['products']['total'], $result['products']['per_page'], $result['products']['current_page'], ['path' => url()->current()]);
        return view('outlet::max_order', $data);
    }
    public function maxOrderUpdate(Request $request, $outlet_code)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['maxx_order_filter' => $post]);
            return redirect('outlet/max-order/' . $outlet_code);
        }
        if ($post['clear'] ?? false) {
            session(['maxx_order_filter' => null]);
            return redirect('outlet/max-order/' . $outlet_code);
        }
        $post['outlet_code'] = $outlet_code;

        $update = MyHelper::post('outlet/max-order/update', $post);

        if (($update['status'] ?? false) == 'success') {
            return back()->with('success', ['Success update maximum order']);
        } else {
            return back()->withErrors($update['messages'] ?? ['Something went wrong']);
        }
    }

    public function exportBrandOutle(Request $request)
    {
        $post = $request->except('_token');
        $brand = MyHelper::post('brand/be/list', ['web' => 1]);
        $codeOutlet =  MyHelper::get('outlet/list/code');

        $data = [];
        if (isset($codeOutlet['status']) && $codeOutlet['status'] == 'success') {
            $count = count($codeOutlet['result']);
            $result = $codeOutlet['result'];
            for ($i = 0; $i < $count; $i++) {
                $data[$i]['code_outlet'] = $result[$i]['outlet_code'];
                $brands = $result[$i]['brands'];
                foreach ($brand['result'] as $value) {
                    $check = array_search($value['name_brand'], array_column($brands, 'name_brand'));

                    if ($check !== false) {
                        $data[$i][$value['name_brand']] = 'YES';
                    } else {
                        $data[$i][$value['name_brand']] = 'NO';
                    }
                }
            }
        }

        $dataExport['All Type'] = $data;
        $dataExport = new MultisheetExport($dataExport);
        return Excel::download($dataExport, 'Data_Brand_' . date('Ymdhis') . '.xls');
    }

    public function differentPrice(Request $request)
    {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Outlet Different Price',
            'menu_active'    => 'outlet-different-price',
            'submenu_active' => 'outlet-different-price',
            'filter_title'   => 'Filter Product',
        ];
        return view('outlet::different_price', $data);
    }
    public function getDifferentPrice(Request $request)
    {
        $filter['keyword'] = $request->post('keyword');
        $data = MyHelper::post('outlet/different_price', $filter)['result'] ?? [];
        return $data;
    }
    public function updateDifferentPrice(Request $request)
    {
        $post = $request->except('_token');
        $data = MyHelper::post('outlet/different_price/update', $post);
        return $data;
    }
    public function autoresponse(Request $request, $type = '')
    {
        $post = $request->except('_token');
        if (!empty($post)) {
            $outlet_apps_access_feature = $post['outlet_apps_access_feature'];
            unset($post['outlet_apps_access_feature']);
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
            MyHelper::post('setting/update2', ['update' => ['outlet_apps_access_feature' => ['value',$outlet_apps_access_feature]]]);
            // print_r($query);exit;
            return back()->withSuccess(['Setting updated']);
        }
        $data = [ 'title'             => 'Setting Messages Outlet App OTP',
                  'menu_active'       => 'outlet',
                  'submenu_active'    => 'outlet-pin-response',
                  'subject'           => 'outlet-app-request-pin'
                ];

        $getApiKey = MyHelper::get('setting/whatsapp?log_save=0');
        if (isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']) {
            $data['api_key_whatsapp'] = $getApiKey['result']['value'];
        } else {
            $data['api_key_whatsapp'] = null;
        }

        $data['textreplaces'] = [];
        if ($type == 'request_pin') {
            $type = 'outlet-app-request-pin';
            $view = 'outlet::response';
        } else {
            $data['title'] = 'Setting Forward Incomplete Outlet Data';
            $data['submenu_active'] = 'outlet-incomplete-response';
            $data['forwardOnly'] = true;
            $view = 'users::response';
        }
        $data['data'] = MyHelper::post('autocrm/list', ['autocrm_title' => ucfirst(str_replace('-', ' ', $type))])['result'] ?? [];
        $data['data']['outlet_apps_access_feature'] = MyHelper::post('setting', ['key' => 'outlet_apps_access_feature'])['result']['value'] ?? 'otp';
        $data['custom'] = explode(';', $data['data']['custom_text_replace']);
        return view($view, $data);
    }


    /*=========== User Franchise ===========*/
    public function listUserFranchise(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'User Mitra',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-list-user-franchise',
        ];

        if (Session::has('filter-list-user-franchise') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-user-franchise');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-user-franchise');
        }

        $list = MyHelper::post('outlet/list/user-franchise', $post);

        if (isset($list['status']) && $list['status'] == "success") {
            $data['paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
            $data['list'] = $list['result']['data'];
            $data['from'] = $list['result']['from'];
            $data['to'] = $list['result']['to'];
            $data['total'] = $list['result']['total'];
        } else {
            $data['paginator'] = [];
            $data['list'] = [];
            $data['from'] = [];
            $data['to'] = [];
            $data['total'] = [];
        }

        if ($post) {
            Session::put('filter-list-user-franchise', $post);
        }

        return view('outlet::users_franchise.list', $data);
    }

    public function detailUserFranchise(Request $request, $phone)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Detail User Mitra',
            'menu_active'    => 'outlet',
            'submenu_active' => 'outlet-list-user-franchise',
        ];

        $post['phone'] = $phone;
        $detail = MyHelper::post('outlet/detail/user-franchise', $post);

        if (isset($detail['status']) && $detail['status'] == "success") {
            $data['user'] = $detail['data_user'];
            if (!empty($detail['list_outlet'])) {
                $data['paginator'] = new LengthAwarePaginator($detail['list_outlet']['data'], $detail['list_outlet']['total'], $detail['list_outlet']['per_page'], $detail['list_outlet']['current_page'], ['path' => url()->current()]);
                $data['outlets'] = $detail['list_outlet']['data'];
                $data['from'] = $detail['list_outlet']['from'];
                $data['to'] = $detail['list_outlet']['to'];
                $data['total'] = $detail['list_outlet']['total'];
            } else {
                $data['paginator'] = [];
                $data['outlets'] = [];
                $data['from'] = [];
                $data['to'] = [];
                $data['total'] = [];
            }
        } else {
            $data['user'] = [];
            $data['paginator'] = [];
            $data['outlets'] = [];
            $data['from'] = [];
            $data['to'] = [];
            $data['total'] = [];
        }

        return view('outlet::users_franchise.detail', $data);
    }

    public function setPasswordDefaultUserFranchise(Request $request)
    {
        $post = $request->except('_token');
        $update = MyHelper::post('outlet/user-franchise/set-password-default', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('outlet/list/user-franchise')->with('success', ['Set up password success']);
        } else {
            return redirect('outlet/list/user-franchise')->withErrors($update['messages']);
        }
    }
    public function exportPin(Request $request)
    {
        $data = [
            'title'          => 'Outlet',
            'sub_title'      => 'Export Outlet Pin',
            'menu_active'    => 'outlet',
            'submenu_active' => 'export-outlet-pin',
        ];
        return view('outlet::export_outlet_pin', $data);
    }

    public function doExportPin(Request $request)
    {
        $checkpin = MyHelper::post('users/pin/check-backend', array('phone' => Session::get('phone'), 'pin' => $request->password, 'admin_panel' => 1));
        if ($checkpin['status'] != "success") {
            return back()->withErrors(['invalid_credentials' => 'Invalid PIN'])->withInput();
        }

        $dataOutlet = MyHelper::get('outlet/export-pin')['result'] ?? [];
        $dataOutlet = array_map(function ($i) {
            return [
                'Outlet Code' => $i['outlet_code'],
                'Outlet Name' => $i['outlet_name'],
                'Outlet PIN' => (string) $i['pin']
            ];
        }, $dataOutlet);
        return Excel::download(new ArrayExport($dataOutlet, 'Outlet PIN'), date('YmdHis') . '_Outlet_PIN.xlsx');
    }

    public function deliveryOutletAjax(Request $request)
    {
        $post = $request->except('_token');
        $draw = $post["draw"];
        $list = MyHelper::post('outlet/delivery-outlet-ajax', $post);

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
}
