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
            window.location.href = "{{url('product/price')}}/"+$(this).val();
        });
        $('#form-prices').submit(function(){
            $('.price').inputmask('remove');
        });

        $(document).on('click', '.same', function() {
            var price = $(this).parent().parent().parent().find('.product-price').val();
            price = price.replace(".", "");

            if ($('.checkbox-product-price').is(':checked')) {
                var check = $('input[name="sameall[]"]:checked').length;
                var count = $('.checkbox-product-price').prop('checked', false);
                $(this).prop('checked', true);

                if (check == 1) {
                    var all_price = $('.product-price');
                    var array_price = [];
                    for (i = 0; i < all_price.length; i++) {
                        array_price.push(all_price[i]['defaultValue']);
                    }
                    sessionStorage.setItem("product_price", array_price);
                }

               $('.product-price').val(price);

            } else {

                var item_price = sessionStorage.getItem("product_price");

                var item_price = item_price.split(",");

                $('.product-price').each(function(i, obj) {
                    $(this).val(item_price[i]);
                });

                $(this).parent().parent().parent().find('.product-price').val(price);
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
                        <option value="0">Global price</option>
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet['id_outlet'] }}" @if ($outlet['id_outlet'] == $key) selected @endif>{{ $outlet['outlet_code'] }} - {{ $outlet['outlet_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="portlet-body form">
            <form id="form-prices" action="{{url()->current()}}" method="POST">
                <table class="table table-striped table-bordered table-hover table-responsive" width="100%">
                    <thead>
                    <tr>
                        <th> Category </th>
                        <th> Product </th>
                        <th> Price </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (!empty($product))
                        @foreach ($product as $col => $pro)
                            <tr>
                                <td>@if(isset($pro['category'][0]['product_category_name'])) {{ $pro['category'][0]['product_category_name'] }} @else Uncategorized @endif</td>
                                <td> {{ $pro['product_code'] }} - {{ $pro['product_name'] }} </td>
                                <td style="width:40%;">
                                    <div style="width:40%;">
                                    @if($key == 0)
                                        <?php
                                            $priceGlobal = 0;
                                            if(isset($pro['global_price'][0]['product_global_price'])){
                                                $priceGlobal = $pro['global_price'][0]['product_global_price'];
                                            }
                                        ?>
                                        <input type="text" name="price[]" value="{{(int)$priceGlobal}}" data-placeholder="input price" data-id="{{$pro['id_product']}}" class="form-control mt-repeater-input-inline price product-price">
                                    @else
                                        <?php
                                            $price = 0;
                                            if(isset($pro['product_special_price'])){
                                                $checkExist = array_search($key, array_column($pro['product_special_price'], 'id_outlet'));
                                                if($checkExist !== false){
                                                    $price = $pro['product_special_price'][$checkExist]['product_special_price'];
                                                }
                                            }
                                        ?>
                                        <input type="text" name="price[]" value="{{(int)$price}}" data-placeholder="input price" data-id="{{$pro['id_product']}}" class="form-control mt-repeater-input-inline price product-price">
                                    @endif
                                    </div>
                                    <br>
                                    <div style="width:40%; display:inline-block; vertical-align: text-top;">
                                        <label class="mt-checkbox mt-checkbox-outline"> Same for all product
                                            <input type="checkbox" name="sameall[]" class="same checkbox-product-price" data-check="ampas"/>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div style="width:40%; display:inline-block; vertical-align: text-top;">
                                        <label class="mt-checkbox mt-checkbox-outline"> Same for all product on the list
                                            <input type="checkbox" name="sameallonlist[]" class="same checkbox-product-price"/>
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