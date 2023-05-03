<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');

?>
@extends('layouts.main')

@include('list_filter')
@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	@yield('filter_script')
	<script type="text/javascript">
		rules = {
			all_product:{
				display:'All Product',
				operator:[],
				opsi:[]
			},
			product_code :{
				display:'Code',
				operator:[
					['=','='],
					['like','like']
				],
				opsi:[]
			},
			product_name :{
				display:'Name',
				operator:[
					['=','='],
					['like','like']
				],
				opsi:[]
			}
		};
		$(document).on('click', '.same', function() {
			var id = this.id;
			var code = id.split("-");
			code = code[1];
			var total_use = $('#total-use-current-'+code).val();

			if (total_use == '') {
				alert('Use plastic cannot be empty');
				return false;
			}

			if ($('.checkbox-all').is(':checked')) {
				$('.total-use-current').each(function(i, obj) {
					$('#'+this.id).val(total_use);
				});
			} else {
				$('.total-use-old').each(function(i, obj) {
					var id_old = this.id;
					var code_old = id_old.split("-");
					code_old = code_old[3];
					var value = $('#total-use-old-'+code_old).val();
					$('#total-use-current-'+code_old).val(value);
				});
			}
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

	@yield('filter_view')

	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject sbold uppercase font-blue">Use Plastic Product</span>
			</div>
		</div>
		<div class="portlet-body form">
			<form id="form-prices" action="{{url()->current()}}" method="POST">
				<div class="table-scrollable">
					<table class="table table-striped table-bordered table-hover table-responsive">
						<thead>
						<tr>
							<th> Product </th>
							<th> Total Used Plastic </th>
							<th> Checkbox</th>
						</tr>
						</thead>
						<tbody>
						@if (!empty($product))
							@foreach ($product as $col => $pro)
								<tr>
									<td> {{ $pro['product_code'] }} - {{ $pro['product_name'] }} </td>
									<td style="width:15%">
										<input type="text" class="form-control total-use-current" name="total_use_plastic[]" id="total-use-current-{{$pro['product_code']}}" value="{{$pro['total_use_plastic']}}">
										<input type="hidden" value="{{$pro['total_use_plastic']}}" id="total-use-old-{{$pro['product_code']}}" class="total-use-old">
									</td>
									<td width="25%">
										<div style="width:40%;display:inline-block;vertical-align: text-top;">
											<label class="mt-checkbox mt-checkbox-outline"> Same for all product
												<input type="checkbox" name="sameall[]" class="same checkbox-all" data-check="ampas" id="sameall-{{ $pro['product_code'] }}"/>
												<span></span>
											</label>
										</div>
									</td>
								</tr>
								<input type="hidden" name="id_product[]" value="{{ $pro['id_product'] }}">
							@endforeach
						@else
							<tr style="text-align: center"><td colspan="4">Data Not Available</td></tr>
						@endif
						</tbody>
					</table>
				</div>
				<div class="form-actions">
					{{ csrf_field() }}
					<div class="row">
						@if (isset($paginator) && $paginator)
							<div class="col-md-10">
								{{ $paginator->links() }}
							</div>
						@endif
						<div class="col-md-2">
							<button type="submit" class="btn blue pull-right" style="margin:10px 0">Save</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection