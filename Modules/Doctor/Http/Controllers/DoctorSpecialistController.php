<?php

namespace Modules\Doctor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class DoctorSpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Specialist',
            'sub_title'      => 'Specialist List',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-specialist'
        ];

        $specialist = MyHelper::get('doctor/specialist');

        if (isset($specialist['status']) && $specialist['status'] == "success") {
            $data['specialist'] = $specialist['result'];
        } else {
            $data['specialist'] = [];
        }

        return view('doctor::specialist.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Specialist',
            'sub_title'      => 'Specialist List',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-specialist'
        ];

        $category = MyHelper::get('doctor/be/specialist-category');

        if (isset($category['status']) && $category['status'] == "success") {
            $data['category'] = $category['result'];
        } else {
            $data['category'] = [];
        }

        return view('doctor::specialist.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $store = MyHelper::post('doctor/specialist/store', $post);

        if (($store['status'] ?? '') == 'success') {
            return redirect('doctor/specialist')->with('success', ['Create Specialist Success']);
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
            'title'          => 'Specialist',
            'sub_title'      => 'Specialist Edit',
            'menu_active'    => 'doctor',
            'submenu_active' => 'doctor-specialist'
        ];

        $specialist = MyHelper::get('doctor/specialist/' . $id);

        if (isset($specialist['status']) && $specialist['status'] == "success") {
            $data['specialist'] = $specialist['result'];
        } else {
            $data['specialist'] = [];
        }

        $category = MyHelper::get('doctor/specialist-category');

        if (isset($category['status']) && $category['status'] == "success") {
            $data['category'] = $category['result'];
        }

        return view('doctor::specialist.form', $data);
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
        $store = MyHelper::post('doctor/specialist/store', $post);

        if (($store['status'] ?? '') == 'success') {
            return redirect('doctor/specialist')->with('success', ['Update Specialist Success']);
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
        $result = MyHelper::post('doctor/specialist/delete', ['id_doctor_specialist' => $id]);
        if (($result['status'] ?? '') == 'success') {
            return redirect('doctor/specialist')->with('success', ['Delete Specialist Success']);
        } else {
            return back()->withInput()->withErrors($result['messages'] ?? ['Something went wrong']);
        }
    }
}
