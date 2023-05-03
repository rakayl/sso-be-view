<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class SingleReportController extends Controller
{
    /**
     * Display a single report page
     *
     */
    public function index()
    {
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-single',
            'sub_title'      => 'Report',
            'submenu_active' => 'report-single'
        ];

        // get report year
        $data['year_list'] = [date('Y')];
        $year_list = MyHelper::get('report/single/year-list');
        if (isset($year_list['status']) && $year_list['status'] == 'success') {
            $data['year_list'] = $year_list['result'];
        }
        // get outlet list
        $data['outlets'] = [];
        $outlets = MyHelper::get('report/single/outlet-list');
        if (isset($outlets['status']) && $outlets['status'] == 'success') {
            $data['outlets'] = $outlets['result'];
        }
        // get product list
        $data['products'] = [];
        $products = MyHelper::get('report/single/product-list');
        if (isset($products['status']) && $products['status'] == 'success') {
            $data['products'] = $products['result'];
        }
        // get membership list
        $data['memberships'] = [];
        $memberships = MyHelper::get('report/single/membership-list');
        if (isset($memberships['status']) && $memberships['status'] == 'success') {
            $data['memberships'] = $memberships['result'];
        }
        // get deals list
        $data['deals'] = [];
        $deals = MyHelper::get('report/single/deals-list');
        if (isset($deals['status']) && $deals['status'] == 'success') {
            $data['deals'] = $deals['result'];
        }

        $post = session('report_filter');
        if ($post == null) {
            // set default filter
            $today = date('Y-m-d');
            $one_week_ago = date("Y-m-d", strtotime("-1 week"));

            $post['time_type_select'] = 'day';  // for select in view
            $post['time_type'] = 'day';  // for api
            $post['param1'] = $one_week_ago;
            $post['param2'] = $today;

            $post['param1_str'] = date('d/m/Y', strtotime($post['param1']));
            $post['param2_str'] = date('d/m/Y', strtotime($post['param2']));

            if (!empty($data['products'])) {
                $post['id_product'] = $data['products'][0]['id_product'];
                $post['product_name'] = $data['products'][0]['product_name'];
            }
            if (!empty($data['memberships'])) {
                $post['id_membership'] = $data['memberships'][0]['id_membership'];
                $post['membership_name'] = $data['memberships'][0]['membership_name'];
            }
            if (!empty($data['deals'])) {
                $post['id_deals'] = $data['deals'][0]['id_deals'];
                $post['deals_title'] = $data['deals'][0]['deals_title'];
            }
            $post['trx_id_outlet'] = 0;
            $post['product_id_outlet'] = 0;
            $post['voucher_id_outlet'] = 0;

            // store filter in session
            session(['report_filter' => $post]);
        }
        $data['filter'] = $post;

        // get report
        $data['report'] = [];
        $report = MyHelper::post('report/single', $post);
        if (isset($report['status']) && $report['status'] == 'success') {
            $data['report'] = $report['result'];
        }

        return view('report::single_report.single_report', $data);
    }

    // check ajax request
    private function checkFilter($post)
    {
        $success = true;
        $post['time_type_select'] = $post['time_type'];
        if ($post['time_type'] == 'week') {
            $post['time_type'] = 'day';
        } elseif ($post['time_type'] == 'quarter') {
            $post['time_type'] = 'month';
        }

        switch ($post['time_type']) {
            case 'day':
                if ($post['param1'] == "" || $post['param2'] == "") {
                    $success = false;
                } else {
                    // date format in datepicker
                    $post['param1_str'] = $post['param1'];
                    $post['param2_str'] = $post['param2'];

                    $post['param1'] = str_replace('/', '-', $post['param1']);
                    $post['param2'] = str_replace('/', '-', $post['param2']);

                    $post['param1'] = date('Y-m-d', strtotime($post['param1']));
                    $post['param2'] = date('Y-m-d', strtotime($post['param2']));

                    $date_range = date(
                        'd M Y',
                        strtotime($post['param1'])
                    ) . " - " . date('d M Y', strtotime($post['param2']));
                }
                break;
            case 'month':
                if ($post['param1'] == "" || $post['param2'] == "" || $post['param3'] == "") {
                    $success = false;
                } else {
                    $month_name_1 = date('F', mktime(0, 0, 0, $post['param1'], 10));
                    $month_name_2 = date('F', mktime(0, 0, 0, $post['param2'], 10));
                    $date_range = $month_name_1 . " - " . $month_name_2 . " " . $post['param3'];
                }
                break;
            case 'year':
                if ($post['param1'] == "" || $post['param2'] == "") {
                    $success = false;
                } else {
                    $date_range = $post['param1'] . " - " . $post['param2'];
                }
                break;

            default:
                $success = false;
                break;
        }

        return [
            'status' => $success,
            'post' => $post,
            'date_range' => $date_range
        ];
    }

    // ajax get report
    public function ajaxSingleReport(Request $request)
    {
        $post = $request->except('_token');
        $report_type = $post['report_type'];
        unset($post['report_type']);

        $date_range = "";
        // request validation
        $check = $this->checkFilter($post);
        if (!$check['status']) {
            return [
                "status" => "fail",
                "messages" => ['Field is required']
            ];
        } else {
            $post = $check['post'];
            $date_range = $check['date_range'];

            // combine post with filter from session
            $report_filter = session('report_filter');
            $post = array_replace($report_filter, $post);

            // store filter in session
            session(['report_filter' => $post]);

            switch ($report_type) {
                case 'all':
                    $result = MyHelper::post('report/single', $post);
                    break;
                case 'trx':
                    $result = MyHelper::post('report/single/trx', $post);
                    break;
                case 'product':
                    $result = MyHelper::post('report/single/product', $post);
                    break;
                /*case 'reg':
                    $result = MyHelper::post('report/single/registration', $post);
                    break;*/
                case 'membership':
                    $result = MyHelper::post('report/single/membership', $post);
                    break;
                case 'voucher':
                    $result = MyHelper::post('report/single/voucher', $post);
                    break;
                default:
                    $result = ['status' => fail, 'messages' => 'Unknown report type'];
                    break;
            }

            // date format in datepicker
            $result['filter'] = $post;
            $result['date_range'] = $date_range;

            return $result;
        }
    }
}
