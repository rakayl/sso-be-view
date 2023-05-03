<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs     		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
@endsection

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{url('/')}}">Home</a>
                <i class="fa fa-circle"></i>
			</li>
			<li>
				<a href="{{url('/payment-method-category')}}">Payment Method Category</a>
			</li>
		</ul>
	</div>
	@include('layouts.notifications')

	<div class="row" style="margin-top:20px">
		<div class="col-md-12">
			<div class="portlet light portlet-fit bordered" >
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase"><i class="fa fa-list"></i> Payment Method Category</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-scrollable">
						<table class="table table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th scope="col"> No </th>
								<th scope="col"> Actions </th>
                                <th scope="col"> Category Name</th>
                                <th scope="col"> Created At</th>
                                <th scope="col"> Updated At</th>
							</tr>
							</thead>
							<tbody>
								@if(!empty($payment_method_category))
									@foreach($payment_method_category as $no => $data)
                                        <tr>
                                            <td> {{$no+1}}</td>
                                            <td>
                                                <a class="btn btn-block yellow btn-xs" href="{{ url('payment-method-category/edit', $data['id_payment_method_category']) }}"><i class="icon-pencil"></i> Edit </a>
                                                <a class="btn btn-block red btn-xs" href="{{ url('payment-method-category/delete', $data['id_payment_method_category']) }}" data-toggle="confirmation" data-placement="top"><i class="icon-close"></i> Delete </a>
                                            </td>
                                            <td> {{$data['payment_method_category_name']}}</td>
                                            <td> {!!str_replace(" ","&nbsp;", date('d F Y H:i', strtotime($data['created_at'])))!!} </td>
											<td> {!!str_replace(" ","&nbsp;", date('d F Y H:i', strtotime($data['updated_at'])))!!} </td>
                                        </tr>
							        @endforeach
							    @endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection