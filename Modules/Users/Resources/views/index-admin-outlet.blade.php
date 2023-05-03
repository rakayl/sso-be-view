<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
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
                order: [1, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('product/delete') }}",
                data : "_token="+token+"&id_product="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Product has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete discount.");
                    }
                }
            });
        });

        $('#sample_1').on('switchChange.bootstrapSwitch', '.changeStatus', function(event, state) {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');
            var nama     = $(this).data('nama');

            if (state) {
              var change = "Visible";
            }
            else {
              var change = "Hidden";
            }

            $.ajax({
                type : "POST",
                url : "{{ url('product/update') }}",
                data : "_token="+token+"&id_product="+id+"&product_visibility="+change,
                success : function(result) {
                    if (result == "success") {
                        toastr.info("Product "+ nama +" has been updated.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to update data product.");
                    }
                }
            });
        });

        $('#sample_1').on('draw.dt', function() {
            $(".changeStatus").bootstrapSwitch();
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
                <span class="caption-subject font-blue sbold uppercase">Admin Outlet List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th>No</th>
						<th class="noExport">Actions</th>
						<th>Name</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Outlet&nbsp;Name</th>
                        {{-- cek config enquiry dulu baru cek admin enquiry --}}
                        @if(MyHelper::hasAccess([56], $configs))
                          @if(MyHelper::hasAccess([9], $configs))
                              <th>Enquiry</th>
                          @endif
                      @endif
                      {{-- cek config pickup order dulu baru cek admin pickup--}}
                      @if(MyHelper::hasAccess([12], $configs))
                          @if(MyHelper::hasAccess([6], $configs))
                              <th style="white-space: inherit;">Pickup&nbsp;Order</th>
                          @endif
                      @endif
                      {{-- cek config delivery order dulu baru cek admin delivery --}}
                      @if(MyHelper::hasAccess([13,15], $configs))
                          @if(MyHelper::hasAccess([7], $configs))
                              <th>Delivery</th>
                          @endif
                      @endif
                      {{-- cek config manual payment dulu baru cek admin finance --}}
                      @if(MyHelper::hasAccess([17], $configs))
                          @if(MyHelper::hasAccess([8], $configs))
                              <th>Payment</th>
                          @endif
                      @endif
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($result))
                        @foreach($result as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td class="noExport">
									@if(MyHelper::hasAccess([2], $grantedFeature))
									<a class="btn btn-block yellow btn-xs" href="{{ url('user/adminoutlet')}}/{{$value['phone']}}"><i class="icon-pencil"></i> Update </a>
									@endif
									@if(MyHelper::hasAccess([5], $grantedFeature))
										<a class="btn btn-block red btn-xs" href="{{ url('user/adminoutlet/delete')}}/{{$value['phone']}}/{{$value['id_outlet']}}" data-toggle="confirmation" data-placement="top"><i class="icon-close"></i> Delete </a>
									@endif
								</td>
                                <td>{{ $value['name'] }}</td>
                                <td>{{ $value['phone'] }}</td>
                                <td>{{ $value['email'] }}</td>
                                <td>
                                    <ul style="padding:10px">
                                        @foreach($value['outlets'] as $outlet)
                                        <li>{{$outlet['outlet_name']}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                {{-- cek config enquiry dulu baru cek admin enquiry --}}
                                @if(MyHelper::hasAccess([56], $configs))
                                    @if(MyHelper::hasAccess([9], $configs))
                                        <td>@if($value['enquiry'] == 1)Yes @else No @endif</td>
                                    @endif
                                @endif
                                {{-- cek config pickup order dulu baru cek admin pickup--}}
                                @if(MyHelper::hasAccess([12], $configs))
                                    @if(MyHelper::hasAccess([6], $configs))
                                        <td>@if($value['pickup_order'] == 1)Yes @else No @endif</td>
                                    @endif
                                @endif
                                {{-- cek config delivery order dulu baru cek admin delivery --}}
                                @if(MyHelper::hasAccess([13,15], $configs))
                                    @if(MyHelper::hasAccess([7], $configs))
                                        <td>@if($value['delivery'] == 1)Yes @else No @endif</td>
                                    @endif
                                @endif
                                {{-- cek config manual payment dulu baru cek admin finance --}}
                                @if(MyHelper::hasAccess([17], $configs))
                                    @if(MyHelper::hasAccess([8], $configs))
                                        <td>@if($value['payment'] == 1)Yes @else No @endif</td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>



@endsection