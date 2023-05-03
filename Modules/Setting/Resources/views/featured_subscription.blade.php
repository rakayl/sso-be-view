<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
<div class="tab-pane" id="featured_subscription">
	@if(MyHelper::hasAccess([242], $grantedFeature))
    <div style="margin:20px 0">
        <a class="btn blue btn-outline sbold" data-toggle="modal" href="#modalFeaturedSubscription"> New Featured Subscription
        	<i class="fa fa-question-circle tooltips" data-original-title="Membuat featured subscription di halaman home aplikasi mobile" data-container="body"></i>
        </a>
    </div>
	@endif

	<div class="row" style="margin-top:20px">
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">List Featured Subscription</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="alert alert-warning">
					    <p> To arrange the order of subscription, drag and drop on the subscription in the order of the desired image.</p>
					</div>
					@if(!empty($featured_subscriptions))
					<form action="{{ url('setting/featured_subscription/reorder') }}" method="POST">
						<div class="clearfix" id="sortable2">
							@foreach ($featured_subscriptions as $key => $featured_subscription)
							@php
								// dd($featured_subscription);
							@endphp
				 			<div class="portlet portlet-sortable light bordered col-md-3">
				 				<div class="portlet-title">
									<div class="row">
										<div class="col-md-2">
				 				  			<span class="caption-subject bold" style="font-size: 12px !important;">{{ $key + 1 }}</span>
										</div>
										<div class="col-md-10 text-right">
											@if(MyHelper::hasAccess([243], $grantedFeature))
												<a class="btn blue btn-circle btn-edit" href="#modalFeaturedSubscriptionUpdate" data-toggle="modal" data-start-date="{{ date('d M Y H:i',strtotime($featured_subscription['date_start'])) }}" data-end-date="{{ date('d M Y H:i',strtotime($featured_subscription['date_end'])) }}" data-id-subscription="{{ $featured_subscription['id_subscription'] }}" data-subscription-title="{{ $featured_subscription['subscription']['subscription_title'] }}" data-id="{{ $featured_subscription['id_featured_subscription'] }}"><i class="fa fa-pencil"></i> </a>
											@endif
											@if(MyHelper::hasAccess([244], $grantedFeature))
												<a class="btn red-mint btn-circle btn-delete" data-id="{{ $featured_subscription['id_featured_subscription'] }}"><i class="fa fa-trash-o"></i> </a>
											@endif
										</div>
									</div>
				 				</div>
				 			 	<div class="portlet-body">
				 			   		<input type="hidden" name="id_featured_subscription[]" value="{{ $featured_subscription['id_featured_subscription'] }}">
				 			   		<center><img src="{{ $featured_subscription['subscription']['url_subscription_image'] }}" alt="FeaturedSubscription Image" width="150"></center>
				 			 	</div>
				 			 	<div class="click-to text-center">
				 			 		<div>{{ $featured_subscription['subscription']['subscription_title'] }}</div>
				 			 		<div>{!! date('d M Y H:i:s',strtotime($featured_subscription['date_start']))."<br> - <br>".date('d M Y H:i:s',strtotime($featured_subscription['date_end'])) !!}</div>
				 			 	</div>
				 			</div>
				 			@endforeach
						</div>
						@if(MyHelper::hasAccess([243], $grantedFeature))
						<div class="text-center">
							{{ csrf_field() }}
							<input type="submit" value="Update Sorting" class="btn blue">
						</div>
						@endif
					</form>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalFeaturedSubscriptionUpdate" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Featured Subscription</h4>
			</div>
			<div class="modal-body form">
				<br>
				<form role="form" action="{{url('setting/featured_subscription/update')}}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id_featured_subscription" id="id_featured_subscription">
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Subscription</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<select class="select2 form-control" name="id_subscription" id="id_subscription" style="width: 100%">
									<option></option>
									@foreach($subscriptions as $subscription)
									<option value="{{$subscription['id_subscription']}}">{{$subscription['subscription_title']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Start Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="date_start" id="start_date_subs">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>End Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="date_end" id="end_date_subs">
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center">
						{{ csrf_field() }}
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalFeaturedSubscription" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Create Featured Subscription</h4>
			</div>
			<div class="modal-body form">
				<br>
				<form role="form" action="{{url('setting/featured_subscription/create')}}" method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Subscription</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<select class="select2 form-control" name="id_subscription" style="width: 100%">
									<option></option>
									@foreach($subscriptions as $subscription)
									<option value="{{$subscription['id_subscription']}}">{{$subscription['subscription_title']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Start Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="date_start">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>End Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="date_end">
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center">
						{{ csrf_field() }}
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						<button type="submit" class="btn blue" id="checkBtn">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>