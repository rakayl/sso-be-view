<?php
use App\Lib\MyHelper;
$configs = session('configs');
$grantedFeature     = session('granted_features');
?>
@include('subscription::detail-info')
@include('subscription::detail-info-content')
@include('subscription::participate')
@include('promocampaign::template.promo-extend-period', ['promo_source' => 'subscription'])
@include('promocampaign::template.promo-description', ['promo_source' => 'subscription'])
@extends('layouts.main-closed')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css')}}" rel="stylesheet" type="text/css" /> -->
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" /> 
    <style type="text/css">
		.d-none {
			display: none;
		}
		.width-60-percent {
			width: 60%;
		}
		.width-100-percent {
			width: 100%;
		}
		.width-voucher-img {
			max-width: 200px;
			width: 100%;
		}
		.v-align-top {
			vertical-align: top;
		}
		.p-t-10px {
			padding-top: 10px;
		}
		.page-container-bg-solid .page-content {
			background: #fff!important;
		}
		.text-decoration-none {
			text-decoration: none!important;
		}
		.p-l-0{
			padding-left: 0px;
		}
		.p-r-0{
			padding-right: 0px;
		}
		.p-l-r-0{
			padding-left: 0px;
			padding-right: 0px;
		}
		.font-custom-dark-grey {
			color: #95A5A6!important;
		}
		.font-custom-green {
			color: #26C281!important;
		}
	</style>
@endsection

