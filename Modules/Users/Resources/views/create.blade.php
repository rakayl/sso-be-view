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
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script>
		$('.onlynumber').keypress(function (e) {
			var regex = new RegExp("^[0-9]");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

			var check_browser = navigator.userAgent.search("Firefox");

			if(check_browser == -1){
				if (regex.test(str) || e.which == 8) {
					return true;
				}
			}else{
				if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
					return true;
				}
			}

			e.preventDefault();
			return false;
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
			<a href="{{url('/user')}}">User</a>
            <i class="fa fa-circle"></i>
		</li>
		<li class="active"><a href="{{url('/user/create')}}">New User</a></li>
	</ul>
</div>
@include('layouts.notifications')
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">New User Account</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url('user/create')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Name
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="name" placeholder="User Name (Required)" class="form-control" required value="{{old('name')}}"/>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Email
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Email user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="email" placeholder="Email (Required & Unique)" class="form-control" required autocomplete="new-password" value="{{old('email')}}"/>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Phone
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon seluler" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="phone" maxlength="20" placeholder="Phone Number (Required & Unique)" class="form-control onlynumber" required autocomplete="new-password" value="{{old('phone')}}"/>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
									Password
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Password terdiri dari minimal 8 digit karakter, wajib mengandung huruf dan angka" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="password" name="pin" placeholder="Minimum 8 digits karakter (Leave empty to autogenerate)" minlength="8" class="form-control mask_number" autocomplete="new-password" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Sent Password to User?
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Pilih apakah akan mengirimkan password ke user (Yes/No)" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="sent_pin" class="form-control input-sm select2" data-placeholder="Yes / No" required>
									<option value="">Select...</option>
									<option value="Yes" @if(old('sent_pin') == 'Yes') selected @endif>Yes</option>
									<option value="No" @if(old('sent_pin') == 'No') selected @endif>No</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Birthday
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal lahir user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy-mm-dd">
									<input type="text" class="form-control form-filter input-sm date-picker" name="birthday" placeholder="Birthday Date" required>
									<span class="input-group-btn">
										<button class="btn btn-sm default" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Gender
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Jenis kelamin user (laki-laki/perempuan)" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="gender" class="form-control input-sm select2" data-placeholder="Male / Female" required>
									<option value="">Select...</option>
									<option value="Male" @if(old('gender') == 'Male') selected @endif>Male</option>
									<option value="Female" @if(old('gender') == 'Female') selected @endif>Female</option>
								</select>
							</div>
						</div>
    <!--						<div class="form-group">
                                                            <div class="input-icon right">
                                                                <label class="col-md-3 control-label">
                                                                Celebrate
    {{--							    <span class="required" aria-required="true"> * </span>--}}
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                    <select name="celebrate" class="form-control input-sm select2" placeholder="Search Celebrate" data-placeholder="Choose Users Celebrate">
                                                                            <option value="">Select...</option>
                                                                            @if(isset($celebrate))
                                                                                    @foreach($celebrate as $row)
                                                                                            <option value="{{$row}}" @if(old('celebrate') == $row) selected @endif>{{$row}}</option>
                                                                                    @endforeach
                                                                            @endif
                                                                    </select>
                                                            </div>
                                                    </div>-->
<!--						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Work
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="job" class="form-control input-sm select2" placeholder="Search Work" data-placeholder="Choose Users Work" required>
									<option value="">Select...</option>
									@if(isset($job))
										@foreach($job as $row)
											<option value="{{$row}}" @if(old('job') == $row) selected @endif>{{$row}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>-->
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Province
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="id_province" class="form-control input-sm select2" placeholder="Search Province" data-placeholder="Choose Users Province" required>
									<option value="">Select...</option>
									@if(isset($province))
										@foreach($province as $row)
											<option value="{{$row['id_province']}}" @if(old('id_province') == $row['id_province']) selected @endif>{{$row['province_name']}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    City
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="id_city" class="form-control input-sm select2" placeholder="Search City" data-placeholder="Choose Users City" required>
									<option value="">Select...</option>
									@if(isset($city))
										@foreach($city as $row)
											<option value="{{$row['id_city']}}" @if(old('id_city') == $row['id_city']) selected @endif>{{$row['city_name']}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Address
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<textarea type="text" name="address" placeholder="Input your address here..." class="form-control">{{old('address')}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Level
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Hak akses yang diberikan ke user (admin/ customer)" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="level" class="form-control input-sm select2">
									<option value="Mitra" @if(old('level') == 'Mitra') selected @endif>Mitra</option>
									<option value="Customer" @if(old('level') == 'Customer' || empty(old('level'))) selected @endif>Customer</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
