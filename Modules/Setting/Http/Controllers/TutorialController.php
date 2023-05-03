<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;

class TutorialController extends Controller
{
    public function introList($key)
    {
        if ($key == 'first') {
            $sub = 'setting-intro-first';
            $active = 'setting-intro';
            $subTitle = 'Intro First Install';
            $key = 'intro_' . $key;
        } elseif ($key == 'home') {
            $sub = 'setting-intro-home';
            $active = 'setting-intro';
            $subTitle = 'Tutorial at Home Page';
            $key = 'intro_' . $key;
        }

        $data = [
            'title'          => 'Setting',
            'menu_active'    => $active,
            'submenu_active' => $sub,
            'sub_title'      => $subTitle,
            'key'            => $key
        ];

        $request = MyHelper::post('setting/intro', ['key' => $key]);

        if (isset($request['status']) && $request['status'] == 'success') {
            $result = $request['result'];
            $grantedFeature     = session('granted_features');

            if (MyHelper::hasAccess([168, 169, 170, 171], $grantedFeature)) {
                if (isset($result['value_text']) && $result['value_text'] != 'null') {
                    foreach (json_decode($result['value_text']) as $key => $value) {
                        $data['value_text'][$key] = $value;
                    }
                }
                $data['value'] = json_decode($result['value'], true);
                return view('setting::intro', $data);
            } else {
                return redirect('/');
            }
        } else {
            return view('setting::intro', $data)->withErrors($request['messages']);
        }
    }

    public function introStore(Request $request)
    {
        $post = $request->except('_token');

        $data['key'] = $post['key'];
        $data['value'] = json_encode([
            'active'        => (isset($post['active']) && $post['active'] == 'on') ? 1 : 0,
            'skippable'     => (isset($post['skippable']) && $post['skippable'] == 'on') ? 1 : 0,
            'text_next'     => $post['text_next'],
            'text_previous' => $post['text_previous'],
            'text_skip'     => $post['text_skip']
        ]);

        if (isset($post['value_text']) && $post['value_text'] != null) {
            foreach ($post['value_text'] as $value) {
                if (is_file($value['value_text'])) {
                    $data['value_text'][] = MyHelper::encodeImage($value['value_text']);
                } else {
                    $data['value_text'][] = $value['value_text'];
                }
            }
        }

        $insert = MyHelper::post('setting/intro/save', $data);

        return parent::redirect($insert, 'Tutorial has been updated.');
    }
}
