<?php

namespace Modules\PaymentMethod\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Offline Payment Method',
            'sub_title'      => 'Offline Payment Method List',
            'menu_active'    => 'payment-method',
            'submenu_active' => 'payment-method-list',
        ];

        // outlet
        $payment_method = MyHelper::get('payment-method');

        if (isset($payment_method['status']) && $payment_method['status'] == "success") {
            $data['payment_method'] = $payment_method['result'];
        } else {
            $data['payment_method'] = [];
        }


        return view('paymentmethod::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Payment Method',
            'sub_title'      => 'New Payment Method',
            'menu_active'    => 'payment-method',
            'submenu_active' => 'new-payment-method',
        ];

        $payment_method_category = MyHelper::get('payment-method-category');

        if (isset($payment_method_category['status']) && $payment_method_category['status'] == "success") {
            $data['payment_method_category'] = $payment_method_category['result'];
        } else {
            $data['payment_method_category'] = [];
        }

        return view('paymentmethod::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        $create = MyHelper::post('payment-method/store', $post);

        if ($create['status'] == 'success') {
            return redirect('payment-method')->with('success', ['Create payment method success']);
        } else {
            return back()->withInput()->withErrors($create['messages'] ?? ['Create payment method fail']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'title'          => 'Payment Method',
            'sub_title'      => 'Edit Payment Method',
            'menu_active'    => 'payment-method',
            'submenu_active' => 'payment-method-list',
        ];

        $payment_method_category = MyHelper::get('payment-method-category');
        if (isset($payment_method_category['status']) && $payment_method_category['status'] == "success") {
            $data['payment_method_category'] = $payment_method_category['result'];
        } else {
            $data['payment_method_category'] = [];
        }

        $edit = MyHelper::get('payment-method/edit/' . $id);
        if (isset($edit['status']) && $edit['status'] == "success") {
            $data['payment_method'] = $edit['result'];
        } else {
            $data['payment_method'] = [];
        }
        //dd($data);exit;
        return view('paymentmethod::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        // dd($post);exit;
        $update = MyHelper::post('payment-method/update/' . $id, $post);
        //dd($update);exit;
        if ($update['status'] == 'success') {
            return redirect('payment-method')->with('success', ['Update payment method success']);
        } else {
            return back()->withInput()->withErrors($create['messages'] ?? ['Update payment method fail']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $delete = MyHelper::get('payment-method/delete/' . $id);

        if ($delete['status'] == 'success') {
            return redirect('payment-method')->with('success', ['Delete payment method success']);
        } else {
            return back()->withInput()->withErrors($create['messages'] ?? ['Delete payment method fail']);
        }
    }

    public function differentPaymentMethod($id)
    {
        $payment_method  = MyHelper::get('payment-method/item/' . $id);

        if (isset($payment_method['status']) && $payment_method['status'] == 'success') {
            $data = [
                'title'          => 'Payment Method',
                'sub_title'      => 'Detail Payment Method',
                'menu_active'    => 'payment-method',
                'submenu_active' => 'payment-method-list',
                'payment_method' => $payment_method['result']
            ];
            return view('paymentmethod::detail', $data);
        }

        return back() - withInput()->withErrors($create['messages'] ?? ['Payment Method not found']);
    }

    public function getDifferentPaymentMethod(Request $request, $id)
    {
        $filter['keyword'] = $request->post('keyword');
        $data = MyHelper::post('payment-method/outlet/different-payment-method/list/' . $id, $filter);
        return $data;
    }

    public function updateDifferentPaymentMethod(Request $request)
    {
        $post = $request->except('_token');
        $data = MyHelper::post('payment-method/outlet/different-payment-method/update', $post);
        return $data;
    }
}
