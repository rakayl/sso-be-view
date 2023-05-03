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
        $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });

        $('.price').each(function() {
            var input = $(this).val();
            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt( input, 10 ) : 0;

            $(this).val( function() {
                return ( input === 0 ) ? "" : input.toLocaleString( "id" );
            });
        });

        $( ".price" ).on( "keyup", numberFormat);
        function numberFormat(event){
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }

            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            }
            var $this = $( this );
            var input = $this.val();
            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt( input, 10 ) : 0;

            $this.val( function() {
                return ( input === 0 ) ? "" : input.toLocaleString( "id" );
            });
        }

        $( ".price" ).on( "blur", checkFormat);
        function checkFormat(event){
            var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
            if(!$.isNumeric(data)){
                $( this ).val("");
            }
        }

        $('.price2').each(function() {
            var input = $(this).val();
            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt( input, 10 ) : 0;

            $(this).val( function() {
                return input.toLocaleString( "id" );
            });
        });

        $( ".price2" ).on( "keyup", numberFormat);
        function numberFormat(event){
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }

            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            }
            var $this = $( this );
            var input = $this.val();
            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt( input, 10 ) : 0;

            $this.val( function() {
                return input.toLocaleString( "id" );
            });
        }

        $( ".price2" ).on( "blur", checkFormat);
        function checkFormat(event){
            var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
            if(!$.isNumeric(data)){
                $( this ).val("");
            }
        }

        function changeAdditionalType(val) {
            if(val == 'account'){
                document.getElementById('type_user_limit_per_account').style.display = 'block';
                document.getElementById('select_additional_account_type').required = true;
            }else{
                document.getElementById('type_user_limit_per_account').style.display = 'none';
                document.getElementById('select_additional_account_type').required = false;
            }
        }

        function changeCashbackType(val) {
            if(val == 'Nominal'){
                document.getElementById('cashback_nominal').style.display = 'block';
                document.getElementById('cashback_percent_value').style.display = 'none';
                document.getElementById('maximum_cashback').style.display = 'none';

                $("#input_cashback_nominal").prop('disabled', false);
                $("#input_cashback_percent_value").prop('disabled', true);
                $("#input_maximum_cashback").prop('disabled', true);

                document.getElementById('input_cashback_nominal').style.required = false;
                document.getElementById('input_cashback_percent_value').style.required = true;
                document.getElementById('input_maximum_cashback').style.required = true;
            }else{
                document.getElementById('cashback_nominal').style.display = 'none';
                document.getElementById('cashback_percent_value').style.display = 'block';
                document.getElementById('maximum_cashback').style.display = 'block';

                $("#input_cashback_nominal").prop('disabled', true);
                $("#input_cashback_percent_value").prop('disabled', false);
                $("#input_maximum_cashback").prop('disabled', false);

                document.getElementById('input_cashback_nominal').style.required = true;
                document.getElementById('input_cashback_percent_value').style.required = false;
                document.getElementById('input_maximum_cashback').style.required = false;
            }
            $('#charged_type').val(val);
        }

        var SweetAlert = function() {
            return {
                init: function() {
                    $(".sweetalert-start").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to start this rule promo payment gateway?",
                                    text: "Pastikan rule yang diinputkan pada promo yang dibuat sudah sesuai, karena data promo yang sudah di-start tidak dapat diubah lagi!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-primary",
                                    confirmButtonText: "Yes, start it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{ url('disburse/rule-promo-payment-gateway/start') }}",
                                        data : "_token="+token+"&id_rule_promo_payment_gateway="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                swal("Success!", "Success to start rule promo payment gateway.", "success")
                                                location.href = "{{url('disburse/rule-promo-payment-gateway/detail')}}/"+id;
                                            }else {
                                                swal("Error!", "Something went wrong. Failed to strat rule promo payment gateway.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    });

                    $(".sweetalert-validate").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to validation completed this rule promo payment gateway?",
                                    text: "Pastikan semua transaksi yang mendapatkan promo ini sudah dilakukan proses validasi, karena selanjutnya tidak dapat dilakukan validasi lagi untuk promo ini. Dan semua transaksi yang mendapatkan promo akan diproses disburse nya!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-primary",
                                    confirmButtonText: "Yes, start it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{ url('disburse/rule-promo-payment-gateway/mark-as-valid') }}",
                                        data : "_token="+token+"&id_rule_promo_payment_gateway="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                swal("Success!", "Success to mark as valid.", "success")
                                                location.href = "{{url('disburse/rule-promo-payment-gateway/detail')}}/"+id;
                                            }else {
                                                swal("Error!", "Something went wrong. Failed to mark as valid.", "error")
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

        function changePayment(val) {
            $('#select_additional_account_type').empty();
            if(val.toLowerCase() == 'gopay'){
                var html = '';
                html += '<option></option>';
                html += '<option value="Jiwa+">Jiwa+</option>';
                $('#select_additional_account_type').append(html);
            }else{
                var html = '';
                html += '<option></option>';
                html += '<option value="Jiwa+">Jiwa+</option>';
                html += '<option value="Payment Gateway">Payment Gateway</option>';
                $('#select_additional_account_type').append(html);
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

    <a href="{{url('disburse/rule-promo-payment-gateway')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    @include('layouts.notifications')

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $summary['total_transaction']??0 }}">{{ number_format($summary['total_transaction']??0) }}</span>
                    </div>
                    <div class="desc"> Total Transaction </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $summary['total_amount']??0 }}">{{ number_format($summary['total_amount']??0) }}</span>
                    </div>
                    <div class="desc"> Total Amount </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $summary['total_cashback']??0 }}">{{ number_format($summary['total_cashback']??0) }}</span>
                    </div>
                    <div class="desc"> Total Cashback </div>
                </div>
            </a>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Detail Rule Promo Payment Gateway</span>
            </div>

            <div class="actions">
                <a class="btn purple" target="_blank" href="{{url('disburse/rule-promo-payment-gateway/report', $detail['id_rule_promo_payment_gateway'])}}"><i class="fa fa-bar-chart"></i> Report Promo</a>
                @if($detail['start_status'] != 1)
                <a class="btn green-jungle sweetalert-start" data-id="{{$detail['id_rule_promo_payment_gateway']}}" data-name="{{ $detail['name'] }}"> Start Promo</a>
                @endif
                @if($detail['start_status']== 1 && $detail['validation_status'] != 1 && $detail['end_date'] < date('Y-m-d'))
                    <a class="btn green sweetalert-validate" data-id="{{$detail['id_rule_promo_payment_gateway']}}" data-name="{{ $detail['name'] }}"> Validation Complete </a>
                @endif
            </div>
        </div>
        <div class="portlet-body form">
            <div class="m-heading-1 border-green m-bordered">
                <p>Semua disburse untuk transaksi yang mendapatkan promo ini akan di hold terlebih dahulu sampai proses validasi dipastikan sudah selesai semua dengan cara klik button "Validation Complete"</p>
            </div>
            <form class="form-horizontal" role="form" action="{{url('disburse/rule-promo-payment-gateway/update')}}/{{$detail['id_rule_promo_payment_gateway']}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Status</label>
                        <div class="col-md-4">
                            @if(empty($detail['start_status']))
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #d6cece;padding: 5px 12px;color: #fff;">Pending</span>
                            @elseif( !empty($detail['end_date']) && $detail['end_date'] < date('Y-m-d') )
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Ended</span>
                            @elseif( empty($detail['start_date']) || $detail['start_date'] <= date('Y-m-d') )
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">On Going</span>
                            @elseif($detail['start_date'] > date('Y-m-d'))
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #fef647;padding: 5px 12px;color: #fff;">Not Started</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Validation
                            <i class="fa fa-question-circle tooltips" data-html="true" data-original-title="status validasi promo:
                            <br>1. not completed :
                                Promo belum divalidasi atau validasi belum selesai dilakukan oleh admin.
                                Disburse untuk transaksi yang mendapatkan promo akan di hold terlebih dahulu.
                            <br>2. completed :
                                promo sudah dilakukan validasi oleh admin dan sudah dikonfirmasi bahwa proses validasi sudah lengkap.
                                Disburse untuk transaksi yang mendapatkan promo bisa diproses." data-container="body"  style="color: black"></i>
                        </label>
                        <div class="col-md-4">
                            @if($detail['validation_status'] == 1)
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #4bbf5e;padding: 5px 12px;color: #fff;">Completed</span>
                            @else
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #d6cece;padding: 5px 12px;color: #fff;">Not Completed</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">ID <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="ID rule promo payment gateway" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="ID" class="form-control" name="promo_payment_gateway_code" value="{{ $detail['promo_payment_gateway_code'] }}" required @if($detail['start_status'] == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Name rule promo payment gateway" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" placeholder="Name" class="form-control" name="name" value="{{ $detail['name']}}" required @if($detail['start_status'] == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Payment Gateway <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih payment gateway yang akan kena promo" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product" name="payment_gateway" data-placeholder="Select" required onchange="changePayment(this.value)" @if($detail['start_status'] == 1) disabled @endif>
                                    <option></option>
                                    @foreach($payment_list as $val)
                                        <option value="{{$val['payment_method']}}" @if($detail['payment_gateway'] == $val['payment_method']) selected @endif>{{$val['payment_method']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Brand
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih brand yang akan kena promo" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product" name="brands[]" data-placeholder="Select Brand" multiple @if($detail['start_status'] == 1) disabled @endif>
                                    <option></option>
                                    @foreach($brands as $val)
                                        <option value="{{$val['id_brand']}}" @if(in_array($val['id_brand'], array_column($detail['current_brand'], 'id_brand')??[])) selected @endif>{{$val['name_brand']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product" name="operator_brand" data-placeholder="Select" @if($detail['start_status'] == 1) disabled @endif>
                                    <option></option>
                                    <option value="or" @if($detail['operator_brand'] == 'or') selected @endif>one of the selected brand must exist</option>
                                    <option value="and" @if($detail['operator_brand'] == 'and') selected @endif>all selected brand must exist</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Periode <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="promo yang berlaku bedasarkan periode yang dipilih" data-container="body"></i></label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control datepicker" name="start_date" value="{{ $detail['start_date'] }}" required autocomplete="off" @if($detail['start_status'] == 1) disabled @endif>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai promo berlaku" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control datepicker" name="end_date" value="{{ $detail['end_date'] }}" required autocomplete="off" @if($detail['start_status'] == 1) disabled @endif>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhir promo berlaku" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Maximum Total Cashback <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="maximum total cashback yang akan diberikan. jika promo tidak memiliki maximum cashback silahkan isi dengan angka 0" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Maximum Total Cashback" class="form-control price2" name="maximum_total_cashback" value="{{ (int)$detail['maximum_total_cashback'] }}" required @if($detail['start_status'] == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Total Limit <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="total jumlah promo yang akan diberikan.jika promo unlitimed silahkan isi dengan angka 0" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Total Limit" class="form-control" name="limit_promo_total" value="{{ $detail['limit_promo_total'] }}" required @if($detail['start_status'] == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Limit Per User Per Day <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="limitasi penggunaan promo pada tiap user perhari. jika promo unlitimed silahkan isi dengan angka 0" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Limit Per User Per Day" class="form-control" name="limit_per_user_per_day" value="{{ $detail['limit_per_user_per_day'] }}" required @if($detail['start_status'] == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Additional Limit Per Day
                            <i class="fa fa-question-circle tooltips" data-original-title="rule tambahan untuk limit promo per hari" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Additional Limit Per Day" class="form-control" name="limit_promo_additional_day" value="{{ $detail['limit_promo_additional_day'] }}" @if($detail['start_status'] == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Additional Limit Per Week
                            <i class="fa fa-question-circle tooltips" data-original-title="rule tambahan untuk limit promo per minggu" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Additional Limit Per Week" class="form-control" name="limit_promo_additional_week" value="{{ $detail['limit_promo_additional_week'] }}" @if($detail['start_status'] == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Additional Limit Per Month
                            <i class="fa fa-question-circle tooltips" data-original-title="rule tambahan untuk limit promo per bulan" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Additional Limit Per Month" class="form-control" name="limit_promo_additional_month" value="{{ $detail['limit_promo_additional_month'] }}" @if($detail['start_status'] == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Additional Limit Per Account
                            <i class="fa fa-question-circle tooltips" data-original-title="rule tambahan untuk limit promo per akun" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Additional Limit Per Account" class="form-control" name="limit_promo_additional_account" value="{{ $detail['limit_promo_additional_account'] }}" @if($detail['start_status'] == 1) disabled @endif>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <select  class="form-control select2" name="limit_promo_additional_account_type" id="select_additional_account_type" data-placeholder="Type" @if($detail['start_status'] == 1) disabled @endif>
                                    <option></option>
                                    <option value="Jiwa+" @if($detail['limit_promo_additional_account_type'] == 'Jiwa+') selected @endif>Jiwa+</option>
                                    <option value="Payment Gateway" @if($detail['limit_promo_additional_account_type'] == 'Payment Gateway') selected @endif>Payment Gateway</option>
                                </select>
                                <span class="input-group-addon">
                                    <i class="fa fa-question-circle tooltips" data-html="true" data-original-title="Jiwa+ : pengecekan limit user akan dilihat dari database milik jiwa+. <br>Payment Gateway : pengecekan limit user akan dilihat dari data user yang didapatkan dari payment gateway" data-container="body"  style="color: black"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Cashback <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="jumlah cashback" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="mt-radio-list">
                                <label class="mt-radio mt-radio-outline"> Nominal
                                    <input type="radio" value="Nominal" name="cashback_type" @if($detail['cashback_type'] == "Nominal") checked @endif required onclick="changeCashbackType(this.value)" @if($detail['start_status'] == 1) disabled @endif>
                                    <span></span>
                                </label>
                                <label class="mt-radio mt-radio-outline"> Percent
                                    <input type="radio" value="Percent" name="cashback_type" @if($detail['cashback_type'] == "Percent") checked @endif required onclick="changeCashbackType(this.value)" @if($detail['start_status'] == 1) disabled @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" @if($detail['cashback_type'] == 'Percent') style="display: none" @endif id="cashback_nominal">
                        <label class="col-md-3 control-label">Cashback Nominal
                            <i class="fa fa-question-circle tooltips" data-original-title="jumlah cashback dalam nominal" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    IDR
                                </span>
                                <input type="text" class="form-control price"  id="input_cashback_nominal" placeholder="Cashback Nominal" name="cashback" @if($detail['cashback_type'] == 'Percent' || $detail['start_status'] == 1) disabled @endif value="{{($detail['cashback_type'] == 'Percent' ? NULL: (int)$detail['cashback'])}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" @if($detail['cashback_type'] == 'Nominal') style="display: none" @endif id="cashback_percent_value">
                        <label class="col-md-3 control-label">Cashback Percent Value
                            <i class="fa fa-question-circle tooltips" data-original-title="jumlah cashback dalam persen" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control"  id="input_cashback_percent_value" placeholder="Cashback Percent Value" name="cashback" @if($detail['cashback_type'] == 'Nominal' || $detail['start_status'] == 1) disabled @endif value="{{($detail['cashback_type'] == 'Nominal' ? NULL: $detail['cashback'])}}" >
                                <span class="input-group-addon">
                                    %
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" @if($detail['cashback_type'] == 'Nominal') style="display: none" @endif id="maximum_cashback">
                        <label class="col-md-3 control-label">Maximum Cashback
                            <i class="fa fa-question-circle tooltips" data-original-title="maximum cashback" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                 <span class="input-group-addon">
                                    IDR
                                </span>
                                <input type="text" class="form-control price"  id="input_maximum_cashback" placeholder="Maximum Cashback" id="maximum_cashback" name="maximum_cashback" @if($detail['cashback_type'] == 'Nominal') disabled value="" @else value="{{ $detail['maximum_cashback'] }}" @endif @if($detail['start_status'] == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Minimum Transaksi <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="minimum transaksi yang dibayarkan customer ke Payment Gateway (sudah dikurang diskon dan pembayaran menggunakan point)" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    IDR
                                </span>
                                <input type="text" class="form-control price2"  placeholder="Minimum transaksi" name="minimum_transaction" value="{{ $detail['minimum_transaction'] }}" required @if($detail['start_status'] == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Charged Type <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="tipe charged" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Charged Type" class="form-control" id="charged_type" name="charged_type" value="{{ $detail['charged_type'] }}" readonly @if($detail['start_status'] == 1) disabled @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-4">Charged Payment Gateway</div>
                        <div class="col-md-4">Charged Jiwa Group</div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Charged <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="pembagian fee promo yang akan ditanggung oleh pihak Payment Gateway dan Jiwa Group" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" placeholder="Charged Payment Gateway" class="form-control" name="charged_payment_gateway" value="{{($detail['charged_type'] == 'Nominal'?(int)$detail['charged_payment_gateway']:$detail['charged_payment_gateway'])}}" required @if($detail['start_status'] == 1) disabled @endif>
                                <span class="input-group-addon">
                                    <i class="fa fa-question-circle tooltips" data-original-title="Charged Payment Gateway :  fee yang akan ditanggung oleh Payment Gateway" data-container="body"  style="color: black"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" placeholder="Charged Jiwa Group" class="form-control" name="charged_jiwa_group" value="{{($detail['charged_type'] == 'Nominal'?(int)$detail['charged_jiwa_group']:$detail['charged_jiwa_group'])}}" required @if($detail['start_status'] == 1) disabled @endif>
                                <span class="input-group-addon">
                                    <i class="fa fa-question-circle tooltips" data-original-title="Charged Jiwa Group :  fee yang akan ditanggung oleh jiwa group" data-container="body"  style="color: black"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-4">Charged Central</div>
                        <div class="col-md-4">Charged Outlet</div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Charged Central & <br>Outlet <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="pembagian fee promo yang akan ditanggung oleh pihak Jiwa Group dan outlet" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" placeholder="Charged Central" class="form-control" name="charged_central" value="{{($detail['charged_type'] == 'Nominal'?(int)$detail['charged_central']:$detail['charged_central'])}}" required @if($detail['start_status'] == 1) disabled @endif>
                                <span class="input-group-addon">
                                    <i class="fa fa-question-circle tooltips" data-original-title="Charged Central :  fee yang akan ditanggung oleh jiwa group" data-container="body"  style="color: black"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" placeholder="Charged Outlet" class="form-control" name="charged_outlet" value="{{($detail['charged_type'] == 'Nominal'?(int)$detail['charged_outlet']:$detail['charged_outlet'])}}" required @if($detail['start_status'] == 1) disabled @endif>
                                <span class="input-group-addon">
                                    <i class="fa fa-question-circle tooltips" data-original-title="Charged Outlet :  fee yang akan ditanggung oleh outlet" data-container="body"  style="color: black"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">MDR Setting <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-html="true" data-original-title="Total Amount PG : Perhitungan MDR akan di ambil dari total yang di bayarkan customer ke payment gateway.
                                    <br>Total Amount PG - Cashback Jiwa Group : perhitungan MDR akan diambil dari total yang di bayarkan customer dikurangi dengan cashback yang ditanggung oleh jiwa group.
                                    <br>Total Amount PG - Total Cashback Customer : perhitungan MDR akan diambil dari total yang di bayarkan customer dikurangi dengan total cashback yang didapatkan customer." data-container="body"  style="color: black"></i>
                        </label>
                        <div class="col-md-5">
                            <select  class="form-control select2" name="mdr_setting" data-placeholder="MDR Setting" required @if($detail['start_status'] == 1) disabled @endif>
                                <option></option>
                                <option value="Total Amount PG" @if($detail['mdr_setting'] == 'Total Amount PG') selected @endif>Total Amount PG</option>
                                <option value="Total Amount PG - Cashback Jiwa Group" @if($detail['mdr_setting'] == 'Total Amount PG - Cashback Jiwa Group') selected @endif>Total Amount PG - Cashback Jiwa Group</option>
                                <option value="Total Amount PG - Total Cashback Customer" @if($detail['mdr_setting'] == 'Total Amount PG - Total Cashback Customer') selected @endif>Total Amount PG - Total Cashback Customer</option>
                            </select>
                        </div>
                    </div>
                </div>
                @if($detail['start_status'] != 1)
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>

@endsection