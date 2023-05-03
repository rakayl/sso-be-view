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
    <script>
        var table;
        $(document).ready(function() {
            // library initialization
            $('[data-switch=true]').bootstrapSwitch();
            table = $('#kt_datatable').DataTable({serverSide: true, ordering: false,
                "lengthChange": false,
                ajax: {
                    url : "{{url('product-variant-group/list')}}",
                    type: 'GET',
                    data: function (data) {
                        const info = $('#kt_datatable').DataTable().page.info();
                        data.page = (info.start / info.length) + 1;
                    },
                    dataSrc: 'data'
                },
                columns: [
                    {data: 'product_code'},
                    {data: 'product_name'},
                    {data: 'count_product_variant_group'},
                    {data: 'product_code'},
                ],
                columnDefs: [
                    {
                        'targets': 3,
                        render: function ( data, type, row, meta ) {
                            var status = '{{MyHelper::hasAccess([281,282], $grantedFeature)}}';
                            var html = '';

                            if(status == 1){
                                html += '<form action="{{url('product-variant-group/delete')}}/'+data+'" method="POST" class="form-inline">';
                                html += '{{method_field('DELETE')}}';
                                html += '{{csrf_field()}}';
                                html += '<button class="btn btn-sm red btnDelete" type="submit" data-toggle="confirmation"><i class="fa fa-trash"></i></button>';
                                html += '<a href="{{ url("product-variant-group/edit") }}/'+data+'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>';
                                html += '</form>';
                            }
                            $('[data-toggle=confirmation]').confirmation({ btnOkClass: 'btn btn-sm btn-success submit', btnCancelClass: 'btn btn-sm btn-danger'});
                            return html;
                        }
                    }
                ]
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
                <span class="caption-subject font-blue sbold uppercase">Product List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="kt_datatable">
                <thead>
                <tr>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Variant</th>
                    @if(MyHelper::hasAccess([286,287], $grantedFeature))
                        <th>Action</th>
                    @endif
                </tr>
                </tr>
                </thead>
                <tbody id="kt_datatable_tbody"></tbody>
            </table>
        </div>
    </div>



@endsection