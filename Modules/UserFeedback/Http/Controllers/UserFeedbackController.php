<?php

namespace Modules\UserFeedback\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class UserFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'User Feedback List',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'user-feedback-list',
            'filter_title'   => 'User Feedback Filter'
        ];
        $page = $request->get('page') ?: 1;
        $post = [];

        if (session('feedback_list_filter')) {
            $post = session('feedback_list_filter');
            $data['rule'] = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'] ?? 'and';
        }
        $rating_items = MyHelper::get('user-feedback/rating-item')['result'] ?? [];
        $data['rating_items'] = [];
        foreach ($rating_items as $item) {
            $data['rating_items'][$item['rating_value']] = $item['text'];
        }
        $data['feedbackData'] = MyHelper::post('user-feedback?page=' . $page, $post)['result'] ?? [];
        $data['total'] = $data['feedbackData']['total'] ?? count($data['feedbackData']['data'] ?? []);
        $data['outlets'] = array_map(function ($var) {
            $var = [$var['id_outlet'],$var['outlet_name']];
            return $var;
        }, MyHelper::get('outlet/be/list')['result'] ?? []);
        $data['next_page'] = $data['feedbackData']['next_page_url'] ? url()->current() . '?page=' . ($page + 1) : '';
        $data['prev_page'] = $data['feedbackData']['prev_page_url'] ? url()->current() . '?page=' . ($page - 1) : '';
        return view('userfeedback::index', $data);
    }

    public function setFilter(Request $request)
    {
        $post = $request->except('_token');
        if ($post['rule'] ?? false) {
            session(['feedback_list_filter' => $post]);
        } elseif ($post['clear'] ?? false) {
            session(['feedback_list_filter' => null]);
            session(['feedback_list_filter' => null]);
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
            'title'          => 'User Feedback',
            'sub_title'      => 'User Feedback Detail',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'user-feedback-list'
        ];
        $ids = explode('#', base64_decode($id));
        if (!is_numeric($ids[0]) || !is_numeric($ids[1])) {
            return back()->withErrors(['User feedback not found']);
        }
        $post = [
            'id_user_feedback' => $ids[0] ?? '',
            'id_transaction' => $ids[1] ?? ''
        ];
        $rating_items = MyHelper::get('user-feedback/rating-item')['result'] ?? [];
        $data['rating_items'] = [];
        foreach ($rating_items as $item) {
            $data['rating_items'][$item['rating_value']] = $item['text'];
        }
        $data['feedback'] = MyHelper::post('user-feedback/detail', $post)['result'] ?? false;
        if (!$data['feedback']) {
            return back()->withErrors(['User feedback not found']);
        }

        // $check = MyHelper::post('outletapp/order/detail/view?log_save=0', $data);
        $check = MyHelper::post('transaction/be/detail', ['id_transaction' => $data['feedback']['id_transaction'], 'type' => 'trx', 'admin' => 1]);

        if (isset($check['status']) && $check['status'] == 'success') {
            $data['data'] = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        return view('userfeedback::show', $data);
    }
    public function setting(Request $request)
    {
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'User Feedback Setting',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'feedback-setting'
        ];
        $ratings = MyHelper::post('setting', ['key-like' => 'rating'])['result'] ?? [];
        $popups = MyHelper::post('setting', ['key-like' => 'popup'])['result'] ?? [];
        $data['rating'] = [];
        $data['popup'] = [];
        foreach ($ratings as $rating) {
            $data['setting'][$rating['key']] = $rating;
        }
        foreach ($popups as $popup) {
            $data['setting'][$popup['key']] = $popup;
        }
        $items = MyHelper::get('user-feedback/rating-item')['result'] ?? [];
        $newArr = [];
        foreach ($items as $item) {
            $newArr[$item['rating_value']] = $item;
        }
        $data['items'] = $newArr;
        return view('userfeedback::setting', $data);
    }

    public function settingUpdate(Request $request)
    {
        $data = [
            'popup_min_interval' => ['value',$request->post('popup_min_interval')],
            'popup_max_refuse' => ['value',$request->post('popup_max_refuse')],
            'popup_max_days' => ['value',$request->post('popup_max_days')],
            'rating_question_text' => ['value_text',substr($request->post('rating_question_text'), 0, 40)]
        ];
        $update = MyHelper::post('setting/update2', ['update' => $data]);
        if (($update['status'] ?? false) == 'success') {
            return back()->with('success', ['Success update setting']);
        } else {
            return back()->withInput()->withErrors(['Failed update setting']);
        }
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function report(Request $request)
    {
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'Report User Feedback',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'user-feedback-report',
            'filter_title'   => 'User Feedback Filter'
        ];
        $date_start = date('Y-m-d H:i:s', strtotime(session('feedback_date_start', date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s', strtotime(session('feedback_date_end', date('Y-m-d H:i:s'))));
        $post['photos_only'] = session('feedback_photos_only', 0);
        $post['notes_only'] = session('feedback_notes_only', 0);
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $data['reportData'] = MyHelper::post('user-feedback/report', $post)['result'] ?? [];
        if (!$data['reportData']) {
            return back()->withErrors(['Feedback data not found']);
        }
        $feedbackOk = [];
        foreach ($data['reportData']['rating_item'] as $value) {
            $feedbackOk[$value['rating_value']] = $value;
        }
        $outletOk = [];
        $colorRand = ['#FF6600','#FCD202','#FF6600','#FCD202','#DADADA','#3598dc','#2C3E50','#1BBC9B','#94A0B2','#1BA39C','#e7505a','#D91E18'];
        foreach ($data['reportData']['outlet_data'] as $value) {
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
        $data['date_start_raw'] = $date_start;
        $data['date_end_raw'] = $date_end;
        $data['date_start'] = date('d F Y', strtotime($date_start));
        $data['date_end'] = date('d F Y', strtotime($date_end));
        $data['reportData']['rating_item'] = $feedbackOk;
        $data['reportData']['outlet_data'] = $outletOk;
        return view('userfeedback::report', $data + $post);
    }
    public function setReportFilter(Request $request)
    {
        $post = $request->except('_token');
        $new_sess = [];
        if ($request->post('date_start')) {
            $new_sess['feedback_date_start'] = str_replace('-', '', $request->post('date_start', date('01 M Y')));
        }
        if ($request->post('date_end')) {
            $new_sess['feedback_date_end'] = str_replace('-', '', $request->post('date_end', date('d M Y')));
        }
        if (!is_null($request->post('photos_only'))) {
            $new_sess['feedback_photos_only'] = !!$request->post('photos_only');
        }
        if (!is_null($request->post('notes_only'))) {
            $new_sess['feedback_notes_only'] = !!$request->post('notes_only');
        }
        if (!is_null($request->post('order'))) {
            $new_sess['feedback_order'] = $request->post('order');
        }
        if ($request->exists('search')) {
            $new_sess['feedback_search'] = $request->post('search');
        }
        session($new_sess);
        return back();
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reportOutlet(Request $request)
    {
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'Report User Feedback',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'user-feedback-report',
            'filter_title'   => 'User Feedback Filter'
        ];
        $post = $request->except('_token');
        $date_start = date('Y-m-d H:i:s', strtotime(session('feedback_date_start', date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s', strtotime(session('feedback_date_end', date('Y-m-d H:i:s'))));
        $page = $request->get('page') ?: 1;
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $post['order'] = session('feedback_order', 'outlet_name');
        $post['search'] = session('feedback_search');
        $post['page'] = $page;
        // return $post;
        $data['outlet_data'] = MyHelper::post('user-feedback/report/outlet', $post)['result'] ?? [];
        $data['next_page'] = $data['outlet_data']['next_page_url'] ? url()->current() . '?page=' . ($page + 1) : '';
        $data['prev_page'] = $data['outlet_data']['prev_page_url'] ? url()->current() . '?page=' . ($page - 1) : '';
        $data['date_start'] = date('d F Y', strtotime($date_start));
        $data['date_end'] = date('d F Y', strtotime($date_end));
        return view('userfeedback::report_outlet', $data + $post);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reportOutletDetail(Request $request, $outlet_code)
    {
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'Report User Feedback',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'user-feedback-report',
            'filter_title'   => 'User Feedback Filter'
        ];
        $date_start = date('Y-m-d H:i:s', strtotime(session('feedback_date_start', date('Y-m-01 H:i:s'))));
        $date_end = date('Y-m-d H:i:s', strtotime(session('feedback_date_end', date('Y-m-d H:i:s'))));
        $post['photos_only'] = session('feedback_photos_only', 0);
        $post['notes_only'] = session('feedback_notes_only', 0);
        $post['date_start'] = $date_start;
        $post['date_end'] = $date_end;
        $post['outlet_code'] = $outlet_code;
        $data['reportData'] = MyHelper::post('user-feedback/report/outlet', $post)['result'] ?? [];
        if (!$data['reportData']) {
            return back()->withErrors(['Feedback data not found']);
        }
        $feedbackOk = [];
        foreach ($data['reportData']['rating_item'] as $value) {
            $feedbackOk[$value['rating_value']] = $value;
        }
        $colorRand = ['#FF6600','#FCD202','#FF6600','#FCD202','#DADADA','#3598dc','#2C3E50','#1BBC9B','#94A0B2','#1BA39C','#e7505a','#D91E18'];
        $data['date_start'] = date('d F Y', strtotime($date_start));
        $data['date_end'] = date('d F Y', strtotime($date_end));
        $data['reportData']['rating_item'] = $feedbackOk;
        return view('userfeedback::report_outlet_detail', $data + $post);
    }

    public function autoresponse(Request $request)
    {
        $post = $request->except('_token');
        if (!empty($post)) {
            if (isset($post['max_rating_value'])) {
                MyHelper::post('setting/update2', [
                    'update' => [
                        'response_feedback_max_rating_value' => ['value',$post['max_rating_value']]
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
        $data = [ 'title'             => 'User Rating Auto Response',
                  'menu_active'       => 'user-rating',
                  'submenu_active'    => 'user-rating-response',
                  'subject'           => 'user-rating'
                ];
        $data['max_rating_value'] = MyHelper::post('setting', ['key' => 'response_feedback_max_rating_value'])['result']['value'] ?? 2;
        $data['textreplaces'] = MyHelper::get('autocrm/textreplace')['result'] ?? [];
        $data['data'] = MyHelper::post('autocrm/list', ['autocrm_title' => 'User Feedback'])['result'] ?? [];
        $data['custom'] = explode(';', $data['data']['custom_text_replace']);
        return view('userfeedback::response', $data);
    }
}
