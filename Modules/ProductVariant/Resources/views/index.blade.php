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
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-nestable/jquery.nestable.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dd-handle:hover{
            background: #fafafa;
            color: #333;
            cursor: context-menu;
        }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>

        $(document).ready(function() {
            var obj = {!! $variants !!};
            var output = '';
            var output_action = '';

            function buildItem(item) {

                var html = "<li class='dd-item' data-id='" + item.id_product_variant + "' data-parent='"+item.id_parent+"'>";
                html += "<div class='dd-handle dd-nodrag'>" + item.product_variant_name + "</div>";
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

            function buildItemAction(item) {

                var html = "<li style='margin-top:1.2%;margin-bottom:1%;list-style-type:none;'>";
                html += '<div class="row">' +
                    '<a href="{{ url("product-variant/edit") }}/'+item.id_product_variant+'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>' +
                    '<a onclick="deleteVariant(\'' + item.id_product_variant + '\',\'' + item.product_variant_name + '\')" class="btn btn-sm btn-danger sweetalert-delete" style="margin-left:0.5%"><i class="fa fa-trash"></i></a>' +
                    '<div>';

                if (item.children) {

                    $.each(item.children, function (index, sub) {
                        html += buildItemAction(sub);
                    });

                }
                html += "</li>";

                return html;
            }

            $.each(obj, function (index, item) {
                output += buildItem(item);
                output_action += buildItemAction(item);
            });

            $('#variants').html(output);
            $('#variants_action').html(output_action);
        });

        function deleteVariant(id_product_variant, product_variant_name) {
            swal({
                    title: "Are you sure want to delete variant \n" + product_variant_name + " ?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete!",
                    closeOnConfirm: false
                },
                function () {
                    var token  	= "{{ csrf_token() }}";
                    $.ajax({
                        type: "POST",
                        url: "{{ url('product-variant/delete') }}/"+id_product_variant,
                        data: "_token=" + token + "&id_product_variant=" + id_product_variant,
                        success: function (result) {
                            if (result.status == "success") {
                                swal("Success!", "Deleted product variant.", "success")
                                location.reload();
                            } else {
                                swal("Error!", "Fail delete product variant, product variant already to use in transaction", "error")
                            }
                        }
                    });
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
                <span class="caption-subject font-blue sbold uppercase">Product Variant List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
                <div class="col-md-6">
                    <div class="dd" id="nestable3">
                        <ol class='dd-list dd3-list'>
                            <div id="variants"></div>
                        </ol>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="variants_action"></div>
                </div>
            </div>
        </div>
    </div>

@endsection