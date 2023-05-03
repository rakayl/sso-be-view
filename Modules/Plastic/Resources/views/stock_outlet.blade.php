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
	<script type="text/javascript">
		$('#outlet_selector').on('change',function(){
			window.location.href = "{{url('product-plastic/stock-outlet')}}/"+$(this).val();
		});
		$(document).on('click', '.same', function() {
			var id = this.id;
			var code = id.split("-");
			code = code[1];
			var stock = $('#product-stock-'+code).val();

			if (stock == '') {
				alert('Stock field cannot be empty');
				return false;
			}

			if ($('.checkbox-outlet').is(':checked')) {
				var count = $('.checkbox-outlet').prop('checked', false);
				$(this).prop('checked', true);

				var all_stock = $('.product-stock-value');
				var array_stock = [];
				for (i = 0; i < all_stock.length; i++) {
					array_stock.push(all_stock[i]['defaultValue']);
				}
				sessionStorage.setItem("product_stock", array_stock);
				$('.product-stock').val(stock);

			} else {

				var item_stock = sessionStorage.getItem("product_stock");
				var item_stock = item_stock.split(",");
				$('.product-stock').each(function(i, obj) {
					$(this).val(item_stock[i]);
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

	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject sbold uppercase font-blue">List Product Plastic</span>
			</div>
			<div class="actions">
				<div class="btn-group" style="width: 300px">
					<select class="form-control select2" name="id_outlet" id="outlet_selector" data-placeholder="select outlet">
						@foreach($outlets as $outlet)
							<option value="{{ $outlet['id_outlet'] }}" @if ($outlet['id_outlet'] == $key) selected @endif>{{ $outlet['outlet_code'] }} - {{ $outlet['outlet_name'] }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="portlet-body form">
			<form id="form-prices" action="{{url()->current()}}" method="POST">
				<div class="table-scrollable">
					<table class="table table-striped table-bordered table-hover table-responsive">
						<thead>
						<tr>
							<th> Plastic Type </th>
							<th> Product </th>
							<th> Stock </th>
							<th> Checkbox</th>
						</tr>
						</thead>
						<tbody>
						@if (!empty($product))
							@foreach ($product as $col => $pro)
								<tr>
									<td> {{$pro['plastic_type_name']}} </td>
									<td> {{ $pro['product_code'] }} - {{ $pro['product_name'] }} </td>
									<td style="width:15%">
										<select class="form-control product-stock" name="product_stock_status[]" id="product-stock-{{ $pro['product_code'] }}">
											<option value="Available" @if($pro['product_stock_status'] == 'Available') selected @endif>Available</option>
											<option value="Sold Out" @if($pro['product_stock_status'] == 'Sold Out') selected @endif>Sold Out</option>
										</select>
										<input type="hidden" value="{{$pro['product_stock_status']}}" class="product-stock-value">
									</td>
									<td width="25%">
										<div style="width:40%;display:inline-block;vertical-align: text-top;">
											<label class="mt-checkbox mt-checkbox-outline"> Same for all product
												<input type="checkbox" name="sameall[]" class="same checkbox-outlet" data-check="ampas" id="sameall-{{ $pro['product_code'] }}"/>
												<span></span>
											</label>
										</div>
									</td>
								</tr>
								<input type="hidden" name="id_product[]" value="{{ $pro['id_product'] }}">
								<input type="hidden" name="id_outlet" value="{{ $key }}">
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