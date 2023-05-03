@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .repeater-btn-remove{
            position: absolute;
            top: 0px;
            left: 21%;
        }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>

    <script type="text/javascript">
        $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });
        $('.timepicker').timepicker();


        $(".form_datetime").datetimepicker({
            format: "d-M-yyyy hh:ii",
            autoclose: true,
            todayBtn: true
        });

        //  form repeater
        var radio_id = 10;
        $('.mt-repeater').repeater({
            show: function () {
                $(this).slideDown();
                // init select2
                var last_item = $('.mt-repeater-item').last();
                last_item.find('.tooltips').tooltip();
                last_item.find('.select2').select2({ width: '100%' });
                // give id and for attribute to metronic radio
                last_item.find('.md-radio').each(function() {
                    $(this).find('input').attr('id','radio'+radio_id);
                    $(this).find('label').attr('for','radio'+radio_id);
                    radio_id++;
                });
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
        });

        $( ".mt-repeater" ).on( "keyup", ".price", numberFormat);

        $(document).ready(function() {
            var _URL = window.URL || window.webkitURL;

            $('.price').each(function() {
                var input = $(this).val();
                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt( input, 10 ) : 0;

                $(this).val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "id" );
                });
            });
            token = '<?php echo csrf_token();?>';

            /* TYPE VOUCHER */
            $('.voucherType').click(function() {
                // tampil duluk
                var nilai = $(this).val();

                if (nilai == "List Vouchers") {
                    $('#listVoucher').show();
                    $('.listVoucher').prop('required', true);

                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                }
                else if(nilai == "Unlimited") {
                    $('.generateVoucher').val('');
                    $('.listVoucher').val('');
                    $('.listVoucher').removeAttr('required');

                    $('#listVoucher').hide();
                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                }
                else {
                    $('#generateVoucher').show();
                    $('.generateVoucher').prop('required', true);

                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                }
            });

            /* PRICES */
            $('.prices').click(function() {
                var nilai = $(this).val();

                if (nilai != "free") {
                    $('#prices').show();

                    $('.payment').hide();

                    $('#'+nilai).show();
                    $('.'+nilai).prop('required', true);
                    $('.'+nilai+'Opp').removeAttr('required');
                    $('.'+nilai+'Opp').val('');
                }
                else {
                    $('#prices').hide();
                    $('.freeOpp').removeAttr('required');
                    $('.freeOpp').val('');
                }
            });

            // show or hide deals promo type input
            $(document).on('click', '.dealsPromoType', function() {
                var nilai = $(this).val();
                var parent = $(this).parents('.promo-type');

                parent.find('.dealsPromoTypeShow').show();

                if (nilai == "promoid") {
                    parent.find('.dealsPromoTypeValuePromo').show();
                    parent.find('.dealsPromoTypeValuePromo').prop('required', true);

                    parent.find('.dealsPromoTypeValuePrice').val('');
                    parent.find('.dealsPromoTypeValuePrice').hide();
                    parent.find('.dealsPromoTypeValuePrice').removeAttr('required', true);
                    parent.find('.dealsPromoTypeValueItem').val('');
                    parent.find('.dealsPromoTypeValueItem').hide();
                    parent.find('.dealsPromoTypeValueItem').removeAttr('required', true);
                    parent.find('.select2-container').hide();
                }
                else if (nilai == "nominal") {
                    parent.find('.dealsPromoTypeValuePrice').show();
                    parent.find('.dealsPromoTypeValuePrice').prop('required', true);

                    parent.find('.dealsPromoTypeValuePromo').val('');
                    parent.find('.dealsPromoTypeValuePromo').hide();
                    parent.find('.dealsPromoTypeValuePromo').removeAttr('required', true);
                    parent.find('.dealsPromoTypeValueItem').val('');
                    parent.find('.dealsPromoTypeValueItem').hide();
                    parent.find('.dealsPromoTypeValueItem').removeAttr('required', true);
                    parent.find('.select2-container').hide();
                }
                else {
                    parent.find('.dealsPromoTypeValueItem').show();
                    parent.find('.dealsPromoTypeValueItem').prop('required', true);
                    parent.find('.select2-container').show();

                    parent.find('.dealsPromoTypeValuePrice').val('');
                    parent.find('.dealsPromoTypeValuePrice').hide();
                    parent.find('.dealsPromoTypeValuePrice').removeAttr('required', true);
                    parent.find('.dealsPromoTypeValuePromo').val('');
                    parent.find('.dealsPromoTypeValuePromo').hide();
                    parent.find('.dealsPromoTypeValuePromo').removeAttr('required', true);
                }
            });

            // check total_voucher_subscription
            $(document).on('keyup change', '.total_voucher', function() {
                var total_voucher_subs = $('.total_voucher_subscription').val();
                var total_voucher = 0;
                $('.total_voucher').each(function() {
                    var total_temp = $(this).val();
                    total_voucher += parseInt(total_temp);
                });

                if (total_voucher > total_voucher_subs) {
                    alert("Total Voucher Qty should not greater than Total Voucher");
                    $('.total_voucher').last().val('');
                    $('.total_voucher').last().focus();
                }
            });

            // check voucher_start and voucher_end
            $(document).on('change', '.voucher_start, .voucher_end', function() {
                var parent = $(this).parents('.mt-repeater-item');
                var voucher_start = parent.find('.voucher_start').val();
                var voucher_end = parent.find('.voucher_end').val();

                if (voucher_start!='' && voucher_end!='' && voucher_start>voucher_end) {
                    alert("Voucher Start should not be greater than Voucher End");
                    $('html, body').animate({
                        scrollTop: ($(this).offset().top - 140)
                    }, 300);
                    $(this).focus();
                }
            });

            // check total voucher and voucher qty
            $('form').on('submit', function(e) {
                var total_voucher_subs = $('.total_voucher_subscription').val();
                var total_voucher = 0;
                $('.total_voucher').each(function() {
                    var total_temp = $(this).val();
                    total_voucher += parseInt(total_temp);
                });

                if (total_voucher != total_voucher_subs) {
                    e.preventDefault();
                    alert('Total Voucher is should be equal with total Voucher Qty');
                    $('html, body').animate({
                        scrollTop: ($('.total_voucher_subscription').offset().top - 70)
                    }, 300);
                }
            });
        });


        // upload & delete image on summernote
        $('.summernote').summernote({
            placeholder: 'Deals Content Long',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
            ],
            callbacks: {
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

        function sendFile(file){
            token = "{{ csrf_token() }}";
            var data = new FormData();
            data.append('image', file);
            data.append('_token', token);
            // document.getElementById('loadingDiv').style.display = "inline";
            $.ajax({
                url : "{{url('summernote/picture/upload/deals')}}",
                data: data,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(url) {
                    if (url['status'] == "success") {
                        $('#field_content_long').summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                    }
                    // document.getElementById('loadingDiv').style.display = "none";
                },
                error: function(data){
                    // document.getElementById('loadingDiv').style.display = "none";
                }
            })
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
                <span class="caption-subject font-blue sbold uppercase ">New {{ $title }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="form">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Title
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Judul deals" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="deals_title" value="{{ old('deals_title') }}" placeholder="Title" required maxlength="30">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Second Title
                            <i class="fa fa-question-circle tooltips" data-original-title="Sub judul deals jika ada" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="deals_second_title" value="{{ old('deals_second_title') }}" placeholder="Second Title" maxlength="30">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Content Long
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi lengkap tentang deals yang dibuat" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <textarea name="deals_description" id="field_content_long" class="form-control summernote">{{ old('deals_description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Deals Periode <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_start" value="{{ old('deals_start') }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_end" value="{{ old('deals_end') }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Publish Periode <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_publish_start" value="{{ old('deals_publish_start') }}" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai deals dipublish" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="deals_publish_end" value="{{ old('deals_publish_end') }}">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai deals dipublish" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Total Voucher
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Total seluruh voucher dalam 1 deals" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <input type="text" class="form-control total_voucher_subscription" name="total_voucher_subscription" value="{{ old('total_voucher_subscription') }}" placeholder="Total Voucher" maxlength="30">
                            </div>
                        </div>
                    </div>

                    {{-- form repeater --}}
        <div class="mt-repeater repeater-radio" style="margin-top: 30px; margin-bottom: 30px;">
            <div data-repeater-list="voucher_subscriptions">
                <div data-repeater-item class="mt-repeater-item mt-overflow col-md-12" style="border-bottom: 1px #ddd;">
                    <div class="repeater-btn-remove">
                        <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-del-right mt-repeater-btn-inline">
                            <i class="fa fa-close"></i>
                        </a>
                    </div>
                    <div class="form-group promo-type">
                        <div class="col-md-offset-3 col-md-9">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Promo Type
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tipe promosi berdasarkan Promo ID, nominal, atau produk promo" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-icon right">
                                    <div class="col-md-4">
                                        <div class="md-radio-inline">
                                            {{-- radio id radio1-radio6 is reserved in deals subsc form --}}
                                            <div class="md-radio">
                                                <input id="radio7" type="radio" name="deals_promo_id_type" class="md-radiobtn dealsPromoType radio_promo_type" value="promoid" required>
                                                <label for="radio7" class="radio_promo_type">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Promo ID
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input id="radio8" type="radio" name="deals_promo_id_type" class="md-radiobtn dealsPromoType radio_nominal_type" value="nominal" required>
                                                <label for="radio8" class="radio_nominal_type">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Nominal
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input id="radio9" type="radio" name="deals_promo_id_type" class="md-radiobtn dealsPromoType radio_item_type" value="free item" required>
                                                <label for="radio9" class="radio_item_type">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Free Item
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dealsPromoTypeShow" style="display: none;">
                            <div class="col-md-offset-3 col-md-9">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="text" class="form-control dealsPromoTypeValuePromo" name="deals_promo_id_promoid" placeholder="Input Promo ID">

                                    <input type="text" class="form-control dealsPromoTypeValuePrice price" name="deals_promo_id_nominal" placeholder="Input nominal">

                                    <select class="form-control select2 dealsPromoTypeValueItem" name="deals_promo_id_free_item" data-placeholder="Select Item">
                                        @if (!empty($products))
                                            @foreach ($products as $product)
                                                <option value="{{ $product['id_product'] }}">{{ $product['product_name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <label class="col-md-3 control-label">
                                Voucher Qty
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Jumlah voucher dalam 1 tipe promo" data-container="body"></i>
                            </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control total_voucher" name="total_voucher" placeholder="Voucher Quantity" maxlength="30" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <label class="col-md-3 control-label">
                                Voucher Start
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Berapa hari voucher akan aktif semenjak deals diklaim" data-container="body"></i>
                            </label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="number" class="form-control voucher_start" name="voucher_start" required>
                                    <span class="input-group-addon">
                                        day(s)
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <label class="col-md-3 control-label">
                                Voucher End
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Berapa hari voucher akan kadaluwarsa semenjak deals diklaim" data-container="body"></i>
                            </label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="number" class="form-control voucher_end" name="voucher_end" required>
                                    <span class="input-group-addon">
                                        day(s)
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix">
                <div class="col-md-offset-3 col-md-9">
                    <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">Add Voucher</a>
                </div>
            </div>
        </div>

                    {{-- end of form repeater --}}

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Image
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar deals" data-container="body"></i>
                            <br>
                            <span class="required" aria-required="true"> (300*300) </span>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                      <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                    <div>
                                        <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" accept="image/*" name="deals_image" required id="file">

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
                            Outlet Available
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple required>
                                <optgroup label="Outlet List">
                                    @if (!empty($outlet))
                                        <option value="all" @if (old('id_outlet')) @if(in_array('all', old('id_outlet'))) selected @endif @endif>All Outlets</option>
                                        @foreach($outlet as $suw)
                                            <option value="{{ $suw['id_outlet'] }}" @if (old('id_outlet')) @if(in_array($suw['id_outlet'], old('id_outlet'))) selected @endif @endif>{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- include deals subscription form -->
                    @include('deals::subscription.deals_subscription_form')

                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="hidden" name="deals_type" value="{{ $deals_type }}">
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection