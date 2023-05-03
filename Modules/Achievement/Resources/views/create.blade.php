@extends('layouts.main-closed') 

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" /> 
@endsection 

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('.datepicker').datepicker({
            'format': 'd-M-yyyy',
            'todayHighlight': true,
            'autoclose': true
        });
        $('.timepicker').timepicker();
        $(".form_datetime").datetimepicker({
            format: "d-M-yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            minuteStep: 1
        });
        $('.summernote').summernote({
            placeholder: true,
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
            ],
            fontNames: ['Open Sans', 'Product Sans'],
            fontNamesIgnoreCheck: ['Product Sans'],
            callbacks: {
                onInit: function(e) {
                    this.placeholder
                    ? e.editingArea.find(".note-placeholder").html(this.placeholder)
                    : e.editingArea.remove(".note-placeholder");
                },
                onImageUpload: function(files){
                    sendFile(files[0]);
                },
                onMediaDelete: function(target){
                    var name = target[0].src;
                    token = "{{ csrf_token() }}";
                    $.ajax({
                        type: 'post',
                        data: 'filename='+name+'&_token='+token,
                        url: "{{url('summernote/picture/delete/deals')}}",
                        success: function(data){
                            // console.log(data);
                        }
                    });
                }
            }
        });
        $(".file").change(function(e) {
            console.log($(this))
            var btnRemove = $(this).parent().next()[0]
            var widthImg  = 500;
            var heightImg = 500;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width != widthImg && this.height != heightImg) {
                        toastr.warning("Please check dimension of your photo.");
                        btnRemove.click()
                    }
                };
                image.src = _URL.createObjectURL(file);
            }

        });
    </script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            /* sortable */
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
            $("#selectCategory").select2({
                tags: true
            });
            $(".select2-multiple").select2({
                width: '100%',
                allowClear: true
            });
            $(".select2-rule").select2({
                width: '100%'
            });
            var index = 1;
            $('.add').click(function() {
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
                                                    Badge Rule
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Detail Badge Rule" data-container="body"></i>
                                                </label>
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
                $("#selectCategory").select2({
                    tags: true
                });
                $(".select2-multiple").select2({
                    width: '100%',
                    allowClear: true
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
                    $(form).find('.product_variant_rule_form').hide()
                    if ($(this).is(':checked')) {
                        $(form).find('.product_rule_form').show()
                        $(form).find('.product_variant_rule_form').show()
                    }
                });
                $('.use_variant').change(function() {
                    var form = $(this).parents()[4]
                    $(form).find('.product_variant_rule_option').hide()
                    if ($(this).is(':checked')) {
                        $(form).find('.product_variant_rule_option').show()
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
                $('#additional_rule').show()
                $('#rule_transaction').show()
                $('#additionalnya').show()
                $('#rule_product').show()
                $('#additional_rule_form').show()
                $('#rule_product_add').css('margin-left', '0')
                switch ($(this).val()) {
                    case 'total_product':
                        $('#rule_product').hide()
                        $('#product_total_rule').val("")
                        // toastr.warning("Kamu tidak bisa menggunakan Additional Rule Product Total");
                        break;
                    case 'nominal_transaction':
                        $('.rule_trx').prop('checked', false)
                        $('#rule_transaction').hide()
                        $('.trx_rule_form').hide()
                        $('#nominal_trx').val("")
                        $('#rule_product_add').css('margin-left', '15px')
                        // toastr.warning("Kamu tidak bisa menggunakan Additional Rule Transaction Nominal");
                        break;
                    case 'total_outlet':
                        $('#select_outlet').hide()
                        $('#select_outlet').children().children().val("").trigger("change")
                        // toastr.warning("Kamu tidak bisa menggunakan Additional Rule Outlet");
                        break;
                    case 'total_outlet':
                        $('#outlet_total_rule').val("").trigger("change")
                        $('#select_outlet').hide()
                        $('#select_outlet').children().children().val("").trigger("change")
                        // toastr.warning("Kamu tidak bisa menggunakan Additional Rule Outlet");
                        break;
                    case 'total_province':
                        $('.rule_additional').prop('checked', false)
                        $('.additional_rule_form').hide()
                        $('#additionalnya').hide()
                        $('#province_total_rule').val("").trigger("change") 
                        $('#outlet_total_rule').val("").trigger("change")
                        $('#select_province').hide()
                        $('#select_province').children().children().val("").trigger("change")
                        // toastr.warning("Kamu tidak bisa menggunakan Additional Rule Province");
                        break;
                }
            });
            $('.rule_trx').change(function() {
                var form = $(this).parents()[4]
                $(form).find('.trx_rule_form').hide()
                $(form).find('.nominal_transaksi').val("").trigger("change")
                if ($(this).is(':checked')) {
                    $(form).find('.trx_rule_form').show()
                }
            });
            $('.rule_product').change(function() {
                var form = $(this).parents()[4]
                $(form).find('.id_product').val("").trigger("change")
                $(form).find('.total_product').val("").trigger("change")
                $(form).find('.product_rule_form').hide()
                $(form).find('.product_variant_rule_form').hide()
                $('#product_total_rule').val("")
                if ($(this).is(':checked')) {
                    $(form).find('.product_rule_form').show()
                    $(form).find('.product_variant_rule_form').show()
                }
            });
            $('.use_variant').change(function() {
                var form = $(this).parents()[4]
                $(form).find('.product_variant_rule_option').hide()
                var idProduct = $(form).find('.id_product_variant').val()
                $
                if ($(this).is(':checked')) {
                    $(form).find('.product_variant_rule_option').show()
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
                $(form).find('.id_outlet').val("").trigger("change")
                $(form).find('.id_province').val("").trigger("change")
                $(form).find('.additional_rule_form').hide()
                if ($(this).is(':checked')) {
                    $(form).find('.additional_rule_form').show()
                }
            });
            $('.id_province').change(function() {
                var id_province = $(this).val()
                $.ajax({
                    type: 'GET',
                    url: "{{url('achievement/outlet')}}/" + id_province
                }).then(function (data) {
                    // create the option and append to Select2
                    $('.id_outlet').empty()
                    $.each( data, function( key, value ) {
                        var option = new Option(value.outlet_name, value.id_outlet, true, true);
                        $('.id_outlet').append(option).trigger('change');
                    });
                    $('.id_outlet').val("").trigger("change")
                });
            });
            $('.id_product').change(function() {
                var id_product = $(this).val()
                $.ajax({
                    type: 'GET',
                    url: "{{url('product-variant-group/ajax')}}/" + id_product
                }).then(function (data) {
                    // create the option and append to Select2
                    $('.id_product_variant').empty()
                    $.each( data, function( key, value ) {
                        var option = new Option(value.product_variant_group_name, value.id_product_variant_group, true, true);
                        $('.id_product_variant').append(option).trigger('change');
                    });
                    $('.id_product_variant').val("").trigger("change")
                });
            });
        });
        function removeBox(params) {
            $(params).parent().parent().remove()
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
                <span>{{ $title }}</span> @if (!empty($sub_title))
                <i class="fa fa-circle"></i> @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div>
    <br> 

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">Achivement</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    <div class="portlet-body form">
                        <form id="form" class="form-horizontal" role="form" action="{{ url('achievement/create') }}" method="post" enctype="multipart/form-data">
                            <div class="col-md-8 form-body">
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Category
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Select category or type a new category, if it isn't available in the selection" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-7">
						                <select id="selectCategory" data-placeholder="Select or Type new Category" name="category[name]" class="form-control">
                                            <option></option>
                                            @foreach ($category as $item)
                                                <option value="{{$item['name']}}" @if (old('category.name') == $item['name']) selected @endif>{{$item['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                            Name
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Achievement Name" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="group[name]" value="{{ old('group.name') }}" placeholder="Achievement" required maxlength="30">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                        Image Default Badge
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar deals" data-container="body"></i>
                                        <br>
                                        <span class="required" aria-required="true"> (500*500) </span>
                                        </label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                                <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                                                <div id="classImage">
                                                    <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" accept="image/*" class="file" name="group[logo_badge_default]" value="{{ old('group.logo_badge_default') }}" required>
                                                    </span>
                                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"> Achievement Publish Start Periode <span class="required" aria-required="true"> * </span> </label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form_datetime form-control" name="group[publish_start]" value="{{ old('group.publish_start') }}" required autocomplete="off">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Start Publish Achievement" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"> Achievement Publish End Periode </label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form_datetime form-control" name="group[publish_end]" value="{{ old('group.publish_end.') }}" autocomplete="off">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="End Publish Achievement (Leave this column, if the achievement is active forever)" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"> Achievement Start Periode <span class="required" aria-required="true"> * </span> </label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form_datetime form-control" name="group[date_start]" value="{{ old('group.date_start') }}" autocomplete="off">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Start Peroide Achievement" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"> Achievement End Periode </label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form_datetime form-control" name="group[date_end]" value="{{ old('group.date_end') }}" autocomplete="off">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="End Peroide Achievement (Leave this column, if the achievement is active forever)" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-4 control-label">
                                        Description
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi lengkap tentang deals yang dibuat" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                            <textarea name="group[description]" id="field_content_long" class="form-control summernote" placeholder="Achievement Description">{{ old('group.description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Order By
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih brand untuk deal ini" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <select class="form-control select2-multiple" data-placeholder="Select Brand" name="group[order_by]" required>
                                                <option value="trx_nominal" @if (old('group.order_by') == 'trx_nominal') selected @endif>Transaction Nominal</option>
                                                <option value="trx_total" @if (old('group.order_by') == 'trx_total') selected @endif>Transaction Total</option>
                                                <option value="different_outlet" @if (old('group.order_by') == 'different_outlet') selected @endif>Different Outlet</option>
                                                <option value="different_province" @if (old('group.order_by') == 'different_province') selected @endif>Different Province</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Achievement Total Rule
                                        <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the achievement is not based on the transaction" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <select class="form-control select2-rule" name="rule_total" id="total_rule" data-placeholder="Select Total Rule By">
                                                    <option></option>
                                                    <option value="nominal_transaction">Transaction Nominal</option>
                                                    <option value="total_transaction">Transaction Total</option>
                                                    <option value="total_product">Product Total</option>
                                                    <option value="total_outlet">Outlet Different</option>
                                                    <option value="total_province">Province Different</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="additional_rule" hidden>
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                            Achievement Additional Rule
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Detail Achievement Name" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-9">
                                        <div class="mt-checkbox-inline">
                                            <label class="mt-checkbox" style="margin-left: 15px;" id="rule_transaction">
                                                <input type="checkbox" class="rule_trx"> Transaction
                                                <span></span>
                                            </label>
                                            <label class="mt-checkbox" id="rule_product_add">
                                                <input type="checkbox" class="rule_product"> Product
                                                <span></span>
                                            </label>
                                            <label class="mt-checkbox" id="additionalnya">
                                                <input type="checkbox" class="rule_additional"> Additional
                                                <span></span>
                                            </label>
                                            {{-- <label class="mt-checkbox">
                                                <input type="checkbox" class="rule_total"> Total
                                                <span></span>
                                            </label> --}}
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
                                                <input type="text" class="form-control digit_mask nominal_transaksi" name="rule[trx_nominal]" id="nominal_trx" placeholder="Transaction Nominal">
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
                                            <select class="form-control select2-multiple id_product" data-placeholder="Select Product" name="rule[id_product]">
                                                <option></option>
                                                @foreach ($product as $item)
                                                    <option value="{{$item['id_product']}}">{{$item['product_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="rule_product">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form-control total_product" name="rule[product_total]" id="product_total_rule" placeholder="Total Product">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group product_variant_rule_form" hidden>
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Achievement Product Variant Rule
                                        <i class="fa fa-question-circle tooltips" data-original-title="Select a product variant. leave blank, if the achievement is not based on the product variant" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-checkbox-inline">
                                            <label class="mt-checkbox" style="margin-left: 15px;" id="rule_product_variant">
                                                <input type="checkbox" class="use_variant"> Use Variant
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-offset-3 col-md-4 product_variant_rule_option" hidden>
                                        <div class="input-icon right">
                                            <select class="form-control select2-multiple id_product_variant" data-placeholder="Select Variant" name="rule[id_product_variant_group]">
                                                <option></option>
                                            </select>
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
                                    <div class="col-md-4" id="select_province">
                                        <div class="input-icon right">
                                            <select class="form-control select2-multiple id_province" data-placeholder="Select Province" name="rule[id_province]" id="province_total_rule">
                                                <option></option>
                                                @foreach ($province as $item)
                                                    <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="select_outlet">
                                        <div class="input-icon right">
                                            <select class="form-control select2-multiple id_outlet" data-placeholder="Select Outlet" name="rule[id_outlet]" id="outlet_total_rule">
                                                <option></option>
                                                @foreach ($outlet as $item)
                                                    <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group total_rule_form" hidden>
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
                                </div>   --}}
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Calculate Membership
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Apakah achievement ini digunakan untuk kalkulasi pendapatan di membership?" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mt-radio-inline">
                                            <label class="mt-radio">
                                                <input type="radio" name="group[is_calculate]" value="1"> Yes
                                                <span></span>
                                            </label>
                                            <label class="mt-radio">
                                                <input type="radio" name="group[is_calculate]" value="0"> No
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                            Progress Text
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Progress Text" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="group[progress_text]" placeholder="Text" required maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 form-body">
                                <img class="img-responsive" src="https://staging-jj-customer-view.s3-ap-southeast-1.amazonaws.com/img/achievement/achievement.jpeg" alt="">
                                <br>
                                <p><span class="required" aria-required="true"> * </span> Kotak Hijau &nbsp; : Category Achievement</p>
                                <p><span class="required" aria-required="true"> * </span> Kotak Biru &nbsp;&nbsp;&nbsp; : Achievement</p>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-8 form-body box-repeat" style="display: table;">
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
                                                    Badge Rule
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Detail Badge Rule" data-container="body"></i>
                                                </label>
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
                                    </div>
                                </div>
                                <div class="btn-rmv form-action col-md-12 text-right">
                                    <a href="javascript:;" class="btn btn-success add">
                                        <i class="fa fa-plus"></i> Add New Input
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 form-body">
                                <img class="img-responsive" src="https://staging-jj-customer-view.s3-ap-southeast-1.amazonaws.com/img/achievement/badge.jpeg" alt="">
                                <br>
                                <p><span class="required" aria-required="true"> * </span> Kotak Hijau &nbsp;&nbsp;&nbsp; : Achievement Badge</p>
                                <p><span class="required" aria-required="true"> * </span> Kotak Biru &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Deskripsi Achievement</p>
                                <p><span class="required" aria-required="true"> * </span> Kotak Merah &nbsp; : Progress Text Achievement</p>
                            </div>
                            {{-- @include('deals::deals.step1-form') --}}
                            <div class="form-actions" style="margin-top: 10px;">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn green">Submit</button>
                                        <!-- <button type="button" class="btn default">Cancel</button> -->
                                    </div>
                                </div>
                            </div>
                            {{--
                            <input type="hidden" name="id_deals" value="{{ $deals['id_deals'] }}">
                            <input type="hidden" name="deals_type" value="{{ $deals['deals_type'] }}"> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection