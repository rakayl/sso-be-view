<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
	<script>
		var table=$('#sample_1').DataTable({
			"paging": false,
			"searching": false,
			"ordering": false,
			"info": false
		});

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
								title: "Are you sure want to delete campaign '"+name+"' ?",
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
									url : "{{ url('campaign/delete') }}",
									data : "_token="+token+"&id_campaign="+id,
									success : function(result) {
										if (result.status == "success") {
											$('#sample_1').DataTable().row(column).remove().draw();
											swal("Deleted!", "Campaign has been deleted.", "success")
											SweetAlert.init();
										}
										else if(result.status == "fail"){
											swal("Error!", "Failed to delete Campaign. Campaign has been sent.", "error")
										}
										else {
											swal("Error!", "Something went wrong. Failed to delete Campaign.", "error")
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

@section('page-script')
	<script>
		$('.table-scrollable').on('show.bs.dropdown', function () {
			$('.table-scrollable').css( "overflow", "inherit" );
		});

		$('.table-scrollable').on('hide.bs.dropdown', function () {
			$('.table-scrollable').css( "overflow", "auto" );
		})
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
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">Campaign List</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:20px;margin-bottom:15px">
					<div class="col-md-6" style="padding: 0px;">
						<form action="?filter=1" method="POST">
							<input type="text" class="form-control" name="campaign_title" placeholder="Search Campaign Title" @if(isset($post['campaign_title']) && $post['campaign_title'] != "") value = "{{$post['campaign_title']}}" @endif>
					</div>
					<div class="col-md-1" style="padding: 0px;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Search</button>
						</form>
					</div>
					<div class="col-md-1" style="padding: 0px;">
						@if(isset($post['campaign_title']) && $post['campaign_title'] != "")<a href="{{url('campaign')}}" class="btn red">Reset Search</a>@endif
					</div>
				</div>
				<div class="table-scrollable">
					<table class="table table-striped table-bordered table-hover" id="sample_1">
						<thead>
						<tr>
							<th>No</th>
							<th>Title</th>
							<th>Send At</th>
							<th>Media ( All | Sent )</th>
							<th width=10%>Action</th>
						</tr>
						</thead>
						<tbody>
						@if(!empty($campaign))
							@foreach($campaign as $key => $data)
								<tr>
									<td>{{($post['page'] - 1) * 15 + $key + 1}}</td>
									<td>{{$data['campaign_title']}}</td>
									<td>@if($data['campaign_send_at'] != "")
											{{date('d F Y - H:i', strtotime($data['campaign_send_at']))}}
										@else
											{{date('d F Y - H:i', strtotime($data['created_at']))}}
										@endif</td>
									<td>
										<ul>
											@if($data['campaign_media_email'] == 'Yes')<li> Email ({{$data['campaign_email_count_all']}} | {{$data['campaign_email_count_sent']}}) </li> @endif
											@if($data['campaign_media_sms'] == 'Yes')<li> SMS ({{$data['campaign_sms_count_all']}} | {{$data['campaign_sms_count_sent']}})</li> @endif
											@if($data['campaign_media_push'] == 'Yes')<li> Push ({{$data['campaign_push_count_all']}} | {{$data['campaign_push_count_sent']}} )</li> @endif
											@if($data['campaign_media_inbox'] == 'Yes')<li> Inbox ({{$data['campaign_inbox_count']}})</li> @endif
											@if($data['campaign_media_whatsapp'] == 'Yes')<li> WhatsApp ({{$data['campaign_whatsapp_count_all']}})</li> @endif
										</ul>
									</td>
									<td>
										<div class="btn-group pull-right">
											<button class="btn blue btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">Actions
												<i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu pull-right">
												@if($data['campaign_is_sent'] != 'Yes')
													<li>
														<a href="{{ url('campaign/step1') }}/{{ $data['id_campaign'] }}">
															<i class="fa fa-edit"></i> Edit Information </a>
													</li>
													<li>
														<a href="{{ url('campaign/step2') }}/{{ $data['id_campaign'] }}">
															<i class="fa fa-edit"></i> Edit Receipient </a>
													</li>
													<li>
														<a class="sweetalert-delete" data-id="{{ $data['id_campaign']}}" data-name="{{ $data['campaign_title']}}">
															<i class="fa fa-trash"></i> Delete </a>
													</li>
												@endif
												<li>
													<a href="{{ url('campaign/step3') }}/{{ $data['id_campaign'] }}">
														<i class="fa fa-gear"></i> Summary </a>
												</li>
											</ul>
										</div>
									</td>
								</tr>
							@endforeach
						@else
							<tr style="text-align: center"><td colspan="10">No Data Available</td></tr>
						@endif
						</tbody>
					</table>
				</div>
				<br>
				<div style="text-align: right">
					@if ($campaignPaginator)
						{{ $campaignPaginator->links() }}
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection