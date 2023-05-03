<?php

namespace Modules\Shift\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $post = $request->except('_token');
        // dd($post);exit;
        $data = [
            'title'          => 'Report Shift',
            'sub_title'      => 'Report Shift List',
            'menu_active'    => 'report-shift',
            'submenu_active' => 'report-shift',
            'post'           => []
        ];

        if (!empty($post)) {
            /* Jika User melakukan filter data Shift */

            $data['post'] = array_filter($post, function ($item) {
                if (is_array($item)) {
                    foreach ($item as $val) {
                        return !is_null($val);
                    }
                }
                return !is_null($item);
            });


            if (isset($post['shift_start_date']) && isset($post['shift_end_date'])) {
                if (strtotime($post['shift_start_date']) > strtotime($post['shift_end_date'])) {
                    return back()->withErrors(['Shift start date must be smaller than shift end date'])->withInput();
                }
            }

            if (isset($post['cash_start']['range_start']) && isset($post['cash_start']['range_end'])) {
                if ($post['cash_start']['range_start'] > $post['cash_start']['range_end']) {
                    return back()->withErrors(['Cash Start - Range Start must be smaller than Cash Start - Range End'])->withInput();
                }
            }

            if (isset($post['cash_end']['range_start']) && isset($post['cash_end']['range_end'])) {
                if ($post['cash_end']['range_start'] > $post['cash_end']['range_end']) {
                    return back()->withErrors(['Cash End - Range Start must be smaller than Cash End - Range End'])->withInput();
                }
            }

            if (isset($post['cash_difference']['range_start']) && isset($post['cash_difference']['range_end'])) {
                if ($post['cash_difference']['range_start'] > $post['cash_difference']['range_end']) {
                    return back()->withErrors(['Cash Difference - Range Start must be smaller than Cash Difference - Range End'])->withInput();
                }
            }
        }

        $shifts = MyHelper::post('report/shift/summary', $data['post']);
        $outlets = MyHelper::get('outlet/be/list');
        $user_outletapps = MyHelper::get('outlet/be/user_outletapp/list');

        if (isset($shifts['status']) && $shifts['status'] == "success") {
            $data['shifts'] = $shifts['result'];
        } else {
            $data['shifts'] = [];
        }

        if (isset($outlets['status']) && $outlets['status'] == 'success') {
            $data['outlets'] = $outlets['result'];
        } else {
            $data['outlets'] = [];
        }

        if (isset($user_outletapps['status']) && $user_outletapps['status'] == 'success') {
            $data['user_outletapps'] = $user_outletapps['result'];
        } else {
            $data['user_outletapps'] = [];
        }

        return view('shift::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('shift::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('shift::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('shift::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
