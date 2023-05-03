
@extends('layouts.main')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="javascript:;">Specialist</a>
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
							<span class="caption-subject bold uppercase">Specialist Form</span>
						</div>
					</div>
					<div class="portlet-body">
						@if(isset($specialist))
						<form role="form" class="form-horizontal" action="{{ url('/doctor/specialist', $specialist['id_doctor_specialist'])}}" method="POST">
						@method('PUT')
						<input class="form-control" type="hidden" name="id_doctor_specialist" value="{{$specialist['id_doctor_specialist']}}" required>
						@else 
						<form role="form" class="form-horizontal" action="{{url('doctor/specialist')}}" method="POST">
						@endif
							{{--<div class="form-group">
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">Specialist Category Name
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="pilih specialist category untuk specialist" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-4">
									<select name="id_doctor_specialist_category" class="form-control input-sm select2" data-placeholder="Yes / No" required>
										<option value="">Choose Category...</option>
										@if(isset($category))
											@foreach($category as $row)
												<option value="{{$row['id_doctor_specialist_category']}}"
												{{isset($specialist)? $specialist['id_doctor_specialist_category'] == $row['id_doctor_specialist_category'] ? 'selected' : '' : ''}}>
												{{$row['doctor_specialist_category_name']}}</option>
											@endforeach
										@endif
									</select>
									</div>
								</div>
							</div>--}}
							<div class="form-group">
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">Specialist Name
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="masukkan nama specialist" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-4">
										<input class="form-control" type="text" name="doctor_specialist_name" value="{{ isset($specialist) ? $specialist['doctor_specialist_name'] : old('doctor_specialist_name') }}" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="form-group col-md-12">
									<label class="col-md-4 control-label"> </label>
									<div class="col-md-8">
										<div class="form-actions">
											{{ csrf_field() }}
											<button type="submit" class="btn blue" id="checkBtn">{{isset($specialist) ? 'Update' : 'Create'}}</button>
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