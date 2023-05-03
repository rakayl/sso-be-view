<?php

namespace Modules\Doctor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class DoctorServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Service',
            'sub_title'      => 'Service List',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-service'
        ];

        $service = MyHelper::get('doctor/service');

        if (isset($service['status']) && $service['status'] == "success") {
            $data['service'] = $service['result'];
        } else {
            $data['service'] = [];
        }

        return view('doctor::service.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Service',
            'sub_title'      => 'Service List',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-service'
        ];

        return view('doctor::service.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $store = MyHelper::post('doctor/service/store', $post);

        if (($store['status'] ?? '') == 'success') {
            return redirect('doctor/service')->with('success', ['Create Service Success']);
        } else {
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('doctor::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'title'          => 'Service',
            'sub_title'      => 'Service Edit',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-service'
        ];

        $service = MyHelper::get('doctor/service/' . $id);

        if (isset($service['status']) && $service['status'] == "success") {
            $data['service'] = $service['result'];
        } else {
            $data['service'] = [];
        }

        return view('doctor::service.form', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $post = $request->except('_method');
        $store = MyHelper::post('doctor/service/store', $post);

        if (($store['status'] ?? '') == 'success') {
            return redirect('doctor/service')->with('success', ['Update Service Success']);
        } else {
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::post('doctor/service/delete', ['id_doctor_service' => $id]);
        if (($result['status'] ?? '') == 'success') {
            return redirect('doctor/service')->with('success', ['Delete Service Success']);
        } else {
            return back()->withInput()->withErrors($result['messages'] ?? ['Something went wrong']);
        }
    }
}
