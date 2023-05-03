<?php
    use App\Lib\MyHelper;
	$grantedFeature     = session('granted_features');
	$configs    		= session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
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
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">Edit Admin Outlet</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="form-group">
							<div class="input-icon right">
								<label class="control-label col-md-3">
									Name
									<i class="fa fa-question-circle tooltips" data-original-title="nama admin" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
                                <input type="text" name="name" placeholder="User Name (Required)" value="@if(old('name')){{old('name')}} @else {{$user_outlet['name']}} @endif" class="form-control" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
								<label class="control-label col-md-3">
									Phone
									<i class="fa fa-question-circle tooltips" data-original-title="nomor telepon admin" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
								<input type="text" name="phone" placeholder="Phone Number (Required & Unique)" value="@if(old('phone')){{old('phone')}} @else {{$user_outlet['phone']}} @endif" class="form-control" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
								<label class="control-label col-md-3">
									Email
									<i class="fa fa-question-circle tooltips" data-original-title="email admin, contoh: andi@mail.com" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
								<input type="email" name="email" placeholder="Email (Required & Unique)" value="@if(old('email')){{old('email')}} @else {{$user_outlet['email']}} @endif" class="form-control" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
								<label class="control-label col-md-3">
									Type
									<i class="fa fa-question-circle tooltips" data-original-title="fitur yang dapat diakses oleh admin, bisa lebih dari satu" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
								<select name="type[]" class="form-control input-sm select2-multiple" multiple data-placeholder="Select at Least 1 Type (Required)" required>
									{{-- cek config enquiry dulu baru cek admin enquiry--}}
									@if(MyHelper::hasAccess([56], $configs))
										@if(MyHelper::hasAccess([9], $configs))
											<option @if($user_outlet['enquiry'] == "1") selected @endif value="enquiry">Enquiry</option>
										@endif
									@endif
									{{-- cek config pickup order dulu baru cek admin pickup--}}
									@if(MyHelper::hasAccess([12], $configs))
										@if(MyHelper::hasAccess([6], $configs))
											<option @if($user_outlet['pickup_order'] == "1") selected @endif value="pickup_order">Pickup Order</option>
										@endif
									@endif
									{{-- cek config delivery order dulu baru cek admin delivery --}}
									@if(MyHelper::hasAccess([13,15], $configs))
										@if(MyHelper::hasAccess([7], $configs))
											<option @if($user_outlet['delivery'] == "1") selected @endif value="delivery">Delivery</option>
										@endif
									@endif
									{{-- cek config manual payment dulu baru cek admin finance --}}
									@if(MyHelper::hasAccess([17], $configs))
										@if(MyHelper::hasAccess([8], $configs))
											<option @if($user_outlet['payment'] == "1") selected @endif value="delivery">Payment</option>
										@endif
									@endif

									{{-- cek config outlet apps --}}
									@if(MyHelper::hasAccess([101], $configs))
										<option @if($user_outlet['outlet_apps'] == "1") selected @endif value="outlet_apps">Outlet Apps</option>
									@endif
								</select>
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<input hidden name="id_user_outlet" value="{{$user_outlet['id_user_outlet']}}">
						@if(MyHelper::hasAccess([41], $grantedFeature))
							<button type="submit" class="btn blue">Update</button>
						@endif
						<a href="{{url()->previous().'#admin'}}" class="btn default">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection