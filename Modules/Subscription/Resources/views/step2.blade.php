@include('subscription::step2-form')
<?php
	use App\Lib\MyHelper;
	$configs = session('configs');
	if ($subscription_type == 'welcome') {
		$redirect = 'welcome-subscription';
	}
	else{
		$redirect = 'subscription';
	}
	$product_type 	= $subscription['product_type'] ?? 'single';
?>
@extends('layouts.main-closed')

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
        .content-title {
            padding-bottom: 15px;
        }
        .content-detail {
            padding-bottom: 10px;
            padding-left: 40px;
        }
        .p-l-40px {
            padding-left: 40px;
        }
        .p-l-30px {
            padding-left: 30px;
        }
        a[aria-expanded=false] .fa-chevron-down {
            display: none;
        }
        a[aria-expanded=true] .fa-chevron-right {
            display: none;
        }
        .bottom-border {
            border-bottom: 1px solid #c2cad8;
        }
        .btn-grey {
            color: #337ab7;
            background-color: #eee;
            border-color: #ccc;
        }
        .text-decoration-none {
            text-decoration: none!important;
        }
        /*.select2-results__option[aria-selected=true] {
		    display: none;
		}*/

		.select2-search--inline {
		    /*display: contents;*/ /*this will make the container disappear, making the child the one who sets the width of the element*/
		}

		.select2-search__field:placeholder-shown {
		    /*width: 100% !important;*/ /*makes the placeholder to be 100% of the width while there are no options selected*/
		}

		.select2-container .select2-search__field {
		    width: 100% !important; /*makes the placeholder to be 100% of the width while there are no options selected*/
		}

    </style>
@endsection

