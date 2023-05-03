<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script>
        $('#sample_1').dataTable({
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false
        });

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
                                    title: name+"\n\nAre you sure want to delete this product?",
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
                                        url : "{{ url('product/delete') }}",
                                        data : "_token="+token+"&id_product="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                swal({
                                                    title: 'Deleted!',
                                                    text: 'Product has been deleted.',
                                                    type: 'success',
                                                    showCancelButton: false,
                                                    showConfirmButton: false
                                                })
                                                SweetAlert.init()
                                                location.href = "{{url('product')}}";
                                            }
                                            else if(result.status == "fail"){
                                                swal("Error!", result.messages[0], "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete product.", "error")
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

        $('#sample_1').on('switchChange.bootstrapSwitch', 'input[name="product_visibility"]', function(event, state) {
            var id     = $(this).data('id');
            var token  = "{{ csrf_token() }}";
            if(state == true){
                state = 'Visible'
            }
            else if(state == false){
                state = 'Hidden'
            }
            $.ajax({
                type : "POST",
                url : "{{ url('product/update/visibility/global') }}",
                data : "_token="+token+"&id_product="+id+"&product_visibility="+state,
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("Product visibility has been updated.");
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                }
            });
        });
    </script>
@endsection

@extends('layouts.main')

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

    <?php
    if(Session::has('filter-products')){
        $search_param = Session::get('filter-products');

        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
    }
    ?>

    <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
        {{ csrf_field() }}
        @include('product::product.filter_list_product')
    </form>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">List Product</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                <tr>
                    <th> Code </th>
                    <th> Outlet </th>
                    <th> Category </th>
                    <th> Name </th>
                    <th >Visibility Product</th>
                    @if(MyHelper::hasAccess([49,51,52], $grantedFeature))
                        <th> Action </th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @if (!empty($data))
                    @foreach($data as $key => $value)
                        <tr>
                            <td>{{ $value['product_code'] }}</td>
                            <td>
                                {{$value['outlet']['outlet_name']??''}}
                            </td>
                            @if (empty($value['category']))
                                <td>Uncategorize</td>
                            @else
                                <td>{{ $value['category'][0]['product_category_name']??'Uncategories' }}</td>
                            @endif
                            <td>{{ $value['product_name'] }}</td>
                            <td>
                                <div class="bootstrap-switch-container">
                                    <span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 35px;"></span>
                                    <span class="bootstrap-switch-label" style="width: 35px;">&nbsp;</span>
                                    <span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 35px;"></span>
                                    <input type="checkbox" name="product_visibility" @if(!empty($value['product_detail'][0]['product_detail_visibility']) && $value['product_detail'][0]['product_detail_visibility'] == 'Visible') checked @endif data-id="{{ $value['id_product'] }}" class="make-switch switch-large switch-change" data-on-text="Visible" data-off-text="Hidden">
                                </div>
                            </td>
                            @if(MyHelper::hasAccess([49,51,52], $grantedFeature))
                                <td style="width: 80px;white-space: nowrap">
                                    @if(MyHelper::hasAccess([52], $grantedFeature))
                                        <a class="btn btn-sm red sweetalert-delete" data-id="{{ $value['id_product'] }}" data-name="{{ $value['product_name'] }}"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                    @if(MyHelper::hasAccess([49,51], $grantedFeature))
                                        <a href="{{ url('product/detail') }}/{{ $value['product_code'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            <div style="text-align: right">
                @if ($dataPaginator)
                    {{ $dataPaginator->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection