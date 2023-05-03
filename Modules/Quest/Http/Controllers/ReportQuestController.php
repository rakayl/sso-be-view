<?php

namespace Modules\Quest\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\MultisheetExport;
use Session;
use Excel;

class ReportQuestController extends Controller
{
    public function reportQuest(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Quest',
            'sub_title'      => 'Report Quest',
            'menu_active'    => 'quest',
            'submenu_active' => 'quest-report'
        ];

        if (Session::has('filter-report-quest') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-report-quest');
            $post['page'] = $page;
        } else {
            Session::forget('filter-report-quest');
        }

        $getData = MyHelper::post('quest/report', $post);

        if (isset($getData['status']) && $getData['status'] == "success") {
            $data['data']          = $getData['result']['data'];
            $data['dataTotal']     = $getData['result']['total'];
            $data['dataPerPage']   = $getData['result']['from'];
            $data['dataUpTo']      = $getData['result']['from'] + count($getData['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($getData['result']['data'], $getData['result']['total'], $getData['result']['per_page'], $getData['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if ($post) {
            Session::put('filter-report-quest', $post);
        }
        return view('quest::report.list', $data);
    }

    public function reportDetail(Request $request, $id_quest)
    {
        $post = $request->all();
        $post['id_quest'] = $id_quest;

        $data = [
            'title'          => 'Quest',
            'sub_title'      => 'Report Detail Quest',
            'menu_active'    => 'quest',
            'submenu_active' => 'quest-report'
        ];

        $detail = MyHelper::post('quest/report/detail', $post);

        if (($detail['status'] ?? false) == 'success') {
            $data['detail'] = $detail['result'];
        } else {
            return redirect('quest/report')->withErrors($detail['messages'] ?? ['Detail report not found']);
        }

        return view('quest::report.detail', $data);
    }

    public function reportListUser(Request $request, $id_quest)
    {
        $post = $request->all();
        $post['id_quest'] = $id_quest;
        $draw = $post['draw'] ?? 10;

        $page = 1;
        if (isset($post['start']) && isset($post['length'])) {
            $page = $post['start'] / $post['length'] + 1;
        }
        $list_user = MyHelper::post('quest/report/list/user-quest?page=' . $page, $post);

        if ($request->export) {
            if (($list_user['status'] ?? false) == 'success') {
                $res = [];
                foreach ($list_user['result'] as $val) {
                    $res[] = [
                        'Name' => $val[0],
                        'Phone' => $val[1],
                        'Email' => $val[2],
                        'Date Claim' => $val[3],
                        'Date Complete' => $val[4],
                        'Date Claim Benefit' => $val[5],
                        'Status' => $val[6],
                        'Claim Benefit Status' => $val[7],
                        'Total Rule Complete' => $val[8]
                    ];
                }

                $datas['Report ' . $id_quest] = $res;
                return Excel::download(new MultisheetExport($datas), date('YmdHi') . '_report ' . $id_quest . '.xlsx');
            } else {
                return redirect('report/quest/detail/' . $id_quest)->withErrors($result['messages'] ?? ['Failed get data']);
            }
        }

        if (isset($list_user['status']) && $list_user['status'] == 'success') {
            foreach ($list_user['result']['data'] ?? [] as $key => $val) {
                switch ($list_user['result']['data'][$key][6]) {
                    case 'complete':
                        $status_style = 'background-color: #26C281;color: #fff;';
                        break;

                    case 'expired':
                        $status_style = 'background-color: #E7505A;color: #fff;';
                        break;

                    default:
                        $status_style = 'background-color: #f4d03f;color: #333;';
                        break;
                }

                $list_user['result']['data'][$key][6] = '<span class="sale-num sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;padding: 5px 12px;' . $status_style . '">' . $list_user['result']['data'][$key][6] . '</span>';

                if ($list_user['result']['data'][$key][7] == 'claimed') {
                    $status_claim_style = 'background-color: #26C281;';
                } else {
                    $status_claim_style = 'background-color: #E7505A;';
                }

                $list_user['result']['data'][$key][7] = '<span class="sale-num sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;' . $status_claim_style . 'padding: 5px 12px;color: #fff;">' . $list_user['result']['data'][$key][7] . '</span>';
            }

            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $list_user['result']['total'];
            $arr_result['recordsFiltered'] = $list_user['result']['total'];
            $arr_result['data'] = $list_user['result']['data'];
        } else {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }

        return response()->json($arr_result);
    }
}
