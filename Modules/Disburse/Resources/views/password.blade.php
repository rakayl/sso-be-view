@extends('disburse::layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script>

	function checkPassword() {
		var pin = $('input[name=pin]').val();
		var re_pin = $('input[name=re_pin]').val();
		var current_pin = $('input[name=current_pin]').val();

		if(pin !== re_pin){
			confirm("Your pin doesn't match");
		}else{
			if(current_pin === pin){
				confirm("New Pin and Current Pin can not same");
			}else{
				var obj = document.form_input;
				obj.action = "{{url('disburse/user-franchise/reset-password')}}";
				obj.submit();
			}
		}

	}
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
	<div class="col-md-8">
		<div class="portlet light bordered" >
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-red sbold uppercase"><i class="fa fa-list"></i> Reset PIN</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form class="form-horizontal form-bordered" name="form_input" action="">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-4">Current PIN</label>
							<div class="col-md-8">
								<input type="password" name="current_pin" maxlength="6" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">New PIN (6 digit)</label>
							<div class="col-md-8">
								<input type="password" name="pin" maxlength="6" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Re-input PIN (6 digit)</label>
							<div class="col-md-8">
								<input type="password" name="re_pin" maxlength="6" class="form-control" />
							</div>
						</div>
					</div>
				</form>
				<div style="margin-top: 2%;text-align: center">
					<button class="green btn" onclick="checkPassword()">Submit</button>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection