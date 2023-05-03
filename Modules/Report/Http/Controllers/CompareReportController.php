<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class CompareReportController extends Controller
{
    public function index()
    {
        $data = [
            'title'          => 'Report',
            'menu_active'    => 'report-compare',
            'sub_title'      => 'Compare Report',
            'submenu_active' => 'report-compare'
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

        session(['compare_report_filter' => null]);
        $post = session('compare_report_filter');
        $post = null;
        if ($post == null) {
            // set default filter
            // $today = date('Y-m-d');
            // $one_week_ago = date("Y-m-d", strtotime("-7 week"));
            // $two_week_ago = date("Y-m-d", strtotime("-8 week"));
            $today = date("Y-m-d", strtotime("30-12-2018"));
            $one_week_ago = date("Y-m-d", strtotime("23-12-2018"));
            $two_week_ago = date("Y-m-d", strtotime("16-12-2018"));

            $post['time_type_select'] = 'day';  // for select in view
            $post['time_type'] = 'day';  // for api
            // $post['param1'] = $one_week_ago;
            // $post['param2'] = $today;
            // $post['param3'] = $two_week_ago;
            // $post['param4'] = $one_week_ago;
            $post['param1'] = date("Y-m-d", strtotime("23-12-2018"));
            $post['param2'] = date("Y-m-d", strtotime("30-12-2018"));
            $post['param3'] = date("Y-m-d", strtotime("01-01-2019"));
            $post['param4'] = date("Y-m-d", strtotime("08-01-2019"));

            // date format in view (datepicker)
            $post['param1_str'] = date('d/m/Y', strtotime($post['param1']));
            $post['param2_str'] = date('d/m/Y', strtotime($post['param2']));
            $post['param3_str'] = date('d/m/Y', strtotime($post['param3']));
            $post['param4_str'] = date('d/m/Y', strtotime($post['param4']));

            if (!empty($data['products'])) {
                $post['id_product'] = $data['products'][0]['id_product'];
                $post['product_name'] = $data['products'][0]['product_name'];
                // $post['id_product_2'] = $data['products'][0]['id_product'];
                // $post['product_name_2'] = $data['products'][0]['product_name'];
            }
            if (!empty($data['memberships'])) {
                $post['id_membership_1'] = $data['memberships'][0]['id_membership'];
                $post['membership_name_1'] = $data['memberships'][0]['membership_name'];
                $post['id_membership_2'] = $data['memberships'][0]['id_membership'];
                $post['membership_name_2'] = $data['memberships'][0]['membership_name'];
            }
            if (!empty($data['deals'])) {
                $post['id_deals_1'] = $data['deals'][0]['id_deals'];
                $post['deals_title_1'] = $data['deals'][0]['deals_title'];
                $post['id_deals_2'] = $data['deals'][0]['id_deals'];
                $post['deals_title_2'] = $data['deals'][0]['deals_title'];
            }
            $post['trx_id_outlet_1'] = 0;
            $post['product_id_outlet_1'] = 0;
            $post['voucher_id_outlet_1'] = 0;

            $post['trx_id_outlet_2'] = 0;
            $post['product_id_outlet_2'] = 0;
            $post['voucher_id_outlet_2'] = 0;

            // store filter in session
            session(['compare_report_filter' => $post]);
        }
        $data['filter'] = $post;

        // get report
        $data['report'] = [];
        $report = MyHelper::post('report/compare', $post);
        if (isset($report['status']) && $report['status'] == 'success') {
            $data['report'] = $report['result'];
        }
        // dd([$data['report']]);

        return view('report::compare_report.compare_report', $data);
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
                if (
                    $post['param1'] == "" || $post['param2'] == "" ||
                    $post['param3'] == "" || $post['param4'] == ""
                ) {
                    $success = false;
                } else {
                    // date format in datepicker
                    $post['param1_str'] = $post['param1'];
                    $post['param2_str'] = $post['param2'];
                    $post['param3_str'] = $post['param3'];
                    $post['param4_str'] = $post['param4'];

                    $post['param1'] = str_replace('/', '-', $post['param1']);
                    $post['param2'] = str_replace('/', '-', $post['param2']);
                    $post['param3'] = str_replace('/', '-', $post['param3']);
                    $post['param4'] = str_replace('/', '-', $post['param4']);

                    $post['param1'] = date('Y-m-d', strtotime($post['param1']));
                    $post['param2'] = date('Y-m-d', strtotime($post['param2']));
                    $post['param3'] = date('Y-m-d', strtotime($post['param3']));
                    $post['param4'] = date('Y-m-d', strtotime($post['param4']));

                    $date_range_1 = date(
                        'd M Y',
                        strtotime($post['param1'])
                    ) . " - " . date('d M Y', strtotime($post['param2']));

                    $date_range_2 = date(
                        'd M Y',
                        strtotime($post['param3'])
                    ) . " - " . date('d M Y', strtotime($post['param4']));
                }
                break;
            case 'month':
                if (
                    $post['param1'] == "" || $post['param2'] == "" || $post['param3'] == "" ||
                    $post['param4'] == "" || $post['param5'] == "" || $post['param6'] == ""
                ) {
                    $success = false;
                } else {
                    $month_name_1 = date('F', mktime(0, 0, 0, $post['param1'], 10));
                    $month_name_2 = date('F', mktime(0, 0, 0, $post['param2'], 10));
                    $month_name_3 = date('F', mktime(0, 0, 0, $post['param4'], 10));
                    $month_name_4 = date('F', mktime(0, 0, 0, $post['param5'], 10));
                    $date_range_1 = $month_name_1 . " - " . $month_name_2 . " " . $post['param3'];
                    $date_range_2 = $month_name_3 . " - " . $month_name_4 . " " . $post['param6'];
                }
                break;
            case 'year':
                if (
                    $post['param1'] == "" || $post['param2'] == "" ||
                    $post['param3'] == "" || $post['param4'] == ""
                ) {
                    $success = false;
                } else {
                    $date_range_1 = $post['param1'] . " - " . $post['param2'];
                    $date_range_2 = $post['param3'] . " - " . $post['param4'];
                }
                break;

            default:
                $success = false;
                break;
        }

        return [
            'status' => $success,
            'post' => $post,
            'date_range_1' => $date_range_1,
            'date_range_2' => $date_range_2
        ];
    }

    // ajax get report
    public function ajaxCompareReport(Request $request)
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
            $date_range_1 = $check['date_range_1'];
            $date_range_2 = $check['date_range_2'];

            // combine post with filter from session
            $compare_report_filter = session('compare_report_filter');
            $post = array_replace($compare_report_filter, $post);

            // store filter in session
            session(['compare_report_filter' => $post]);

            switch ($report_type) {
                case 'all':
                    $result = MyHelper::post('report/compare', $post);
                    break;
                case 'trx':
                    $result = MyHelper::post('report/compare/trx', $post);
                    break;
                case 'product':
                    $result = MyHelper::post('report/compare/product', $post);
                    break;
                case 'membership':
                    $result = MyHelper::post('report/compare/membership', $post);
                    break;
                case 'voucher':
                    $result = MyHelper::post('report/compare/voucher', $post);
                    break;
                default:
                    $result = ['status' => fail, 'messages' => 'Unknown report type'];
                    break;
            }

            // date format in datepicker
            $result['filter'] = $post;
            $result['date_range_1'] = $date_range_1;
            $result['date_range_2'] = $date_range_2;

            return $result;
        }
    }
}
