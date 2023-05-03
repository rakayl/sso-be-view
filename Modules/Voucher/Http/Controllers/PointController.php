<?php

namespace Modules\Voucher\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class PointController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    /* POINT */
    public function point(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Voucher',
                'menu_active'    => 'voucher',
                'sub_title'      => 'Point History',
                'submenu_active' => 'point-history'
            ];

            $request->session()->forget('date_start');
            $request->session()->forget('date_end');
            $request->session()->forget('phone_number');

            $data['date_start']   = date('Y-m-d', strtotime("- 30 days"));
            $data['date_end']     = date('Y-m-d');
            $data['phone_number'] = "";

            return view('voucher::point', $data);
        } else {
            $data = [
                'title'          => 'Voucher',
                'menu_active'    => 'voucher',
                'sub_title'      => 'Point History',
                'submenu_active' => 'point-history'
            ];

            $dataApi = $post;

            if (isset($post['page'])) {
                $dataApi['date_start']   = session('date_start');
                $dataApi['date_end']     = session('date_end');
                $dataApi['phone_number'] = session('phone_number');

                // untuk view
                $data['date_start']   = session('date_start');
                $data['date_end']     = session('date_end');
                $data['phone_number'] = session('phone_number');
            } else {
                session(['date_start'   => $post['date_start'] ]);
                session(['date_end'     => $post['date_end'] ]);
                session(['phone_number' => $post['phone_number'] ]);
            }

            foreach ($post as $key => $value) {
                $data[$key] = $value;
            }

            // filter inputan
            $dataApi = $this->filterInputan($dataApi);

            // POINT LOG
            $data['point'] = $this->getPointValue($dataApi);

            // USER
            $data['user'] = $this->getUserPoint($dataApi);
            $data['post'] = 1;

            return view('voucher::point', $data);
        }
    }

    public function filterInputan($dataApi)
    {
        $dataApi = array_filter($dataApi);
        if (isset($dataApi['phone_number'])) {
            $dataApi['phone'] = $dataApi['phone_number'];
            unset($dataApi['phone_number']);
        }

        return $dataApi;
    }

    /* DATA POINT VALUE */
    public function getPointValue($dataApi)
    {
        $voucher      = 0;
        $pointVoucher = 0;
        $trx          = 0;
        $pointTrx     = 0;

        // WARNA
        $warna = [
            '#FF0F00',
            '#FF6600',
            '#FF9E01',
            '#FCD202',
            '#F8FF01',
            '#B0DE09',
            '#04D215',
            '#0D8ECF',
            '#0D52D1',
            '#2A0CD0',
            '#8A0CCF',
            '#CD0D74'
        ];

        // POINT
        $point = parent::getData(MyHelper::post('point/list', $dataApi));

        if (!empty($point)) {
            foreach ($point as $suw) {
                if ($suw['source'] == "voucher") {
                    $voucher      = $voucher + 1;
                    $pointVoucher = $pointVoucher + $suw['point'];
                }

                if ($suw['source'] == "transaction") {
                    $trx      = $trx + 1;
                    $pointTrx = $pointTrx + $suw['point'];
                }
            }
        }

        // data point
        $dataPointValue = [
            [
                'type'  => 'Voucher',
                'point' => $pointVoucher,
                'color' => $warna[0]
            ],
            [
                'type'  => 'Transaction',
                'point' => $pointTrx,
                'color' => $warna[2]
            ],
        ];

        // data satuan
        $dataPoint = [
            [
                'type'  => 'Voucher',
                'point' => $voucher
            ],
            [
                'type'  => 'Transaction',
                'point' => $trx
            ],
        ];

        $data['voucher']             = $voucher;
        $data['pointVoucher']        = $pointVoucher;
        $data['trx']                 = $trx;
        $data['pointTrx']            = $pointTrx;
        $data['chart']['point']      = json_encode($dataPoint);
        $data['chart']['pointValue'] = json_encode($dataPointValue);

        return $data;
    }

    /* GET USER WITH POINT*/
    public function getUserPoint($dataApi)
    {
        $dataApi['admin'] = 1;
        $user = parent::getData(MyHelper::post('point/user/list', $dataApi));

        if (!empty($user)) {
            $user['paginator'] = new LengthAwarePaginator($user['data'], $user['total'] - 1, $user['per_page'], $user['current_page'], ['path' => url()->current()]);
        }

        return $user;
    }

    /* GET INFO POINT USER */
    public function pointDetail(Request $request, $phone)
    {
        $data = [
            'title'          => 'Voucher',
            'menu_active'    => 'voucher',
            'sub_title'      => 'Point History',
            'submenu_active' => 'point-history'
        ];

        $data['user'] = parent::getData(MyHelper::post('point/user/list', ['phone' => $phone]));

        if (empty($data['user'])) {
            return back()->withErrors(['Data not found.']);
        } else {
            return view('voucher::point_user', $data);
        }
    }
}