@section('page-script')

    <!-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/subscription.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js') }}" type="text/javascript"></script>

    <script>
    $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
    $('.timepicker').timepicker();

    $(".form_datetime").datetimepicker({
        format: "d-M-yyyy hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep:1
    });

    </script>

    <script type="text/javascript">        
        var oldOutlet=[];
        function redrawOutlets(list,selected,convertAll, all){
            var html="";
            if(list.length){
                html+="<option value=\"all\">All Outlets</option>";
            }
            list.forEach(function(outlet){
                html+="<option value=\""+outlet.id_outlet+"\">"+outlet.outlet_code+" - "+outlet.outlet_name+"</option>";
            });
            $('select[name="id_outlet[]"]').html(html);
            $('select[name="id_outlet[]"]').val(selected);
            if( all == 1 || ( convertAll && $('select[name="id_outlet[]"]').val() != null && $('select[name="id_outlet[]"]').val().length==list.length ) ){
                $('select[name="id_outlet[]"]').val(['all']);
            }
            oldOutlet=list;
        }

        var oldProduct=[];
        function redrawProducts(list,selected,convertAll,all){
            var html="";
            if(list.length){
                html+="<option value=\"all\">All Products</option>";
            }
            list.forEach(function(product){
                html+="<option value=\""+product.id_product+"\">"+product.product_code+" - "+product.product_name+"</option>";
            });
            $('select[name="id_product[]"]').html(html);
            $('select[name="id_product[]"]').val(selected);
            if( all == 1 || ( convertAll && $('select[name="id_product[]"]').val() != null && $('select[name="id_product[]"]').val().length==list.length ) ){
                $('select[name="id_product[]"]').val(['all']);
            }
            oldProduct=list;
        }

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

            /* SELECT PRICES */
            $('select[name=prices_by]').change(function() {
                price = $('select[name=prices_by] option:selected').val();
                if (price != "free") {
                    $('#prices').show();

                    $('.payment').hide();

                    $('#'+price).show();
                    $('.'+price).prop('required', true);
                    $('.'+price+'Opp').removeAttr('required');
                    $('.'+price+'Opp').val('');
                }
                else {
                    $('#prices').hide();
                    $('.freeOpp').removeAttr('required');
                    $('.freeOpp').val('');
                }
            });

            /* VOUCHER TYPE */
            $('select[name=voucher_type]').change(function() {
                nilai = $('select[name=voucher_type] option:selected').val();

                $('#voucher-value').show();
                $('#discount-max-form, #discount-max-value').hide();
                $("input[name='percent_max']").prop('checked', false);
                $("input[name='subscription_voucher_percent_max']").prop('required', false);

                if (nilai == "percent") {

                    $('#voucher-percent, #discount-max').show();
                    $('#voucher-cash').hide();
                    $("input[name='subscription_voucher_percent'], input[name='percent_max']").prop('required', true);
                    $("input[name='subscription_voucher_nominal']").prop('required', false);
                }
                else {
                    $('#voucher-percent, #discount-max').hide();
                    $('#voucher-cash').show();
                    $("input[name='subscription_voucher_percent'], input[name='percent_max']").prop('required', false);
                    $("input[name='subscription_voucher_nominal']").prop('required', true);

                }
            });

            /* PURCHASE LIMIT */
            $('select[name=purchase_limit]').change(function() {
                nilai = $('select[name=purchase_limit] option:selected').val();

                $("input[name='new_purchase_after']").prop('selected', false);

                if (nilai == "limit") {

                    $('#new-purchase-after').show();
                    $("input[name='new_purchase_after']").prop('required', true);
                }
                else {
                    $('#new-purchase-after').hide();
                    $("input[name='new_purchase_after']").prop('required', false);

                }
            });
            
            /* DISCOUNT MAX */
            $('select[name=percent_max]').change(function() {
                nilai = $('select[name=percent_max] option:selected').val();

                $('#voucher-percent').show();

                if (nilai == "true") {

                    $('#discount-max-form, #discount-max-value').show();
                    $("input[name='subscription_voucher_percent_max']").prop('required', true);
                }
                else {

                    $('#discount-max-form, #discount-max-value').hide();
                    $("input[name='subscription_voucher_percent_max']").prop('required', false);
                }
            });
            
            /* SUBSCRIPTION TOTAL */
            $('select[name=subscription_total_type]').change(function() {
                nilai = $('select[name=subscription_total_type] option:selected').val();
                if (nilai == "limited") {

                    $('#subscription-total-form, #subscription-total-value').show();
                    $("input[name='subscription_total']").prop('required', true);
                }
                else {
                    $('#subscription-total-form, #subscription-total-value').hide();
                    $("input[name='subscription_total']").prop('required', false);
                }
            });

            /* EXPIRY */
            $('select[name=duration]').change(function() {
                nilai = $('select[name=duration] option:selected').val();

                $('#times').show();

                $('.voucherTime').hide();

                $('#'+nilai).show();
                $('.'+nilai).prop('required', true);
                $('.'+nilai+'Opp').removeAttr('required');
                $('.'+nilai+'Opp').val('');
            });
            
            $('.subscriptionPromoType').click(function() {
                $('.subscriptionPromoTypeShow').show();
                var nilai = $(this).val();

                if (nilai == "promoid") {
                    $('.subscriptionPromoTypeValuePromo').show();
                    $('.subscriptionPromoTypeValuePromo').prop('required', true);

                    $('.subscriptionPromoTypeValuePrice').val('');
                    $('.subscriptionPromoTypeValuePrice').hide();
                    $('.subscriptionPromoTypeValuePrice').removeAttr('required', true);
                }
                else {
                    $('.subscriptionPromoTypeValuePrice').show();
                    $('.subscriptionPromoTypeValuePrice').prop('required', true);

                    $('.subscriptionPromoTypeValuePromo').val('');
                    $('.subscriptionPromoTypeValuePromo').hide();
                    $('.subscriptionPromoTypeValuePromo').removeAttr('required', true);
                }
            });

            // upload & delete image on summernote
            $('.summernote').summernote({
                placeholder: true,
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
                            url: "{{url('summernote/picture/delete/subscription')}}",
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
                    url : "{{url('summernote/picture/upload/subscription')}}",
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

            $('.fileinput-preview').bind('DOMSubtreeModified', function() {
                var mentah    = $(this).find('img')
                // set image
                var cariImage = mentah.attr('src')
                var ko        = new Image()
                ko.src        = cariImage
                // load image
                ko.onload     = function(){
                    if (this.naturalHeight === 250 && this.naturalWidth === 600) {
                    } else {
                        mentah.attr('src', "https://www.placehold.it/600x250/EFEFEF/AAAAAA&text=no+image")
                        $('#file').val("");
                        toastr.warning("Please check dimension of your photo.");
                    }
                };
            });
            window.onload = function() {
                $("body").on('click', ".removeRepeater", function() {
                    var mbok = $(this).parent().parent().parent();
                    mbok.remove();
                });
            }

            $('.collapse').collapse({
              toggle: true
            })

            $('.sortable').sortable({
                items: '> div:not(.unsortable)',
                handle: ".sortable-handle",
                connectWith: ".sortable",
                axis: 'y',
            });

            $('.sortable-detail-0').sortable({
                handle: '.sortable-detail-handle-0',
                connectWith: '.sortable-detail-0',
                axis: 'y'
            });

            $('.sortable-detail-1').sortable({
                handle: '.sortable-detail-handle-1',
                connectWith: '.sortable-detail-1',
                axis: 'y'
            });
            $('.sortable-detail-2').sortable({
                handle: '.sortable-detail-handle-2',
                connectWith: '.sortable-detail-2',
                axis: 'y'
            });

            $('.digit_mask').inputmask({
                removeMaskOnSubmit: true, 
                placeholder: "",
                alias: "currency", 
                digits: 0, 
                rightAlign: false,
                min: 0,
                max: 999999999
            });

            $('.digit_mask_min_1').inputmask({
                removeMaskOnSubmit: true, 
                placeholder: "",
                alias: "currency", 
                digits: 0, 
                rightAlign: false,
                min: 1,
                max: 999999999
            });

            $('.percent_mask').inputmask({
                removeMaskOnSubmit: true,
                placeholder: "",
                alias: 'integer',
                min: 0,
                max: 100,
                allowMinus : false,
                rightAlign: false,
                allowPlus : false
            });

            $('#submitButton').click(function () {
                $('input:invalid, select:invalid').each(function () {
                    // Find the tab-pane that this element is inside, and get the id
                    var $closest = $(this).closest('.tab-pane');
                    var id = $closest.attr('id');

                    // Find the link that corresponds to the pane and have it show
                    $('.nav a[href="#' + id + '"]').tab('show');

                    // Only want to do it once
                    return false;
                });
            });

            $('select[name="id_brand"]').on('change',function(){
                var id_brand=$('select[name="id_brand"]').val();
                $.ajax({
                    url:"{{url('outlet/ajax_handler')}}",
                    method: 'GET',
                    data: {
                        select:['id_outlet','outlet_code','outlet_name'],
                        condition:{
                            rules:[
                                {
                                    subject:'id_brand',
                                    parameter:id_brand,
                                    operator:'=',
                                }
                            ],
                            operator:'and'
                        }
                    },
                    success: function(data){
                        if(data.status=='success'){
                            var value = $('select[name="id_outlet[]"]').val();
                            var all = $('select[name="id_outlet[]"]').data('all');
                            var convertAll=false;
                            if($('select[name="id_outlet[]"]').data('value')){
                                value=$('select[name="id_outlet[]"]').data('value');
                                $('select[name="id_outlet[]"]').data('value',false);
                                convertAll=true;
                            }
                            redrawOutlets(data.result,value,convertAll,all);
                        }
                    }
                });

                $.ajax({
                    url:"{{url('product/ajax-product-brand')}}",
                    method: 'GET',
                    data: {
                        select:['id_product','product_code','product_name'],
                        condition:{
                            rules:[
                                {
                                    subject:'id_brand',
                                    parameter:id_brand,
                                    operator:'=',
                                }
                            ],
                            operator:'and'
                        }
                    },
                    success: function(data){
                        if(data.status=='success'){
                            var value=$('select[name="id_product[]"]').val();
                            var all = $('select[name="id_product[]"]').data('all');
                            var convertAll=false;
                            if($('select[name="id_product[]"]').data('value')){
                                value=$('select[name="id_product[]"]').data('value');
                                $('select[name="id_product[]"]').data('value',false);
                                convertAll=true;
                            }
                            redrawProducts(data.result,value,convertAll,all);
                        }
                    }
                });
            });

            $("a[href='#step2']").on('shown.bs.tab', function (e) {
			    $('select[name="id_brand"]').change();
			})
            $('select[name="id_brand"]').change();
        });
    </script>
