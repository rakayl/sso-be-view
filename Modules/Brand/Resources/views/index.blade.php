<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main-closed')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        #sortable{
            cursor: move;
        }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var table=$('#sample_1').DataTable({
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
                buttons: [{
                    extend: "print",
                    className: "btn dark btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "copy",
                  className: "btn blue btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                },{
                  extend: "pdf",
                  className: "btn yellow-gold btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }, {
                    extend: "excel",
                    className: "btn green btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                    extend: "csv",
                    className: "btn purple btn-outline ",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "colvis",
                  className: "btn red",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }],
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
                url : "{{ url('brand/delete') }}",
                data : "_token="+token+"&id_brand="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Brand has been deleted.");
                    }
                    else if(result == "fail"){
                        toastr.warning("Failed to delete brand. Brand has been used.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete brand.");
                    }
                }
            });
        });
        var manual=1;
        $(document).ready(function(){
            $('.form').on( 'click', function () {
                $('#data_start').val(table.page.info().start);
            });
            $('#sortable').sortable();
            $('#sortable').on('switchChange.bootstrapSwitch','.brand_status',function(){
                if(!manual){
                    manual=1;
                    return false;
                }
                var switcher=$(this);
                var newState=switcher.bootstrapSwitch('state');
                $.ajax({
                    method:'GET',
                    url:"{{url('brand/switch_status')}}",
                    data:{
                        id_brand:switcher.data('id'),
                        brand_active:newState
                    },
                    success:function(data){
                        if(data.status == 'success'){
                            toastr.info("Success update brand status");
                        }else{
                            manual=0;
                            toastr.warning("Fail update brand status");
                            switcher.bootstrapSwitch('state',!newState);
                        }
                    }
                }).fail(function(data){
                    manual=0;
                    toastr.warning("Fail update brand status");
                    switcher.bootstrapSwitch('state',!newState);
                });
            });
            $('#sortable').on('switchChange.bootstrapSwitch','.brand_visibility',function(){
                if(!manual){
                    manual=1;
                    return false;
                }
                var switcher=$(this);
                var newState=switcher.bootstrapSwitch('state');
                $.ajax({
                    method:'GET',
                    url:"{{url('brand/switch_visibility')}}",
                    data:{
                        id_brand:switcher.data('id'),
                        brand_visibility:newState
                    },
                    success:function(data){
                        if(data.status == 'success'){
                            toastr.info("Success update brand visibility");
                        }else{
                            manual=0;
                            toastr.warning("Fail update brand visibility");
                            switcher.bootstrapSwitch('state',!newState);
                        }
                    }
                }).fail(function(data){
                    manual=0;
                    toastr.warning("Fail update brand visibility");
                    switcher.bootstrapSwitch('state',!newState);
                });
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
                <span class="caption-subject font-blue sbold uppercase">Brand List</span>
            </div>
        </div>
        <div class="portlet-body form">

            <form action="{{url('/brand/reorder')}}" method="POST">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                    <thead>
                        <tr>
                            <th> Code </th>
                            <th> Name </th>
                            <th> Logo </th>
                            {{-- <th> Image </th> --}}
                            <th> Visibility </th>
                            <th> Status </th>
                            @if(MyHelper::hasAccess([25,27,28], $grantedFeature))
                                <th width="100px;"> Action </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @if (!empty($brand))
                            @foreach($brand as $value)
                            @php
                                $logo = explode('.', $value['logo_brand']);
                                $image = explode('.', $value['image_brand']);
                            @endphp
                                <tr>
                                    <td>{{ $value['code_brand'] }} <input type="hidden" name="order[]" value="{{$value['id_brand']}}"></td>
                                    <td>{{ $value['name_brand'] }} {!! !empty($value['default_brand_status']) ? '<span class="badge badge-primary badge-sm">Default</span>' : ''!!}</td>
                                    @if (empty($value['logo_brand']))
                                        <td>No Logo</td>
                                    @else
                                        <td>Logo Available</td>
                                    @endif
                                    {{-- @if (end($image) == 'jpg' || end($image) == 'png')
                                        <td>Image Available</td>
                                    @else
                                        <td>No Image</td>
                                    @endif --}}
                                    <td><input type="checkbox" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Visible" data-off-color="default" data-id="{{$value['id_brand']}}" data-off-text="Hidden" value="1" @if($value['brand_visibility']??'') checked @endif></td>
                                    <td><input type="checkbox" class="make-switch brand_status" data-size="small" data-on-color="info" data-on-text="Active" data-off-color="default" data-id="{{$value['id_brand']}}" data-off-text="Inactive" value="1" @if($value['brand_active']??'') checked @endif></td>
                                    @if(MyHelper::hasAccess([25,27,28], $grantedFeature))
                                        <td style="width: 90px;">
                                            @if(MyHelper::hasAccess([28], $grantedFeature))
                                                <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_brand'] }}"><i class="fa fa-trash-o"></i></a>
                                            @endif
                                            @if(MyHelper::hasAccess([25,27], $grantedFeature))
                                                <a href="{{ url('brand/detail') }}/{{ $value['id_brand'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="form-group text-center">
                    <input type="hidden" name="data_start" id="data_start" value="0">
                    {{csrf_field()}}
                    <button class="btn green">Update Order</button>
                </div>
            </form>

        </div>
    </div>



@endsection