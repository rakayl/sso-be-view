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

    if(Session::has('filter-list-promo-pg-validation')){
        $search_param = Session::get('filter-list-promo-pg-validation');
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
        @include('disburse::promo_payment_gateway.filter_validation')
        <br>
    </form>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Promo Payment Gateway Validation Report</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width: 100px"> Status </th>
                        <th style="width: 100px"> Created At </th>
                        <th style="width: 100px"> Admin Name </th>
                        <th style="width: 100px"> Promo </th>
                        <th style="width: 100px"> Periode </th>
                        <th style="width: 100px"> Invalid Data <i class="fa fa-info-circle tooltips" data-toggle="tooltip" data-placement="top" title="Jumlah data yang tidak ditemukan dan data payment tidak sesuai rule" data-skin="dark" style="color: #0000007a"></i></th>
                        <th style="width: 100px"> Correct Get Promo <i class="fa fa-info-circle tooltips" data-toggle="tooltip" data-placement="top" title="Jumlah data yang sesuai untuk transaksi yang mendapatkan promo" data-skin="dark" style="color: #0000007a"></i></th>
                        <th style="width: 100px"> Not Get Promo <i class="fa fa-info-circle tooltips" data-toggle="tooltip" data-placement="top" title="Jumlah transaksi yang di sistem Jiwa+ mendapatkan promo tetapi berdasarkan file validasi dari PG tidak mendapatkan promo (pada sistem Jiwa+ di-update menjadi tidak mendapatkan promo)" data-skin="dark" style="color: #0000007a"></i></th>
                        <th style="width: 100px"> Must Get Promo <i class="fa fa-info-circle tooltips" data-toggle="tooltip" data-placement="top" title="Jumlah transaksi yang di sistem Jiwa+ tidak mendapatkan promo tetapi berdasarkan file validasi dari PG mendapatkan promo (pada sistem Jiwa+ di-update menjadi mendapatkan promo)" data-skin="dark" style="color: #0000007a"></i></th>
                        <th style="width: 100px"> Wrong Cashback <i class="fa fa-info-circle tooltips" data-toggle="tooltip" data-placement="top" title="Jumlah transaksi dengan nilai cashback yang tidak sesuai (nilai cashback di-update berdasarkan nilai cashback dari file validasi)" data-skin="dark" style="color: #0000007a"></i></th>
                        <th style="width: 100px"> Action </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (!empty($data))
                        @foreach($data as $value)
                            <tr>
                                <td>
                                    <?php
                                        $color = [
                                            'In Progress' => '#f7e40f',
                                            'Success' => '#26C281',
                                            'Fail' => '#E7505A'
                                        ];
                                    ?>
                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: {{$color[$value['processing_status']]??''}};padding: 5px 12px;color: #fff;">{{$value['processing_status']}}</span>
                                </td>
                                <td>{{date('d-M-Y H:i', strtotime($value['date_validation']))}}</td>
                                <td>{{$value['admin_name']}}</td>
                                <td>{{$value['name']}}</td>
                                <td>@if(!empty($value['start_date_periode'])) {{date('d-M-Y', strtotime($value['start_date_periode']))}} @endif
                                    @if(!empty($value['start_date_periode']) || !empty($value['end_date_periode'])) / @endif
                                    @if(!empty($value['end_date_periode'])) {{date('d-M-Y', strtotime($value['end_date_periode']))}} @endif</td>
                                <td>{{$value['invalid_data']}}</td>
                                <td>{{$value['correct_get_promo']}}</td>
                                <td>{{$value['not_get_promo']}}</td>
                                <td>{{$value['must_get_promo']}}</td>
                                <td>{{$value['wrong_cashback']}}</td>
                                <td>
                                    <a target="_blank" class="btn btn-sm btn-primary" href="{{url('disburse/rule-promo-payment-gateway/validation/report/detail', $value['id_promo_payment_gateway_validation'])}}"><i class="fa fa-pencil"></i> Detail</a>
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