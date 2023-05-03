<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$idUserFrenchisee = session('id_user_franchise');
?>
@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.custom-card-caption {
			margin-bottom: 12px;
			font-size: 18px;
		}
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

	<script>
		$(document).ready(function () {
			datatables();

			$("#date_end").datepicker({
				dateFormat: 'dd-mm-yy',
			});
			$("#date_start").datepicker({
				dateFormat: 'dd-mm-yy',
			});
		});

		function datatables(){
			$("#tbodyListCalculation").empty();
			var data_display = 25;
			var token  = "{{ csrf_token() }}";
			@if(is_null($idUserFrenchisee))
			    var url = "{{url('disburse/list-datatable/calculation')}}";
			@else
				var url = "{{url('disburse/user-franchise/list-datatable/calculation')}}";
			@endif

			var dt = 0;
			var tab = $.fn.dataTable.isDataTable( '#tableListCalculation' );
			if(tab){
				$('#tableListCalculation').DataTable().destroy();
			}

			var outlet = $("#fitler_outlet").val();
			var fitler_date = $("#fitler_date").val();
			var start_date = $("#date_start").val();
			var end_date = $("#date_end").val();
			var data = {
				_token : token,
				id_outlet : outlet,
				fitler_date : fitler_date,
				start_date : start_date,
				end_date : end_date
			};

			$('#tableListCalculation').DataTable( {
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": false,
				"bSort": false,
				"bInfo": true,
				"iDisplayLength": data_display,
				"bProcessing": true,
				"serverSide": true,
				"searching": false,
				"ajax": {
					url : url,
					dataType: "json",
					type: "POST",
					data: data,
					"dataSrc": function (json) {
						return json.data;
					}
				},
				columnDefs: [
					{
						targets: 0,
						render: function ( data, type, row, meta ) {
							var color = '#bfbfbf';
							if(data === 'Fail'){
								color = '#f54842';
							}else if(data === 'Success'){
								color = '#26C281';
							}

							var status = data;
							if(data == null){
								status = 'Unprocessed';
							}
							var html = '<span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: '+color+';padding: 5px 12px;color: #fff;">'+status+'</span>';
							return html;
						}
					}
				]
			});
		}

		function dataDashboard(){
			var token  = "{{ csrf_token() }}";
			@if(is_null($idUserFrenchisee))
			var url = "{{url('disburse/dashboard')}}";
			@else
			var url = "{{url('disburse/user-franchise/dashboard')}}";
			@endif
			var outlet = $("#fitler_outlet").val();
			var fitler_date = $("#fitler_date").val();
			var start_date = $("#date_start").val();
			var end_date = $("#date_end").val();
			var data = {
				_token : token,
				id_outlet : outlet,
				fitler_date : fitler_date,
				start_date : start_date,
				end_date : end_date
			};

			$.ajax({
				type : "POST",
				url : url,
				data : data,
				success : function(result) {
					$("#pending_nom_success, #pending_nom_fail, #pending_nom_trx, #pending_nom_income, #pending_nom_item, #pending_nom_delivery, #pending_nom_expense_central, #pending_nom_disburse").empty();
					$("#processed_nom_success, #processed_nom_fail, #processed_nom_trx, #processed_nom_income, #processed_nom_item, #processed_nom_delivery, #processed_nom_expense_central, #processed_nom_disburse").empty();

					if (result.status === "success") {
						$("#pending_nom_success").append('<span data-counter="counterup" data-value="'+result.pending.nominal_success+'" style="font-size: 22px">Rp '+result.pending.format_nominal_success+'</span>');
						$("#pending_nom_fail").append('<span data-counter="counterup" data-value="'+result.pending.nominal_fail+'" style="font-size: 22px">Rp '+result.pending.format_nominal_fail+'</span>');
						$("#pending_nom_trx").append('<span data-counter="counterup" data-value="'+result.pending.nominal_grandtotal+'" style="font-size: 22px">Rp '+result.pending.format_nominal_grandtotal+'</span>');
						$("#pending_nom_income").append('<span data-counter="counterup" data-value="'+result.pending.total_income_central+'" style="font-size: 22px">Rp '+result.pending.format_total_income_central+'</span>');

						$("#pending_nom_item").append('<span data-counter="counterup" data-value="'+result.pending.nominal_item+'" style="font-size: 22px">Rp '+result.pending.format_nominal_item+'</span>');
						$("#pending_nom_delivery").append('<span data-counter="counterup" data-value="'+result.pending.nominal_delivery+'" style="font-size: 22px">Rp '+result.pending.format_nominal_delivery+'</span>');
						$("#pending_nom_expense_central").append('<span data-counter="counterup" data-value="'+result.pending.nominal_expense_central+'" style="font-size: 22px">Rp '+result.pending.format_nominal_expense_central+'</span>');
						$("#pending_nom_disburse").append('<span data-counter="counterup" data-value="'+result.pending.total_disburse+'" style="font-size: 22px">Rp '+result.pending.format_total_disburse+'</span>');

						$("#processed_nom_success").append('<span data-counter="counterup" data-value="'+result.processed.nominal_success+'" style="font-size: 22px">Rp '+result.processed.format_nominal_success+'</span>');
						$("#processed_nom_fail").append('<span data-counter="counterup" data-value="'+result.processed.nominal_fail+'" style="font-size: 22px">Rp '+result.processed.format_nominal_fail+'</span>');
						$("#processed_nom_trx").append('<span data-counter="counterup" data-value="'+result.processed.nominal_grandtotal+'" style="font-size: 22px">Rp '+result.processed.format_nominal_grandtotal+'</span>');
						$("#processed_nom_income").append('<span data-counter="counterup" data-value="'+result.processed.total_income_central+'" style="font-size: 22px">Rp '+result.processed.format_total_income_central+'</span>');

						$("#processed_nom_item").append('<span data-counter="counterup" data-value="'+result.processed.nominal_item+'" style="font-size: 22px">Rp '+result.processed.format_nominal_item+'</span>');
						$("#processed_nom_delivery").append('<span data-counter="counterup" data-value="'+result.processed.nominal_delivery+'" style="font-size: 22px">Rp '+result.processed.format_nominal_delivery+'</span>');
						$("#processed_nom_expense_central").append('<span data-counter="counterup" data-value="'+result.processed.nominal_expense_central+'" style="font-size: 22px">Rp '+result.processed.format_nominal_expense_central+'</span>');
						$("#processed_nom_disburse").append('<span data-counter="counterup" data-value="'+result.processed.total_disburse+'" style="font-size: 22px">Rp '+result.processed.format_total_disburse+'</span>');

					}else{
						let append_zero_currency = '<span data-counter="counterup" data-value="0" style="font-size: 22px">Rp 0</span>';
						let append_zero = '<span data-counter="counterup" data-value="0" style="font-size: 22px">0</span>';
						$("#pending_nom_success, #pending_nom_fail, #pending_nom_trx, #pending_nom_income, #pending_nom_item, #pending_nom_delivery, #pending_nom_expense_central").append(append_currency);
						$("#pending_nom_disburse").append(append_zero);
						$("#processed_nom_success, #processed_nom_fail, #processed_nom_trx, #processed_nom_income, #processed_nom_item, #processed_nom_delivery, #processed_nom_expense_central").append(append_currency);
						$("#processed_nom_disburse").append(append_zero);
					}
				},
				error: function (jqXHR, exception) {
					toastr.warning('Failed get data dashboard');
				}
			});
		}

		$('#fitler_date').change(function(){
			var value_date = $("#fitler_date").val();
			if(value_date === 'specific_date'){
				document.getElementById('div_specific_date').style.display = 'block';
			}else{
				document.getElementById('div_specific_date').style.display = 'none';
			}
		});
		
		function search() {
			datatables();
			dataDashboard();
		}
	</script>