@if( isset($subscription['subscription_content']) )
    @foreach($subscription['subscription_content'] as $key => $val)
        @if($key > 1)
    <script type="text/javascript">
        $(document).ready(function() {
            $('.sortable-detail-<?php echo $key+1 ?>').sortable({
                handle: '.sortable-detail-handle-<?php echo $key+1 ?>',
                connectWith: '.sortable-detail-<?php echo $key+1 ?>',
                axis: 'y'
            });
        });
    </script>
        @endif
    @endforeach
@endif

    @yield('child-script')
    @yield('extend-period-script')
    @yield('promo-description-script')
@endsection

@section('content')
@php
    $datenow = date("Y-m-d H:i:s");
@endphp
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

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ ($subscription['subscription_total']??0) == 0 || empty($subscription['subscription_total']) ? 'Unlimited' : number_format($subscription['subscription_total']) }}">{{ ($subscription['subscription_total']??0) == 0 || empty($subscription['subscription_total']) ? 'Unlimited' : number_format($subscription['subscription_total']) }}</span>
                    </div>
                    <div class="desc"> Total Subscription </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ ($subscription['subscription_total']??0) == 0 || empty($subscription['subscription_total']) ? 'Unlimited' : number_format($subscription['subscription_total'] * $subscription['subscription_voucher_total']) }}">{{ ($subscription['subscription_total']??0) == 0 || empty($subscription['subscription_total']) ? 'Unlimited' : number_format($subscription['subscription_total'] * $subscription['subscription_voucher_total']) }}</span>
                    </div>
                    <div class="desc"> Total Voucher </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $subscription['subscription_users_count'] }}">{{ $subscription['subscription_users_count'] }}</span>
                    </div>
                    <div class="desc"> Total Bought </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $subscription['total_used_voucher'] }}">{{ $subscription['total_used_voucher'] }}</span>
                    </div>
                    <div class="desc"> Total Used </div>
                </div>
            </a>
        </div>
    </div>
    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">{{ $subscription['subscription_title']??'' }}</span>
            </div>
            <ul class="nav nav-tabs">
                <li class="active" id="infoOutlet">
                    <a href="#info" data-toggle="tab" > Info </a>
                </li>
                <li>
                    <a href="#participate" data-toggle="tab"> Participate </a>
                </li>
                <li class="">
                    <a href="#promo-description" data-toggle="tab"> Promo Description </a>
                </li>
            </ul>
        </div>
        <div class="portlet-body form">
            <div class="tab-content">
                <div class="tab-pane active" id="info">

                	@if(MyHelper::hasAccess([270], $grantedFeature))
	                    @if ($subscription['subscription_step_complete'] != 1)
	                    	<a data-toggle="modal" href="#small" class="btn btn-primary" style="float: right;">Start Subscription</a>
	                    @endif
                    @endif
                	@yield('extend-period-form')
                	{{-- @include('promocampaign::template.promo-extend-period', ['promo_source' => 'subscription']) --}}
                	<ul class="nav nav-tabs" id="tab-header">
                        <li class="active" id="infoOutlet">
                            <a href="#basic" data-toggle="tab" > Basic Info </a>
                        </li>
                        <li>
                            <a href="#content" data-toggle="tab"> Content Info </a>
                        </li>
                        <li>
                            <a href="#outlet" data-toggle="tab"> Outlet Info </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="basic">
                			@yield('detail-info')
                        </div>
                        <div class="tab-pane " id="content">
                			@yield('detail-info-content')
                        </div>
                        @if($subscription['is_all_outlet'] != 1)
                        	@if ($subscription['outlet_groups'])
                        		<div class="tab-pane" id="outlet">
		                            <!-- BEGIN: Comments -->
		                            <div class="mt-comments">
		                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
		                                    <thead>
		                                        <tr>
								                    <th > Outlet Group Filter Name</th>
								                    <th> Filter Type </th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	@foreach($subscription['outlet_groups'] as $key => $res)
							                        <tr style="background-color: #fbfbfb;">
							                            <td > 
							                            	@if(MyHelper::hasAccess([295,297], $grantedFeature))
								                                <a class="" target="_blank" href="{{url('outlet-group-filter/detail', $res['id_outlet_group'])}}">{{ $res['outlet_group_name'] }}</a>
								                            @else
								                            	{{ $res['outlet_group_name'] }} 
								                            @endif
								                        </td>
							                            <td > {{ $res['outlet_group_type'] }} </td>
							                        </tr>
							                    @endforeach
		                                    </tbody>
		                                </table>
		                            </div>
		                            <!-- END: Comments -->
		                        </div>
                            @else
		                        <div class="tab-pane" id="outlet">
		                            <!-- BEGIN: Comments -->
		                            <div class="mt-comments">
		                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
		                                    <thead>
		                                        <tr>
		                                            <th>Code</th>
		                                            <th>Name</th>
		                                            <th>Address</th>
		                                            <th>Phone</th>
		                                            <th>Email</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                        @foreach( ($promotion_outlets??$subscription['outlets']) as $res)
		                                            <tr>
		                                                <td>{{ $res['outlet_code'] }}</td>
		                                                <td>{{ $res['outlet_name'] }}</td>
		                                                <td>{{ $res['outlet_address'] }}</td>
		                                                <td>{{ $res['outlet_phone'] }}</td>
		                                                <td>{{ $res['outlet_email'] }}</td>
		                                            </tr>
		                                        @endforeach
		                                    </tbody>
		                                </table>
		                            </div>
		                            <!-- END: Comments -->
		                        </div>
		                    @endif
		                @else
		                	<div class="tab-pane" id="outlet">
		                		<div class="alert alert-warning">
                                    This Subscription applied to <strong>All Outlet</strong>.
                                </div>
		                	</div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane" id="participate">
                	<input type="hidden" name="id_subscription" value="{{ $subscription['id_subscription']??'' }}">
                    @yield('participate')
                </div>
                <div class="tab-pane" id="promo-description">
                    @yield('promo-description')
                </div>
            </div>
        </div>
    </div>

    @if ($subscription['subscription_step_complete'] != 1)
    <div class="modal fade bs-modal-sm" id="small" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Start Subscription?</h4>
                </div>
                <form action="{{url($rpage.'/update-complete')}}" method="post">
                	@csrf
                	<input type="hidden" name="id_subscription" value="{{$subscription['id_subscription']}}">                	
	                <div class="modal-footer">
	                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
	                    <button type="submit" class="btn green">Confirm</button>
	                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @endif
@endsection