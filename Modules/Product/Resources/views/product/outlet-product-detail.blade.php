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
			},
			product_visibility :{
				display:'Default Visibility',
				operator:[],
				opsi:[
					['Visible','Visible'],
					['Hidden', 'Hidden']
				]
			},
		};
		$('.price').inputmask("numeric", {
			radixPoint: ",",
			groupSeparator: ".",
			digits: 0,
			autoGroup: true,
			rightAlign: false,
			oncleared: function () { self.Value(''); }
		});
		$('#outlet_selector').on('change',function(){
			window.location.href = "{{url('product/outlet-detail')}}/"+$(this).val();
		});
		$('#form-prices').submit(function(){
			$('.price').inputmask('remove');
		});

		$(document).on('click', '.same', function() {
			var id = this.id;
			var code = id.split("-");
			code = code[1];
			var visibility = $('#product-visibility-'+code).val();
			var stock = $('#product-stock-'+code).val();

			if (stock == '') {
				alert('Stock field cannot be empty');
				return false;
			}

			if ($('.checkbox-outlet').is(':checked')) {
				var count = $('.checkbox-outlet').prop('checked', false);
				$(this).prop('checked', true);

				var all_visibility = $('.product-visibility-value');
				var array_visibility = [];
				for (i = 0; i < all_visibility.length; i++) {
					array_visibility.push(all_visibility[i]['defaultValue']);
				}
				sessionStorage.setItem("product_visibility", array_visibility);

				var all_stock = $('.product-stock-value');
				var array_stock = [];
				for (i = 0; i < all_stock.length; i++) {
					array_stock.push(all_stock[i]['defaultValue']);
				}
				sessionStorage.setItem("product_stock", array_stock);

				$('.product-visibility').val(visibility);
				$('.product-stock').val(stock);

			} else {

				var item_visibility = sessionStorage.getItem("product_visibility");
				var item_stock = sessionStorage.getItem("product_stock");

				var item_visibility = item_visibility.split(",");
				var item_stock = item_stock.split(",");

				$('.product-visibility').each(function(i, obj) {
					$(this).val(item_visibility[i]);
				});
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

	@yield('filter_view')
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject sbold uppercase font-blue">List Product</span>
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
							<th> Category </th>
							<th> Product </th>
							<th> Visible </th>
							<th> Stock </th>
							<th> POS Status </th>
							<th> Checkbox</th>
						</tr>
						</thead>
						<tbody>
						@if (!empty($product))
							@foreach ($product as $col => $pro)
								<tr>
									<td>@if(isset($pro['category'][0]['product_category_name'])) {{ $pro['category'][0]['product_category_name'] }} @else Uncategorized @endif</td>
									<td> {{ $pro['product_code'] }} - {{ $pro['product_name'] }} </td>

									@if (!empty($pro['product_detail']))
										@php
											$marker = 0;
										@endphp
										@foreach ($pro['product_detail'] as $dpp)
											@if ($dpp['id_outlet'] == $key)
												@php
													$marker = 1;
												@endphp
												<td style="width:20%">
													<select class="form-control product-visibility" name="visible[]" id="product-visibility-{{ $pro['product_code'] }}">
														<option @if(empty($dpp['product_detail_visibility'])) selected @endif>Default Visibilty Product</option>
														<option value="Visible" @if($dpp['product_detail_visibility'] == 'Visible') selected @endif>Visible</option>
														<option value="Hidden" @if($dpp['product_detail_visibility'] == 'Hidden') selected @endif>Hidden</option>
													</select>
													<input type="hidden" value="{{$dpp['product_detail_visibility']}}" class="product-visibility-value">
												</td>
												<td style="width:15%">
													<select class="form-control product-stock" name="product_stock_status[]" id="product-stock-{{ $pro['product_code'] }}">
														<option value="Available" @if($dpp['product_detail_stock_status'] == 'Available') selected @endif>Available</option>
														<option value="Sold Out" @if($dpp['product_detail_stock_status'] == 'Sold Out') selected @endif>Sold Out</option>
													</select>
													<input type="hidden" value="{{$dpp['product_detail_stock_status']}}" class="product-stock-value">
												</td>
												<td style="width:15%">
													<input type="text" value="{{ $dpp['product_detail_status'] }}" class="form-control mt-repeater-input-inline" disabled>
												</td>
											@endif
										@endforeach

										@if ($marker == 0)
											<td style="width: 20%">
												<select class="form-control product-visibility" name="visible[]" id="product-visibility-{{ $pro['product_code'] }}">
													<option>Default Visibilty Product</option>
													<option value="Visible">Visible</option>
													<option value="Hidden">Hidden</option>
												</select>
												<input type="hidden" value="Hidden" class="product-visibility-value">
											</td>
											<td style="width: 15%">
												<select class="form-control product-stock" name="product_stock_status[]" id="product-stock-{{ $pro['product_code'] }}">
													<option value="Available">Available</option>
													<option value="Sold Out" selected>Sold Out</option>
												</select>
												<input type="hidden" value="Available" class="product-stock-value">
											</td>
											<td style="width: 15%">
												<input type="text" value="" class="form-control mt-repeater-input-inline" disabled>
											</td>
										@endif
									@else
										<td style="width: 20%">
											<select class="form-control product-visibility" name="visible[]" id="product-visibility-{{ $pro['product_code'] }}">
												<option>Default Visibilty Product</option>
												<option value="Visible">Visible</option>
												<option value="Hidden" selected>Hidden</option>
												<input type="hidden" value="Hidden" class="product-visibility-value">
											</select>
										</td>
										<td style="width: 15%">
											<select class="form-control product-stock" name="product_stock_status[]" id="product-stock-{{ $pro['product_code'] }}">
												<option value="Available">Available</option>
												<option value="Sold Out" selected>Sold Out</option>
											</select>
											<input type="hidden" value="Available" class="product-stock-value">
										</td>
										<td style="width: 15%">
											<input type="text" value="" class="form-control mt-repeater-input-inline" disabled>
										</td>
									@endif
									<td width="25%">
										<div style="width:40%;display:inline-block;vertical-align: text-top;">
											<label class="mt-checkbox mt-checkbox-outline"> Same for all product
												<input type="checkbox" name="sameall[]" class="same checkbox-outlet" data-check="ampas" id="sameall-{{ $pro['product_code'] }}"/>
												<span></span>
											</label>
										</div>
										<div style="width:40%; display:inline-block;vertical-align: text-top;">
											<label class="mt-checkbox mt-checkbox-outline"> Same for all product on the list
												<input type="checkbox" name="sameallonlist[]" class="same checkbox-outlet" id="sameallonlist-{{ $pro['product_code'] }}"/>
												<span></span>
											</label>
										</div>
									</td>
								</tr>
								<input type="hidden" name="id_product[]" value="{{ $pro['id_product'] }}">
								<input type="hidden" name="id_outlet" value="{{ $key }}">
							@endforeach
						@endif
						</tbody>
					</table>
				</div>
				<div class="form-actions">
					{{ csrf_field() }}
					<div class="row">
						@if ($paginator)
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