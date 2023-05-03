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
	<script>
		$('#sample_1').on('draw.dt', function() {
            $('[data-toggle=confirmation]').confirmation({ btnOkClass: 'btn btn-sm btn-success', btnCancelClass: 'btn btn-sm btn-danger'});
        });
	</script>
@endsection

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#">Home</a>
                <i class="fa fa-circle"></i>
			</li>
			<li>
				<a href="#">Clinic</a>
			</li>
		</ul>
	</div>
	@include('layouts.notifications')

	<div class="row" style="margin-top:20px">
		<div class="col-md-12">
			<div class="portlet light portlet-fit bordered" >
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase"><i class="fa fa-list"></i> {{$title}} </span>
					</div>
				</div>
				@if(MyHelper::hasAccess([337], $grantedFeature))
				<a href="{{ url('doctor/specialist/create') }}" data-repeater-create="" class="btn btn-info mt-repeater-add" style="margin-left: 20px;"><i class="fa fa-plus"></i> Add Specialist</a>
				@endif
				<div class="portlet-body">
					<div class="table-scrollable">
						<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
							<tr>
								<th scope="col" style="width:70px !important"> No </th>
								<th scope="col"> Name </th>
								<th scope="col"> </th>
							</tr>
							</thead>
							<tbody>
							@if(count($specialist) > 0)
							@foreach($specialist as $key => $value)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$value['doctor_specialist_name']}}</td>
								<td>
									<form action="{{ url('doctor/specialist', $value['id_doctor_specialist']) }}" method="POST">
										@if(MyHelper::hasAccess([338], $grantedFeature))
										<a href="{{ url('doctor/specialist', $value['id_doctor_specialist']) }}/{{'edit'}}" class="btn btn-sm blue"><i class="fa fa-edit"></i></a>
										@endif
										{{--<a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_doctor_specialist'] }}"><i class="fa fa-trash-o"></i></a>--}}
									
										@if(MyHelper::hasAccess([339], $grantedFeature))
										{{--<a method="DELETE" href="{{ url('doctor/specialist', $value['id_doctor_specialist']) }}" data-toggle="confirmation" data-popout="true" type="submit" class="btn btn-sm red delete" data-id="{{ $value['id_doctor_specialist'] }}"><i class="fa fa-trash-o"></i></a>--}}
										@csrf
										@method('DELETE')
										<button  data-toggle="confirmation" data-popout="true" type="submit" class="btn btn-sm red delete" data-id="{{ $value['id_doctor_specialist'] }}"><i class="fa fa-trash-o"></i></button>
										@endif
									</form>
								</td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan=3 style="text-align:center;">No data available in table</td>
							</tr>
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection