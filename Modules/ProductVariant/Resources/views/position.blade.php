<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/nestable2/jquery.nestable.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/nestable2/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>

        $(document).ready(function() {
            var obj = {!! $variants !!};
            var output = '';

            function buildItem(item) {

                var html = "<li class='dd-item' data-id='" + item.id_product_variant + "' data-parent='"+item.id_parent+"'>";
                html += "<div class='dd-handle'>" + item.product_variant_name + "</div>";
                html += '<input type="hidden" name="position[]" value="'+item.id_product_variant+'">';

                if (item.children) {

                    html += "<ol class='dd-list'>";
                    $.each(item.children, function (index, sub) {
                        html += buildItem(sub);
                    });
                    html += "</ol>";

                }
                html += "</li>";

                return html;
            }

            $.each(obj, function (index, item) {
                output += buildItem(item);
            });

            $('#variants').html(output);

            $('#nestable3').nestable({
                beforeDragStop: function(l,e, p){
                    // l is the main container
                    // e is the element that was moved
                    // p is the place where element was moved.
                    var id = $(e).data('id');
                    var parent = $(e).data('parent');

                    if($(p[0].offsetParent).data('id') && parent !== $(p[0].offsetParent).data('id')){
                        swal("Error!", "Can not change position", "error");
                        return false;
                    }else if($(p[0].firstChild).data('id') && $(p[0].offsetParent).data('id') == undefined && parent !== $(p[0].firstChild).data('id')){
                        swal("Error!", "Can not not change position", "error");
                        return false;
                    }else if(parent && $(p[0].offsetParent).data('id') == undefined && $(p[0].firstChild).data('id') == undefined){
                        swal("Error!", "Can not change position", "error");
                        return false;
                    }
                }
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Product Variant Position</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form action="{{url('product-variant/position')}}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="dd" id="nestable3">
                            <ol class='dd-list dd3-list'>
                                <div id="variants"></div>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-center" style="margin-top: 2%">
                        <button type="submit" class="btn green"> Update Position</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection