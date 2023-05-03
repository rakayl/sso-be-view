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
        $('#sample_1').dataTable({
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
                buttons: [{
                    extend: "print",
                    className: "btn dark btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "copy",
                  className: "btn blue btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                },{
                  extend: "pdf",
                  className: "btn yellow-gold btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }, {
                    extend: "excel",
                    className: "btn green btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                    extend: "csv",
                    className: "btn purple btn-outline ",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "colvis",
                  className: "btn red",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
    </script>
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
			document.getElementById('autocrm_push_image').src = env('STORAGE_URL_VIEW')+image;
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

		if(det == 'Treatment'){
			$.ajax({
				type : "GET",
				url : "{{ url('treatment/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd').style.display = 'block';
					var operator_value = document.getElementsByName('autocrm_push_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=1;x <= result.length; x++){
						operator_value.options[operator_value.options.length] = new Option(result[x]['treatment_name'], result[x]['id_treatment']);
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
			<span class="caption-subject font-dark sbold uppercase">List Auto CRM</span>
		</div>
	</div>
	<div class="portlet-body form">
		<table class="table table-bordered table-hover" width="100%">
			<thead>
				<tr>
					<th> No </th>
					<th> Title </th>
					<th> Send Email </th>
					<th> Send SMS </th>
					<th> Send Push </th>
					<th> Send Inbox </th>
					<th> Forward Email </th>
				</tr>
			</thead>
			<tbody>
				@if (!empty($data))
					@foreach($data as $key => $value)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $value['autocrm_title'] }}</td>
							<td>@if($value['autocrm_email_toogle'] == 1)
									<a href="#email" data-toggle="modal" class="btn btn-sm blue" onClick="viewEmail('{{ $value['id_autocrm'] }}')"> View Template <i class="fa fa-search-plus"></i></a>
								@else
									<a class="btn btn-sm green" href="{{ url('autocrm/email/turnon') }}/{{ $value['id_autocrm'] }}">Enable Email <i class="fa fa-check-circle"></i></a>
								@endif
							</td>
							<td>@if($value['autocrm_sms_toogle'] == 1)
									<a href="#sms" data-toggle="modal" class="btn btn-sm blue" onClick="viewSms('{{ $value['id_autocrm'] }}')"> View Template <i class="fa fa-search-plus"></i></a>
								@else
									<a class="btn btn-sm green" href="{{ url('autocrm/sms/turnon') }}/{{ $value['id_autocrm'] }}">Enable Sms <i class="fa fa-check-circle"></i></a>
								@endif
							</td>
							<td>@if($value['autocrm_push_toogle'] == 1)
									<a href="#push" data-toggle="modal" class="btn btn-sm blue" onClick="viewPush('{{ $value['id_autocrm'] }}')"> View Template <i class="fa fa-search-plus"></i></a>
								@else
									<a class="btn btn-sm green" href="{{ url('autocrm/push/turnon') }}/{{ $value['id_autocrm'] }}">Enable Push <i class="fa fa-check-circle"></i></a>
								@endif
							</td>
							<td>@if($value['autocrm_inbox_toogle'] == 1)
									<a href="#inbox" data-toggle="modal" class="btn btn-sm blue" onClick="viewInbox('{{ $value['id_autocrm'] }}')"> View Template <i class="fa fa-search-plus"></i></a>
								@else
									<a class="btn btn-sm green" href="{{ url('autocrm/inbox/turnon') }}/{{ $value['id_autocrm'] }}">Enable Inbox <i class="fa fa-check-circle"></i></a>
								@endif
							</td>
							<td>@if($value['autocrm_forward_toogle'] == 1)
									<a href="#forward" data-toggle="modal" class="btn btn-sm blue" onClick="viewForward('{{ $value['id_autocrm'] }}')"> View Template <i class="fa fa-search-plus"></i></a>
								@else
									<a class="btn btn-sm green" href="{{ url('autocrm/forward/turnon') }}/{{ $value['id_autocrm'] }}">Enable Forward <i class="fa fa-check-circle"></i></a>
								@endif
							</td>
							<input type="hidden" id="autocrm_email_subject_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_email_subject']}}">
							<input type="hidden" id="autocrm_email_content_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_email_content']}}">
							<input type="hidden" id="autocrm_sms_content_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_sms_content']}}">
							<input type="hidden" id="autocrm_push_subject_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_push_subject']}}">
							<input type="hidden" id="autocrm_push_content_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_push_content']}}">
							<input type="hidden" id="autocrm_push_clickto_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_push_clickto']}}">
							<input type="hidden" id="autocrm_push_id_reference_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_push_id_reference']}}">
							<input type="hidden" id="autocrm_push_link_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_push_link']}}">
							<input type="hidden" id="autocrm_push_image_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_push_image']}}">
							<input type="hidden" id="autocrm_inbox_subject_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_inbox_subject']}}">
							<input type="hidden" id="autocrm_inbox_content_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_inbox_content']}}">
							<input type="hidden" id="autocrm_forward_email_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_forward_email']}}">
							<input type="hidden" id="autocrm_forward_email_subject_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_forward_email_subject']}}">
							<input type="hidden" id="autocrm_forward_email_content_{{ $value['id_autocrm'] }}" value="{{$value['autocrm_forward_email_content']}}">
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade bs-modal-lg" id="email" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Email Content</h4>
			</div>
			<div class="modal-body form">
				<form class="form-horizontal" role="form" action="{{ url('autocrm/email') }}" method="post" enctype="multipart/form-data">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">Subject</label>
							<div class="col-md-9">
								<input type="text" placeholder="Email Subject" class="form-control" name="autocrm_email_subject" id="autocrm_email_subject">
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
								<input type="hidden" id="id_autocrm_email" name="id_autocrm">
								<input type="hidden" name="autocrm_email_toogle" value='1'>
							</div>
						</div>
						<div class="form-group">
							<label for="multiple" class="control-label col-md-3">Content</label>
							<div class="col-md-9">
								<textarea name="autocrm_email_content" id="autocrm_email_content" class="form-control summernote"></textarea>
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
					<div class="form-actions">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn green">Update</button>
								<button type="submit" name="autocrm_email_toogle" value="0" class="btn red">Turn Off Email</button>
								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-modal-lg" id="sms" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">SMS Content</h4>
			</div>
			<div class="modal-body form">
				<form class="form-horizontal" role="form" action="{{ url('autocrm/sms') }}" method="post" enctype="multipart/form-data">
					<div class="form-body">
						<div class="form-group">
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
							<input type="hidden" id="id_autocrm_sms" name="id_autocrm" >
							<input type="hidden" name="autocrm_sms_toogle"  value='1'>
						</div>
					</div>
					<div class="form-actions">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn green">Update</button>
								<button type="submit" name="autocrm_sms_toogle" value="0" class="btn red">Turn Off SMS</button>
								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-modal-lg" id="push" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Push Notification Content</h4>
			</div>
			<div class="modal-body form">
				<form class="form-horizontal" role="form" action="{{ url('autocrm/push') }}" method="post" enctype="multipart/form-data">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">Subject</label>
							<div class="col-md-9">
								<input type="text" placeholder="Push Notification Subject" class="form-control" name="autocrm_push_subject" id="autocrm_push_subject">
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
								<input type="hidden" name="autocrm_push_toogle" value='1'>
							</div>
						</div>
						<div class="form-group">
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
						<div class="form-group">
							<label for="autocrm_push_clickto" class="control-label col-md-3">Gambar</label>
							<div class="col-md-9">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
										<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="autocrm_push_image" />
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
						<div class="form-group">
							<label for="autocrm_push_clickto" class="control-label col-md-3">Click Action</label>
							<div class="col-md-9">
								<select name="autocrm_push_clickto" id="autocrm_push_clickto" class="form-control select2" onChange="fetchDetail(this.value)">
									<option value="Home">Home</option>
									<option value="News">News</option>
									<option value="Product">Product</option>
									<option value="Treatment">Treatment</option>
									<option value="Outlet">Outlet</option>
									<option value="E-Magazine">E-Magazine</option>
									<option value="Inbox">Inbox</option>
									<option value="Voucher">Voucher</option>
									<option value="Contact Us">Contact Us</option>
									<option value="Link">Link</option>
									<option value="Logout">Logout</option>
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
								<input type="text" placeholder="https://" class="form-control" name="autocrm_push_link" id="autocrm_push_link">
							</div>
						</div>

					</div>
					<div class="form-actions">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn green">Update</button>
								<button type="submit" name="autocrm_push_toogle" value="0" class="btn red">Turn Off Push</button>
								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-modal-lg" id="inbox" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Inbox Content</h4>
			</div>
			<div class="modal-body form">
				<form class="form-horizontal" role="form" action="{{ url('autocrm/inbox') }}" method="post" enctype="multipart/form-data">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">Subject</label>
							<div class="col-md-9">
								<input type="text" placeholder="Inbox Subject" class="form-control" name="autocrm_inbox_subject" id="autocrm_inbox_subject">
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
								<input type="hidden" name="autocrm_inbox_toogle" value='1'>
							</div>
						</div>
						<div class="form-group">
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
					</div>
					<div class="form-actions">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn green">Update</button>
								<button type="submit" name="autocrm_inbox_toogle" value="0" class="btn red">Turn Off Inbox</button>
								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-modal-lg" id="forward" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Forward Content</h4>
			</div>
			<div class="modal-body form">
				<form class="form-horizontal" role="form" action="{{ url('autocrm/forward') }}" method="post" enctype="multipart/form-data">
					<div class="form-body">
						<div class="form-group">
							<label for="multiple" class="control-label col-md-3">Forward Address</label>
							<div class="col-md-9">
								<textarea name="autocrm_forward_email" id="autocrm_forward_email" class="form-control" placeholder="Forward Email Address"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Subject</label>
							<div class="col-md-9">
								<input type="text" placeholder="Forward Subject" class="form-control" name="autocrm_forward_email_subject" id="autocrm_forward_email_subject">
								<br>
								You can use this variables to display user personalized information:
								<br><br>
								<div class="row">
									@foreach($textreplaces as $key=>$row)
										<div class="col-md-3" style="margin-bottom:5px;">
											<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addForwardSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
										</div>
									@endforeach
								</div>
								<input type="hidden" id="id_autocrm_forward" name="id_autocrm">
								<input type="hidden" name="autocrm_forward_toogle" value='1'>
							</div>
						</div>
						<div class="form-group">
							<label for="multiple" class="control-label col-md-3">Content</label>
							<div class="col-md-9">
								<textarea name="autocrm_forward_email_content" id="autocrm_forward_email_content" class="form-control summernote"></textarea>
								You can use this variables to display user personalized information:
								<br><br>
								<div class="row">
									@foreach($textreplaces as $key=>$row)
										<div class="col-md-3" style="margin-bottom:5px;">
											<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addForwardContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn green">Update</button>
								<button type="submit" name="autocrm_forward_toogle" value="0" class="btn red">Turn Off Forward</button>
								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection