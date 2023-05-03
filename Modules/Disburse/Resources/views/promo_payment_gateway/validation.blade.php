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
            'autoclose' : true,
            'endDate' : new Date()
        });

        function changeOverrideMdr(value) {
            if(value == 1){
                document.getElementById("div_mdr_type").style.display = "block";
            }else{
                document.getElementById("div_mdr_type").style.display = "none";
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
                <span class="caption-subject sbold uppercase font-blue">Promo Payment Gateway Validation</span>
            </div>
        </div>
        <div class="m-heading-1 border-green m-bordered">
            <ul>
                <li><p>Feature ini digunakan untuk memvalidasi promo pada transaksi. Data yang ada pada excel hanya data transaksi yang mendapatkan promo.</p></li>
                <li><p>Validasi cashback ada 2 pilihan yaitu "Check Cashback" dan "Not Check Cashback".
                    Jika memilih "Not Check Cashback" maka data cashback tidak wajib untuk dimasukkan pada excel.</p></li>
            </ul>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" id="form-validation" action="{{url('disburse/rule-promo-payment-gateway/validation')}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Template Excel</label>
                        <div class="col-md-8">
                            <a href="{{url('disburse/rule-promo-payment-gateway/validation/template')}}"><i class="fa fa-download"></i> template validation promo payment gateway.xls</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Transaction Periode
                            <i class="fa fa-question-circle tooltips" data-original-title="Periode tanggal transaksi yang akan divalidasi" data-container="body"></i></label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control datepicker" id="start_date_periode" name="start_date_periode" value="{{ old('start_date_periode') }}" autocomplete="off" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai promo diberikan kepada user" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control datepicker" id="end_date_periode" name="end_date_periode" value="{{ old('end_date_periode') }}" autocomplete="off" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhir promo diberikan kepada user" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Reference by <span class="text-danger">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="pengecekan berdasarkan data receipt number atau id payment" data-container="body"></i>
                        </label>
                        <div class="col-md-5">
                            <select  class="form-control select2" id="reference_by" name="reference_by" data-placeholder="Select Reference by" required>
                                <option></option>
                                <option value="transaction_receipt_number" @if(old('reference_by') == 'transaction_receipt_number') selected @endif>Receipt Number</option>
                                <option value="id_payment" @if(old('reference_by') == 'id_payment') selected @endif>ID Payment Gateway</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Validation Cashback Type <span class="text-danger">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="proses validasi akan mengecek data cashback atau tidak" data-container="body"></i>
                        </label>
                        <div class="col-md-5">
                            <select  class="form-control select2" id="validation_cashback_type" name="validation_cashback_type" data-placeholder="Select Validation Cashback Type" required>
                                <option></option>
                                <option value="Check Cashback" @if(old('validation_cashback_type') == 'Check Cashback') selected @endif>Check Cashback</option>
                                <option value="Not Check Cashback" @if(old('validation_cashback_type') == 'Not Check Cashback') selected @endif>Not Check Cashback</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Override MDR Status <span class="text-danger">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="pada proses validasi Anda bisa memilih untuk melakukan override MDR atau tidak" data-container="body"></i>
                        </label>
                        <div class="col-md-5">
                            <select  class="form-control select2" id="override_mdr_status" name="override_mdr_status" data-placeholder="Select Override MDR Status" required onchange="changeOverrideMdr(this.value)">
                                <option></option>
                                <option value="1" @if(old('override_mdr_status') == 1) selected @endif>Override MDR</option>
                                <option value="0" @if(old('override_mdr_status') == 0 || !is_null(old('override_mdr_status'))) selected @endif>Not Override MDR</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" @if(old('override_mdr_status') == 0) style="display: none" @endif id="div_mdr_type">
                        <label class="col-md-3 control-label">MDR Percent Type <span class="text-danger">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="perhitungan MDR bisa berupa persen atau nominal" data-container="body"></i>
                        </label>
                        <div class="col-md-5">
                            <select  class="form-control select2" id="override_mdr_percent_type" name="override_mdr_percent_type" data-placeholder="Select MDR Percent Type">
                                <option></option>
                                <option value="Percent" @if(old('override_mdr_percent_type') == 'Percent') selected @endif>Percent</option>
                                <option value="Nominal" @if(old('override_mdr_percent_type') == 'Nominal') selected @endif>Nominal</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Promo <span class="text-danger">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="pilih promo yang akan divalidasi" data-container="body"></i>
                        </label>
                        <div class="col-md-5">
                            <select  class="form-control select2" id="id_rule_promo_payment_gateway" name="id_rule_promo_payment_gateway" data-placeholder="Select Promo" required>
                                <option></option>
                                @foreach($list_promo_payment_gateway as $value)
                                    <option value="{{$value['id_rule_promo_payment_gateway']}}" @if(old('id_rule_promo_payment_gateway') == $value['id_rule_promo_payment_gateway']) selected @endif>{{$value['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">File <span class="text-danger">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="masukkan file untuk melakukan validasi" data-container="body"></i>
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
                    <input type="hidden" name="export" id="export">
                </div>                
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-4">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection