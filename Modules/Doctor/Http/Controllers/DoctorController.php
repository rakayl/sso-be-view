<?php

namespace Modules\Doctor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Doctor',
            'sub_title'      => 'Doctor List',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-list',
            'filter_title'   => 'Filter Doctor',
        ];

        if (session('list_doctor_filter')) {
            $extra = session('list_doctor_filter');
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
            $data = MyHelper::post('doctor', $post + $extra)['result'] ?? [];
            $data['recordsFiltered'] = $data['total'] ?? 0;
            $data['recordsTotal'] = $data['total'] ?? 0;
            $data['draw'] = $request->draw;

            return $data;
        }

        return view('doctor::index', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function filter(Request $request)
    {
        $post = $request->all();

        if (($post['rule'] ?? false) && !isset($post['draw'])) {
            session(['list_doctor_filter' => $post]);
            return back();
        }

        if ($post['clear'] ?? false) {
            session(['list_doctor_filter' => null]);
            return back();
        }

        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Doctor',
            'sub_title'      => 'Doctor Create',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-create'
        ];

        $outlet = MyHelper::get('outlet/be/list', ['all_outlet' => 1]);

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        }

        $service = MyHelper::get('doctor/service');

        if (isset($service['status']) && $service['status'] == "success") {
            $data['service'] = $service['result'];
        } else {
            $data['service'] = [];
        }

        $specialist = MyHelper::get('doctor/specialist');

        if (isset($specialist['status']) && $specialist['status'] == "success") {
            $data['specialist'] = $specialist['result'];
        } else {
            $data['specialist'] = [];
        }

        $celebrate = MyHelper::get('setting/be/celebrate_list');

        if ($celebrate['status'] == 'success') {
            $data['celebrate'] = $celebrate['result'];
        } else {
            $data['celebrate'] = null;
        }

        $data['id_outlet'] = $post['id_outlet'] ?? null;

        return view('doctor::form', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();

        if (isset($post['doctor_photo']) && !empty($post['doctor_photo'])) {
            $post['doctor_photo'] = MyHelper::encodeImage($post['doctor_photo']);
        }

        if (isset($post['doctor_service']) && !empty($post['doctor_service'])) {
            $post['doctor_service'] = '["' . implode('","', $post['doctor_service']) . '"]';
        } else {
            $post['doctor_service'] = null;
        }

        if (isset($post['practice_experience_place']) && !empty($post['practice_experience_place'])) {
            $post['practice_experience_place'] = '["' . implode('","', $post['practice_experience_place']) . '"]';
        } else {
            $post['practice_experience_place'] = null;
        }

        $store = MyHelper::post('doctor/store', $post);

        if (($store['status'] ?? '') == 'success') {
            return redirect('doctor')->with('success', ['Create Doctor Success']);
        } else {
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('doctor::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'title'          => 'Doctor',
            'sub_title'      => 'Doctor List',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-list',
        ];

        $doctor = MyHelper::get('doctor/detail/' . $id);

        $explode = json_decode($doctor['result']['doctor_service']);
        $doctor['result']['doctor_service'] = $explode;

        $explode2 = json_decode($doctor['result']['practice_experience_place']);
        $doctor['result']['practice_experience_place'] = $explode2;

        if (isset($doctor['status']) && $doctor['status'] == "success") {
            $data['doctor'] = $doctor['result'];
        } else {
            $data['doctor'] = [];
        }

        $outlet = MyHelper::get('outlet/be/list', ['all_outlet' => 1]);

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        }

        $service = MyHelper::get('doctor/service');

        if (isset($service['status']) && $service['status'] == "success") {
            $data['service'] = $service['result'];
        }

        $specialist = MyHelper::get('doctor/specialist');

        if (isset($specialist['status']) && $specialist['status'] == "success") {
            $data['specialist'] = $specialist['result'];
        }

        $data['selected_id_specialist'] = array();
        foreach ($data['doctor']['specialists'] as $row) {
            $data['selected_id_specialist'][] = $row['id_doctor_specialist'];
        }

        $celebrate = MyHelper::get('setting/be/celebrate_list');

        if ($celebrate['status'] == 'success') {
            $data['celebrate'] = $celebrate['result'];
        } else {
            $data['celebrate'] = null;
        }

        $schedules = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
        $scheduleRaw = [];
        foreach ($schedules as $s) {
            $arrayColumn = array_column($data['doctor']['schedules_raw'] ?? [], 'day');
            $search = array_search(strtolower($s), array_map('strtolower', $arrayColumn));
            if ($search !== false) {
                $scheduleRaw[] = [
                    "id_doctor_schedule" => $data['doctor']['schedules_raw'][$search]['id_doctor_schedule'],
                    "id_doctor" => $id,
                    "day" => $s,
                    "is_active" => $data['doctor']['schedules_raw'][$search]['is_active'],
                    "schedule_time" => $data['doctor']['schedules_raw'][$search]['schedule_time']
                ];
            } else {
                $scheduleRaw[] = [
                    "id_doctor_schedule" => null,
                    "id_doctor" => $id,
                    "day" => $s,
                    "is_active" => 0,
                    "schedule_time" => []
                ];
            }
        }

        $data['doctor']['schedules_raw'] = $scheduleRaw;

        return view('doctor::form', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $post = $request->except('_method');

        if (isset($post['doctor_photo']) && !empty($post['doctor_photo'])) {
            $post['doctor_photo'] = MyHelper::encodeImage($post['doctor_photo']);
        } else {
            unset($post['doctor_photo']);
        }

        //if(isset($post['doctor_service']) && !empty($post['doctor_service'])){$post['doctor_service'] = implode(',' , $post['doctor_service']);} else {$post['doctor_service'] = null;}

        if (isset($post['doctor_service']) && !empty($post['doctor_service'])) {
            $post['doctor_service'] = json_encode($post['doctor_service']);
        } else {
            $post['doctor_service'] = null;
        }

        //if(isset($post['practice_experience_place']) && !empty($post['practice_experience_place'])){$post['practice_experience_place'] = implode(',' , $post['practice_experience_place']);} else {$post['practice_experience_place'] = null;}

        if (isset($post['practice_experience_place']) && !empty($post['practice_experience_place'])) {
            $post['practice_experience_place'] = json_encode($post['practice_experience_place']);
        } else {
            $post['practice_experience_place'] = null;
        }

        $store = MyHelper::post('doctor/store', $post);

        if (($store['status'] ?? '') == 'success') {
            return redirect('doctor')->with('success', ['Update Doctor Success']);
        } else {
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updatePassword(Request $request, $id)
    {
        $post = $post = $request->except('_method');

        $store = MyHelper::post('doctor/change-password', $post);

        if (($store['status'] ?? '') == 'success') {
            return back()->with('success', ['Update Doctor Success']);
        } else {
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateSchedule(Request $request, $id)
    {
        $post = $request->except('_method');

        $post['id_doctor'] = $id;

        foreach ($post['schedules'] as $key => $val) {
            if (isset($val['is_active']) && $val['is_active'] == 'on') {
                $post['schedules'][$key]['is_active'] = 1;
            } else {
                $post['schedules'][$key]['is_active'] = 0;
            }

            if (isset($val['session_time'])) {
                usort($val['session_time'], function ($a, $b) {
                    return strtotime($a['start_time']) <=> strtotime($b['start_time']);
                });

                $post['schedules'][$key]['session_time'] = $val['session_time'];
            }

            if (isset($val['session_time'])) {
                $endTime = null;
                foreach ($post['schedules'][$key]['session_time'] as $time) {
                    $time['start_time'] = (!empty($time['start_time']) ? date('H:i', strtotime($time['start_time'])) : null);
                    $endTime = (!empty($endTime) ? date('H:i', strtotime($endTime)) : null);

                    if (strtotime($time['start_time']) > strtotime($time['end_time'])) {
                        return back()->withInput()->withErrors(['End time should be greater more than start time']);
                    }

                    if ($time['start_time'] < $endTime) {
                        return back()->withInput()->withErrors(['Session time can not be the same in one day']);
                    }
                    $endTime = $time['end_time'];
                }
            }
        }

        $store = MyHelper::post('doctor/schedule/store', $post);

        if (($store['status'] ?? '') == 'success') {
            //return redirect('product/detail/'.$product_code.'#variant-group')->with('success',['Update Product Variant Group Success']);
            return redirect('doctor/' . $id . '/edit#schedule')->with('success', ['Update Doctor Schedule Success']);
        } else {
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $post = $request->except('_token');
        $result = MyHelper::post('doctor/delete', ['id_doctor' => $post['id_doctor']]);
        return $result;
    }

    public function autoResponse(Request $request, $subject)
    {
        $autocrmSubject = ucwords(str_replace('-', ' ', $subject));
        $data = [ 'title'             => 'Doctor Auto Response ' . $autocrmSubject,
                  'menu_active'       => 'doctor',
                  'submenu_active'    => 'doctor-autoresponse-' . $subject,
                ];

        if ($subject == 'pin-sent') {
            $subject = 'doctor-pin-sent';
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
            case 'receive-inject-voucher':
                $data['menu_active'] = 'doctor-update-data';
                break;
            default:
                $data['click_inbox'] = [
                    ['value' => "Doctor Pin Sent",'title' => 'Doctor Pin Sent']
                ];
                $data['click_notification'] = [
                    ['value' => 'Doctor Pin Sent','title' => 'Doctor Pin Sent']
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

    public function doctorRecommendation(Request $request)
    {
        $post = $request->except('_token');

        $data = [
            'title'          => 'Doctor',
            'sub_title'      => 'Doctor Recommendation',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-recommendation',
        ];

        if (empty($post)) {
            $data['doctors'] = MyHelper::post('doctor', $post)['result'] ?? [];
            return view('doctor::doctor_recommendation', $data);
        } else {
            $save = MyHelper::post('doctor/recomendation/store', $post);
            if (isset($save['status']) && $save['status'] == 'success') {
                return redirect('doctor/recommendation')->with($save, $save['result']);
            } else {
                return back()->witherrors($save['messages'] ?? ['Something went wrong']);
            }
        }
    }
}
