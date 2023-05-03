@extends('layouts.main')
@include('deals::deals.step3-form')

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
        .img-tutorial {
        	border: 1px solid grey;
        }

		.modal-dialog{
		    position: relative;
		    display: table; /* This is important */ 
		    overflow-y: auto;    
		    overflow-x: auto;
		    width: auto;
		    min-width: 300px;   
		}

    </style>
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/deals.js') }}" type="text/javascript"></script>

<!--     <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
-->
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('#sample_2').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [2, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                "searching": false,
                "paging": false,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
    </script>

    <script type="text/javascript">
        var oldOutlet=[];
        function redrawOutlets(list,selected,convertAll){
            var html="";
            if(list.length){
                html+="<option value=\"all\">All Outlets</option>";
            }
            list.forEach(function(outlet){
                html+="<option value=\""+outlet.id_outlet+"\">"+outlet.outlet_code+" - "+outlet.outlet_name+"</option>";
            });
            $('select[name="id_outlet[]"]').html(html);
            $('select[name="id_outlet[]"]').val(selected);
            if(convertAll&&$('select[name="id_outlet[]"]').val().length==list.length){
                $('select[name="id_outlet[]"]').val(['all']);
            }
            oldOutlet=list;
        }
        $(document).ready(function() {
            token = '<?php echo csrf_token();?>';

            $('#is_offline').change(function() {
		        if(this.checked) {
		            $('#promo-type-form').show().find('input').prop('required', true).prop('checked', false);
		        }else{
		            $('#promo-type-form').hide().find('input').prop('required', false).prop('checked', false);

                    $('.dealsPromoTypeValuePrice').val('');
                    $('.dealsPromoTypeValuePrice').hide();
                    $('.dealsPromoTypeValuePrice').removeAttr('required', true);
                    $('.dealsPromoTypeValuePromo').val('');
                    $('.dealsPromoTypeValuePromo').hide();
                    $('.dealsPromoTypeValuePromo').removeAttr('required', true);

		        	$('.dealsPromoTypeShow').hide();
		        }
		    });

		    $('#is_online').change(function() {
		        if(this.checked) {
		            $('#step-online').show();
		            $('#step-offline').hide();
		        }else{
		            $('#step-online').hide();
		            $('#step-offline').show();
		        }
		    });

            /* TYPE VOUCHER */
            $('input[name=deals_voucher_type]').click(function() {
                // tampil duluk
                var nilai = $(this).val();

                // alert(nilai);

                if (nilai == "List Vouchers") {

                	$('input[name=total_voucher_type]:checked').prop('checked', false);
                	$('input[name=deals_total_voucher]').val('');

                    $('#listVoucher').show();
                    $('.listVoucher').prop('required', true);
                    $('.listVoucher').prop('disabled', false);

                    $('#total-voucher-form').hide();
                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                    $('.generateVoucher').prop('disabled', true);
                }
                else if (nilai == "Auto generated"){
                    $('#total-voucher-form').show();
                    
                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                    $('.listVoucher').prop('disabled', true);
                }
            });

            /* TOTAL TYPE VOUCHER */
            $('input[name=total_voucher_type]').click(function() {
                // tampil duluk
                var nilai = $(this).val();
                // alert(nilai);

                if (nilai == "Auto generated") {

                    $('#generateVoucher').show();
                    $('.generateVoucher').prop('required', true);
                    $('.generateVoucher').prop('disabled', false);

                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                    $('.listVoucher').prop('disabled', true);
                }
                else if (nilai == "Unlimited"){
                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                    $('.listVoucher').prop('disabled', true);

                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                    $('.generateVoucher').prop('disabled', true);
                    $('input[name=deals_total_voucher]').val('');
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

            /* EXPIRY */
            $('.expiry').click(function() {
                var nilai = $(this).val();

                $('#times').show();

                $('.voucherTime').hide();

                $('#'+nilai).show();
                $('.'+nilai).prop('required', true);
                $('.'+nilai+'Opp').removeAttr('required');
                $('.'+nilai+'Opp').val('');
            });

            $('.dealsPromoType').click(function() {
                $('.dealsPromoTypeShow').show();
                var nilai = $(this).val();

                $('.dealsPromoTypeValuePrice').val('');
                $('.dealsPromoTypeValuePromo').val('');

                if (nilai == "promoid") {
                    $('.dealsPromoTypeValuePromo').show();
                    $('.dealsPromoTypeValuePromo').prop('required', true);

                    $('.dealsPromoTypeValuePrice').hide();
                    $('.dealsPromoTypeValuePrice').removeAttr('required', true);
                }
                else {
                    $('.dealsPromoTypeValuePrice').show();
                    $('.dealsPromoTypeValuePrice').prop('required', true);

                    $('.dealsPromoTypeValuePromo').hide();
                    $('.dealsPromoTypeValuePromo').removeAttr('required', true);
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
                    ['misc', ['fullscreen', 'help']], ['height', ['height']]
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

            // $("#file").change(function(e) {
                // var dim = realImgDimension($('#file'))

                // console.log(dim)
                // var _URL = window.URL || window.webkitURL;
                // var image, file;
                // if ((file = this.files[0])) {
                //     var dim = realImgDimension($('#file'))

                //     console.log(dim)

                //     if (this.width != 300 && this.height != 300) {
                //         toastr.warning("Please check dimension of your photo.");
                //         $('#file').val("");
                //     }
                //     else {
                //         image = new Image();
                //         image.src = _URL.createObjectURL(file);
                //     }
                // }
                // else {
                    // $('#file').val("");
                // }
            // });

            $('.fileinput-preview').bind('DOMSubtreeModified', function() {
                var mentah    = $(this).find('img')
                // set image
                var cariImage = mentah.attr('src')
                var ko        = new Image()
                ko.src        = cariImage
                // load image
                ko.onload     = function(){
                    if (this.naturalHeight === 500 && this.naturalWidth === 500) {
                    } else {
                        mentah.attr('src', "{{ $deals[0]['url_deals_image']??'https://www.placehold.it/500x500/EFEFEF/AAAAAA&text=no+image' }}")
                        $('#file').val("");
                        toastr.warning("Please check dimension of your photo.");
                    }
                };
            })
            @if( ($conditions[0][0]['operator']??false)=="WHERE IN")
                var collapsed=false;
            @else
                var collapsed=true;
            @endif
            function collapser(){
                if(collapsed){
                    $('#manualFilter input,#manualFilter select').removeAttr('disabled');
                    $('#manualFilter').collapse('show');
                    $('#csvFilter').collapse('hide');
                    $('#campaign-csv-file').attr('disabled','disabled');
                    $('input[name="csv_content"]').attr('disabled','disabled');
                    $('#campaign-csv-file').attr('disabled','disabled');
                }else{
                    $('input[name="csv_content"]').removeAttr('disabled');
                    $('#campaign-csv-file').removeAttr('disabled');
                    $('#manualFilter').collapse('hide');
                    $('#csvFilter').collapse('show');
                    $('#manualFilter input,#manualFilter select').attr('disabled','disabled');
                }
                collapsed=!collapsed;
            }
            $('.collapser').on('click',collapser);
            collapser();
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
                            var value=$('select[name="id_outlet[]"]').val();
                            var convertAll=false;
                            if($('select[name="id_outlet[]"]').data('value')){
                                value=$('select[name="id_outlet[]"]').data('value');
                                $('select[name="id_outlet[]"]').data('value',false);
                                convertAll=true;
                            }
                            redrawOutlets(data.result,value,convertAll);
                        }
                    }
                });
            });
            $('select[name="id_brand"]').change();
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

            $(".img-preview").on("click", function() {
			   $('#image-preview').attr('src', $(this).data('src')); 
			   $('#image-modal').modal('show');
			});
    </script>

@if( isset($deals['deals_content']) )
    @foreach($deals['deals_content'] as $key => $val)
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
                    <div id="step-online">
	                    <div class="col-md-4 mt-step-col first">
	                        <div class="mt-step-number bg-white">1</div>
	                        <div class="mt-step-title uppercase font-grey-cascade">Info</div>
	                        <div class="mt-step-content font-grey-cascade">Title, Image, Periode</div>
	                    </div>
	                    <div class="col-md-4 mt-step-col ">
	                        <div class="mt-step-number bg-white">2</div>
	                        <div class="mt-step-title uppercase font-grey-cascade">Rule</div>
	                        <div class="mt-step-content font-grey-cascade">discount rule</div>
	                    </div>
	                    <div class="col-md-4 mt-step-col last active">
		                    <div class="mt-step-number bg-white">3</div>
		                    <div class="mt-step-title uppercase font-grey-cascade">Content</div>
		                    <div class="mt-step-content font-grey-cascade">Detail Content Deals</div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">{{ $deals['deals_title'] }}</span>
            </div>
        </div>
        <div class="portlet box green">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gear"></i>Deals Content Setting</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"> </a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-8">
						<p>Menu ini digunakan untuk mengatur deskripsi dan content pada detail deals.</p>
						<ul>
							<li>Gambar (a) adalah contoh setting deskripsi dan content yang akan menampilkan detail deals (gambar (b)) di apps.</li>
							<li>Gambar (b) adalah contoh tampilan detail deals di apps berdasarkan setting dari gambar (a).</li>
							<li>Content title yang tidak memiliki content detail tidak akan ditampilkan di apps.</li>
							<li>Penomoran content detail akan disesuaikan berdasarkan urutan yang tersimpan di setting.</li>
						</ul>
						<a href="javascript:;" class="img-preview" data-src="{{ env('STORAGE_URL_VIEW') }}img/deals/promo_content_be.png">
							<div class="text-center">
								<img class="zoom-in img-tutorial" src="{{ env('STORAGE_URL_VIEW') }}img/deals/promo_content_be.png" height="350px"/>
								<p style="text-align: center">(a)</p>
							</div>
						</a>
					</div>
					<div class="col-md-4">
						<a href="javascript:;" class="img-preview" data-src="{{ env('STORAGE_URL_VIEW') }}img/deals/deals_voucher_detail_3.png">
							<div style="text-align: center;">
								<img id="imageresource" class="zoom-in img-tutorial" src="{{ env('STORAGE_URL_VIEW') }}img/deals/deals_voucher_detail_3.png" height="550px" />
								<p style="text-align: center">(b)</p>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
        <div class="portlet-body">

            <div class="tab-content">
                <div class="tab-pane active" id="info">
                	<div class="portlet-body form">
					    <form id="form" class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
					    		<div class="form-body">
                    
				                    @yield('step3')

				                </div>
				                <div class="form-actions">
				                @if( $deals_type == 'Promotion' || $deals['deals_total_claimed'] == 0 )
				                {{ csrf_field() }}
				                <div class="row">
				                    <div class="col-md-offset-5 col-md-7">
				                        <button type="submit" class="btn green">Submit</button>
				                    </div>
				                </div>
								@else
								<div class="row">
				                    <div class="col-md-offset-5 col-md-7">
										<a href="{{ ($deals['id_deals'] ?? false) ? url('deals/detail/'.$deals['id_deals']) : '' }}" class="btn green">Detail</a>
				                    </div>
				                </div>
								@endif
				            </div>
				            <input type="hidden" name="id_deals" value="{{ $deals['id_deals']??$deals['id_deals_promotion_template'] }}">
				            <input type="hidden" name="deals_type" value="{{ $deals['deals_type']??$deals_type }}">
					    </form>
					</div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="image-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    	<div class="modal-dialog">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    				<h4 class="modal-title" id="myModalLabel">Image preview</h4>
    			</div>
    			<div class="modal-body">
    				<img src="" id="image-preview">
    			</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    			</div>
    		</div>
    	</div>
    </div>

@endsection