@endsection

@extends(($idUserFrenchisee == NULL ? 'layouts.main' : 'disburse::layouts.main'))

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

	<h1 class="page-title" style="margin-top: 0px;">
		{{$sub_title}}
	</h1>
	@include('layouts.notifications')
	<div class="row">
		<div class="col-md-4">
			<select id="fitler_outlet" class="form-control select2" name="brand" style="width: 100%">
				<option value="all" selected>All Outlet</option>
				@foreach($outlets as $val)
					<option value="{{$val['id_outlet']}}">{{$val['outlet_code']}} - {{$val['outlet_name']}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-4">
			<select id="fitler_date" class="form-control select2" name="brand" style="width: 100%">
				<option value="all" selected>All Date</option>
				<option value="today">Today</option>
				<option value="specific_date">Specific Date</option>
			</select>
		</div>
		<div class="col-md-4" style="margin-top: 0.3%">
			<button class="btn btn-sm btn-primary" onclick="search()">Search</button>
		</div>
	</div>

	<div class="row" style="margin-top: 1%;display: none" id="div_specific_date">
		<div class="col-md-4">
			<div class="input-group">
				<input type="text" class="form-control form-control-inline date-picker" name="date_start" id="date_start" data-date-format="dd-mm-yyyy" value="@if(isset($date_start)) {{$date_start}} @else {{date('d-m-Y', strtotime(date('d-m-Y'). ' - 1 days'))}} @endif" readonly>
				<span class="input-group-btn">
					<button class="btn default" type="button">
						<i class="fa fa-calendar"></i>
					</button>
				</span>
			</div>
		</div>
		<div class="col-md-4">
			<div class="input-group">
				<input type="text" class="form-control form-control-inline date-picker" name="date_end"  id="date_end"  data-date-format="dd-mm-yyyy" value="@if(isset($date_end)) {{$date_end}} @else {{date('d-m-Y', strtotime(date('d-m-Y'). ' - 1 days'))}} @endif" readonly>
				<span class="input-group-btn">
					<button class="btn default" type="button">
						<i class="fa fa-calendar"></i>
					</button>
				</span>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 3%;">
		<div class="col-md-12 custom-card-caption">
			<span class="caption-subject font-blue sbold uppercase">Pending Disburse</span>
		</div>
		
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 green" target="_blank" href="{{url('disburse/list/all')}}">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number" id="pending_nom_disburse">
						<span data-counter="counterup" data-value="{{$pending['total_disburse']}}" style="font-size: 22px">Rp {{number_format($pending['total_disburse'], 2)}}</span>
					</div>
					<div class="desc"> Total Disburse</div>
				</div>
			</a>
		</div>
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 green-seagreen" target="_blank" href="{{url('disburse/list/success')}}">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number" id="pending_nom_item">
						<span data-counter="counterup" data-value="{{$pending['nominal_item']}}" style="font-size: 22px">Rp {{number_format($pending['nominal_item'], 2)}}</span>
					</div>
					<div class="desc"> Total Fee Item (Subtotal)</div>
				</div>
			</a>
		</div>
		@if(MyHelper::hasAccess([235], $grantedFeature))
			<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
				<a class="dashboard-stat dashboard-stat-v2 purple" target="_blank" href="{{url('disburse/list/all')}}">
					<div class="visual">
						<i class="fa fa-shopping-cart"></i>
					</div>
					<div class="details">
						<div class="number" id="pending_nom_income">
							<span data-counter="counterup" data-value="{{$pending['total_income_central']}}" style="font-size: 22px">Rp {{number_format($pending['total_income_central'], 2)}}</span>
						</div>
						<div class="desc"> Income Central </div>
					</div>
				</a>
			</div>
		@endif
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 yellow-crusta" target="_blank" href="{{url('disburse/list/success')}}">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number" id="pending_nom_expense_central">
						<span data-counter="counterup" data-value="{{$pending['nominal_expense_central']}}" style="font-size: 22px">Rp {{number_format($pending['nominal_expense_central'], 2)}}</span>
					</div>
					<div class="desc"> Total Expense Central </div>
				</div>
			</a>
		</div>
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 blue" target="_blank" href="{{url('disburse/list/trx')}}">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number" id="pending_nom_trx">
						<span data-counter="counterup" data-value="{{$pending['nominal_grandtotal']}}" style="font-size: 22px">Rp {{number_format($pending['nominal_grandtotal'], 2)}}</span>
					</div>
					<div class="desc"> Grand Total </div>
				</div>
			</a>
		</div>
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 green-jungle" target="_blank" href="{{url('disburse/list/success')}}">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number" id="pending_nom_delivery">
						<span data-counter="counterup" data-value="{{$pending['nominal_delivery']}}" style="font-size: 22px">Rp {{number_format($pending['nominal_delivery'], 2)}}</span>
					</div>
					<div class="desc"> Total Delivery </div>
				</div>
			</a>
		</div>
		{{-- <div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 green" target="_blank" href="{{url('disburse/list/success')}}">
				<div class="visual">
					<i class="fa fa-shopping-cart"></i>
				</div>
				<div class="details">
					<div class="number" id="pending_nom_success">
						<span data-counter="counterup" data-value="{{$pending['nominal_success']}}" style="font-size: 22px">Rp {{number_format($pending['nominal_success'], 2)}}</span>
					</div>
					<div class="desc"> Total Success Disburse</div>
				</div>
			</a>
		</div>
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 red" target="_blank" href="{{url('disburse/list/fail-action')}}">
				<div class="visual">
					<i class="fa fa-bar-chart-o"></i>
				</div>
				<div class="details">
					<div class="number" id="pending_nom_fail">
						<span data-counter="counterup" data-value="{{pending['$nominal_fail']}}" style="font-size: 22px">Rp {{number_format($pending['nominal_fail'], 2)}}</span>
					</div>
					<div class="desc"> Total Failed Disburse</div>
				</div>
			</a>
		</div> --}}
	</div>

	<div class="row" style="margin-top: 3%;">
		<div class="col-md-12 custom-card-caption">
			<span class="caption-subject font-blue sbold uppercase">Processed Disburse</span>
		</div>
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 green" target="_blank" href="{{url('disburse/list/success')}}">
				<div class="visual">
					<i class="fa fa-shopping-cart"></i>
				</div>
				<div class="details">
					<div class="number" id="processed_nom_success">
						<span data-counter="counterup" data-value="{{$processed['nominal_success']}}" style="font-size: 22px">Rp {{number_format($processed['nominal_success'], 2)}}</span>
					</div>
					<div class="desc"> Total Success Disburse</div>
				</div>
			</a>
		</div>
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 red" target="_blank" href="{{url('disburse/list/fail-action')}}">
				<div class="visual">
					<i class="fa fa-bar-chart-o"></i>
				</div>
				<div class="details">
					<div class="number" id="processed_nom_fail">
						<span data-counter="counterup" data-value="{{$processed['nominal_fail']}}" style="font-size: 22px">Rp {{number_format($processed['nominal_fail'], 2)}}</span>
					</div>
					<div class="desc"> Total Failed Disburse</div>
				</div>
			</a>
		</div>
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 green-seagreen" target="_blank" href="{{url('disburse/list/success')}}">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number" id="processed_nom_item">
						<span data-counter="counterup" data-value="{{$processed['nominal_item']}}" style="font-size: 22px">Rp {{number_format($processed['nominal_item'], 2)}}</span>
					</div>
					<div class="desc"> Total Fee Item (Subtotal)</div>
				</div>
			</a>
		</div>
		@if(MyHelper::hasAccess([235], $grantedFeature))
			<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
				<a class="dashboard-stat dashboard-stat-v2 purple" target="_blank" href="{{url('disburse/list/all')}}">
					<div class="visual">
						<i class="fa fa-shopping-cart"></i>
					</div>
					<div class="details">
						<div class="number" id="processed_nom_income">
							<span data-counter="counterup" data-value="{{$processed['total_income_central']}}" style="font-size: 22px">Rp {{number_format($processed['total_income_central'], 2)}}</span>
						</div>
						<div class="desc"> Income Central </div>
					</div>
				</a>
			</div>
		@endif
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 yellow-crusta" target="_blank" href="{{url('disburse/list/success')}}">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number" id="processed_nom_expense_central">
						<span data-counter="counterup" data-value="{{$processed['nominal_expense_central']}}" style="font-size: 22px">Rp {{number_format($processed['nominal_expense_central'], 2)}}</span>
					</div>
					<div class="desc"> Total Expense Central </div>
				</div>
			</a>
		</div>
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 blue" target="_blank" href="{{url('disburse/list/trx')}}">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number" id="processed_nom_trx">
						<span data-counter="counterup" data-value="{{$processed['nominal_grandtotal']}}" style="font-size: 22px">Rp {{number_format($processed['nominal_grandtotal'], 2)}}</span>
					</div>
					<div class="desc"> Grand Total </div>
				</div>
			</a>
		</div>
		<div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 green-jungle" target="_blank" href="{{url('disburse/list/success')}}">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number" id="processed_nom_delivery">
						<span data-counter="counterup" data-value="{{$processed['nominal_delivery']}}" style="font-size: 22px">Rp {{number_format($processed['nominal_delivery'], 2)}}</span>
					</div>
					<div class="desc"> Total Delivery </div>
				</div>
			</a>
		</div>
		{{-- <div class="@if(MyHelper::hasAccess([235], $grantedFeature))col-lg-3 @else col-lg-4 @endif col-md-4 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 green" target="_blank" href="{{url('disburse/list/all')}}">
				<div class="visual">
					<i class="fa fa-comments"></i>
				</div>
				<div class="details">
					<div class="number" id="processed_nom_disburse">
						<span data-counter="counterup" data-value="{{$processed['total_disburse']}}" style="font-size: 22px">Rp {{number_format($processed['total_disburse'], 2)}}</span>
					</div>
					<div class="desc"> Total Disburse</div>
				</div>
			</a>
		</div> --}}
	</div>

	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject font-red sbold uppercase">List Calculation Transaction</span>
			</div>
		</div>
		<div class="portlet-body form">
			<table class="table table-striped table-bordered table-hover" id="tableListCalculation">
				<thead>
				<tr>
					<th scope="col" width="25%"> Status Disburse </th>
					<th scope="col" width="30%"> Outlet </th>
					<th scope="col" width="30%"> Disburse Date </th>
					<th scope="col" width="30%"> Transaction Date </th>
					<th scope="col" width="25%"> Receipt Number </th>
					<th scope="col" width="25%"> Gross Sales </th>
					<th scope="col" width="25%"> Discount </th>
					<th scope="col" width="25%"> Delivery </th>
					<th scope="col" width="25%"> Sub Total </th>
					<th scope="col" width="25%"> Fee Item </th>
					<th scope="col" width="25%"> Fee Payment </th>
					<th scope="col" width="25%"> Fee Promo </th>
					<th scope="col" width="25%"> Fee Subscription </th>
					<th scope="col" width="25%"> Fee Point Use </th>
					<th scope="col" width="25%"> Net Sale (Income Outlet) </th>
					<th scope="col" width="25%"> Income Central </th>
					<th scope="col" width="25%"> Expense Central </th>
				</tr>
				</thead>
				<tbody id="tbodyListCalculation"></tbody>
			</table>
		</div>
	</div>
@endsection