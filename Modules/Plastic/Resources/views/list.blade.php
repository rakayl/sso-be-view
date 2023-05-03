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
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/table-datatables-responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('#list_product_plastic').dataTable();

        var SweetAlert = function() {
            return {
                init: function() {
                    $(".sweetalert-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this product plastic?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, delete it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{ url('product-plastic/delete') }}",
                                        data : "_token="+token+"&id_product="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                swal("Deleted!", "product plastic has been deleted.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('product-plastic')}}";
                                            }
                                            else if(result.status == "fail"){
                                                swal("Error!", "Failed to delete product plastic. Product plastic has been used.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete product plastic.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();

        jQuery(document).ready(function() {
            SweetAlert.init()
        });

        $('#list_product_plastic').on('switchChange.bootstrapSwitch', 'input[name="product_visibility"]', function(event, state) {
            var id     = $(this).data('id');
            var token  = "{{ csrf_token() }}";
            if(state == true){
                state = 'Visible'
            }else{
                state = 'Hidden'
            }
            $.ajax({
                type : "POST",
                url : "{{ url('product-plastic/visibility') }}",
                data : "_token="+token+"&id_product="+id+"&product_visibility="+state,
                success : function(result) {
                    if (result.status == "success") {
                        document.getElementById('atr-'+id).innerHTML = state;
                        $('#list_product_plastic').DataTable().rows().invalidate()
                            .draw();
                        toastr.info("Product plastic visibility has been updated.");
                    }
                    else {
                        toastr.warning(result.messages);
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
                <span class="caption-subject font-dark sbold uppercase font-blue">List Product Plastic</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="list_product_plastic">
                <thead>
                <tr>
                    <th > Code</th>
                    <th> Plastic Type </th>
                    <th> Plastic Name </th>
                    <th> Capacity </th>
                    <th> Price </th>
                    <th> Visibility </th>
                    @if(MyHelper::hasAccess([49,51,52], $grantedFeature))
                    <th> Action &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @if(!empty($data))
                    @foreach($data as $res)
                        <tr style="background-color: #fbfbfb;">
                            <td > {{ $res['product_code'] }} </td>
                            <td > {{ $res['plastic_type_name'] }} </td>
                            <td > {{ $res['product_name'] }} </td>
                            <td > {{ $res['product_capacity'] }} </td>
                            <td > {{ $res['global_price'] }} </td>
                            <td >
                                @if(MyHelper::hasAccess([51], $grantedFeature))
                                    <input type="checkbox" name="product_visibility" @if($res['product_visibility'] == 'Visible') checked @endif data-id="{{ $res['id_product'] }}" class="make-switch switch-change" data-size="small" data-on-text="Visible" data-off-text="Hidden">
                                    <p style="display: none" id="atr-{{$res['id_product']}}">{{$res['product_visibility']}}</p>
                                @else
                                    {{ $res['product_visibility'] }}
                                @endif
                            </td>
                            @if(MyHelper::hasAccess([49,51,52], $grantedFeature))
                            <td style="width: 80px;">
                                @if(MyHelper::hasAccess([295,297], $grantedFeature))
                                    <a class="btn btn-sm green" href="{{url('product-plastic/detail', $res['id_product'])}}"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if(MyHelper::hasAccess([298], $grantedFeature))
                                    <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $res['id_product'] }}" data-name="{{ $res['product_name'] }}"><i class="fa fa-trash-o"></i></a>
                                @endif
                            </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection