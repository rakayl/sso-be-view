@php 
	date_default_timezone_set('Asia/Jakarta');
@endphp
@extends('layouts.main-closed')
@include('promocampaign::bulkForm')
@include('promocampaign::buyXgetYForm')
@include('promocampaign::discount-bill')
@include('promocampaign::discount-delivery')
@include('promocampaign::template.promo-global-requirement', ['promo_source' => 'promo_campaign'])
@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
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
		.select2-container .select2-search__field {
			width: 100% !important;
		}
		.select2-results__option[aria-selected=true] {
			/*display: none;*/
		}
		.bxgy-product-benefit .select2-selection--single {
			height: 100% !important;
		}
		.select2-selection__rendered{
			word-wrap: break-word !important;
			text-overflow: inherit !important;
			white-space: normal !important;
		}
	</style>

@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/custom-select2.full.js') }}" type="text/javascript"></script>
	{{-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script> --}}
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/table-datatables-buttons.js') }}" type="text/javascript"></script>
	
	@php
		$is_all_product 	= null;
		$product 			= null;
		$is_all_outlet 		= null;
		$outlet			 	= null;
		$outlet_groups		= null;
		$payment_method		= null;
		$shipment_method	= null;
        $product_type 		= $result['product_type'] ?? 'single';

		if (isset($result['is_all_outlet']) && $result['is_all_outlet'] == "0") {
			$is_all_outlet = $result['is_all_outlet'];
			$outlet = [];
			for ($i=0; $i < count($result['outlets']); $i++) { 
				$outlet[] = $result['outlets'][$i]['id_outlet'];
			}

			$outlet_groups = [];
			foreach (($result['outlet_groups'] ?? []) as $value) {
				$outlet_groups[] = $value['id_outlet_group'];
			}
		}

		$promo_product = $result['promo_campaign_product_discount'] ?: $result['promo_campaign_tier_discount_product'] ?: $result['promo_campaign_buyxgety_product_requirement'] ?: $result['promo_campaign_discount_bill_products'] ?: [];

		if (isset($result['promo_campaign_product_discount_rules']['is_all_product']) && $result['promo_campaign_product_discount_rules']['is_all_product'] == "0") {
			$is_all_product = $result['promo_campaign_product_discount_rules']['is_all_product'];
			$product = [];
			for ($i=0; $i < count($result['promo_campaign_product_discount']); $i++) { 
				$product[] = $result['promo_campaign_product_discount'][$i]['id_brand'].'-'.$result['promo_campaign_product_discount'][$i]['id_product'].'-'.$result['promo_campaign_product_discount'][$i]['id_product_variant_group'];
			}
		}else{
			$product = [];
			foreach ($promo_product as $key => $value) {
				if ($product_type == 'variant') {
					if ($result['promo_type'] == 'Buy X Get Y' && isset($value['promo_campaign_buyxgety_product_modifiers'])) {
						$extra_modifier = array_column($value['promo_campaign_buyxgety_product_modifiers'], 'id_product_modifier');
						$text_product[] = $value['id_brand'].'-'.$value['id_product_variant_group'];
						$text_product[] = implode('-', $extra_modifier);
						$product[] = implode('-', $text_product);
					}else{
						$product[] = $value['id_brand'].'-'.$value['id_product'].'-'.$value['id_product_variant_group'];
					}
				}else{
					$product[] = $value['id_brand'].'-'.$value['id_product'].'-'.$value['id_product_variant_group'];
				}
			}
		}
	
		if (isset($result['is_all_outlet']) && $result['is_all_outlet'] == "0") {
			$is_all_outlet = $result['is_all_outlet'];
			$outlet = [];
			for ($i=0; $i < count($result['outlets']); $i++) { 
				$outlet[] = $result['outlets'][$i]['id_outlet'];
			}
		}

		$datenow = date("Y-m-d H:i:s");
		if ($result??false) {
            $date_start = $result['date_start'];
            $date_end   = $result['date_end'];
        }elseif($result['vouchers']??false){
            $date_start = $result['vouchers']['voucher_publish_start'];
            $date_end   = $result['vouchers']['voucher_publish_end'];
        }else{
            $date_start = null;
            $date_end   = null;
        }

        $brands = array_column($result['brands'], 'id_brand');
        $brand_rule = $result['brand_rule'];
        $is_all_product_bill = $result['promo_campaign_discount_bill_rules']['is_all_product']??1;
	@endphp
	<script>
	$(document).ready(function() {
		listProduct=[];
		productLoad = 0;
		selectedProduct = JSON.parse('{!!json_encode($product)!!}');

		var is_all_product = '{!!$is_all_product!!}';
		var is_all_product_bill = {{ $is_all_product_bill }};
		var brand = JSON.parse('{!!json_encode($brands)!!}');
		var brand_rule = '{!!$brand_rule!!}';
		var product_type = '{!!$product_type!!}';

		// load product benefit for promo buy x get y
		$.ajax({
			type: "GET",
			url: "getData",
			data : {
				"get" : 'Product',
				"brand" : brand,
				"product_type" : 'single'
			},
			dataType: "json",
			success: function(data){
				if (data.status == 'fail') {
					$.ajax(this)
					return
				}
				// productLoad = 1;
				listProduct=data;
			}
		});

		$.ajax({
			type: "GET",
			url: "getData",
			data : {
				"get" : 'Outlet',
				"brand" : brand,
				'brand_rule' : brand_rule
			},
			dataType: "json",
			success: function(data){
				if (data.status == 'fail') {
					$.ajax(this)
					return
				}
				listOutlet=data;
				$.each(data, function( key, value ) {
					$('#multipleOutlet').append("<option id='outlet"+value.id_outlet+"' value='"+value.id_outlet+"'>"+value.outlet+"</option>");
				});

			},
			complete: function(data){
				if (data.responseJSON.status != 'fail') {
					selectedOutlet = JSON.parse('{!!json_encode($outlet)!!}')
					$.each(selectedOutlet, function( key, value ) {
						$("#outlet"+value+"").attr('selected', true)
					});
				}
			}
		});

		$.ajax({
			type: "GET",
			url: "getData",
			data : {
				"get" : 'Outlet Group',
				"brand" : brand,
				'brand_rule' : brand_rule
			},
			dataType: "json",
			success: function(data){
				if (data.status == 'fail') {
					$.ajax(this)
					return
				}
				list_outlet_group = data;
				$.each(data, function( key, value ) {
					$('#multiple-outlet-group').append("<option id='outlet-group-"+value.id_outlet_group+"' value='"+value.id_outlet_group+"'>"+value.outlet_group_name+"</option>");
				});

			},
			complete: function(data){
				if (data.responseJSON.status != 'fail') {
					selected_outlet_group = JSON.parse('{!!json_encode($outlet_groups)!!}')
					$.each(selected_outlet_group, function( key, value ) {
						$("#outlet-group-"+value+"").attr('selected', true)
					});
				}
			}
		});

		$('input[name=filter_user]').change(function() {
			user = $('input[name=filter_user]:checked').val()
			$('input[name=specific_user]').prop('required', false)
			$('input[name=specific_user]').prop('disabled', true)
			if (user == 'Specific User') {
				$('#specific-user').show()
 
			} else {
				$('#specific-user').hide()
			}
		});

		$('#selectProduct, #product-rule-option').hide()
		function loadProduct(selector,callback){
			if (productLoad == 0) {
				// var valuee=$(selector).data('value');
				$.ajax({
					type: "GET",
					url: "getData",
					data : {
						"get" : 'Product',
						"brand" : brand,
						"product_type" : product_type
					},
					dataType: "json",
					success: function(data){
						if (data.status == 'fail') {
							$.ajax(this)
							return
						}
						// listProduct=data;
						productLoad = 1;
						$.each(data, function( key, value ) {
							/*if(valuee.indexOf(value.id_product)>-1){
								var more='selected';
							}else{
								var more='';
							}*/
							let more='';
							$('#multipleProduct,#multipleProduct2,#multipleProduct3,#multiple-product-bill,#multiple-product-tier-discount,#multiple-product-bxgy').append("<option class='product"+value.id_brand+'-'+value.id_product+'-'+value.id_product_variant_group+"' value='"+value.id_brand+'-'+value.id_product+'-'+value.id_product_variant_group+"' "+more+">"+value.product+"</option>");
						});
						$.each(selectedProduct, function( key, value ) {
							$(".product"+value+"").attr('selected', true)
						});
						if(is_all_product_bill != 1){
							$(selector).prop('required', true)
						}
						$(selector).prop('disabled', false)
						if(callback){callback()}
					}
				});
			}
		}
		function changeTriger () {
			$('#tabContainer .tabContent').hide();
			promo_type = $('select[name=promo_type] option:selected').val();
			// $('#tabContainer input:not(input[name="promo_type"]),#tabContainer select').prop('disabled',true);
			$('#productDiscount, #bulkProduct, #buyXgetYProduct, #discount-bill, #discount-delivery').hide().find('input, textarea, select').prop('disabled', true);

			if (promo_type == 'Product discount') {
				product = $('select[name=filter_product] option:selected').val();
				$('#productDiscount').show().find('input, textarea, select').prop('disabled', false);
				if (product == 'All Product') {
					$('#multipleProduct').find('select').prop('disabled', true);
				}else {
					$('#multipleProduct').prop('disabled', false);
				}
			}else if(promo_type == 'Tier discount'){

				reOrder();
				$('#bulkProduct').show().find('input, textarea, select').prop('disabled', false);
				// loadProduct('#multipleProduct2');
				loadProduct('#multiple-product-tier-discount');
			}else if(promo_type=='Buy X Get Y'){

				reOrder2();
				$('#buyXgetYProduct').show().find('input, textarea, select').prop('disabled', false);
				// loadProduct('#multipleProduct3',reOrder2);
				loadProduct('#multiple-product-bxgy',reOrder2);
			}
			else if(promo_type == 'Discount bill'){
				product = $('select[name=filter_product_bill] option:selected').val();
				$('#discount-bill').show().find('input, textarea, select').prop('disabled', false);
				loadProduct('#multiple-product-bill');
				if (product == 'All Product') {
					$('#multiple-product-bill').find('select').prop('disabled', true);
				}else {
					$('#multiple-product-bill').prop('disabled', false);
				}
			}
			else if(promo_type == 'Discount delivery'){

				$('#discount-delivery').show().find('input, textarea, select').prop('disabled', false);
			}
		}

		$('select[name=promo_type]').change(changeTriger);
		$('select[name=filter_product]').change(function() {
			product = $('select[name=filter_product] option:selected').val()
			$('#multipleProduct').prop('required', false)
			$('#multipleProduct').prop('disabled', true)
			if (product == 'Selected') {
				$('#selectProduct, #product-rule-option').show()
				if (productLoad == 0) {
					$.ajax({
						type: "GET",
						url: "getData",
						data : {
							"get" : 'Product',
							"brand" : brand,
							"product_type" : product_type
						},
						dataType: "json",
						success: function(data){
							productLoad = 1;
							// listProduct=data;
							$.each(data, function( key, value ) {
								let more='';
								$('#multipleProduct,#multipleProduct2,#multipleProduct3,#multiple-product-bill,#multiple-product-tier-discount,#multiple-product-bxgy').append("<option class='product"+value.id_brand+'-'+value.id_product+'-'+value.id_product_variant_group+"' value='"+value.id_brand+'-'+value.id_product+'-'+value.id_product_variant_group+"' "+more+">"+value.product+"</option>");
							});
							$.each(selectedProduct, function( key, value ) {
								$(".product"+value+"").attr('selected', true)
							});
							$('#multipleProduct').prop('required', true)
							$('#multipleProduct').prop('disabled', false)
						}
					});
				} else {
					$('#multipleProduct').prop('required', true)
					$('#multipleProduct').prop('disabled', false)
				}
			} else {
				$('#selectProduct, #product-rule-option').hide()
			}
		});
		$('input[name=discount_type]').change(function() {
			discount_value = $('input[name=discount_type]:checked').val();
			$('#product-discount-div').show();
			if (discount_value == 'Nominal') {
				$('input[name=discount_value]').removeAttr('max').val('').attr('placeholder', '100.000').inputmask({removeMaskOnSubmit: "true", placeholder: "", alias: "currency", digits: 0, rightAlign: false});
				$('#product-discount-value').text('Discount Nominal');
				$('#product-discount-addon, #product-discount-percent-max-div').hide();
				$('#product-addon-rp').show();
				$('#product-discount-group').addClass('col-md-12');
				$('#product-discount-group').removeClass('col-md-5');
				$('input[name=max_percent_discount]').val('');
			} else {
				$('input[name=discount_value]').attr('max', 100).val('').attr('placeholder', '50').inputmask({
					removeMaskOnSubmit: true,
					placeholder: "",
					alias: 'integer',
					min: '0',
					max: '100',
					allowMinus : false,
					allowPlus : false
				});
				$('#product-discount-value').text('Discount Percent Value');
				$('#product-addon-rp').hide();
				$('#product-discount-addon, #product-discount-percent-max-div').show();
				$('#product-discount-group').addClass('col-md-5');
				$('#product-discount-group').removeClass('col-md-12');
			}
			$('input[name=discount_value]').removeAttr("style");
		});

		$('input[name=discount_global_type]').change(function() {
			discount_value = $('input[name=discount_global_type]:checked').val()
			if (discount_value == 'Nominal') {
				$('input[name=discount_global_value]').removeAttr('max')
			} else {
				$('input[name=discount_global_value]').attr('max', 100)
			}
		});
		
		var is_all_product = '{!!$is_all_product!!}'
		if (is_all_product == 0 && is_all_product.length != 0) {
			$('#productDiscount').show()
			$('#selectProduct, #product-rule-option').show()
			if (productLoad == 0) {
				$.ajax({
					type: "GET",
					url: "getData",
					data : {
						"get" : 'Product',
						"brand" : brand,
						"product_type" : product_type
					},
					dataType: "json",
					success: function(data){
						if (data.status == 'fail') {
							$.ajax(this)
							return
						}
						productLoad = 1;
						// listProduct=data;
						$.each(data, function( key, value ) {
							let more='';
							$('#multipleProduct,#multipleProduct2,#multipleProduct3,#multiple-product-bill,#multiple-product-tier-discount,#multiple-product-bxgy').append("<option class='product"+value.id_brand+'-'+value.id_product+'-'+value.id_product_variant_group+"' value='"+value.id_brand+'-'+value.id_product+'-'+value.id_product_variant_group+"' "+more+">"+value.product+"</option>");
						});
						$.each(selectedProduct, function( key, value ) {
							$(".product"+value+"").attr('selected', true)
						});
						$('#multipleProduct').prop('required', true)
						$('#multipleProduct').prop('disabled', false)
					},
					complete: function(data){
						if (data.responseJSON.status != 'fail') {
							selectedProduct = JSON.parse('{!!json_encode($product)!!}')
							$.each(selectedProduct, function( key, value ) {
								$("#product"+value+"").attr('selected', true)
							});
						}
					}
				});
			} else {
				$('#multipleProduct').prop('required', true)
				$('#multipleProduct').prop('disabled', false)
			}
		}
		$('button[type="submit"]').on('click',function(){
			changeTriger();
		});
		changeTriger();

		$('.digit_mask').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: 0,
			max: '999999999'
		});

		$('input[name=filter_outlet]').on('click', function(){
			outlet = $(this).val();

			if(outlet == 'Selected') {
				$('#selectOutlet').show();
				$('#select-outlet-group').hide();
				$("select[name='multiple_outlet[]']").prop('required', true);
                $("select[name='multiple_outlet_group[]']").prop('required', false);
			}
			else if (outlet == 'Outlet Group') {
				$('#select-outlet-group').show();
				$('#selectOutlet').hide();
				$("select[name='multiple_outlet[]']").prop('required', false);
                $("select[name='multiple_outlet_group[]']").prop('required', true);
			}
			else {
				$('#selectOutlet, #select-outlet-group').hide();
				$("select[name='multiple_outlet[]']").prop('required', false);
                $("select[name='multiple_outlet_group[]']").prop('required', false);
			}
		});

		$('#multipleProduct,#multipleProduct2,#multipleProduct3,#multiple-product-bill,#multiple-product-tier-discount,#multiple-product-bxgy,#multipleOutlet,#multiple-outlet-group').select2({
		    "closeOnSelect": false,
		    "width": "100%"
		}).on('select2:select select2:open', function(evt) {
			var $container = $(this).data("select2").$container.find(".select2-selection__rendered");
			var $results = $(".select2-dropdown--below");
			$results.position({
				my: "top",
				at: "bottom",
				of: $container
			});
		})
		.on('select2:selecting select2:unselecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
	    .on('select2:select select2:unselect', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')));
	});
	</script>
	@yield('child-script')
	@yield('child-script2')
	@yield('discount-bill-script')
	@yield('discount-delivery-script')
	@yield('global-requirement-script')
	<style>
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
		-webkit-appearance: none; 
		margin: 0; 
	}
	</style>
	{{-- if promo campaign already used --}}
	@if( !empty($result['promo_campaign_reports']) && isset($result['step_complete']) && session('level') != 'Super Admin' )
	<script type="text/javascript">
		$(document).ready(function() {
			$('#promotype-form').find('input, textarea, select').prop('disabled', true);
			$('#user-search-form').find('input, textarea').prop('disabled', true);
		});
	</script>
	@endif

	@if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Percent")
	<script>
		$('input[name=discount_value]').attr('placeholder', '50').inputmask({
			removeMaskOnSubmit: true,
			placeholder: "",
			alias: 'integer',
			min: '0',
			max: '100',
			allowMinus : 'false',
			allowPlus : 'false',
			rightAlign: "false"
		});
	</script>
	@else
	<script>
		$('input[name=discount_value]').inputmask({placeholder: "", removeMaskOnSubmit: "true", alias: "currency", digits: 0, rightAlign: false,prefix: ""});
	</script>
	@endif
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{ secure_url('/')}}">Home</a>
			@if (!empty($title))
                <i class="fa fa-circle"></i>
            @endif
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

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="mt-element-step">
			<div class="row step-line">
				<div class="col-md-6 mt-step-col first">
					<a href="{{ ($result['id_promo_campaign'] ?? false) ? url('promo-campaign/step1/'.$result['id_promo_campaign']) : '' }}" class="text-decoration-none">
						<div class="mt-step-number bg-white">1</div>
						<div class="mt-step-title uppercase font-grey-cascade">Campaign Info</div>
						<div class="mt-step-content font-grey-cascade">Campaign Name, Title, Type & Total</div>
					</a>
				</div>
				<div class="col-md-6 mt-step-col active last">
					<div class="mt-step-number bg-white">2</div>
					<div class="mt-step-title uppercase font-grey-cascade">Campaign Detail</div>
					<div class="mt-step-content font-grey-cascade">Detail Campaign Information</div>
				</div>
			</div>
		</div>
	</div>
	<form role="form" action="" method="POST" enctype="multipart/form-data">
		@if( !empty($result['promo_campaign_reports']) && isset($result['step_complete']) && session('level') != 'Super Admin')
			<input type="hidden" name="used_code_update" value="1">
		@endif
		<div class="col-md-12">
			{{-- DETAIL CAMPAIGN INFORMATION --}}
			<div class="col-md-7">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Information</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row static-info">
							<div class="col-md-4 name">Campaign Name</div>
							<div class="col-md-8 value">: {{ isset($result['campaign_name']) ? $result['campaign_name'] : '' }}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Promo Title</div>
							<div class="col-md-8 value">: {{ isset($result['promo_title']) ? $result['promo_title'] : '' }}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Promo Use</div>
							<div class="col-md-8 value">: {{ isset($result['promo_use_in']) ? $result['promo_use_in'] : '' }}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Visibility</div>
							<div class="col-md-8 value">: {{ isset($result['promo_campaign_visibility']) ? $result['promo_campaign_visibility'] : '' }}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Campaign Type</div>
							<div class="col-md-8 value">: {{ !empty($result['vouchers']) ? 'Voucher' : 'Promo code' }}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Charged Central</div>
							<div class="col-md-8 value">: {{$result['charged_central']}} %</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Charged Outlet</div>
							<div class="col-md-8 value">: {{$result['charged_outlet']}} %</div>
						</div>
						@if((!empty($result['promo_use_in']) && $result['promo_use_in'] == 'Product') || empty($result['promo_use_in']))
						<div class="row static-info">
                            <div class="col-md-4 name">Brand</div>
                            <div class="col-md-8 value">: 
                            	@php
                            		foreach ($result['brands'] as $key => $value) {
	                            		if ($key == 0) {
	                            			$comma = '';
	                            		}else{
	                            			$comma = ', ';
	                            		}
	                            		echo $comma.$value['name_brand'];
                            		}
                            	@endphp</div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 name">Brand Rule</div>
                            <div class="col-md-8 value">: 
                                {{ $result['brand_rule'] && $result['brand_rule'] == 'and' ? 'All selected brands' : 'One of the selected brands' }}
                            </div>
                        </div>						
						<div class="row static-info">
							<div class="col-md-4 name">Product Type</div>
							<div class="col-md-8 value">: 
								@php
									$product_type = $result['product_type'] ?? 'single';
									$echo = "";
									switch ($product_type) {
										case 'single + variant':
											$echo = 'Product + Product variant';
											break;

										case 'variant':
											$echo = 'Product variant only';
											break;
										
										default:
											$echo = 'Product only';
											break;
									}

									echo $echo;
								@endphp
							</div>
						</div>
						@endif
						<div class="row static-info">
							<div class="col-md-4 name">Tag</div>
							@if(isset($result['promo_campaign_have_tags']))
							@php
								$tagID = [];
								for ($i = 0; $i < count($result['promo_campaign_have_tags']); $i++) {
									$tagID[] = $result['promo_campaign_have_tags'][$i]['promo_campaign_tag']['tag_name'];
								}
							@endphp
							@endif
							<div class="col-md-8 value">: {{implode(', ',$tagID)}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Start Date</div>
							<div class="col-md-8 value">: @if(isset($result['date_start'])) {{date("d F Y", strtotime($result['date_start']))}}&nbsp;{{date("H:i", strtotime($result['date_start']))}} @endif</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">End Date</div>
							<div class="col-md-8 value">: @if(isset($result['date_end'])){{date("d F Y", strtotime($result['date_end']))}}&nbsp;{{date("H:i", strtotime($result['date_end']))}} @endif</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Limit Usage</div>
							<div class="col-md-8 value">: {{ $result['limitation_usage']??false != 0 ? number_format($result['limitation_usage']).' Times Usage' : 'Unlimited'}} </div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Total Coupon</div>
							<div class="col-md-8 value">: {{ $result['total_coupon']??false != 0 ? number_format($result['total_coupon']).' Coupons' : 'Unlimited'}} </div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Type Code</div>
							<div class="col-md-8 value">: {{ isset($result['code_type']) ? $result['code_type'] : '' }}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Creator</div>
							<div class="col-md-8 value">: {{ isset($result['user']['name']) ? $result['user']['name'] : '' }}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Level</div>
							<div class="col-md-8 value">: {{ isset($result['user']['level']) ? $result['user']['level'] : ''}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Created</div>
							<div class="col-md-8 value">: @if(isset($result['created_at'])) {{date("d F Y", strtotime($result['created_at']))}}&nbsp;{{date("H:i", strtotime($result['created_at']))}} @endif</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Image</div>
							<div class="col-md-8 value">
								<span style="float: left;margin-right: 5px">:</span>
								<div><img src="{{ $result['url_promo_image'] ?? '' }}" style="width: 100px"></div>
							</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Image Detail</div>
							<div class="col-md-8 value">
								<span style="float: left;margin-right: 5px">:</span>
								<div><img src="{{ $result['url_promo_image_detail'] ?? '' }}" style="width: 225px"></div>
							</div>
						</div>
					</div>
					<div class="row static-info">
						<div class="col-md-4"></div>
						<div class="col-md-4 value">
							<a class="btn blue col-md-12" href="{{url('/')}}/promo-campaign/step1/{{$result['id_promo_campaign']}}">Edit Promo Campaign</a>
						</div>
						<div class="col-md-4"></div>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Filter Promo</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="form-group" style="height: 130px;">
							<label class="control-label">Filter User</label>
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="User yang dapat menggunakan promo code" data-container="body"></i>
							<div class="mt-radio-list">
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="Promo code berlaku untuk semua user" data-container="body"></i> All User
									<input type="radio" value="All User" name="filter_user" @if(isset($result['user_type']) && $result['user_type'] == "All user") checked @endif required/>
									<span></span>
								</label>
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="Promo code hanya berlaku untuk user baru yang belum pernah melakukan transaksi" data-container="body"></i> New User
									<input type="radio" value="New User" name="filter_user" @if(isset($result['user_type']) && $result['user_type'] == "New user" ) checked @endif required/>
									<span></span>
								</label>
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="Promo code hanya berlaku untuk user yang memiliki nomor telepon yang dimasukkan" data-container="body"></i> Specific User
									<input type="radio" value="Specific User" name="filter_user" @if(isset($result['user_type']) && $result['user_type'] == "Specific user") checked @endif required/>
									<span></span>
								</label>
							</div>
						</div>
						<div id="specific-user" class="form-group" @if($result['user_type'] != 'Specific user') style="display: none;" @endif>
							<label>Add User</label>
							<textarea class="form-control" rows="3" name="specific_user" placeholder="081xxxxxxxxx, 082xxxxxxxxx, ..." style="resize: vertical;">{{ $result['specific_user']??null }}</textarea>
							<p class="help-block">Comma ( , ) separated for multiple phone number</p>
						</div>
						<div class="form-group" style="height: 55px;">
							<label class="control-label">Filter Outlet</label>
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang dapat menggunakan promo code" data-container="body"></i>
							<div class="mt-radio-list">
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="Promo code berlaku di semua outlet" data-container="body"></i> All Outlet
									<input type="radio" value="All Outlet" name="filter_outlet" @if(isset($result['is_all_outlet']) && $result['is_all_outlet'] == "1") checked @endif required/>
									<span></span>
								</label>
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="Promo code hanya berlaku untuk outlet tertentu" data-container="body"></i> Selected Outlet
									<input type="radio" value="Selected" name="filter_outlet" @if(empty($result['is_all_outlet']) && !empty($result['outlets'])) checked @endif required/>
									<span></span>
								</label>

								{{-- list outlet --}}
								<div id="selectOutlet" class="form-group" @if($result['is_all_outlet'] == 1  || empty($result['outlets']) ) style="display: none;" @endif>
									<label for="multipleOutlet" class="control-label">Select Outlet</label>
									<select id="multipleOutlet" name="multiple_outlet[]" class="form-control select2-multiple select2-hidden-accessible" multiple="multiple" tabindex="-1" aria-hidden="true" @if(empty($result['is_all_outlet']) && !empty($result['outlets'])) required @endif ></select>
								</div>

								{{-- list outlet group --}}
								<div id="select-outlet-group" class="form-group" @if($result['is_all_outlet'] == 1  || empty($result['outlet_groups']) ) style="display: none;" @endif>
									<label for="multiple-outlet-group" class="control-label">Select Outlet Group</label>
									<select id="multiple-outlet-group" name="multiple_outlet_group[]" class="form-control select2-multiple select2-hidden-accessible" multiple="multiple" tabindex="-1" aria-hidden="true" @if(empty($result['is_all_outlet']) && !empty($result['outlet_groups'])) required @endif ></select>
								</div>
							</div>
						</div>
					<div class="form-group" style="height: 55px;">
					</div>
					</div>

				</div>
			</div>

			{{-- Global Requirement --}}
			<div class="col-md-12">
				@yield('global-requirement')
			</div>

			{{-- PROMO TYPE FORM --}}
			<div class="col-md-12">
				<div class="portlet light bordered" id="promotype-form">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Promo Type</span>
						</div>
					</div>
					<div class="portlet-body" id="tabContainer">
						<div class="form-group" style="height: 55px;display: inline;">
							<div class="row">
								<div class="col-md-3">
									<label class="control-label">Promo Type</label>
									<span class="required" aria-required="true"> * </span>
									@if($result['promo_use_in'] == 'Consultation')
										<i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe promo
										</br>
										</br> Discount Bill : Promo berupa potongan harga untuk total transaksi / bill
										" data-container="body" data-html="true"></i>
									@else
										<i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe promo
										</br>
										</br> Product Discount : Promo berlaku untuk semua product atau product tertentu tanpa jumlah minimum
										</br>
										</br> Bulk/Tier Product : Promo hanya berlaku untuk suatu product setelah melakukan pembelian dalam jumlah yang telah ditentukan
										</br>
{{--										</br> Buy X get Y : Promo hanya berlaku untuk product tertentu--}}
{{--										</br>--}}
										</br> Discount Bill : Promo berupa potongan harga untuk total transaksi / bill
										</br>
										</br> Discount Delivery : Promo berupa potongan harga untuk biaya pengiriman
										" data-container="body" data-html="true"></i>
									@endif

									<select class="form-control" name="promo_type" required>
										<option value="" disabled 
											@if (empty($result['promo_campaign_product_discount_rules'])
												&& empty($result['promo_campaign_tier_discount_rules'])
												&& empty($result['promo_campaign_buyxgety_rules'])
												&& empty($result['promo_campaign_discount_bill_rules'])
												&& empty($result['promo_campaign_discount_delivery_rules'])
											) selected 
											@endif
											> Select Promo Type </option>
										@if($result['promo_use_in'] != 'Consultation')
										<option value="Product discount" 
											@if ( old('promo_type') && old('promo_type') == 'Product discount' ) selected 
											@elseif ( !empty($result['promo_campaign_product_discount_rules']) ) selected 
											@endif
											title="Promo berlaku untuk semua product atau product tertentu tanpa jumlah minimum"
											> Product Discount </option>
										<option value="Tier discount" 
											@if ( old('promo_type') && old('promo_type') == 'Tier discount' ) selected 
											@elseif ( !empty($result['promo_campaign_tier_discount_rules']) ) selected 
											@endif
											title="Promo hanya berlaku untuk suatu product setelah melakukan pembelian dalam jumlah yang telah ditentukan"
											> Bulk/Tier Product </option>
{{--										<option value="Buy X Get Y" --}}
{{--											@if ( old('promo_type') && old('promo_type') == 'Buy X Get Y' ) selected --}}
{{--											@elseif ( !empty($result['promo_campaign_buyxgety_rules']) ) selected --}}
{{--											@endif--}}
{{--											title="Promo hanya berlaku untuk product tertentu"--}}
{{--											> Buy X Get Y </option>--}}
										<option value="Discount delivery"
												@if ( old('promo_type') && old('promo_type') == 'Discount delivery' ) selected
												@elseif ( !empty($result['promo_campaign_discount_delivery_rules']) ) selected
												@endif
												title="Promo berupa potongan harga untuk total transaksi / delivery"
										> Discount Delivery </option>
										@endif
										<option value="Discount bill"
												@if ( old('promo_type') && old('promo_type') == 'Discount bill' ) selected
												@elseif ( !empty($result['promo_campaign_discount_bill_rules']) ) selected
												@endif
												title="Promo berupa potongan harga untuk total transaksi / bill"
										> Discount Bill </option>
		                            </select>
								</div>
							</div>
						</div>
						<div style="display: inline;">
							<div id="productDiscount" class="p-t-10px"> 
								<div class="form-group">
									<div class="row">
										<div class="col-md-3">
											<label class="control-label">Filter Product</label>
											<span class="required" aria-required="true"> * </span>
											<i class="fa fa-question-circle tooltips" data-original-title="Pilih produk yang akan diberikan diskon </br></br>All Product : Promo code berlaku untuk semua product </br></br>Selected Product : Promo code hanya berlaku untuk product tertentu" data-container="body" data-html="true"></i>
											<select class="form-control" name="filter_product">
												<option value="All Product"  @if(isset($result['promo_campaign_product_discount_rules']['is_all_product']) && $result['promo_campaign_product_discount_rules']['is_all_product'] == "1") selected @endif required> All Product </option>
												<option value="Selected" @if(isset($result['promo_campaign_product_discount_rules']['is_all_product']) && $result['promo_campaign_product_discount_rules']['is_all_product'] == "0") selected @endif> Selected Product </option>
				                            </select>
										</div>
									</div>
								</div>

								<div id="selectProduct" class="form-group row" style="width: 100%!important">
									<div class="">
										<div class="col-md-6">
											<label for="multipleProduct" class="control-label">Select Product</label>
											<select id="multipleProduct" name="multiple_product[]" class="form-control select2 select2-hidden-accessible col-md-6" multiple="" tabindex="-1" aria-hidden="true" style="width: 100%!important" @if(isset($result['promo_campaign_product_discount_rules']['is_all_product']) && $result['promo_campaign_product_discount_rules']['is_all_product'] == "0") required @endif>
											</select>
										</div>
									</div>
								</div>

								<div id="product-rule-option">
									<label class="control-label">Product Rule</label>
									<i class="fa fa-question-circle tooltips" data-original-title="Pilih rule yang berlaku ketika transaksi menggunakan syarat product" data-container="body" data-html="true"></i>
									<div class="mt-radio-list">
										<label class="mt-radio mt-radio-outline"> All items must be present
											<input type="radio" value="and" name="product_rule" @if(isset($result['product_rule']) && $result['product_rule'] === 'and' && !empty($result['promo_campaign_product_discount_rules'])) checked @endif/>
											<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku ketika <b>semua</b> syarat product ada dalam transaksi" data-container="body" data-html="true"></i>
											<span></span>
										</label>
										<label class="mt-radio mt-radio-outline"> One of the items must exist
											<input type="radio" value="or" name="product_rule" @if(isset($result['product_rule']) && $result['product_rule'] === 'or' && !empty($result['promo_campaign_product_discount_rules'])) checked @endif/>
											<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku ketika <b>salah satu</b> syarat product ada dalam transaksi" data-container="body" data-html="true"></i>
											<span></span>
										</label>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label">Min basket size</label>
									<i class="fa fa-question-circle tooltips" data-original-title="Syarat minimum basket size atau total harga product (subtotal) sebelum dikenakan promo dan biaya pengiriman. Subtotal diambil dari subtotal dari brand yang dipilih. Kosongkan jika tidak ada syarat jumlah minimum basket size" data-container="body" data-html="true"></i>
									<div class="row">
										<div class="col-md-3">
											<div class="input-group" >
												<div class="input-group-addon">IDR</div>
												<input type="text" class="form-control text-center digit_mask" name="min_basket_size" placeholder="" 
													@if(old('min_basket_size') != "") value="{{old('min_basket_size')}}" 
													@elseif(isset($result['min_basket_size'])) value="{{$result['min_basket_size']}}" 
													@endif min="0" oninput="validity.valid||(value='');" autocomplete="off">
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label">Max product discount per transaction</label>
									<i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal masing-masing produk yang dapat dikenakan diskon dalam satu transaksi </br></br>Note : Kosongkan jika jumlah maksimal produk tidak dibatasi" data-container="body" data-html="true"></i>
									<div class="row">
										<div class="col-md-2">
											
											<input type="text" class="form-control text-center digit_mask" name="max_product" placeholder="" @if(isset($result['promo_campaign_product_discount_rules']['max_product']) && $result['promo_campaign_product_discount_rules']['max_product'] != "") value="{{$result['promo_campaign_product_discount_rules']['max_product']}}" @elseif(old('max_product') != "") value="{{old('max_product')}}" @endif min="0" oninput="validity.valid||(value='');" autocomplete="off">
											
										</div>
									</div>
								</div>
								<div class="form-group" style="height: 90px;">
									<label class="control-label">Discount Type</label>
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Pilih jenis diskon untuk produk </br></br>Nominal : Diskon berupa potongan nominal, jika total diskon melebihi harga produk akan dikembalikan ke harga produk </br></br>Percent : Diskon berupa potongan persen" data-container="body" data-html="true"></i>
									<div class="mt-radio-list">
										<label class="mt-radio mt-radio-outline"> Nominal
											<input type="radio" value="Nominal" name="discount_type" @if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Nominal") checked @endif required/>
											<span></span>
										</label>
										<label class="mt-radio mt-radio-outline"> Percent
											<input type="radio" value="Percent" name="discount_type" @if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Percent") checked @endif required/>
											<span></span>
										</label>
									</div>
								</div>
								<div class="form-group" id="product-discount-div" @if(empty($result['promo_campaign_product_discount_rules'])) style="display: none;" @endif >
									<div class="row">
										<div class="col-md-3">
											<label class="control-label" id="product-discount-value">Discount Value</label>
											<span class="required" aria-required="true"> * </span>
											<i class="fa fa-question-circle tooltips" data-original-title="Besar diskon yang akan diberikan untuk setiap produk. Diskon akan dihitung dari harga produk tanpa harga topping" data-container="body"></i>
											<div class="input-group @if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Percent") col-md-5 @else col-md-12 @endif" id="product-discount-group">
												<div class="input-group-addon" id="product-addon-rp" @if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Percent") style="display: none;" @endif>IDR</div>
												<input required type="text" class="form-control text-center" name="discount_value" placeholder="" @if(isset($result['promo_campaign_product_discount_rules']['discount_value']) && $result['promo_campaign_product_discount_rules']['discount_value'] != "") value="{{$result['promo_campaign_product_discount_rules']['discount_value']}}" @elseif(old('discount_value') != "") value="{{old('discount_value')}}" @endif min="0" oninput="validity.valid||(value='');" autocomplete="off">
												<div class="input-group-addon" id="product-discount-addon" @if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Nominal") style="display: none;" @endif>%</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group" id="product-discount-percent-max-div" style="{{ ($result['promo_campaign_product_discount_rules']['discount_type']??false) == "Percent" ? '' : "display: none" }}">
									<div class="row">
										<div class="col-md-3">
											<label class="control-label" id="product-discount-value">Max Percent Discount <br> (untuk 1 qty) <i class="fa fa-question-circle tooltips" data-original-title="Jumlah diskon maksimal yang bisa didapatkan ketika menggunakan promo. Kosongkan jika maksimal persen mengikuti harga produk " data-container="body"></i></label>
											<div class="input-group col-md-12">

												<div class="input-group-addon">IDR</div>

												<input type="text" class="form-control text-center digit_mask" name="max_percent_discount" placeholder="" value="{{$result['promo_campaign_product_discount_rules']['max_percent_discount']??0}}" min="0" oninput="validity.valid||(value='');" autocomplete="off">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="bulkProduct" class="p-t-10px">
								@yield('bulkForm')
							</div>
							<div id="buyXgetYProduct" class="p-t-10px">
								@yield('buyXgetYForm')
							</div>
							<div id="discount-bill" class="p-t-10px">
								@yield('discount-bill')
							</div>
							<div id="discount-delivery" class="p-t-10px">
								@yield('discount-delivery')
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12" style="text-align:center;">
				<div class="form-actions">
					{{ csrf_field() }}
					<button type="submit" class="btn blue"> Save </button>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection