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
                                    title: name+"\n\nAre you sure want to delete this rule promo payment gateway?",
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
                                        url : "{{ url('disburse/rule-promo-payment-gateway/delete') }}",
                                        data : "_token="+token+"&id_rule_promo_payment_gateway="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                SweetAlert.init()
                                                location.href = "{{url('disburse/rule-promo-payment-gateway')}}";
                                            }
                                            else if(result.status == "fail"){
                                                swal("Error!", "Failed to delete rule promo payment gateway. The rule has been used.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete rule promo payment gateway.", "error")
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

    if(Session::has('filter-list-rule-promo-pg')){
        $search_param = Session::get('filter-list-rule-promo-pg');
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
        @include('disburse::promo_payment_gateway.filter_rule')
        <br>
    </form>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Rule Promo Payment Gateway List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width: 100px"> Status </th>
                        <th style="width: 100px"> Validation </th>
                        <th style="width: 100px"> ID </th>
                        <th style="width: 100px"> Name </th>
                        <th style="width: 100px"> Payment Gateway </th>
                        <th style="width: 100px"> Periode Start </th>
                        <th style="width: 100px"> Periode End </th>
                        <th style="width: 100px"> Total Limit </th>
                        <th style="width: 100px"> Action </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (!empty($data))
                        @foreach($data as $value)
                            <tr>
                                <td>
                                    @if(empty($value['start_status']))
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #d6cece;padding: 5px 12px;color: #fff;">Pending</span>
                                    @elseif( !empty($value['end_date']) && $value['end_date'] < date('Y-m-d') )
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Ended</span>
                                    @elseif( empty($value['start_date']) || $value['start_date'] <= date('Y-m-d') )
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">On Going</span>
                                    @elseif($value['start_date'] > date('Y-m-d'))
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #fef647;padding: 5px 12px;color: #fff;">Not Started</span>
                                    @endif
                                </td>
                                <td>
                                    @if($value['validation_status'] == 1)
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #4bbf5e;padding: 5px 12px;color: #fff;">Completed</span>
                                    @else
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #d6cece;padding: 5px 12px;color: #fff;">Not Completed</span>
                                    @endif
                                </td>
                                <td>{{$value['promo_payment_gateway_code']}}</td>
                                <td>{{$value['name']}}</td>
                                <td>{{$value['payment_gateway']}}</td>
                                <td>{{date('d M Y', strtotime($value['start_date']))}}</td>
                                <td>{{date('d M Y', strtotime($value['end_date']))}}</td>
                                <td>{{$value['limit_promo_total']}}</td>
                                <td>
                                    @if(MyHelper::hasAccess([312,314], $grantedFeature))
                                        <a target="_blank" class="btn btn-sm purple" href="{{url('disburse/rule-promo-payment-gateway/report', $value['id_rule_promo_payment_gateway'])}}"><i class="fa fa-bar-chart"></i></a>
                                        <a class="btn btn-sm green" href="{{url('disburse/rule-promo-payment-gateway/detail', $value['id_rule_promo_payment_gateway'])}}"><i class="fa fa-search"></i></a>
                                    @endif
                                    @if(MyHelper::hasAccess([315], $grantedFeature) && $value['start_status'] != 1)
                                        <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $value['id_rule_promo_payment_gateway'] }}" data-name="{{ $value['name'] }}"><i class="fa fa-trash-o"></i></a>
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
        @if ($dataPaginator)
            {{ $dataPaginator->links() }}
        @endif
    </div>

@endsection