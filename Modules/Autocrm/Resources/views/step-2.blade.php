@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('.summernote').summernote({
				placeholder: 'Email Content',
				tabsize: 2,
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
				height: 120
			});
        });

		function viewEmail(id){
			var subject = document.getElementById('autocrm_email_subject_'+id).value;
			var content = document.getElementById('autocrm_email_content_'+id).value;

			document.getElementById('autocrm_email_subject').value = subject;
			document.getElementById('id_autocrm_email').value = id;

			$('#autocrm_email_content').summernote('code', content);
		}

		function viewSms(id){
			var messages = document.getElementById('autocrm_sms_content_'+id).value;

			document.getElementById('autocrm_sms_content').value = messages;
			document.getElementById('id_autocrm_sms').value = id;
		}

		function viewPush(id){
			function sleep(ms) {
		  return new Promise(resolve => setTimeout(resolve, ms));
		}


			var subject 	= document.getElementById('autocrm_push_subject_'+id).value;
			var content 	= document.getElementById('autocrm_push_content_'+id).value;
			var clickto 	= document.getElementById('autocrm_push_clickto_'+id).value;
			var link 		= document.getElementById('autocrm_push_link_'+id).value;
			var idreference = document.getElementById('autocrm_push_id_reference_'+id).value;
			var image 		= document.getElementById('autocrm_push_image_'+id).value;

			document.getElementById('autocrm_push_subject').value = subject;
			document.getElementById('autocrm_push_content').value = content;
			$('#autocrm_push_clickto').val(clickto).trigger('change');

			document.getElementById('autocrm_push_link').value = link;
			document.getElementById('autocrm_push_image').src = "{{ env('STORAGE_URL_API') }}"+image;
			document.getElementById('id_autocrm_push').value = id;
			setTimeout(function(){
				$('#autocrm_push_id_reference').val(idreference).trigger('change');
			}, 1000);

		}

		function viewInbox(id){
			var subject = document.getElementById('autocrm_inbox_subject_'+id).value;
			var content = document.getElementById('autocrm_inbox_content_'+id).value;

			document.getElementById('autocrm_inbox_subject').value = subject;
			$('#autocrm_inbox_content').summernote('code', content);
			document.getElementById('id_autocrm_inbox').value = id;
		}

		function viewForward(id){
			var forward = document.getElementById('autocrm_forward_email_'+id).value;
			var subject = document.getElementById('autocrm_forward_email_subject_'+id).value;
			var content = document.getElementById('autocrm_forward_email_content_'+id).value;

			document.getElementById('autocrm_forward_email').value = forward;
			document.getElementById('autocrm_forward_email_subject').value = subject;
			$('#autocrm_forward_email_content').summernote('code', content);
			document.getElementById('id_autocrm_forward').value = id;
		}

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

	function fetchDetail(det){
		let token  = "{{ csrf_token() }}";

		if(det == 'Product'){
			$.ajax({
				type : "GET",
				url : "{{ url('product/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd').style.display = 'block';
					var operator_value = document.getElementsByName('autocrm_push_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=1;x <= result.length; x++){
						operator_value.options[operator_value.options.length] = new Option(result[x]['product_name'], result[x]['id_product']);
					}
				}
			});
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Outlet'){
			$.ajax({
				type : "GET",
				url : "{{ url('outlet/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd').style.display = 'block';
					var operator_value = document.getElementsByName('autocrm_push_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=1;x <= result.length; x++){
						operator_value.options[operator_value.options.length] = new Option(result[x]['outlet_name'], result[x]['id_outlet']);
					}
				}
			});
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'News'){
			$.ajax({
				type : "GET",
				url : "{{ url('news/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd').style.display = 'block';
					var operator_value = document.getElementsByName('autocrm_push_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=1;x <= result.length; x++){
						operator_value.options[operator_value.options.length] = new Option(result[x]['news_title'], result[x]['id_news']);
					}
				}
			});
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Home'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'E-Magazine'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Inbox'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Voucher'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Contact Us'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Link'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'block';
		}

		if(det == 'Logout'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}
	}
	function visibleDiv(apa,nilai){
		if(apa == 'email'){
			if(nilai=='1'){
				document.getElementById('div_email_subject').style.display = 'block';
				document.getElementById('div_email_content').style.display = 'block';
			} else {
				document.getElementById('div_email_subject').style.display = 'none';
				document.getElementById('div_email_content').style.display = 'none';
			}
		}
		if(apa == 'sms'){
			if(nilai=='1'){
				document.getElementById('div_sms_content').style.display = 'block';
			} else {
				document.getElementById('div_sms_content').style.display = 'none';
			}
		}

		if(apa == 'push'){
			if(nilai=='1'){
				document.getElementById('div_push_subject').style.display = 'block';
				document.getElementById('div_push_content').style.display = 'block';
				document.getElementById('div_push_image').style.display = 'block';
				document.getElementById('div_push_clickto').style.display = 'block';
				document.getElementById('atd').style.display = 'block';
				document.getElementById('link').style.display = 'block';
			} else {
				document.getElementById('div_push_subject').style.display = 'none';
				document.getElementById('div_push_content').style.display = 'none';
				document.getElementById('div_push_image').style.display = 'none';
				document.getElementById('div_push_clickto').style.display = 'none';
				document.getElementById('atd').style.display = 'none';
				document.getElementById('link').style.display = 'none';
			}
		}

		if(apa == 'inbox'){
			if(nilai=='1'){
				document.getElementById('div_inbox_subject').style.display = 'block';
				document.getElementById('div_inbox_content').style.display = 'block';
			} else {
				document.getElementById('div_inbox_subject').style.display = 'none';
				document.getElementById('div_inbox_content').style.display = 'none';
			}
		}
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
<div class="mt-element-step">
        <div class="row step-line">
            <div class="col-md-4 mt-step-col first">
                <div class="mt-step-number bg-white">1</div>
                <div class="mt-step-title uppercase font-grey-cascade">Info</div>
                <div class="mt-step-content font-grey-cascade">Auto CRM Detail & Rule</div>
            </div>
            <div class="col-md-4 mt-step-col active">
                <div class="mt-step-number bg-white">2</div>
                <div class="mt-step-title uppercase font-grey-cascade">Content</div>
                <div class="mt-step-content font-grey-cascade">Review Auto CRM Content</div>
            </div>
            <div class="col-md-4 mt-step-col last">
                <div class="mt-step-number bg-white">3</div>
                <div class="mt-step-title uppercase font-grey-cascade">Review & Summary</div>
                <div class="mt-step-content font-grey-cascade">Auto CRM Finalization</div>
            </div>
        </div>
    </div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<span class="caption-subject font-dark sbold uppercase font-blue">Content</span>
		</div>
	</div>
	<div class="portlet-body form">
		<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			<div class="form-body">
				<h4>Email</h4>
				<div class="form-group">
					<label class="col-md-3 control-label">Status</label>
					<div class="col-md-9">
						<select name="autocrm_email_toogle" id="autocrm_email_toogle" class="form-control select2" id="email_toogle" onChange="visibleDiv('email',this.value)">
							<option value="0" >Disabled</option>
							<option value="1" >Enabled</option>
						</select>
					</div>
				</div>

				<div class="form-group" id="div_email_subject">
					<label class="col-md-3 control-label">Subject</label>
					<div class="col-md-9">
						<input type="text" placeholder="Email Subject" class="form-control" name="autocrm_email_subject" id="autocrm_email_subject" value="">
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
					</div>
				</div>
				<div class="form-group" id="div_email_content">
					<label for="multiple" class="control-label col-md-3">Content</label>
					<div class="col-md-9">
						<textarea name="autocrm_email_content" id="autocrm_email_content" class="form-control summernote"></textarea>
						You can use this variables to display user personalized information:
						<br><br>
						<div class="row" >
							@foreach($textreplaces as $key=>$row)
								<div class="col-md-3" style="margin-bottom:5px;">
									<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
								</div>
							@endforeach
						</div>
					</div>
				</div>
				<hr>
				<h4>SMS</h4>
				<div class="form-group" >
					<label class="col-md-3 control-label">Status</label>
					<div class="col-md-9">
						<select name="autocrm_sms_toogle" id="autocrm_sms_toogle" class="form-control select2" id="sms_toogle" onChange="visibleDiv('sms',this.value)">
							<option value="0" >Disabled</option>
							<option value="1" >Enabled</option>
						</select>

					</div>
				</div>
				<div class="form-group" id="div_sms_content">
					<label for="multiple" class="control-label col-md-3">Description</label>
					<div class="col-md-9">
						<textarea name="autocrm_sms_content" id="autocrm_sms_content" class="form-control" placeholder="SMS Content"></textarea>
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
					</div>
				</div>
				<hr>
				<h4>Push Notification</h4>
				<div class="form-group">
					<label class="col-md-3 control-label">Status</label>
					<div class="col-md-9">
						<select name="autocrm_push_toogle" id="autocrm_push_toogle" class="form-control select2" id="push_toogle" onChange="visibleDiv('push',this.value)">
							<option value="0" >Disabled</option>
							<option value="1" >Enabled</option>
						</select>

					</div>
				</div>
				<div class="form-group" id="div_push_subject" >
					<label class="col-md-3 control-label">Subject</label>
					<div class="col-md-9" >
						<input type="text" placeholder="Push Notification Subject" class="form-control" name="autocrm_push_subject" id="autocrm_push_subject" value="">
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
						<input type="hidden" id="id_autocrm_push" name="id_autocrm">
					</div>
				</div>
				<div class="form-group" id="div_push_content" >
					<label for="multiple" class="control-label col-md-3">Content</label>
					<div class="col-md-9">
						<textarea name="autocrm_push_content" id="autocrm_push_content" class="form-control"></textarea>
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
				<div class="form-group" id="div_push_image" >
					<label for="autocrm_push_clickto" class="control-label col-md-3">Gambar</label>
					<div class="col-md-9">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
								{{-- @if($data['autocrm_push_image'] == null) --}}
								<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="autocrm_push_image" />
								{{-- @else
								<img src="{{env('STORAGE_URL_API')}}{{$data['autocrm_push_image']}}" id="autocrm_push_image" />
								@endif --}}
							</div>

							<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
							<div>
								<span class="btn default btn-file">
									<span class="fileinput-new"> Select image </span>
									<span class="fileinput-exists"> Change </span>
									<input type="file"  accept="image/*" name="autocrm_push_image"> </span>
								<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group" id="div_push_clickto">
					<label for="autocrm_push_clickto" class="control-label col-md-3">Click Action</label>
					<div class="col-md-9">
						<select name="autocrm_push_clickto" id="autocrm_push_clickto" class="form-control select2" onChange="fetchDetail(this.value)">
							{{-- <option value="Home" @if($data['autocrm_push_clickto'] == 'Home') selected @endif>Home</option>
							<option value="News" @if($data['autocrm_push_clickto'] == 'News') selected @endif>News</option>
							<option value="Product" @if($data['autocrm_push_clickto'] == 'Product') selected @endif>Product</option>
							<option value="Outlet" @if($data['autocrm_push_clickto'] == 'Outlet') selected @endif>Outlet</option>
							<option value="Inbox" @if($data['autocrm_push_clickto'] == 'Inbox') selected @endif>Inbox</option>
							<option value="Deals" @if($data['autocrm_push_clickto'] == 'Deals') selected @endif>Deals</option>
							<option value="Contact Us" @if($data['autocrm_push_clickto'] == 'Contact Us') selected @endif>Contact Us</option>
							<option value="Link" @if($data['autocrm_push_clickto'] == 'Link') selected @endif>Link</option>
							<option value="Logout" @if($data['autocrm_push_clickto'] == 'Logout') selected @endif>Logout</option> --}}
						</select>
					</div>
				</div>
				<div class="form-group" id="atd" style="display:none;">
					<label for="autocrm_push_clickto" class="control-label col-md-3">Action to Detail</label>
					<div class="col-md-9">
						<select name="autocrm_push_id_reference" id="autocrm_push_id_reference" class="form-control select2">
						</select>
					</div>
				</div>
				<div class="form-group" id="link" style="display:none;">
					<label for="autocrm_push_clickto" class="control-label col-md-3">Link</label>
					<div class="col-md-9">
						<input type="text" placeholder="https://" class="form-control" name="autocrm_push_link" value="">
					</div>
				</div>
				<hr>
				<h4>Inbox</h4>
				<div class="form-group">
					<label class="col-md-3 control-label">Status</label>
					<div class="col-md-9">
						<select name="autocrm_inbox_toogle" id="autocrm_inbox_toogle" class="form-control select2" id="autocrm_inbox_toogle" class="form-control select2" id="inbox_toogle" onChange="visibleDiv('inbox',this.value)">
							<option value="0" >Disabled</option>
							<option value="1" >Enabled</option>
						</select>

					</div>
				</div>
				<div class="form-group" id="div_inbox_subject" >
					<label class="col-md-3 control-label">Subject</label>
					<div class="col-md-9">
						<input type="text" placeholder="Inbox Subject" class="form-control" name="autocrm_inbox_subject" id="autocrm_inbox_subject" value="">
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
						<input type="hidden" id="id_autocrm_inbox" name="id_autocrm">
					</div>
				</div>
				<div class="form-group" id="div_inbox_content" >
					<label for="multiple" class="control-label col-md-3">Content</label>
					<div class="col-md-9">
						<textarea name="autocrm_inbox_content" id="autocrm_inbox_content" class="form-control summernote"></textarea>
						You can use this variables to display user personalized information:
						<br><br>
						<div class="row">
							@foreach($textreplaces as $key=>$row)
								<div class="col-md-3" style="margin-bottom:5px;">
									<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
								</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="form-actions">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-offset-5 col-md-5">
						<input type="hidden" name="id_autocrm" value="">
							<button type="submit" class="btn green">Update</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection