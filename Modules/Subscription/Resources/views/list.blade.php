@include('subscription::list_filter')
<?php
use App\Lib\MyHelper;
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
                order: [0, "asc"],
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
                url : "{{ url('subscription/delete') }}",
                data : "_token="+token+"&id_subscription="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Subscription has been deleted.");
                    }
                    else {
                    	let messages;
                    	if (result['messages']??false){
                    		messages = result['messages'];
                    	}
                    	else{
                    		messages = "Something went wrong. Failed to delete subscription.";
                    	}
                        toastr.warning(messages);
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

                        <th> No</th>
                        <th> Title </th>
                    @if ($subscription_type == 'subscription')
                        <th> Date Publish </th>
                        <th> Date Start </th>
                        <th> Price </th>
                    @endif
                    	<th> Brand </th>
                        <th> Status </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($subs))
                        @foreach($subs as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value['subscription_title'] }}</td>

                                @if ($subscription_type == 'subscription')
                                <td>
                                    @php
                                        $bulan   = date('m', strtotime($value['subscription_publish_start']));
                                        $bulanEx = date('m', strtotime($value['subscription_publish_end']));
                                    @endphp
                                    @if ($bulan == $bulanEx)
                                        {{ date('d', strtotime($value['subscription_publish_start'])) }} - {{ date('d M Y', strtotime($value['subscription_publish_end'])) }}
                                    @else
                                        {{ date('d M Y', strtotime($value['subscription_publish_start'])) }} - {{ date('d M Y', strtotime($value['subscription_publish_end'])) }}
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $bulan   = date('m', strtotime($value['subscription_start']));
                                        $bulanEx = date('m', strtotime($value['subscription_end']));
                                    @endphp
                                    @if ($bulan == $bulanEx)
                                        {{ date('d', strtotime($value['subscription_start'])) }} - {{ date('d M Y', strtotime($value['subscription_end'])) }}
                                    @else
                                        {{ date('d M Y', strtotime($value['subscription_start'])) }} - {{ date('d M Y', strtotime($value['subscription_end'])) }}
                                    @endif
                                </td>
                                <td>@php
                                        if($value['subscription_price_point']??0)
                                        {
                                            $price = $value['subscription_price_point'].' Points';
                                        }
                                        elseif($value['subscription_price_cash']??0)
                                        {
                                            $price = 'IDR '.$value['subscription_price_cash'];
                                        }
                                        else
                                        {
                                            $price = 'Free';
                                        }
                                        echo $price;
                                    @endphp
                                </td>
                                @endif
                                <td nowrap>
                                	<ul style="margin-left: -20px">
                                	@foreach($value['brands'] ?? [] as $brand)
                                		<li>{{ $brand['name_brand'] ?? '' }}</li>
                                	@endforeach
                                	</ul>
                                <td>
                                <td class="middle-center">
                                	@php
                                		$date_start = $value['subscription_start'];
                                		$date_end 	= $value['subscription_end'];
                                		$now 		= date("Y-m-d H:i:s");
                                	@endphp
                                	@if ( empty($value['subscription_step_complete']) )
	                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #F4D03F;padding: 5px 12px;color: #fff;">Not Complete</span>
	                                @elseif( !empty($date_end) && $date_end < $now )
	                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #ACB5C3;padding: 5px 12px;color: #fff;">Ended</span>
	                                @elseif( empty($date_start) || $date_start <= $now )
	                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Started</span>
	                                @else
	                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Not Started</span>
	                                @endif
	                            </td>
                                <td style="width: 80px;">
                                    @if(MyHelper::hasAccess([176], $grantedFeature) && empty($value['subscription_bought']))
                                        <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_subscription'] }}"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                    @if(MyHelper::hasAccess([174], $grantedFeature))
                                    <a href="{{ url($rpage.'/detail') }}/{{ $value['id_subscription'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>



@endsection