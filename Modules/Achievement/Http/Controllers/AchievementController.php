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

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Achievement List',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-list'
        ];

        $data['category']   = MyHelper::get('achievement/category')['data'];
        $data['product']    = MyHelper::get('product/be/list')['result'];
        $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
        $data['province']   = MyHelper::get('province/list')['result'];

        return view('achievement::index', $data);
    }

    public function report(Request $request, $slug)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Achievement List',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-list'
        ];

        // dd(MyHelper::get('achievement/category'));
        $data['category']   = MyHelper::get('achievement/category')['data'];
        $data['product']    = MyHelper::get('product/be/list')['result'];
        $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
        $data['province']   = MyHelper::get('province/list')['result'];

        switch ($slug) {
            case 'list-achievement':
                if (!empty($post)) {
                    $post = $request->except('_token');
                    $raw_data = MyHelper::post('achievement/report/' . $slug, $post)['result'] ?? [];
                    $data['data'] = $raw_data['data'];
                    $data['total'] = $raw_data['total'] ?? 0;
                    $data['from'] = $raw_data['from'] ?? 0;
                    $data['order_by'] = $raw_data['order_by'] ?? 0;
                    $data['order_sorting'] = $raw_data['order_sorting'] ?? 0;
                    $data['last_page'] = !($raw_data['next_page_url'] ?? false);
                    return $data;
                }
                return view('achievement::report.index', $data);
                break;
            case 'membership-achievement':
                if (!empty($post)) {
                    $post = $request->except('_token');
                    $raw_data = MyHelper::post('achievement/report/' . $slug, $post)['result'] ?? [];
                    $data['data'] = $raw_data['data'];
                    $data['total'] = $raw_data['total'] ?? 0;
                    $data['from'] = $raw_data['from'] ?? 0;
                    $data['order_by'] = $raw_data['order_by'] ?? 0;
                    $data['order_sorting'] = $raw_data['order_sorting'] ?? 0;
                    $data['last_page'] = !($raw_data['next_page_url'] ?? false);
                    return $data;
                }
                return view('achievement::report.membership', $data);
                break;
        }
    }

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
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function indexAjax(Request $request)
    {
        $post = $request->except('_token');
        $raw_data = MyHelper::post('achievement', $post)['result'] ?? [];
        $data['data'] = $raw_data['data'];
        $data['total'] = $raw_data['total'] ?? 0;
        $data['from'] = $raw_data['from'] ?? 0;
        $data['order_by'] = $raw_data['order_by'] ?? 0;
        $data['order_sorting'] = $raw_data['order_sorting'] ?? 0;
        $data['last_page'] = !($raw_data['next_page_url'] ?? false);
        return $data;
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $post = $request->except('_token');
        if (!empty($post)) {
            if (isset($post['id_achievement_group'])) {
                foreach ($post['detail'] as $key => $value) {
                    $post['detail'][$key]['logo_badge'] = MyHelper::encodeImage($value['logo_badge']);
                }

                $save = MyHelper::post('achievement/create', $post);

                if (isset($save['status']) && $save['status'] == "success") {
                    return redirect('achievement/detail/' . $save['data']);
                } else {
                    return back()->with('error', $save['errors'])->withInput();
                }
            } else {
                $post['group']['logo_badge_default'] = MyHelper::encodeImage($post['group']['logo_badge_default']);
                $post['group']['order_by']  = $post['rule_total'];

                if (isset($post['detail'])) {
                    foreach ($post['detail'] as $key => $value) {
                        $post['detail'][$key]['logo_badge'] = MyHelper::encodeImage($value['logo_badge']);
                    }
                }

                $save = MyHelper::post('achievement/create', $post);
                // return $save;
                if (isset($save['status']) && $save['status'] == "success") {
                    return redirect('achievement/detail/' . $save['data']);
                } else {
                    return back()->with('error', $save['errors'])->withInput();
                }
            }
        } else {
            $data = [
                'title'          => 'Achievement',
                'sub_title'      => 'Achievement Create',
                'menu_active'    => 'achievement',
                'submenu_active' => 'achievement-create'
            ];

            $data['category']   = MyHelper::get('achievement/category')['data'];
            $data['product']    = MyHelper::get('product/be/list')['result'];
            $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
            $data['province']   = MyHelper::get('province/list')['result'];

            return view('achievement::create', $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function detailAjax(Request $request)
    {
        $post = $request->except('_token');
        $data = MyHelper::post('achievement/detailAjax', $post)['data'];
        $data['is_start'] = ($data['date_start'] ?? false) < date('Y-m-d H:i:s');
        $data['date_start'] = $data['date_start'] ?? false ? date('d-M-Y H:i', strtotime($data['date_start'])) : '';
        $data['date_end'] = $data['date_end'] ?? false ? date('d-M-Y H:i', strtotime($data['date_end'])) : '';
        $data['publish_start'] = $data['publish_start'] ?? false ? date('d-M-Y H:i', strtotime($data['publish_start'])) : '';
        $data['publish_end'] = $data['publish_end'] ?? false ? date('d-M-Y H:i', strtotime($data['publish_end'])) : '';
        $data['logo_badge_default'] = env('STORAGE_URL_API') . $data['logo_badge_default'];
        return $data;
    }

    public function getOutlet($id_province)
    {
        $data = MyHelper::post('achievement/getOutlet?log_save=0', ['id_province' => $id_province])['data'];
        return $data;
    }

    public function updateAchievement(Request $request)
    {
        $post = $request->except('_token');

        if (isset($post['group']['logo_badge_default'])) {
            $post['group']['logo_badge_default'] = MyHelper::encodeImage($post['group']['logo_badge_default']);
        }

        if (isset($post['group']['date_start'])) {
            $post['group']['date_start'] = date('Y-m-d H:i:s', strtotime($post['group']['date_start']));
            if ($post['group']['date_start'] < date('Y-m-d H:i:s')) {
                return back()->withErrors(['The start date must be after the current datetime']);
            }
        }


        if (isset($post['group']['date_end'])) {
            $post['group']['date_end'] = date('Y-m-d H:i:s', strtotime($post['group']['date_end']));
            if ($post['group']['date_end'] < date('Y-m-d H:i:s')) {
                return back()->withErrors(['The end date must be after the current datetime']);
            }
        }

        if (isset($post['group']['publish_start'])) {
            $post['group']['publish_start'] = date('Y-m-d H:i:s', strtotime($post['group']['publish_start']));
        }

        if (isset($post['group']['publish_end'])) {
            $post['group']['publish_end'] = date('Y-m-d H:i:s', strtotime($post['group']['publish_end']));
        }
        $save = MyHelper::post('achievement/update', $post);

        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('achievement');
        } else {
            return back()->with('error', $save['errors'])->withInput();
        }
        return $request;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'title'          => 'Achievement',
            'sub_title'      => 'Achievement Detail',
            'menu_active'    => 'achievement',
            'submenu_active' => 'achievement-list'
        ];

        $getDetail = MyHelper::post('achievement/detail', ['id_achievement_group' => $id]);

        if (isset($getDetail['status']) && $getDetail['status'] == "success") {
            $data['data'] = $getDetail['data'];

            $data['category']   = MyHelper::get('achievement/category')['data'];
            $data['product']    = MyHelper::get('product/be/list')['result'];
            $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
            $data['province']   = MyHelper::get('province/list')['result'];

            return view('achievement::detail', $data);
        } else {
            $data = [
                'title'          => 'Achievement',
                'sub_title'      => 'Achievement Create',
                'menu_active'    => 'achievement',
                'submenu_active' => 'achievement-create'
            ];

            $data['category']   = MyHelper::get('achievement/category')['data'];
            $data['product']    = MyHelper::get('product/be/list')['result'];
            $data['outlet']     = MyHelper::get('outlet/be/list')['result'];
            $data['province']   = MyHelper::get('province/list')['result'];

            return view('achievement::create', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('achievement::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $post = $request->except('_token');

        $update = MyHelper::post('achievement/detail/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return back();
        } else {
            return back()->with('error', $update['errors'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function remove(Request $request)
    {
        $post = $request->except('_token');

        $remove = MyHelper::post('achievement/destroy', $post);

        return $remove;
    }
}
