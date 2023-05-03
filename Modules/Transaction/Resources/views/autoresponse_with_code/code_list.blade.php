<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>

        var SweetAlert = function() {
            return {
                init: function() {
                    $(".sweetalert-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this autoresponse code?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, delete it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{ url('response-with-code/delete/autoresponse-code') }}",
                                        data : "_token="+token+"&id_autoresponse_code="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                SweetAlert.init()
                                                location.href = "{{url('response-with-code')}}";
                                            }
                                            else if(result.status == "fail"){
                                                swal("Error!", "Failed to delete autoresponse code. Autoresponse Code has been used.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete autoresponse code.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();

        jQuery(document).ready(function() {
            SweetAlert.init()
        });
    </script>
@endsection

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

    @include('layouts.notifications')

    <?php
    $date_start = '';
    $date_end = '';

    if(Session::has('filter-list-autoresponse-code')){
        $search_param = Session::get('filter-list-autoresponse-code');
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
        @include('transaction::autoresponse_with_code.filter-code')
        <br>
    </form>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Code List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width: 100px"> Status </th>
                        <th style="width: 100px"> Name </th>
                        <th style="width: 100px"> Periode Start </th>
                        <th style="width: 100px"> Periode End </th>
                        <th style="width: 100px"> Transaction Type </th>
                        <th style="width: 100px"> Payment Method </th>
                        <th style="width: 100px"> Action </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (!empty($data))
                        @foreach($data as $value)
                            <tr>
                                <td>
                                    @if(!empty($value['autoresponse_code_periode_end']) && $value['autoresponse_code_periode_end'] < date('Y-m-d') )
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Ended</span>
                                    @elseif($value['is_stop'] == 1 && (empty($value['autoresponse_code_periode_start']) || $value['autoresponse_code_periode_start'] <= date('Y-m-d')))
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Stop</span>
                                    @elseif($value['is_stop'] == 0 && (empty($value['autoresponse_code_periode_start']) || $value['autoresponse_code_periode_start'] <= date('Y-m-d')))
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">On Going</span>
                                    @elseif($value['autoresponse_code_periode_start'] > date('Y-m-d'))
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #fef647;padding: 5px 12px;color: #fff;">Not Started</span>
                                    @endif
                                </td>
                                <td>{{$value['autoresponse_code_name']}}</td>
                                <td>{{date('d M Y', strtotime($value['autoresponse_code_periode_start']))}}</td>
                                <td>{{date('d M Y', strtotime($value['autoresponse_code_periode_end']))}}</td>
                                <td>
                                    @if($value['is_all_transaction_type'] == 1)
                                        All
                                    @else
                                        <?php
                                        echo  implode(', ', array_column($value['transaction_type'], 'autoresponse_code_transaction_type'))
                                        ?>
                                    @endif
                                </td>
                                <td>
                                    @if($value['is_all_payment_method'] == 1)
                                        All
                                    @else
                                        <?php
                                        echo  implode(', ', array_column($value['payment_method'], 'autoresponse_code_payment_method'))
                                        ?>
                                    @endif
                                </td>
                                <td>
                                    @if(MyHelper::hasAccess([318], $grantedFeature))
                                        <a class="btn btn-sm green" href="{{url('response-with-code/edit', $value['id_autoresponse_code'])}}"><i class="fa fa-pencil"></i></a>
                                    @endif
                                    @if(MyHelper::hasAccess([319], $grantedFeature))
                                        <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $value['id_autoresponse_code'] }}" data-name="{{ $value['autoresponse_code_name'] }}"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr style="text-align: center"><td colspan="10">No Data Available</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection