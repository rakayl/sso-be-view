<?php

namespace Modules\Reward\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class RewardController extends Controller
{
    public function create(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Reward',
                'sub_title'      => 'New Reward',
                'menu_active'    => 'reward',
                'submenu_active' => 'reward-create',
            ];

            return view('reward::create', $data);
        } else {
            $post['reward_image'] = MyHelper::encodeImage($post['reward_image']);
            $save = MyHelper::post('reward/create', $post);

            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('reward/create')->withSuccess(['Reward has been created.']);
            } else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    public function list()
    {
        $data = [
            'title'          => 'Reward',
            'sub_title'      => 'Reward List',
            'menu_active'    => 'reward',
            'submenu_active' => 'reward-list',
        ];

        $reward = MyHelper::get('reward/list');

        if (isset($reward['status']) && $reward['status'] == "success") {
            $data['reward'] = array_map(function ($var) {
                $var['id_reward'] = MyHelper::createSlug($var['id_reward'], $var['created_at']);
                return $var;
            }, $reward['result']);
        } else {
            $data['reward'] = [];
        }
        return view('reward::list', $data);
    }

    public function detail(Request $request, $slug)
    {
        $exploded = MyHelper::explodeSlug($slug);
        $id = $exploded[0];
        $created_at = $exploded[1];
        $post = $request->except('_token');

        $data = [
            'title'          => 'Reward',
            'sub_title'      => 'Reward List',
            'menu_active'    => 'reward',
            'submenu_active' => 'reward-list',
        ];

        if (empty($post)) {
            $reward = MyHelper::post('reward/list', ['id_reward' => $id,'created_at' => $created_at]);

            if (isset($reward['status']) && $reward['status'] == "success") {
                $data['reward'] = $reward['result'];
            } else {
                return back()->withErrors(['Reward not found.']);
            }
            return view('reward::detail', $data);
        } else {
            if (isset($post['reward_image'])) {
                $post['reward_image'] = MyHelper::encodeImage($post['reward_image']);
            }

            $save = MyHelper::post('reward/update', $post);

            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('reward/detail/' . $slug)->withSuccess(['Reward has been updated.']);
            } else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    public function delete(Request $request)
    {
        $post    = $request->except('_token');
        $reward = MyHelper::post('reward/delete', ['id_reward' => $post['id_reward']]);

        if (isset($reward['status']) && $reward['status'] == "success") {
            return "success";
        } elseif (isset($reward['status']) && $reward['status'] == "fail" && isset($reward['messages']) && $reward['messages'][0] == 'Reward already used.') {
            return "used";
        } else {
            return "fail";
        }
    }

    public function setWinner(Request $request)
    {
        $post = $request->except('_token');

        $save = MyHelper::post('reward/winner', $post);

        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('reward/detail/' . $post['id_reward'] . '#winner')->withSuccess(['Winner has been updated.']);
        } else {
            if (isset($save['errors'])) {
                return back()->withErrors($save['errors'])->withInput();
            }

            if (isset($save['status']) && $save['status'] == "fail") {
                return back()->withErrors($save['messages'])->withInput();
            }
            return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
        }
    }
}
