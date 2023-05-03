<?php

namespace Modules\UserRating\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;

class UserRatingController extends Controller
{
    public function index(Request $request, $key = '')
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'User Rating List',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-list',
            'key'            => $key,
            'filter_title'   => 'User Rating Filter'
        ];
        $page = $request->get('page') ?: 1;
        $post = [];
        if ($key) {
            $post['outlet_code'] = $key;
        }
        if (session('rating_list_filter')) {
            $post = session('rating_list_filter');
            $data['rule'] = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        }
        $data['ratingData'] = MyHelper::post('user-rating?page=' . $page, $post)['result'] ?? [];
        $outlets = MyHelper::get('outlet/be/list')['result'] ?? [];
        $data['total'] = $data['ratingData']['total'] ?? 0;
        $data['outlets'] = array_map(function ($var) {
            return [$var['id_outlet'],$var['outlet_name']];
        }, $outlets);

        if (!empty($data['ratingData']['data'])) {
            $data['data']          = $data['ratingData']['data'];
            $data['dataTotal']     = $data['ratingData']['total'];
            $data['dataPerPage']   = $data['ratingData']['from'];
            $data['dataUpTo']      = $data['ratingData']['from'] + count($data['ratingData']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($data['ratingData']['data'], $data['ratingData']['total'], $data['ratingData']['per_page'], $data['ratingData']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        return view('userrating::index', $data);
    }

    public function setFilter(Request $request)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['rating_list_filter' => $post]);
        } elseif ($post['clear'] ?? false) {
            session(['rating_list_filter' => null]);
            session(['rating_list_filter' => null]);
        }
        return ($post['redirect'] ?? false) ? redirect($post['redirect']) : back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'User Rating Detail',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-list'
        ];
        $post = [
            'id' => $id
        ];
        $data['rating'] = MyHelper::post('user-rating/detail', $post)['result'] ?? false;
        if (!$data['rating']) {
            return back()->withErrors(['User rating not found']);
        }

        $post['id_transaction'] = $data['rating']['id_transaction'];
        $post['type'] = 'trx';
        $post['admin'] = 1;

        // $check = MyHelper::post('transaction/be/detail?log_save=0', $post);
        // $check = MyHelper::post('outletapp/order/detail/view?log_save=0', $data);
        // if (isset($check['status']) && $check['status'] == 'success') {
        //     $data['data'] = $check['result'];
        // } elseif (isset($check['status']) && $check['status'] == 'fail') {
        //     return view('error', ['msg' => 'Data failed']);
        // } else {
        //     return view('error', ['msg' => 'Something went wrong, try again']);
        // }
        return view('userrating::show', $data);
    }

    public function setting(Request $request)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'User Rating Setting',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'rating-setting'
        ];
        $ratings = MyHelper::post('setting', ['key-like' => 'rating'])['result'] ?? [];
        $popups = MyHelper::post('setting', ['key-like' => 'popup'])['result'] ?? [];
        $data['rating'] = [];
        $data['popup'] = [];

        $data['options'] = MyHelper::get('user-rating/option?outlet=true')['result'] ?? [];
        $data['options_dc'] = MyHelper::get('user-rating/option?doctor=true')['result'] ?? [];
        $data['options_product'] = MyHelper::get('user-rating/option?product=true')['result'] ?? [];

        foreach ($ratings as $rating) {
            $data['setting'][$rating['key']] = $rating;
        }
        foreach ($popups as $popup) {
            $data['setting'][$popup['key']] = $popup;
        }

        return view('userrating::setting', $data);
    }

    public function settingUpdate(Request $request)
    {
        $data = [
            'popup_min_interval' => ['value',$request->post('popup_min_interval')],
            'popup_max_list' => ['value',$request->post('popup_max_list')],
            'popup_max_refuse' => ['value',$request->post('popup_max_refuse')],
            'popup_max_days' => ['value',$request->post('popup_max_days')],
            'rating_question_text' => ['value_text',substr($request->post('rating_question_text'), 0, 40)],
            'product_rating_question_text' => ['value_text',substr($request->post('product_rating_question_text'), 0, 40)],
        ];
        $update = MyHelper::post('setting/update2', ['update' => $data]);
        if (($update['status'] ?? false) == 'success') {
            return redirect('user-rating/setting#tab_setting')->with('success', ['Success update setting']);
        } else {
            return redirect('user-rating/setting#setting')->withInput()->withErrors(['Failed update setting']);
        }
    }

    public function setReportFilter(Request $request)
    {
        $post = $request->except('_token');
        $new_sess = [];
        if ($request->post('date_start')) {
            $new_sess['rating_date_start'] = str_replace('-', '', $request->post('date_start', date('01 M Y')));
        }
        if ($request->post('date_end')) {
            $new_sess['rating_date_end'] = str_replace('-', '', $request->post('date_end', date('d M Y')));
        }
        if (!is_null($request->post('photos_only'))) {
            $new_sess['rating_photos_only'] = !!$request->post('photos_only');
        }
        if (!is_null($request->post('notes_only'))) {
            $new_sess['rating_notes_only'] = !!$request->post('notes_only');
        }
        if (!is_null($request->post('order'))) {
            $new_sess['rating_order'] = $request->post('order');
        }
        if (!is_null($request->post('transaction_type'))) {
            $new_sess['rating_transaction_type'] = $request->post('transaction_type');
        }
        if ($request->exists('search')) {
            $new_sess['rating_search'] = $request->post('search');
        }
        session($new_sess);
        return back();
    }

    public function autoresponse(Request $request, $target = null)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            if (isset($post['max_rating_value'])) {
                switch ($target) {
                    case 'product':
                        $maxRatingSubject = 'response_max_rating_value_product';
                        break;

                    case 'doctor':
                        $maxRatingSubject = 'response_max_rating_value_doctor';
                        break;

                    default:
                        $maxRatingSubject = 'response_max_rating_value';
                        break;
                }

                MyHelper::post('setting/update2', [
                    'update' => [
                        $maxRatingSubject => [
                            'value',
                            $post['max_rating_value']
                        ]
                    ]
                ]);
                unset($post['max_rating_value']);
            }

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


        $data = [
            'title'             => 'User Rating Auto Response',
            'menu_active'       => 'user-rating',
            'submenu_active'    => 'user-rating-response-doctor',
            'subject'           => 'user-rating-doctor'
        ];
        $data['textreplaces'] = MyHelper::get('autocrm/textreplace')['result'] ?? [];

        switch ($target) {
            case 'product':
                $data['submenu_active'] = 'user-rating-response-product';
                $data['subject'] = 'user-rating-product';
                $data['max_rating_value'] = MyHelper::post('setting', ['key' => 'response_max_rating_value_product'])['result']['value'] ?? 2;
                $data['data'] = MyHelper::post('autocrm/list', ['autocrm_title' => 'User Rating Product'])['result'] ?? [];
                $data['custom'] = explode(';', ($data['data']['custom_text_replace'] ?? null));
                break;

            case 'doctor':
                $data['submenu_active'] = 'user-rating-response-doctor';
                $data['subject'] = 'user-rating-doctor';
                $data['max_rating_value'] = MyHelper::post('setting', ['key' => 'response_max_rating_value_doctor'])['result']['value'] ?? 2;
                $data['data'] = MyHelper::post('autocrm/list', ['autocrm_title' => 'User Rating doctor'])['result'] ?? [];
                $data['custom'] = explode(';', ($data['data']['custom_text_replace'] ?? null));
                break;

            default:
                $data['max_rating_value'] = MyHelper::post('setting', ['key' => 'response_max_rating_value'])['result']['value'] ?? 2;
                $data['data'] = MyHelper::post('autocrm/list', ['autocrm_title' => 'User Rating Outlet'])['result'] ?? [];
                $data['custom'] = explode(';', ($data['data']['custom_text_replace'] ?? null));
                break;
        }

        return view('userrating::response', $data);
    }

    public function reportProduct(Request $request, $id_outlet = null)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'Report User Rating',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-report',
            'filter_title'   => 'User Rating Filter'
        ];
        $date_start = date('Y-m-d H:i:s', strtotime(session('rating_product_date_start', date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s', strtotime(session('rating_product_date_end', date('Y-m-d H:i:s'))));
        $post['photos_only'] = session('rating_product_photos_only', 0);
        $post['notes_only'] = session('rating_product_notes_only', 0);
        $post['transaction_type'] = session('rating_product_transaction_type', 'all');
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $post['id_outlet'] = $id_outlet;
        $post['rating_target'] = 'product';
        $data['reportData'] = MyHelper::post('user-rating/report', $post)['result'] ?? [];
        if (!$data['reportData']) {
            return back()->withErrors(['Rating data not found']);
        }
        $ratingOk = [];
        foreach ($data['reportData']['rating_item'] as $value) {
            $ratingOk[$value['rating_value']] = $value;
        }
        $outletOk = [];
        $colorRand = ['#FF6600','#FCD202','#FF6600','#FCD202','#DADADA','#3598dc','#2C3E50','#1BBC9B','#94A0B2','#1BA39C','#e7505a','#D91E18'];
        $outletName = $data['reportData']['outlet_name'] ?? '';
        foreach ($data['reportData']['rating_data'] as $value) {
            if (!$colorRand) {
                $colorRand = ['#FF6600','#FCD202','#FF6600','#FCD202','#DADADA','#3598dc','#2C3E50','#1BBC9B','#94A0B2','#1BA39C','#e7505a','#D91E18'];
            }
            $randomNumber = array_rand($colorRand);
            $outletOk[$value['rating_value']][] = [
                'name' => $value['outlet_code'] . ' - ' . $value['outlet_name'],
                'total' => $value['total'],
                'color' => $colorRand[$randomNumber]
            ];
            unset($colorRand[$randomNumber]);
        }
        $data['date_start'] = date('d F Y', strtotime($date_start));
        $data['date_end'] = date('d F Y', strtotime($date_end));
        $data['reportData']['rating_item'] = $ratingOk;
        $data['reportData']['rating_data'] = $outletOk;
        $data['redirect_url'] = url('user-rating/report/product');

        if (!empty($id_outlet)) {
            $data['sub_title'] = 'Report User Rating Outlet ' . $outletName;
            $data['submenu_active'] = 'user-rating-report-outlet';
        } else {
            $data['sub_title'] = 'Report User Rating Product';
            $data['submenu_active'] = 'user-rating-report-product';
        }
        return view('userrating::report', $data + $post);
    }

    public function setReportFilterProduct(Request $request)
    {
        $post = $request->except('_token');
        $new_sess = [];
        if ($request->post('date_start')) {
            $new_sess['rating_product_date_start'] = str_replace('-', '', $request->post('date_start', date('01 M Y')));
        }
        if ($request->post('date_end')) {
            $new_sess['rating_product_date_end'] = str_replace('-', '', $request->post('date_end', date('d M Y')));
        }
        if (!is_null($request->post('photos_only'))) {
            $new_sess['rating_product_photos_only'] = !!$request->post('photos_only');
        }
        if (!is_null($request->post('notes_only'))) {
            $new_sess['rating_product_notes_only'] = !!$request->post('notes_only');
        }
        if (!is_null($request->post('order'))) {
            $new_sess['rating_product_order'] = $request->post('order');
        }
        if (!is_null($request->post('transaction_type'))) {
            $new_sess['rating_product_transaction_type'] = $request->post('transaction_type');
        }
        if ($request->exists('search')) {
            $new_sess['rating_product_search'] = $request->post('search');
        }
        session($new_sess);
        return back();
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reportListProduct(Request $request)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'Report User Rating Product',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-report-product',
            'filter_title'   => 'User Rating Filter'
        ];
        $post = $request->except('_token');
        $date_start = date('Y-m-d H:i:s', strtotime(session('rating_product_date_start', date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s', strtotime(session('rating_product_date_end', date('Y-m-d H:i:s'))));
        $page = $request->get('page') ?: 1;
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $post['order'] = session('rating_product_order', 'product_name');
        $post['search'] = session('rating_product_search');
        $post['page'] = $page;
        $post['transaction_type'] = session('rating_product_transaction_type', 'all');
        $post['rating_target'] = 'product';
        $data['rating_data'] = MyHelper::post('user-rating/report/product', $post)['result'] ?? [];
        $data['next_page'] = $data['rating_data']['next_page_url'] ? url()->current() . '?page=' . ($page + 1) : '';
        $data['prev_page'] = $data['rating_data']['prev_page_url'] ? url()->current() . '?page=' . ($page - 1) : '';
        $data['date_start'] = date('d F Y', strtotime($date_start));
        $data['date_end'] = date('d F Y', strtotime($date_end));
        $data['redirect_url'] = url('user-rating/report/product');
        return view('userrating::report_list', $data + $post);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reportDetailProduct(Request $request, $id_product)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'Report User Rating Product',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-report-product',
            'filter_title'   => 'User Rating Filter'
        ];
        $date_start = date('Y-m-d H:i:s', strtotime(session('rating_product_date_start', date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s', strtotime(session('rating_product_date_end', date('Y-m-d H:i:s'))));
        $post['photos_only'] = session('rating_product_photos_only', 0);
        $post['notes_only'] = session('rating_product_notes_only', 0);
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $post['id_product'] = $id_product;
        $post['transaction_type'] = session('rating_product_transaction_type', 'all');
        $post['rating_target'] = 'product';
        $data['reportData'] = MyHelper::post('user-rating/report/product', $post)['result'] ?? [];
        if (!$data['reportData']) {
            return back()->withErrors(['Rating data not found']);
        }
        $colorRand = ['#FF6600','#FCD202','#FF6600','#FCD202','#DADADA','#3598dc','#2C3E50','#1BBC9B','#94A0B2','#1BA39C','#e7505a','#D91E18'];
        $data['date_start'] = date('d F Y', strtotime($date_start));
        $data['date_end'] = date('d F Y', strtotime($date_end));
        $data['redirect_url'] = url('user-rating/report/product');
        return view('userrating::report_detail', $data + $post);
    }


    public function reportDoctor(Request $request)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'Report User Rating Doctor',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-report-doctor',
            'filter_title'   => 'User Rating Filter'
        ];
        $date_start = date('Y-m-d H:i:s', strtotime(session('rating_doctor_date_start', date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s', strtotime(session('rating_doctor_date_end', date('Y-m-d H:i:s'))));
        $post['photos_only'] = session('rating_doctor_photos_only', 0);
        $post['notes_only'] = session('rating_doctor_notes_only', 0);
        $post['transaction_type'] = session('rating_doctor_transaction_type', 'all');
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $post['rating_target'] = 'doctor';
        $data['reportData'] = MyHelper::post('user-rating/report', $post)['result'] ?? [];
        if (!$data['reportData']) {
            return back()->withErrors(['Rating data not found']);
        }
        $ratingOk = [];
        foreach ($data['reportData']['rating_item'] as $value) {
            $ratingOk[$value['rating_value']] = $value;
        }
        $outletOk = [];
        $colorRand = ['#FF6600','#FCD202','#FF6600','#FCD202','#DADADA','#3598dc','#2C3E50','#1BBC9B','#94A0B2','#1BA39C','#e7505a','#D91E18'];
        foreach ($data['reportData']['rating_data'] as $value) {
            if (!$colorRand) {
                $colorRand = ['#FF6600','#FCD202','#FF6600','#FCD202','#DADADA','#3598dc','#2C3E50','#1BBC9B','#94A0B2','#1BA39C','#e7505a','#D91E18'];
            }
            $randomNumber = array_rand($colorRand);
            $outletOk[$value['rating_value']][] = [
                'name' => $value['outlet_code'] . ' - ' . $value['outlet_name'],
                'total' => $value['total'],
                'color' => $colorRand[$randomNumber]
            ];
            unset($colorRand[$randomNumber]);
        }
        $data['date_start'] = date('d F Y', strtotime($date_start));
        $data['date_end'] = date('d F Y', strtotime($date_end));
        $data['reportData']['rating_item'] = $ratingOk;
        $data['reportData']['rating_data'] = $outletOk;
        $data['redirect_url'] = url('user-rating/report/doctor');
        return view('userrating::report', $data + $post);
    }

    public function setReportFilterDoctor(Request $request)
    {
        $post = $request->except('_token');
        $new_sess = [];
        if ($request->post('date_start')) {
            $new_sess['rating_doctor_date_start'] = str_replace('-', '', $request->post('date_start', date('01 M Y')));
        }
        if ($request->post('date_end')) {
            $new_sess['rating_doctor_date_end'] = str_replace('-', '', $request->post('date_end', date('d M Y')));
        }
        if (!is_null($request->post('photos_only'))) {
            $new_sess['rating_doctor_photos_only'] = !!$request->post('photos_only');
        }
        if (!is_null($request->post('notes_only'))) {
            $new_sess['rating_doctor_notes_only'] = !!$request->post('notes_only');
        }
        if (!is_null($request->post('order'))) {
            $new_sess['rating_doctor_order'] = $request->post('order');
        }
        if (!is_null($request->post('transaction_type'))) {
            $new_sess['rating_doctor_transaction_type'] = $request->post('transaction_type');
        }
        if ($request->exists('search')) {
            $new_sess['rating_doctor_search'] = $request->post('search');
        }
        session($new_sess);
        return back();
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reportListDoctor(Request $request)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'Report User Rating Doctor',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-report-doctor',
            'filter_title'   => 'User Rating Filter'
        ];
        $post = $request->except('_token');
        $date_start = date('Y-m-d H:i:s', strtotime(session('rating_doctor_date_start', date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s', strtotime(session('rating_doctor_date_end', date('Y-m-d H:i:s'))));
        $page = $request->get('page') ?: 1;
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $post['order'] = session('rating_doctor_order', 'doctor_name');
        $post['search'] = session('rating_doctor_search');
        $post['page'] = $page;
        $post['transaction_type'] = session('rating_doctor_transaction_type', 'all');
        $post['rating_target'] = 'doctor';
        $data['rating_data'] = MyHelper::post('user-rating/report/doctor', $post)['result'] ?? [];
        $data['next_page'] = $data['rating_data']['next_page_url'] ? url()->current() . '?page=' . ($page + 1) : '';
        $data['prev_page'] = $data['rating_data']['prev_page_url'] ? url()->current() . '?page=' . ($page - 1) : '';
        $data['date_start'] = date('d F Y', strtotime($date_start));
        $data['date_end'] = date('d F Y', strtotime($date_end));
        $data['redirect_url'] = url('user-rating/report/doctor');
        return view('userrating::report_list', $data + $post);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reportDetailDoctor(Request $request, $id_doctor)
    {
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'Report User Rating Doctor',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-report-doctor',
            'filter_title'   => 'User Rating Filter'
        ];
        $date_start = date('Y-m-d H:i:s', strtotime(session('rating_doctor_date_start', date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s', strtotime(session('rating_doctor_date_end', date('Y-m-d H:i:s'))));
        $post['photos_only'] = session('rating_doctor_photos_only', 0);
        $post['notes_only'] = session('rating_doctor_notes_only', 0);
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $post['id_doctor'] = $id_doctor;
        $post['transaction_type'] = session('rating_doctor_transaction_type', 'all');
        $post['rating_target'] = 'doctor';
        $data['reportData'] = MyHelper::post('user-rating/report/doctor', $post)['result'] ?? [];
        if (!$data['reportData']) {
            return back()->withErrors(['Rating data not found']);
        }
        $colorRand = ['#FF6600','#FCD202','#FF6600','#FCD202','#DADADA','#3598dc','#2C3E50','#1BBC9B','#94A0B2','#1BA39C','#e7505a','#D91E18'];
        $data['date_start'] = date('d F Y', strtotime($date_start));
        $data['date_end'] = date('d F Y', strtotime($date_end));
        $data['redirect_url'] = url('user-rating/report/doctor');
        return view('userrating::report_detail', $data + $post);
    }

    public function reportOutlet(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'User Rating',
            'sub_title'      => 'Report User Rating Outlet',
            'menu_active'    => 'user-rating',
            'submenu_active' => 'user-rating-report-outlet'
        ];

        if (Session::has('filter-list-user-rating-outlet') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-user-rating-outlet');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-user-rating-outlet');
        }

        $outlets   = MyHelper::post('user-rating/report/outlet', $post);

        if (isset($outlets['status']) && $outlets['status'] == "success") {
            $data['data']          = $outlets['result']['data'];
            $data['dataTotal']     = $outlets['result']['total'];
            $data['dataPerPage']   = $outlets['result']['from'];
            $data['dataUpTo']      = $outlets['result']['from'] + count($outlets['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($outlets['result']['data'], $outlets['result']['total'], $outlets['result']['per_page'], $outlets['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if ($post) {
            Session::put('filter-list-user-rating-outlet', $post);
        }

        return view('userrating::report_outlet', $data);
    }
}
