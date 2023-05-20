<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class CommissionController extends Controller
{
    public function createCommission()
    {
        $data = [
            'title'          => 'Commission Sedot WC',
            'sub_title'      => 'New Commission Sedot WC',
            'menu_active'    => 'commission-sedot-wc',
            'submenu_active' => 'commission-sedot-wc-new'
        ];
       $data['city'] = MyHelper::get('merchant/city/list-not-register')['result'] ?? [];
        return view('merchant::commission.create', $data);
    }

    public function storeCommission(Request $request)
    {
        $post = $request->all();
        $post['commission_price'] = (int)str_replace(".","",$post['commission_price']);
        $create = MyHelper::post('merchant/commission/store', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return redirect('tukang-sedot/commission')->withSuccess(['Success save data']);
        } else {
            return redirect('tukang-sedot/commission/create')->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }

    public function listCommission(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Tukang Sedot',
            'sub_title'      => 'Tukang Sedot List',
            'menu_active'    => 'commission-sedot-wc',
            'submenu_active' => 'commission-sedot-wc-list',
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
            Session::forget('filter-commission');
        }

        $getList = MyHelper::post('merchant/commission/list', $post);

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
        return view('merchant::commission.list', $data);
    }

    public function detailCommission($id)
    {
        $data = [
            'title'          => 'Tukang Sedot',
            'sub_title'      => 'Tukang Sedot Detail',
            'menu_active'    => 'commission-sedot-wc',
            'submenu_active' => 'commission-sedot-wc-list',
        ];
        $detail = MyHelper::post('merchant/commission/detail', ['id_commission_sedot_wc' => $id]);

        if (isset($detail['status']) && $detail['status'] == "success") {
            $data['detail'] = $detail['result'];
            return view('merchant::commission.detail', $data);
        } else {
            return redirect('tukang-sedot/commission')->withErrors($save['messages'] ?? ['Failed get data']);
        }
    }

    public function updateCommission(Request $request, $id)
    {
        $post = $request->except('_token');
        
        $post['id_commission_sedot_wc'] = $id;
        $post['commission_price'] = (int)str_replace(".","",$post['commission_price']);
        $update = MyHelper::post('merchant/commission/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('tukang-sedot/commission/detail/' . $id)->withSuccess(['Success save data']);
        } else {
            return redirect('tukang-sedot/commission/detail/' . $id)->withErrors($update['messages'] ?? ['Failed get data']);
        }
    }
}