@section('page-script')

    <!-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/custom-select2.full.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/subscription.js') }}" type="text/javascript"></script>
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
        var product_type = '{!!$product_type!!}';
        let id_brand = null;
        let id_brands = [];

        function redrawOutlets(list,selected,convertAll, all){
            var html="";
            if(list.length){
                // html+="<option value=\"all\">All Outlets</option>";
            }
            list.forEach(function(outlet){
            	// single brand
                // html+="<option value=\""+outlet.id_outlet+"\">"+outlet.outlet_code+" - "+outlet.outlet_name+"</option>";

                // multi brand
                html+="<option value=\""+outlet.id_outlet+"\">"+outlet.outlet+"</option>";
            });
            $('select[name="id_outlet[]"]').html(html);
            $('select[name="id_outlet[]"]').val(selected);
            if( all == 1 || ( convertAll && $('select[name="id_outlet[]"]').val() != null && $('select[name="id_outlet[]"]').val().length==list.length ) ){
                $('select[name="id_outlet[]"]').val(['all']);
            }
            oldOutlet=list;
        }

        function redrawOutletGroups(list,selected,convertAll, all){
            var html="";

            list.forEach(function(val){
                html+="<option value=\""+val.id_outlet_group+"\">"+val.outlet_group_name+"</option>";
            });

            $('select[name="id_outlet_group[]"]').html(html);
            $('select[name="id_outlet_group[]"]').val(selected);

            oldOutlet=list;
        }

        var oldProduct=[];
        function redrawProducts(list,selected,convertAll,all){
            var html="";
            if(list.length){
                html+="<option value=\"all\">All Products</option>";
            }
            list.forEach(function(product){
            	// single brand
             	// html+="<option value=\""+product.id_product+"\">"+product.product_code+" - "+product.product_name+"</option>";

                // multi brand
                html+="<option value=\""+product.id_brand+"-"+product.id_product+'-'+product.id_product_variant_group+"\">"+product.product+"</option>";
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
            var brand_rule = $('select[name="id_outlet[]"]').data('brand-rule');

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

            /* FILTER OUTLET */
            $('select[name=filter_outlet]').change(function() {
                outlet = $('select[name=filter_outlet] option:selected').val();

                if(outlet == 'selected_outlet') {
					$('#select-outlet').show();
					$('#select-outlet-group').hide();
                	$("select[name='id_outlet[]']").prop('required', true);
                	$("select[name='id_outlet_group[]']").prop('required', false);
				}
				else if (outlet == 'outlet_group') {
					$('#select-outlet-group').show();
					$('#select-outlet').hide();
                	$("select[name='id_outlet[]']").prop('required', false);
                	$("select[name='id_outlet_group[]']").prop('required', true);
				}
				else {
					$('#select-outlet, #select-outlet-group').hide();
                	$("select[name='id_outlet[]']").prop('required', false);
                	$("select[name='id_outlet_group[]']").prop('required', false);
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


            ajaxProductMultiBrand();
            ajaxOutletMultiBrand();
            ajaxOutletGroup();

            $('select[name="brand_rule"]').on('change',function(){
                brand_rule = $('select[name="brand_rule"]').val();
                ajaxOutletMultiBrand(id_brands);
            });

            $('select[name="id_brand[]"]').on('change',function(){
                id_brands = $('select[name="id_brand[]"]').val();
                ajaxOutletMultiBrand(id_brands);
                ajaxProductMultiBrand(id_brands);

            });
            $('select[name="id_brand[]"]').change();

            $('select[name="id_product[]"]').on('change',function(){
                let product = $('select[name="id_product[]"]').val();
                if (!product || product.indexOf("all") != -1) {
                	$('#product-rule').hide();
                	$('select[name="product_rule"]').prop('required', false);
                }else{
                	$('#product-rule').show();
                	$('select[name="product_rule"]').prop('required', true);
                }
            });

            function ajaxOutlet(id_brand = null) {

            	let condition;
            	if(id_brand) {
            		condition = {
                        rules:[
                            {
                                subject:'id_brand',
                                parameter:id_brand,
                                operator:'=',
                            }
                        ],
                        operator:'and'
                    }
            	}

                $.ajax({
                    url:"{{url('outlet/ajax_handler')}}",
                    method: 'GET',
                    data: {
                        select:['id_outlet','outlet_code','outlet_name'],
                        condition: condition
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
            }

            function ajaxOutletGroup() {
	        	$.ajax({
					type: "GET",
					url: "{{url('promo-campaign/step2/getData')}}",
					data : {
						"get" : 'Outlet Group',
						"brand" : id_brands,
						"brand_rule" : brand_rule
					},
					dataType: "json",
					success: function(data){
						if (data.status == 'fail') {
							$.ajax(this)
							return
						}

	                    let value = $('#input-select-outlet-group').val();
	                    let all = $('#input-select-outlet-group').data('all');
	                    let convertAll=false;
	                    if($('#input-select-outlet-group').data('value')){
	                        value = $('#input-select-outlet-group').data('value');
	                        $('#input-select-outlet-group').data('value',false);
	                        convertAll = true;
	                    }
	                    redrawOutletGroups(data,value,convertAll,all);
					}
				});
	        }

            function ajaxOutletMultiBrand(id_brands = []) {
            	$.ajax({
					type: "GET",
					url: "{{url('promo-campaign/step2/getData')}}",
					data : {
						"get" : 'Outlet',
						"brand" : id_brands,
						"brand_rule" : brand_rule
					},
					dataType: "json",
					success: function(data){
						if (data.status == 'fail') {
							$.ajax(this)
							return
						}

	                    let value = $('select[name="id_outlet[]"]').val();
	                    let all = $('select[name="id_outlet[]"]').data('all');
	                    let convertAll=false;
	                    if($('select[name="id_outlet[]"]').data('value')){
	                        value=$('select[name="id_outlet[]"]').data('value');
	                        $('select[name="id_outlet[]"]').data('value',false);
	                        convertAll=true;
	                    }
	                    redrawOutlets(data,value,convertAll,all);
					}
				});
            }

            function ajaxProduct(id_brand = null) {
            	let condition;
            	if(id_brand) {
            		condition = {
                        rules:[
                            {
                                subject:'id_brand',
                                parameter:id_brand,
                                operator:'=',
                            }
                        ],
                        operator:'and'
                    }
            	}
                $.ajax({
                    url:"{{url('product/ajax-product-brand')}}",
                    method: 'GET',
                    data: {
                        select:['id_product','product_code','product_name'],
                        condition : condition
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
            }

            function ajaxProductMultiBrand(id_brands = []) {
            	$.ajax({
					type: "GET",
					url: "{{url('promo-campaign/step2/getData')}}",
					data : {
						"get" : 'Product',
						"brand" : id_brands,
						"product_type" : product_type
					},
					dataType: "json",
					success: function(data){
						if (data.status == 'fail') {
							$.ajax(this)
							return
						}

                        let value = $('select[name="id_product[]"]').val();
                        let all = $('select[name="id_product[]"]').data('all');
                        let convertAll = false;
                        if($('select[name="id_product[]"]').data('value')){
                            value = $('select[name="id_product[]"]').data('value');
                            $('select[name="id_product[]"]').data('value',false);
                            convertAll = true;
                        }
                        redrawProducts(data,value,convertAll,all);
					}
				});
            }

            $("select[name='id_outlet[]'], select[name='id_outlet_group[]'], select[name='id_product[]']").select2({
	        	"closeOnSelect": false,
	        	width: '100%'
	        }).on('change', function(evt) {
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
        <div class="col-md-12">
            <div class="mt-element-step">
                <div class="row step-line">
                    <div class="col-md-4 mt-step-col first">
                        <a href="{{ ($subscription['id_subscription']??0) ? url($redirect.'/step1/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">1</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Info</div>
                            <div class="mt-step-content font-grey-cascade">Title, Image, & Periode</div>
                        </a>
                    </div>
                    <div class="col-md-4 mt-step-col active">
                        <a href="{{ ($subscription['id_subscription']??0) ? url($redirect.'/step2/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">2</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Rule</div>
                            <div class="mt-step-content font-grey-cascade">Discount, Limit, & Expired</div>
                        </a>
                    </div>
                    <div class="col-md-4 mt-step-col last">
                        <a href="{{ ($subscription['id_subscription']??0) ? url($redirect.'/step3/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">3</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Content</div>
                            <div class="mt-step-content font-grey-cascade">Detail Content Subscription</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">{{ $subscription['subscription_title'] ?? "Step 2 ".$title }}</span>
            </div>
        </div>
        <div class="portlet-body form">

            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="form">
                <div class="form-body">
                    @yield('step2')
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-4 col-md-8">
                            <input type="hidden" name="id_subscription" value="{{ $subscription['id_subscription']??'' }}">
                            <input type="hidden" name="subscription_type" value="{{ $subscription_type??'' }}">
                            <a href="{{ ($subscription['id_subscription']??'') ? url($redirect.'/step1/'.$subscription['id_subscription']) : '' }}" class="btn green">Previous Step</a>
                            <button type="submit" class="btn green">Next Step</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection