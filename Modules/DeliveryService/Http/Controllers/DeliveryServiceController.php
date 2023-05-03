<?php

namespace Modules\DeliveryService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class DeliveryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'             => 'Setting',
            'sub_title'         => 'Delivery Service',
            'menu_active'       => 'delivery-service',
            'submenu_active'    => 'delivery-service'
        ];

        $action = MyHelper::get('delivery-service/');
        $data['result'] = $action['result'];
        return view('deliveryservice::index', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except(['_token']);
        $data = [
            'title'             => 'Setting',
            'sub_title'         => 'Delivery Service',
            'menu_active'       => 'delivery-service',
            'submenu_active'    => 'delivery-service'
        ];

        $action = MyHelper::post('delivery-service/store', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            $data['result'] = $action['result'];
            return view('deliveryservice::index', $data);
        }
    }

    public function detailWebview(Request $request)
    {
        $bearer = $request->header('Authorization');

        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        $data = MyHelper::getWithBearer('delivery-service/webview?log_save=0', $bearer);

        // dd($data);
        return view('deliveryservice::webview.detail', $data);
    }
}
