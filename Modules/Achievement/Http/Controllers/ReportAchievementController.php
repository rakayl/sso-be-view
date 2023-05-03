<?php

namespace Modules\Achievement\Http\Controllers;

use App\Lib\MyHelper;
use Cassandra\RetryPolicy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;

class ReportAchievementController extends Controller
{
    public function reportAchievement(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Report Achievement',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-report'
        ];

        if (Session::has('filter-report-achievement') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-report-achievement');
            $post['page'] = $page;
        } else {
            Session::forget('filter-report-achievement');
        }

        $getData = MyHelper::post('achievement/report', $post);

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
            Session::put('filter-report-achievement', $post);
        }
        return view('achievement::report.achievement.achievement', $data);
    }

    public function reportDetailAchievement(Request $request, $id)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Report Detail Achievement',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-report'
        ];

        $data['id_achievement_group'] = $id;
        if (!empty($post)) {
            $post['id_achievement_group'] = $id;
            $getData = MyHelper::post('achievement/report/detail', $post);

            $result['id_achievement_group'] = $id;
            $result['data_achievement'] = [];
            $result['data_badge'] = [];

            if (isset($getData['status']) && $getData['status'] == "success") {
                $result['data_achievement'] = $getData['result']['data_achievement'];
                $result['data_badge'] = $getData['result']['data_badge'];
            }

            return response()->json($result);
        } else {
            $data['data_achievement'] = [];
            $data['data_badge'] = [];
            return view('achievement::report.achievement.detail', $data);
        }
    }

    public function reportListUserAchievement(Request $request, $id)
    {
        $post = $request->all();
        $post['id_achievement_group'] = $id;
        $draw = $post['draw'];

        $page = 1;
        if (isset($post['start']) && isset($post['length'])) {
            $page = $post['start'] / $post['length'] + 1;
        }
        $getDataListUser = MyHelper::post('achievement/report/list/user-achievement?page=' . $page, $post);

        if (isset($getDataListUser['status']) && $getDataListUser['status'] == 'success') {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $getDataListUser['result']['total'];
            $arr_result['recordsFiltered'] = $getDataListUser['result']['total'];
            $arr_result['data'] = $getDataListUser['result']['data'];
        } else {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }

        return response()->json($arr_result);
    }

    public function reportUser(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Report Achievement User',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-report-user'
        ];

        if (Session::has('filter-report-achievement-user') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-report-achievement-user');
            $post['page'] = $page;
        } else {
            Session::forget('filter-report-achievement-user');
        }

        $getData = MyHelper::post('achievement/report/user-achievement', $post);

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
            Session::put('filter-report-achievement-user', $post);
        }
        return view('achievement::report.user.user', $data);
    }

    public function reportDetailUser(Request $request, $phone)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Report Detail Achievement User',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-report-user'
        ];

        $post['phone'] = $phone;
        $getData = MyHelper::post('achievement/report/user-achievement/detail', $post);

        if (isset($getData['status']) && $getData['status'] == "success") {
            $data['user'] = $getData['result']['data_user'];

            if (!empty($getData['result']['list_achievement'])) {
                $listachievement = $getData['result']['list_achievement'];
                $data['data']          = $listachievement['data'];
                $data['dataTotal']     = $listachievement['total'];
                $data['dataPerPage']   = $listachievement['from'];
                $data['dataUpTo']      = $listachievement['from'] + count($listachievement['data']) - 1;
                $data['dataPaginator'] = new LengthAwarePaginator($listachievement['data'], $listachievement['total'], $listachievement['per_page'], $listachievement['current_page'], ['path' => url()->current()]);
            } else {
                $data['data']          = [];
                $data['dataTotal']     = 0;
                $data['dataPerPage']   = 0;
                $data['dataUpTo']      = 0;
                $data['dataPaginator'] = false;
            }
        } else {
            $data['user'] = [];
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        $data['phone'] = $phone;

        return view('achievement::report.user.detail', $data);
    }

    public function reportDetailBadgeUser(Request $request, $id_achievement_group, $phone)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Report Detail Badged User',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-report-user'
        ];

        $post['phone'] = $phone;
        $post['id_achievement_group'] = $id_achievement_group;
        $getData = MyHelper::post('achievement/report/user-achievement/detail-badge', $post);

        $data['data'] = [];
        if (isset($getData['status']) && $getData['status'] == "success") {
            $data['data'] = $getData['result'];
        }
        return view('achievement::report.user.detail_badge', $data);
    }

    public function reportMembership(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Report Achievement User',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-report-user'
        ];

        if (Session::has('filter-report-achievement-membership') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-report-achievement-membership');
            $post['page'] = $page;
        } else {
            Session::forget('filter-report-achievement-membership');
        }

        $getData = MyHelper::post('achievement/report/membership', $post);

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
            Session::put('filter-report-achievement-membership', $post);
        }
        return view('achievement::report.membership.membership', $data);
    }

    public function reportDetailMembershipView(Request $request, $id)
    {
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Report Detail Membeship Achievement',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-report-membership'
        ];

        $data['id_membership'] = $id;
        return view('achievement::report.membership.detail', $data);
    }

    public function reportDetailMembership(Request $request, $id)
    {
        $post = $request->all();

        $post['id_membership'] = $id;
        $getData = MyHelper::post('achievement/report/membership/detail', $post);
        return response()->json($getData);
    }

    public function reportListUserMembership(Request $request, $id)
    {
        $post = $request->all();
        $post['id_membership'] = $id;
        $draw = $post['draw'];

        $page = 1;
        if (isset($post['start']) && isset($post['length'])) {
            $page = $post['start'] / $post['length'] + 1;
        }
        $getDataListUser = MyHelper::post('achievement/report/membership/list-user?page=' . $page, $post);

        if (isset($getDataListUser['status']) && $getDataListUser['status'] == 'success') {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = $getDataListUser['result']['total'];
            $arr_result['recordsFiltered'] = $getDataListUser['result']['total'];
            $arr_result['data'] = $getDataListUser['result']['data'];
        } else {
            $arr_result['draw'] = $draw;
            $arr_result['recordsTotal'] = 0;
            $arr_result['recordsFiltered'] = 0;
            $arr_result['data'] = array();
        }

        return response()->json($arr_result);
    }
}
