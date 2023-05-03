<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $field = [
        'doctor_name' => 'Nama',
        'doctors_services' => 'Service',
        'practice_experience' => 'Pengalaman Praktik',
        'alumni' => 'Alumni',
        'registration_certificate_number' => 'Nomor STR'
    ];
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
@endsection

@extends('layouts.main')

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div><br>

    <h1 class="page-title" style="margin-top: 0px;">
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')

    <?php
    $date_start = '';
    $date_end = '';

    if(Session::has('filter-doctor-update-data')){
        $search_param = Session::get('filter-doctor-update-data');
        if(isset($search_param['date_start'])){
            $date_start = $search_param['date_start'];
        }

        if(isset($search_param['date_end'])){
            $date_end = $search_param['date_end'];
        }

        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
    }
    ?>

    <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
        {{ csrf_field() }}
        @include('doctor::update_data.filter')
    </form>

    <br>
    <div style="overflow-x: scroll; overflow-y: hidden;">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col" width="5%" class="text-center"> Action </th>
                <th scope="col" width="10%" class="text-center"> Doctor Name </th>
                <th scope="col" width="15%" class="text-center"> Phone </th>
                <th scope="col" width="10%" class="text-center"> Status </th>
                <th scope="col" width="10%" class="text-center"> field </th>
                <th scope="col" width="10%" class="text-center"> New Value </th>
                <th scope="col" width="10%" class="text-center"> Notes </th>
                <th scope="col" width="15%" class="text-center"> Request Date </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($data))
                @foreach($data as $val)
                	@php
                		$status = $val['approve_at'] ? 'Approved' : ($val['reject_at'] ? 'Rejected' : 'Pending');
                		$color = ($status == 'Approved') ? '#26C281' : (($status == 'Rejected') ? '#E7505A' : '#ffc107');
                		$textColor = ($status == 'Pending') ? '#fff' : '#fff';
                	@endphp
                    <tr>
                        <td>
                            <a class="btn btn-sm btn-info" target="_blank" href="{{ url('doctor/update-data/detail', $val['id_doctor_update_data']) }}"><i class="fa fa-edit"></i></a>
                        </td>
                        <td>{{ $val['doctor_name'] }}</td>
                        <td class="text-center">{{ $val['doctor_phone'] }}</td>
                        <td class="text-center">
                            <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: {{ $color }};padding: 5px 12px;color: {{ $textColor }};">{{ $status }}</span>
                        </td>
                        <td class="text-center">{{ $field[$val['field']]??'' }}</td>
                        <td class="text-center">{{ $val['new_value'] }}</td>
                        <td class="text-center">{{ $val['notes'] }}</td>
                        <td class="text-center">{{ date('d M Y H:i', strtotime($val['created_at'])) }}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
            @endif
            </tbody>
        </table>
    </div>
    <br>
    @if ($dataPaginator)
        {{ $dataPaginator->links() }}
    @endif
@endsection