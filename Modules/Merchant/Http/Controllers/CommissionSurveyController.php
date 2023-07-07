<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class CommissionSurveyController extends Controller
{
    public function createCommission()
    {
        $data = [
            'title'          => 'Commission Survey',
            'sub_title'      => 'New Commission Survey',
            'menu_active'    => 'commission-survey',
            'submenu_active' => 'commission-survey-new'
        ];
       $data['city'] = MyHelper::get('merchant/city/survey')['result'] ?? [];
        return view('merchant::survey.create', $data);
    }

    public function storeCommission(Request $request)
    {
        $post = $request->all();
        $post['commission_price'] = (int)str_replace(".","",$post['commission_price']);
        $create = MyHelper::post('merchant/survey/store', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return redirect('kontraktor/commission')->withSuccess(['Success save data']);
        } else {
            return redirect('kontraktor/commission/create')->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }

    public function listCommission(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Kontraktor',
            'sub_title'      => 'Kontraktor List',
            'menu_active'    => 'commission-survey',
            'submenu_active' => 'commission-survey-list',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
            'type' => ''
        ];
        

        if ($post) {
            Session::put('filter-commission', $post);
        }
        if (Session::has('filter-commission') && $post && isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-commission');
            $post['page'] = $page;
            $data['conditions'] = $post['conditions'];
            $data['rule'] = $post['rule'];
        } else {
            Session::forget('filter-survey');
        }

        $getList = MyHelper::post('merchant/survey/list', $post);

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
        return view('merchant::survey.list', $data);
    }

    public function detailCommission($id)
    {
        $data = [
            'title'          => 'Kontraktor',
            'sub_title'      => 'Kontraktor Detail',
            'menu_active'    => 'commission-survey',
            'submenu_active' => 'commission-survey-list',
        ];
        $detail = MyHelper::post('merchant/survey/detail', ['id_commission_survey' => $id]);

        if (isset($detail['status']) && $detail['status'] == "success") {
            $data['detail'] = $detail['result'];
            return view('merchant::survey.detail', $data);
        } else {
            return redirect('kontraktor/commission')->withErrors($save['messages'] ?? ['Failed get data']);
        }
    }

    public function updateCommission(Request $request, $id)
    {
        $post = $request->except('_token');
        
        $post['id_commission_survey'] = $id;
        $post['commission_price'] = (int)str_replace(".","",$post['commission_price']);
        $update = MyHelper::post('merchant/survey/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('kontraktor/commission/detail/' . $id)->withSuccess(['Success save data']);
        } else {
            return redirect('kontraktor/commission/detail/' . $id)->withErrors($update['messages'] ?? ['Failed get data']);
        }
    }
}
