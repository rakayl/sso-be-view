<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script>
        function showDetail(id_transaction) {
            var token  = "{{ csrf_token() }}";

            $.ajax({
                type : "POST",
                url : "{{ url('transaction/log-invalid-flag/detail') }}",
                data : "_token="+token+"&id_transaction="+id_transaction,
                success : function(result) {
                    $("#bodyDeatil").empty();
                    $("#detail_receipt_number").empty();
                    $("#detail_image").empty();

                    if (result.status == "success") {
                        $('#detail_receipt_number').append(': '+result.result[0].transaction_receipt_number);

                        if(result.result[0].image_invalid_flag !== null){
                            var img = result.result[0].url_storage+result.result[0].image_invalid_flag;
                            $('#detail_image').append('<a target="_blank" href="'+img+'"><img src="'+img+'" width="200px"></a>');
                        }else{
                            $('#detail_image').append(': No Image');
                        }

                        var table = '';

                        for(var i=0;i<result.result.length;i++){
                            table += '<tr>';
                            table += '<td>'+result.result[i].reason+'</td>';
                            table += '<td>'+result.result[i].name+'</td>';
                            table += '<td>'+result.result[i].updated_date+'</td>';
                            table += '<td>'+result.result[i].tansaction_flag+'</td>';
                            table += '</tr>';
                        }

                        $('#bodyDeatil').append(table);
                        $('#detailLog').modal('show');
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                }
            });
        }
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

    <?php
    if(Session::has('filter-list-flag-invalid')){
        $search_param = Session::get('filter-list-flag-invalid');
        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
    }
    ?>

    <form role="form" action="{{ url('transaction/log-invalid-flag/list')}}?filter=1" method="post">
        @include('transaction::flag_invalid.filter_list')
    </form>

    @include('layouts.notifications')

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">Log Update Status</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" id="list-data">
                <thead>
                <tr>
                    <th>Receipt Number</th>
                    <th>Current Status</th>
                    @if(MyHelper::hasAccess([276], $grantedFeature))
                        <th>Detail</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @if(!empty($data))
                    @foreach($data as $res)
                        <tr>
                            <td>
                                <a href="{{ url('transaction/detail') }}/{{ $res['id_transaction'] }}/{{ $res['trasaction_type'] }}">{{$res['transaction_receipt_number']}}</a>
                            </td>
                            <td>
                                {{$res['transaction_flag_invalid']}}
                            </td>
                            <td>
                                @if(MyHelper::hasAccess([276], $grantedFeature))
                                    <a class="btn btn-xs green" onClick="showDetail('{{$res['id_transaction']}}')">Detail</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            @if(isset($dataPerPage) && isset($dataUpTo) && isset($dataTotal))
                Showing {{$dataPerPage}} to {{$dataUpTo}} of {{ $dataTotal }} entries<br>
            @endif
            @if ($dataPaginator)
                {{ $dataPaginator->links() }}
            @endif
        </div>
    </div>

    <div class="modal fade" id="detailLog" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Detail</h4>
                </div>
                <div class="modal-body form">
                    <div class="form-body">
                        <div class="form-group row">
                            <div class="col-md-3">
                                Recipt Number
                            </div>
                            <div class="col-md-8" id="detail_receipt_number"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                Image
                            </div>
                            <div class="col-md-8" id="detail_image"></div>
                        </div>
                        <br>
                        <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                            <table class="table table-striped table-bordered table-hover dt-responsive">
                                <thead>
                                <th>Reason</th>
                                <th>Updated By</th>
                                <th>Updated Date</th>
                                <th>Status</th>
                                </thead>
                                <tbody id="bodyDeatil"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
