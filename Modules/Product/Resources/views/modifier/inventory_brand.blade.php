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
                <span class="caption-subject sbold uppercase font-blue">Topping Inventory Brand</span>
            </div>
        </div>
        <div class="portlet-body">
        	<div class="m-heading-1 border-green m-bordered">
		        <li>Halaman ini digunakan untuk menampilkan topping pada menu pengaturan stok di outlet apps.</li>
		        <li>Topping hanya akan tampil pada outlet yang memiliki brand yang dipilih.</li>
	        	<li>Topping : nama topping</li> 
	        	<li>Brand : brand yang akan menjadi acuan untuk menampilkan topping di menu pengaturan stok outlet apps</li>
		    </div>
            <form action="{{url()->current()}}" method="post">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 30%">Topping</th>
                            <th>Brand</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modifiers as $modifier)
                        <tr>
                            <td>{{$modifier['text']}}</td>
                            <td>
                                <select class="select2 form-control" multiple name="product_modifiers[{{$modifier['id_product_modifier']}}][]">
                                    @foreach($brands as $brand)
                                    <option value="{{$brand['id_brand']}}" {{in_array($brand['id_brand'], $modifier['inventory_brand']) ? 'selected' : ''}}>{{$brand['name_brand']}}</option>
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