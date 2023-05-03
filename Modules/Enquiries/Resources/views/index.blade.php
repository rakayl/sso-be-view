<?php
use App\Lib\MyHelper;
    $grantedFeature = session('granted_features');
$configs = session('configs');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
	<style type="text/css">
    .show{
        display:block !important;
    }
    </style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};


	$('.summernote').summernote({
        placeholder: 'Enquiry Reply',
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
                    url: "{{url('summernote/picture/delete/enquiry')}}",
                    success: function(data){
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
            url : "{{url('summernote/picture/upload/enquiry')}}",
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
        });

		function setIdEnquiry(idnya){
			let token  = "{{ csrf_token() }}";
			document.getElementById('id_enquiry').value = idnya;
			$.ajax({
				type : "POST",
				url : "{{ url('enquiries/ajax') }}",
				data : "_token="+token+"&id_enquiry="+idnya,
				success : function(result) {
					//show detail
					$('#detail-subject').val(result[0]['enquiry_subject'])
					$('#detail-message').val(result[0]['enquiry_content'])

					if (typeof result[0]['files'][0] !== 'undefined') {
						var attacment = '';
						$.each( result[0]['files'], function( key, value ) {
							attacment +='<br><a target="_blank" href="'+value.url_enquiry_file+'">Attachment '+(key+1)+'</a>';
						})
						$('#detail-attachment').append(attacment);
					}

					if(result[0]['reply_email_subject'] != "" && result[0]['reply_email_subject'] != null){
						document.getElementById('reply_email_subject').value = result[0]['reply_email_subject'];

						$('#reply_email_content').val(result[0]['reply_email_content']);
						$('#reply_email_content').summernote('editor.saveRange');
						$('#reply_email_content').summernote('editor.restoreRange');
						$('#reply_email_content').summernote('editor.focus');
						$('#reply_email_content').summernote('code', result[0]['reply_email_content']);

						document.getElementById('reply_email_subject').disabled  = true;
						$('#reply_email_content').summernote('disable');
					} else {
						document.getElementById('reply_email_subject').value = " ";
						$('#reply_email_content').val("");
						$('#reply_email_content').summernote('editor.saveRange');
						$('#reply_email_content').summernote('editor.restoreRange');
						$('#reply_email_content').summernote('editor.focus');
						$('#reply_email_content').summernote('code.insertText', " ");

						document.getElementById('reply_email_subject').disabled  = false;
						$('#reply_email_content').summernote('enable');
					}

					if(result[0]['reply_sms_content'] != "" && result[0]['reply_sms_content'] != null){
						document.getElementById('reply_sms_content').value = result[0]['reply_sms_content'];
						document.getElementById('reply_sms_content').disabled  = true;
					} else {
						document.getElementById('reply_sms_content').value = "";
						document.getElementById('reply_sms_content').disabled  = false;
					}

					if(result[0]['reply_push_subject'] != "" && result[0]['reply_push_subject'] != null){
						document.getElementById('reply_push_subject').value = result[0]['reply_push_subject'];
						if(result[0]['reply_push_content'] != "" && result[0]['reply_push_content'] != null){
							document.getElementById('reply_push_content').value = result[0]['reply_push_content'];
						}

						if(result[0]['reply_push_image'] != "" && result[0]['reply_push_image'] != null){
							document.getElementById('reply_push_image').src = "{{ env('STORAGE_URL_API') }}"+result[0]['reply_push_image'];
						}

						if(result[0]['reply_push_clickto'] != "" && result[0]['reply_push_clickto'] != null){
							$('#reply_push_clickto').val(result[0]['reply_push_clickto']).trigger('change');
							fetchDetail(result[0]['reply_push_clickto'], result[0]['reply_push_id_reference']);
						}


						/* document.getElementById('reply_push_subject').disabled  = true;
						document.getElementById('reply_push_content').disabled  = true;
						document.getElementById('reply_push_clickto').disabled  = true;
						document.getElementById('reply_push_id_reference').disabled  = true;
						document.getElementById('autocrm_push_link').disabled  = true;
						document.getElementById('reply_push_image_btn').disabled  = true; */

					} else {
						/* document.getElementById('reply_push_subject').disabled  = false;
						document.getElementById('reply_push_content').disabled  = false;
						document.getElementById('reply_push_clickto').disabled  = false;
						document.getElementById('reply_push_id_reference').disabled  = false;
						document.getElementById('autocrm_push_link').disabled  = false;
						document.getElementById('reply_push_image_btn').disabled  = false; */
					}



				}
			});
		}

        $('.tablesData').dataTable({searching: false, "paging":   false, ordering: false});

        $('.tablesData').on('click', '.delete', function() {
			var token   = "{{ csrf_token() }}";
			var column  = $(this).parents('tr');
			var id      = $(this).data('id');
			var subject = $(this).data('subject');

            $.ajax({
                type : "POST",
                url : "{{ url('enquiries/delete') }}",
                data : "_token="+token+"&id_enquiry="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#tablesData'+subject).DataTable().row(column).remove().draw();
                        toastr.info("Enquiry has been deleted.");
						location.reload();
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete enquiry.");
                    }
                }
            });
        });

        $('.tablesData').on('switchChange.bootstrapSwitch', '.changeStatus', function(event, state) {

			var token    = "{{ csrf_token() }}";
			var column   = $(this).parents('tr');
			var id       = $(this).data('id');
			var nama     = $(this).data('nama');
			var category = $(this).data('category');

            if (state) {
              var change = "Read";
            }
            else {
              var change = "Unread";
            }

            $.ajax({
                type : "POST",
                url : "{{ url('enquiries/update') }}",
                data : "_token="+token+"&id_enquiry="+id+"&enquiry_status="+change,
                success : function(result) {
                    if (result == "success") {
                        toastr.info(category+" enquiry from "+nama+" has been "+change);
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to update data enquiry.");
                    }
                }
            });
        });

	function addEmailContent(param){
		var textvalue = $('#reply_email_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#reply_email_content').val(textvaluebaru);
		$('#reply_email_content').summernote('editor.saveRange');
		$('#reply_email_content').summernote('editor.restoreRange');
		$('#reply_email_content').summernote('editor.focus');
		$('#reply_email_content').summernote('editor.insertText', param);
	}

	function addEmailSubject(param){
		var textvalue = $('#reply_email_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#reply_email_subject').val(textvaluebaru);
	}

	function addSmsContent(param){
		var textvalue = $('#reply_sms_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#reply_sms_content').val(textvaluebaru);
	}

	function addPushSubject(param){
		var textvalue = $('#reply_push_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#reply_push_subject').val(textvaluebaru);
	}

	function addPushContent(param){
		var textvalue = $('#reply_push_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#reply_push_content').val(textvaluebaru);
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

	function addWhatsappContent(param, element){
		var textarea = $(element).closest('.col-md-3').closest('.row').closest('.col-md-8').find('.whatsapp-content')
		var textvalue = $(textarea).val();
		var textvaluebaru = textvalue+" "+param;
		$(textarea).val(textvaluebaru);
	}

		function fetchDetail(det, id_ref = null){
		let token  = "{{ csrf_token() }}";

		if(det == 'Product'){
			$.ajax({
				type : "GET",
				url : "{{ url('product/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd').style.display = 'block';
					var operator_value = document.getElementsByName('reply_push_id_reference')[0];
					for(var i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(var x=1;x < result.length; x++){
						operator_value.options[operator_value.options.length] = new Option(result[x]['product_name'], result[x]['id_product']);
						if((id_ref !== null || id_ref !== '') && id_ref == result[x]['id_product']){
							$('#reply_push_id_reference').val(result[x]['id_product']).trigger('change');
						}
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
					var operator_value = document.getElementsByName('reply_push_id_reference')[0];
					for(var i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(var x=1;x < result.length; x++){
						operator_value.options[operator_value.options.length] = new Option(result[x]['outlet_name'], result[x]['id_outlet']);
						if((id_ref !== null || id_ref !== '') && id_ref == result[x]['id_outlet']){
							$('#reply_push_id_reference').val(result[x]['id_outlet']).trigger('change');
						}
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
					var operator_value = document.getElementsByName('reply_push_id_reference')[0];
					for(var i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(var x=1;x < result.length; x++){
						operator_value.options[operator_value.options.length] = new Option(result[x]['news_title'], result[x]['id_news']);
						if((id_ref !== null || id_ref !== '') && id_ref == result[x]['id_news']){
							$('#reply_push_id_reference').val(result[x]['id_news']).trigger('change');
						}
					}
				}
			});
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Subscription'){
			$.ajax({
				type : "GET",
				url : "{{ url('subscription/list-ajax') }}",
				data : "_token="+token,
				success : function(result) {
					result = result.result;
					document.getElementById('atd').style.display = 'block';
					var operator_value = document.getElementsByName('reply_push_id_reference')[0];
					for(var i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(var x=1;x < result.length; x++){
						operator_value.options[operator_value.options.length] = new Option(result[x]['subscription_title'], result[x]['id_subscription']);
						if((id_ref !== null || id_ref !== '') && id_ref == result[x]['id_subscription']){
							$('#reply_push_id_reference').val(result[x]['id_subscription']).trigger('change');
						}
					}
				}
			});
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Deals'){
			$.ajax({
				type : "GET",
				url : "{{ url('deals/list/active') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd').style.display = 'block';
					var operator_value = document.getElementsByName('reply_push_id_reference')[0];
					for(var i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(var x=1;x < result.length; x++){
						operator_value.options[operator_value.options.length] = new Option(result[x]['deals_title']+' '+result[x]['deals_second_title'], result[x]['id_deals']);
						if((id_ref !== null || id_ref !== '') && id_ref == result[x]['id_deals']){
							$('#reply_push_id_reference').val(result[x]['id_deals']).trigger('change');
						}
					}
				},error: function(xhr){
					console.log(xhr);
				}
			});
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Home'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('reply_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'E-Magazine'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('reply_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Inbox'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('reply_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Deals'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('reply_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Contact Us'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('reply_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}

		if(det == 'Link'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('reply_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'block';
		}

		if(det == 'Logout'){
			document.getElementById('atd').style.display = 'none';
			var operator_value = document.getElementsByName('reply_push_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link').style.display = 'none';
		}
	}

		var SweetAlert = function() {
			return {
				init: function() {
					$(".sweetalert-delete").each(function() {
						var token  	= "{{ csrf_token() }}";
						let column 	= $(this).parents('tr');
						let id     	= $(this).data('id');
						let name    = $(this).data('name');
						$(this).click(function() {
							swal({
										title: name+"\n\nAre you sure want to delete this data?",
										text: "Your will not be able to recover this data!",
										type: "warning",
										showCancelButton: true,
										confirmButtonClass: "btn-danger",
										confirmButtonText: "Yes, delete it!",
										closeOnConfirm: false
									},
									function(){

										$.ajax({
											type : "POST",
											url : "{{ url('enquiries/delete') }}",
											data : "_token="+token+"&id_enquiry="+id,
											success : function(result) {
												if (result.status == "success") {
													swal({
														title: 'Deleted!',
														text: 'Data has been deleted.',
														type: 'success',
														showCancelButton: false,
														showConfirmButton: false
													})
													SweetAlert.init()
													location.href = "{{url('enquiries')}}";
												}
												else if(result.status == "fail"){
													swal("Error!", result.messages[0], "error")
												}
												else {
													swal("Error!", "Something went wrong. Failed to delete data.", "error")
												}
											}
										});
									});
						})
					})
				}
			}
		}();

		jQuery(document).ready(function() {
			SweetAlert.init()
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

	<?php
	$date_start = '';
	$date_end = '';

	if(Session::has('filter-list-enquiries')){
		$search_param = Session::get('filter-list-enquiries');
		if(isset($search_param['date_start'])){
			$date_start = $search_param['date_start'];
		}

		if(isset($search_param['date_end'])){
			$date_end = $search_param['date_end'];
		}

		if(isset($search_param['rule'])){
			$rule = $search_param['rule'];
		}

		if(isset($search_param['conditions'])){
			$conditions = $search_param['conditions'];
		}
	}
	?>

	<form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
		{{ csrf_field() }}
		@include('enquiries::filter_list')
	</form>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">List Contact Us</span>
            </div>
        </div>
		<div class="portlet-body form">
			<div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
				<table class="table table-striped table-bordered table-hover tablesData">
					<thead>
					<tr>
						<th class="noExport show"> Action </th>
						<th> Status </th>
						<th> Subject </th>
						<th> Date </th>
						<th> Name </th>
						<th> Phone </th>
						<th> Email </th>
					</tr>
					</thead>
					<tbody>
					@if (!empty($data))
						<?php $no = 1; ?>
						@foreach($data as $key => $value)
							<tr>
								<td class="noExport show">
									<a class="btn btn-block red btn-xs sweetalert-delete" data-id="{{ $value['id_enquiry'] }}" data-name="{{ $value['enquiry_subject'] }} ({{$value['enquiry_name']}})"><i class="fa fa-trash-o"></i> Delete</a>

									<a class="btn btn-block btn-xs blue" data-toggle="modal" data-target="#{{ $key }}"><i class="fa fa-search"></i> Detail</a>
									@if(MyHelper::hasAccess([57], $configs))
										<a class="btn btn-block btn-xs green" data-toggle="modal" data-target="#modalReply" onClick="setIdEnquiry({{$value['id_enquiry']}})"><i class="fa fa-mail-reply"></i> Reply</a>
									@endif
								</td>
								<td>
									<input type="checkbox" class="make-switch changeStatus" data-on-text="Read" data-off-text="Unread" data-id="{{ $value['id_enquiry'] }}" data-category="{{ $value['enquiry_subject'] }}" data-nama="{{ $value['enquiry_name'] }}" value="{{ $value['enquiry_status'] }}" data-status="{{ $value['enquiry_status'] }}" @if ($value['enquiry_status'] == "Read") checked @endif >
								</td>
								<td>{{$value['enquiry_subject']}}</td>
								<td>{{ date('d F Y H:i', strtotime($value['created_at'])) }}</td>
								<td>{{ $value['enquiry_name'] }}</td>
								<td>{{ $value['enquiry_phone'] }}</td>
								<td>{{ $value['enquiry_email'] }}</td>
							</tr>

							<div id="{{ $key }}" class="modal fade" tabindex="-1" data-keyboard="false">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">({{ date('d F Y H:i:s', strtotime($value['created_at'])) }}) - {{ $value['enquiry_name'] }} </h4>
										</div>
										<div class="modal-body">
											<div class="portlet light portlet-fit bordered">
												<div class="portlet-body form">
													<div class="form-horizontal form-bordered">
														<div class="form-body">
															<div class="form-group">
																<label class="control-label col-md-3">
																	Subject
																</label>
																<div class="col-md-9">
																	<input type="text" readonly value="{{ $value['enquiry_subject'] }}" class="form-control" />
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-md-3">
																	Message
																</label>
																<div class="col-md-9">
																	<textarea class="form-control" readonly>{{ $value['enquiry_content'] }}</textarea>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-md-3">
																	Attachment
																</label>
																<div class="col-md-9">
																	@php
																		$no = 1;
																	@endphp
																	@foreach ($value['files'] as $item)
																		<a target="_blank" href="{{$item['url_enquiry_file']}}">Attachment {{$no++}}</a>
																	@endforeach
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn green">Close</button>
										</div>
									</div>
								</div>
							</div>
							<?php $no++; ?>
						@endforeach
					@endif
					</tbody>
				</table>
			</div>
		</div>
		<br>
		@if ($dataPaginator)
			{{ $dataPaginator->fragment('participate')->links() }}
		@endif
    </div>

<div class="modal fade bs-modal-lg" id="modalReply" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Reply Enquiry</h4>
			</div>
			<div class="col-md-12" style="margin-top: 10px">
				<div class="portlet light portlet-fit">
				<div class="portlet-body form">
					<h4>Detail</h4>
					<div class="form-horizontal">
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">
									Subject
								</label>
								<div class="col-md-9">
									<input type="text" readonly id="detail-subject" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">
									Message
								</label>
								<div class="col-md-9">
									<textarea class="form-control" readonly id="detail-message"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">
									Attachment
								</label>
								<div class="col-md-9" id="detail-attachment">
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
			<div class="modal-body form">
				<form class="form-horizontal" role="form" action="{{ url('enquiries/reply') }}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id_enquiry" id="id_enquiry">
					<div class="form-body">
						@if(MyHelper::hasAccess([38], $configs))
							<h4>Via Email</h4>
							<div class="form-group">
								<label class="col-md-3 control-label">Email Subject</label>
								<div class="col-md-9">
									<input type="text" placeholder="Email Subject" class="form-control" name="reply_email_subject" id="reply_email_subject">
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
							<div class="form-group">
								<label for="multiple" class="control-label col-md-3">Email Content</label>
								<div class="col-md-9">
									<textarea name="reply_email_content" id="reply_email_content" class="form-control summernote"></textarea>
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
						@endif

						@if(MyHelper::hasAccess([39], $configs))
						<h4>Via SMS</h4>
						<div class="form-group">
							<label class="col-md-3 control-label">SMS Content</label>
							<div class="col-md-9">
								<textarea name="reply_sms_content" id="reply_sms_content" class="form-control" placeholder="SMS Content" maxlength="135"></textarea>
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
						@endif

						@if(MyHelper::hasAccess([36], $configs))
							<h4>Via Push Notification</h4>
							<div class="form-group">
								<label for="reply_push_subject" class="col-md-3 control-label">Subject</label>
								<div class="col-md-9">
									<input type="text" placeholder="Push Notification Subject" class="form-control" name="reply_push_subject" id="reply_push_subject">
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
								</div>
							</div>
							<div class="form-group">
								<label for="reply_push_content" class="control-label col-md-3">Content</label>
								<div class="col-md-9">
									<textarea name="reply_push_content" id="reply_push_content" class="form-control"></textarea>
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
								<label for="reply_push_image" class="control-label col-md-3">Gambar</label>
								<div class="col-md-9">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
											<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="reply_push_image" />
										</div>

										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
										<div>
											<span class="btn default btn-file">
												<span class="fileinput-new"> Select image </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file"  accept="image/*" name="reply_push_image" id="btn_reply_push_image"> </span>
											<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="reply_push_clickto" class="control-label col-md-3">Click Action</label>
								<div class="col-md-9">
									<select name="reply_push_clickto" id="reply_push_clickto" class="form-control select2" onChange="fetchDetail(this.value)">
										<option value="Home">Home</option>
										<option value="Deals">Deals</option>
										<option value="Subscription">Subscription</option>
										<option value="My Subscription">My Subscription</option>
										<option value="Voucher">Voucher</option>
										<option value="Order">Order</option>
										<option value="History Transaction">History Transaction</option>
										<option value="History Point">History Point</option>
										<option value="Profil">Profile</option>
										<option value="Membership">Membership</option>
										<option value="News">News</option>
										<option value="Outlet">Outlet</option>
										<option value="About">About</option>
										<option value="FAQ">FAQ</option>
										<option value="TOS">Term Of Services</option>
										<option value="Contact Us">Contact Us</option>
										<option value="Link">Link</option>
										<option value="Logout">Logout</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="atd" style="display:none;">
								<label for="autocrm_push_clickto" class="control-label col-md-3">Action to Detail</label>
								<div class="col-md-9">
									<select name="reply_push_id_reference" id="reply_push_id_reference" class="form-control select2">
									</select>
								</div>
							</div>
							<div class="form-group" id="link" style="display:none;">
								<label for="reply_push_link" class="control-label col-md-3">Link</label>
								<div class="col-md-9">
									<input type="text" placeholder="https://" class="form-control" name="reply_push_link" id="reply_push_link">
								</div>
							</div>
						@endif
					</div>
					<div class="form-actions">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-offset-5 col-md-8">
								<button type="submit" class="btn green">Send Reply</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection