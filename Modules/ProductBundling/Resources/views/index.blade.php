<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

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
                                    title: name+"\n\nAre you sure want to delete this bundling?",
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
                                        url : "{{ url('product-bundling/delete') }}",
                                        data : "_token="+token+"&id_bundling="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                swal("Deleted!", "Bundling has been deleted.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('product-bundling')}}";
                                            }
                                            else if(result.status == "fail"){
                                                swal("Error!", "Failed to delete bundling. Bundling has been used.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete Bundling.", "error")
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
    </div>
    <br>

    @include('layouts.notifications')

    <?php
    $date_start = '';
    $date_end = '';

    if(Session::has('filter-list-bundling')){
        $search_param = Session::get('filter-list-bundling');
        if(isset($search_param['date_start'])){
            $date_start = $search_param['date_start'];
        }

        if(isset($search_param['date_end'])){
            $date_end = $search_param['date_end'];
        }

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
        @include('productbundling::filter-bundling')
    <br>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Product Bundling List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
                <div class="col-md-4">
                    <select name="order_field" class="form-control select2" style="width: 100%">
                        <option value="id_bundling" @if($order_field == 'id_bundling') selected @endif>Order by ID</option>
                        <option value="bundling_code" @if($order_field == 'bundling_code') selected @endif>Order by Bundling ID</option>
                        <option value="bundling_name" @if($order_field == 'bundling_name') selected @endif>Order by Bundling Name</option>
                        <option value="bundling_price_before_discount" @if($order_field == 'bundling_price_before_discount') selected @endif>Price Before Discount</option>
                        <option value="bundling_price_after_discount" @if($order_field == 'bundling_price_after_discount') selected @endif>Price After Discount</option>
                        <option value="start_date" @if($order_field == 'start_date') selected @endif>Start Date</option>
                        <option value="end_date" @if($order_field == 'end_date') selected @endif>End Date</option>
                        <option value="created_at" @if($order_field == 'created_at') selected @endif>Created Date</option>
                    </select>
                </div>
                <div class="col-md-2" style="padding-left:0px;padding-right:0px">
                    <select name="order_method" class="form-control select2">
                        <option value="desc" @if($order_method == 'desc') selected @endif>Desc</option>
                        <option value="asc" @if($order_method == 'asc') selected @endif>Asc</option>
                    </select>
                </div>
                <div class="col-md-1" style="padding-left:0px;padding-right:0px;text-align:right">
                    <button type="submit" class="btn yellow">Show</button>
                </div>
            </div>
            <br>
            <br>
            <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            @if(MyHelper::hasAccess([291,292], $grantedFeature))
                                <th> Action</th>
                            @endif
                            <th style="width: 100px"> Bundling ID </th>
                            <th style="width: 100px"> Name </th>
                            <th style="width: 100px"> Price Before Discount </th>
                            <th style="width: 100px"> Price After Discount </th>
                            <th style="width: 100px"> Brands </th>
                            <th style="width: 100px"> Product List </th>
                            <th style="width: 100px"> Bundling Start </th>
                            <th style="width: 100px"> Bundling End </th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @if (!empty($data))
                            @foreach($data as $value)
                                <tr>
                                    <td>
                                        @if(MyHelper::hasAccess([292], $grantedFeature))
                                            <a class="btn btn-sm green" href="{{url('product-bundling/detail', $value['id_bundling'])}}"><i class="fa fa-pencil"></i></a>
                                        @endif
                                        @if(MyHelper::hasAccess([291], $grantedFeature))
                                                <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $value['id_bundling'] }}" data-name="{{ $value['bundling_name'] }}"><i class="fa fa-trash-o"></i></a>
                                        @endif
                                    </td>
                                    <td>{{ $value['bundling_code'] }}</td>
                                    <td>{{ $value['bundling_name'] }}</td>
                                    <td>{{ number_format($value['bundling_price_before_discount']) }}</td>
                                    <td>{{ number_format($value['bundling_price_after_discount']) }}</td>
                                    <td>
                                        <ul>
                                            @foreach($value['brands'] as $brands)
                                                <li>{{$brands['name_brand']}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul style="padding-left: 20px;">
                                            @foreach ($value['bundling_product'] as $item)
                                                <li>{{$item['product_name']}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ date('d M Y H:i', strtotime($value['start_date'])) }}</td>
                                    <td>{{ date('d M Y H:i', strtotime($value['end_date'])) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr style="text-align: center"><td colspan="10">No Data Available</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </form>
    <br>
    @if ($dataPaginator)
        {{ $dataPaginator->links() }}
    @endif
@endsection