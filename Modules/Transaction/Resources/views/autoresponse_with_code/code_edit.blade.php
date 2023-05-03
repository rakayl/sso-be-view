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
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('#sample_1').dataTable({
                "paging":   false,
                "ordering": false,
                "info":     false,
                "searching" : false
            });

            $('.datepicker').datepicker({
                'format' : 'd-M-yyyy',
                'todayHighlight' : true,
                'autoclose' : true
            });
        });

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
                                    title: name+"\n\nAre you sure want to delete this code?",
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
                                        url : "{{ url('response-with-code/delete/code') }}",
                                        data : "_token="+token+"&id_autoresponse_code_list="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                $('#sample_1').DataTable().row(column).remove().draw();
                                                swal("Deleted!", "Code has been deleted.", "success")
                                                SweetAlert.init()
                                            }
                                            else if(result.status == "fail"){
                                                swal("Error!", "Failed to delete code. Code has been used.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete code.", "error")
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

        function submitCheck() {
            var name = $('input[name=autoresponse_code_name]').val();
            var start = $('input[name=autoresponse_code_periode_start]').val();
            var end = $('input[name=autoresponse_code_periode_end]').val();
            var type = $('#autoresponse_code_transaction_type').val();
            var method = $('#autoresponse_code_payment_method').val();
            var codes = $('#codes').val().split("\n");
            codes = codes.filter(function (el) {
                return el != "";
            });
            var file = $('input[name=import_file]').val();
            var msg = '';

            if(name === ""){
                msg += '- Name can not be empty \n';
            }

            if(start === ""){
                msg += '- Start date can not be empty \n';
            }

            if(end === ""){
                msg += '- End date can not be empty \n';
            }

            if(type === null){
                msg += '- Transaction Type can not be empty \n';
            }

            if(method === null){
                msg += '- Payment Method can not be empty \n';
            }

            // if(codes.length <= 0 && file == ""){
            //     msg += '- List code or import excel can not be empty. \nPlease fill in one of the data.';
            // }

            // const object = {};
            // const result = [];
            // if(codes.length > 0){
            //
            //     codes.forEach(item => {
            //         if(!object[item])
            //     object[item] = 0;
            //     object[item] += 1;
            // })
            //
            //     for (const prop in object) {
            //         if(object[prop] >= 2) {
            //             result.push(prop);
            //         }
            //     }
            // }
            //
            // if(result.length > 0){
            //     msg += '- Please remove duplicate code : '+result.join();
            // }

            if(msg !== ""){
                swal("Error!", msg, "error");
            }else{
                $('#from_autoresponse').submit();
            }
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

    <a href="{{url('response-with-code')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject bold uppercase font-blue">{{ $result['autoresponse_code_name'] }}</span>
            </div>
            <ul class="nav nav-tabs">

                <li class="active">
                    <a href="#detail" data-toggle="tab"> Detail </a>
                </li>
                <li>
                    <a href="#list_code" data-toggle="tab"> List Code</a>
                </li>
            </ul>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active" id="detail">
                    <form class="form-horizontal" role="form" id="from_autoresponse" action="{{url('response-with-code/update')}}/{{$result['id_autoresponse_code']}}" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Status
                                </label>
                                <div class="col-md-5">
                                    @if(!empty($result['autoresponse_code_periode_end']) && $result['autoresponse_code_periode_end'] < date('Y-m-d') )
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Ended</span>
                                    @elseif($result['is_stop'] == 1 && (empty($result['autoresponse_code_periode_start']) || $result['autoresponse_code_periode_start'] <= date('Y-m-d')))
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Stop</span>
                                    @elseif($result['is_stop'] == 0 && (empty($result['autoresponse_code_periode_start']) || $result['autoresponse_code_periode_start'] <= date('Y-m-d')))
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">On Going</span>
                                    @elseif($result['autoresponse_code_periode_start'] > date('Y-m-d'))
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #fef647;padding: 5px 12px;color: #fff;">Not Started</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama" data-container="body"></i>
                                </label>
                                <div class="col-md-5">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Name" class="form-control" name="autoresponse_code_name" value="{{$result['autoresponse_code_name']}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Code Periode <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Kode yang berlaku bedasarkan periode yang dipilih" data-container="body"></i></label>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control datepicker" name="autoresponse_code_periode_start" value="{{date('d-M-Y', strtotime($result['autoresponse_code_periode_start']))}}" required autocomplete="off">
                                            <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai kode dapat diberikan" data-container="body"></i>
                                        </button>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control datepicker" name="autoresponse_code_periode_end" value="{{date('d-M-Y', strtotime($result['autoresponse_code_periode_end']))}}" required autocomplete="off">
                                            <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhir kode diberikan" data-container="body"></i>
                                        </button>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Transaction Type <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Tipe transaksi yang boleh mendapatkan kode" data-container="body"></i>
                                </label>
                                <div class="col-md-5">
                                    <div class="input-icon right">
                                        <select  class="form-control select2" multiple name="autoresponse_code_transaction_type[]" id="autoresponse_code_transaction_type" data-placeholder="Select transaction type" required>
                                            <option></option>
                                            <?php
                                            $trxType = array_column($result['transaction_type'], 'autoresponse_code_transaction_type');
                                            ?>
                                            <option value="All" @if($result['is_all_transaction_type'] == 1) selected @endif>All</option>
                                            <option value="Pickup Order" @if(in_array("Pickup Order", $trxType)) selected @endif>Pickup Order</option>
                                            <option value="Delivery" @if(in_array("Delivery", $trxType)) selected @endif>Delivery</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Payment Method <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Metode pembayaran yang boleh mendapatkan kode" data-container="body"></i>
                                </label>
                                <div class="col-md-5">
                                    <div class="input-icon right">
                                        <select  class="form-control select2" multiple name="autoresponse_code_payment_method[]" id="autoresponse_code_payment_method" data-placeholder="Select payment method" required>
                                            <option></option>
                                            <?php
                                            $paymentMethod = array_column($result['payment_method'], 'autoresponse_code_payment_method');
                                            ?>
                                            <option value="All" @if($result['is_all_payment_method'] == 1) selected @endif>All</option>
                                            @foreach($payment_list as $val)
                                                <option value="{{$val['payment_method']}}" @if(in_array($val['payment_method'], $paymentMethod)) selected @endif>{{$val['payment_method']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3  control-label"></label>
                                <div class="col-md-5">
                                    <a href="{{url('response-with-code/export-example')}}">Example import code.xlsx</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3  control-label">Import List Code
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Anda bisa menggunakan file excel untuk memasukkan data code. Satu kode hanya berlaku untuk 1 user." data-container="body"></i>
                                </label>
                                <div class="col-md-5">
                                    <div class="fileinput fileinput-new text-left" data-provides="fileinput">
                                        <div class="input-group input-large">
                                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                <span class="fileinput-filename"> </span>
                                            </div>
                                            <span class="input-group-addon btn default btn-file">
												<span class="fileinput-new"> Select file </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
											</span>
                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3  control-label">List Code
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="List code yang akan di berikan kepada user, satu kode hanya berlaku untuk 1 user." data-container="body"></i>
                                    <br> <small> Separated by new line </small>
                                </label>
                                <div class="col-md-5">
                                    <textarea name="codes" class="form-control" id="codes" rows="15"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-offset-3 col-md-8">
                                    <a class="btn blue" onclick="submitCheck()">Submit</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="list_code">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Transaction Number</th>
                            <th>User Name</th>
                            <th>User Phone</th>
                            @if(MyHelper::hasAccess([309], $grantedFeature))
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result['code_list'] as $val)
                            <tr>
                                <td>{{$val['autoresponse_code']}}</td>
                                <td><a href="{{ url('transaction/detail') }}/{{ $val['id_transaction'] }}/all" target="_blank">{{$val['transaction_receipt_number']}}</a></td>
                                <td>{{$val['name']}}</td>
                                <td>{{$val['phone']}}</td>
                                @if(MyHelper::hasAccess([309], $grantedFeature))
                                    <td>
                                        @if(empty($val['id_user']))
                                            <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $val['id_autoresponse_code_list'] }}" data-name="{{ $val['autoresponse_code'] }}"><i class="fa fa-trash-o"></i></a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection