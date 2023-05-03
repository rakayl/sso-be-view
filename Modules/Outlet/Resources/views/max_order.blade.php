@extends('layouts.main')

@include('list_filter')
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    {{-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<!-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script> -->
    @yield('filter_script')
     <script type="text/javascript">
        rules = {
            all_product_modifier :{
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
            max_order :{
                display:'Maximum Order',
                operator:[
                    ['=','='],
                    ['<','<'],
                    ['>','>'],
                    ['<=','<='],
                    ['>=','>=']
                ],
                opsi:[],
                type: 'number'
            }
        };
        $(document).ready(function() {
	        $('#outlet_selector').on('change',function(){
	            window.location.href = "{{url('outlet/max-order')}}/"+$(this).val();
	        });
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
                <span class="caption-subject sbold uppercase font-blue">Outlet Maximum Order</span>
            </div>
            <div class="actions">
                <div class="btn-group" style="width: 300px">
                   <select class="form-control select2-multiple" id="outlet_selector" data-placeholder="select outlet">
	                @foreach($outlets as $outlet)
	                    <option value="{{ $outlet['outlet_code'] }}" @if ($outlet['outlet_code'] == $key) selected @endif>{{ $outlet['outlet_code'] }} - {{ $outlet['outlet_name'] }}</option>
	                @endforeach
				    </select>
                </div>
            </div>
        </div>
        <div class="portlet_body">
        	<form method="POST">
        		<div class="row">
        			<label class="col-md-3 control-label text-right">
                            Catering Order
                            <i class="fa fa-question-circle tooltips" data-original-title="Digunakan untuk mengatur apakah outlet menerima Catering Order atau tidak" data-container="body"></i>
        			</label>
        			<div class="col-md-9"><input type="checkbox" value="1" name="advance_order" data-id="{{ $data['outlet']['id_outlet'] }}" class="make-switch switch-change" data-size="small" data-on-text="Support" data-off-text="Not Support" @if($data['outlet']['advance_order']) checked @endif></div>
        		</div><br/>
        		<div class="row">
        			<label class="col-md-3 control-label text-right">
                            Default Maximum Order
                            <i class="fa fa-question-circle tooltips" data-original-title="Digunakan untuk mengatur default jumlah pemesanan maksimum dalam pemesanan reguler (non Catering Order) untuk outlet {{ $outlet['outlet_name'] }} apabila per produk tidak diatur" data-container="body"></i>
        			</label>
        			<div class="col-md-3">
        				<div class="input-group">
	        				<input type="number" min="1" name="max_order" class="form-control" value="{{$data['outlet']['max_order']}}" />
							<div class="input-group-addon">Item</div>
        				</div>
        			</div>
        		</div>
	        	<table class="table">
	        		<thead>
	        			<tr>
	        				<th>No</th>
	        				<th>Product Name</th>
	        				<th>Maximum Order</th>
	        			</tr>
	        		</thead>
	        		<tbody>
                        @if($data['products']['data']??[])
    	        			@foreach($data['products']['data']??[] as $product)
    	        			<tr>
    	        				<td width="1%">{{$start}}</td>
    	        				<td>{{$product['product_code']}} - {{$product['product_name']}}</td>
    	        				<td width="200px">
    		        				<div class="input-group">
    	        						<input type="number" min="1" name="products[{{$product['id_product']}}]" class="form-control" value="{{$product['max_order']}}">
    									<div class="input-group-addon">Item</div>
    		        				</div>
    		        			</td>
    	        			</tr>
    	        			@php $start++ @endphp
    	        			@endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">
                                    <em class="text-muted">No product found</em>
                                </td>
                            </tr>
                        @endif
	        		</tbody>
	        	</table>
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
