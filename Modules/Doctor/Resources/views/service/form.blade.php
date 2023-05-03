
@extends('layouts.main')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="javascript:;">Service</a>
		</li>
	</ul>
</div>
<br>
@include('layouts.notifications')
    <div class="tab-pane" id="user-profile">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Service Form</span>
						</div>
					</div>
					<div class="portlet-body">
						@if(isset($service))
						<form role="form" class="form-horizontal" action="{{ url('/doctor/service', $service['id_doctor_service'])}}" method="POST">
							@method('PUT')
						@else 
						<form role="form" class="form-horizontal" action="{{ url('doctor/service') }}" method="POST"> 
						@endif
							<div class="form-group">
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">Service Name
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="masukkan nama service" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-4">
										@if(isset($service))
										<input class="form-control" type="hidden" name="id_doctor_service" value="{{$service['id_doctor_service']}}" required>
										@endif
										<input class="form-control" type="text" name="doctor_service_name" value="{{ isset($service) ? $service['doctor_service_name'] : old('doctor_service_name') }}" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="form-group col-md-12">
									<label class="col-md-4 control-label"> </label>
									<div class="col-md-8">
										<div class="form-actions">
											{{ csrf_field() }}
											<button type="submit" class="btn blue" id="checkBtn">{{isset($service) ? 'Update' : 'Create'}}</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection