<?php

namespace Modules\Voucher\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;

class WebviewVoucherController extends Controller
{
    public function voucherDetail(Request $request, $id_deals_user)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }

        $post['id_deals_user'] = $id_deals_user;
        $post['used'] = 0;

        $data['voucher'] = parent::getData(MyHelper::postWithBearer('voucher/me?log_save=0', $post, $bearer));

        return view('voucher::webview.voucher_detail_v3', $data);
    }

    public function voucherDetailV2(Request $request, $id_deals_user)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }

        // $bearer = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImIzZjc4Nzc5MjMyMzE5NGUwOGYzMDViZTg5MzdkYzRjOTAxY2ZiYjhjNDgzMTA2NzFmOWQ1OWYxZWYyYTFmNTNhNzZkMTVlOTgxMmI1ZDMwIn0.eyJhdWQiOiIyIiwianRpIjoiYjNmNzg3NzkyMzIzMTk0ZTA4ZjMwNWJlODkzN2RjNGM5MDFjZmJiOGM0ODMxMDY3MWY5ZDU5ZjFlZjJhMWY1M2E3NmQxNWU5ODEyYjVkMzAiLCJpYXQiOjE1NDUxMjI2OTAsIm5iZiI6MTU0NTEyMjY5MCwiZXhwIjoxNTc2NjU4NjkwLCJzdWIiOiIzIiwic2NvcGVzIjpbIioiXX0.SvAjRAlyv6mmp1gfItNE0iEFUEK-4c3BnH7plc79lwgSahXoCuvdyHdHAUPAx10-IuW5KZ-yJAjkuLgJOOIOI_syzMxNad37Czc3JDzW13QlD3wdPg9Sbd6FQCNcOJrTzS4Kdn6VdGd36fokvfzqcfEWUX1UhKW4NLrrTRstsabXKXM96Yg-H-IAo7Mb7ihJyBFJw8vbVyUhiXeYwxQrHGiIufcK3Vi5a_xuVgU5OEbhawpJh80gZNPCT26yKQCX6iQdJVjM_PySupd3V9QhQdsj4e78JdRKbQ_2CjiCDGv5JKmNljGjxUQY6QnVD61r5oGywLEM7W5Od68lh8OuGMCtdPUkRDEHE0fSyduGGM8G4vxiCk2dVZ3BvLStQvnR1OObUGYn1gMZN4bNHc21TAgKiriA7vxNLirt9mVheioIQveXixkwf3YWW1ro2lCp2GH15Llf5GdyVgp9v67sSmTsxEF7ssj_2AUZyiMbJOvyzppdal2-HE9scIqlEFPXPDxytw6D-YiPfeDEkkFc8zPMX1HLR4sNZS76JVJPGoYG5jpIXxMpBIzLHEeUO47UosMs_lo9Ty7KM9QNmSQFoibpP_bFuFeUdSrKBpV4mkq6OGkN3igATnuG7twqRj6StoOfRBGy_99pbQ6opm48AfKmKGjec2S6tnHdylje7vs';

        $post['id_deals_user'] = $id_deals_user;
        $post['used'] = 0;

        $data['voucher'] = parent::getData(MyHelper::postWithBearer('voucher/me?log_save=0', $post, $bearer));

        return view('voucher::webview.voucher_detail_v4', $data);
    }

    // display detail voucher after used
    public function voucherUsed(Request $request, $id_deals_user)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }

        $post['id_deals_user'] = $id_deals_user;
        $post['used'] = 1;

        $data['voucher'] = parent::getData(MyHelper::postWithBearer('voucher/me?log_save=0', $post, $bearer));

        return view('voucher::webview.voucher_detail', $data);
    }
}
