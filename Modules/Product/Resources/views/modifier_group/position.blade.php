@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .sort-icon{
            margin-right: 5px;
        }
        .sort-icon:hover{
            cursor: move;
        }
        .sort-link{
            padding-left: 5px !important;
        }
        .sub-menu a{
            padding-left: 30px;
        }
        .sub-menu.active a,
        .sub-menu-parent.active a{
            color: #555;
            background-color: #eee;
        }
        .sub-menu-parent a{
            padding-left: 20px !important;
        }

        /* product list */
        .product-li{
            padding: 7px 15px;
            border: 1px solid #eee;
            margin-bottom: 15px;
        }
        .product-li:hover{
            background-color: #eee;
        }

    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $(".sortable-product").sortable({
                stop: function (event, ui) {
                        sortProductModifier(event);
                    }
            });
            $(".sortable-product").disableSelection();
        });

        var token = "{{ csrf_token() }}";

        // ajax sort topping
        function sortProductModifier(e) {
            var ids = [];
            // get product id
            $(e.target).find(".product-li").each(function() {
                var id = $(this).data('id');
                ids.push(id);
            });

            var data = {_token: token, modifier_group_ids: ids};

            $.ajax({
                type : "POST",
                url : "{{ url('product/modifier-group/position/assign') }}",
                data : data,
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("Data has been sorted.");
                    }
                    else if(result.messages != ""){
                        toastr.warning(result.messages);
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to sort data.");
                    }
                }
            });
        }
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
                <span class="caption-subject sbold uppercase font-blue">List Product Variant NON PRICE (NO SKU) By Position</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="alert alert-info">
                Drag and drop the item to sort "Product Variant NON PRICE (NO SKU)"
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 product-position">
                    <div class="tab-content">
                        <ul class="nav sortable-product">
                            @foreach($list as $value)
                                <li class="product-li" data-id="{{$value['id_product_modifier_group']}}">
                                    <i class="sort-icon fa fa-arrows"></i>
                                    {{$value['product_modifier_group_name']}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection