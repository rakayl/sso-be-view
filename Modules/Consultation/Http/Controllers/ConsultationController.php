<?php

namespace Modules\Consultation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use Excel;
use App\Exports\MultisheetExport;
use App\Lib\MyHelper;

class ConsultationController extends Controller
{
    // public function index()
    // {
    //     return view('consultation::index');
    // }

    public function consultationList()
    {
        $data = [];
        $data = [
            'title'          => 'Consultation',
            'menu_active'    => 'consultation',
            'submenu_active' => 'consultation-list'
        ];

        $list = MyHelper::get('consultation');

        if (isset($list['status']) && $list['status'] == 'success') {
            $data['list'] = $list['result'];
        } else {
            return view('consultation::consultationList', $data)->withErrors($list['messages']);
        }

        return view('consultation::consultationList', $data);
    }

    public function consultationSearch()
    {
        $data = [];
        $data = [
            'title'   => 'Consultation',
            'menu_active'    => 'consultation',
            'submenu_active' => 'consultation-search'
        ];

        $getList = MyHelper::get('consultation');
        if ($getList['status'] == 'success') {
            $data['list'] = $getList['result'];
        } else {
            $data['list'] = null;
        }

        // return $data;
        return view('consultation::consultationSearch', $data);
    }

    public function consultationFilter(Request $request)
    {
        $post = $request->all();

        if (empty($post)) {
            return redirect('consultation/search');
        }

        $data = [];
        $data = [
            'title'   => 'Consultation',
            'sub_title'   => 'Filter',
            'menu_active'    => 'consultation',
            'submenu_active' => 'consultation-search'
        ];

        $filter = MyHelper::post('consultation/filter', $post);

        if (isset($filter['status']) && $filter['status'] == 'success') {
            $data['list']       = $filter['data'];
            $data['conditions'] = $filter['conditions'];
            $data['count']      = $filter['count'];
            $data['rule']       = $filter['rule'];
            $data['search']     = $filter['search'];
            return view('consultation::consultationSearch', $data);
        } elseif (isset($filter['status']) && $filter['status'] == 'fail') {
            $data['list']       = $filter['data'];
            $data['conditions'] = $filter['conditions'];
            $data['count']      = $filter['count'];
            $data['rule']       = $filter['rule'];
            $data['search']     = $filter['search'];

            return view('consultation::consultationSearch', $data);
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Consultation',
            'sub_title'      => 'Consultation List',
            'menu_active'    => 'consultation',
            'submenu_active' => 'consultation-list',
            'filter_title'   => 'Filter Consultation',
        ];

        if (session('list_consultation_filter')) {
            $extra = session('list_consultation_filter');
            $data['rule'] = array_map('array_values', $extra['rule']);
            $data['operator'] = $extra['operator'];
        } else {
            $extra = [
                'rule' => [],
                'operator' => ''
            ];
            $data['rule'] = array_map('array_values', $extra['rule']);
            $data['operator'] = $extra['operator'];
            $data['hide_record_total'] = 1;
        }

        if ($request->wantsJson()) {
            $data = MyHelper::post('be/consultation', $post + $extra)['result'] ?? [];
            $data['recordsFiltered'] = $data['total'] ?? 0;
            $data['recordsTotal'] = $data['total'] ?? 0;
            $data['draw'] = $request->draw;

            return $data;
        }

        // outlets
        $outlets = MyHelper::post('outlet/be/list', ['all_outlet' => 1])['result'] ?? [];

        $outletOption = [];
        if (!empty($outlets)) {
            foreach ($outlets as $key => $outlet) {
                $outletOption[] = $outlet['outlet_name'];
            }
        }

        $data['outlet'] = $outletOption;

        return view('consultation::index', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function filter(Request $request)
    {
        $post = $request->all();

        if (($post['rule'] ?? false) && !isset($post['draw'])) {
            session(['list_consultation_filter' => $post]);
            return back();
        }

        if ($post['clear'] ?? false) {
            session(['list_consultation_filter' => null]);
            return back();
        }

        return abort(404);
    }

    public function detail($id)
    {
        $data = [
            'title'          => 'Consultation',
            'sub_title'      => 'Consultation List',
            'menu_active'    => 'consultation',
            'submenu_active' => 'consultation-list',
        ];

        $consultation = MyHelper::get('be/consultation/detail/' . $id);
        //dd($consultation);
        if ($consultation['status'] == 'success') {
            $data['result'] = $consultation['result'];
        } else {
            $data['result'] = null;
        }

        //dd($data['result']);

        return view('consultation::detail', $data);
    }

    public function editStatusConsultation($id)
    {
        $data = [
            'title'          => 'Consultation',
            'sub_title'      => 'Manage Consultation',
            'menu_active'    => 'consultation',
            'submenu_active' => 'consultation-list',
        ];

        $consultation = MyHelper::get('be/consultation/detail/' . $id);

        if ($consultation['status'] == 'success') {
            $data['result'] = $consultation['result'];
        } else {
            $data['result'] = null;
        }

        return view('consultation::edit', $data);
    }

    public function updateStatusConsultation(Request $request)
    {
        $post = $request->except('_token');
        unset($post['use_reason']);

        $update = MyHelper::post('be/consultation/update', $post);
        return redirect('consultation/be/' . $post['id_transaction'] . '/detail')->with('success', ['Update Status Consultation Success']);
    }

    public function getScheduleTime(Request $request)
    {
        $post = $request->except('_token');

        $consultation = MyHelper::post('be/consultation/get-schedule-time', $post);

        if ($consultation['status'] == 'success') {
            $data = $consultation['result'];
        } else {
            $data = null;
        }

        return $data;
    }

    public function autoResponse(Request $request, $subject)
    {
        $autocrmSubject = ucwords(str_replace('-', ' ', $subject));
        $data = [ 'title'             => 'Consultation Auto Response ' . $autocrmSubject,
                  'menu_active'       => 'doctor',
                  'submenu_active'    => 'consultation-autoresponse-' . $subject,
                ];

        switch ($subject) {
            case 'user-received-chat':
                $data['click_inbox'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "consultation_chat",'title' => 'Consultation Chat']
                ];
                $data['click_notification'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "consultation_chat",'title' => 'Consultation Chat']
                ];
                break;
            case 'consultation-canceled':
            case 'reschedule-consultation':
                $data['click_inbox'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail']
                ];
                $data['click_notification'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail']
                ];
                break;
            case 'consultation-has-started':
                $data['click_inbox'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "consultation_chat",'title' => 'Consultation Chat'],
                    ['value' => "history_consultation",'title' => 'History Consultation']
                ];
                $data['click_notification'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "consultation_chat",'title' => 'Consultation Chat']
                ];
                break;
            case 'consultation-done':
                $data['click_inbox'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "consultation_chat",'title' => 'Consultation Chat'],
                    ['value' => "consultation_summary",'title' => 'Consultation Summary'],
                    ['value' => "history_consultation",'title' => 'History Consultation']
                ];
                $data['click_notification'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "consultation_chat",'title' => 'Consultation Chat'],
                    ['value' => "consultation_summary",'title' => 'Consultation Summary'],
                    ['value' => "history_consultation",'title' => 'History Consultation']
                ];
                break;
            case 'consultation-completed':
                $data['click_inbox'] = [
                    ['value' => "consultation_done",'title' => 'Consultation Done'],
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "consultation_chat",'title' => 'Consultation Chat'],
                    ['value' => "consultation_summary",'title' => 'Consultation Summary'],
                    ['value' => "consultation_product_recomendation",'title' => 'Consultation Product Recomendation'],
                    ['value' => "consultation_product_prescription",'title' => 'Consultation Prescription'],
                    ['value' => "history_consultation",'title' => 'History Consultation']
                ];
                $data['click_notification'] = [
                    ['value' => "consultation_done",'title' => 'Consultation Done'],
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "consultation_chat",'title' => 'Consultation Chat'],
                    ['value' => "consultation_summary",'title' => 'Consultation Summary'],
                    ['value' => "consultation_product_recomendation",'title' => 'Consultation Product Recomendation'],
                    ['value' => "consultation_product_prescription",'title' => 'Consultation Prescription'],
                    ['value' => "history_consultation",'title' => 'History Consultation']
                ];
                break;
            case 'consultation-missed':
                $data['click_inbox'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "history_consultation",'title' => 'History Consultation']
                ];
                $data['click_notification'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "history_consultation",'title' => 'History Consultation']
                ];
                break;
            case 'doctor-received-chat':
                $data['click_inbox'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "consultation_chat",'title' => 'Consultation Chat']
                ];
                $data['click_notification'] = [
                    ['value' => "consultation_detail",'title' => 'Consultation Detail'],
                    ['value' => "consultation_chat",'title' => 'Consultation Chat']
                ];
                break;
            default:
                $data['click_inbox'] = [
                    ['value' => 'consultation_chat','title' => 'Consultation Chat'],
                ];
                $data['click_notification'] = [
                    ['value' => 'consultation_chat','title' => 'Consultation Chat']
                ];
                break;
        }

        $autocrmSubject = ucwords(str_replace('-', ' ', $subject));

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

        if (stristr($request->url(), 'deals') || stristr($request->url(), 'voucher')) {
            $data['deals'] = true;
            $custom[] = '%outlet_name%';
            $custom[] = '%outlet_code%';
        }

        $data['custom'] = $custom;

        return view('users::response', $data);
    }

    public function exportData(Request $request)
    {
        $post = $request->except('_token');
        $consultation = MyHelper::post('be/consultation/detail/export', $post);
        if (isset($consultation['status']) && $consultation['status'] == "success") {
            $res = $consultation['result'];
            $data = new MultisheetExport($res);
            return Excel::download($data, 'Data_Consultation_' . date('Ymdhis') . '.xls');
        } else {
            return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
        }
    }
}
