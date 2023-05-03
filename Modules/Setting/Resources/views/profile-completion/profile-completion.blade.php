
@extends('layouts.main')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="javascript:;">Profile Completion</a>
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
							<span class="caption-subject bold uppercase">User Profile Completion</span>
						</div>
					</div>
					<div class="portlet-body">

						<form role="form" class="form-horizontal" action="{{url('setting/complete-profile')}}" method="POST">
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">Completion {{env('POINT_NAME', 'Points')}}
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="{{env('POINT_NAME', 'Points')}} yang diperoleh user ketika melengkapi data profil" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-4">
										<input class="form-control" type="text" name="complete_profile_cashback" value="{{ old('complete_profile_cashback',$complete_profile['complete_profile_cashback']??'') }}" required>
									</div>
								</div>
							</div>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<button type="submit" class="btn blue">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>
@endsection