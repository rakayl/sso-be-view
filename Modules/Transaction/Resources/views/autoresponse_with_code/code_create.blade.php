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

            if(codes.length <= 0 && file == ""){
                msg += '- List code or import excel can not be empty. \nPlease fill in one of the data.';
            }

            // const object = {};
            // const result = [];
            // if(codes.length > 0){
            //
            //     codes.forEach(item => {
            //         if(!object[item])
            //         object[item] = 0;
            //         object[item] += 1;
            //     })
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

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">New Code</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" id="from_autoresponse" action="{{url('response-with-code/store')}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama" data-container="body"></i>
                        </label>
                        <div class="col-md-5">
                            <div class="input-icon right">
                                <input type="text" placeholder="Name" class="form-control" name="autoresponse_code_name" value="{{ old('autoresponse_code_name') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Code Periode <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode yang berlaku bedasarkan periode yang dipilih" data-container="body"></i></label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control datepicker" name="autoresponse_code_periode_start" value="{{ old('autoresponse_code_periode_start') }}" required autocomplete="off">
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
                                    <input type="text" class="form_datetime form-control datepicker" name="autoresponse_code_periode_end" value="{{ old('autoresponse_code_periode_end') }}" required autocomplete="off">
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
                                    <option value="All" @if(in_array("All", old('autoresponse_code_transaction_type')??[])) selected @endif>All</option>
                                    <option value="Pickup Order" @if(in_array("Pickup Order", old('autoresponse_code_transaction_type')??[])) selected @endif>Pickup Order</option>
                                    <option value="Delivery" @if(in_array("Delivery", old('autoresponse_code_transaction_type')??[])) selected @endif>Delivery</option>
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
                                    <option value="All" @if(in_array("All", old('autoresponse_code_payment_method')??[])) selected @endif>All</option>
                                    @foreach($payment_list as $val)
                                        <option value="{{$val['payment_method']}}" @if(in_array($val['payment_method'], old('autoresponse_code_payment_method')??[])) selected @endif>{{$val['payment_method']}}</option>
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
                            <textarea name="codes" class="form-control" id="codes" rows="15" required>{{ old('codes') }}</textarea>
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
    </div>

@endsection