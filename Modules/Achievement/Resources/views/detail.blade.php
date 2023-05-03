<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
    date_default_timezone_set('Asia/Jakarta');
 ?>
@extends('layouts.main-closed')
@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	
	<style type="text/css">
	    #sample_1_filter label, #sample_5_filter label, #sample_4_filter label, .pagination, .dataTables_filter label {
	        float: right;
	    }
	    
	    .cont-col2{
	        margin-left: 30px;
	    }
        .page-container-bg-solid .page-content {
            background: #fff!important;
        }
        .v-align-top {
            vertical-align: top;
        }
        .width-voucher-img {
            max-width: 150px;
        }
        .custom-text-green {
            color: #28a745!important;
        }
        .font-black {
            color: #333!important;
        }
        .pull-right>.dropdown-menu{
            left: 0;
        }
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>

	<script>
    $(document).ready( function () {
        $('.select2-multiple').select2({
            placeholder : "Select",
            allowClear : true,
            width: '100%',
            dropdownParent: $('.modal'),
            dropdownParent: $('#addBadge')
        })
        $('.digit_mask').inputmask({
            removeMaskOnSubmit: true, 
            placeholder: "",
            alias: "currency", 
            digits: 0, 
            rightAlign: false,
            min: 0,
            max: '999999999'
        });
        $('#total_rule').change(function() {
            $('#select_outlet').show()
            $('#select_province').show()
            switch ($(this).val()) {
                case 'total_outlet':
                    $('#select_outlet').hide()
                    $('#select_outlet').children().children().val()
                    toastr.warning("Kamu tidak bisa menggunakan Additional Rule Outlet");
                    break;
                case 'total_province':
                    $('#select_province').hide()
                    $('#select_province').children().children().val()
                    toastr.warning("Kamu tidak bisa menggunakan Additional Rule Province");
                    break;
            }
        });
        $('#total_rule').change(function() {
            $('#select_outlet').show()
            $('#select_province').show()
            switch ($(this).val()) {
                case 'total_outlet':
                    $('#select_outlet').hide()
                    $('#select_outlet').children().children().val()
                    toastr.warning("Kamu tidak bisa menggunakan Additional Rule Outlet");
                    break;
                case 'total_province':
                    $('#select_province').hide()
                    $('#select_province').children().children().val()
                    toastr.warning("Kamu tidak bisa menggunakan Additional Rule Province");
                    break;
            }
        });
        $('.rule_trx').change(function() {
            var form = $(this).parents()[4]
            $(form).find('.trx_rule_form').hide()
            if ($(this).is(':checked')) {
                $(form).find('.trx_rule_form').show()
            }
        });
        $('.rule_product').change(function() {
            var form = $(this).parents()[4]
            $(form).find('.product_rule_form').hide()
            if ($(this).is(':checked')) {
                $(form).find('.product_rule_form').show()
            }
        });
        $('.rule_total').change(function() {
            var form = $(this).parents()[4]
            $(form).find('.total_rule_form').hide()
            if ($(this).is(':checked')) {
                $(form).find('.total_rule_form').show()
            }
        });
        $('.rule_additional').change(function() {
            var form = $(this).parents()[4]
            $(form).find('.additional_rule_form').hide()
            if ($(this).is(':checked')) {
                $(form).find('.additional_rule_form').show()
            }
        });
        var index = 1;
        $('.addBox').click(function() {
            nomer = index++
            $('.btn-rmv').before(`<div class="box">
                                        <div class="col-md-2 text-right" style="text-align: -webkit-right;">
                                            <a href="javascript:;" onclick="removeBox(this)" class="remove-box btn btn-danger">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                        Name
                                                        <span class="required" aria-required="true"> * </span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Detail Achievement Name" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="detail[`+nomer+`][name]" placeholder="Detail Achievement" required maxlength="30">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Image Default Badge
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Gambar deals" data-container="body"></i>
                                                    <br>
                                                    <span class="required" aria-required="true"> (500*500) </span>
                                                    </label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                                            <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                                                            <div>
                                                                <span class="btn default btn-file">
                                                                <span class="fileinput-new"> Select image </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" class="file" accept="image/*" name="detail[`+nomer+`][logo_badge]" required>
                                                                </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                        Achievement Rule
                                                        <span class="required" aria-required="true"> * </span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Detail Achievement Name" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-9">
                                                    <div class="mt-checkbox-inline">
                                                        <label class="mt-checkbox" style="margin-left: 15px;">
                                                            <input type="checkbox" class="rule_trx"> Transaction
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" class="rule_product"> Product
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" class="rule_total"> Total
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" class="rule_additional"> Additional
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group trx_rule_form" hidden>
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Achievement Transaction Rule
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the achievement is not based on the transaction" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control digit_mask" name="detail[`+nomer+`][trx_nominal]" placeholder="Transaction Nominal">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group product_rule_form" hidden>
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Achievement Product Rule
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the achievement is not based on the product" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2-multiple" data-placeholder="Select Product" name="detail[`+nomer+`][id_product]">
                                                            <option></option>
                                                            @foreach ($product as $item)
                                                                <option value="{{$item['id_product']}}">{{$item['product_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="detail[`+nomer+`][product_total]" placeholder="Total Product">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group total_rule_form" hidden>
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Achievement Total Rule
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the achievement is not based on the transaction" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <div class="input-group">
                                                            <select class="form-control select2-multiple" name="detail[`+nomer+`][rule_total]" id="total_rule" data-placeholder="Select Total Rule By">
                                                                <option></option>
                                                                <option value="total_transaction">Transaction</option>
                                                                <option value="total_outlet">Outlet Different</option>
                                                                <option value="total_province">Province Different</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control digit_mask" name="detail[`+nomer+`][value_total]" placeholder="Value Total">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group additional_rule_form" hidden>
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Achievement Additional Rule
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the achievement is not based on the product" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4" id="select_outlet">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="detail[`+nomer+`][id_outlet]">
                                                            <option></option>
                                                            @foreach ($outlet as $item)
                                                                <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="select_province">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2-multiple" data-placeholder="Select Province" name="detail[`+nomer+`][id_province]">
                                                            <option></option>
                                                            @foreach ($province as $item)
                                                                <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`);
            $('.digit_mask').inputmask({
                removeMaskOnSubmit: true, 
                placeholder: "",
                alias: "currency", 
                digits: 0, 
                rightAlign: false,
                min: 0,
                max: '999999999'
            });
            $(".select2-multiple").select2({
                allowClear: true,
                width: '100%'
            });
            $('#total_rule').change(function() {
                $('#select_outlet').show()
                $('#select_province').show()
                switch ($(this).val()) {
                    case 'total_outlet':
                        $('#select_outlet').hide()
                        $('#select_outlet').children().children().val()
                        toastr.warning("Kamu tidak bisa menggunakan Additional Rule Outlet");
                        break;
                    case 'total_province':
                        $('#select_province').hide()
                        $('#select_province').children().children().val()
                        toastr.warning("Kamu tidak bisa menggunakan Additional Rule Province");
                        break;
                }
            });
            $('#total_rule').change(function() {
                $('#select_outlet').show()
                $('#select_province').show()
                switch ($(this).val()) {
                    case 'total_outlet':
                        $('#select_outlet').hide()
                        $('#select_outlet').children().children().val()
                        toastr.warning("Kamu tidak bisa menggunakan Additional Rule Outlet");
                        break;
                    case 'total_province':
                        $('#select_province').hide()
                        $('#select_province').children().children().val()
                        toastr.warning("Kamu tidak bisa menggunakan Additional Rule Province");
                        break;
                }
            });
            $('.rule_trx').change(function() {
                var form = $(this).parents()[4]
                $(form).find('.trx_rule_form').hide()
                if ($(this).is(':checked')) {
                    $(form).find('.trx_rule_form').show()
                }
            });
            $('.rule_product').change(function() {
                var form = $(this).parents()[4]
                $(form).find('.product_rule_form').hide()
                if ($(this).is(':checked')) {
                    $(form).find('.product_rule_form').show()
                }
            });
            $('.rule_total').change(function() {
                var form = $(this).parents()[4]
                $(form).find('.total_rule_form').hide()
                if ($(this).is(':checked')) {
                    $(form).find('.total_rule_form').show()
                }
            });
            $('.rule_additional').change(function() {
                var form = $(this).parents()[4]
                $(form).find('.additional_rule_form').hide()
                if ($(this).is(':checked')) {
                    $(form).find('.additional_rule_form').show()
                }
            });
        });
    })
    function removeBox(params) {
        $(params).parent().parent().remove()
    }
    function editBadge(params) {
        $('#editBadge').find("input[name='name']").val(params.name)
        $('#editBadge').find("img").attr("src", params.logo_badge)
        $('#editBadge').find("select[name='id_product']").val(params.id_product).trigger('change')
        $('#editBadge').find("input[name='trx_nominal']").val(params.trx_nominal)
        $('#editBadge').find("input[name='trx_total']").val(params.trx_total)
        $('#editBadge').find("input[name='product_total']").val(params.product_total)
        $('#editBadge').find("select[name='id_outlet']").val(params.id_outlet).trigger('change')
        $('#editBadge').find("input[name='different_outlet']").val(params.different_outlet).trigger('change')
        $('#editBadge').find("select[name='id_province']").val(params.id_province).trigger('change')
        $('#editBadge').find("input[name='different_province']").val(params.different_province).trigger('change')
        $('#editBadge').find("input[name='id_achievement_detail']").val(params.id_achievement_detail)
        $('.digit_mask').inputmask({
            removeMaskOnSubmit: true, 
            placeholder: "",
            alias: "currency", 
            digits: 0, 
            rightAlign: false,
            min: 0,
            max: '999999999'
        });
        $(".select2-multiple").select2({
            allowClear: true,
            width: '100%',
            dropdownParent: $('#editBadge')
        });
    }
    function removeBadge(params, data) {
        var btn = $(params).parent().parent().parent().before().children()
        btn.find('#loadingBtn').show()
        btn.find('#moreBtn').hide()
        $.post( "{{ url('achievement/remove') }}", { id_achievement_detail: data, _token: "{{ csrf_token() }}" })
        .done(function( data ) {
            if (data.status == 'success') {
                var removeDiv = $(params).parents()[5]
                removeDiv.remove()
            }
            btn.find('#loadingBtn').hide()
            btn.find('#moreBtn').show()
        });
    }
	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
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
</div>
@include('layouts.notifications')
<div class="modal fade bs-modal-lg" id="addBadge" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="width: 800px;">
        <form role="form" action="{{ url('achievement/create') }}" method="post" enctype="multipart/form-data" class="form-horizontal modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Badge</h4>
            </div>
            <div class="modal-body box-repeat" style="padding: 20px;display: table;width: 100%;">
                <div class="box">
                    <div class="col-md-2 text-right" style="text-align: -webkit-right;">
                        <a href="javascript:;" onclick="removeBox(this)" class="remove-box btn btn-danger">
                            <i class="fa fa-close"></i>
                        </a>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                    Name
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Detail Achievement Name" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="detail[0][name]" placeholder="Detail Achievement" required maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Image Default Badge
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar deals" data-container="body"></i>
                                <br>
                                <span class="required" aria-required="true"> (500*500) </span>
                                </label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                        <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                                        <div>
                                            <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" class="file" accept="image/*" name="detail[0][logo_badge]" required>
                                            </span>
                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                    Achievement Rule
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Detail Achievement Name" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-9">
                                <div class="mt-checkbox-inline">
                                    <label class="mt-checkbox" style="margin-left: 15px;">
                                        <input type="checkbox" class="rule_trx"> Transaction
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox">
                                        <input type="checkbox" class="rule_product"> Product
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox">
                                        <input type="checkbox" class="rule_total"> Total
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox">
                                        <input type="checkbox" class="rule_additional"> Additional
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group trx_rule_form" hidden>
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Achievement Transaction Rule
                                <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the achievement is not based on the transaction" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <div class="input-group">
                                        <input type="text" class="form-control digit_mask" name="detail[0][trx_nominal]" placeholder="Transaction Nominal">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group product_rule_form" hidden>
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Achievement Product Rule
                                <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the achievement is not based on the product" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <select class="form-control select2-multiple" data-placeholder="Select Product" name="detail[0][id_product]">
                                        <option></option>
                                        @foreach ($product as $item)
                                            <option value="{{$item['id_product']}}">{{$item['product_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="detail[0][product_total]" placeholder="Total Product">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group total_rule_form" hidden>
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Achievement Total Rule
                                <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the achievement is not based on the transaction" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <div class="input-group">
                                        <select class="form-control select2-multiple" name="detail[0][rule_total]" id="total_rule" data-placeholder="Select Total Rule By">
                                            <option></option>
                                            <option value="total_transaction">Transaction</option>
                                            <option value="total_outlet">Outlet Different</option>
                                            <option value="total_province">Province Different</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <div class="input-group">
                                        <input type="text" class="form-control digit_mask" name="detail[0][value_total]" placeholder="Value Total">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group additional_rule_form" hidden>
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Achievement Additional Rule
                                <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the achievement is not based on the product" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-4" id="select_outlet">
                                <div class="input-icon right">
                                    <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="detail[0][id_outlet]">
                                        <option></option>
                                        @foreach ($outlet as $item)
                                            <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" id="select_province">
                                <div class="input-icon right">
                                    <select class="form-control select2-multiple" data-placeholder="Select Province" name="detail[0][id_province]">
                                        <option></option>
                                        @foreach ($province as $item)
                                            <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-rmv form-action col-md-12 text-right">
                    <a href="javascript:;" class="btn btn-success addBox">
                        <i class="fa fa-plus"></i> Add New Input
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                {{ csrf_field() }}
                <input type="text" hidden name="id_achievement_group" value="{{$data['group']['id_achievement_group']}}">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save changes</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade bs-modal-lg" id="editBadge" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="width: 700px;">
        <form role="form" action="{{ url('achievement/update/detail') }}" method="post" enctype="multipart/form-data" class="form-horizontal modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Modal Title</h4>
            </div>
            <div class="modal-body" style="padding: 20x;display: table;width: 100%;">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Name
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Detail Achievement Name" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" placeholder="Detail Achievement" required maxlength="30">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Image Default Badge
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar deals" data-container="body"></i>
                            <br>
                            <span class="required" aria-required="true"> (500*500) </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                    <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                                    <div>
                                        <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" class="file" accept="image/*" name="logo_badge">
                                        </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Achievement Product Rule
                            <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the achievement is not based on the product" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple" data-placeholder="Select Product" name="id_product">
                                    <option></option>
                                    @foreach ($product as $item)
                                        <option value="{{$item['id_product']}}">{{$item['product_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="product_total" placeholder="Total Product">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Achievement Transaction Rule
                            <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the achievement is not based on the transaction" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form-control digit_mask" name="trx_nominal" placeholder="Transaction Nominal">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form-control digit_mask" name="trx_total" placeholder="Transaction Total">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Achievement Outlet Rule
                            <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the achievement is not based on the product" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple" data-placeholder="Select Product" name="id_outlet">
                                    <option></option>]
                                    @foreach ($outlet as $item)
                                        <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form-control digit_mask" name="different_outlet" placeholder="Value Total">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Rule for different outlet" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Achievement Province Rule
                            <i class="fa fa-question-circle tooltips" data-original-title="Select a province. leave blank, if the achievement is not based on the province" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple" data-placeholder="Select Province" name="id_province">
                                    <option></option>
                                    @foreach ($province as $item)
                                        <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form-control digit_mask" name="different_province" placeholder="Value Total">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Rule for different province" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" hidden name='id_achievement_detail'>
                {{ csrf_field() }}
                <input type="text" name="id_achievement_detail" hidden>
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save changes</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="row" style="margin-top:20px">
    {{-- <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 green">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="3">{{ !empty($result['total_coupon']) ? number_format(($result['total_coupon']??0)-($result['count']??0)) : isset($result['total_coupon']) ? 'unlimited' : '' }}</span>
                            </div>
                            <div class="desc"> Available </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 red">
                        <div class="visual">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="20">{{ number_format($result['count']??0) }}</span>
                            </div>
                            <div class="desc"> Total Used </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 blue">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{$result['total_coupon']??''}}">{{ !empty($result['total_coupon']) ? number_format($result['total_coupon']??0) : isset($result['total_coupon']) ? 'unlimited' : '' }}</span>
                            </div>
                            <div class="desc"> Total {{ isset($result['total_coupon']) ? 'Coupon' : '' }} </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="tabbable-line tabbable-full-width">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#promocampaign" data-toggle="tab"> Achievement </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content" style="margin-top:20px">
                <div class="tab-pane active" id="promocampaign">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="portlet profile-info portlet light bordered">
                                <div class="portlet-title" style="display: flex;"> 
                                    <img src="{{$data['group']['logo_badge_default']}}" style="width: 40px;height: 40px;" class="img-responsive" alt="">
                                    <span class="caption font-blue sbold uppercase">
                                        &nbsp;&nbsp;{{$data['group']['name']}}
                                    </span>
                                </div>
                                <div class="portlet sale-summary">
                                    <div class="portlet-body">
                                        <ul class="list-unstyled">
                                            <li>
                                                <span class="sale-info"> Status 
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                @if (!is_null($data['group']['date_end']) && $data['group']['date_end'] < date('Y-m-d H:i:s'))
                                                    <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Ended</span>
                                                @elseif ($data['group']['date_start'] < date('Y-m-d H:i:s'))
                                                    <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Started</span>
                                                @else
                                                    <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Not Started</span>
                                                @endif
                                            </li>
                                            <li>
                                                <span class="sale-info"> Creator 
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="font-black sale-num sbold">
                                                    {{$data['category']['name']}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Category
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{$data['category']['name']}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Pulished at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{date('d F Y H:i', strtotime($data['group']['publish_start']))}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Created at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{date('d F Y H:i', strtotime($data['group']['created_at']))}}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 profile-info">
                            <div class="profile-info portlet light bordered">
                                <div class="portlet-title"> 
                                    <span class="caption font-blue sbold uppercase">{{$data['group']['name']}} Badge </span>
                                    {{-- <a class="btn blue" style="float: right;" data-toggle="modal" href="#addBadge">Add Badge</a> --}}
                                </div>
                                <div class="portlet-body row">
                                    @foreach ($data['detail'] as $item)
                                    <div class="col-md-12 profile-info">
                                        <div class="profile-info portlet light bordered">
                                            <div class="portlet-title"> 
                                                <div class="col-md-6" style="display: flex;">
                                                    <img src="{{$item['logo_badge']}}" style="width: 40px;height: 40px;" class="img-responsive" alt="">
                                                    <span class="caption font-blue sbold uppercase" style="padding: 8px 0px;font-size: 16px;">
                                                        &nbsp;&nbsp;{{$item['name']}}
                                                    </span>
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <div class="btn-group btn-group-solid pull-right">
                                                        <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <div id="loadingBtn" hidden>
                                                                <i class="fa fa-spinner fa-spin"></i> Loading
                                                            </div>
                                                            <div id="moreBtn">
                                                                <i class="fa fa-ellipsis-horizontal"></i> More
                                                                <i class="fa fa-angle-down"></i>
                                                            </div>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li style="margin: 0px;">
                                                                <a href="#editBadge" data-toggle="modal" onclick="editBadge({{json_encode($item)}})"> Edit </a>
                                                            </li>
                                                            <li style="margin: 0px;">
                                                                <a href="javascript:;" onclick="removeBadge(this, {{$item['id_achievement_detail']}})"> Remove </a>
                                                            </li>
                                                        </ul>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row" style="padding: 5px;position: relative;">
                                                    <div class="col-md-12">
                                                        @if (!is_null($item['id_product']) || !is_null($item['product_total']))
                                                            <div class="row static-info">
                                                                <div class="col-md-5 value">Product Rule</div>
                                                            </div>
                                                            <div class="row static-info">
                                                                @if (!is_null($item['id_product']))
                                                                    <div class="col-md-5 name">Product</div>
                                                                    <div class="col-md-7 value">: {{$item['product']['product_name']}}</div>
                                                                @endif
                                                                @if (!is_null($item['id_product_variant_group']))
                                                                    <div class="col-md-5 name">Product Variant</div>
                                                                    @php
                                                                        $variantName = '';
                                                                        foreach($item['product_variant_group']['product_variant_pivot_simple'] as $key => $variant){
                                                                            if($key > 0){
                                                                                $variantName=$variantName.' ';
                                                                            }
                                                                            $variantName=$variantName.$variant['product_variant_name'];
                                                                        } 
                                                                    @endphp
                                                                    <div class="col-md-7 value">: {{$variantName}}</div>
                                                                @endif
                                                                @if (!is_null($item['product_total']))
                                                                    <div class="col-md-5 name">Product Total</div>
                                                                    <div class="col-md-7 value">: {{$item['product_total']}}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['id_outlet']) || !is_null($item['different_outlet']))
                                                            <div class="row static-info">
                                                                <div class="col-md-5 value">Outlet Rule</div>
                                                            </div>
                                                            <div class="row static-info">
                                                                @if (!is_null($item['id_outlet']))
                                                                    <div class="col-md-5 name">Outlet</div>
                                                                    <div class="col-md-7 value">: {{$item['outlet']['outlet_name']}}</div>
                                                                @endif
                                                                @if (!is_null($item['different_outlet']))
                                                                    <div class="col-md-5 name">Outlet Different ?</div>
                                                                    <div class="col-md-7 value">: {{$item['different_outlet']}} Outlet</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['id_province']) || !is_null($item['different_province']))
                                                            <div class="row static-info">
                                                                <div class="col-md-5 value">Province Rule</div>
                                                            </div>
                                                            <div class="row static-info">
                                                                @if (!is_null($item['id_province']))
                                                                    <div class="col-md-5 name">Province</div>
                                                                    <div class="col-md-7 value">: {{$item['province']['province_name']}}</div>
                                                                @endif
                                                                @if (!is_null($item['different_province']))
                                                                    <div class="col-md-5 name">Province Different ?</div>
                                                                    <div class="col-md-7 value">: {{$item['different_province']}} Province</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['trx_nominal']) || !is_null($item['trx_total']))
                                                            <div class="row static-info">
                                                                <div class="col-md-5 value">Transaction Rule</div>
                                                            </div>
                                                            <div class="row static-info">
                                                                @if (!is_null($item['trx_nominal']))
                                                                    <div class="col-md-5 name">Transaction Nominal</div>
                                                                    <div class="col-md-7 value">: Minimum {{number_format($item['trx_nominal'])}}</div>
                                                                @endif
                                                                @if (!is_null($item['trx_total']))
                                                                    <div class="col-md-5 name">Transaction Total</div>
                                                                    <div class="col-md-7 value">: Minimum {{number_format($item['trx_total'])}}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection