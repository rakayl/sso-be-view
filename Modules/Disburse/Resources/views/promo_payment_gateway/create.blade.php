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

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">New Rule Promo Payment Gateway</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('disburse/rule-promo-payment-gateway/store')}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">ID <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="ID rule promo payment gateway" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="ID" class="form-control" name="promo_payment_gateway_code" value="{{ old('promo_payment_gateway_code') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Name rule promo payment gateway" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" placeholder="Name" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Payment Gateway <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih payment gateway yang akan kena promo" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product" name="payment_gateway" data-placeholder="Select" required onchange="changePayment(this.value)">
                                    <option></option>
                                    @foreach($payment_list as $val)
                                        <option value="{{$val['payment_method']}}" @if(old('payment_gateway') == $val['payment_method']) selected @endif>{{$val['payment_method']}}</option>
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
                                <select  class="form-control select2 select2-multiple-product" name="brands[]" data-placeholder="Select Brand" multiple>
                                    <option></option>
                                    @foreach($brands as $val)
                                        <option value="{{$val['id_brand']}}" @if(!empty(old('brands')) && in_array($val['id_brand'], old('brands')) >= 0) selected @endif>{{$val['name_brand']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product" name="operator_brand" data-placeholder="Select">
                                    <option></option>
                                    <option value="or" @if(old('operator_brand') == 'or') selected @endif>one of the selected brand must exist</option>
                                    <option value="and" @if(old('operator_brand') == 'and') selected @endif>all selected brand must exist</option>
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
                                    <input type="text" class="form_datetime form-control datepicker" name="start_date" value="{{ old('start_date') }}" required autocomplete="off">
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
                                    <input type="text" class="form_datetime form-control datepicker" name="end_date" value="{{ old('end_date') }}" required autocomplete="off">
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
                                <input type="text" placeholder="Maximum Total Cashback" class="form-control price2" name="maximum_total_cashback" value="{{ old('maximum_total_cashback') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Total Limit <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="total jumlah promo yang akan diberikan. jika promo unlitimed silahkan isi dengan angka 0" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Total Limit" class="form-control" name="limit_promo_total" value="{{ old('limit_promo_total') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Limit Per User Per Day <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="limitasi penggunaan promo pada tiap user perhari. jika promo unlitimed silahkan isi dengan angka 0" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Limit Per User Per Day" class="form-control" name="limit_per_user_per_day" value="{{ old('limit_per_user_per_day') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Additional Limit Per Day
                            <i class="fa fa-question-circle tooltips" data-original-title="rule tambahan untuk limit promo per hari" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Additional Limit Per Day" class="form-control" name="limit_promo_additional_day" value="{{ old('limit_promo_additional_day') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Additional Limit Per Week
                            <i class="fa fa-question-circle tooltips" data-original-title="rule tambahan untuk limit promo per minggu" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Additional Limit Per Week" class="form-control" name="limit_promo_additional_week" value="{{ old('limit_promo_additional_week') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Additional Limit Per Month
                            <i class="fa fa-question-circle tooltips" data-original-title="rule tambahan untuk limit promo per bulan" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Additional Limit Per Month" class="form-control" name="limit_promo_additional_month" value="{{ old('limit_promo_additional_month') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Additional Limit Per Account
                            <i class="fa fa-question-circle tooltips" data-original-title="rule tambahan untuk limit promo per akun" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Additional Limit Per Account" class="form-control" name="limit_promo_additional_account" value="{{ old('limit_promo_additional_account') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <select  class="form-control select2" name="limit_promo_additional_account_type" id="select_additional_account_type" data-placeholder="Type">
                                    <option></option>
                                    <option value="Jiwa+" @if(old('limit_promo_additional_account_type') == 'Jiwa+') selected @endif>Jiwa+</option>
                                    <option value="Payment Gateway" @if(old('limit_promo_additional_account_type') == 'Payment Gateway') selected @endif>Payment Gateway</option>
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
                                    <input type="radio" value="Nominal" name="cashback_type" @if(old('cashback_type') == "Nominal") checked @endif required onclick="changeCashbackType(this.value)"/>
                                    <span></span>
                                </label>
                                <label class="mt-radio mt-radio-outline"> Percent
                                    <input type="radio" value="Percent" name="cashback_type" @if(old('cashback_type') == "Percent") checked @endif required onclick="changeCashbackType(this.value)"/>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" @if(old('cashback_type') == "Percent") style="display: none" @endif id="cashback_nominal">
                        <label class="col-md-3 control-label">Cashback Nominal
                            <i class="fa fa-question-circle tooltips" data-original-title="jumlah cashback dalam nominal" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    IDR
                                </span>
                                <input type="text" class="form-control price"  id="input_cashback_nominal" placeholder="Cashback Nominal" name="cashback" value="{{ old('cashback') }}" @if(old('cashback_type') == "Percent") disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" @if(old('cashback_type') == "Nominal") style="display: none" @endif id="cashback_percent_value">
                        <label class="col-md-3 control-label">Cashback Percent Value
                            <i class="fa fa-question-circle tooltips" data-original-title="jumlah cashback dalam persen" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control"  id="input_cashback_percent_value" placeholder="Cashback Percent Value" name="cashback" value="{{ old('cashback') }}" @if(old('cashback_type') == "Nominal") disabled @endif>
                                <span class="input-group-addon">
                                    %
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" @if(old('cashback_type') == "Nominal") style="display: none" @endif id="maximum_cashback">
                        <label class="col-md-3 control-label">Maximum Cashback
                            <i class="fa fa-question-circle tooltips" data-original-title="maximum cashback" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                 <span class="input-group-addon">
                                    IDR
                                </span>
                                <input type="text" class="form-control price"  id="input_maximum_cashback" placeholder="Maximum Cashback" id="maximum_cashback" name="maximum_cashback" value="{{ old('maximum_cashback') }}" @if(old('cashback_type') == "Nominal") disabled @endif>
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
                                <input type="text" class="form-control price2"  placeholder="Minimum transaksi" name="minimum_transaction" value="{{ old('minimum_transaction') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Charged Type <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="tipe charged" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Charged Type" class="form-control" id="charged_type" name="charged_type" value="{{ old('charged_type') }}" readonly>
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
                                <input type="text" placeholder="Charged Payment Gateway" class="form-control" name="charged_payment_gateway" value="{{ old('charged_payment_gateway') }}" required>
                                <span class="input-group-addon">
                                    <i class="fa fa-question-circle tooltips" data-original-title="Charged Payment Gateway :  fee yang akan ditanggung oleh Payment Gateway" data-container="body"  style="color: black"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" placeholder="Charged Jiwa Group" class="form-control" name="charged_jiwa_group" value="{{ old('charged_jiwa_group') }}" required>
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
                                <input type="text" placeholder="Charged Central" class="form-control" name="charged_central" value="{{ old('charged_central') }}" required>
                                <span class="input-group-addon">
                                    <i class="fa fa-question-circle tooltips" data-original-title="Charged Central :  fee yang akan ditanggung oleh jiwa group" data-container="body"  style="color: black"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" placeholder="Charged Outlet" class="form-control" name="charged_outlet" value="{{ old('charged_outlet') }}" required>
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
                            <select  class="form-control select2" name="mdr_setting" data-placeholder="MDR Setting" required>
                                <option></option>
                                <option value="Total Amount PG" @if(old('mdr_setting') == 'Total Amount PG') selected @endif>Total Amount PG</option>
                                <option value="Total Amount PG - Cashback Jiwa Group" @if(old('mdr_setting') == 'Total Amount PG - Cashback Jiwa Group') selected @endif>Total Amount PG - Cashback Jiwa Group</option>
                                <option value="Total Amount PG - Total Cashback Customer" @if(old('mdr_setting') == 'Total Amount PG - Total Cashback Customer') selected @endif>Total Amount PG - Total Cashback Customer</option>
                            </select>
                        </div>
                    </div>
                </div>                
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection