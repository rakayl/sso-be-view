@php
	use App\Lib\MyHelper;
    $configs = session('configs');
@endphp
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
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>

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
                <i class="icon-equalizer font-blue-hoki"></i>
                <span class="caption-subject font-blue-hoki bold uppercase">Detail</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row widget-row">
				<!-- <div class="col-md-3">
					<ul class="list-unstyled profile-nav">
						<li>
							@if(isset($detail['user']['photo']) && $detail['user']['photo'] != "")
							<img src="{{$detail['user']['photo']}}" class="img-responsive pic-bordered" alt="{{$detail['user']['name']}}'s Photo" />
							@else
							<img src="{{url('images/default-avatar.png')}}" class="img-responsive pic-bordered" alt="{{$detail['user']['name']}} Has no Photo" />
							@endif
						</li>
					</ul>
				</div> -->
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-8 profile-info">
							<h1 class="font-green sbold uppercase">{{$detail['user']['name']}}</h1>

							<ul class="list-group">
								<li class="list-group-item" style="padding: 5px !important;" title="User Phone number & Provider">
									<i class="fa fa-mobile-phone"></i> {{$detail['user']['phone']}} ({{$detail['user']['provider']}}) </li>
								<li class="list-group-item" style="padding: 5px !important;" title="User Email">
									<i class="fa fa-envelope-o"></i> {{$detail['user']['email']}} </li>
								<li class="list-group-item" style="padding: 5px !important;" title="User Gender">
									@if($detail['user']['gender'] == 'Male')<i class="fa fa-male"></i> {{$detail['user']['gender']}} </li>@else<i class="fa fa-female"></i> {{$detail['user']['gender']}} </li>
									@endif
								<li class="list-group-item" style="padding: 5px !important;" title="User City & Province">
									<i class="fa fa-map"></i> {{$detail['user']['city']['city_name']}}, {{$detail['user']['city']['province']['province_name']}} </li>
								<li class="list-group-item" style="padding: 5px !important;" title="User Birthday">
									<i class="fa fa-birthday-cake"></i> {{date("d F Y", strtotime($detail['user']['birthday']))}} </li>
								<li class="list-group-item" style="padding: 5px !important;" title="User Register date & time">
									<i class="fa fa-registered"></i> {{date("d F Y H:i:s", strtotime($detail['user']['created_at']))}} </li>

								@if(MyHelper::hasAccess([20], $configs))
								<li class="list-group-item" style="padding: 5px !important;" title="Membership Level">
									<i class="icon-badge"></i> @if(isset($detail['user']['memberships'][0])) {{$detail['user']['memberships'][0]['membership_name']}} @endif
								</li>
								<li class="list-group-item" style="padding: 5px !important;" title="Membership Benefit">
									<i class="fa fa-gift"></i>
									@php $first = false; @endphp
									@if(MyHelper::hasAccess([21], $configs))
										@if(isset($detail['user']['memberships'][0]['benefit_point_multiplier']))
											@php $first = true; @endphp
											Point Received : {{$detail['user']['memberships'][0]['benefit_point_multiplier']}}%
											<br>
										@endif
									@endif
									@if(MyHelper::hasAccess([22], $configs))
										@if(isset($detail['user']['memberships'][0]['benefit_cashback_multiplier']))
											@if($first == true)
												<i class="fa fa-gift" style="color:white"></i>
											@endif
											@php $first = true; @endphp
											Cashback Received : {{$detail['user']['memberships'][0]['benefit_cashback_multiplier']}}%
											<br>
										@endif
									@endif
									@if(MyHelper::hasAccess([24], $configs))
										@if(isset($detail['user']['memberships'][0]['benefit_promo_id']))
											@if($first == true)
												<i class="fa fa-gift" style="color:white"></i>
											@endif
											@php $first = true; @endphp
											Promo ID : {{$detail['user']['memberships'][0]['benefit_promo_id']}}
											<br>
										@endif
									@endif
									@if(MyHelper::hasAccess([23], $configs))
										@if(isset($detail['user']['memberships'][0]['benefit_discount']))
											@if($first == true)
												<i class="fa fa-gift" style="color:white"></i>
											@endif
											Discount : {{$detail['user']['memberships'][0]['benefit_discount']}}%
											<br>
										@endif
									@endif
								</li>
								@endif
							</ul>
						</div>
						<!--end col-md-8-->
						<div class="col-md-4">
							<div class="portlet sale-summary">
								<div class="portlet-title">
									<div class="caption font-green sbold"> {{$detail['user']['level']}} </div>
								</div>
								<div class="portlet-body">
									<ul class="list-unstyled">
										<li>
											<span class="sale-info"> Phone
												<i class="fa fa-img-up"></i>
											</span>
											@if($detail['user']['phone_verified']==1)
												<span class="sale-num font-blue">verified</span>
											@else
												<span class="sale-num font-red">not verified</span>
											@endif
										</li>
										<li>
											<span class="sale-info"> Email
												<i class="fa fa-img-down"></i>
											</span>
											@if($detail['user']['email_verified']==1)
												<span class="sale-num font-blue">verified</span>
											@else
												<span class="sale-num font-red">not verified</span>
											@endif
										</li>
										<li>
											<span class="sale-info"> Email Unsubscribed </span>
											@if($detail['user']['email_unsubscribed']==0)
												<span class="sale-num font-blue">No</span>
											@else
												<span class="sale-num font-red">Yes</span>
											@endif
										</li>
									</ul>
								</div>
							</div>
						</div>
						<!--end col-md-4-->
					</div>
				</div>
            </div>
        </div>
    </div>

    <div class="portlet light bordered">
	    <div class="row">
	        <div class="col-lg-12 col-xs-12 col-sm-12">
	            <div class="portlet light ">
	                <div class="portlet-title tabbable-line">
	                    <div class="caption">
	                        <i class="icon-bubbles font-dark hide"></i>
	                        <span class="caption-subject font-dark bold uppercase">History</span>
	                    </div>
	                    <ul class="nav nav-tabs">
	                        <li @if($type == 'transactions') class="active" @endif>
	                            <a href="{{url('report/customer/detail/'.$detail['user']['phone'].'/transactions')}}"> Transaction </a>
							</li>
							@if(MyHelper::hasAccess([18], $configs))
								<li @if($type == 'point') class="active" @endif>
									<a href="{{url('report/customer/detail/'.$detail['user']['phone'].'/point')}}"> Point </a>
								</li>
							@endif
	                        <li @if($type == 'log') class="active" @endif>
								<a href="{{url('report/customer/detail/'.$detail['user']['phone'].'/log')}}"> Activity </a>
	                        </li>
	                    </ul>
	                </div>
	                <div class="portlet-body">
	                    <div class="tab-content">
							@if($type == 'transactions')
	                        <div class="tab-pane active" id="portlet_comments_1">
	                            <!-- BEGIN: Comments -->
	                            <div class="mt-comments">
									<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
										<thead>
											<tr>
												<th>Date</th>
												<th>Receipt Number</th>
												<th>Total Price</th>
												<th>Payment Status</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											@if(!empty($detail['transactions']['data']))
												@foreach($detail['transactions']['data'] as $res)
													<tr>
														<td>{{ date('d F Y H:i', strtotime($res['transaction_date'])) }}</td>
														<td>{{ $res['transaction_receipt_number'] }}</td>
														<td>Rp {{ number_format($res['transaction_grandtotal']) }}</td>
														<td>{{ $res['transaction_payment_status'] }}</td>
														<td>
															<a class="btn btn-block yellow btn-xs" href="{{ url('transaction/detail', $res['transaction_receipt_number']).'/'.$res['trasaction_type'] }}"><i class="icon-pencil"></i> Detail </a>
														</td>
													</tr>
												@endforeach
											@else
												<tr><td colspan="5" style="text-align:center">Transaction is empty</td></tr>
											@endif
										</tbody>
									</table>
								</div>
								<!-- END: Comments -->
								@if ($paginator)
									<div>
										Showing {{$from}} to {{$to}} of {{$total}} entries
									</div>
									<div class="pagination pull-right">
										{{ $paginator->links() }}
									</div>
								@endif
							</div>
							@elseif($type == 'point')
	                        <div class="tab-pane active" id="portlet_comments_4">
	                        	<div class="row">
    	                            <div class="col-lg-12 col-xs-12 col-sm-12">
    	                                <div class="portlet light ">
    	                                    <div class="portlet-body">
    	                                        <div class="row number-stats margin-bottom-30">
    	                                            <div class="col-md-6 col-sm-6 col-xs-6">
    	                                                <div class="stat-left">
    	                                                    <div class="stat-number">
    	                                                        <div class="title" style="color: red"> Voucher </div>
    	                                                        <div class="number"> {{ $detail['voucher'] }} </div>
    	                                                    </div>
    	                                                </div>
    	                                            </div>
    	                                            <div class="col-md-6 col-sm-6 col-xs-6">
    	                                                <div class="stat-right">
    	                                                    <div class="stat-number">
    	                                                        <div class="title" style="color: blue"> Transaction </div>
    	                                                        <div class="number"> {{ $detail['trx'] }} </div>
    	                                                    </div>
    	                                                </div>
    	                                            </div>
    	                                        </div>
	                                            <table class="table table-striped table-bordered table-hover dt-responsive" id="sample_4">
	                                                <thead>
	                                                    <tr class="uppercase">
	                                                        <th> Source </th>
	                                                        <th> Point </th>
	                                                        <th> Date </th>
	                                                        <th> Time </th>
	                                                        <th> Detail </th>
	                                                    </tr>
	                                                </thead>
	                                                @if(!empty($detail['point']['data']))
	                                                	@foreach ($detail['point']['data'] as $point)
	    	                                                <tr @if ($point['source'] == 'voucher') style="color: red" @else style="color: blue" @endif >
	    	                                                    <td> {{ ucwords($point['source']) }} </td>
	    	                                                    <td> {{ number_format($point['point']) }} </td>
	    	                                                    <td> {{ date('d F Y', strtotime($point['created_at'])) }} </td>
	    	                                                    <td> {{ date('H:i:s', strtotime($point['created_at'])) }} </td>
	    	                                                    @if ($point['source'] != 'voucher')
	    	                                                    	<td> {{ $point['transaction']['transaction_receipt_number'] }} </td>
	    	                                                    @else
	    	                                                    	<td> {{ $point['detail_product']['trx_id'] }} </td>
	    	                                                    @endif

	    	                                                </tr>
	                                                	@endforeach
													@else
														<tr><td colspan="5" style="text-align:center">History point is empty</td></tr>
													@endif
												</table>
												@if ($paginator)
													<div>
														Showing {{$from}} to {{$to}} of {{$total}} entries
													</div>
													<div class="pagination pull-right">
														{{ $paginator->links() }}
													</div>
												@endif
    	                                    </div>
    	                                </div>
    	                            </div>
    	                        </div>
							</div>
							@elseif($type == 'log')
							<div class="tab-pane active" id="portlet_comments_5">
								<!-- BEGIN: Comments -->
								<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="">
										<thead>
											<tr>
												<th scope="col"> Action </th>
												<th scope="col"> Date Time </th>
												<th scope="col"> Status </th>
												<th scope="col"> Subject </th>
												<th scope="col"> IP </th>
												<th scope="col"> User Agent </th>
											</tr>
										</thead>
										<tbody>
											@if(!empty($detail['log']['data']))
												@foreach($detail['log']['data'] as $no => $data)
													<tr>
														<td>
															<a class="btn btn-block btn-xs green" data-toggle="modal" data-target="#modalLog{{$no}}"><i class="fa fa-search"></i> Detail</a>
														</td>
														<td> {!!str_replace(" ","&nbsp;", date('d F Y', strtotime($data['created_at'])))!!} </td>
														<td> {{$data['response_status']}} </td>
														<td> {!!str_replace(" ","&nbsp;", $data['subject'])!!} </td>
														<td> {{$data['ip']}} </td>
														<td> {!!str_replace(" ","&nbsp;", $data['useragent'])!!} </td>
													</tr>
												@endforeach
											@else
												<tr><td colspan="6" style="text-align:center">History Activity is empty</td></tr>
											@endif
										</tbody>
									</table>
								</div>
								<!-- END: Comments -->
								@if ($paginator)
									<div>
										Showing {{$from}} to {{$to}} of {{$total}} entries
									</div>
									<div class="pagination pull-right">
										{{ $paginator->links() }}
									</div>
								@endif
							</div>
							@endif
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- Modal Detail Log -->
	@if($type == 'log')
		@foreach($detail['log']['data'] as $no => $data)
			<div class="modal fade bs-modal-lg" id="modalLog{{$no}}" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Log Activity Detail</h4>
						</div>
						<div class="modal-body">
							<div class="form-horizontal">
								<div class="form-body">
									<div class="form-group">
										<label class="col-md-2 control-label">Date Time</label>
										<div class="col-md-10">
											<pre>{{date('d F Y H:i:s', strtotime($data['created_at']))}}</pre>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Status</label>
										<div class="col-md-10">
											<pre>{{$data['response_status']}}</pre>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Subject</label>
										<div class="col-md-10">
											<pre>{{$data['subject']}}</pre>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Request</label>
										<div class="col-md-10">
											@php $request = json_decode($data['request']);  @endphp
											<pre><?php echo json_encode($request, JSON_PRETTY_PRINT); ?></pre>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Response</label>
										<div class="col-md-10">
											@php $response = json_decode($data['response']);  @endphp
											<pre><?php echo json_encode($response, JSON_PRETTY_PRINT); ?></pre>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">IP</label>
										<div class="col-md-10">
											<pre>{{$data['ip']}}</pre>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">User Agent</label>
										<div class="col-md-10">
											<pre>{{$data['useragent']}}</pre>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	@endif

@endsection
