<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;

class EventController extends Controller
{
    public function create()
    {
        $data = [
            'title'          => 'Event',
            'sub_title'      => 'New Event',
            'menu_active'    => 'event',
            'submenu_active' => 'event-new'
        ];
       $data['province'] = MyHelper::get('province/list')['result'] ?? [];
        return view('merchant::event.create', $data);
    }

    public function store(Request $request)
    {
        $post = $request->except('_token');
        $idSubdis = explode("|", $post['id_subdistrict']);
        $post['id_subdistrict'] = $idSubdis[0] ?? null;
        $post['date'] = date('Y-m-d H:i:s', strtotime($post['date']));
        $post['created_by'] = Session::get('id_user');
         if (isset($post['image_event'])) {
            $post['image_event'] = MyHelper::encodeImage($post['image_event']);
        }
        $create = MyHelper::post('event/store', $post);
        if (isset($create['status']) && $create['status'] == "success") {
            return redirect('event')->withSuccess(['Success save data']);
        } else {
            return redirect('event/create')->withErrors($create['messages'] ?? ['Failed save data']);
        }
    }

    public function list(Request $request)
    {
        $post = $request->all();

        $data = [
            'title'          => 'Event',
            'sub_title'      => 'Event List',
            'menu_active'    => 'event',
            'submenu_active' => 'event-list',
            'title_date_start' => 'Start',
            'title_date_end' => 'End',
            'type' => ''
        ];
        

        if ($post) {
            Session::put('filter-event', $post);
        }
        if (Session::has('filter-event') && $post && isset($post['filter'])) {
            $page = 1;
            if (isset($post['page'])) {
                $page = $post['page'];
            }
            $post = Session::get('filter-event');
            $post['page'] = $page;
            $data['conditions'] = $post['conditions'];
            $data['rule'] = $post['rule'];
        } else {
            Session::forget('filter-event');
        }

        $getList = MyHelper::post('event/list', $post);

        if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['data'];
            $data['dataTotal']     = $getList['result']['total'];
            $data['dataPerPage']   = $getList['result']['from'];
            $data['dataUpTo']      = $getList['result']['from'] + count($getList['result']['data']) - 1;
            $data['dataPaginator'] = new LengthAwarePaginator($getList['result']['data'], $getList['result']['total'], $getList['result']['per_page'], $getList['result']['current_page'], ['path' => url()->current()]);
        } else {
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }
        return view('merchant::event.list', $data);
    }

    public function detail($id)
    {
        $data = [
            'title'          => 'Event',
            'sub_title'      => 'Event Detail',
            'menu_active'    => 'event',
            'submenu_active' => 'event-list',
        ];
        $detail = MyHelper::post('event/detail', ['id_event' => $id]);
        
        if (isset($detail['status']) && $detail['status'] == "success") {
            $data['result'] = $detail['result'];
            $data['province'] = MyHelper::get('province/list')['result'] ?? [];
            return view('merchant::event.detail', $data);
        } else {
            return redirect('event')->withErrors($save['messages'] ?? ['Failed get data']);
        }
    }
    public function delete($id)
    {
        $detail = MyHelper::post('event/delete', ['id_event' => $id]);
        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('event')->withSuccess(['Success delete data']);
        } else {
            return redirect('event')->withErrors($update['messages'] ?? ['Failed delete data']);
        }
    }

    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        
        $post['id_event_sedot_wc'] = $id;
        $post['event_price'] = (int)str_replace(".","",$post['event_price']);
        $update = MyHelper::post('event/update', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return redirect('event/detail/' . $id)->withSuccess(['Success save data']);
        } else {
            return redirect('event/detail/' . $id)->withErrors($update['messages'] ?? ['Failed get data']);
        }
    }
}
