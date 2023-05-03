<?php

namespace Modules\Enquiries\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

class EnquiriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function indexAjax(Request $request)
    {
        $post = $request->except('_token');
        // return response()->json($post);
        $enquiries = MyHelper::post('enquiries/list', $post);

        if (isset($enquiries['status']) && $enquiries['status'] == "success") {
            $data = $enquiries['result'];
        } else {
            $data = [];
        }
        return response()->json($data);
    }
    public function indexDetailAjax(Request $request)
    {
        $post = $request->except('_token');
        $enquiries = MyHelper::post('enquiries/list', $post);

        if (isset($enquiries['status']) && $enquiries['status'] == "success") {
            $data = $enquiries['result'];
        } else {
            $data = [];
        }
        return response()->json($data);
    }

    public function index(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Enquiries',
            'sub_title'      => 'List',
            'menu_active'    => 'enquiries',
            'submenu_active' => 'enquiries-list',
        ];

        if (Session::has('filter-list-enquiries') && !empty($post) && !isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-list-enquiries');
            $post['page'] = $page;
        } else {
            Session::forget('filter-list-enquiries');
        }

        $post['paginate'] = true;
        // get api
        $enquiries   = MyHelper::post('enquiries/list', $post);

        if (isset($enquiries['status']) && $enquiries['status'] == "success") {
            $data['data']          = $enquiries['result']['data'];
            $data['dataTotal']     = $enquiries['result']['total'];
            $data['dataPerPage']   = $enquiries['result']['from'];
            $data['dataUpTo']      = $enquiries['result']['from'] + count($enquiries['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($enquiries['result']['data'], $enquiries['result']['total'], $enquiries['result']['per_page'], $enquiries['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        $replace = MyHelper::get('autocrm/textreplace');
        if ($replace['status'] == 'success') {
            $data['textreplaces'] = $replace['result'];
        }

        $data['textreplaces'][] = ['keyword' => '%enquiry_subject%','reference' => 'enquiry subject'];
        $data['textreplaces'][] = ['keyword' => '%enquiry_message%','reference' => 'enquiry message'];
        $data['textreplaces'][] = ['keyword' => '%enquiry_phone%','reference' => 'enquiry phone'];
        $data['textreplaces'][] = ['keyword' => '%enquiry_name%','reference' => 'enquiry name'];
        $data['textreplaces'][] = ['keyword' => '%enquiry_email%','reference' => 'enquiry email'];
        $data['textreplaces'][] = ['keyword' => '%visiting_time%','reference' => 'enquiry visiting time'];

        if ($post) {
            Session::put('filter-list-enquiries', $post);
        }

        return view('enquiries::index', $data);
    }

    /* UPDATE */
    public function update(Request $request)
    {
        $post = $request->except('_token');
        $update = MyHelper::post('enquiries/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    public function reply(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['reply_push_image'])) {
            $post['reply_push_image'] = MyHelper::encodeImage($post['reply_push_image']);
        }
        $update = MyHelper::post('enquiries/reply', $post);
        // print_r($update);exit;
        if (isset($update['status']) && $update['status'] == "success") {
            session(['success' => ['Enquiry replied']]);
            return back();
        } else {
            return redirect('enquiries')->withErrors(['Failed to reply']);
        }
    }

    /* DELETE */
    public function delete(Request $request)
    {
        $post = $request->except('_token');
        $delete = MyHelper::post('enquiries/delete', $post);
        return $delete;
    }
}
