<?php

namespace Modules\UserFeedback\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class RatingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'Rating Item',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'rating-item'
        ];
        $items = MyHelper::get('user-feedback/rating-item')['result'] ?? [];
        $newArr = [];
        foreach ($items as $item) {
            $newArr[$item['rating_value']] = $item;
        }
        $data['items'] = $newArr;
        return view('userfeedback::rating_item.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $post = $request->except('_token');
        $items = $post['item'] ?? [];
        if (!$items) {
            return back()->withInput()->withErrors('Data could not be empty');
        }
        foreach ($items as $key => &$item) {
            $item['rating_value'] = $key;
            $item['order'] = 2 - $key;
            if (isset($item['image'])) {
                $item['image'] = MyHelper::encodeImage($item['image']);
            }
            if (isset($item['image_selected'])) {
                $item['image_selected'] = MyHelper::encodeImage($item['image_selected']);
            }
        }
        $result = MyHelper::post('user-feedback/rating-item/update', ['rating_item' => array_values($items)]);
        if (($result['status'] ?? false) == 'success') {
            return redirect('user-feedback/setting#tab_rating_items')->with('success', ['Success update rating item']);
        } else {
            return redirect('user-feedback/setting#tab_rating_items')->withInput()->withErrors($result['messages'] ?? ['Failed update rating item']);
        }
    }
}
