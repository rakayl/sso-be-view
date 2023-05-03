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
                                    title: name+"\n\nAre you sure want to delete this plastic type?",
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
                                        url : "{{ url('plastic-type/delete') }}",
                                        data : "_token="+token+"&id_plastic_type="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                swal("Deleted!", "plastic type has been deleted.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('plastic-type')}}";
                                            }
                                            else if(result.status == "fail"){
                                                swal("Error!", "Failed to delete plastic type. Plastic type has been used.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete plastic type.", "error")
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
    </div><br>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-blue">List Category</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="list_product_plastic">
                <thead>
                <tr>
                    <th width="10"> No</th>
                    <th> Name </th>
                    <th> Outlet Group </th>
                    @if(MyHelper::hasAccess([49,51,52], $grantedFeature))
                    <th> Action </th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @if(!empty($data))
                    @foreach($data as $key=>$res)
                        <tr style="background-color: #fbfbfb;">
                            <td > {{ $key+1 }} </td>
                            <td > {{ $res['plastic_type_name'] }} </td>
                            <td>
                                <ul>
                                    @foreach($res['outlet_group'] as $group)
                                    <li>{{$group['outlet_group_name']}}</li>
                                    @endforeach
                                </ul>
                            </td>
                            @if(MyHelper::hasAccess([49,51,52], $grantedFeature))
                            <td style="width: 80px;">
                                @if(MyHelper::hasAccess([295,297], $grantedFeature))
                                    <a class="btn btn-sm green" href="{{url('plastic-type/detail', $res['id_plastic_type'])}}"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if(MyHelper::hasAccess([298], $grantedFeature))
                                    <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $res['id_plastic_type'] }}" data-name="{{ $res['plastic_type_name'] }}"><i class="fa fa-trash-o"></i></a>
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