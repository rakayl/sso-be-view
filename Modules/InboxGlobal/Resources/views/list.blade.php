<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

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
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
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
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script>
	$('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('inboxglobal/delete') }}",
                data : "_token="+token+"&id_inbox_global="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Inbox Global has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete discount.");
                    }
                }
            });
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
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">Inbox Global List</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:20px;margin-bottom:15px">
					<div class="col-md-6" style="padding: 0px;">
						<form action="" method="POST">
						<input type="text" class="form-control" name="inbox_global_subject" placeholder="Search Inbox Global Subject" @if(isset($post['inbox_global_subject']) && $post['inbox_global_subject'] != "") value = "{{$post['inbox_global_subject']}}" @endif>
					</div>
					<div class="col-md-1" style="padding: 0px;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Search</button>
						</form>
					</div>
					<div class="col-md-1" style="padding: 0px;">
						@if(isset($post['inbox_global_subject']) && $post['inbox_global_subject'] != "")<a href="{{url('inboxglobal')}}" class="btn red">Reset Search</a>@endif
					</div>
					<div class="col-md-4" style="padding: 0px;">
						<div class="pull-right pagination" style="margin-top: 0px;margin-bottom: 0px;">
							<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
							@if(isset($post['inbox_global_subject']) && $post['inbox_global_subject'] != "")
							@else
								@if($post['skip'] > 0)
									<li class="page-first"><a href="{{url('inboxglobal')}}/page/{{(($post['skip'] + $post['take'])/$post['take'])-1}}">«</a></li>
								@else
									<li class="page-first disabled"><a href="javascript:void(0)">«</a></li>
								@endif

								@if(isset($count) && $count > (($post['skip']+1) * $post['take']))
									<li class="page-last"><a href="{{url('inboxglobal')}}/page/{{(($post['skip'] + $post['take'])/$post['take'])+1}}">»</a></li>
								@else
									<li class="page-last disabled"><a href="javascript:void(0)">»</a></li>
								@endif

							@endif
							</ul>
						</div>
					</div>
				</div>
				<div class="table-scrollable">
					@if(isset($result) && $result != '')
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th width=5%>No</th>
								<th>Subject</th>
								<th width=13%>Date Visible</th>
								<th width=13%>Date Expired</th>
								<th width=20%>Rule</th>
								@if(MyHelper::hasAccess([115,117,118], $grantedFeature))
									<th width=12%>Action</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@foreach($result as $key => $data)
							<tr>
								<td>{{(($post['skip'] + $post['take']) - $post['take'])+($key+1)}}</td>
								<td>{{$data['inbox_global_subject']}}</td>
								<td>{{date("d F Y H:i", strtotime($data['inbox_global_start']))}}</td>
								<td>{{date("d F Y H:i", strtotime($data['inbox_global_end']))}}</td>
								<td>
								@if(isset($data['inbox_global_rule_parents']))
									<div class="row static-info">
										<div class="col-md-4 name">Conditions</div>
										<div class="col-md-8 value">: </div>
									</div>
									@php $i=0; @endphp
									@foreach($data['inbox_global_rule_parents'] as $ruleParent)
									<div class="portlet light bordered" style="margin-bottom:10px">
										@foreach($ruleParent['rules'] as $rule)
										<div class="row static-info">
											<div class="col-md-1 name"></div>
											<div class="col-md-10 value"><li>
											@if($rule['subject'] != 'trx_outlet' && $rule['subject'] != 'trx_product')
												{{ucwords(str_replace("_", " ", $rule['subject']))}} @if(empty($rule['operator']))=@else{{$rule['operator']}}@endif
											@endif
											@if($rule['subject'] == 'trx_outlet')
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
												"{{$name}}" with outlet count {{$rule['operator']}} {{$rule['parameter']}}
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
											</li></div>
										</div>
										@endforeach
										<div class="row static-info">
											<div class="col-md-11 value">
												@if($ruleParent['rule'] == 'and')
													All conditions must valid
												@else
													Atleast one condition is valid
												@endif
											</div>
										</div>
									</div>
									@if(count($data['inbox_global_rule_parents']) > 1 && $i < count($data['inbox_global_rule_parents']) - 1)
									<div class="row static-info" style="text-align:center">
										<div class="col-md-11 value">
											{{strtoupper($ruleParent['rule_next'])}}
										</div>
									</div>
									@endif
									@php $i++; @endphp
									@endforeach
								@endif
								</td>
								@if(MyHelper::hasAccess([115,117,118], $grantedFeature))
									<td>
										@if(MyHelper::hasAccess([115,117], $grantedFeature))
											<a href="{{ url('inboxglobal/edit') }}/{{ $data['id_inbox_global'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
										@endif
										@if(MyHelper::hasAccess([118], $grantedFeature))
											<a class="btn btn-sm red delete" href="{{ url('inboxglobal/delete', $data['id_inbox_global']) }}" data-toggle="confirmation" data-placement="top"><i class="fa fa-trash-o"></i></a>
										@endif
									</td>
								@endif
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
						No User found with such conditions
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection