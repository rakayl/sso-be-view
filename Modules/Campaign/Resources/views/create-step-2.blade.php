<?php
	use App\Lib\MyHelper;
    $configs    		= session('configs');
?>

@extends('layouts.main-closed')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/table-datatables-buttons.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
	function addEmailContent(param){
		var textvalue = $('#campaign_email_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#campaign_email_content').val(textvaluebaru);
		$('#campaign_email_content').summernote('editor.saveRange');
		$('#campaign_email_content').summernote('editor.restoreRange');
		$('#campaign_email_content').summernote('editor.focus');
		$('#campaign_email_content').summernote('editor.insertText', param);
    }

    function addEmailSubject(param){
		var textvalue = $('#campaign_email_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#campaign_email_subject').val(textvaluebaru);
    }

	function addSmsContent(param){
		var textvalue = $('#campaign_sms_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#campaign_sms_content').val(textvaluebaru);
    }

	function addPushSubject(param){
		var textvalue = $('#campaign_push_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#campaign_push_subject').val(textvaluebaru);
    }

	function addPushContent(param){
		var textvalue = $('#campaign_push_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#campaign_push_content').val(textvaluebaru);
    }

	function addInboxSubject(param){
		var textvalue = $('#campaign_inbox_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#campaign_inbox_subject').val(textvaluebaru);
    }

	function addInboxContent(param){
		var textvalue = $('#campaign_inbox_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#campaign_inbox_content').val(textvaluebaru);
		// $('#campaign_inbox_content').summernote('editor.saveRange');
		// $('#campaign_inbox_content').summernote('editor.restoreRange');
		// $('#campaign_inbox_content').summernote('editor.focus');
		// $('#campaign_inbox_content').summernote('editor.insertText', param);
    }

	function addWhatsappContent(param, element){
		var textarea = $(element).closest('.col-md-3').closest('.row').closest('.col-md-8').find('.whatsapp-content')
		var textvalue = $(textarea).val();
		var textvaluebaru = textvalue+" "+param;
		$(textarea).val(textvaluebaru);
    }

	function fetchDetail(det, type, idref=null){
		let token  = "{{ csrf_token() }}";

		if(det == 'product_detail'){
			$.ajax({
				type : "GET",
				url : "{{ url('product/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
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
		}

		else if(det == 'doctor_detail'){
			$.ajax({
				type : "POST",
				url : "{{ url('campaign/click-action') }}",
				data : {
					"_token" : token,
					"type" : 'doctor_detail'
				},
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_doctor']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['doctor_name'], result[x]['id_doctor'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['doctor_name'], result[x]['id_doctor']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
		}

		else if(det == 'Outlet' || det == 'Order'){
			$.ajax({
				type : "GET",
				url : "{{ url('outlet/ajax/filter') }}"+'/'+det,
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
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
		}

		else if(det == 'merchant_detail'){
			$.ajax({
				type : "POST",
				url : "{{ url('campaign/click-action') }}",
				data : {
					"_token" : token,
					"type" : 'merchant_detail'
				},
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
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
		}

		else if(det == 'elearning'){
			$.ajax({
				type : "GET",
				url : "{{ url('news/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
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
		}

		else if(det == 'Subscription'){
			$.ajax({
				type : "GET",
				url : "{{ url('subscription/list-ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.result.length; x++){
						if(idref == result.result[x]['id_subscription']){
							operator_value.options[operator_value.options.length] = new Option(result.result[x]['subscription_title'], result.result[x]['id_subscription'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result.result[x]['subscription_title'], result.result[x]['id_subscription']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
		}

		else if(det == 'Deals'){
			$.ajax({
				type : "GET",
				url : "{{ url('deals/list/active') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_deals']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['deals_title'], result[x]['id_deals'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['deals_title'], result[x]['id_deals']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
		}

		else if(det == 'promo_detail'){
			$.ajax({
				type : "POST",
				url : "{{ url('campaign/click-action') }}",
				data : {
					"_token" : token,
					"type" : 'promo_detail'
				},
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_promo_campaign']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['promo_title'], result[x]['id_promo_campaign'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['promo_title'], result[x]['id_promo_campaign']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
		}

		else if(det == 'Complex'){
			$.ajax({
				type : "GET",
				url : "{{ url('redirect-complex/list/active') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_redirect_complex_reference']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['name']??'', result[x]['id_redirect_complex_reference'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['name']??'', result[x]['id_redirect_complex_reference']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
		}
		
		else if(det == 'Home'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
		}

		else if(det == 'Inbox'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
		}

		else if(det == 'Voucher'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
		}

		else if(det == 'Contact Us'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
		}

		else if(det == 'url'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'block';
		}

		else if(det == 'Logout'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
		}

		else if(det == 'Content'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
		}

		else {
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('campaign_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
		}
	}

	function viewPush(id){
		setTimeout(function(){
			$('#campaign_push_id_reference').val(id).trigger('change');
		}, 1000);
	}

	$(document).ready(function() {
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
						url: "{{url('summernote/picture/delete/campaign')}}",
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
				url : "{{url('summernote/picture/upload/campaign')}}",
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

	var clickto = "{{$result['campaign_push_clickto']}}";
	var to = "{{$result['campaign_push_id_reference']}}";
	if(clickto != "") fetchDetail(clickto, 'push', to);

	var clicktoInbox = "{{$result['campaign_inbox_clickto']}}";
	var toInbox = "{{$result['campaign_inbox_id_reference']}}";

	if(clicktoInbox != "") fetchDetail(clicktoInbox, 'inbox', toInbox);

	});

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

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="mt-element-step">
			<div class="row step-line">
				<div class="col-md-4 mt-step-col first">
					<div class="mt-step-number bg-white">1</div>
					<div class="mt-step-title uppercase font-grey-cascade">Info</div>
					<div class="mt-step-content font-grey-cascade">Campaign Rule & Setting</div>
				</div>
				<div class="col-md-4 mt-step-col active">
					<div class="mt-step-number bg-white">2</div>
					<div class="mt-step-title uppercase font-grey-cascade">Recipient & Content</div>
					<div class="mt-step-content font-grey-cascade">Review Campaign Recipient</div>
				</div>
				<div class="col-md-4 mt-step-col last">
					<div class="mt-step-number bg-white">3</div>
					<div class="mt-step-title uppercase font-grey-cascade">Review & Summary</div>
					<div class="mt-step-content font-grey-cascade">Campaign Finalization</div>
				</div>
			</div>
		</div>
	</div>
	<form role="form" action="" method="POST" enctype="multipart/form-data">
		<div class="col-md-12">
			<div class="col-md-4">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Information</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row static-info">
							<div class="col-md-4 name">Campaign</div>
							<div class="col-md-8 value">: {{$result['campaign_title']}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Creator</div>
							<div class="col-md-8 value">: {{$result['user']['name']}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Level</div>
							<div class="col-md-8 value">: {{$result['user']['level']}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Media</div>
							<div class="col-md-8 value">: </div>
						</div>
						@if($result['campaign_media_email'] == "Yes")
						<div class="row static-info">
							<div class="col-md-1 name"></div>
							<div class="col-md-10 value">
								<li><i class="fa fa-envelope-o" title="Email"></i> Email</li>
							</div>
						</div>
						@endif
						@if($result['campaign_media_sms'] == "Yes")
						<div class="row static-info">
							<div class="col-md-1 name"></div>
							<div class="col-md-10 value">
								<li><i class="fa fa-commenting-o" title="SMS"></i> SMS</li>
							</div>
						</div>
						@endif
						@if($result['campaign_media_push'] == "Yes")
						<div class="row static-info">
							<div class="col-md-1 name"></div>
							<div class="col-md-10 value">
								<li><i class="fa fa-exclamation-circle" title="Push Notification"></i>Push Notification</li>
							</div>
						</div>
						@endif
						@if($result['campaign_media_inbox'] == "Yes")
						<div class="row static-info">
							<div class="col-md-1 name"></div>
							<div class="col-md-10 value">
								<li><i class="fa fa-download" title="Inbox"></i> Inbox</li>
							</div>
						</div>
						@endif
						@if($result['campaign_media_whatsapp'] == "Yes")
						<div class="row static-info">
							<div class="col-md-1 name"></div>
							<div class="col-md-10 value">
								<li><i class="fa fa-whatsapp" title="SMS"></i> Whatsapp</li>
							</div>
						</div>
						@endif
						<div class="row static-info">
							<div class="col-md-4 name">Created</div>
							<div class="col-md-8 value">: {{date("l, d F Y H:i", strtotime($result['created_at']))}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Send</div>
							<div class="col-md-8 value">: @if($result['campaign_send_at'] != ''){{date("l, d F Y H:i", strtotime($result['campaign_send_at']))}}@else Now @endif</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Recipient generate</div>
							<div class="col-md-8 value">: {{$result['campaign_generate_receipient']}}</div>
						</div>
						@if(isset($result['campaign_rule_parents']))
							<div class="row static-info">
								<div class="col-md-4 name">Conditions</div>
								<div class="col-md-8 value">: </div>
							</div>
							@php $i=0; $where=false;@endphp
							@foreach($result['campaign_rule_parents'] as $ruleParent)
							<div class="portlet light bordered" style="margin-bottom:10px">
								@foreach($ruleParent['rules'] as $rule)
								<div class="row static-info">
									@php if($rule['operator'] == 'WHERE IN'): $where=true; @endphp
										<div class="col-md-12 text-center">Based on CSV file upload</div>
									@php else: $where=false; @endphp
									<div class="col-md-1 name"></div>
									<div class="col-md-10 value"><li>
									@if($rule['subject'] != 'trx_outlet' && $rule['subject'] != 'trx_product')
										{{ucwords(str_replace("_", " ", $rule['subject']))}} @if($rule['subject'] != "all_user") @if(empty($rule['operator']))=@else{{$rule['operator']}}@endif @endif
									@endif
									@if($rule['subject'] == 'trx_outlet')
										{{ucwords(str_replace("_", " ", $rule['subject']))}}
										<?php $name = null; ?>
										@foreach($outlets as $outlet)
											@if($outlet['id_outlet'] == $rule['id'])
												<?php $name = $outlet['outlet_name']; ?>
											@endif
										@endforeach
										"{{$name}}" with outlet count {{$rule['operator']}} {{$rule['parameter']}}
									@elseif($rule['subject'] == 'trx_outlet_not')
										<?php $name = null; ?>
										@foreach($outlets as $outlet)
											@if($outlet['id_outlet'] == $rule['parameter'])
												<?php $name = $outlet['outlet_name']; ?>
											@endif
										@endforeach
										{{$name}}
									@elseif($rule['subject'] == 'trx_product')
										{{ucwords(str_replace("_", " ", $rule['subject']))}}
										<?php $name = null; ?>
										@foreach($products as $product)
											@if($product['id_product'] == $rule['id'])
												<?php $name = $product['product_name']; ?>
											@endif
										@endforeach
										"{{$name}}" with product count {{$rule['operator']}} {{$rule['parameter']}}
									@elseif($rule['subject'] == 'trx_product_not')
										<?php $name = null; ?>
										@foreach($products as $product)
											@if($product['id_product'] == $rule['parameter'])
												<?php $name = $product['product_name']; ?>
											@endif
										@endforeach
										{{$name}}
									@elseif($rule['subject'] == 'trx_product_tag' || $rule['subject'] == 'trx_product_tag_not')
										<?php $name = null; ?>
										@foreach($tags as $tag)
											@if($tag['id_tag'] == $rule['parameter'])
												<?php $name = $tag['tag_name']; ?>
											@endif
										@endforeach
										{{$name}}
									@elseif($rule['subject'] == 'Deals')
										<?php $name = null; ?>
										@foreach($deals as $val)
											@if($val['id_deals'] == $rule['parameter'])
												<?php $name = $val['deals_title']; ?>
											@endif
										@endforeach
										{{$name}}
									@elseif($rule['subject'] == 'Quest')
										<?php $name = null;
										$dtSelect =[
												'already_claim' => 'Already Claim',
												'not_yet_claim' => 'Not Yet Claim'
										];
										?>
										@foreach($quest as $val)
											@if($val['id_quest'] == $rule['parameter'])
												<?php $name = $val['name']; ?>
											@endif
										@endforeach
										{{$name}} ({{$dtSelect[$rule['parameter_select']]??''}})
									@elseif($rule['subject'] == 'Subscription')
										<?php $name = null; ?>
										@foreach($subscription as $val)
											@if($val['id_subscription'] == $rule['parameter'])
												<?php $name = $val['subscription_title']; ?>
											@endif
										@endforeach
										{{$name}}
									@elseif($rule['subject'] == 'membership')
										<?php $name = null; ?>
										@foreach($memberships as $membership)
											@if($membership['id_membership'] == $rule['parameter'])
												<?php $name = $membership['membership_name']; ?>
											@endif
										@endforeach
										{{$name}}
									@else
										{{$rule['parameter']}}
									@endif
									</li>
									</div>
									@php endif; @endphp
								</div>
								@endforeach
								<div class="row static-info">
									<div class="col-md-11 value">
									@if(!$where)
										@if($ruleParent['rule'] == 'and')
											All conditions must valid
										@else
											Atleast one condition is valid
										@endif
									@endif
									</div>
								</div>
							</div>
							@if(count($result['campaign_rule_parents']) > 1 && $i < count($result['campaign_rule_parents']) - 1)
							<div class="row static-info" style="text-align:center">
								<div class="col-md-11 value">
									{{strtoupper($ruleParent['rule_next'])}}
								</div>
							</div>
							@endif
							@php $i++; @endphp
							@endforeach
							@if($where&&$result['campaign_description'])
							<div class="row static-info">
								<div class="col-md-4 name">Description</div>
								<div class="col-md-8 value">: </div>
							</div>
							<div class="portlet light bordered" style="margin-bottom:10px">
								<div class="row static-info">
									<div class="col-md-12 text-justify">{{$result['campaign_description']}}</div>
								</div>
							</div>
							@endif
						@endif
						<div class="row static-info">
							<div class="col-md-11 value">
								<a class="btn blue" href="{{url('/')}}/campaign/step1/{{$result['id_campaign']}}">Edit Campaign Information</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			$emails = [];
			$phones = [];
			?>
			<div class="col-md-8">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Recipient</span>
						</div>
						<div class="action-btn pull-right">
							<a href="{{url('campaign/recipient/'.$result['id_campaign'])}}" target="_blank" class="btn yellow btn-sm btn-flat">See generated recipient</a>
						</div>
					</div>
					<div class="portlet-body form">
						@if($result['campaign_generate_receipient'] != "Now")
							<span><i>You can add custom recipient (even non member email) by adding email / phone value below (separated by coma ',').</i><br><br> </span>
						@else
							<span><i>You can add custom recipient (even non member email) by adding email / phone value below (separated by coma ',').</i><br><br> </span>
						@endif
						<div class="form-group">
							<?php
							$email_list = implode(',',$emails);
							$phone_list = implode(',',$phones);
							?>
							@if($result['campaign_media_email'] == "Yes")
							<div class="form-group">
								<label>Email</label>
								<textarea class="form-control" rows="3" name="campaign_email_more_recipient">{{old('campaign_email_more_recipient',$result['campaign_email_more_recipient'])}}</textarea>
								<p class="help-block">Comma ( , ) separated for multiple emails</p>
							</div>
							@endif
							@if($result['campaign_media_sms'] == "Yes")
							<div class="form-group">
								<label>SMS</label>
								<textarea class="form-control" rows="3" name="campaign_sms_more_recipient">{{old('campaign_sms_more_recipient',$result['campaign_sms_more_recipient'])}}</textarea>
								<p class="help-block">Comma ( , ) separated for multiple phone number</p>
							</div>
							@endif

							@if($result['campaign_media_push'] == "Yes")
							<div class="form-group">
								<label>Push Notification</label>
								<textarea class="form-control" rows="3" name="campaign_push_more_recipient">{{old('campaign_push_more_recipient',$result['campaign_push_more_recipient'])}}</textarea>
								<p class="help-block">Comma ( , ) separated for multiple phone number</p>
							</div>
							@endif

							@if($result['campaign_media_inbox'] == "Yes")
							<div class="form-group">
								<label>Inbox</label>
								<textarea class="form-control" rows="3" name="campaign_inbox_more_recipient">{{old('campaign_inbox_more_recipient',$result['campaign_inbox_more_recipient'])}}</textarea>
								<p class="help-block">Comma ( , ) separated for multiple phone number</p>
							</div>
							@endif

							@if($result['campaign_media_whatsapp'] == "Yes")
							<div class="form-group">
								<label>WhatsApp</label>
								<textarea class="form-control" rows="3" name="campaign_whatsapp_more_recipient">{{old('campaign_whatsapp_more_recipient',$result['campaign_whatsapp_more_recipient'])}}</textarea>
								<p class="help-block">Comma ( , ) separated for multiple phone number</p>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>

			@if($result['campaign_media_email'] == "Yes")
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Email Content</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="form-group" style="margin-bottom:30px">
								<label class="col-md-2 control-label">Subject</label>
								<div class="col-md-10">
									<input type="text" placeholder="Email Subject" class="form-control" name="campaign_email_subject" id="campaign_email_subject" required @if(isset($result['campaign_email_subject']) && $result['campaign_email_subject'] != "") value="{{$result['campaign_email_subject']}}" @endif>
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
									</div>
									<br><br>
								</div>
							</div>
							<div class="form-group" style="margin-bottom:30px">
								<label for="multiple" class="control-label col-md-2">Content</label>
								<div class="col-md-10">
									<textarea name="campaign_email_content" id="campaign_email_content" class="form-control summernote" required>@if(isset($result['campaign_email_content']) && $result['campaign_email_content'] != ""){{$result['campaign_email_content']}}@endif</textarea>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif

			@if($result['campaign_media_sms'] == "Yes")
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">SMS Content</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="form-group" style="margin-bottom:30px">
								<label class="col-md-2 control-label">Content</label>
								<div class="col-md-10">
									<textarea name="campaign_sms_content" id="campaign_sms_content" class="form-control" placeholder="SMS Content" maxlength="135" required>@if(isset($result['campaign_sms_content']) && $result['campaign_sms_content'] != ""){{$result['campaign_sms_content']}}@endif</textarea>
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addSmsContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
									</div>
									<br><br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif

			@if($result['campaign_media_push'] == "Yes")
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Push Notification Content</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="form-group" style="margin-bottom:30px">
								<label class="col-md-2 control-label">Subject</label>
								<div class="col-md-10">
									<input type="text" placeholder="Push Notification Subject" class="form-control" name="campaign_push_subject" id="campaign_push_subject" required @if(isset($result['campaign_push_subject']) && $result['campaign_push_subject'] != "") value="{{$result['campaign_push_subject']}}" @endif>
									<span class="help-block">jika lebih dari 35 karakter ada kemungkinan terpotong di layar hp</span>
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
									</div>
									<br><br>
								</div>
							</div>
							<div class="form-group" style="margin-bottom:30px">
								<label for="multiple" class="control-label col-md-2">Content</label>
								<div class="col-md-10">
									<textarea name="campaign_push_content" id="campaign_push_content" class="form-control" required>@if(isset($result['campaign_push_content']) && $result['campaign_push_content'] != ""){{$result['campaign_push_content']}}@endif</textarea>
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="campaign_push_clickto" class="control-label col-md-2">Gambar</label>
								<div class="col-md-10">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
											@if(isset($result['campaign_push_image']) && $result['campaign_push_image'] != "")
												<img src="{{env('STORAGE_URL_API')}}{{$result['campaign_push_image']}}" id="campaign_push_image" />
											@else
												<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="campaign_push_image" />
											@endif
										</div>

										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
										<div>
											<span class="btn default btn-file">
												<span class="fileinput-new"> Select image </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file"  accept="image/*" name="campaign_push_image"> </span>
											<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="campaign_push_clickto" class="control-label col-md-2" style="padding-top:30px">Click Action</label>
								<div class="col-md-10" style="padding-top:30px">
									<select name="campaign_push_clickto" id="campaign_push_clickto" class="form-control select2" onChange="fetchDetail(this.value, 'push')">
										<option value="none" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "none") selected @endif>None</option>
										<option value="home" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "home") selected @endif>Home</option>
										<option value="membership" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "membership") selected @endif>Membership</option>
										<option value="point_history" @if(isset($result['campaign_push_clickto']) && $result['campaign_inbox_clickto'] == "point_history") selected @endif>Point History</option>
										<option value="store" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "store") selected @endif>Store</option>
										<option value="consultation" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "consultation") selected @endif>Consultation</option>
										<option value="elearning" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "elearning") selected @endif>E-learning</option>
										<option value="product_recomendation_list" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "No Action") selected @endif>Product Recomendation List</option>
										<option value="home" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "product_recomendation_list") selected @endif>Doctor Recomendation List</option>
										<option value="merchant_detail" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "merchant_detail") selected @endif>Merchant Detail</option>
										<option value="product_detail" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "product_detail") selected @endif>Product Detail</option>
										<option value="notification_notification" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "notification_notification") selected @endif>Notification</option>
										<option value="notification_promo" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "notification_promo") selected @endif>Notification Promo</option>
										<option value="history_order" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "history_order") selected @endif>History Order</option>
										<option value="history_consultation" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "history_consultation") selected @endif>History Consultation</option>
										<option value="doctor_detail" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "doctor_detail") selected @endif>Doctor Detail</option>
										<option value="wishlist" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "wishlist") selected @endif>Wishlist</option>
										<option value="privacy_policy" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "privacy_policy") selected @endif>Privacy Policy</option>
										<option value="faq" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "faq") selected @endif>FAQ</option>
										<option value="enquires" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "enquires") selected @endif>Enquires</option>
										<option value="featured_promo_home" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "featured_promo_home") selected @endif>Featured Promo Home</option>
										<option value="featured_promo_merchant" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "featured_promo_merchant") selected @endif>Featured Promo Merchant</option>
										<option value="promo_detail" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "promo_detail") selected @endif>Promo Detail</option>
										<option value="url" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "url") selected @endif>URL</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="atd_push" style="display:none;">
								<label for="campaign_push_id_reference" class="control-label col-md-2" style="padding-top:30px;">Action to Detail</label>
								<div class="col-md-10" style="padding-top:30px;">
									<select name="campaign_push_id_reference" id="campaign_push_id_reference" class="form-control select2">
									</select>
								</div>
							</div>
							<div class="form-group" id="link_push" @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
								<label for="campaign_push_link" class="control-label col-md-2" style="padding-top:30px;">Link</label>
								<div class="col-md-10" style="padding-top:30px;">
									<input type="text" placeholder="https://" class="form-control" name="campaign_push_link" id="campaign_push_link" @if(isset($result['campaign_push_link'])) value="{{$result['campaign_push_link']}}" @endif>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif

			@if($result['campaign_media_inbox'] == "Yes")
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Inbox Content</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="form-group">
								<label class="col-md-2 control-label">Subject</label>
								<div class="col-md-10">
									<input type="text" placeholder="Inbox Subject" maxlength="125" class="form-control" name="campaign_inbox_subject" id="campaign_inbox_subject" required @if(isset($result['campaign_inbox_subject']) && $result['campaign_inbox_subject'] != "") value="{{$result['campaign_inbox_subject']}}" @endif>
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
									</div>
								</div>
							</div>
							<div class="form-group" id="div_inbox_content" style="margin-bottom:30px;">
								<label for="multiple" class="control-label col-md-2" style="padding-top:30px;">Content</label>
								<div class="col-md-10" style="padding-top:30px;">
									<textarea name="campaign_inbox_content" id="campaign_inbox_content"  placeholder="Inbox Content" class="form-control">@if(isset($result['campaign_inbox_content']) && $result['campaign_inbox_content'] != ""){{$result['campaign_inbox_content']}}@endif</textarea>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
									</div>
									<br>
								</div>
							</div>
							<div class="form-group">
								<label for="campaign_inbox_clickto" class="control-label col-md-2">Click Action</label>
								<div class="col-md-10">
									<select name="campaign_inbox_clickto" id="campaign_inbox_clickto" class="form-control select2" onChange="fetchDetail(this.value, 'inbox')">
										<option value="none" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "none") selected @endif>None</option>
										<option value="home" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "home") selected @endif>Home</option>
										<option value="membership" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "membership") selected @endif>Membership</option>
										<option value="point_history" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "point_history") selected @endif>Point History</option>
										<option value="store" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "store") selected @endif>Store</option>
										<option value="consultation" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "consultation") selected @endif>Consultation</option>
										<option value="elearning" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "elearning") selected @endif>E-learning</option>
										<option value="product_recomendation_list" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "No Action") selected @endif>Product Recomendation List</option>
										<option value="home" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "product_recomendation_list") selected @endif>Doctor Recomendation List</option>
										<option value="merchant_detail" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "merchant_detail") selected @endif>Merchant Detail</option>
										<option value="product_detail" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "product_detail") selected @endif>Product Detail</option>
										<option value="notification_notification" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "notification_notification") selected @endif>Notification</option>
										<option value="notification_promo" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "notification_promo") selected @endif>Notification Promo</option>
										<option value="history_order" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "history_order") selected @endif>History Order</option>
										<option value="history_consultation" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "history_consultation") selected @endif>History Consultation</option>
										<option value="doctor_detail" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "doctor_detail") selected @endif>Doctor Detail</option>
										<option value="wishlist" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "wishlist") selected @endif>Wishlist</option>
										<option value="privacy_policy" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "privacy_policy") selected @endif>Privacy Policy</option>
										<option value="faq" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "faq") selected @endif>FAQ</option>
										<option value="enquires" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "enquires") selected @endif>Enquires</option>
										<option value="featured_promo_home" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "featured_promo_home") selected @endif>Featured Promo Home</option>
										<option value="featured_promo_merchant" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "featured_promo_merchant") selected @endif>Featured Promo Merchant</option>
										<option value="promo_detail" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "promo_detail") selected @endif>Promo Detail</option>
										<option value="url" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "url") selected @endif>URL</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="atd_inbox" style="display:none;">
								<label for="campaign_inbox_id_reference" class="control-label col-md-2" style="padding-top:30px;">Action to Detail</label>
								<div class="col-md-10" style="padding-top:30px;">
									<select name="campaign_inbox_id_reference" id="campaign_inbox_id_reference" class="form-control select2">
									</select>
								</div>
							</div>
							<div class="form-group" id="link_inbox" @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
								<label for="campaign_inbox_link" class="control-label col-md-2" style="padding-top:30px;">Link</label>
								<div class="col-md-10" style="padding-top:30px;">
									<input type="text" placeholder="https://" class="form-control" name="campaign_inbox_link" id="campaign_inbox_link" @if(isset($result['campaign_inbox_link'])) value="{{$result['campaign_inbox_link']}}" @endif>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif

			@if($result['campaign_media_whatsapp'] == "Yes")
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">WhatsApp Content</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="repeat">
								<div data-repeater-list="campaign_whatsapp_content">
									@if(count($result['whatsapp_content']) > 0)
										@foreach($result['whatsapp_content'] as $content)
											<div data-repeater-item="" class="item-repeat portlet light bordered" style="margin:15px">
												<input type="hidden" name="id_whatsapp_content" value="{{$content['id_whatsapp_content']}}">
												<div class="form-group row" style="padding:0; margin-bottom:15px">
													<label class="col-md-2 control-label" style="text-align:right">Content Type</label>
													<div class="col-md-4">
														<select name="content_type" class="form-control select content-type" style="width:100%" required>
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
													<label class="col-md-2 control-label" style="text-align:right">Content</label>
													<div class="col-md-8">
														<textarea name="content" rows="3" class="form-control whatsapp-content" placeholder="WhatsApp Content">@if($content['content_type'] == 'text') {{$content['content']}} @endif</textarea>
														<br>
														You can use this variables to display user personalized information:
														<br><br>
														<div class="row">
															@foreach($textreplaces as $key=>$row)
																<div class="col-md-3" style="margin-bottom:5px;">
																	<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}', this);">{{ str_replace('_',' ',$row['keyword']) }}</span>
																</div>
															@endforeach
														</div>
														<br><br>
													</div>
												</div>
												<div class="form-group type_file row" @if($content['content_type'] != 'file') style="display:none" @endif>
													<label class="col-md-2 control-label" style="text-align:right">Content</label>
													<div class="col-md-9">
														@if($content['content_type'] == 'file')
															<div class="form-group filename">
															@php $file = explode('/', $content['content']) @endphp
															<label class="control-label"><a href= "{{$content['content']}}"> <i class="fa fa-file-pdf-o"></i> {{end($file)}} </a> </label>
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
													<label class="col-md-2 control-label" style="text-align:right">Content</label>
													<div class="col-md-9">
														<div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
															@if($content['content_type'] == 'image')
																<img src="{{$content['content']}}" alt="">
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
											<div class="form-group row" style="padding:0; margin-bottom:15px">
												<label class="col-md-2 control-label" style="text-align:right">Content Type</label>
												<div class="col-md-4">
													<select name="content_type" class="form-control select content-type" style="width:100%" required>
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
												<label class="col-md-2 control-label" style="text-align:right">Content</label>
												<div class="col-md-8">
													<textarea name="content" rows="3" class="form-control whatsapp-content" placeholder="WhatsApp Content">@if(isset($result['campaign_whatsapp_content']) && $result['campaign_whatsapp_content'] != ""){{$result['campaign_whatsapp_content']}}@endif</textarea>
													<br>
													You can use this variables to display user personalized information:
													<br><br>
													<div class="row">
														@foreach($textreplaces as $key=>$row)
															<div class="col-md-3" style="margin-bottom:5px;">
																<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}', this);">{{ str_replace('_',' ',$row['keyword']) }}</span>
															</div>
														@endforeach
													</div>
													<br><br>
												</div>
											</div>
											<div class="form-group type_file row" style="display:none">
												<label class="col-md-2 control-label" style="text-align:right">Content</label>
												<div class="col-md-9">
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
												<label class="col-md-2 control-label" style="text-align:right">Content Image</label>
												<div class="col-md-9">
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
								<label class="col-md-2 control-label" style="text-align:right"></label>
								<a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add">
									<i class="fa fa-plus"></i> Add Content</a>
								<br>
								<br>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif
		</div>
		<div class="col-md-12" style="text-align:center;">
			<div class="form-actions">
				{{ csrf_field() }}
				<button type="submit" class="btn blue">Save Campaign</button>
			</div>
		</div>
	</form>
</div>
@endsection
