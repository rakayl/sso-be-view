<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Lib\MyHelper;
use Session;
use GoogleReCaptchaV3;

class HomeController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

     public function cogs(Request $request)
    {
       $post['dari'] = session('dari')??date('Y-m-01');
        $post['sampai'] = session('sampai')??date('Y-m-t');
        $post['date_start'] = $post['dari'];
        $post['date_end'] = $post['sampai'];
        $data = MyHelper::post('report/dashboard/layanan', $post)['result']??[];
        $array = array();
        foreach($data['week'] as $key =>$value){
            $array[$key]['date'] = $value;
            $array[$key]['sedot'] = $data['data'][0]['data'][$key]??0;
            $array[$key]['renov'] = $data['data'][1]['data'][$key]??0;
        }
        return $array;
    }
     public function omset(Request $request)
    {
        $post['dari'] = session('dari')??date('Y-m-01');
        $post['sampai'] = session('sampai')??date('Y-m-t');
        $post['date_start'] = $post['dari'];
        $post['date_end'] = $post['sampai'];
        $data = MyHelper::post('report/dashboard/layanan', $post)['result']??[];
        $array = array();
        foreach($data['week'] as $key =>$value){
            $array[$key]['date'] = $value;
        }
        return $array;
    }
     public function categori(Request $request)
    {
        $post['dari'] = session('dari')??date('Y-m-01');
        $post['sampai'] = session('sampai')??date('Y-m-t');
        $post['date_start'] = $post['dari'];
        $post['date_end'] = $post['sampai'];
        $data = MyHelper::post('report/dashboard/percent', $post)['result']??[];
        $array = array();
        foreach($data['labels'] as $key =>$value){
            $array[$key]['category'] = $value;
            $array[$key]['value'] = $data['series'][$key]??0;
        }
        return $array;
    }
     public function departTertinggi(Request $request)
    {
        $post['dari'] = session('dari')??date('Y-m-01');
        $post['sampai'] = session('sampai')??date('Y-m-t');
        $post['date_start'] = $post['dari'];
        $post['date_end'] = $post['sampai'];
        $data = MyHelper::post('report/dashboard/department/pemesanan', $post)['result']??[];
        return $data;
    }
     public function departPiutang(Request $request)
    {
        $post['dari'] = session('dari')??date('Y-m-01');
        $post['sampai'] = session('sampai')??date('Y-m-t');
        $post['date_start'] = $post['dari'];
        $post['date_end'] = $post['sampai'];
        $data = MyHelper::post('report/dashboard/department/piutang', $post)['result']??[];
        return $data;
    }
     public function omsetOutlet(Request $request)
    {
        $post['dari'] = session('dari')??date('Y-m-01');
        $post['sampai'] = session('sampai')??date('Y-m-t');
        $post['date_start'] = $post['dari'];
        $post['date_end'] = $post['sampai'];
        $data = MyHelper::post('report/dashboard/omset/outlet', $post)['result']??[];
        return $data;
    }
     public function vendor(Request $request)
    {
        $post['dari'] = session('dari')??date('Y-m-01');
        $post['sampai'] = session('sampai')??date('Y-m-t');
        $post['date_start'] = $post['dari'];
        $post['date_end'] = $post['sampai'];
        $data = MyHelper::post('report/dashboard/vendor', $post)['result']??[];
        return $data;
    }
    public function home(Request $request)
    {
        $post['dari'] = session('dari')??date('Y-m-01');
        $post['sampai'] = session('sampai')??date('Y-m-t');
        $post['date_start'] = $post['dari'];
        $post['date_end'] = $post['sampai'];
        $data = MyHelper::post('report/dashboard/leher-angsa', $post)['result']??0;
        $array[] = array(
            "title"=> "Jumlah Pembangunan Leher Angsa",
            "amount"=> $data,
            "tooltip"=> "Bangunan yang telah menggunakan Leher Angsa pada WC",
            "show"=> 1,
            "color"=> 'blue',
            "icon"=> "fa fa-home"
        ); 
        $data = MyHelper::post('report/dashboard/leher-angsa', $post)['result']??0;
        $array[] = array(
           "title"=> "Jumlah Pembangunan Tangki Septic Standar",
            "amount"=> $data,
            "tooltip"=> "Bangunan yang telah menggunakan Tangki Septic Standar",
            "show"=> 1,
            "color"=> 'blue',
            "icon"=> "fa fa-calendar"
        ); 
        $data = MyHelper::post('report/dashboard/sedotWc', $post)['result']??0;
        $array[] = array(
            "title"=> "Jumlah Sedot WC",
            "amount"=> $data,
            "tooltip"=> "Jumlah Rumah Tangga yang di sedot",
            "show"=> 1,
            "color"=> 'blue',
            "icon"=> "fa fa-bar-chart"
        ); 
        
        $data = MyHelper::post('report/dashboard/sedotWcIplt', $post)['result']??0;
        $array[] = array(
            "title"=> "Jumlah Sedot WC IPLT",
            "amount"=> $data,
            "tooltip"=> "Jumlah lumpur tinja yang ditransport ke IPLT",
            "show"=> 1,
            "color"=> 'blue',
            "icon"=> "fa fa-truck"
        ); 
        $data = MyHelper::post('report/dashboard/sedotWcNonIplt', $post)['result']??0;
        $array[] = array(
            "title"=> "Jumlah Sedot WC Non IPLT",
            "amount"=> $data,
            "tooltip"=> "Jumlah lumpur tinja yang ditransport ke Non IPLT",
            "show"=> 1,
            "color"=> 'blue',
            "icon"=> "fa fa-truck"
        ); 
        $data = MyHelper::post('report/dashboard/layak', $post)['result']??0;
        $array[] = array(
            "title"=> "Akses Sanitasi Layak",
            "amount"=> $data,
            "tooltip"=> "Jumlah lumpur tinja yang ditransport ke Non IPLT",
            "show"=> 1,
            "color"=> 'blue',
            "icon"=> "icon-home"
        ); 
        $data = MyHelper::post('report/dashboard/aman', $post)['result']??0;
        $array[] = array(
            "title"=> "Akses Sanitasi Aman",
            "amount"=> $data,
            "tooltip"=> "Jumlah lumpur tinja yang ditransport ke Non IPLT",
            "show"=> 1,
            "color"=> 'blue',
            "icon"=> "fa fa-home"
        ); 
        $data = MyHelper::post('report/dashboard/event', $post)['result']??0;
        $array[] = array(
            "title"=> "Event Dibuat",
            "amount"=> $data,
            "tooltip"=> "Jumlah lumpur tinja yang ditransport ke Non IPLT",
            "show"=> 1,
            "color"=> 'blue',
            "icon"=> "fa fa-calendar"
        ); 
        return $array;
    }

}
