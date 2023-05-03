<?php

namespace Modules\Doctor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class DoctorClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Clinic',
            'sub_title'      => 'Clinic List',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-clinic'
        ];

        $clinic = MyHelper::get('doctor/clinic');

        if (isset($clinic['status']) && $clinic['status'] == "success") {
            $data['clinic'] = $clinic['result'];
        } else {
            $data['clinic'] = [];
        }

        return view('doctor::clinic.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Clinic',
            'sub_title'      => 'Clinic Create',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-clinic'
        ];

        return view('doctor::clinic.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $store = MyHelper::post('doctor/clinic/store', $post);

        if (($store['status'] ?? '') == 'success') {
            return redirect('doctor/clinic')->with('success', ['Create Clinic Success']);
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
            'title'          => 'Clinic',
            'sub_title'      => 'Clinic Edit',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-clinic'
        ];

        $clinic = MyHelper::get('doctor/clinic/' . $id);

        if (isset($clinic['status']) && $clinic['status'] == "success") {
            $data['clinic'] = $clinic['result'];
        } else {
            $data['clinic'] = [];
        }

        return view('doctor::clinic.form', $data);
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
        $store = MyHelper::post('doctor/clinic/store', $post);

        if (($store['status'] ?? '') == 'success') {
            return redirect('doctor/clinic')->with('success', ['Update Clinic Success']);
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
        $result = MyHelper::post('doctor/clinic/delete', ['id_doctor_clinic' => $id]);
        if (($result['status'] ?? '') == 'success') {
            return redirect('doctor/clinic')->with('success', ['Delete Clinic Success']);
        } else {
            return back()->withInput()->withErrors($result['messages'] ?? ['Something went wrong']);
        }
    }
}
