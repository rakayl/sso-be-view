<?php
    use App\Lib\MyHelper;
	$configs    		= session('configs');
 ?>
 @extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.css?x=1') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-typeahead.min.js') }}" type="text/javascript"></script>

	<script>
		jQuery(document).ready(function($) {
		   var user;
		   $('#select2User').select2({
			   ajax: {
				   url: "{{url('outlet/getuser')}}",
				   data: function (params) {
					   return {
						   q: params.term, // search term
						   page: params.page
					   };
				   },
				   processResults: function (data) {
					   console.log(data)
				   user = data
				   return {
					   results: $.map(data, function (item, i) {
							   return {
								   text: item.name+' - '+item.phone+' - '+item.email,
								   id: item.id,
								   name: item.name,
								   email: item.email,
								   phone: item.phone,
							   }
						   })
					   };
				   }
			   }
		   });

		   $('#chooseUser').hide()
	   });

	   var data;
	   $('input[type=radio][name=user]').change(function(){
		   var user = $(this).val();
		   if(user == 'exist'){
				$('#select2User').prop('required',true);
				$('#chooseUser').show()
				if(data != null){
					$('input[name=name]').val(data.name)
					$('input[name=email]').val(data.email)
					$('input[name=phone]').val(data.phone)
				}
		   }else if(user == 'new'){
				$('#chooseUser').hide()
				$('#select2User').prop('required',false);
				$('input[name=name]').val('')
				$('input[name=email]').val('')
				$('input[name=phone]').val('')
		   }
	   })

	   $('#select2User').on('select2:select', function (e) {
		   data = e.params.data;
		   $('input[name=name]').val(data.name)
		   $('input[name=email]').val(data.email)
		   $('input[name=phone]').val(data.phone)
	   });
   </script>
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
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">New Admin Outlet</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Outlet
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Outlet penempatan admin" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="id_outlet[]" class="form-control input-sm select2-multiple" multiple data-placeholder="Select Outlet" required>
									@foreach($outlets as $outlet)
										<option value="{{$outlet['id_outlet']}}">{{$outlet['outlet_name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">User</label>
							<div class="col-md-9">
								<div class="md-radio-inline">
									<div class="md-radio">
										<input type="radio" id="radio1" name="user" class="md-radiobtn" value="exist">
										<label for="radio1">
											<span></span>
											<span class="check"></span>
											<span class="box"></span> From existing user
										</label>
									</div>
									<div class="md-radio">
										<input type="radio" id="radio2" name="user" class="md-radiobtn" value="new" checked>
										<label for="radio2">
											<span></span>
											<span class="check"></span>
											<span class="box"></span> New user
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" id="chooseUser">
							<label class="control-label col-md-3">Choose User</label>
							<div class="col-md-9">
								<select id="select2User" name="id_user" class="form-control input-sm select2">
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Phone
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon admin" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="phone" placeholder="Phone Number (Required & Unique)" class="form-control" value="{{old('phone')}}" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Name
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Nama admin" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="name" placeholder="User Name (Required)" class="form-control" value="{{old('name')}}" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Email
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Email admin, contoh: andi@mail.com" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="email" placeholder="Email (Required & Unique)" class="form-control" value="{{old('email')}}" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Type
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Fitur yang dapat diakses oleh admin, bisa lebih dari satu" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="type[]" class="form-control input-sm select2-multiple" multiple data-placeholder="Select at Least 1 Type (Required)" required>
									{{-- cek config enquiry dulu baru admin enquiry --}}
									@if(MyHelper::hasAccess([56], $configs))
										@if(MyHelper::hasAccess([9], $configs))
											<option @if(old('type') == 'enquiry') selected @endif value="enquiry">Enquiry</option>
										@endif
									@endif

									{{-- cek config pickup order dulu baru admin pickup --}}
									@if(MyHelper::hasAccess([12], $configs))
										@if(MyHelper::hasAccess([6], $configs))
											<option @if(old('type') == 'pickup_order') selected @endif value="pickup_order">Pickup Order</option>
										@endif
									@endif

									{{-- cek config delivery order dulu baru admin delivery --}}
									@if(MyHelper::hasAccess([13,15], $configs))
										@if(MyHelper::hasAccess([7], $configs))
											<option @if(old('type') == 'delivery') selected @endif value="delivery">Delivery</option>
										@endif
									@endif

									{{-- cek config manual payment dulu baru admin finance --}}
									@if(MyHelper::hasAccess([17], $configs))
										@if(MyHelper::hasAccess([8], $configs))
											<option @if(old('type') == 'payment') selected @endif value="payment">Payment</option>
										@endif
									@endif
									
									{{-- cek config outlet apps --}}
									@if(MyHelper::hasAccess([101], $configs))
										<option @if(old('type') == 'outlet_apps') selected @endif value="outlet_apps">Outlet Apps</option>
									@endif
								</select>
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center;">
						<input hidden name="level" value="Admin Outlet">
						{{ csrf_field() }}
						<button type="submit" class="btn blue">Create</button>
						<a href="{{url()->previous().'#admin'}}" class="btn default">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection