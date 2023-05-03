<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SettingController extends Controller
{
    public function faqWebview(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        $faqList = MyHelper::getWithBearer('setting/faq?log_save=0', $bearer);
        if (isset($faqList['result'])) {
            return view('setting::webview.faq', ['faq' => $faqList['result']]);
        } else {
            return view('setting::webview.faq', ['faq' => null]);
        }
    }

    public function aboutWebview($key, Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        $data = MyHelper::postWithBearer('setting/webview', ['key' => $key, 'data' => 1], $bearer);
        if (isset($data['status']) && $data['status'] == 'success') {
            if ($data['result']['value_text']) {
                $data['value'] = preg_replace('/face="[^;"]*(")?/', 'div class="seravek-light-font"', $data['result']['value_text']);
                $data['value'] = preg_replace('/face="[^;"]*(")?/', '', $data['value']);
            }

            if ($data['result']['value']) {
                $data['value'] = preg_replace('/<\/font>?/', '</div>', $data['value']);
            }
        } else {
            $data['value'] = null;
        }
        return view('setting::webview.about', $data);
    }

    public function appLogoSave(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['app_logo'])) {
            $post['app_logo'] = MyHelper::encodeImage($post['app_logo']);
        }
        // print_r($post);exit;
        $result = MyHelper::post('setting/app_logo', $post);
        // print_r($result);exit;
        return parent::redirect($result, 'Default Application Logo has been updated.');
    }

    public function appSidebarSave(Request $request)
    {
        $post   = $request->except('_token');
        $result = MyHelper::post('setting/app_sidebar', $post);
        return parent::redirect($result, 'Application Side Navigation Text has been updated.');
    }

    public function appNavbarSave(Request $request)
    {
        $post   = $request->except('_token');
        $result = MyHelper::post('setting/app_navbar', $post);
        return parent::redirect($result, 'Application Top Navigation Text has been updated.');
    }

    public function userInboxSave(Request $request)
    {
        $post   = $request->except('_token');
        $result = MyHelper::post('setting/update2', ['update' => ['inbox_max_days' => ['value', $post['inbox_max_days']]]]);
        return parent::redirect($result, 'User Inbox setting has been updated.', 'setting/home#user_inbox');
    }

    public function settingList($key)
    {
        $data = [];

        $colLabel = 2;
        $colInput = 10;
        $label    = '';

        if ($key == 'about') {
            $sub      = 'about-about';
            $active   = 'about';
            $subTitle = 'About Us';
            $label    = 'About';
        } elseif ($key == 'tos') {
            $sub      = 'about-tos';
            $active   = 'tos';
            $subTitle = 'Ketentuan Layanan';
            $label    = 'Ketentuan Layanan';
        } elseif ($key == 'tax') {
            $sub      = 'about-tax';
            $active   = 'tax';
            $subTitle = 'Tax';
            $label    = 'Tax';
        } elseif ($key == 'service') {
            $sub      = 'about-service';
            $active   = 'service';
            $subTitle = 'Service';
            $label    = 'Service';
        } elseif ($key == 'contact') {
            $sub      = 'contact-us';
            $active   = 'contact';
            $subTitle = 'Contact Us';
            $label    = 'Contact Us';
        } elseif ($key == 'processing_time') {
            $sub      = 'transaction-processing';
            $active   = 'order';
            $subTitle = 'Processing Time';
            $label    = 'Time';
            $span     = 'minutes';
            $colInput = 3;
        } elseif ($key == 'qrcode_expired') {
            $sub      = 'expired-qrcode';
            $active   = 'expired-qrcode';
            $subTitle = 'Expired QR Code';
            $label    = 'QR Code expires in';
            $span     = 'minutes';
            $colLabel = 3;
            $colInput = 3;
        } elseif ($key == 'count_login_failed') {
            $sub      = 'count-login-failed';
            $active   = 'count-login-failed';
            $subTitle = 'Count Login Failed';
            $label    = 'Response Failed login will be sent after the user has failed to login ';
            $span     = 'times';
            $colLabel = 7;
            $colInput = 2;
        } elseif ($key == 'point_reset') {
            $sub      = 'point-reset';
            $active   = 'point-reset';
            $subTitle = 'Point Reset';
        } elseif ($key == 'max_order') {
            $span     = 'item';
            $colInput = 3;
            $colLabel = 3;
            $sub      = 'default-max-order';
            $active   = 'default-max-order';
            $subTitle = 'Default Max Order';
        } elseif ($key == 'balance_reset') {
            $sub      = 'balance-reset';
            $active   = 'balance-reset';
            $subTitle = env('POINT_NAME', 'Points') . ' Reset';
        } elseif ($key == 'default_outlet') {
            $sub      = 'default-outlet';
            $active   = 'outlet';
            $subTitle = 'Default Outlet';
            $colInput = 4;
            $colLabel = 3;
        } elseif ($key == 'credit_card_payment_gateway') {
            $sub      = 'credit_card_payment_gateway';
            $active   = 'order';
            $subTitle = 'Credit Card Payment Gateway';
            $label    = 'Payment Gateway';
            $span     = 'credit_card_payment_gateway';
            $colInput = 4;
            $colLabel = 3;
        } elseif ($key == 'consultation_option_setting') {
            $sub      = 'consultation-option-settings';
            $active   = 'consultation-option-settings';
            $subTitle = 'Consultation Option Setting';
        } elseif ($key == 'consultation_setting') {
            $sub      = 'consultation-settings';
            $active   = 'consultation-settings';
            $subTitle = 'Consultation Setting';
        } elseif ($key == 'privacypolicy') {
            $sub      = 'about-privacy-policy';
            $active   = 'privacy-policy';
            $subTitle = 'Kebijakan Privasi';
            $label    = 'Kebijakan Privasi';
            $span     = '';
        } elseif ($key == 'privacypolicydoctor') {
            $sub      = 'about-privacy-policy-doctor';
            $active   = 'privacy-policy-doctor';
            $subTitle = 'Kebijakan Privasi Doctor Apps';
            $label    = 'Kebijakan Privasi Doctor Apps';
            $span     = '';
        }

        $data = [
            'title'          => 'Setting',
            'menu_active'    => $active,
            'submenu_active' => $sub,
            'sub_title'      => $subTitle,
            'subTitle'       => $subTitle,
            'label'          => $label,
            'colLabel'       => $colLabel,
            'colInput'       => $colInput,
        ];

        if (isset($span)) {
            $data['span'] = $span;
        }

        if ($key == 'point_reset' || $key == 'balance_reset') {
            $request = MyHelper::post('setting', ['key-like' => $key]);
            if (isset($request['status']) && $request['status'] == 'success') {
                $data['result'] = $request['result'];
                return view('setting::point-reset', $data);
            // } elseif (isset($request['status']) && $request['messages'][0] == 'empty') {
            // return view('setting::point-reset', $data);
            } else {
                return view('setting::point-reset', $data);
                // return view('setting::point-reset', $data)->withErrors($request['messages']);
            }
        } elseif ($key == 'default_outlet') {
            $data['outlets'] = MyHelper::get('outlet/be/list')['result'] ?? [];
            $result          = MyHelper::post('setting', ['key' => $key])['result'] ?? false;
            $data['id']      = $result['id_setting'];
            $data['value']   = $result['value'];
            $data['key']     = 'value';
            return view('setting::default_outlet', $data);
        } elseif ($key == 'consultation_option_setting') {
            $result                      = [];
            $diagnosis                   = MyHelper::post('setting', ['key' => 'diagnosis']);
            $complaints                  = MyHelper::post('setting', ['key' => 'complaints']);
            $usage_rules                 = MyHelper::post('setting', ['key' => 'usage_rules']);
            $usage_rules_time            = MyHelper::post('setting', ['key' => 'usage_rules_time']);
            $usage_rules_additional_time = MyHelper::post('setting', ['key' => 'usage_rules_additional_time']);

            if (isset($diagnosis['status']) && $diagnosis['status'] == 'success') {
                $result['diagnosis']               = $diagnosis['result'];
                $result['diagnosis']['value_text'] = json_decode($diagnosis['result']['value_text']);
            }

            if (isset($complaints['status']) && $complaints['status'] == 'success') {
                $result['complaints']               = $complaints['result'];
                $result['complaints']['value_text'] = json_decode($complaints['result']['value_text']);
            }

            if (isset($usage_rules['status']) && $usage_rules['status'] == 'success') {
                $result['usage_rules']               = $usage_rules['result'];
                $result['usage_rules']['value_text'] = json_decode($usage_rules['result']['value_text']);
            }

            if (isset($usage_rules_time['status']) && $usage_rules_time['status'] == 'success') {
                $result['usage_rules_time']               = $usage_rules_time['result'];
                $result['usage_rules_time']['value_text'] = json_decode($usage_rules_time['result']['value_text']);
            }

            if (isset($usage_rules_additional_time['status']) && $usage_rules_additional_time['status'] == 'success') {
                $result['usage_rules_additional_time']               = $usage_rules_additional_time['result'];
                $result['usage_rules_additional_time']['value_text'] = json_decode($usage_rules_additional_time['result']['value_text']);
            }

            if (!empty($result)) {
                $data['result'] = $result;
            }

            return view('setting::consultation_option_setting', $data);
        } elseif ($key == 'consultation_setting') {
            $result                    = [];
            $max_consultation          = MyHelper::post('setting', ['key' => 'max_consultation_quota']);
            $consultation_starts_early = MyHelper::post('setting', ['key' => 'consultation_starts_early']);
            $consultation_starts_late  = MyHelper::post('setting', ['key' => 'consultation_starts_late']);
            $max_reschedule_settings   = MyHelper::post('setting', ['key' => 'max_reschedule_settings']);
            $min_session_consultation_now  = MyHelper::post('setting', ['key' => 'min_session_consultation_now']);

            if (isset($max_consultation['status']) && $max_consultation['status'] == 'success') {
                $result['max_consultation_quota'] = $max_consultation['result'];
            }

            if (isset($consultation_starts_early['status']) && $consultation_starts_early['status'] == 'success') {
                $result['consultation_starts_early'] = $consultation_starts_early['result'];
            }

            if (isset($consultation_starts_late['status']) && $consultation_starts_late['status'] == 'success') {
                $result['consultation_starts_late'] = $consultation_starts_late['result'];
            }

            if (isset($max_reschedule_settings['status']) && $max_reschedule_settings['status'] == 'success') {
                $result['max_reschedule_settings'] = $max_reschedule_settings['result'];
            }

            if (isset($min_session_consultation_now['status']) && $min_session_consultation_now['status'] == 'success') {
                $result['min_session_consultation_now'] = $min_session_consultation_now['result'];
            }

            if (!empty($result)) {
                $data['result'] = $result;
            }

            return view('setting::consultation_setting', $data);
        } else {
            $request = MyHelper::post('setting', ['key' => $key]);

            if (isset($request['status']) && $request['status'] == 'success') {
                $result     = $request['result'];
                $data['id'] = $result['id_setting'];

                if (is_null($result['value'])) {
                    $data['value'] = $result['value_text'];
                    $data['key']   = 'value_text';
                } else {
                    $data['value'] = $result['value'];
                    $data['key']   = 'value';
                }
            } else {
                return view('setting::index', $data)->withErrors($request['messages']);
            }

            return view('setting::index', $data);
        }
    }

    public function settingUpdate(Request $request, $id)
    {
        $post = $request->except('_token');

        $update = MyHelper::post('setting/update', ['id_setting' => $id, $post['key'] => $post['value']]);

        return parent::redirect($update, 'Setting data has been updated.');
    }

    public function updatePointReset(Request $request, $type)
    {
        $post = $request->except('_token');

        $update = MyHelper::post('setting/reset/' . $type . '/update', $post);
        return parent::redirect($update, 'Setting data has been updated.');
    }

    public function updateConsultationSetting(Request $request, $type)
    {
        $post = $request->except('_token');

        if (empty($post['value_text'])) {
            return redirect('setting/consultation_option_setting#usage_rules')->witherrors(['Aturan dosis tidak boleh kosong']);
        }

        if (str_contains($type, 'usage_rules') !== false || strpos($type, 'diagnosis') !== false || strpos($type, 'complaints') !== false) {
            $post['value_text'] = json_encode($post['value_text']);
        }

        $update = MyHelper::post('setting/consultation/' . $type . '/update', $post);
        return parent::redirect($update, 'Setting data has been updated.');
    }

    public function faqList()
    {
        $data = [];
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-list',
        ];

        $faqList = MyHelper::get('setting/be/faq');

        if (isset($faqList['status']) && $faqList['status'] == 'success') {
            $data['result'] = array_map(function ($var) {
                $var['id_faq'] = MyHelper::createSlug($var['id_faq'], $var['created_at']);
                return $var;
            }, $faqList['result']);
        } else {
            if (isset($faqList['status']) && $faqList['status'] == 'fail') {
                $data['result'] = [];
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
                return view('setting::faqList', $data)->withErrors($e);
            }
        }

        return view('setting::faqList', $data);
    }

    public function faqCreate()
    {
        $data = [];
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-new',
        ];

        return view('setting::faqCreate', $data);
    }

    public function faqStore(Request $request)
    {
        $data = $request->except('_token');

        $insert = MyHelper::post('setting/faq/create', $data);

        return parent::redirect($insert, 'FAQ has been created.');
    }

    /*======== This function is used to display the FAQ list that will be sorted ========*/
    public function faqSort()
    {
        $data = [];
        $data = [
            'title'          => 'Sorting FAQ List',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-sort',
        ];

        $faqList = MyHelper::get('setting/be/faq');

        if (isset($faqList['status']) && $faqList['status'] == 'success') {
            $data['result'] = $faqList['result'];
        } else {
            if (isset($faqList['status']) && $faqList['status'] == 'fail') {
                $data['result'] = [];
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
                return view('setting::faqList', $data)->withErrors($e);
            }
        }
        return view('setting::faqSort', $data);
    }

    public function faqSortUpdate(Request $request)
    {
        $post   = $request->except('_token');
        $status = 0;
        $update = MyHelper::post('setting/faq/sort/update', $post);
        if (isset($update['status']) && $update['status'] == 'success') {
            $status = 1;
        }

        return response()->json(['status' => $status]);
    }

    public function faqEdit($slug)
    {
        $exploded   = MyHelper::explodeSlug($slug);
        $id         = $exploded[0];
        $created_at = $exploded[1];
        $data       = [];
        $data       = [
            'title'          => 'Setting',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-list',
        ];

        $edit = MyHelper::post('setting/faq/edit', ['id_faq' => $id, 'created_at' => $created_at]);

        if (isset($edit['status']) && $edit['status'] == 'success') {
            $data['faq'] = $edit['result'];
            if (isset($data['faq']['id_faq'])) {
                $data['faq']['id_faq'] = $slug;
            }
            return view('setting::faqEdit', $data);
        } else {
            $e = ['e' => 'Something went wrong. Please try again.'];

            return back()->witherrors($e);
        }
    }

    public function faqUpdate(Request $request, $slug)
    {
        $exploded   = MyHelper::explodeSlug($slug);
        $id         = $exploded[0];
        $created_at = $exploded[1];
        $post       = [
            'id_faq'     => $id,
            'question'   => $request['question'],
            'answer'     => $request['answer'],
            'created_at' => $created_at,
        ];

        $update = MyHelper::post('setting/faq/update', $post);

        return parent::redirect($update, 'FAQ has been updated.');
    }

    public function faqDelete($slug)
    {
        $exploded   = MyHelper::explodeSlug($slug);
        $id         = $exploded[0];
        $created_at = $exploded[1];
        $delete     = MyHelper::post('setting/faq/delete', ['id_faq' => $id, 'created_at', $created_at]);

        return parent::redirect($delete, 'FAQ has been deleted.');
    }

    public function faqDoctorList()
    {
        $data = [];
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-doctor-list',
        ];

        $faqList = MyHelper::get('setting/be/faq-doctor');

        if (isset($faqList['status']) && $faqList['status'] == 'success') {
            $data['result'] = array_map(function ($var) {
                $var['id_faq_doctor'] = MyHelper::createSlug($var['id_faq_doctor'], $var['created_at']);
                return $var;
            }, $faqList['result']);
        } else {
            if (isset($faqList['status']) && $faqList['status'] == 'fail') {
                $data['result'] = [];
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
                return view('setting::faqDoctorList', $data)->withErrors($e);
            }
        }

        return view('setting::faqDoctorList', $data);
    }

    public function faqDoctorCreate()
    {
        $data = [];
        $data = [
            'title'          => 'Setting',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-doctor-new',
        ];

        return view('setting::faqDoctorCreate', $data);
    }

    public function faqDoctorStore(Request $request)
    {
        $data = $request->except('_token');

        $insert = MyHelper::post('setting/faq-doctor/create', $data);

        return parent::redirect($insert, 'FAQ has been created.');
    }

    /*======== This function is used to display the FAQ list that will be sorted ========*/
    public function faqDoctorSort()
    {
        $data = [];
        $data = [
            'title'          => 'Sorting FAQ List',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-doctor-sort',
        ];

        $faqList = MyHelper::get('setting/be/faq-doctor');

        if (isset($faqList['status']) && $faqList['status'] == 'success') {
            $data['result'] = $faqList['result'];
        } else {
            if (isset($faqList['status']) && $faqList['status'] == 'fail') {
                $data['result'] = [];
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
                return view('setting::faqDoctorList', $data)->withErrors($e);
            }
        }
        return view('setting::faqDoctorSort', $data);
    }

    public function faqDoctorSortUpdate(Request $request)
    {
        $post   = $request->except('_token');
        $status = 0;
        $update = MyHelper::post('setting/faq-doctor/sort/update', $post);
        if (isset($update['status']) && $update['status'] == 'success') {
            $status = 1;
        }

        return response()->json(['status' => $status]);
    }

    public function faqDoctorEdit($slug)
    {
        $exploded   = MyHelper::explodeSlug($slug);
        $id         = $exploded[0];
        $created_at = $exploded[1];
        $data       = [];
        $data       = [
            'title'          => 'Setting',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-doctor-list',
        ];

        $edit = MyHelper::post('setting/faq-doctor/edit', ['id_faq_doctor' => $id, 'created_at' => $created_at]);

        if (isset($edit['status']) && $edit['status'] == 'success') {
            $data['faq'] = $edit['result'];
            if (isset($data['faq']['id_faq_doctor'])) {
                $data['faq']['id_faq_doctor'] = $slug;
            }
            return view('setting::faqDoctorEdit', $data);
        } else {
            $e = ['e' => 'Something went wrong. Please try again.'];

            return back()->witherrors($e);
        }
    }

    public function faqDoctorUpdate(Request $request, $slug)
    {
        $exploded   = MyHelper::explodeSlug($slug);
        $id         = $exploded[0];
        $created_at = $exploded[1];
        $post       = [
            'id_faq_doctor' => $id,
            'question'      => $request['question'],
            'answer'        => $request['answer'],
            'created_at'    => $created_at,
        ];

        $update = MyHelper::post('setting/faq-doctor/update', $post);

        return parent::redirect($update, 'FAQ has been updated.');
    }

    public function faqDoctorDelete($slug)
    {
        $exploded   = MyHelper::explodeSlug($slug);
        $id         = $exploded[0];
        $created_at = $exploded[1];
        $delete     = MyHelper::post('setting/faq-doctor/delete', ['id_faq_doctor' => $id, 'created_at', $created_at]);

        return parent::redirect($delete, 'FAQ has been deleted.');
    }

    public function levelList()
    {
        $data = [];
        $data = [
            'title'          => 'Level',
            'menu_active'    => 'level',
            'submenu_active' => 'level-list',
        ];

        $level = MyHelper::get('setting/level');

        if (isset($level['status']) && $level['status'] == 'success') {
            $data['result'] = $level['result'];
        } else {
            if (isset($level['status']) && $level['status'] == 'fail') {
                $data['result'] = [];
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
                return view('setting::level.levelList', $data)->withErrors($e);
            }
        }

        return view('setting::level.levelList', $data);
    }

    public function levelCreate()
    {
        $data = [];
        $data = [
            'title'          => 'Level',
            'menu_active'    => 'level',
            'submenu_active' => 'level-create',
        ];

        return view('setting::level.levelCreate', $data);
    }

    public function levelStore(Request $request)
    {
        $data = $request->except('_token');

        $insert = MyHelper::post('setting/level/create', $data);

        return parent::redirect($insert, 'Level has been created.');
    }

    public function levelEdit($id)
    {
        $data = [];
        $data = [
            'title'          => 'Level',
            'menu_active'    => 'level',
            'submenu_active' => 'level-list',
        ];

        $edit = MyHelper::post('setting/level/edit', ['id_level' => $id]);

        if (isset($edit['status']) && $edit['status'] == 'success') {
            $data['level'] = $edit['result'];
            return view('setting::level.levelEdit', $data);
        } else {
            if (isset($edit['status']) && $edit['status'] == 'fail') {
                $e = $edit['messages'];
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
            }

            return back()->witherrors($e);
        }
    }

    public function levelUpdate(Request $request, $id)
    {
        $post = [
            'id_level'          => $id,
            'level_name'        => $request['level_name'],
            'level_parameters'  => $request['level_parameters'],
            'level_range_start' => $request['level_range_start'],
            'level_range_end'   => $request['level_range_end'],
        ];

        $update = MyHelper::post('setting/level/update', $post);

        return parent::redirect($update, 'Level has been updated.');
    }

    public function levelDelete($id)
    {
        $delete = MyHelper::post('setting/level/delete', ['id_level' => $id]);

        return parent::redirect($delete, 'Level has been deleted.');
    }

    public function holidayList()
    {
        $data = [];
        $data = [
            'title'          => 'Holiday',
            'menu_active'    => 'holiday',
            'submenu_active' => 'holiday-list',
        ];

        $holiday = MyHelper::get('setting/holiday');
        // print_r($holiday);exit;
        if (isset($holiday['status']) && $holiday['status'] == 'success') {
            $data['result'] = $holiday['result'];
        } else {
            if (isset($holiday['status']) && $holiday['status'] == 'fail') {
                $data['result'] = [];
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
                return view('setting::holiday.holidayList', $data)->withErrors($e);
            }
        }

        return view('setting::holiday.holidayList', $data);
    }

    public function holidayCreate()
    {
        $data = [];
        $data = [
            'title'          => 'Holiday',
            'menu_active'    => 'holiday',
            'submenu_active' => 'holiday-create',
        ];

        $outlet = MyHelper::post('setting/holiday/create', $data);

        if (isset($outlet['status']) && $outlet['status'] == 'success') {
            $data['outlet'] = $outlet['result'];
        } else {
            if (isset($outlet['status']) && $outlet['status'] == 'fail') {
                $e = 'Outlet is empty, have to create outlet first';
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
            }

            return back()->witherrors($e);
        }

        return view('setting::holiday.holidayCreate', $data);
    }

    public function holidayStore(Request $request)
    {
        $data = $request->except('_token');

        $insert = MyHelper::post('setting/holiday/store', $data);

        return parent::redirect($insert, 'Holiday has been created.');
    }

    public function holidayEdit($id)
    {
        $data = [];
        $data = [
            'title'          => 'Holiday',
            'menu_active'    => 'holiday',
            'submenu_active' => 'holiday-list',
        ];

        $edit = MyHelper::post('setting/holiday/edit', ['id_holiday' => $id]);

        if (isset($edit['status']) && $edit['status'] == 'success') {
            $data['holiday'] = $edit['result'];
            return view('setting::holiday.holidayEdit', $data);
        } else {
            if (isset($edit['status']) && $edit['status'] == 'fail') {
                $e = $edit['messages'];
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
            }

            return back()->witherrors($e);
        }
    }

    public function holidayUpdate(Request $request, $id)
    {
        $post = [
            'id_holiday'   => $id,
            'holiday_name' => $request['holiday_name'],
            'day'          => $request['day'],
            'id_outlet'    => $request['id_outlet'],
        ];

        $update = MyHelper::post('setting/holiday/update', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            session(['success' => ['Holiday data updated']]);
            return redirect('setting/holiday');
        } else {
            if (isset($update['status']) && $update['status'] == 'fail') {
                $e = $update['messages'];
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
            }

            return back()->witherrors($e);
        }
    }

    public function holidayDelete($id)
    {
        $delete = MyHelper::post('setting/holiday/delete', ['id_holiday' => $id]);

        return parent::redirect($delete, 'Holiday has been deleted.');
    }

    public function holidayDetail($id)
    {
        $data = [];
        $data = [
            'title'          => 'Holiday',
            'menu_active'    => 'global',
            'submenu_active' => 'global-holiday',
        ];

        $detail = MyHelper::post('setting/holiday/detail', ['id_holiday' => $id]);

        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data['result'] = $detail['result'];
        } else {
            if (isset($detail['status']) && $detail['status'] == 'fail') {
                $data['result'] = [];
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
                return view('setting::holiday.holidayDetail', $data)->withErrors($e);
            }
        }

        return view('setting::holiday.holidayDetail', $data);
    }

    public function homeSetting(Request $request)
    {
        $post = $request->except('_token');
        if ($post) {
            $request = MyHelper::post('timesetting', $post);
            // print_r($request);exit;
            session(['success' => ['Time Setting Updated']]);
        }
        $data = [
        'title'          => 'Mobile Apps Home Setting',
        'menu_active'    => 'setting-home',
        'submenu_active' => 'setting-home-list',
        ];

        $request = MyHelper::get('timesetting');

        if (isset($request['result'])) {
            $data['timesetting'] = $request['result'];
        } else {
            $data['timesetting'] = [];
        }

        $request = MyHelper::get('greetings');

        if (isset($request['result'])) {
            $data['greetings'] = $request['result'];
        } else {
            $data['greetings'] = [];
        }

        $request = MyHelper::get('background');
        if (isset($request['result'])) {
            $data['background'] = $request['result'];
        } else {
            $data['background'] = [];
        }

        $test = MyHelper::get('autocrm/textreplace');

        if ($test['status'] == 'success') {
            $data['textreplaces'] = $test['result'];
        }

        // banner
        $request = MyHelper::get('setting/banner/list');
        if (isset($request['result'])) {
            $data['banners'] = $request['result'];
        } else {
            $data['banners'] = [];
        }

        // featured deals
        $request = MyHelper::get('setting/featured_deal/list');
        if (isset($request['result'])) {
            $data['featured_deals'] = $request['result'];
        } else {
            $data['featured_deals'] = [];
        }

        // featured subscription
        $request = MyHelper::get('setting/featured_subscription/list');
        if (isset($request['result'])) {
            $data['featured_subscriptions'] = $request['result'];
        } else {
            $data['featured_subscriptions'] = [];
        }

        // featured promo campaign
        $data['featured_promo_campaigns'] = MyHelper::get('setting/featured_promo_campaign/list')['result'] ?? [];

        // subscription
        $sp                    = ['select' => ['id_subscription', 'subscription_title']];
        $request               = MyHelper::post('subscription/be/list-complete', $sp);
        $data['subscriptions'] = $request['result'] ?? [];

        // deals
        $dp            = ['deals_type' => 'Deals', 'forSelect2' => true, 'featured' => true];
        $request       = MyHelper::post('deals/be/list', $dp);
        $data['deals'] = $request['result'] ?? [];

        // promo campaign
        $data['all_promo']       = MyHelper::get('promo-campaign/active-campaign')['result'] ?? [];
        $data['promo_campaigns'] = MyHelper::get('promo-campaign/active-campaign?featured=true&featured_type=home')['result'] ?? [];

        // news for banner
        $news_req = [
        'published' => 1,
        'admin'     => 1,
        ];
        $request = MyHelper::post('news/be/list', $news_req);
        if (isset($request['result'])) {
            $data['news'] = $request['result'];
        } else {
            $data['news'] = [];
        }

        // complete profile
        $request = MyHelper::get('setting/be/complete-profile');
        if (isset($request['result'])) {
            $data['complete_profile'] = $request['result'];
        } else {
            $data['complete_profile'] = [
                'complete_profile_point'        => '',
                'complete_profile_cashback'     => '',
                'complete_profile_count'        => '',
                'complete_profile_interval'     => '',
                'complete_profile_success_page' => '',
            ];
        }

        //product detail
        $pp               = ['select' => ['id_product', 'product_name', 'product_code']];
        $request          = MyHelper::post('product/be/list', $pp);
        $data['products'] = $request['result'] ?? [];

        //merchant detail
        $mp                = ['select' => ['id_merchant', 'merchant_pic_name']];
        $request           = MyHelper::post('merchant/list-setting', $mp);
        $data['merchants'] = $request['result'] ?? [];

        //doctor detail
        $dcp             = ['select' => ['id_doctor', 'doctor_name']];
        $request         = MyHelper::post('doctor', $dcp);
        $data['doctors'] = $request['result'] ?? [];

        $data['default_home']        = parent::getData(MyHelper::get('setting/default_home'));
        $data['default_home_doctor'] = parent::getData(MyHelper::get('setting/default_home_doctor'));
        $data['app_logo']            = parent::getData(MyHelper::get('setting/app_logo'));
        $data['app_sidebar']         = parent::getData(MyHelper::get('setting/app_sidebar'));
        $data['app_navbar']          = parent::getData(MyHelper::get('setting/app_navbar'));
        $data['inbox_max_days']      = parent::getData(MyHelper::post('setting', ['key' => 'inbox_max_days']))['value'] ?? 30;
        // dd($data);
        return view('setting::home', $data);
    }

    public function createGreeting(Request $request)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            $create = MyHelper::post('greetings/create', $post);

            if ($create['status'] == 'success') {
                session(['success' => ['New greeting text created']]);
                return redirect('setting/home');
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
                return redirect('setting/home')->withErrors($e);
            }
        }
    }

    public function createBackground(Request $request)
    {
        $post = $request->except('_token');
        if (!empty($post)) {
            if (isset($post['background'])) {
                $post['background'] = MyHelper::encodeImage($post['background']);
            }
            $result = MyHelper::post('background/create', $post);
            // print_r($result);exit;
            session(['success' => ['New greeting background created']]);
            return redirect('setting/home');
        }
    }

    public function deleteBackground(Request $request)
    {
        $post = $request->except('_token');
        if (!empty($post)) {
            $result = MyHelper::post('background/delete', $post);
            if ($result['status'] == 'success') {
                session(['success' => ['Home Background data deleted']]);
                return redirect('setting/home');
            } else {
                return redirect('setting/home')->withErrors($request['messages']);
            }
            return redirect('setting/home');
        }
    }

    public function updateGreetings(Request $request, $id)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            $data                 = $post;
            $data['id_greetings'] = $id;

            $query = MyHelper::post('greetings/update', $data);
            if ($query['status'] == 'success') {
                session(['success' => ['Greeting data updated']]);
                return redirect('setting/home');
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
                return redirect('setting/home')->withErrors($e);
            }
        }
    }
    public function deleteGreetings(Request $request)
    {
        $post = $request->except('_token');

        if (!empty($post)) {
            $query = MyHelper::post('greetings/delete', $post);
            if ($query['status'] == 'success') {
                session(['success' => ['Greeting data deleted']]);
                return redirect('setting/home');
            } else {
                return redirect('setting/home')->withErrors($request['messages']);
            }
        } else {
            return redirect('setting/home')->withErrors(['ID Tidak ditemukan']);
        }
    }

    public function dateSetting(Request $request)
    {
        $post = $request->except('_token');

        $update = MyHelper::post('setting/date', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            session(['success' => ['Date limit updated']]);
            return redirect('queue');
        } else {
            if (isset($update['status']) && $update['status'] == 'fail') {
                $e = $update['messages'];
            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
            }

            return back()->witherrors($e);
        }
    }

    public function settingEmail(Request $request)
    {
        $post = $request->except('_token');
        if (empty($post)) {
            $data = ['title' => 'Email Header Footer',
            'menu_active'    => 'crm-setting',
            'submenu_active' => 'email',
            ];

            $setting = MyHelper::get('setting/email');

            if ($setting['status'] == 'success') {
                $data['setting'] = $setting['result'];
            }
            return view('setting::setting_email', $data);
        } else {
            if (isset($post['email_logo'])) {
                $post['email_logo'] = MyHelper::encodeImage($post['email_logo']);
            }
            $update = MyHelper::post('setting/email', $post);
            if ($update['status'] == 'success') {
                return back()->with('success', ['Setting Email has been updated']);
            } else {
                if (isset($update['errors'])) {
                    return back()->withErrors($update['errors'])->withInput();
                }

                if (isset($update['status']) && $update['status'] == "fail") {
                    return back()->withErrors($update['messages'])->withInput();
                }

                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    public function defaultHomeSave(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['default_home_image'])) {
            $post['default_home_image'] = MyHelper::encodeImage($post['default_home_image']);
        }
        if (isset($post['default_home_splash_screen'])) {
            $post['default_home_splash_screen'] = MyHelper::encodeImage($post['default_home_splash_screen']);
        }

        if (isset($post['default_home_splash_duration'])) {
            if ($post['default_home_splash_duration'] < 1) {
                $post['default_home_splash_duration'] = 1;
            }
        }

        // print_r($post);exit;
        $result = MyHelper::post('setting/default_home', $post);
        return parent::redirect($result, 'Default Home Background has been updated.');
    }

    public function defaultDoctorHomeSave(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['default_home_doctor_image'])) {
            $post['default_home_doctor_image'] = MyHelper::encodeImage($post['default_home_doctor_image']);
        }
        if (isset($post['default_home_doctor_splash_screen'])) {
            $post['default_home_doctor_splash_screen'] = MyHelper::encodeImage($post['default_home_doctor_splash_screen']);
        }

        if (isset($post['default_home_doctor_splash_duration'])) {
            if ($post['default_home_doctor_splash_duration'] < 1) {
                $post['default_home_doctor_splash_duration'] = 1;
            }
        }

        // print_r($post);exit;
        $result = MyHelper::post('setting/default_home_doctor', $post);
        return parent::redirect($result, 'Default Doctor Home Background has been updated.');
    }

    public function dashboardSetting(Request $request)
    {
        $post = $request->except('_token');

        $data = [
        'title'          => 'Home Setting',
        'menu_active'    => 'setting-home-user',
        'submenu_active' => 'setting-home-user',
        ];

        if (!empty($post)) {
            $save = MyHelper::post('setting/dashboard/update', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('setting/home/user')->withSuccess(['Section dashboard has been updated.']);
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

        $dashboard = MyHelper::get('setting/dashboard/list');
        if (isset($dashboard['status']) && $dashboard['status'] == "success") {
            $data['dashboard'] = $dashboard['result'];
        } else {
            $data['dasboard'] = [];
        }

        return view('setting::dashboard.form', $data);
    }

    public function deleteDashboard(Request $request)
    {
        $post = $request->except('_token');
        $save = MyHelper::post('setting/dashboard/delete', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return 'success';
        } else {
            return 'fail';
        }
    }

    public function updateDashboardAjax(Request $request)
    {
        $post = $request->except('_token');
        $save = MyHelper::post('setting/dashboard/update', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return $save;
        } else {
            return ['status' => 'fail'];
        }
    }

    public function visibilityDashboardSection(Request $request)
    {
        $post = $request->except('_token');
        $save = MyHelper::post('setting/dashboard/update-visibility', $post);
        return $save;
    }

    public function orderDashboardSection(Request $request)
    {
        $post = $request->except('_token');
        $save = MyHelper::post('setting/dashboard/order-section', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return 'success';
        } else {
            return 'fail';
        }
    }

    public function orderDashboardCard(Request $request)
    {
        $post = $request->except('_token');
        $save = MyHelper::post('setting/dashboard/order-card', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return 'success';
        } else {
            return 'fail';
        }
    }

    public function updateDateRange(Request $request)
    {
        $post = $request->except('_token');
        $save = MyHelper::post('setting/dashboard/update/date-range', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('setting/home/user')->withSuccess(['Default date range dashboard has been updated.']);
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

    public function whatsApp(Request $request)
    {
        $post = $request->except('_token');

        $data = [
        'title'          => 'Setting WhatsApp',
        'menu_active'    => 'crm-setting',
        'submenu_active' => 'whatsapp',
        ];

        if (empty($post)) {
            $query = MyHelper::get('setting/whatsapp');
            if (isset($query['status']) && $query['status'] == 'success') {
                $data['api_key_whatsapp'] = $query['result'];
            } else {
                $data['api_key_whatsapp'] = null;
            }
            return view('setting::whatsapp.whatsapp', $data);
        } else {
            $save = MyHelper::post('setting/whatsapp', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('setting/whatsapp')->withSuccess(['Api key whatsApp has been updated.']);
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

/* Banner */
    public function createBanner(Request $request)
    {
        $validatedData = $request->validate([
        'banner_image' => 'required|dimensions:width=750,height=375',
        ]);

        $post = $request->except('_token');

        if (isset($post['banner_image'])) {
            $post['image'] = MyHelper::encodeImage($post['banner_image']);
            unset($post['banner_image']);
        }

        $post['type'] = 'general';

        if (isset($post['click_to'])) {
            $post['type'] = $post['click_to'];
            // remove click_to index
            unset($post['click_to']);
        }

        if (isset($post['banner_start'])) {
            $post['banner_start'] = MyHelper::convertDateTime2($post['banner_start']);
        }

        if (isset($post['banner_end'])) {
            $post['banner_end'] = MyHelper::convertDateTime2($post['banner_end']);
        }

        $result = MyHelper::post('setting/banner/create', $post);

        return parent::redirect($result, 'New banner has been created.', 'setting/home#banner');
    }

    public function updateBanner(Request $request)
    {
        $validatedData = $request->validate([
        'id_banner'    => 'required',
        'banner_image' => 'sometimes|dimensions:width=750,height=375',
        ]);

        $post = $request->except('_token');

        if (isset($post['banner_image'])) {
            $post['image'] = MyHelper::encodeImage($post['banner_image']);
            unset($post['banner_image']);
        }

        $post['type'] = 'general';

        if (isset($post['click_to'])) {
            $post['type'] = $post['click_to'];
            // remove click_to index
            unset($post['click_to']);
        }

        if (isset($post['banner_start'])) {
            $post['banner_start'] = MyHelper::convertDateTime2($post['banner_start']);
        }

        if (isset($post['banner_end'])) {
            $post['banner_end'] = MyHelper::convertDateTime2($post['banner_end']);
        }

        $result = MyHelper::post('setting/banner/update', $post);
        return parent::redirect($result, 'Banner has been updated.', 'setting/home#banner');
    }

    public function reorderBanner(Request $request)
    {
        $post = $request->except("_token");
        // dd($post['id_banners']);
        $result = MyHelper::post('setting/banner/reorder', $post);

        return parent::redirect($result, 'Banner has been sorted.', 'setting/home#banner');
    }

    // delete banner
    public function deleteBanner($id_banner)
    {
        $post['id_banner'] = $id_banner;

        $result = MyHelper::post('setting/banner/delete', $post);

        return parent::redirect($result, 'Banner has been deleted.', 'setting/home#banner');
    }

/* Featured Deal */
    public function createFeaturedDeal(Request $request)
    {
        $post = $request->except('_token');

        $result = MyHelper::post('setting/featured_deal/create', $post);
        return parent::redirect($result, 'New featured deal has been created.', 'setting/home#featured_deals');
    }

    public function updateFeaturedDeal(Request $request)
    {
        $post          = $request->except('_token');
        $validatedData = $request->validate([
        'id_featured_deals' => 'required',
        ]);
        $result = MyHelper::post('setting/featured_deal/update', $post);
        return parent::redirect($result, 'Featured Deal has been updated.', 'setting/home#featured_deals', [], true);
    }

    public function reorderFeaturedDeal(Request $request)
    {
        $post = $request->except("_token");
        // dd($post['id_featured_deals']);

        $result = MyHelper::post('setting/featured_deal/reorder', $post);

        return parent::redirect($result, 'Featured Deal has been sorted.', 'setting/home#featured_deals');
    }

    // delete featured_deal
    public function deleteFeaturedDeal($id_featured_deal)
    {
        $post['id_featured_deals'] = $id_featured_deal;

        $result = MyHelper::post('setting/featured_deal/delete', $post);

        return parent::redirect($result, 'Featured Deal has been deleted.', 'setting/home#featured_deals');
    }

    // complete user profile settings
    public function completeProfile(Request $request)
    {
        $post = $request->except('_token');
        if ($post) {
            $validatedData = $request->validate([
            'complete_profile_cashback' => 'required',
            ]);

            $post = $request->except('_token');
                // remove this, if point feature is active
            $post['complete_profile_point'] = 0;

                // update complete profile
            $result = MyHelper::post('setting/be/complete-profile', $post);

            return parent::redirect($result, 'User Profile Completing has been updated.', 'setting/complete-profile');
        } else {
            $data = [
            'title'          => 'Complete Profile Setting',
            'menu_active'    => 'profile-completion',
            'submenu_active' => 'complete-profile',
            ];
            $request = MyHelper::get('setting/be/complete-profile');
            if (isset($request['result'])) {
                $data['complete_profile'] = $request['result'];
            }
            return view('setting::profile-completion.profile-completion', $data);
        }
    }

    // complete user profile success page content
    public function completeProfileSuccessPage(Request $request)
    {
        $validatedData = $request->validate([
        'complete_profile_success_page' => 'required',
        ]);

        $post = $request->except('_token');

            // update
        $result = MyHelper::post('setting/complete-profile/success-page', $post);
            // dd($result);

        return parent::redirect($result, 'User Profile Success Page has been updated.', 'setting/home#user-profile');
    }

    public function textMenu(Request $request)
    {
        //text menu setting
        $data = [
        'title'          => 'Text Menu Setting',
        'menu_active'    => 'setting-text-menu',
        'submenu_active' => 'setting-text-menu-list',
        ];

        $request = MyHelper::post('setting/be/text_menu_list', ['webview' => 1]);
        if (isset($request['result']) && !empty($request['result'])) {
            $data['menu_list'] = $request['result'];
        } else {
            $data['menu_list'] = [
            'main_menu'  => [],
            'other_menu' => [],
            'home_menu'  => [],
            ];
        }

        $configMenu = MyHelper::get('setting/text_menu/configs');
        if (isset($configMenu['result']) && !empty($configMenu['result'])) {
            $data['config_main_menu']  = $configMenu['result']['config_main_menu'];
            $data['config_other_menu'] = $configMenu['result']['config_other_menu'];
        } else {
            $data['config_main_menu']  = [];
            $data['config_other_menu'] = [];
        }
        return view('setting::text_menu', $data);
    }

    public function updateTextMenu(Request $request, $category)
    {
        $post    = $request->except('_token');
        $allData = $request->all();

        if (isset($allData['images'])) {
            foreach ($allData['images'] as $key => $value) {
                if ($allData['images'][$key] !== null) {
                    $allData['images'][$key] = MyHelper::encodeImage($allData['images'][$key]);
                }
            }
        }

        $post = [
        'category'  => $category,
        'data_menu' => $allData,
        ];

        $result = MyHelper::post('setting/text_menu/update', $post);

        if ($category == 'other-menu') {
            return parent::redirect($result, 'Text menu has been updated.', 'setting/text_menu#other_menu');
        } elseif ($category == 'home-menu') {
            return parent::redirect($result, 'Text menu has been updated.', 'setting/text_menu#home_menu');
        } else {
            return parent::redirect($result, 'Text menu has been updated.', 'setting/text_menu#main_menu');
        }
    }

    public function confirmationMessages(Request $request)
    {
        $data = [
        'title'          => 'Confirmation Messages',
        'menu_active'    => 'confirmation-messages',
        'submenu_active' => '',
        ];
        if ($post = $request->except('_token')) {
            $data = [
            'update' => [
                'payment_messages'         => ['value_text', $post['payment_messages']],
                'payment_messages_cash'    => ['value_text', $post['payment_messages_cash']],
                'payment_messages_point'   => ['value_text', $post['payment_messages_point']],
                'payment_success_messages' => ['value_text', $post['payment_success_messages']],
                'payment_fail_messages'    => ['value_text', $post['payment_fail_messages']],
            ],
            ];
            $result = MyHelper::post('setting/update2', $data);
            if (($result['status'] ?? '') == 'success') {
                return redirect('setting/confirmation-messages')->with('success', ['Confirmation messages has been updated']);
            } else {
                return back()->withErrors($result['messages'] ?? ['Something went wrong']);
            }
        } else {
            $payment_messages         = MyHelper::post('setting', ['key' => 'payment_messages'])['result']['value_text'] ?? 'Kamu yakin ingin mengambil voucher ini?';
            $payment_messages_cash    = MyHelper::post('setting', ['key' => 'payment_messages_cash'])['result']['value_text'] ?? 'Kamu yakin ingin membeli deals %deals_title% dengan harga %cash% ?';
            $payment_messages_point   = MyHelper::post('setting', ['key' => 'payment_messages_point'])['result']['value_text'] ?? 'Anda akan menukarkan %point% points anda dengan Voucher %deals_title%?';
            $payment_success_messages = MyHelper::post('setting', ['key' => 'payment_success_messages'])['result']['value_text'] ?? 'Apakah kamu ingin menggunakan Voucher sekarang?';
            $payment_fail_messages    = MyHelper::post('setting', ['key' => 'payment_fail_messages'])['result']['value_text'] ?? 'Mohon maaf, point anda tidak cukup';
            $data['msg']              = [
            'payment_messages'         => $payment_messages,
            'payment_messages_cash'    => $payment_messages_cash,
            'payment_messages_point'   => $payment_messages_point,
            'payment_success_messages' => $payment_success_messages,
            'payment_fail_messages'    => $payment_fail_messages,
            ];
            return view('setting::confirmation-messages.confirmation-messages', $data);
        }
    }

    public function otpMessages(Request $request)
    {
        $data = [
        'title'          => 'Popup Messages',
        'menu_active'    => 'setting',
        'submenu_active' => 'setting-popup-messages',
        ];
        if ($post = $request->except('_token')) {
            $data = [
            'update' => [
                'message_send_otp_miscall' => ['value_text', $post['message_send_otp_miscall']],
                'message_send_otp_wa'      => ['value_text', $post['message_send_otp_wa']],
                'message_send_otp_sms'     => ['value_text', $post['message_send_otp_sms']],
                'message_sent_otp_miscall' => ['value_text', $post['message_sent_otp_miscall']],
                'message_sent_otp_wa'      => ['value_text', $post['message_sent_otp_wa']],
                'message_sent_otp_sms'     => ['value_text', $post['message_sent_otp_sms']],
            ],
            ];
            $result = MyHelper::post('setting/update2', $data);
            if (($result['status'] ?? '') == 'success') {
                return redirect('setting/otp-messages')->with('success', ['popup messages has been updated']);
            } else {
                return back()->withErrors($result['messages'] ?? ['Something went wrong']);
            }
        } else {
            $message_send_otp_miscall = MyHelper::post('setting', ['key' => 'message_send_otp_miscall'])['result']['value_text'] ?? 'Kami akan mengirimkan kode OTP melalui Missed Call ke %phone%.<br/>Anda akan mendapatkan panggilan dari nomor 6 digit.<br/>Nomor panggilan tsb adalah Kode OTP Anda.';
            $message_send_otp_wa      = MyHelper::post('setting', ['key' => 'message_send_otp_wa'])['result']['value_text'] ?? 'Kami akan mengirimkan kode OTP melalui Whatsapp.<br/>Pastikan nomor %phone% terdaftar di Whatsapp.';
            $message_send_otp_sms     = MyHelper::post('setting', ['key' => 'message_send_otp_sms'])['result']['value_text'] ?? 'Kami akan mengirimkan kode OTP melalui SMS.<br/>Pastikan nomor %phone% aktif.';
            $message_sent_otp_miscall = MyHelper::post('setting', ['key' => 'message_sent_otp_miscall'])['result']['value_text'] ?? 'Kami telah mengirimkan PIN ke nomor %phone% melalui Missed Call.';
            $message_sent_otp_wa      = MyHelper::post('setting', ['key' => 'message_sent_otp_wa'])['result']['value_text'] ?? 'Kami telah mengirimkan PIN ke nomor %phone% melalui Whatsapp.';
            $message_sent_otp_sms     = MyHelper::post('setting', ['key' => 'message_sent_otp_sms'])['result']['value_text'] ?? 'Kami telah mengirimkan PIN ke nomor %phone% melalui SMS.';
            $data['msg']              = compact('message_send_otp_sms', 'message_send_otp_miscall', 'message_send_otp_wa', 'message_sent_otp_sms', 'message_sent_otp_miscall', 'message_sent_otp_wa');
            return view('setting::confirmation-messages.popup-messages', $data);
        }
    }

    public function phoneNumberSetting(Request $request)
    {
        $getSetting = MyHelper::get('setting/phone');

        $data = [
        'title'          => 'Phone Setting',
        'menu_active'    => 'setting-phone',
        'submenu_active' => 'setting-phone',
        ];

        if (($getSetting['status'] ?? '') == 'success') {
            $data['result']               = $getSetting['result'];
            $data['example_phone']        = $getSetting['result']['phone_code'] . $getSetting['result']['example_phone'];
            $data['length_example_phone'] = strlen($data['example_phone']);
        } else {
            $data['result']               = [];
            $data['example_phone']        = '';
            $data['length_example_phone'] = '';
        }

        return view('setting::phone-setting', $data);
    }

    public function updatePhoneNumberSetting(Request $request)
    {
        $post          = $request->except('_token');
        $updateSetting = MyHelper::post('setting/phone/update', $post);

        if (($updateSetting['status'] ?? '') == 'success') {
            return redirect('setting/phone')->with('success', ['Success update phone setting']);
        } else {
            return redirect('setting/phone')->withErrors([$updateSetting['message']]);
        }
    }

    public function maintenanceMode(Request $request)
    {
        $post = $request->except('_token');
        $data = [
        'title'          => 'Maintenance Mode Setting',
        'menu_active'    => 'maintenance-mode',
        'submenu_active' => 'maintenance-mode',
        ];
        if ($post) {
            if (isset($post['image']) && $post['image'] !== null) {
                $post['image'] = MyHelper::encodeImage($post['image']);
            }
            $updateMaintenanceMode = MyHelper::post('setting/maintenance-mode/update', $post);
            if (($updateMaintenanceMode['status'] ?? '') == 'success') {
                return redirect('setting/maintenance-mode')->with('success', ['Success update maintenance']);
            } else {
                return redirect('setting/maintenance-mode')->withErrors([$updateMaintenanceMode['message']]);
            }
        } else {
            $maintenanceMode = MyHelper::get('setting/maintenance-mode');
            if (isset($maintenanceMode['status']) && $maintenanceMode['status'] == 'success') {
                $data['status']  = $maintenanceMode['result']['status'];
                $data['message'] = $maintenanceMode['result']['message'];
                $data['image']   = $maintenanceMode['result']['image'];
            } else {
                $data['status']  = 0;
                $data['message'] = '';
                $data['image']   = '';
            }
        }
        return view('setting::maintenance-mode', $data);
    }

/*========================= featured subscription =========================*/

    public function createFeaturedSubscription(Request $request)
    {
        $post = $request->except('_token');

        $result = MyHelper::post('setting/featured_subscription/create', $post);
        return parent::redirect($result, 'New featured subscription has been created.', 'setting/home#featured_subscription');
    }

    public function updateFeaturedSubscription(Request $request)
    {
        $post          = $request->except('_token');
        $validatedData = $request->validate([
        'id_featured_subscription' => 'required',
        ]);
        $result = MyHelper::post('setting/featured_subscription/update', $post);
        return parent::redirect($result, 'Featured Subscription has been updated.', 'setting/home#featured_subscription', [], true);
    }

    public function reorderFeaturedSubscription(Request $request)
    {
        $post = $request->except("_token");
        // dd($post['id_featured_subscription']);

        $result = MyHelper::post('setting/featured_subscription/reorder', $post);

        return parent::redirect($result, 'Featured Subscription has been sorted.', 'setting/home#featured_subscription');
    }

    // delete featured_subscription
    public function deleteFeaturedSubscription($id_featured_subscription)
    {
        $post['id_featured_subscription'] = $id_featured_subscription;

        $result = MyHelper::post('setting/featured_subscription/delete', $post);

        return parent::redirect($result, 'Featured Subscription has been deleted.', 'setting/home#featured_subscription');
    }

/*========================= end of featured subscription =========================*/

    public function timeExpired(Request $request)
    {
        $post = $request->except('_token');
        $data = [
        'title'          => 'Time Expired Setting',
        'menu_active'    => 'time-expired',
        'submenu_active' => 'time-expired',
        ];
        if ($post) {
            $update = MyHelper::post('setting/time-expired/update', $post);
            if (($update['status'] ?? '') == 'success') {
                return redirect('setting/time-expired')->with('success', ['Success update time expired']);
            } else {
                return redirect('setting/time-expired')->withErrors([$update['message']]);
            }
        } else {
            $get = MyHelper::get('setting/time-expired');
            if (isset($get['status']) && $get['status'] == 'success') {
                $data['result'] = $get['result'];
            } else {
                return back()->withErrors(['Failed get data setting time expired']);
            }
        }

        return view('setting::time-expired', $data);
    }

    public function outletAppSetting(Request $request)
    {
        $post = $request->except('_token');
        $data = [
        'title'          => 'Outlet App Setting',
        'menu_active'    => 'setting-outlet-apps',
        'submenu_active' => 'setting-outlet-apps',
        ];

        $get                          = MyHelper::get('setting/outletapp/splash-screen');
        $data['result_splash_screen'] = [];
        if (isset($get['status']) && $get['status'] == 'success') {
            $data['result_splash_screen'] = $get['result'];
        }

        return view('setting::outletapp', $data);
    }

    public function splashScreenOutletApps(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['default_splash_screen_outlet_apps'])) {
            $post['default_splash_screen_outlet_apps'] = MyHelper::encodeImage($post['default_splash_screen_outlet_apps']);
        }

        if (isset($post['default_splash_screen_outlet_apps_duration'])) {
            if ($post['default_splash_screen_outlet_apps_duration'] < 1) {
                $post['default_splash_screen_outlet_apps_duration'] = 1;
            }
        }

        $result = MyHelper::post('setting/outletapp/splash-screen', $post);
        return parent::redirect($result, 'Splash Screen has been updated.');
    }

    public function updateMaxConsultationQuota(Request $request)
    {
        $post = $request->except('_token');

        $update = MyHelper::post('setting/max-consultation/update', $post);
        return parent::redirect($update, 'Setting data has been updated.');
    }

/* Featured Promo Campaign */
    public function createFeaturedPromoCampaign(Request $request)
    {
        $post = $request->except('_token');

        $result = MyHelper::post('setting/featured_promo_campaign/create', $post);

        return parent::redirect($result, 'New featured promo campaign has been created.', 'setting/home#featured_promo_campaign');
    }

    public function updateFeaturedPromoCampaign(Request $request)
    {
        $post          = $request->except('_token');
        $validatedData = $request->validate([
        'id_featured_promo_campaign' => 'required',
        ]);
        $result = MyHelper::post('setting/featured_promo_campaign/update', $post);
        return parent::redirect($result, 'Featured promo campaign has been updated.', 'setting/home#featured_promo_campaign', [], true);
    }

    public function reorderFeaturedPromoCampaign(Request $request)
    {
        $post   = $request->except("_token");
        $result = MyHelper::post('setting/featured_promo_campaign/reorder', $post);

        return parent::redirect($result, 'Featured promo campaign has been sorted.', 'setting/home#featured_promo_campaign');
    }

    public function deleteFeaturedPromoCampaign($id_promo_campaign)
    {
        $post['id_featured_promo_campaign'] = $id_promo_campaign;
        $result                             = MyHelper::post('setting/featured_promo_campaign/delete', $post);

        return parent::redirect($result, 'Featured promo campaign has been deleted.', 'setting/home#featured_promo_campaign');
    }
}
