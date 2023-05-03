<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script>
        var table;
        $(document).ready(function() {
            // library initialization
            table = $('#kt_datatable').DataTable({serverSide: true, ordering: false,
                "lengthChange": false,
                "searching" : false,
                ajax: {
                    url : "{{url('product-variant-group/list-group')}}",
                    type: 'GET',
                    data: function (data) {
                        const info = $('#kt_datatable').DataTable().page.info();
                        data.page = (info.start / info.length) + 1;
                    },
                    dataSrc: 'data'
                },
                columns: [
                    {data: 'id_product_variant_group'},
                    {data: 'name_brand'},
                    {data: 'product_name'},
                    {data: 'product_variant_group_code'},
                    {data: 'product_variant_pivot'}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        render: function ( data, type, row, meta ) {
                            if($('#checkall').is(":checked") || arrProductVariant.indexOf(data) >= 0){
                                var html = '<label class="mt-checkbox"><input value="'+data+'" onchange="checkboxEvent(this)" type="checkbox" id="check'+data+'" class="md-check checkbox-fee-special-outlet" checked/> <span></span></label>';
                            }else{
                                var html = '<label class="mt-checkbox"><input value="'+data+'" onchange="checkboxEvent(this)" type="checkbox" id="check'+data+'" class="md-check checkbox-fee-special-outlet" /> <span></span></label>';
                            }

                            return html;
                        }
                    },
                    {
                        'targets': 4,
                        render: function ( data, type, row, meta ) {
                            var arr = [];
                            if(data){
                                for(var i=0;i<data.length;i++){
                                    arr.push(data[i].product_variant_name);
                                }
                            }

                            return arr.join();
                        }
                    }
                ]
            });
        });

        var arrProductVariant = [];
        function checkboxEvent(checkboxElem) {
            var value = checkboxElem.value;

            if(value == 'all'){
                if (checkboxElem.checked) {
                    arrProductVariant = [];
                    arrProductVariant.push('all');
                    $(".checkbox-fee-special-outlet").prop("checked", true);
                }else{
                    arrProductVariant = [];
                    $(".checkbox-fee-special-outlet").prop("checked", false);
                }
            }else{
                if (checkboxElem.checked) {
                    arrProductVariant.push(Number(checkboxElem.value));
                } else {
                    var index = arrProductVariant.indexOf(Number(checkboxElem.value));
                    if (index > -1) {
                        arrProductVariant.splice(index, 1);
                    }
                }
            }
        }

        function submitRemoveProductVariant() {
            var msg = "";

            if(document.getElementById("checkall").checked === false){
                if(arrProductVariant.length <= 0){
                    msg += "Please select one or more product variant to remove \n";
                }
            }

            if(msg !== ""){
                confirm(msg);
            }else{
                if(confirm('Are you sure you want to delete selected product variant?')) {
                    $('input[name=id_product_variant]').val(arrProductVariant);
                    $( "#form_product_variant" ).submit();
                }
            }
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

    <form role="form" action="{{ url('product-variant-group/list-group')}}?filter=1" method="post">
        @include('productvariant::group.filter')
    </form>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Product Variant List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <label class="mt-checkbox"><input value="all" onchange="checkboxEvent(this)" type="checkbox" id="checkall" class="md-check checkbox-fee-special-outlet" /> <span></span> Remove All Product Variant Group (base on list data)</label>
            <form class="form-horizontal" role="form" id="form_product_variant" action="{{url('product-variant-group/remove')}}" method="post">
                {{ csrf_field() }}
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="kt_datatable">
                    <thead>
                    <tr>
                    <tr>
                        <th>Checkbox</th>
                        <th>Brand Name</th>
                        <th>Product</th>
                        <th>Product Variant Code</th>
                        <th>Variant</th>
                    </tr>
                    </tr>
                    </thead>
                    <tbody id="kt_datatable_tbody"></tbody>
                </table>
                <input type="hidden" name="id_product_variant">
            </form>
            <div class="form-actions" style="text-align: center">
                <button onclick="submitRemoveProductVariant()" class="btn green">Submit</button>
            </div>
        </div>
    </div>



@endsection