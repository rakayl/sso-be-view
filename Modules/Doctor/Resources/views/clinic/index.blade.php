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
	<script type="text/javascript">
		$('#sample_1').on('click', '.delete', function() {
			console.log("here");
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');
			var url = "{{ url('doctor/clinic', ":id") }}"
			console.log(id);

            $.ajax({
                type : "DELETE",
                url : url,
                data : "_token="+token+"&id_doctor_clinic="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Product has been deleted.");
                    }
                    else {
						window.location.reload(true);
                        toastr.info("Product has been deleted.");
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
				@if(MyHelper::hasAccess([333], $grantedFeature))
				<a href="{{ url('doctor/clinic/create') }}" data-repeater-create="" class="btn btn-info mt-repeater-add" style="margin-left: 20px;"><i class="fa fa-plus"></i> Add Clinic</a>
				@endif
				<div class="portlet-body">
					<div class="table-scrollable">
						<table class="table table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th scope="col" style="width:70px !important"> No </th>
								<th scope="col"> Name </th>
							</tr>
							</thead>
							<tbody>
							@if(count($clinic) > 0)
							@foreach($clinic as $key => $value)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$value['doctor_clinic_name']}}</td>
								<td>
									<form action="{{ url('doctor/clinic', $value['id_doctor_clinic']) }}" method="POST">
										@if(MyHelper::hasAccess([334], $grantedFeature))
										<a href="{{ url('doctor/clinic', $value['id_doctor_clinic']) }}/{{'edit'}}" class="btn btn-sm blue"><i class="fa fa-edit"></i></a> 
										@endif
										{{--<a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_doctor_clinic'] }}"><i class="fa fa-trash-o"></i></a>--}}
									
										@if(MyHelper::hasAccess([335], $grantedFeature))
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-sm red"><i class="fa fa-trash-o"></i></button>
										@endif
									</form>
								</td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan=2 style="text-align:center;">No data available in table</td>
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