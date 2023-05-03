@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
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
                <span class="caption-subject sbold uppercase font-blue"> Product Variant NON PRICE (NO SKU) Inventory Brand </span>
            </div>
        </div>
        <div class="portlet-body">
        	<div class="m-heading-1 border-green m-bordered">
		        <li>Halaman ini digunakan untuk menampilkan product Variant NON PRICE (NO SKU) pada menu pengaturan stok di outlet apps.</li>
		        <li>Product Variant NON PRICE (NO SKU) hanya akan tampil pada outlet yang memiliki brand yang dipilih.</li>
	        	<li>Name : nama product Variant NON PRICE (NO SKU)</li> 
	        	<li>Child : pembagian dari product Variant NON PRICE (NO SKU) menjadi turunan yang lebih spesifik</li>
	        	<li>Brand : brand yang akan menjadi acuan untuk menampilkan product Variant NON PRICE (NO SKU) di menu pengaturan stok outlet apps</li>
		    </div>
            <form action="{{url()->current()}}" method="post">
                <table class="table table-striped table-bordered table-hover table-responsive" width="100%">
                    <thead>
                        <tr>
                            <th> Name </th>
                            <th> Child </th>
                            <th> Brand </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modifier_groups as $modifier_group)
                        <tr>
                            <td>{{ $modifier_group['name'] }}</td>
                            <td>
                                <ul>
                                    @foreach($modifier_group['product_modifier'] as $pm)
                                        <li>{{$pm['text']}} ({{$pm['code']}})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <select class="select2 form-control" multiple name="product_modifier_groups[{{ $modifier_group['id_product_modifier_group'] }}][]">
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand['id_brand'] }}" {{ in_array($brand['id_brand'], $modifier_group['inventory_brand']) ? 'selected' : '' }}>{{ $brand['name_brand'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    <hr>
                    @csrf
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection