<?php

namespace Modules\Doctor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class DoctorUpdateDataController extends Controller
{
    public function list(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'             => 'Doctor',
            'sub_title'         => 'Request Update Data',
            'menu_active'       => 'doctor-update-data',
            'submenu_active'    => 'doctor-update-data-list',
            'title_date_start'  => 'Request Start',
            'title_date_end'    => 'Request End'
        ];

        if (Session::has('filter-doctor-update-data') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-doctor-update-data');
            $post['page'] = $page;
        } else {
            Session::forget('filter-doctor-update-data');
        }

        $getList = MyHelper::post('doctor/update-data/list', $post);

        if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['data'];
            $data['dataTotal']     = $getList['result']['total'];
            $data['dataPerPage']   = $getList['result']['from'];
            $data['dataUpTo']      = $getList['result']['from'] + count($getList['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($getList['result']['data'], $getList['result']['total'], $getList['result']['per_page'], $getList['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if ($post) {
            Session::put('filter-doctor-update-data', $post);
        }

        $month = [];
        for ($m = 1; $m <= 12; $m++) {
            $month[] = [
                'index' => $m,
                'name' => date('F', mktime(0, 0, 0, $m, 1, date('Y')))
            ];
        }

        return view('doctor::update_data.list', $data);
    }

    public function detail(Request $request, $id)
    {
        $detail = MyHelper::post('doctor/update-data/detail', ['id_doctor_update_data' => $id]);
        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data = [
                'title'          => 'Doctor',
                'sub_title'      => 'Request Update Data',
                'menu_active'    => 'doctor-update-data',
                'submenu_active' => 'doctor-update-data-list',
                'url_back'       => 'doctor/update-data'
            ];

            $data['data'] = $detail['result'];

            return view('doctor::update_data.detail', $data);
        } else {
            return redirect('doctor/update-data')->withErrors($store['messages'] ?? ['Failed get detail request update data']);
        }
    }

    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        $post['id_doctor_update_data'] = $id;

        $update = MyHelper::post('doctor/update-data/update', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('doctor/update-data/detail/' . $id)->withSuccess(['Success update data request']);
        } else {
            return redirect('doctor/update-data/detail/' . $id)->withErrors($update['messages'] ?? ['Failed update data to approved']);
        }
    }
}
