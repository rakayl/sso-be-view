<?php
    use App\Lib\MyHelper;
    $grantedFeature = session('granted_features');
    $configs     	= session('configs');
 ?>

@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>

	<script>
	</script>
	<script type="text/javascript">
        $(document).ready(function() {
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};

			$('.summernote').summernote({
				placeholder: 'Email Content',
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
						sendFile(files[0], $(this).attr('id'));
					},
					onMediaDelete: function(target){
						var name = target[0].src;
						token = "<?php echo csrf_token(); ?>";
						$.ajax({
							type: 'post',
							data: 'filename='+name+'&_token='+token,
							url: "{{url('summernote/picture/delete/autocrm')}}",
							success: function(data){
								// console.log(data);
							}
						});
					}
				}
			});

			function sendFile(file, id){
                token = "<?php echo csrf_token(); ?>";
                var data = new FormData();
                data.append('image', file);
                data.append('_token', token);
                // document.getElementById('loadingDiv').style.display = "inline";
                $.ajax({
                    url : "{{url('summernote/picture/upload/autocrm')}}",
                    data: data,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(url) {
                        if (url['status'] == "success") {
							$('#'+id).summernote('editor.saveRange');
							$('#'+id).summernote('editor.restoreRange');
							$('#'+id).summernote('editor.focus');
                            $('#'+id).summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                        }
                        // document.getElementById('loadingDiv').style.display = "none";
                    },
                    error: function(data){
                        // document.getElementById('loadingDiv').style.display = "none";
                    }
                })
            }

			//untuk menampilkan detail
			@if(!empty(old('autocrm_trigger')))
				changeTrigger("{{old('autocrm_trigger')}}")
				@php $ref = old('autocrm_cron_reference'); @endphp
				@if(old('autocrm_trigger') == 'Yearly')
					$('#input_yearly').val('{{$ref[0]}}')
					$('#select_month').val('{{$ref[1]}}')
				@elseif(old('autocrm_trigger') == 'Monthly')
					@if(strlen($result['autocrm_cron_reference']) <= 2)
						// $('#input_reference').val(parseInt("{{$ref}}"))
						changeMonthly('monthly_date')
					@endif
				@elseif(old('autocrm_trigger') == 'Weekly')
					$('#select_day').val("{{$ref}}")
				@endif
			@else
				@if(isset($result['autocrm_trigger']))
					changeTrigger("{{$result['autocrm_trigger']}}")
					@if($result['autocrm_trigger'] == 'Yearly')
						$('#input_yearly').val("{{preg_replace('/^0/', '', substr($result['autocrm_cron_reference'],0,2))}}")
						$('#select_month').val("{{substr($result['autocrm_cron_reference'],2,2)}}")
					@elseif($result['autocrm_trigger'] == 'Monthly')
						@if(strlen($result['autocrm_cron_reference']) <= 2)
							$('#monthly_date_radio').prop("checked", true);
							changeMonthly('monthly_date')
							$('#monthly_date_value').val({{$result['autocrm_cron_reference']}})
						@else
							$('#monthly_day_radio').prop("checked", true);
							changeMonthly('monthly_day')
							$('#monthly_day_select').val("{{substr($result['autocrm_cron_reference'],0,-2)}}")
							$('#monthly_day_value').val("{{substr($result['autocrm_cron_reference'],-1)}}")
						@endif
						// $('#input_reference').val(parseInt("{{$result['autocrm_cron_reference']}}"))
					@elseif($result['autocrm_trigger'] == 'Weekly')
						$('#select_day').val("{{$result['autocrm_cron_reference']}}")
					@endif
				@endif
			@endif

			@if (!empty(old('autocrm_email_toogle')))
				visibleDiv('email', "{{old('autocrm_email_toogle')}}" )
				$('#autocrm_email_toogle').val('1')
			@else
				@if (isset($result['autocrm_email_toogle']))
					visibleDiv('email', "{{$result['autocrm_email_toogle']}}")
					$('#autocrm_email_toogle').val("{{$result['autocrm_email_toogle']}}")
				@endif
			@endif

			@if (!empty(old('autocrm_sms_toogle')))
				visibleDiv('sms', "{{old('autocrm_sms_toogle')}}")
			@else
				@if (isset($result['autocrm_sms_toogle']))
					visibleDiv('sms', "{{$result['autocrm_sms_toogle']}}")
				@endif
			@endif

			@if (!empty(old('autocrm_push_toogle')))
				visibleDiv('push', "{{old('autocrm_push_toogle')}}")
			@else
				@if (isset($result['autocrm_push_toogle']))
					visibleDiv('push', "{{$result['autocrm_push_toogle']}}")
				@endif
			@endif

			@if (!empty(old('autocrm_inbox_toogle')))
				visibleDiv('inbox', "{{old('autocrm_inbox_toogle')}}")
			@else
				@if (isset($result['autocrm_inbox_toogle']))
					visibleDiv('inbox', "{{$result['autocrm_inbox_toogle']}}")
					$('#autocrm_inbox_toogle').val("{{$result['autocrm_inbox_toogle']}}")
				@endif
			@endif

			@if (!empty(old('autocrm_whatsapp_toogle')))
				visibleDiv('whatsapp', "{{old('autocrm_whatsapp_toogle')}}")
			@else
				@if (isset($result['autocrm_whatsapp_toogle']))
					visibleDiv('whatsapp', "{{$result['autocrm_whatsapp_toogle']}}")
				@endif
			@endif

			var clickto = "@if(isset($result['autocrm_push_clickto'])){{$result['autocrm_push_clickto']}}@endif";
			var to = "@if(isset($result['autocrm_push_id_reference'])){{$result['autocrm_push_id_reference']}}@endif";

			if(clickto != null && to != null) fetchDetail(clickto, 'push', to);

			var clicktoInbox = "@if(isset($result['autocrm_inbox_clickto'])){{$result['autocrm_inbox_clickto']}}@endif";
			var toInbox = "@if(isset($result['autocrm_inbox_id_reference'])){{$result['autocrm_inbox_id_reference']}}@endif";

			if(clicktoInbox != null && toInbox != null) fetchDetail(clicktoInbox, 'inbox', toInbox);

			$('.datepicker').datepicker({
				'format' : 'd-M-yyyy',
				'todayHighlight' : true,
				'autoclose' : true
			});

        });

	function addEmailContent(param){
		var textvalue = $('#autocrm_email_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_email_content').val(textvaluebaru);
		$('#autocrm_email_content').summernote('editor.saveRange');
		$('#autocrm_email_content').summernote('editor.restoreRange');
		$('#autocrm_email_content').summernote('editor.focus');
		$('#autocrm_email_content').summernote('editor.insertText', param);
    }

    function addEmailSubject(param){
		var textvalue = $('#autocrm_email_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_email_subject').val(textvaluebaru);
    }

	function addSmsContent(param){
		var textvalue = $('#autocrm_sms_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_sms_content').val(textvaluebaru);
    }

	function addPushSubject(param){
		var textvalue = $('#autocrm_push_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_push_subject').val(textvaluebaru);
    }

	function addPushContent(param){
		var textvalue = $('#autocrm_push_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_push_content').val(textvaluebaru);
    }

	function addInboxSubject(param){
		var textvalue = $('#autocrm_inbox_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_inbox_subject').val(textvaluebaru);
    }

	function addInboxContent(param){
		var textvalue = $('#autocrm_inbox_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_inbox_content').val(textvaluebaru);
		$('#autocrm_inbox_content').summernote('editor.saveRange');
		$('#autocrm_inbox_content').summernote('editor.restoreRange');
		$('#autocrm_inbox_content').summernote('editor.focus');
		$('#autocrm_inbox_content').summernote('editor.insertText', param);
    }

	function addWhatsappContent(param, element){
		var textarea = $(element).closest('.col-md-3').closest('.row').closest('.col-md-8').find('.whatsapp-content')
		var textvalue = $(textarea).val();
		var textvaluebaru = textvalue+" "+param;
		$(textarea).val(textvaluebaru);
    }

	function addForwardSubject(param){
		var textvalue = $('#autocrm_forward_email_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_forward_email_subject').val(textvaluebaru);
    }

	function addForwardContent(param){
		var textvalue = $('#autocrm_forward_email_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_forward_email_content').val(textvaluebaru);
		$('#autocrm_forward_email_content').summernote('editor.saveRange');
		$('#autocrm_forward_email_content').summernote('editor.restoreRange');
		$('#autocrm_forward_email_content').summernote('editor.focus');
		$('#autocrm_forward_email_content').summernote('editor.insertText', param);
    }

	function fetchDetail(det, type, idref=null){
		let token  = "{{ csrf_token() }}";
		if(det == 'Product'){
			$.ajax({
				type : "GET",
				url : "{{ url('product/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_product']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['product_name'], result[x]['id_product'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['product_name'], result[x]['id_product']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Outlet'){
			$.ajax({
				type : "GET",
				url : "{{ url('outlet/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_outlet']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['outlet_name'], result[x]['id_outlet'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['outlet_name'], result[x]['id_outlet']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'News'){
			$.ajax({
				type : "GET",
				url : "{{ url('news/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_news']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['news_title'], result[x]['id_news'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['news_title'], result[x]['id_news']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Home'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Inbox'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Voucher'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Contact Us'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Link'){
			console.log(idref)
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'block';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Logout'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Content'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'block';
		}
	}

	function visibleDiv(apa,nilai){
		if(apa == 'email'){
			@if(MyHelper::hasAccess([38], $configs))
				if(nilai=='1'){
					document.getElementById('div_email_subject').style.display = 'block';
					document.getElementById('div_email_content').style.display = 'block';
					$('.field_email').prop('required', true);
				} else {
					document.getElementById('div_email_subject').style.display = 'none';
					document.getElementById('div_email_content').style.display = 'none';
					$('.field_email').prop('required', false);
				}
			@endif
		}
		if(apa == 'sms'){
			@if(MyHelper::hasAccess([39], $configs))
				if(nilai=='1'){
					document.getElementById('div_sms_content').style.display = 'block';
					$('.field_sms').prop('required', true);
				} else {
					document.getElementById('div_sms_content').style.display = 'none';
					$('.field_sms').prop('required', false);
				}
			@endif
		}

		if(apa == 'push'){
			@if(MyHelper::hasAccess([36], $configs))
				if(nilai=='1'){
					document.getElementById('div_push_subject').style.display = 'block';
					document.getElementById('div_push_content').style.display = 'block';
					document.getElementById('div_push_image').style.display = 'block';
					document.getElementById('div_push_clickto').style.display = 'block';
					$('.field_push').prop('required', true);
				} else {
					document.getElementById('div_push_subject').style.display = 'none';
					document.getElementById('div_push_content').style.display = 'none';
					document.getElementById('div_push_image').style.display = 'none';
					document.getElementById('div_push_clickto').style.display = 'none';
					document.getElementById('atd_push').style.display = 'none';
					document.getElementById('link_push').style.display = 'none';
					$('.field_push').prop('required', false);
				}
			@endif
		}

		if(apa == 'inbox'){
			@if(MyHelper::hasAccess([37], $configs))
				if(nilai=='1'){
					document.getElementById('div_inbox_subject').style.display = 'block';
					document.getElementById('div_inbox_clickto').style.display = 'block';
					$('.field_inbox').prop('required', true);
				} else {
					document.getElementById('div_inbox_subject').style.display = 'none';
					document.getElementById('div_inbox_clickto').style.display = 'none';
					document.getElementById('atd_inbox').style.display = 'none';
					document.getElementById('link_inbox').style.display = 'none';
					document.getElementById('div_inbox_content').style.display = 'none';
					$('.field_inbox').prop('required', false);
				}
			@endif
		}

		if(apa == 'whatsapp'){
			@if(MyHelper::hasAccess([74], $configs))
				if(nilai=='1'){
					if(document.getElementById('div_whatsapp_content')){
						document.getElementById('div_whatsapp_content').style.display = 'block';
					}
					$('.field_whatsapp').prop('required', true);
				} else {
					if(document.getElementById('div_whatsapp_content')){
						document.getElementById('div_whatsapp_content').style.display = 'none';
					}
					$('.field_whatsapp').prop('required', false);
				}
			@endif
		}
	}

		function changeTrigger(trigger){
		if(trigger == 'Yearly'){
			$('#send_at_div').show()
			$('#send_at').empty()
			$('#send_at').append(
				'<div class="col-md-12" style="padding:0">'+
				'<div class="col-md-3" style="padding:0">'+
				'<input type="number" class="form-control" id="input_yearly" placeholder="input date" min="1" name="autocrm_cron_reference[]">'+
				'</div>'+
				'<div class="col-md-5">'+
				'<select name="autocrm_cron_reference[]" id="select_month" class="form-control select2" placeholder="Select Month">'+
					'<option value="01">January</option>'+
					'<option value="02">February</option>'+
					'<option value="03">March</option>'+
					'<option value="04">April</option>'+
					'<option value="05">May</option>'+
					'<option value="06" >June</option>'+
					'<option value="07" >July</option>'+
					'<option value="08" >August</option>'+
					'<option value="09" >September</option>'+
					'<option value="10">October</option>'+
					'<option value="11">November</option>'+
					'<option value="12">December</option>'+
				'</select>'+
				'</div>'+
				'</div>'
			)
		}else if(trigger == 'Weekly'){
			$('#send_at_div').show()
			$('#send_at').empty()
			$('#send_at').append(
				'<div class="col-md-8" style="padding:0">'+
				'<select name="autocrm_cron_reference" id="select_day" class="form-control select2" placeholder="Search Day" style="width:100%">'+
					'<option value="Sunday">Sunday</option>'+
					'<option value="Monday">Monday</option>'+
					'<option value="Tuesday">Tuesday</option>'+
					'<option value="Wednesday">Wednesday</option>'+
					'<option value="Thursday">Thursday</option>'+
					'<option value="Friday">Friday</option>'+
					'<option value="Saturday">Saturday</option>'+
				'</select>'+
				'</div>'
			)
		}else if(trigger == 'Daily'){
			$('#send_at_div').hide()
		}else if(trigger == 'Monthly'){
			$('#send_at_div').show()
			$('#send_at').empty()
			$('#send_at').append(
				'<div class="md-radio-inline">'+
					'<div class="md-radio" >'+
						'<input type="radio" id="monthly_date_radio" name="radiomonth" class="md-radiobtn" onclick="changeMonthly(this.value)" value="monthly_date">'+
						'<label for="monthly_date_radio">'+
						'<span></span>'+
						'<span class="check"></span>'+
						'<span class="box"></span> Date </label>'+
					'</div>'+
					'<div class="md-radio" >'+
						'<input type="radio" id="monthly_day_radio" name="radiomonth" class="md-radiobtn" onclick="changeMonthly(this.value)" value="monthly_day">'+
						'<label for="monthly_day_radio">'+
						'<span></span>'+
						'<span class="check"></span>'+
						'<span class="box"></span> Day </label>'+
					'</div>'+
				'</div>'
			)
		}
	}

	function changeMonthly(param){
		if(param == 'monthly_date'){
			if($('#monthly_day').length != -1){
				$('#monthly_day').remove();
			}
			$('#send_at').append(
				'<div class="col-md-3" style="padding:0" id="monthly_date">'+
					'<input type="number" class="form-control" id="monthly_date_value" placeholder="input date" min="1" name="autocrm_cron_reference[]">'+
				'</div>'
			)
		}else{
			if($('#monthly_date').length != -1){
				$('#monthly_date').remove();
			}
			$('#send_at').append(
				'<div id="monthly_day">'+
					'<label class="control-label col-md-1" style="padding-left:0; text-align:left;">Day</label>'+
					'<div class="col-md-3" style="padding:0">'+
						'<select name="autocrm_cron_reference[]" id="monthly_day_select" class="form-control select2" placeholder="Search Day" style="width:100%">'+
							'<option value="Sunday">Sunday</option>'+
							'<option value="Monday">Monday</option>'+
							'<option value="Tuesday">Tuesday</option>'+
							'<option value="Wednesday">Wednesday</option>'+
							'<option value="Thursday">Thursday</option>'+
							'<option value="Friday">Friday</option>'+
							'<option value="Saturday">Saturday</option>'+
						'</select>'+
					'</div>'+
					'<label class="control-label col-md-1" style="width:65px; text-align:left;">Week</label>'+
					'<div class="col-md-2" style="padding:0">'+
						'<select name="autocrm_cron_reference[]" id="monthly_day_value" class="form-control select2" placeholder="Search Week" style="width:100%">'+
							'<option value="1">1</option>'+
							'<option value="2">2</option>'+
							'<option value="3">3</option>'+
							'<option value="4">4</option>'+
							'<option value="5">5</option>'+
						'</select>'+
					'</div>'+
				'</div>'
			)
		}
	}

	$('#checkBtn').click(function() {
		var toogle_email= $('#autocrm_email_toogle').val()
		var toogle_sms= $('#autocrm_sms_toogle').val()
		var toogle_push= $('#autocrm_push_toogle').val()
		var toogle_inbox= $('#autocrm_inbox_toogle').val()
		var toogle_whatsapp= $('#autocrm_whatsapp_toogle').val()
		if((toogle_email == '0' || typeof toogle_email == 'undefined') && (toogle_sms == '0' || typeof toogle_sms == 'undefined') && (toogle_inbox == '0' || typeof toogle_inbox == 'undefined') && (toogle_push == '0' || typeof toogle_push == 'undefined')  && (toogle_whatsapp == '0' || typeof toogle_whatsapp == 'undefined')){
			alert("You must check at least one Campaign Media.");
			return false;
		}else if($( 'input[name=autocrm_trigger]:checked' ).val() == null ){
			alert("You must check Auto CRM Trigger.");
			$('html, body').animate({
				scrollTop: $("#trigger").offset().top
			}, 2000);
			return false;
		}
		$('.price').each(function() {
			var number = $( this ).val().replace(/[($)\s\._\-]+/g, '');
			$(this).val(number);
		});
	})

	//for whatsapp content
	$(document).on('change','.content-type', function(){
		var val = $(this).val();
		if(val == 'text'){
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').show()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').find('.whatsapp-content').prop('required',true);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').find('.whatsapp-content').prop('required',false);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').find('.whatsapp-content').prop('required',false);
		}else if(val == 'image'){
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').show()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').find('.whatsapp-content').prop('required',true);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').find('.whatsapp-content').prop('required',false);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').find('.whatsapp-content').prop('required',false);
		}else if(val == 'file'){
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').show()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').find('.whatsapp-content').prop('required',true);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').find('.whatsapp-content').prop('required',false);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').find('.whatsapp-content').prop('required',false);
		}
	})

	$('.repeat').repeater({
        show: function () {
			$(this).find('.type_image').hide()
			$(this).find('img').attr('src','https://www.placehold.it/500x500/EFEFEF/AAAAAA&text=no+image')
			$(this).find('.filename').remove()
			$(this).find('.type_file').hide()
			$(this).find('.type_text').hide()
            $(this).slideDown();
        },
		hide: function (remove) {
			if(confirm('Are you sure you want to remove this item?')) {
				$(this).slideUp(remove);
			}
		},
		defaultValues: {
			id_whatsapp_content : null
		}
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
</div>
<br>
@include('layouts.notifications')
	<div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">{{ $sub_title }}</span>
            </div>
        </div>
		<div class="portlet-body form">
			<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST" enctype="multipart/form-data">
				<div class="portlet light bordered" id="trigger">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-dark sbold uppercase font-yellow">Detail</span>
						</div>
					</div>
					<div class="portlet-body form">
						<div class="form-group">
							<label class="col-md-3 control-label" >Auto CRM Title</label>
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Auto CRM Title" name="autocrm_title" required @if(!empty(old('autocrm_title'))) value="{{old('autocrm_title')}}" @else @if(isset($result['autocrm_title']) && $result['autocrm_title'] != "") value="{{$result['autocrm_title']}}" @endif @endif>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" >Auto CRM Trigger</label>
							<div class="col-md-9">
								<div class="md-radio-inline">
									<div class="md-radio" >
										<input type="radio" id="radio1" name="autocrm_trigger" class="md-radiobtn" onclick="changeTrigger(this.value)" value="Daily" @if(empty(old('autocrm_trigger'))) @if(isset($result['autocrm_trigger']) && $result['autocrm_trigger'] == "Daily") checked @endif @else @if(old('autocrm_trigger') == 'Daily') checked @endif @endif>
										<label for="radio1">
											<span></span>
											<span class="check"></span>
											<span class="box"></span> Daily </label>
									</div>
									<div class="md-radio">
										<input type="radio" id="radio2" name="autocrm_trigger" class="md-radiobtn" onclick="changeTrigger(this.value)" value="Weekly" @if(empty(old('autocrm_trigger'))) @if(isset($result['autocrm_trigger']) && $result['autocrm_trigger'] == "Weekly") checked @endif @else @if(old('autocrm_trigger') == 'Weekly') checked @endif @endif>
										<label for="radio2">
											<span></span>
											<span class="check"></span>
											<span class="box"></span> Weekly </label>
									</div>
									<div class="md-radio">
										<input type="radio" id="radio3" name="autocrm_trigger" class="md-radiobtn" onclick="changeTrigger(this.value)" value="Monthly" @if(empty(old('autocrm_trigger'))) @if(isset($result['autocrm_trigger']) && $result['autocrm_trigger'] == "Monthly") checked @endif @else @if(old('autocrm_trigger') == 'Monthly') checked @endif @endif>
										<label for="radio3">
											<span></span>
											<span class="check"></span>
											<span class="box"></span> Monthly </label>
									</div>
									<div class="md-radio">
										<input type="radio" id="radio4" name="autocrm_trigger" class="md-radiobtn" onclick="changeTrigger(this.value)" value="Yearly" @if(empty(old('autocrm_trigger'))) @if(isset($result['autocrm_trigger']) && $result['autocrm_trigger'] == "Yearly") checked @endif @else @if(old('autocrm_trigger') == 'Yearly') checked @endif @endif>
										<label for="radio4">
											<span></span>
											<span class="check"></span>
											<span class="box"></span> Yearly </label>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group" id="send_at_div" style="display:none">
							<label class="col-md-3 control-label" >Send At</label>
							<div class="col-md-9" id="send_at">
							</div>
						</div>

					</div>
				</div>

					<?php $tombolsubmit = 'hidden'; ?>
					@include('filter')

				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-dark sbold uppercase font-yellow">Content</span>
						</div>
					</div>
					<div class="portlet-body form">
						<div class="form-body">
							@if(MyHelper::hasAccess([38], $configs))
								<h4>Email</h4>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Status
											<i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan email sebagai media pengiriman auto crm ini" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="autocrm_email_toogle" id="autocrm_email_toogle" class="form-control select2" onChange="visibleDiv('email',this.value)">
											<option value="0" @if(old('autocrm_email_toogle') == '0') selected @else @if(isset($result['autocrm_email_toogle']) && $result['autocrm_email_toogle'] == "0") selected @endif @endif>Disabled</option>
											<option value="1" @if(old('autocrm_email_toogle') == '1') selected @else @if(isset($result['autocrm_email_toogle']) && $result['autocrm_email_toogle'] == "1") selected @endif @endif>Enabled</option>
										</select>
									</div>
								</div>

								<div class="form-group" id="div_email_subject" style="display:none">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Subject
											<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan subjek email, tambahkan text replacer bila perlu" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<input type="text" placeholder="Email Subject" class="form-control field_email" name="autocrm_email_subject" id="autocrm_email_subject" @if(!empty(old('autocrm_email_subject'))) value="{{old('autocrm_email_subject')}}" @else @if(isset($result['autocrm_email_subject']) && $result['autocrm_email_subject'] != '') value="{{$result['autocrm_email_subject']}}" @endif @endif>
										<br>
										You can use this variables to display user personalized information:
										<br><br>
										<div class="row">
											@foreach($textreplaces as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
												</div>
											@endforeach
										</div>
									</div>
								</div>
								<div class="form-group" id="div_email_content" style="display:none">
									<div class="input-icon right">
										<label for="multiple" class="control-label col-md-3">
											Content
											<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten email, tambahkan text replacer bila perlu" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<textarea name="autocrm_email_content" id="autocrm_email_content" class="form-control summernote">@if(!empty(old('autocrm_email_content'))) <?php echo old('autocrm_email_content'); ?> @else @if(isset($result['autocrm_email_content']) && $result['autocrm_email_content'] != '') <?php echo $result['autocrm_email_content'];?> @endif @endif</textarea>
										You can use this variables to display user personalized information:
										<br><br>
										<div class="row" >
											@foreach($textreplaces as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
												</div>
											@endforeach
										</div>
									</div>
								</div>
								<hr>
							@endif
							@if(MyHelper::hasAccess([39], $configs))
								<h4>SMS</h4>
								<div class="form-group" >
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Status
											<i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan sms sebagai media pengiriman auto crm ini" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="autocrm_sms_toogle" id="autocrm_sms_toogle" class="form-control select2" onChange="visibleDiv('sms',this.value)">
											<option value="0" @if(old('autocrm_sms_toogle') == '0') selected @else @if(isset($result['autocrm_sms_toogle']) && $result['autocrm_sms_toogle'] == "0") selected @endif @endif>Disabled</option>
											<option value="1" @if(old('autocrm_sms_toogle') == '1') selected @else @if(isset($result['autocrm_sms_toogle']) && $result['autocrm_sms_toogle'] == "1") selected @endif @endif>Enabled</option>
										</select>

									</div>
								</div>
								<div class="form-group" id="div_sms_content" style="display:none">
									<div class="input-icon right">
										<label for="multiple" class="control-label col-md-3">
											Description
											<i class="fa fa-question-circle tooltips" data-original-title="isi pesan sms, tambahkan text replacer bila perlu" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<textarea name="autocrm_sms_content" id="autocrm_sms_content" class="form-control field_sms" placeholder="SMS Content" maxlength="135">@if(!empty(old('autocrm_sms_content'))) {{old('autocrm_sms_content')}} @else @if(isset($result['autocrm_sms_content']) && $result['autocrm_sms_content'] != '') {{$result['autocrm_sms_content']}} @endif @endif</textarea>
										<br>
										You can use this variables to display user personalized information:
										<br><br>
										<div class="row">
											@foreach($textreplaces as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addSmsContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
												</div>
											@endforeach
										</div>
									</div>
								</div>
								<hr>
							@endif
							@if(MyHelper::hasAccess([36], $configs))
								<h4>Push Notification</h4>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Status
											<i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan push notification sebagai media pengiriman auto crm ini" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="autocrm_push_toogle" id="autocrm_push_toogle" class="form-control select2" onChange="visibleDiv('push',this.value)">
											<option value="0" @if(old('autocrm_push_toogle') == '0') selected @else @if(isset($result['autocrm_push_toogle']) && $result['autocrm_push_toogle'] == "0") selected @endif @endif>Disabled</option>
											<option value="1" @if(old('autocrm_push_toogle') == '1') selected @else @if(isset($result['autocrm_push_toogle']) && $result['autocrm_push_toogle'] == "1") selected @endif @endif>Enabled</option>
										</select>
									</div>
								</div>
								<div class="form-group" id="div_push_subject" style="display:none">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Subject
											<i class="fa fa-question-circle tooltips" data-original-title="subjek / judul push notification, tambahkan text replacer bila perlu" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9" >
										<input type="text" placeholder="Push Notification Subject" class="form-control field_push" name="autocrm_push_subject" id="autocrm_push_subject" @if(!empty(old('autocrm_push_subject'))) value="{{old('autocrm_push_subject')}}" @else @if(isset($result['autocrm_push_subject']) && $result['autocrm_push_subject'] != '') value="{{$result['autocrm_push_subject']}}" @endif @endif>
										<br>
										You can use this variables to display user personalized information:
										<br><br>
										<div class="row">
											@foreach($textreplaces as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
												</div>
											@endforeach
										</div>
										<input type="hidden" id="id_autocrm_push" name="id_autocrm">
									</div>
								</div>
								<div class="form-group" id="div_push_content" style="display:none">
									<div class="input-icon right">
										<label for="multiple" class="control-label col-md-3">
											Content
											<i class="fa fa-question-circle tooltips" data-original-title="konten push notification, tambahkan text replacer bila perlu" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<textarea name="autocrm_push_content" id="autocrm_push_content" class="form-control field_push">@if(!empty(old('autocrm_push_content'))) {{old('autocrm_push_content')}} @else @if(isset($result['autocrm_push_content']) && $result['autocrm_push_content'] != '') {{$result['autocrm_push_content']}} @endif @endif</textarea>
										<br>
										You can use this variables to display user personalized information:
										<br><br>
										<div class="row">
											@foreach($textreplaces as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
												</div>
											@endforeach
										</div>
									</div>
								</div>
								<div class="form-group" id="div_push_image" style="display:none">
									<div class="input-icon right">
										<label for="autocrm_push_clickto" class="control-label col-md-3">
											Gambar
											<i class="fa fa-question-circle tooltips" data-original-title="sertakan gambar jika ada" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
												@if(isset($result['autocrm_push_image']))
												<img src="{{env('STORAGE_URL_API')}}{{$result['autocrm_push_image']}}" id="autocrm_push_image" />
												@else
												<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="autocrm_push_image" />
												@endif
											</div>

											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
											<div>
												<span class="btn default btn-file">
													<span class="fileinput-new"> Select image </span>
													<span class="fileinput-exists"> Change </span>
													<input type="file"  accept="image/*" name="autocrm_push_image">
												</span>
												<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group" id="div_push_clickto" style="display:none">
									<div class="input-icon right">
										<label for="autocrm_push_clickto" class="control-label col-md-3">
											Click Action
											<i class="fa fa-question-circle tooltips" data-original-title="action / menu yang terbuka saat user membuka push notification" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="autocrm_push_clickto" id="autocrm_push_clickto" class="form-control select2 field_push" onChange="fetchDetail(this.value, 'push')">
											<option value="" selected></option>
											<option value="Home" @if(old('autocrm_push_clickto') == 'Home') selected @else @if(isset($result['autocrm_push_clickto']) && $result['autocrm_push_clickto'] == "Home") selected @endif @endif>Home</option>
											<option value="News" @if(old('autocrm_push_clickto') == 'News') selected @else @if(isset($result['autocrm_push_clickto']) && $result['autocrm_push_clickto'] == "News") selected @endif @endif>News</option>
											<option value="Product" @if(old('autocrm_push_clickto') == 'Product') selected @else @if(isset($result['autocrm_push_clickto']) && $result['autocrm_push_clickto'] == "Product") selected @endif @endif>Product</option>
											<option value="Outlet" @if(old('autocrm_push_clickto') == 'Outlet') selected @else @if(isset($result['autocrm_push_clickto']) && $result['autocrm_push_clickto'] == "Outlet") selected @endif @endif>Outlet</option>
											<option value="Inbox" @if(old('autocrm_push_clickto') == 'Inbox') selected @else @if(isset($result['autocrm_push_clickto']) && $result['autocrm_push_clickto'] == "Inbox") selected @endif @endif>Inbox</option>
											<option value="Voucher" @if(old('autocrm_push_clickto') == 'Voucher') selected @else @if(isset($result['autocrm_push_clickto']) && $result['autocrm_push_clickto'] == "Voucher") selected @endif @endif>Voucher</option>
											<option value="Contact Us" @if(old('autocrm_push_clickto') == 'Contact Us') selected @else @if(isset($result['autocrm_push_clickto']) && $result['autocrm_push_clickto'] == "Contact Us") selected @endif @endif>Contact Us</option>
											<option value="Link" @if(old('autocrm_push_clickto') == 'Link') selected @else @if(isset($result['autocrm_push_clickto']) && $result['autocrm_push_clickto'] == "Link") selected @endif @endif>Link</option>
											<option value="Logout" @if(old('autocrm_push_clickto') == 'Logout') selected @else @if(isset($result['autocrm_push_clickto']) && $result['autocrm_push_clickto'] == "Logout") selected @endif @endif>Logout</option>
										</select>
									</div>
								</div>
								<div class="form-group" id="atd_push" style="display:none;">
									<div class="input-icon right">
										<label for="autocrm_push_clickto" class="control-label col-md-3">
											Action to Detail
											<i class="fa fa-question-circle tooltips" data-original-title="detail action / menu yang akan terbuka saat user membuka push notification" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="autocrm_push_id_reference" id="autocrm_push_id_reference" class="form-control select2">
										</select>
									</div>
								</div>
								<div class="form-group" id="link_push" style="display:none;">
									<div class="input-icon right">
										<label for="autocrm_push_clickto" class="control-label col-md-3">
											Link
											<i class="fa fa-question-circle tooltips" data-original-title="jika action berupa link, masukkan alamat link nya disini" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<input type="text" placeholder="https://" class="form-control" name="autocrm_push_link" value="@if(isset($result['autocrm_push_link'])){{$result['autocrm_push_link']}}@endif">
									</div>
								</div>
								<hr>
							@endif
							@if(MyHelper::hasAccess([37], $configs))
								<h4>Inbox</h4>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Status
											<i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan inbox sebagai media pengiriman auto crm ini" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="autocrm_inbox_toogle" id="autocrm_inbox_toogle" class="form-control select2" class="form-control select2" onChange="visibleDiv('inbox',this.value)">
											<option value="0" @if(old('autocrm_inbox_toogle') == '0') selected @else @if(isset($result['autocrm_inbox_toogle']) && $result['autocrm_inbox_toogle'] == "0") selected @endif @endif>Disabled</option>
											<option value="1" @if(old('autocrm_inbox_toogle') == '1') selected @else @if(isset($result['autocrm_inbox_toogle']) && $result['autocrm_inbox_toogle'] == "1") selected @endif @endif>Enabled</option>
										</select>
									</div>
								</div>
								<div class="form-group" id="div_inbox_subject" style="display:none">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Subject
											<i class="fa fa-question-circle tooltips" data-original-title="subjek / judul pesan inbox, tambahkan text replacer bila perlu" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<input type="text" placeholder="Inbox Subject" class="form-control field_inbox" name="autocrm_inbox_subject" id="autocrm_inbox_subject" @if(!empty(old('autocrm_inbox_subject'))) value="{{old('autocrm_inbox_subject')}}" @else @if(isset($result['autocrm_inbox_subject']) && $result['autocrm_inbox_subject'] != '') value="{{$result['autocrm_inbox_subject']}}" @endif @endif>
										<br>
										You can use this variables to display user personalized information:
										<br><br>
										<div class="row">
											@foreach($textreplaces as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
												</div>
											@endforeach
										</div>
										<input type="hidden" id="id_autocrm_inbox" name="id_autocrm">
									</div>
								</div>
								<div class="form-group" id="div_inbox_clickto" style="display:none">
									<div class="input-icon right">
										<label for="autocrm_inbox_clickto" class="control-label col-md-3">
											Click Action
											<i class="fa fa-question-circle tooltips" data-original-title="action / menu yang terbuka saat user membuka inbox" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="autocrm_inbox_clickto" id="autocrm_inbox_clickto" class="form-control select2 field_inbox" onChange="fetchDetail(this.value, 'inbox')">
											<option value="" selected></option>
											<option value="Home" @if(old('autocrm_inbox_clickto') == 'Home') selected @else @if(isset($result['autocrm_inbox_clickto']) && $result['autocrm_inbox_clickto'] == "Home") selected @endif @endif>Home</option>
											{{-- <option value="Content" @if(old('autocrm_inbox_clickto') == 'Content') selected @else @if(isset($result['autocrm_inbox_clickto']) && $result['autocrm_inbox_clickto'] == "Content") selected @endif @endif>Content</option> --}}
											<option value="News" @if(old('autocrm_inbox_clickto') == 'News') selected @else @if(isset($result['autocrm_inbox_clickto']) && $result['autocrm_inbox_clickto'] == "News") selected @endif @endif>News</option>
											<option value="Product" @if(old('autocrm_inbox_clickto') == 'Product') selected @else @if(isset($result['autocrm_inbox_clickto']) && $result['autocrm_inbox_clickto'] == "Product") selected @endif @endif>Product</option>
											<option value="Outlet" @if(old('autocrm_inbox_clickto') == 'Outlet') selected @else @if(isset($result['autocrm_inbox_clickto']) && $result['autocrm_inbox_clickto'] == "Outlet") selected @endif @endif>Outlet</option>
											<option value="Inbox" @if(old('autocrm_inbox_clickto') == 'Inbox') selected @else @if(isset($result['autocrm_inbox_clickto']) && $result['autocrm_inbox_clickto'] == "Inbox") selected @endif @endif>Inbox</option>
											<option value="Voucher" @if(old('autocrm_inbox_clickto') == 'Voucher') selected @else @if(isset($result['autocrm_inbox_clickto']) && $result['autocrm_inbox_clickto'] == "Voucher") selected @endif @endif>Voucher</option>
											<option value="Contact Us" @if(old('autocrm_inbox_clickto') == 'Contact Us') selected @else @if(isset($result['autocrm_inbox_clickto']) && $result['autocrm_inbox_clickto'] == "Contact Us") selected @endif @endif>Contact Us</option>
											<option value="Link" @if(old('autocrm_inbox_clickto') == 'Link') selected @else @if(isset($result['autocrm_inbox_clickto']) && $result['autocrm_inbox_clickto'] == "Link") selected @endif @endif>Link</option>
											<option value="Logout" @if(old('autocrm_inbox_clickto') == 'Logout') selected @else @if(isset($result['autocrm_inbox_clickto']) && $result['autocrm_inbox_clickto'] == "Logout") selected @endif @endif>Logout</option>
										</select>
									</div>
								</div>
								<div class="form-group" id="atd_inbox" style="display:none;">
									<div class="input-icon right">
										<label for="autocrm_push_clickto" class="control-label col-md-3">
											Action to Detail
											<i class="fa fa-question-circle tooltips" data-original-title="detail action / menu yang akan terbuka saat user membuka inbox" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="autocrm_inbox_id_reference" id="autocrm_push_id_reference" class="form-control select2">
										</select>
									</div>
								</div>
								<div class="form-group" id="link_inbox" style="display:none;">
									<div class="input-icon right">
										<label for="autocrm_inbox_clickto" class="control-label col-md-3">
											Link
											<i class="fa fa-question-circle tooltips" data-original-title="jika action berupa link, masukkan alamat link nya disini" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<input type="text" placeholder="https://" class="form-control" name="autocrm_inbox_link" value="@if(isset($result['autocrm_inbox_link'])){{$result['autocrm_inbox_link']}}@endif">
									</div>
								</div>
								<div class="form-group" id="div_inbox_content" style="display:none">
									<div class="input-icon right">
										<label for="multiple" class="control-label col-md-3">
											Content
											<i class="fa fa-question-circle tooltips" data-original-title="konten pesan, tambahkan text replacer bila perlu" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<textarea name="autocrm_inbox_content" id="autocrm_inbox_content" class="form-control summernote">@if(old('autocrm_inbox_content')) <?php echo old('autocrm_inbox_content'); ?> @else @if(isset($result['autocrm_inbox_content']) && $result['autocrm_inbox_content'] != '') <?php echo $result['autocrm_inbox_content'];?> @endif @endif</textarea>
										You can use this variables to display user personalized information:
										<br><br>
										<div class="row">
											@foreach($textreplaces as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
												</div>
											@endforeach
										</div>
									</div>
								</div>
							@endif

							@if(MyHelper::hasAccess([74], $configs))
								<hr>
								@if(!$api_key_whatsapp)
									<div class="alert alert-warning deteksi-trigger">
										<p> To use WhatsApp channel you have to set the api key in <a href="{{url('setting/whatsapp')}}">WhatsApp Setting</a>. </p>
									</div>
								@endif
								<h4>WhatsApp</h4>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Status
											<i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan whatsApp sebagai media pengiriman auto crm ini" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="autocrm_whatsapp_toogle" id="autocrm_whatsapp_toogle" class="form-control select2 field_whatsapp" onChange="visibleDiv('whatsapp',this.value)" @if(!$api_key_whatsapp) disabled @endif>
											<option value="0" @if(old('autocrm_whatsapp_toogle') == '0') selected @else @if(isset($result['autocrm_whatsapp_toogle']) && $result['autocrm_whatsapp_toogle'] == "0") selected @endif @endif>Disabled</option>
											<option value="1" @if($api_key_whatsapp) @if(old('autocrm_whatsapp_toogle') == '1') selected @else @if(isset($result['autocrm_whatsapp_toogle']) && $result['autocrm_whatsapp_toogle'] == "1") selected @endif @endif @endif>Enabled</option>
										</select>
									</div>
								</div>
								@if($api_key_whatsapp)
									<div class="form-group" id="div_whatsapp_content" style="display:none">
										<div class="repeat">
											<div data-repeater-list="whatsapp_content">
												@if(isset($result['whatsapp_content']) && count($result['whatsapp_content']) > 0)
													@foreach($result['whatsapp_content'] as $content)
														<div data-repeater-item="" class="item-repeat portlet light bordered" style="margin:15px">
															<input type="hidden" name="id_whatsapp_content" value="{{$content['id_whatsapp_content']}}">
															<div class="form-group row" style="">
																<div class="input-icon right">
																	<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																		Content Type
																		<i class="fa fa-question-circle tooltips" data-original-title="Tipe konten pesan untuk media whatsapp" data-container="body"></i>
																	</label>
																</div>
																<div class="col-md-4" style="padding-left:5px">
																	<select name="content_type" class="form-control select content-type field_whatsapp" style="width:100%">
																		<option value="" disabled>Select Content Type</option>
																		<option value="text" @if($content['content_type'] == 'text') selected @endif>Text</option>
																		<option value="image" @if($content['content_type'] == 'image') selected @endif>Image</option>
																		<option value="file" @if($content['content_type'] == 'file') selected @endif>File PDF</option>
																	</select>
																</div>
																<div class="col-md-1" style="float:right">
																	<a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
																		<i class="fa fa-close"></i>
																	</a>
																</div>
															</div>
															<div class="form-group type_text row" @if($content['content_type'] != 'text') style="display:none" @endif>
																<div class="input-icon right">
																	<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																		Content
																		<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp, tambahkan text replacer bila perlu" data-container="body"></i>
																	</label>
																</div>
																<div class="col-md-8" style="padding-left:5px">
																	<textarea name="content" rows="3" style="white-space: normal" class="form-control whatsapp-content" placeholder="WhatsApp Content">@if($content['content_type'] == 'text') {{$content['content']}} @endif</textarea>
																	<br>
																	You can use this variables to display user personalized information:
																	<br><br>
																	<div class="row">
																		@foreach($textreplaces as $key=>$row)
																			<div class="col-md-3" style="margin-bottom:5px;">
																				<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}', this);">{{ str_replace('_',' ',$row['keyword']) }}</span>
																			</div>
																		@endforeach
																	</div>
																	<br><br>
																</div>
															</div>
															<div class="form-group type_file row" @if($content['content_type'] != 'file') style="display:none" @endif>
																<div class="input-icon right">
																	<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																		Content File
																		<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp berupa gambar" data-container="body"></i>
																	</label>
																</div>
																<div class="col-md-8" style="padding-left:5px">
																	@if($content['content_type'] == 'file')
																		<div class="form-group filename">
																		@php $file = explode('/', $content['content']) @endphp
																		<label class="control-label" style="padding-left:15px"><a href= "{{$content['content']}}"> <i class="fa fa-file-pdf-o"></i> {{end($file)}} </a> </label>
																		</div>
																	@endif
																	<div class="fileinput fileinput-new" data-provides="fileinput">
																		<div class="input-group input-large">
																			<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
																				<i class="fa fa-file fileinput-exists"></i>&nbsp;
																				<span class="fileinput-filename"> </span>
																			</div>
																			<span class="input-group-addon btn default btn-file">
																				<span class="fileinput-new"> Select file </span>
																				<span class="fileinput-exists"> Change </span>
																				<input type="file" class="file whatsapp-content" accept="application/pdf" name="content_file">
																				</span>
																			<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																		</div>
																	</div>
																</div>
															</div>
															<div class="form-group type_image row" @if($content['content_type'] != 'image') style="display:none" @endif>
																<div class="input-icon right">
																	<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																		Content Image
																		<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp berupa gambar" data-container="body"></i>
																	</label>
																</div>
																<div class="col-md-8" style="padding-left:5px">
																	<div class="fileinput fileinput-new" data-provides="fileinput">
																		<div class="fileinput-new thumbnail" style="width: auto; height: auto;">
																		@if($content['content_type'] == 'image')
																			<img src="{{$content['content']}}" alt="Whatsapp content image" style="max-width: 190px; max-height:190px">
																		@else
																			<img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
																		@endif
																		</div>
																		<div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
																		<div>
																			<span class="btn default btn-file">
																			<span class="fileinput-new"> Select image </span>
																			<span class="fileinput-exists"> Change </span>
																			<input type="file" class="file whatsapp-content" accept="image/*" name="content">

																			</span>

																			<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													@endforeach
												@else
													<div data-repeater-item="" class="item-repeat portlet light bordered" style="margin:15px">
														<input type="hidden" name="id_whatsapp_content" value="">
														<div class="form-group row">
															<div class="input-icon right">
																<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																	Content Type
																	<i class="fa fa-question-circle tooltips" data-original-title="Pilih salah satu tipe konten untuk whatsApp" data-container="body"></i>
																</label>
															</div>
															<div class="col-md-4" style="padding-left:5px">
																<select name="content_type" class="form-control select content-type" style="width:100%">
																	<option value="" disabled selected>Select Content Type</option>
																	<option value="text">Text</option>
																	<option value="image">Image</option>
																	<option value="file">File PDF</option>
																</select>
															</div>
															<div class="col-md-1" style="float:right">
																<a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
																	<i class="fa fa-close"></i>
																</a>
															</div>
														</div>
														<div class="form-group type_text row" style="display:none">
															<div class="input-icon right">
																<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																	Content
																	<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp, tambahkan text replacer bila perlu" data-container="body"></i>
																</label>
															</div>
															<div class="col-md-8" style="padding-left:5px">
																<textarea name="content" rows="3" class="form-control whatsapp-content" placeholder="WhatsApp Content">@if(isset($result['campaign_whatsapp_content']) && $result['campaign_whatsapp_content'] != ""){{$result['campaign_whatsapp_content']}}@endif</textarea>
																<br>
																You can use this variables to display user personalized information:
																<br><br>
																<div class="row">
																	@foreach($textreplaces as $key=>$row)
																		<div class="col-md-3" style="margin-bottom:5px;">
																			<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}', this);">{{ str_replace('_',' ',$row['keyword']) }}</span>
																		</div>
																	@endforeach
																</div>
																<br><br>
															</div>
														</div>
														<div class="form-group type_file row" style="display:none">
															<div class="input-icon right">
																<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																	Content File
																	<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp berupa file pdf" data-container="body"></i>
																</label>
															</div>
															<div class="col-md-8" style="padding-left:5px">
																<div class="fileinput fileinput-new" data-provides="fileinput">
																	<div class="input-group input-large">
																		<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
																			<i class="fa fa-file fileinput-exists"></i>&nbsp;
																			<span class="fileinput-filename"> </span>
																		</div>
																		<span class="input-group-addon btn default btn-file">
																			<span class="fileinput-new"> Select file </span>
																			<span class="fileinput-exists"> Change </span>
																			<input type="file" class="file whatsapp-content" accept="application/pdf" name="content_file">
																			</span>
																		<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																	</div>
																</div>
															</div>
														</div>
														<div class="form-group type_image row" style="display:none">
															<div class="input-icon right">
																<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																	Content Image
																	<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp berupa gambar" data-container="body"></i>
																</label>
															</div>
															<div class="col-md-8" style="padding-left:5px">
																<div class="fileinput fileinput-new" data-provides="fileinput">
																	<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
																	<img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
																	</div>
																	<div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
																	<div>
																		<span class="btn default btn-file">
																		<span class="fileinput-new"> Select image </span>
																		<span class="fileinput-exists"> Change </span>
																		<input type="file" class="file whatsapp-content" accept="image/*" name="content">

																		</span>

																		<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												@endif
											</div>
											<hr>
											<label class="col-md-3 control-label" style="margin-left:15px"></label>
											<a href="javascript:;" data-repeater-create="" class="btn btn-success mt-repeater-add">
												<i class="fa fa-plus"></i> Add Content</a>
											<br>
											<br>
										</div>
									</div>
								@endif
							@endif

						</div>
					</div>
				</div>
				@if(($sub_title == 'New Auto CRM' && MyHelper::hasAccess([121], $grantedFeature)) || ($sub_title == 'Detail Auto CRM' && MyHelper::hasAccess([122], $grantedFeature)) )
					<label class="col-md-3 control-label" style="margin-left:15px"></label>
						{{ csrf_field() }}
						<input hidden name="autocrm_type" value="Cron">
						<button type="submit" class="btn blue" id="checkBtn">Save</button>
				@endif
			</form>
		</div>
	</div>
@endsection