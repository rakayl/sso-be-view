<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;

class WebviewUserController extends Controller
{
    // get webview form
    public function completeProfile(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }
        $data['bearer'] = $bearer;

        $user = parent::getData(MyHelper::getWithBearer('users/get', $bearer));
        $data['user'] = [];

        if (!empty($user)) {
            $data['cities'] = parent::getData(MyHelper::get('city/list'));

            // get only some data
            if ($user) {
                $user_data['gender']   = $user['gender'];
                $user_data['birthday'] = $user['birthday'];
                $user_data['id_city']  = $user['id_city'];
                // $user_data['relationship'] = $user['relationship'];

                //jika sudah complete lempar ke halaman success
                if ($user['birthday'] != null && $user['gender'] != null && $user['id_city'] != null) {
                    return redirect('webview/complete-profile/success#true');
                }

                $data['user'] = $user_data;
            }
        }

        return view('users::webview_complete_profile', $data);
    }

    public function completeProfileSubmit(Request $request)
    {
        $post = $request->except('_token');
        $bearer = $post['bearer'];
        unset($post['bearer']);
        // manual validation
        if ($post['gender'] == "" || $post['date'] == "" || $post['month'] == "" || $post['year'] == "" || $post['id_city'] == "") {
            // manually redirect back
            $data['errors'] = ['Submit data gagal.', 'Silakan ulangi lagi.'];

            $data['bearer'] = $bearer;

            $user_data = $this->getUser($bearer);
            $data['user'] = $user_data;

            $data['cities'] = parent::getData(MyHelper::get('city/list'));

            return view('users::webview_complete_profile', $data);
        }

        // date format
        $post['birthday'] = $post['year'] . "-" . $post['month'] . "-" . $post['date'];
        $post['birthday'] = date('Y-m-d', strtotime($post['birthday']));
        unset($post['date']);
        unset($post['month']);
        unset($post['year']);

        $result = MyHelper::postWithBearer('users/complete-profile', $post, $bearer);

        if (isset($result['status']) && $result['status'] == "success") {
            // $data['content'] = $result['result'];
            // return view('users::webview_complete_profile_success', $data);
            return redirect('webview/complete-profile/success#true');
        } else {
            // manually redirect back
            $data['errors'] = ['Submit data gagal.', 'Silakan ulangi lagi.'];

            $data['bearer'] = $bearer;

            $user_data = $this->getUser($bearer);
            $data['user'] = $user_data;

            $data['cities'] = parent::getData(MyHelper::get('city/list'));

            return view('users::webview_complete_profile', $data);
        }
    }

    private function getUser($bearer)
    {
        $user = parent::getData(MyHelper::getWithBearer('users/get', $bearer));
        $user_data = [];

        if (!empty($user)) {
            // get only some data
            if ($user) {
                $user_data['gender']   = $user['gender'];
                $user_data['birthday'] = $user['birthday'];
                $user_data['id_city']  = $user['id_city'];
                // $user_data['relationship'] = $user['relationship'];
            }
        }
        return $user_data;
    }

    public function completeProfileSuccess()
    {
        $messages = MyHelper::get('users/complete-profile/success-message');

        $data['content'] = '';
        if ($messages['status'] == 'success') {
            $data['content'] = $messages['result'];
        }

        return view('users::webview_complete_profile_success', $data);
    }
}
