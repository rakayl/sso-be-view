<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class PromoSettingController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function promoCashback(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'          => 'Promo Setting',
            'sub_title'      => 'Cashback',
            'menu_active'    => 'promo-cashback-setting',
            'submenu_active' => ''
        ];

        if (empty($post)) {
            $data['cashback'] = MyHelper::get('promo-setting/cashback')['result'] ?? '';

            return view('setting::promo-setting.promo_cashback_setting', $data);
        } else {
            $result = MyHelper::post('promo-setting/cashback', $post);

            if ($result['status'] ?? false) {
                if ($result['status'] == 'success') {
                    return redirect('promo-setting/cashback')->withSuccess(['Promo Cashback Setting has been updated']);
                } else {
                    return redirect('promo-setting/cashback')->withErrors(['Promo Cashback Setting update failed']);
                }
            } else {
                return redirect('promo-setting/cashback')->withErrors(['Something went wrong']);
            }
        }
    }
}
