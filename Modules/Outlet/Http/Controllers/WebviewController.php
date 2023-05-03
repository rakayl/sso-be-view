<?php

namespace Modules\Outlet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class WebviewController extends Controller
{
    public function detailWebview(Request $request, $id)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        // if ($request->isMethod('get')) {
        //     return view('error', ['msg' => 'Url method is POST']);
        // }

        $list = MyHelper::postWithBearer('outlet/be/list?log_save=0', ['id_outlet' => $id], $bearer);
        // return $list;
        return view('outlet::webview.list', ['data' => $list['result']]);
    }
}
