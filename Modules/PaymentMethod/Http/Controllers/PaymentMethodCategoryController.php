<?php

namespace Modules\PaymentMethod\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class PaymentMethodCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Offline Payment Method Category',
            'sub_title'      => 'Offline Payment Method Category List',
            'menu_active'    => 'payment-method',
            'submenu_active' => 'category-list',
        ];

        // outlet
        $payment_method = MyHelper::get('payment-method-category');

        if (isset($payment_method['status']) && $payment_method['status'] == "success") {
            $data['payment_method_category'] = $payment_method['result'];
        } else {
            $data['payment_method_category'] = [];
        }

        return view('paymentmethod::category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Payment Method Category',
            'sub_title'      => 'New Payment Method Category',
            'menu_active'    => 'payment-method',
            'submenu_active' => 'new-category',
        ];
        return view('paymentmethod::category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        $create = MyHelper::post('payment-method-category/store', $post);

        if ($create['status'] == 'success') {
            return redirect('payment-method-category')->with('success', ['Create payment method category success']);
        } else {
            return back()->withInput()->withErrors($create['messages'] ?? ['Create payment method  category fail']);
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
            'title'          => 'Payment Method Category',
            'sub_title'      => 'Edit Payment Method Category',
            'menu_active'    => 'payment-method',
            'submenu_active' => 'category-list',
        ];

        $edit = MyHelper::get('payment-method-category/edit/' . $id);

        if (isset($edit['status']) && $edit['status'] == "success") {
            $data['payment_method_category'] = $edit['result'];
        } else {
            $data['payment_method_category'] = [];
        }
        //dd($data);exit;
        return view('paymentmethod::category.edit', $data);
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
        $update = MyHelper::post('payment-method-category/update/' . $id, $post);

        if ($update['status'] == 'success') {
            return redirect('payment-method-category')->with('success', ['Update payment method category success']);
        } else {
            return back()->withInput()->withErrors($create['messages'] ?? ['Update payment method category fail']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $delete = MyHelper::get('payment-method-category/delete/' . $id);

        if ($delete['status'] == 'success') {
            return redirect('payment-method-category')->with('success', ['Delete payment method category success']);
        } else {
            return back()->withInput()->withErrors($create['messages'] ?? ['Delete payment method category fail']);
        }
    }
}
