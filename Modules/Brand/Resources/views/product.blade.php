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
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: -1,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('brand/delete/product') }}",
                data : "_token="+token+"&id_brand_product="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Product Brand has been deleted.");
                    }
                    else if(result == "fail"){
                        toastr.warning("Failed to delete product brand.Product Brand has been used.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete product brand.");
                    }
                }
            });
        });
        $(document).ready(function() {
            var token  = "{{ csrf_token() }}";
            var id     = "{{$result['id_brand']}}";
            $("#selectProduct").prop('disabled', true);
            $.ajax({
                type: "POST",
                url: "{{$result['id_brand']}}/"+"list",
                data : "_token="+token+"&id_brand="+id,
                dataType: "json",
                success: function(data){
                    console.log(data)
                    $("#selectProduct").prop('disabled', false);
                    if (data.status == 'fail') {
                        $.ajax(this)
                        return
                    }
                    productLoad = 1;
                    $.each(data, function( key, value ) {
                        $('#selectProduct').append("<option id='tag"+value.id_product+"' value='"+value.id_product+"'>"+value.product_code+" - "+value.product_name+"</option>");
                    });
                    $('#multipleProduct').prop('required', true)
                    $('#multipleProduct').prop('disabled', false)
                }
            });
            $("#selectProduct").select2({
                placeholder: "Select product"
            })
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
                <span class="caption-subject font-blue sbold uppercase">Product Brand {{$result['name_brand']}} List</span>
            </div>
            <div class="actions">
                <a class="btn green btn-md" data-toggle="modal" href="#basic"> <i class="fa fa-plus"></i> Add Product </a>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th style="width:20%;"> Code </th>
                        <th style="width:20%;"> Name </th>
                        <th style="width:20%;"> Visibility </th>
                        @if(MyHelper::hasAccess([25,27,28], $grantedFeature))
                            <th style="width:10%;"> Action </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($result))
                        @foreach($result['brand_product'] as $value)
                            <tr style="height: 45px;">
                                <td>{{ $value['products']['product_code'] }}</td>
                                <td>{{ $value['products']['product_name'] }}</td>
                                <td>{{ $value['products']['product_visibility'] }}</td>
                                @if(MyHelper::hasAccess([25,27,28], $grantedFeature))
                                    <td style="width: 90px;">
                                        <div class="btn-group btn-group-solid">
                                            @if(MyHelper::hasAccess([28], $grantedFeature))
                                                <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_brand_product'] }}"><i class="fa fa-trash-o"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" role="form" action="{{ url('brand/product/store') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Add Product to Brand {{$result['name_brand']}}</h4>
                    </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Brand</label>
                                <div class="col-md-7">
                                    <div class="input-icon right">
                                        <input type="text" readonly placeholder="Brand Name" class="form-control" name="name_brand" value="{{ $result['name_brand'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Product</label>
                                <div class="col-md-7">
                                    <div class="input-icon right">
                                        <select style="width:100%;" id="selectProduct" name="product[]" class="form-control select2-multiple" multiple="multiple" tabindex="-1" aria-hidden="true"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        {{ csrf_field() }}
                        <input hidden name="id_brand" value="{{ $result['id_brand'] }}">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn green">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection