<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
 ?>
 @extends('layouts.main-closed')

 @section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
<script>
    function viewLogDetail(url, status, request, response, ip, useragent){
		document.getElementById("log-url").value = url;
		document.getElementById("log-status").value = status;
		document.getElementById("log-request").innerHTML = request;
		document.getElementById("log-response").innerHTML = response;
		document.getElementById("log-ip").value = ip;
		document.getElementById("log-useragent").value = useragent;
	}

	$('.feeds').click(function(){
	    $.ajax({
			type : "GET",
			url : "{{ url('user/ajax/log/{{$phone}}') }}",
			data : "_token="+token,
			success : function(result) {
    			if(success.length > 0){
    			    var months = ['','January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'Oktober', 'November', 'Desember']
    			    result.each(function(i, data)){
    			        var date = new Date(data['created_at']);
    			        date = date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear()
    			        $('.feeds').append(
    			            if(data['response_status'] == 'fail')
    			            '<li>'+
    							'<div class="col1">'+
    								'<div class="cont">'+
    									'<div class="cont-col1">'+
											'<div class="label label-danger">'+
												'<i class="fa fa-exclamation-circle"></i>'+
											'</div>
    										@else
    											<div class="label label-success">
    												<i class="fa fa-check-square"></i>
    											</div>
    										@endif
    									</div>
    									<div class="cont-col2">
    										<div class="desc"> {{$logs['subject']}}
    											@if($logs['response_status'] == 'fail')
    											<span class="label label-danger label-sm"> Failed
    											</span>
    											@else
    											<span class="label label-success label-sm"> Success
    											</span>
    											@endif
    											 from IP {{$logs['ip']}}

    											 <?php
    											 $request =  str_replace('}','\r\n}',str_replace(',',',\r\n&emsp;',str_replace('{','{\r\n&emsp;',strip_tags($logs['request']))));

    											 $response =  str_replace('}','\r\n}',str_replace(',',',\r\n&emsp;',str_replace('{','{\r\n&emsp;',strip_tags($logs['response']))));
    											 ?>
    											'<span class="label label-info label-sm" data-toggle="modal" href="#logModal" onClick="viewLogDetail('{{$logs['url']}}','{{$logs['response_status']}}', '{{$request}}','{{$response}}','{{$logs['ip']}}','{{$logs['useragent']}}')"> <i class="fa fa-info-circle"></i> Details

    											'</span>'+
    										'</div>'+
    									'</div>'+
    								'</div>'+
    							'</div>'+
    							'<div class="col2" style="width: 190px;margin-left: -190px;">'+
    								'<div class="date"> log_date </div>'+
    							'</div>'+
    						'</li>'
    			        )
    			    }
    			}
			}
		});
	})
</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
		</li>
	</ul>
</div>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="profile">
			<div class="tabbable-line tabbable-full-width">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#overview" data-toggle="tab"> LOG ACTIVITY </a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="overview">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<!--end col-md-8-->
									<div class="col-md-12">
										@if(isset($log))
										<h4 class="font-blue sbold uppercase" style="margin-top: 0px;margin-bottom: 50px;font-size: 24px;">Latest Activity Log</h4>
										<div class="tabbable-line tabbable-custom-profile">
											<div class="scroller" data-height="500" data-always-visible="1" data-rail-visible1="1">
												<ul class="feeds">
													@foreach($log as $logs)
													<li>
														<div class="col1">
															<div class="cont">
																<div class="cont-col1">
																	@if($logs['response_status'] == 'fail')
																		<div class="label label-danger">
																			<i class="fa fa-exclamation-circle"></i>
																		</div>
																	@else
																		<div class="label label-success">
																			<i class="fa fa-check-square"></i>
																		</div>
																	@endif
																</div>
																<div class="cont-col2">
																	<div class="desc"> {{$logs['subject']}}
																		@if($logs['response_status'] == 'fail')
																		<span class="label label-danger label-sm"> Failed
																		</span>
																		@else
																		<span class="label label-success label-sm"> Success
																		</span>
																		@endif
																		 from IP {{$logs['ip']}}

																		 <?php
																		 $request =  str_replace('}','\r\n}',str_replace(',',',\r\n&emsp;',str_replace('{','{\r\n&emsp;',strip_tags($logs['request']))));

																		 $response =  str_replace('}','\r\n}',str_replace(',',',\r\n&emsp;',str_replace('{','{\r\n&emsp;',strip_tags($logs['response']))));
																		 ?>
																		<span class="label label-info label-sm" data-toggle="modal" href="#logModal" onClick="viewLogDetail('{{$logs['url']}}','{{$logs['response_status']}}', '{{$request}}','{{$response}}','{{$logs['ip']}}','{{$logs['useragent']}}')"> <i class="fa fa-info-circle"></i> Details

																		</span>
																	</div>
																</div>
															</div>
														</div>
														<div class="col2" style="width: 190px;margin-left: -190px;">
															<div class="date"> {{date("d F Y H:i:s", strtotime($logs['created_at']))}} </div>
														</div>
													</li>
													@endforeach
												</ul>
											</div>
										</div>
										@endif

									</div>
									<div class="col-md-4" style="padding-left:0px;padding-right:0px;">
                    					<div class="pull-right pagination" style="margin-top: 0px;margin-bottom: 0px;">
                    						<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
                    							<li class="page-first disabled"><a href="javascript:void(0)">«</a></li>
                    							<li class="page-first"><a href="">«</a></li>


                    							<li class="page-last disabled"><a href="javascript:void(0)">»</a></li>
                    							<li class="page-last"><a href="">»</a></li>

                    						</ul>
                    					</div>
                    				</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="logModal" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Request & Response Detail</h4>
			</div>
			<div class="modal-body form">
				<form role="form">
					<div class="form-body">
						<div class="form-group">
							<label>URL</label>
							<input type="text" class="form-control" readonly id="log-url">
						</div>
						<div class="form-group">
							<label>Status</label>
							<input type="text" class="form-control" readonly id="log-status">
						</div>
						<div class="form-group">
							<label>IP Address</label>
							<input type="text" class="form-control" readonly id="log-ip">
						</div>
						<div class="form-group">
							<label>User Agent</label>
							<input type="text" class="form-control" readonly id="log-useragent">
						</div>
						<div class="form-group">
							<label>Request</label>
							<textarea class="form-control" rows="4" readonly id="log-request"></textarea>
						</div>
						<div class="form-group">
							<label>Response</label>
							<textarea class="form-control" rows="4" readonly id="log-response"></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
@endsection