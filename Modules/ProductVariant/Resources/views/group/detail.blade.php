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
            all_product_variant_group :{
                display:'All Product Variant',
                operator:[],
                opsi:[]
            },
            product_variant_group_code :{
                display:'Product Variant Code',
                operator:[
                    ['=','='],
                    ['like','like']
                ],
                opsi:[]
            }
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
            window.location.href = "{{url('product-variant-group/detail')}}/"+$(this).val();
        });
        $('#form-prices').submit(function(){
            $('.price').inputmask('remove');
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
                <span class="caption-subject sbold uppercase font-blue">List Product Variant</span>
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
                <table class="table table-striped table-bordered table-hover table-responsive" width="100%">
                    <thead>
                        <tr>
                            <th> Product </th>
                            <th> Product Variant </th>
                            <th> Stock </th>
                            <th> Status </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($productVariant))
                            @foreach($productVariant as $pv)
                                <tr>
                                    <td>{{$pv['product_code']}} - {{$pv['product_name']}}</td>
                                    <td>{{$pv['product_variant_group_code']}} -
                                        <?php
                                        $arr = array_column($pv['product_variant_pivot'], 'product_variant_name');
                                        $name = implode(',',$arr);
                                        echo $name;
                                        ?>
                                    </td>
                                    <td>
                                        <select class="form-control" name="detail[{{$pv['id_product_variant_group']}}][product_variant_group_stock_status]">
                                            <option value="Available" @if($pv['product_variant_group_stock_status']=='Available') selected @endif>Available</option>
                                            <option value="Sold Out" @if($pv['product_variant_group_stock_status']=='Sold Out') selected @endif>Sold Out</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="{{$pv['product_variant_group_status']}}" style="max-width: 120px" disabled />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        @if ($productVariantPaginator)
                        <div class="col-md-10">
                            {{ $productVariantPaginator->links() }}
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