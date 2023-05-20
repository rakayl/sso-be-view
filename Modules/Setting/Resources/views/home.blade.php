<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs     		= session('configs');
?>
@extends('layouts.main')
@include('setting::featured_promo_campaign')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />

	<style type="text/css">
		.click-to{
			margin-top: 10px;
		}
		.modal .click-to-type .form-control,
		.modal .click-to-type .select2-container{
			display: none;
		}
		.modal .select2-selection{
			position: relative;
		}
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script>

	$(document).ready(function(){
		$('#form_banner_create').on('submit', function(e) {
			var date_start = $('#create_banner_start').val();
			date_start = date_start.replace(" - ", ' ');
			date_start = new Date(date_start).getTime();

			var date_end = $('#create_banner_end').val();
			date_end = date_end.replace(" - ", ' ');
			date_end = new Date(date_end).getTime();

			if(date_end < date_start) {
				$('#note_end_create').empty();
				$('#note_end_create').append('End date must be greater than start date');
				e.preventDefault();
				$('#create_banner_end').focus();
				focusSet = true;
			}

			var clickto = $('#create_click_to').val();
			if(clickto == 'url'){
				var url = $('#create_banner_url').val();
				var urlregex = /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
				if(!urlregex)
				{
					$('#note_create_banner_url').empty();
					$('#note_create_banner_url').append('Please input url use http:// or https://');
					e.preventDefault();
					$('#create_banner_url').focus();
					focusSet = true;
				}
			}
		});

		$('#form_banner_edit').on('submit', function(e) {
			var date_start = $('#banner_start').val();
			date_start = date_start.replace(" - ", ' ');
			date_start = new Date(date_start).getTime();

			var date_end = $('#banner_end').val();
			date_end = date_end.replace(" - ", ' ');
			date_end = new Date(date_end).getTime();

			if(date_end < date_start) {
				$('#note_end_edit').empty();
				$('#note_end_edit').append('End date must be greater than start date');
				e.preventDefault();
				$('#banner_end').focus();
				focusSet = true;
			}

			var clickto = $('#click-to-type').val();
			if(clickto == 'url'){
				var url = $('#edit_banner_url').val();
				var urlregex = /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
				if(!urlregex)
				{
					$('#note_edit_banner_url').empty();
					$('#note_edit_banner_url').append('Please input url use http:// or https://');
					e.preventDefault();
					$('#edit_banner_url').focus();
					focusSet = true;
				}
			}
		});
	});

	$('#create_banner_start').on('change', function() {
		$('#note_end_create').empty();
	});

	$('#create_banner_end').on('change', function() {
		$('#note_end_create').empty();
	});

	$('#banner_start').on('change', function() {
		$('#note_end_edit').empty();
	});

	$('#banner_end').on('change', function() {
		$('#note_end_edit').empty();
	});

	$('#edit_banner_url').keyup(function (e) {
		$('#note_edit_banner_url').empty();
	});

	$('#create_banner_url').keyup(function (e) {
		$('#note_create_banner_url').empty();
	});


	$(function () {
        $('.time_picker').datetimepicker({
            format: 'HH:mm',
            autoclose: true,
            pickDate:false
        });
    });


	function hapus1(value){
		swal({
		  title: "Are you sure want to delete greeting ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it",
		  closeOnConfirm: false
		},
		function(){
			document.getElementById('txtvalue1').value = value;
			frmdelete1.submit();
		});
	}
	function hapus2(value){
		swal({
		  title: "Are you sure want to delete background image ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it",
		  closeOnConfirm: false
		},
		function(){
			document.getElementById('txtvalue2').value = value;
			frmdelete2.submit();
		});
	}
	function checkUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = true;
		}
	}

	function uncheckUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = false;
		}
	}

	function addGreetingReplace(param){
		var textvalue = $('#txt_greeting').val();
		var textvaluebaru = textvalue+" "+param;
		$('#txt_greeting').val(textvaluebaru.substring(0,25));
    }

	function addGreetingReplace2(param){
		var textvalue = $('#txt_greeting_2').val();
		var textvaluebaru = textvalue+" "+param;
		$('#txt_greeting_2').val(textvaluebaru);
    }

    // banner: select click to
    $('.click-to-radio').change(function(){
        if (this.checked && this.value == 'news') {
            $('.click-to-news').show();
            $('.click-to-type').find('.select2-container').show();
            $('.click-to-url').val('');
            $('.click-to-url').hide();
        }
        else if(this.checked && this.value == 'url') {
        	$('.click-to-news').val(null).trigger('change');
        	$('.click-to-news').hide();
            $('.click-to-type').find('.select2-container').hide();
            $('.click-to-url').show();
        }
        else {
        	$('.click-to-news').val(null).trigger('change');
        	$('.click-to-news').hide();
            $('.click-to-type').find('.select2-container').hide();
            $('.click-to-url').val('');
            $('.click-to-url').hide();
        }
    });
    // banner: re-order image
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
    // featured deals
    $( "#sortable2" ).sortable();
    $( "#sortable2" ).disableSelection();
    // featured subscription
    $( "#sortable3" ).sortable();
    $( "#sortable3" ).disableSelection();

    $(document).ready(function() {
    	$('#txt_greeting').on('keyup',function(){
    		$(this).val($(this).val().substring(0,25));
    	});
		/* on chrome */
    	$('#modalBanner').on('shown.bs.modal', function () {
    		$('#modalBanner .select2').select2({ dropdownParent: $("#modalBanner .modal-body") });
    		$('#modalBanner [name="click_to"]').change();
    	});

    	$('#modalBanner [name="click_to"]').on('change', function() {
    		$('#modalBanner [data-visible]').addClass('hidden');
    		$('#modalBanner [data-visible] select').attr('disabled', 'disabled');
    		$('#modalBanner [data-visible="' + $(this).val() + '"]').removeClass('hidden');
    		$('#modalBanner [data-visible="' + $(this).val() + '"] select').removeAttr('disabled');
    	});

    	// upload & delete image on summernote
    	$('.summernote').summernote({
	        placeholder: 'Success Page Content',
	        tabsize: 2,
	        height: 180,
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
	                    url: "{{url('summernote/picture/delete/user-profile')}}",
	                    success: function(data){
	                        // console.log(data);
	                    }
	                });
	            }
	        }
	    });
    });

    // upload & delete image on summernote
    function sendFile(file){
        token = "{{ csrf_token() }}";
        var data = new FormData();
        data.append('image', file);
        data.append('_token', token);
        // document.getElementById('loadingDiv').style.display = "inline";
        $.ajax({
            url : "{{url('summernote/picture/upload/user-profile')}}",
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

    // banner: edit
    $('#banner .btn-edit').click(function() {
		var id      = $(this).data('id');
		var id_reference = $(this).data('reference');
		var url     = $(this).data('url');
		var image   = $(this).data('img');
		var type    = $(this).data('type');
		var banner_start	= $(this).data('start');
		var banner_end		= $(this).data('end');
		var time_start		= $(this).data('time_start');
		var time_end		= $(this).data('time_end');
		var reference  		= $(this).data('reference');

    	$('#modalBannerUpdate').on('shown.bs.modal', function () {
    		// on chrome
    		$('#modalBannerUpdate .select2').select2({ dropdownParent: $("#modalBannerUpdate .modal-body") });

    		// assign value to form
    		$('#id_banner').val(id);
			$('#modalBannerUpdate [name="url"]').val(url);
			$('#edit-banner-img').attr('src', image);
			$('#banner_start').val(banner_start);
			$('#banner_end').val(banner_end);
			$('#time_start').val(time_start);
			$('#time_end').val(time_end);
			$('#click-to-type').val(type);
			$('#modalBannerUpdate [name="id_reference"]').val(reference);
			if(id_reference){
				$('.click-to-news').val(id_reference).trigger('change');
			}

			// reset var
			url = "";
    	});

		/* on chrome */
    	$('#modalBannerUpdate').on('shown.bs.modal', function () {
    		$('#modalBannerUpdate .select2').select2({ dropdownParent: $("#modalBannerUpdate .modal-body") });
    		$('#modalBannerUpdate [name="click_to"]').change();
    	});

    	$('#modalBannerUpdate [name="click_to"]').on('change', function() {
    		$('#modalBannerUpdate [data-visible]').addClass('hidden');
    		$('#modalBannerUpdate [data-visible] select').attr('disabled', 'disabled');
    		$('#modalBannerUpdate [data-visible="' + $(this).val() + '"]').removeClass('hidden');
    		$('#modalBannerUpdate [data-visible="' + $(this).val() + '"] select').removeAttr('disabled');
    	});
    });

    $('#featured_deals .btn-edit').click(function() {
		var id         = $(this).data('id');
		var end_date   = $(this).data('end-date');
		var start_date = $(this).data('start-date');
		var id_deals   = $(this).data('id-deals');
		var deals_title   = $(this).data('deals-title');

		// assign value to form
		$('#id_featured_deals').val(id);
		$('#end_date').val(end_date).datetimepicker({
	        format: "dd M yyyy hh:ii",
	        autoclose: true,
	        todayBtn: true,
	        minuteStep:1
	    });
		$('#start_date').val(start_date).datetimepicker({
	        format: "dd M yyyy hh:ii",
	        autoclose: true,
	        todayBtn: true,
	        minuteStep:1
	    });
		$('#id_deals').find('option').first().attr('value',id_deals).text(deals_title);
		$('#id_deals').select2().trigger('change');
    });

    $('#featured_subscription .btn-edit').click(function() {
		var id         = $(this).data('id');
		var end_date   = $(this).data('end-date');
		var start_date = $(this).data('start-date');
		var id_subscription   = $(this).data('id-subscription');
		var subscription_title   = $(this).data('subscription-title');

		// assign value to form
		$('#id_featured_subscription').val(id);
		$('#end_date_subs').val(end_date).datetimepicker({
	        format: "dd M yyyy hh:ii",
	        autoclose: true,
	        todayBtn: true,
	        minuteStep:1
	    });
		$('#start_date_subs').val(start_date).datetimepicker({
	        format: "dd M yyyy hh:ii",
	        autoclose: true,
	        todayBtn: true,
	        minuteStep:1
	    });
		$('#id_subscription').find('option').first().attr('value',id_subscription).text(subscription_title);
		$('#id_subscription').select2().trigger('change');
    });

	$('.datetime').datetimepicker({
        format: "dd M yyyy hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep:1
    });

	



    // clear banner edit form when modal close
    $('#modalBannerUpdate').on('hidden.bs.modal', function () {
		// $('#id_banner').val('');
		$('#modalBannerUpdate .click-to-news').val('').trigger('change');
		$('#modalBannerUpdate .click-to-url').val('');
		// $('#edit-banner-img').attr('src', '');
		// hide all click to input
		$('#modalBannerUpdate .click-to-type').children().hide();
	});

    // banner: delete
    $('#banner .btn-delete').click(function() {
		var id 		= $(this).data('id');
		var link 	= "{{ url('setting/banner/delete') }}/" + id;
		swal({
		  title: "Are you sure want to delete banner image ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it",
		  closeOnConfirm: false
		},
		function(){
			window.location = link;
		});
    });

    // banner: delete
    $('#featured_deals .btn-delete').click(function() {
		var id 		= $(this).data('id');
		var link 	= "{{ url('setting/featured_deal/delete') }}/" + id;
		swal({
		  title: "Are you sure want to delete this featured deals ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it",
		  closeOnConfirm: false
		},
		function(){
			window.location = link;
		});
    });

    // subscription: delete
    $('#featured_subscription .btn-delete').click(function() {
		var id 		= $(this).data('id');
		var link 	= "{{ url('setting/featured_subscription/delete') }}/" + id;
		swal({
		  title: "Are you sure want to delete this featured subscription ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it",
		  closeOnConfirm: false
		},
		function(){
			window.location = link;
		});
    });

	$(".file-splash").change(function(e) {
                var widthImg  = 1080;
		var heightImg = 1920;
                var widthImg2  = 540;
		var heightImg2 = 960;
		var _URL = window.URL || window.webkitURL;
		var image, file;

		if ((file = this.files[0])) {
			image = new Image();

			image.onload = function() {
				if ((this.width == widthImg && this.height == heightImg)||(this.width == widthImg2 && this.height == heightImg2)) {
					// image.src = _URL.createObjectURL(file);
				}
				else {
					toastr.warning("Please check dimension of your image.");
					$("#removeSplash").trigger( "click" );
					$("#removeSplashDoctor").trigger( "click" );
					$(this).val("");
					// $('#remove_square').click()
					// image.src = _URL.createObjectURL();

					$('#field_splash').val("");
					$('#div_splash').children('img').attr('src', 'https://www.placehold.it/500x250/EFEFEF/AAAAAA&amp;text=no+image');

					// console.log(document.getElementsByName('news_image_luar'))
				}
			};

			image.src = _URL.createObjectURL(file);
		}

	});


	$('.nav-tabs a').on('shown.bs.tab', function(){
		var href=$(this).attr('href');
	    window.history.pushState(href, href, "{{url()->current()}}"+href);
	});

	$('.onlynumber').keypress(function (e) {
		var regex = new RegExp("^[0-9]");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		var check_browser = navigator.userAgent.search("Firefox");
		if(check_browser == -1){
			if (regex.test(str) || e.which == 8) {
				return true;
			}
		}else{
			if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
				return true;
			}
		}
		e.preventDefault();
		return false;
	});

	$(".file").change(function(e) {
		var widthImg  = 750;
		var heightImg = 375;

		var _URL = window.URL || window.webkitURL;
		var image, file;

		if ((file = this.files[0])) {
			image = new Image();

			image.onload = function() {
				if (this.width == widthImg && this.height == heightImg) {
				}else {
					toastr.warning("Please check dimension of your photo.");
					$('#div_background_default').children('img').attr('src', 'https://www.placehold.it/300x300/EFEFEF/AAAAAA&amp;text=no+image');
					$("#remove_fieldphoto").trigger( "click" );

				}
			};

			image.src = _URL.createObjectURL(file);
		}

	});

	$(".fileupdate").change(function(e) {
		var widthImg  = 750;
		var heightImg = 375;

		var _URL = window.URL || window.webkitURL;
		var image, file;

		if ((file = this.files[0])) {
			image = new Image();

			image.onload = function() {
				if (this.width == widthImg && this.height == heightImg) {
				}else {
					toastr.warning("Please check dimension of your photo.");
					$("#remove_fieldphoto_update").trigger( "click" );

				}
			};

			image.src = _URL.createObjectURL(file);
		}

	});
	</script>
	@yield('featured-promo-campaign-script')
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="javascript:;">Setting</a>
		</li>
	</ul>
</div>
<br>
@include('layouts.notifications')
<div class="tabbable-line">
	<ul class="nav nav-tabs">
        <li class="active">
            <a href="#splash-screen" data-toggle="tab">Splash Screen</a>
        </li>

       
    </ul>
</div>

<div class="tab-content">

    <div class="tab-pane active" id="splash-screen">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Default Splash Screen</span>
						</div>
					</div>
					<div class="portlet-body">
						<form role="form" class="form-horizontal" action="{{url('setting/default_home')}}" method="POST" enctype="multipart/form-data">
							<div class="form-body">
								<div class="form-group col-md-12">
									<label class="text-right col-md-4">Splash Screen Duration
										<span class="required" aria-required="true"> * </span>
									</label>
									<div class="col-md-4">
										<input type="number" class="form-control" name="default_home_splash_duration" value="{{$default_home['default_home_splash_duration']??''}}" min="1" required>
									</div>
								</div>
								<div class="form-group col-md-12">
										<label class="control-label col-md-4">Splash Screen
											<br>
											<span class="required" aria-required="true"> (1080*1920)/(540*960) </span>
										</label><br>
										<div class="fileinput fileinput-new col-md-4" data-provides="fileinput">
											<div class="fileinput-preview fileinput-new thumbnail">
												@if(isset($default_home['default_home_splash_screen']))
													<img src="{{ env('STORAGE_URL_API')}}{{$default_home['default_home_splash_screen']}}?updated_at={{time()}}" style="max-width: 250px; max-height: 250px;" alt="">
												@else
													<img src="https://www.placehold.it/200x100/EFEFEF/AAAAAA&amp;text=no+image" alt="">
												@endif
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" id="div_splash" style="max-width: 250px; max-height: 250px;"></div>
											<div>
												<span class="btn default btn-file">
												<span class="fileinput-new"> Select image </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file" class="file-splash" id="field_splash" accept="image/*" name="default_home_splash_screen">
												</span>
												<a href="javascript:;" id="removeSplash" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
											</div>
										</div>
									</div>
							</div>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<button type="submit" class="btn blue" id="checkBtn">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>

@endsection