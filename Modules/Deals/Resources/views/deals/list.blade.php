@include('deals::deals.list_filter')
<?php
use App\Lib\MyHelper;
$configs    		= session('configs');
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main-closed')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
    	.middle-center {
            vertical-align: middle!important;
            text-align: center;
        }
        .middle-left {
            vertical-align: middle!important;
            text-align: left;
        }
        .paginator-right {
            display: flex;
            justify-content: flex-end;
        }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
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
                ordering: false,
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'>>"
        });

        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('deals/delete') }}",
                data : "_token="+token+"&id_deals="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Deals has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete deals.");
                    }
                }
            });
        });
    </script>
    @yield('child-script')
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

    @yield('filter')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{ $sub_title }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Type </th>
                        <th> Title </th>
                        @if(MyHelper::hasAccess([95], $configs))
                        <th> Brand </th>
                        @endif
                        <th> Price </th>
                        @if($deals_type != "Hidden" && $deals_type !='WelcomeVoucher' && $deals_type !='Quest')
                            <th> Date Publish </th>
                            <th> Date Start </th>
                        @endif
                        <th> Status </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                	@php $now = date("Y-m-d H:i:s"); @endphp
                    @if (!empty($deals))
                        @foreach($deals as $key => $value)
	                        @php
	                            if( isset($value['deals_start']) )
	                            {
	                                $date_start = $value['deals_start'];
	                                $date_end = $value['deals_end'];
	                            }
	                        @endphp
                            <tr>
                                <td nowrap>
                                	<ul>
                                		<li>{{ $value['promo_type']??'' }}</li>
                                	</ul>
                            	</td>
                                <td>{{ $value['deals_title'] }}</td>
                                @if(MyHelper::hasAccess([95], $configs))
                                <td nowrap>
                                	<ul style="margin-left: -20px">
                                	@foreach($value['brands'] ?? [] as $brand)
                                		<li>{{ $brand['name_brand'] ?? '' }}</li>
                                	@endforeach
                                	</ul>
                                <td>
                                @endif
                                	@if($value['deals_voucher_price_type'] == 'free')
                                		{{ $value['deals_voucher_price_type'] }}
                                	@elseif(!empty($value['deals_voucher_price_point']))
                                		{{ number_format($value['deals_voucher_price_point']).' Points' }}
                                	@elseif(!empty($value['deals_voucher_price_cash']))
                                		{{ 'IDR'.number_format($value['deals_voucher_price_cash']) }}
                                	@endif
                                </td>

                                @if($deals_type != "Hidden" && $deals_type !='WelcomeVoucher' && $deals_type !='Quest')
                                <td>
                                    @php
                                        $bulan   = date('m', strtotime($value['deals_publish_start']));
                                        $bulanEx = date('m', strtotime($value['deals_publish_end']));
                                    @endphp
                                    @if ($bulan == $bulanEx)
                                        {{ date('d', strtotime($value['deals_publish_start'])) }} - {{ date('d M Y', strtotime($value['deals_publish_end'])) }}
                                    @else
                                        {{ date('d M Y', strtotime($value['deals_publish_start'])) }} - {{ date('d M Y', strtotime($value['deals_publish_end'])) }}
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $bulan   = date('m', strtotime($value['deals_start']));
                                        $bulanEx = date('m', strtotime($value['deals_end']));
                                    @endphp
                                    @if ($bulan == $bulanEx)
                                        {{ date('d', strtotime($value['deals_start'])) }} - {{ date('d M Y', strtotime($value['deals_end'])) }}
                                    @else
                                        {{ date('d M Y', strtotime($value['deals_start'])) }} - {{ date('d M Y', strtotime($value['deals_end'])) }}
                                    @endif
                                </td>
                                @endif
                                <td class="middle-center">
	                                @if ( empty($value['step_complete']) )
	                                    <a href="{{url('deals/step2', $value['id_deals'])??'#'}}"><span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #F4D03F;padding: 5px 12px;color: #fff;">Not Complete</span></a>
	                                @elseif( (!empty($date_end) && $date_end < $now) || (!empty($value['deals_voucher_expired']) && $value['deals_voucher_expired'] < $now))
	                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #ACB5C3;padding: 5px 12px;color: #fff;">Ended</span>
	                                @elseif( empty($date_start) || $date_start <= $now )
	                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Started</span>
	                                @elseif($date_start > $now)
	                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Not Started</span>
	                                @endif
	                            </td>
                                <td style="width: 80px;">
                                    @if($deals_type == "Deals" && MyHelper::hasAccess([76], $grantedFeature) && $value['deals_total_claimed'] == 0)
                                        <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_deals'] }}"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                    @if($deals_type == "Hidden" && MyHelper::hasAccess([81], $grantedFeature) && $value['deals_total_claimed'] == 0)
                                        <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_deals'] }}"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                    @if($deals_type == "Quest" && MyHelper::hasAccess([310], $grantedFeature) && $value['deals_total_claimed'] == 0)
                                        <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_deals'] }}"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                    @if($deals_type == "WelcomeVoucher" && MyHelper::hasAccess([191], $grantedFeature) && $value['deals_total_claimed'] == 0)
                                        <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_deals'] }}"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                    @if ($deals_type == "Deals" && MyHelper::hasAccess([73], $grantedFeature))
                                    <a href="{{ url('deals/detail') }}/{{ $value['id_deals'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    @elseif ($deals_type == "Point" && MyHelper::hasAccess([73], $grantedFeature))
                                    <a href="{{ url('deals-point/detail') }}/{{ $value['id_deals'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    @elseif ($deals_type == "WelcomeVoucher" && MyHelper::hasAccess([188], $grantedFeature))
                                        <a href="{{ url('welcome-voucher/detail') }}/{{ $value['id_deals'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    @elseif ($deals_type == "Quest" && MyHelper::hasAccess([307], $grantedFeature))
                                            <a href="{{ url('quest-voucher/detail') }}/{{ $value['id_deals'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    @else
                                        @if(MyHelper::hasAccess([78], $grantedFeature))
                                            <a href="{{ url('inject-voucher/detail') }}/{{ $value['id_deals'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="paginator-right">
                @if ($dealsPaginator)
                  {{ $dealsPaginator->links() }}
                @endif
            </div>
        </div>
    </div>



@endsection